<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketCache extends Model
{
    protected $table = 'market_cache';
    protected $primaryKey = 'symbol';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'symbol',
        'value',
        'unit',
        'change_value',
        'change_percent',
        'direction',
        'yesterday_price',
        'today_open_price',
        'price_date',
        'is_stale',
        'fetched_at',
    ];

    protected $casts = [
        'value'            => 'float',
        'change_value'     => 'float',
        'change_percent'   => 'float',
        'yesterday_price'  => 'float',
        'today_open_price' => 'float',
        'is_stale'         => 'boolean',
        'fetched_at'       => 'datetime',
        'price_date'       => 'date',
    ];
}