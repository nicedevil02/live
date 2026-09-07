<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSlide extends Model
{
    protected $table = 'product_slide';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'weight_gram',
        'labor_fee',
        'profit_value',
        'profit_type',
        'base_gold_price',
        'final_price',
        'is_visible',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id')->orderBy('sort_order');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
