<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_log';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false; // فقط created_at داریم
    protected $fillable = [
        'id',
        'actor',
        'action',
        'entity_type',
        'entity_id',
        'payload',
        'created_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'created_at' => 'datetime',
    ];
}
