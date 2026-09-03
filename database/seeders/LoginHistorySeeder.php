<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\LoginHistory;
use Illuminate\Database\Seeder;

class LoginHistorySeeder extends Seeder
{
    public function run(): void
    {
        $users = User::query()->get();

        if ($users->isEmpty()) {
            return;
        }

        foreach ($users as $user) {

            $loginAt = Carbon::now()->subDays(rand(1, 30))->subHours(rand(1, 20))->subMinutes(rand(1, 59));

            LoginHistory::create([
                'user_id'          => $user->id,
                'phone_number'     => $user->phone_number,
                'ip_address'       => '103.120.' . rand(10, 99) . '.' . rand(10, 99),
                'user_agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/140.0.0.0 Safari/537.36',
                'browser'          => 'Chrome',
                'browser_version'  => '140',
                'platform'         => 'Windows',
                'platform_version' => '11',
                'device'           => 'Desktop',
                'success'          => true,
                'failure_reason'   => null,
                'login_at'         => $loginAt,
                'logout_at'        => (clone $loginAt)->addMinutes(rand(10, 180)),
            ]);

            $loginAt = Carbon::now()->subDays(rand(1, 25))->subHours(rand(1, 20))->subMinutes(rand(1, 59));

            LoginHistory::create([
                'user_id'          => $user->id,
                'phone_number'     => $user->phone_number,
                'ip_address'       => '103.121.' . rand(10, 99) . '.' . rand(10, 99),
                'user_agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/140.0.0.0 Safari/537.36',
                'browser'          => 'Chrome',
                'browser_version'  => '140',
                'platform'         => 'Windows',
                'platform_version' => '11',
                'device'           => 'Desktop',
                'success'          => false,
                'failure_reason'   => 'Invalid password',
                'login_at'         => $loginAt,
                'logout_at'        => null,
            ]);

            $loginAt = Carbon::now()->subDays(rand(1, 20))->subHours(rand(1, 20))->subMinutes(rand(1, 59));

            LoginHistory::create([
                'user_id'          => $user->id,
                'phone_number'     => $user->phone_number,
                'ip_address'       => '103.122.' . rand(10, 99) . '.' . rand(10, 99),
                'user_agent'       => 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0',
                'browser'          => 'Firefox',
                'browser_version'  => '142',
                'platform'         => 'Linux',
                'platform_version' => null,
                'device'           => 'Desktop',
                'success'          => true,
                'failure_reason'   => null,
                'login_at'         => $loginAt,
                'logout_at'        => (clone $loginAt)->addMinutes(rand(10, 150)),
            ]);

            $loginAt = Carbon::now()->subDays(rand(1, 15))->subHours(rand(1, 20))->subMinutes(rand(1, 59));

            LoginHistory::create([
                'user_id'          => $user->id,
                'phone_number'     => $user->phone_number,
                'ip_address'       => '103.123.' . rand(10, 99) . '.' . rand(10, 99),
                'user_agent'       => 'Mozilla/5.0 (Linux; Android 15) AppleWebKit/537.36 Chrome/140.0.0.0 Mobile Safari/537.36',
                'browser'          => 'Chrome Mobile',
                'browser_version'  => '140',
                'platform'         => 'Android',
                'platform_version' => '15',
                'device'           => 'Mobile',
                'success'          => true,
                'failure_reason'   => null,
                'login_at'         => $loginAt,
                'logout_at'        => (clone $loginAt)->addMinutes(rand(5, 90)),
            ]);

            $loginAt = Carbon::now()->subDays(rand(1, 10))->subHours(rand(1, 20))->subMinutes(rand(1, 59));

            LoginHistory::create([
                'user_id'          => $user->id,
                'phone_number'     => $user->phone_number,
                'ip_address'       => '103.124.' . rand(10, 99) . '.' . rand(10, 99),
                'user_agent'       => 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_0 like Mac OS X) AppleWebKit/605.1.15 Version/18.0 Mobile Safari/604.1',
                'browser'          => 'Safari',
                'browser_version'  => '18',
                'platform'         => 'iOS',
                'platform_version' => '18',
                'device'           => 'iPhone',
                'success'          => false,
                'failure_reason'   => 'Too many failed login attempts',
                'login_at'         => $loginAt,
                'logout_at'        => null,
            ]);
        }
    }
}
