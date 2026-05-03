<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormulaConfig extends Model
{
    protected $table = 'formula_config';
    protected $fillable = [
        'buy_multiplier_a',
        'buy_divisor_b',
    ];
    public $timestamps = true;
}
