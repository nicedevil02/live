<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisplaySetting extends Model
{
    protected $table = 'display_settings';
    protected $fillable = [
        'theme_mode',
        'slider_interval_sec',
        'show_weight',
        'show_labor',
        'show_profit',
        'shop_name',
        'phone',
        'instagram',
        'rubika',
        'published_at',
    ];
    protected $casts = [
        'show_weight' => 'boolean',
        'show_labor' => 'boolean',
        'show_profit' => 'boolean',
        'published_at' => 'datetime',
    ];
}
