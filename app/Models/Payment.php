<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'invoice_no',
        'user_id',
        'plan_id',
        'coupon_id',
        'amount',
        'discount_amount',
        'gateway',
        'transaction_id',
        'reference_id',
        'card_pan',
        'status',
        'paid_at',
        'ip_address',
        'description',
        'metadata',
    ];

    protected $casts = [
        'amount'          => 'integer',
        'discount_amount' => 'integer',
        'paid_at'         => 'datetime',
        'metadata'        => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount);
    }

    public function getFormattedDiscountAttribute(): string
    {
        return number_format($this->discount_amount);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'paid'     => 'پرداخت موفق',
            'pending'  => 'در انتظار پرداخت',
            'failed'   => 'ناموفق',
            'canceled' => 'انصراف کاربر',
            default    => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'paid'     => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800',
            'pending'  => 'bg-amber-100 text-amber-800 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-300 dark:border-amber-800',
            'failed'   => 'bg-rose-100 text-rose-800 dark:bg-rose-950/40 dark:text-rose-300 border border-rose-300 dark:border-rose-800',
            'canceled' => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-300 border border-slate-300 dark:border-slate-700',
            default    => 'bg-slate-100 text-slate-800',
        };
    }

    public function getGatewayNameAttribute(): string
    {
        return match($this->gateway) {
            'zarinpal' => 'زرین‌پال',
            'zibal'    => 'زیبال',
            'manual'   => 'کارت‌به‌کارت / دستی',
            default    => $this->gateway,
        };
    }

    public function getAuthorityAttribute(): ?string
    {
        return $this->transaction_id;
    }

    /**
     * تولید شماره فاکتور یکتای استاندارد
     */
    public static function generateInvoiceNo(): string
    {
        $prefix = 'TL';
        $datePart = date('ymd');
        $random = rand(1000, 9999);
        $candidate = "{$prefix}-{$datePart}-{$random}";

        while (self::where('invoice_no', $candidate)->exists()) {
            $random = rand(1000, 9999);
            $candidate = "{$prefix}-{$datePart}-{$random}";
        }

        return $candidate;
    }
}
