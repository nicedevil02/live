<?php

namespace App\Services\Payment;

use App\Models\Coupon;
use App\Models\User;

class CouponService
{
    /**
     * اعتبارسنجی و محاسبه تخفیف
     */
    public function applyCoupon(string $code, int $amount, ?User $user = null): array
    {
        $code = trim(strtoupper($code));
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return [
                'success' => false,
                'message' => 'کد تخفیف وارد شده معتبر نمی‌باشد.',
            ];
        }

        // بررسی محدودیت اختصاصی کد تخفیف افتتاحیه ۷۲ ساعت اول ثبت‌نام
        if ($code === 'WELCOME72' || $code === 'WELCOME48') {
            if (!$user || !$user->isEligibleForWelcomeOffer()) {
                return [
                    'success' => false,
                    'message' => 'مهلت استفاده از تخفیف ویژه ۷۲ ساعت اول ثبت‌نام برای این حساب به پایان رسیده است.',
                ];
            }
        }

        $check = $coupon->isValidForAmount($amount);
        if (!$check['valid']) {
            return [
                'success' => false,
                'message' => $check['message'],
            ];
        }

        $discount = $coupon->calculateDiscount($amount);
        $finalAmount = max(0, $amount - $discount);

        return [
            'success'          => true,
            'coupon'           => $coupon,
            'code'             => $coupon->code,
            'title'            => $coupon->title,
            'discount_amount'  => $discount,
            'final_amount'     => $finalAmount,
            'formatted_discount' => number_format($discount) . ' تومان',
            'formatted_final'    => number_format($finalAmount) . ' تومان',
            'message'          => 'کد تخفیف با موفقیت اعمال گردید.',
        ];
    }
}
