<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiSourceConfig extends Model
{
    protected $table = 'api_source_config';
    protected $fillable = [
        'key',
        'label',
        'base_url',
        'fallback_urls',
        'auth_token',
        'interval_seconds',
        'is_active',
        'last_status',
        'last_latency_ms',
        'last_checked_at',
        'last_error',
    ];
    protected $casts = [
        'fallback_urls' => 'array',
        'is_active' => 'boolean',
        'last_checked_at' => 'datetime',
    ];
}
