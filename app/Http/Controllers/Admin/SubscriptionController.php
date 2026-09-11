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
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class SubscriptionController extends Controller
{
    /**
     * اطمینان از وجود جداول پایگاه داده در سرور
     */
    protected function ensureTablesExist(): void
    {
        if (!Schema::hasTable('subscription_plans') || !Schema::hasTable('payments')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
                Log::info('Auto-migrated subscription tables successfully.');
            } catch (\Throwable $e) {
                Log::error('Auto-migration failed: ' . $e->getMessage());
            }
        }

        if (Schema::hasTable('subscription_plans') && DB::table('subscription_plans')->count() === 0) {
            try {
                DB::table('subscription_plans')->insert([
                    [
                        'name'           => 'اشتراک ۱ ماهه استاندارد',
                        'slug'           => '1-month',
                        'duration_days'  => 30,
                        'price'          => 690000,
                        'original_price' => 690000,
                        'badge_text'     => null,
                        'features'       => json_encode([
                            'دسترسی به کلیه مظنه‌ها و حباب‌ها',
                            'اتصال آنی به تلویزیون هوشمند',
                            'شخصی‌سازی نام و لوگوی گالری',
                            'پشتیبانی فنی و آپدیت لحظه‌ای'
                        ], JSON_UNESCAPED_UNICODE),
                        'is_popular'     => false,
                        'is_active'      => true,
                        'sort_order'     => 1,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ],
                    [
                        'name'           => 'اشتراک ۳ ماهه نقره‌ای',
                        'slug'           => '3-months',
                        'duration_days'  => 90,
                        'price'          => 1790000,
                        'original_price' => 2070000,
                        'badge_text'     => '۱۵٪ تخفیف',
                        'features'       => json_encode([
                            'دسترسی به تمامی امکانات تابلو',
                            'فرمول‌ساز پیشرفته محاسبه سود',
                            'پایداری ۱۰۰٪ بدون قطعی',
                            'پشتیبانی اولویت‌دار'
                        ], JSON_UNESCAPED_UNICODE),
                        'is_popular'     => false,
                        'is_active'      => true,
                        'sort_order'     => 2,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ],
                    [
                        'name'           => 'اشتراک ۶ ماهه طلایی',
                        'slug'           => '6-months',
                        'duration_days'  => 180,
                        'price'          => 2890000,
                        'original_price' => 4140000,
                        'badge_text'     => '۳۰٪ تخفیف',
                        'features'       => json_encode([
                            'دسترسی نامحدود به تمامی امکانات',
                            'اسلایدشوی لوکس ویترین محصولات',
                            'شخصی‌سازی کامل تابلو و رنگ‌ها',
                            'پشتیبانی ویژه VIP'
                        ], JSON_UNESCAPED_UNICODE),
                        'is_popular'     => false,
                        'is_active'      => true,
                        'sort_order'     => 3,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ],
                    [
                        'name'           => 'اشتراک ۱ ساله الماس (ویژه)',
                        'slug'           => '12-months',
                        'duration_days'  => 365,
                        'price'          => 3990000,
                        'original_price' => 8280000,
                        'badge_text'     => 'بیشترین صرفه اقتصادی - محبوب‌ترین',
                        'features'       => json_encode([
                            'پکیج کامل تمام امکانات سامانه',
                            'بیش از ۵۰٪ تخفیف طلایی و استثنایی',
                            'سرور اختصاصی ابری پرسرعت',
                            'پشتیبانی اختصاصی ۲۴ ساعته',
                            'فرمول‌ساز و اسلایدشو نامحدود'
                        ], JSON_UNESCAPED_UNICODE),
                        'is_popular'     => true,
                        'is_active'      => true,
                        'sort_order'     => 4,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ],
                ]);
                Log::info('Auto-seeded subscription plans successfully.');
            } catch (\Throwable $e) {
                Log::error('Auto-seed subscription_plans failed: ' . $e->getMessage());
            }
        }

        if (Schema::hasTable('coupons') && DB::table('coupons')->count() === 0) {
            try {
                DB::table('coupons')->insert([
                    'code'         => 'TALALIVE10',
                    'title'        => 'تخفیف ۱۰ درصدی راه‌اندازی طلالایو',
                    'type'         => 'percent',
                    'value'        => 10,
                    'min_amount'   => 500000,
                    'max_discount' => 500000,
                    'usage_limit'  => 1000,
                    'used_count'   => 0,
                    'is_active'    => true,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
                Log::info('Auto-seeded default coupon successfully.');
            } catch (\Throwable $e) {
                Log::error('Auto-seed coupons failed: ' . $e->getMessage());
            }
        }
        if (Schema::hasTable('payments') && !Schema::hasColumn('payments', 'receipt_path')) {
            try {
                \Illuminate\Support\Facades\Schema::table('payments', function (\Illuminate\Database\Schema\Blueprint $table) {
                    $table->string('receipt_path', 255)->nullable()->after('card_pan');
                });
            } catch (\Throwable $e) {
                Log::error('Auto-migration receipt_path failed in SubscriptionController: ' . $e->getMessage());
            }
        }
    }

    /**
     * نمایش پرتال مدیریت اشتراک، انتخاب پکیج و سوابق پرداخت
     */
    public function index()
    {
        $this->ensureTablesExist();

        $user = Auth::user();
        $plans = SubscriptionPlan::active()->get();
        $payments = $user->payments()->with(['plan', 'coupon'])->latest()->paginate(10);
        
        $daysRemaining = $user->trialDaysRemaining();
        $isSubscribed = $user->isSubscribed();
        $jalaliExpiry = User::toJalali($user->expires_at, false);

        $onlineGatewaysEnabled = config('subscription.online_gateways_enabled', false);
        $bankInfo = config('subscription.bank', [
            'bank_name'             => 'بانک ملی ایران',
            'card_number'           => '6037997205693782',
            'card_number_formatted' => '6037 - 9972 - 0569 - 3782',
            'account_owner'         => 'بهمن شاکری',
        ]);

        return view('admin.subscription.index', compact(
            'user',
            'plans',
            'payments',
            'daysRemaining',
            'isSubscribed',
            'jalaliExpiry',
            'onlineGatewaysEnabled',
            'bankInfo'
        ));
    }

    /**
     * ثبت فیش واریزی کارت به کارت و ایجاد فاکتور در انتظار تایید
     */
    public function submitReceipt(Request $request, CouponService $couponService, SmsService $smsService)
    {
        $this->ensureTablesExist();

        $request->validate([
            'plan_id'       => ['required', 'exists:subscription_plans,id'],
            'receipt_image' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
            'card_pan'      => ['nullable', 'string', 'max:30'],
            'reference_id'  => ['nullable', 'string', 'max:50'],
            'coupon_code'   => ['nullable', 'string', 'max:50'],
            'description'   => ['nullable', 'string', 'max:1000'],
        ], [
            'plan_id.required'       => 'لطفاً پلن مورد نظر خود را انتخاب فرمایید.',
            'receipt_image.required' => 'لطفاً تصویر فیش یا رسید واریزی را پیوست نمایید.',
            'receipt_image.mimes'    => 'فرمت فایل انتخابی باید یکی از فرمت‌های JPG، PNG، WEBP یا PDF باشد.',
            'receipt_image.max'      => 'حداکثر حجم مجاز برای تصویر فیش ۵ مگابایت است.',
        ]);

        $user = Auth::user();
        $plan = SubscriptionPlan::where('is_active', true)->findOrFail($request->plan_id);

        $baseAmount = (int) $plan->price;
        $discountAmount = 0;
        $couponId = null;

        // بررسی و اعمال کد تخفیف در صورت ارسال
        if ($request->filled('coupon_code')) {
            $couponResult = $couponService->applyCoupon($request->coupon_code, $baseAmount);
            if ($couponResult['success']) {
                $discountAmount = $couponResult['discount_amount'];
                $couponId = $couponResult['coupon']->id;
            }
        }

        $finalAmount = max(0, $baseAmount - $discountAmount);

        // آپلود و ذخیره‌سازی تصویر فیش
        $file = $request->file('receipt_image');
        $ext = $file->getClientOriginalExtension() ?: 'jpg';
        $filename = 'receipt_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;

        $publicDir = public_path('uploads/receipts');
        $publicHtmlDir = base_path('public_html/uploads/receipts');

        if (!is_dir($publicDir)) {
            @mkdir($publicDir, 0755, true);
        }
        if (!is_dir($publicHtmlDir)) {
            @mkdir($publicHtmlDir, 0755, true);
        }

        $file->move($publicDir, $filename);
        if (is_dir($publicHtmlDir) && realpath($publicDir) !== realpath($publicHtmlDir)) {
            @copy($publicDir . DIRECTORY_SEPARATOR . $filename, $publicHtmlDir . DIRECTORY_SEPARATOR . $filename);
        }

        $receiptRelativePath = 'uploads/receipts/' . $filename;

        // ایجاد رکورد پرداخت در وضعیت در انتظار تایید
        $payment = Payment::create([
            'invoice_no'      => Payment::generateInvoiceNo(),
            'user_id'         => $user->id,
            'plan_id'         => $plan->id,
            'coupon_id'       => $couponId,
            'amount'          => $finalAmount,
            'discount_amount' => $discountAmount,
            'gateway'         => 'card_to_card',
            'status'          => 'pending',
            'receipt_path'    => $receiptRelativePath,
            'card_pan'        => $request->input('card_pan'),
            'reference_id'    => $request->input('reference_id'),
            'ip_address'      => $request->ip(),
            'description'     => $request->input('description') ?: "واریز کارت به کارت برای {$plan->name} توسط {$user->name}",
            'metadata'        => [
                'submitted_at' => now()->toDateTimeString(),
                'client_ua'    => $request->userAgent(),
            ],
        ]);

        return back()->with('success', 'تصویر فیش واریزی با شماره فاکتور ' . $payment->invoice_no . ' با موفقیت ثبت شد و در صف تایید مدیریت قرار گرفت. پس از بررسی، اشتراک شما بلافاصله فعال خواهد شد.');
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
        $this->ensureTablesExist();

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

            // ۵. لاگین خودکار کاربر در صورت منقضی شدن سشن هنگام بازگشت از درگاه شاپرک
            if (!Auth::check() && $user) {
                Auth::login($user);
            }

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
