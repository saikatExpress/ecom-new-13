<?php

namespace App\Services\Order;

use App\Enums\StatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Order\OrderGuardLog;
use App\Exceptions\CustomException;
use App\Models\Order\OrderGuardBlock;
use App\Models\Order\OrderGuardSetting;
use App\Models\Order\OrderGuardOrderDetail;

class OrderGuardService
{
    public function check(Request $request): array
    {
        $context = $this->getRequestContext($request);

        $setting = OrderGuardSetting::query()->where('status', StatusEnum::ACTIVE->value)->first();

        if (!$setting) {
            return $context;
        }

        $identifiers = [
            'phone'      => $context['phone_hash'],
            'ip'         => $context['ip_address'],
            'user_token' => $context['user_token'],
        ];

        foreach ($identifiers as $type => $value) {
            if (!$value) {
                continue;
            }

            $block = $this->findActiveBlock($type, $value);

            if ($block) {
                $this->recordLog(
                    context: $context,
                    action: 'blocked',
                    reason: $block->reason ?? 'already_blocked'
                );

                throw new CustomException($setting->block_message ?: 'Your ordering activity has been restricted.');
            }
        }

        $rules = [
            [
                'type'         => 'phone',
                'column'       => 'phone_hash',
                'value'        => $context['phone_hash'],
                'limit'        => $setting->phone_order_limit,
                'period_value' => $setting->phone_order_period_value,
                'period_unit'  => $setting->phone_order_period_unit,
                'reason'       => 'phone_order_limit_exceeded',
            ],
            [
                'type'         => 'ip',
                'column'       => 'ip_address',
                'value'        => $context['ip_address'],
                'limit'        => $setting->ip_order_limit,
                'period_value' => $setting->ip_order_period_value,
                'period_unit'  => $setting->ip_order_period_unit,
                'reason'       => 'ip_order_limit_exceeded',
            ],
            [
                'type'         => 'user_token',
                'column'       => 'user_token',
                'value'        => $context['user_token'],
                'limit'        => $setting->user_token_order_limit,
                'period_value' => $setting->user_token_order_period_value,
                'period_unit'  => $setting->user_token_order_period_unit,
                'reason'       => 'user_token_order_limit_exceeded',
            ],
        ];

        foreach ($rules as $rule) {
            if (!$rule['value']) {
                continue;
            }

            $from = $this->getPeriodStart($rule['period_value'],$rule['period_unit']);

            $orderCount = OrderGuardOrderDetail::query()
            ->where($rule['column'], $rule['value'])
            ->where('created_at', '>=', $from)
            ->count();

            if ($orderCount >= $rule['limit']) {

                $this->handleViolation(
                    context: $context,
                    rule: $rule,
                    from: $from,
                    setting: $setting
                );

                throw new CustomException(
                    $setting->block_message ?: 'Too many order attempts. Please try again later.'
                );
            }
        }

        return $context;
    }

    private function getRequestContext(Request $request): array
    {
        $phone = $this->normalizePhone($request->input('phone_number'));

        return [
            'phone_number' => $phone,
            'phone_hash'   => hash('sha256', $phone),
            'user_token'   => $request->input('user_token'),
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
        ];
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D+/', '', $phone);

        // Local format: 017XXXXXXXX
        if (preg_match('/^01[3-9]\d{8}$/', $phone)) {
            return '88' . $phone;
        }

        // International format: 88017XXXXXXXX
        if (preg_match('/^8801[3-9]\d{8}$/', $phone)) {
            return $phone;
        }

        throw new CustomException('Invalid Bangladesh mobile number.');
    }

