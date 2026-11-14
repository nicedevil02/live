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
        'show_weather',
        'show_weather_bg',
        'shop_name',
        'phone',
        'instagram',
        'rubika',
        'qr_link',
        'qr_label',
        'qr_desc',
        'empty_showcase_mode',
        'empty_showcase_title',
        'empty_showcase_text',
        'empty_showcase_theme',
        'hide_showcase',
        'auto_theme_enabled',
        'day_theme_mode',
        'night_theme_mode',
        'day_start_time',
        'night_start_time',
        'footer_ticker_text',
        'published_at',
    ];
    protected $casts = [
        'show_weight' => 'boolean',
        'show_labor' => 'boolean',
        'show_profit' => 'boolean',
        'show_weather' => 'boolean',
        'show_weather_bg' => 'boolean',
        'hide_showcase' => 'boolean',
        'auto_theme_enabled' => 'boolean',
        'published_at' => 'datetime',
    ];
}
