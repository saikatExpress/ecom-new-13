<?php

namespace App\Services\Setting;

use App\Models\Setting;

class SettingService
{
    public function __construct(protected Setting $model){}

    public function index($request)
    {
        $groupName = $request->input('group_name');
        $searchKey = $request->input('search_key');

        $settings = $this->model
        ->when($groupName, function ($query) use ($groupName) {
            $query->where('group_name', $groupName);
        })
        ->when($searchKey, function ($query) use ($searchKey) {
            $query->where(function ($query) use ($searchKey) {
                $query->where('setting_key', 'like', "%{$searchKey}%")
                    ->orWhere('label', 'like', "%{$searchKey}%");
            });
        })
        ->orderBy('group_name')
        ->orderBy('id')
        ->get()
        ->groupBy('group_name');

        return $settings;
    }
}
