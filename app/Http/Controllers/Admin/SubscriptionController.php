<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Services\Payment\CouponService;
use App\Services\Payment\PaymentService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    /**
     * نمایش پرتال مدیریت اشتراک، انتخاب پکیج و سوابق پرداخت
     */
    public function index()
    {
        $user = Auth::user();
        $plans = SubscriptionPlan::active()->get();
        $payments = $user->payments()->with(['plan', 'coupon'])->paginate(10);
        
        $daysRemaining = $user->trialDaysRemaining();
        $isSubscribed = $user->isSubscribed();
        $jalaliExpiry = User::toJalali($user->expires_at, false);

        return view('admin.subscription.index', compact('user', 'plans', 'payments', 'daysRemaining', 'isSubscribed', 'jalaliExpiry'));
    }

    /**
     * اعتبارسنجی ایجکس کد تخفیف
     */
    public function applyCoupon(Request $request, CouponService $couponService)
    {
        $request->validate([
            'code'    => ['required', 'string'],
            'plan_id' => ['required', 'exists:subscription_plans,id'],
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $result = $couponService->applyCoupon($request->code, $plan->price);

        return response()->json($result);
    }

    /**
     * صدور فاکتور موقت و هدایت امن به درگاه پرداخت
     */
    public function checkout(Request $request, PaymentService $paymentService, CouponService $couponService)
    {
        $request->validate([
            'plan_id'     => ['required', 'exists:subscription_plans,id'],
            'gateway'     => ['required', 'in:zarinpal,zibal'],
            'coupon_code' => ['nullable', 'string'],
        ], [
            'plan_id.required' => 'لطفاً پلن مورد نظر خود را انتخاب فرمایید.',
            'gateway.required' => 'لطفاً درگاه پرداخت را مشخص نمایید.',
        ]);

        $user = Auth::user();
        $plan = SubscriptionPlan::where('is_active', true)->findOrFail($request->plan_id);
        $gateway = $request->input('gateway', 'zarinpal');

        $baseAmount = (int) $plan->price;
        $discountAmount = 0;
        $couponId = null;

        // بررسی کد تخفیف در صورت ارسال
        if ($request->filled('coupon_code')) {
            $couponResult = $couponService->applyCoupon($request->coupon_code, $baseAmount);
            if ($couponResult['success']) {
                $discountAmount = $couponResult['discount_amount'];
                $couponId = $couponResult['coupon']->id;
            }
        }

        $finalAmount = max(1000, $baseAmount - $discountAmount); // حداقل ۱۰۰۰ تومان طبق قوانین شاپرک

        // ایجاد تراکنش مالی جدید با وضعیت در انتظار (pending)
        $payment = Payment::create([
            'invoice_no'      => Payment::generateInvoiceNo(),
            'user_id'         => $user->id,
            'plan_id'         => $plan->id,
            'coupon_id'       => $couponId,
            'amount'          => $finalAmount,
            'discount_amount' => $discountAmount,
            'gateway'         => $gateway,
            'status'          => 'pending',
            'ip_address'      => $request->ip(),
            'description'     => "خرید {$plan->name} توسط {$user->name}",
        ]);

        $callbackUrl = route('admin.subscription.callback', ['gateway' => $gateway, 'invoice' => $payment->invoice_no]);
        $gatewayResponse = $paymentService->requestPayment($payment, $gateway, $callbackUrl);

        if (!$gatewayResponse['success']) {
            $payment->update(['status' => 'failed', 'description' => $gatewayResponse['message']]);
            return back()->with('error', $gatewayResponse['message'] ?? 'خطا در برقراری ارتباط با درگاه پرداخت.');
        }

        return redirect()->away($gatewayResponse['redirect_url']);
    }

    /**
     * مدیریت بازگشت از درگاه پرداخت و فعال‌سازی اشتراک
     */
    public function callback(Request $request, string $gateway, PaymentService $paymentService, SmsService $smsService)
    {
        // یافتن تراکنش مرتبط بر اساس Authority، TrackId یا پارامتر فاکتور
        $authority = $request->input('Authority');
        $trackId   = $request->input('trackId');
        $invoiceNo = $request->input('invoice');

        $payment = null;
        if ($authority) {
            $payment = Payment::where('transaction_id', $authority)->first();
        }
        if (!$payment && $trackId) {
            $payment = Payment::where('transaction_id', $trackId)->first();
        }
        if (!$payment && $invoiceNo) {
            $payment = Payment::where('invoice_no', $invoiceNo)->first();
        }

        if (!$payment) {
            return redirect()->route('admin.subscription.index')
                ->with('error', 'اطلاعات تراکنش یافت نشد یا درخواست معتبر نمی‌باشد.');
        }

        // بررسی Idempotency و قفل رکورد با تراکنش دیتابیس
        return DB::transaction(function () use ($payment, $request, $gateway, $paymentService, $smsService) {
            $lockedPayment = Payment::where('id', $payment->id)->lockForUpdate()->first();

            // اگر قبلاً تأیید و پرداخت شده است، مستقیماً به رسید منتقل شود
            if ($lockedPayment->status === 'paid') {
                return redirect()->route('admin.subscription.invoice', $lockedPayment->id)
                    ->with('success', 'این تراکنش قبلاً با موفقیت پرداخت و تأیید گردیده است.');
            }

            $verifyResult = $paymentService->verifyPayment($lockedPayment, $request);

            if (!$verifyResult['success']) {
                $lockedPayment->update([
                    'status'      => 'failed',
                    'description' => $verifyResult['message'] ?? 'تراکنش ناموفق بود.',
                ]);

                return redirect()->route('admin.subscription.index')
                    ->with('error', $verifyResult['message'] ?? 'پرداخت انجام نشد یا توسط شما لغو گردید.');
            }

            // ۱. به‌روزرسانی تراکنش به وضعیت موفق
            $lockedPayment->update([
                'status'       => 'paid',
                'reference_id' => $verifyResult['reference_id'] ?? null,
                'card_pan'     => $verifyResult['card_pan'] ?? null,
                'paid_at'      => now(),
                'metadata'     => array_merge($lockedPayment->metadata ?? [], ['verify' => $verifyResult]),
            ]);

            // ۲. تمدید هوشمند اعتبار کاربر (بدون سوختن روزهای قبلی)
            $user = User::where('id', $lockedPayment->user_id)->lockForUpdate()->first();
            $planDays = $lockedPayment->plan ? $lockedPayment->plan->duration_days : 30;

            if ($user->expires_at && $user->expires_at->isFuture()) {
                $user->expires_at = $user->expires_at->addDays($planDays);
            } else {
                $user->expires_at = now()->addDays($planDays);
            }

            // فعال‌سازی آنی حساب
            $user->is_approved = true;
            $user->save();

            // ۳. افزایش شمارنده مصرف کد تخفیف در صورت استفاده
            if ($lockedPayment->coupon) {
                $lockedPayment->coupon->increment('used_count');
            }

            // ۴. ثبت لاگ امنیتی
            AuditLog::create([
                'id'          => 'pay-' . now()->timestamp . rand(100, 999),
                'actor'       => $user->name ?? $user->phone ?? 'کاربر',
                'action'      => 'subscription_purchased_online',
                'entity_type' => 'payment',
                'entity_id'   => (string) $lockedPayment->id,
                'payload'     => json_encode([
                    'plan'         => $lockedPayment->plan?->name,
                    'amount'       => $lockedPayment->amount,
                    'reference_id' => $lockedPayment->reference_id,
                    'gateway'      => $gateway,
                    'new_expiry'   => $user->expires_at->toDateTimeString(),
                ], JSON_UNESCAPED_UNICODE),
                'created_at'  => now(),
            ]);

            // ۵. ارسال پیامک‌های سیستمی
            $shamsiExpiry = User::toJalali($user->expires_at, false);
            $smsService->sendPaymentSuccess(
                $user->phone ?? '',
                $lockedPayment->plan?->name ?? 'اشتراک طلالایو',
                $lockedPayment->amount,
                $lockedPayment->reference_id ?? '---',
                $shamsiExpiry
            );

            $smsService->notifyAdminPayment(
                $user->name ?? 'طلافروشی',
                $user->phone ?? '',
                $lockedPayment->plan?->name ?? 'اشتراک',
                $lockedPayment->amount,
                $lockedPayment->reference_id ?? '---'
            );

            return redirect()->route('admin.subscription.invoice', $lockedPayment->id)
                ->with('success', 'پرداخت با موفقیت انجام شد و اعتبار تابلوی شما تمدید گردید.');
        });
    }

    /**
     * نمایش فاکتور و رسید رسمی دیجیتال با امکان چاپ
     */
    public function invoice(Payment $payment)
    {
        $user = Auth::user();

        // دسترسی فقط برای صاحب فاکتور یا سوپرادمین
        if ($payment->user_id !== $user->id && !$user->is_super_admin) {
            abort(403, 'شما دسترسی به مشاهده این فاکتور را ندارید.');
        }

        $payment->load(['user', 'plan', 'coupon']);
        $jalaliPaidAt = $payment->paid_at ? User::toJalali($payment->paid_at) : 'ثبت نشده';
        $jalaliUserExpiry = User::toJalali($payment->user?->expires_at, false);

        return view('admin.subscription.invoice', compact('payment', 'jalaliPaidAt', 'jalaliUserExpiry'));
    }
}
