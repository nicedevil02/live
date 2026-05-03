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
        'is_stale',
        'fetched_at',
    ];

    protected $casts = [
        'is_stale'   => 'boolean',
        'fetched_at' => 'datetime',
    ];
}