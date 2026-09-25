<?php

namespace App\Services\Setting;

use App\Exceptions\CustomException;
use App\Helpers\File\FileUploadHelper;
use App\Helpers\File\FileUrlHelper;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingService
{
    public function __construct(protected Setting $model){}

    public function index($request)
    {
        $groupName    = $request->input('group_name');
        $searchKey    = $request->input('search_key');

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
        ->map(function ($setting) {
            if ($setting->type === 'image' && !empty($setting->value)) {
                $setting->value = FileUrlHelper::url($setting->value);
            }
            return $setting;
        })
        ->groupBy('group_name');

        return $settings;
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {

            $existingSetting = $this->model->where('group_name', $request->group_name)->where('setting_key', $request->setting_key)->first();

            if ($existingSetting) {
                throw new CustomException('Setting key already exists in this group.');
            }

            $setting = new $this->model();

            $setting->group_name  = $request->group_name;
            $setting->setting_key = $request->setting_key;
            $setting->label       = $request->label;
            $setting->type        = $request->type;
            $setting->autoload    = $request->input('autoload', true);

            if ($request->type === 'image') {
                if (!$request->hasFile('value')) {
                    throw new CustomException('Image file is required.');
                }

                $setting->value = FileUploadHelper::upload($request->file('value'),'settings');
            } else {
                $setting->value = $request->input('value');
            }

            $setting->save();

            return $setting;
        });
    }

    public function show($id)
    {
        $setting = $this->model->find($id);

        if (!$setting) {
            throw new CustomException('Setting Not Found');
        }

        return $setting;
    }

    public function update($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {

            $setting = $this->model->lockForUpdate()->find($id);

            if (!$setting) {
                throw new CustomException('Setting Not Found');
            }

            $duplicate = $this->model->where('group_name', $request->group_name)->where('setting_key', $request->setting_key)->where('id', '!=', $setting->id)->exists();

            if ($duplicate) {
                throw new CustomException('Setting key already exists in this group.');
            }

            $setting->group_name  = $request->group_name;
            $setting->setting_key = $request->setting_key;
            $setting->label       = $request->label;
            $setting->type        = $request->type;
            $setting->autoload    = $request->input('autoload',$setting->autoload);

            if ($request->type === 'image') {

                if ($request->hasFile('value')) {

                    $setting->value = FileUploadHelper::replace($request->file('value'), $setting->value, 'settings');
                }

            } else {

                $setting->value = $request->input('value');
            }

            $setting->save();

            return $setting->fresh();
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {

            $setting = $this->model->find($id);

            if (!$setting) {
                throw new CustomException('Setting Not Found');
            }

            $setting->delete();

            return true;
        });
    }
}
