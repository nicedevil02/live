<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'title',
        'type',
        'value',
        'min_amount',
        'max_discount',
        'usage_limit',
        'used_count',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'value'        => 'integer',
        'min_amount'   => 'integer',
        'max_discount' => 'integer',
        'usage_limit'  => 'integer',
        'used_count'   => 'integer',
        'expires_at'   => 'datetime',
        'is_active'    => 'boolean',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'coupon_id');
    }

    /**
     * بررسی معتبر بودن کد تخفیف
     */
    public function isValidForAmount(int $amount): array
    {
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'این کد تخفیف غیرفعال است.'];
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return ['valid' => false, 'message' => 'مهلت استفاده از این کد تخفیف به پایان رسیده است.'];
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'ظرفیت استفاده از این کد تخفیف تکمیل شده است.'];
        }

        if ($this->min_amount && $amount < $this->min_amount) {
            $minFormatted = number_format($this->min_amount);
            return ['valid' => false, 'message' => "این کد تخفیف برای سفارش‌های بالای {$minFormatted} تومان معتبر است."];
        }

        return ['valid' => true, 'message' => 'کد تخفیف معتبر است.'];
    }

    /**
     * محاسبه مبلغ تخفیف برای یک سبد خرید مشخص
     */
    public function calculateDiscount(int $amount): int
    {
        if ($this->type === 'percent') {
            $discount = (int) round(($amount * $this->value) / 100);
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
            return min($discount, $amount);
        }

        // fixed
        return min($this->value, $amount);
    }
}
