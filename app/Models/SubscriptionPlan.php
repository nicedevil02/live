<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'duration_days',
        'price',
        'original_price',
        'features',
        'badge_text',
        'is_popular',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'duration_days' => 'integer',
        'price'          => 'integer',
        'original_price' => 'integer',
        'features'       => 'array',
        'is_popular'     => 'boolean',
        'is_active'      => 'boolean',
        'sort_order'     => 'integer',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'plan_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc');
    }

    /**
     * محاسبه مبلغ ماهانه معادل جهت مقایسه و بازارگرم‌کنی
     */
    public function getMonthlyEquivalentPriceAttribute(): int
    {
        if ($this->duration_days <= 0) return $this->price;
        $months = max(1, round($this->duration_days / 30));
        return (int) round($this->price / $months);
    }

    /**
     * درصد تخفیف واقعی نسبت به قیمت پایه
     */
    public function getDiscountPercentAttribute(): int
    {
        if (!$this->original_price || $this->original_price <= $this->price) return 0;
        return (int) round((($this->original_price - $this->price) / $this->original_price) * 100);
    }

    /**
     * قیمت فرمت‌شده به تومان
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price);
    }

    /**
     * قیمت خط خورده فرمت‌شده به تومان
     */
    public function getFormattedOriginalPriceAttribute(): ?string
    {
        return $this->original_price ? number_format($this->original_price) : null;
    }
}
