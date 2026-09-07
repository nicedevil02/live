<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisplayItem extends Model
{
    protected $table = 'display_items';
    protected $fillable = [
        'user_id',
        'key',
        'label',
        'enabled',
        'order',
    ];
    protected $casts = [
        'enabled' => 'boolean',
    ];
}
