<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisplaySetting extends Model
{
    protected $table = 'display_settings';
    protected $fillable = [
        'user_id',
        'theme_mode',
        'slider_interval_sec',
        'show_weight',
        'show_labor',
        'show_profit',
        'shop_name',
        'phone',
        'instagram',
        'rubika',
        'qr_link',
        'qr_label',
        'qr_desc',
        'published_at',
    ];
    protected $casts = [
        'show_weight' => 'boolean',
        'show_labor' => 'boolean',
        'show_profit' => 'boolean',
        'published_at' => 'datetime',
    ];
}
