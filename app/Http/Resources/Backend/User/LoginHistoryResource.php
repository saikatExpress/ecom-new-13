<?php

namespace App\Http\Resources\Backend\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'user_id'          => $this->user_id,
            'phone_number'     => $this->phone_number,
            'ip_address'       => $this->ip_address,
            'user_agent'       => $this->user_agent,
            'browser'          => $this->browser,
            'platform'         => $this->platform,
            'platform_version' => $this->platform_version,
            'device'           => $this->device,
            'success'          => $this->success,
            'failure_reason'   => $this->failure_reason,
            'login_at'         => $this->login_at,
            'logout_at'        => $this->logout_at,
        ];
    }
}
