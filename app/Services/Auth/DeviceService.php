<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class DeviceService
{
    protected Agent $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

    public function info(Request $request): array
    {
        return [

            'ip_address' => $this->ip($request),

            'user_agent' => $this->userAgent($request),

            'browser' => $this->browser(),

            'browser_version' => $this->browserVersion(),

            'platform' => $this->platform(),

            'platform_version' => $this->platformVersion(),

            'device' => $this->device(),

            'is_mobile' => $this->agent->isMobile(),

            'is_tablet' => $this->agent->isTablet(),

            'is_desktop' => $this->agent->isDesktop(),

            'is_robot' => $this->agent->isRobot(),

        ];
    }

    public function ip(Request $request): string
    {
        return $request->ip();
    }

    public function userAgent(Request $request): ?string
    {
        return $request->userAgent();
    }

    public function browser(): string
    {
        return $this->agent->browser() ?: 'Unknown';
    }

    public function browserVersion(): ?string
    {
        return $this->agent->version(
            $this->agent->browser()
        );
    }

    public function platform(): string
    {
        return $this->agent->platform() ?: 'Unknown';
    }

    public function platformVersion(): ?string
    {
        return $this->agent->version(
            $this->agent->platform()
        );
    }

    public function device(): string
    {
        if ($this->agent->isDesktop()) {
            return 'Desktop';
        }

        if ($this->agent->isTablet()) {
            return 'Tablet';
        }

        if ($this->agent->isMobile()) {
            return 'Mobile';
        }

        if ($this->agent->isRobot()) {
            return 'Robot';
        }

        return 'Unknown';
    }

    public function deviceName(): ?string
    {
        return $this->agent->device();
    }

    public function fingerprint(Request $request): string
    {
        return hash(
            'sha256',
            implode('|', [
                $this->ip($request),
                $this->userAgent($request),
                $this->platform(),
                $this->browser(),
            ])
        );
    }
}