    private function findActiveBlock(string $type,string $value): ?OrderGuardBlock
    {

        OrderGuardBlock::query()
        ->where('type', $type)
        ->where('value', $value)
        ->where('is_active', true)
        ->where('block_type', 'temporary')
        ->whereNotNull('expires_at')
        ->where('expires_at', '<=', now())
        ->update([
            'is_active' => false,
        ]);

        return OrderGuardBlock::query()
        ->where('type', $type)
        ->where('value', $value)
        ->where('is_active', true)
        ->where(function ($query) {
            $query->where('block_type', 'permanent')
            ->orWhere(function ($query) {
                $query->where('block_type', 'temporary')->where('expires_at', '>', now());
            });
        })
        ->first();
    }

    private function getPeriodStart(int $value,string $unit): Carbon
    {
        return match ($unit) {
            'minute' => now()->subMinutes($value),
            'hour'   => now()->subHours($value),
            'day'    => now()->subDays($value),
            'week'   => now()->subWeeks($value),
            default  => now()->subDay(),
        };
    }

    private function handleViolation(array $context,array $rule,Carbon $from,OrderGuardSetting $setting): void
    {

        DB::transaction(function () use ($context,$rule,$from,$setting) {

            $violationQuery = OrderGuardLog::query()
            ->where('action', 'violated')
            ->where('reason', $rule['reason'])
            ->where('created_at', '>=', $from);

            $this->applyIdentifier($violationQuery,$rule['type'],$rule['value']);

            $violationCount = $violationQuery->count() + 1;

            $this->recordLog(
                context: $context,
                action: 'violated',
                reason: $rule['reason'],
                violationCount: $violationCount
            );

            if (!$setting->auto_block_enabled || !$setting->block_after_attempts || $violationCount < $setting->block_after_attempts) {
                return;
            }

            $this->createAutomaticBlock(
                type       : $rule['type'],
                value      : $rule['value'],
                reason     : $rule['reason'],
                phoneNumber: $context['phone_number'],
                setting    : $setting
            );

            $this->recordLog(
                context       : $context,
                action        : 'blocked',
                reason        : 'auto_block_created',
                violationCount: $violationCount
            );
        });
    }
    private function applyIdentifier($query,string $type,string $value): void
    {
        $column = match ($type) {
            'phone'      => 'phone_hash',
            'ip'         => 'ip_address',
            'user_token' => 'user_token',
        };

        $query->where($column, $value);
    }

    private function createAutomaticBlock(string $type,string $value,string $reason,?string $phoneNumber,OrderGuardSetting $setting): void
    {

        $hasDuration = $setting->block_duration_value && $setting->block_duration_unit;

        $expiresAt = null;

        if ($hasDuration) {
            $expiresAt = $this->addDuration(now(),$setting->block_duration_value,$setting->block_duration_unit);
        }

        OrderGuardBlock::create([
            'type'         => $type,
            'value'        => $value,
            'phone_number' => $type === 'phone' ? $phoneNumber : null,
            'reason'       => $reason,
            'block_type'   => $hasDuration ? 'temporary' : 'permanent',
            'source'       => 'system',
            'expires_at'   => $expiresAt,
            'is_active'    => true,
        ]);
    }

    private function addDuration(Carbon $date,int $value,string $unit): Carbon {
        return match ($unit) {
            'minute' => $date->copy()->addMinutes($value),
            'hour'   => $date->copy()->addHours($value),
            'day'    => $date->copy()->addDays($value),
            'week'   => $date->copy()->addWeeks($value),
            default  => $date->copy()->addDay(),
        };
    }

    private function recordLog(array $context,string $action,?string $reason = null,int $violationCount = 0,?int $orderId = null): void
    {
        OrderGuardLog::create([
            'order_id'        => $orderId,
            'phone_hash'      => $context['phone_hash'],
            'user_token'      => $context['user_token'],
            'ip_address'      => $context['ip_address'],
            'action'          => $action,
            'reason'          => $reason,
            'violation_count' => $violationCount,
        ]);
    }

    public function recordAllowed(array $context,int $orderId): void {
        $this->recordLog(
            context: $context,
            action : 'allowed',
            orderId: $orderId
        );
    }
}
