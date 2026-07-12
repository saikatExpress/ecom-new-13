<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'group_name',
        'setting_key',
        'label',
        'value',
        'type',
        'description',
        'autoload'
    ];

    public function setValueAttribute($value): void
    {
        $this->attributes['value'] = json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function getValueAttribute($value): mixed
    {
        return json_decode($value, true);
    }

    protected $casts = [
        'autoload' => 'boolean'
    ];
}
