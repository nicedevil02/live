<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class TransactionController extends Controller
{
    /**
     * اطمینان از وجود جداول پایگاه داده در سرور
     */
    protected function ensureTablesExist(): void
    {
        if (!Schema::hasTable('subscription_plans') || !Schema::hasTable('payments')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
                Log::info('Auto-migrated subscription tables from TransactionController.');
            } catch (\Throwable $e) {
                Log::error('Auto-migration failed in TransactionController: ' . $e->getMessage());
            }
        }

        if (Schema::hasTable('payments') && !Schema::hasColumn('payments', 'receipt_path')) {
            try {
                \Illuminate\Support\Facades\Schema::table('payments', function (\Illuminate\Database\Schema\Blueprint $table) {
                    $table->string('receipt_path', 255)->nullable()->after('card_pan');
                });
            } catch (\Throwable $e) {
                Log::error('Failed to add receipt_path in TransactionController: ' . $e->getMessage());
            }
        }
    }

    /**
     * نمایش پرتال تراکنش‌های مالی و گزارشات برای سوپرادمین
     */
    public function index(Request $request)
    {
        $this->ensureTablesExist();

        $query = Payment::with(['user', 'plan', 'coupon'])->latest();

        // فیلترها
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('invoice_no', 'like', "%{$search}%")
                  ->orWhere('reference_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('gateway')) {
            $query->where('gateway', $request->gateway);
        }

        $payments = $query->paginate(15)->withQueryString();

        // آمار مالی کل
        $totalIncome = Payment::where('status', 'paid')->sum('amount');
        $thisMonthIncome = Payment::where('status', 'paid')
            ->where('paid_at', '>=', now()->startOfMonth())
            ->sum('amount');
        $paidCount = Payment::where('status', 'paid')->count();
        $activeSubscribersCount = User::where('is_super_admin', false)
            ->where('expires_at', '>', now())
            ->count();

        $plans = SubscriptionPlan::where('is_active', true)->get();
        $users = User::where('is_super_admin', false)->orderBy('name')->get();
        $coupons = Coupon::latest()->get();

        return view('admin.transactions.index', compact(
            'payments',
            'totalIncome',
            'thisMonthIncome',
            'paidCount',
            'activeSubscribersCount',
            'plans',
            'users',
            'coupons'
        ));
    }

    /**
     * ثبت پرداخت دستی (کارت‌به‌کارت) توسط سوپرادمین و فعال‌سازی فوری اشتراک
     */
    public function storeManual(Request $request, SmsService $smsService)
    {
        $request->validate([
            'user_id'      => ['required', 'exists:users,id'],
            'plan_id'      => ['required', 'exists:subscription_plans,id'],
            'amount'       => ['required', 'numeric', 'min:0'],
            'reference_id' => ['required', 'string'],
            'description'  => ['nullable', 'string'],
        ], [
            'user_id.required'      => 'انتخاب طلافروش الزامی است.',
            'plan_id.required'      => 'انتخاب پلن الزامی است.',
            'amount.required'       => 'مبلغ الزامی است.',
            'reference_id.required' => 'شماره پیگیری فیش کارت‌به‌کارت الزامی است.',
        ]);

        $user = User::findOrFail($request->user_id);
        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        return DB::transaction(function () use ($user, $plan, $request, $smsService) {
            $payment = Payment::create([
                'invoice_no'      => Payment::generateInvoiceNo(),
                'user_id'         => $user->id,
                'plan_id'         => $plan->id,
                'amount'          => $request->amount,
                'discount_amount' => 0,
                'gateway'         => 'manual',
                'reference_id'    => trim($request->reference_id),
                'status'          => 'paid',
                'paid_at'         => now(),
                'ip_address'      => $request->ip(),
                'description'     => $request->description ?? "ثبت دستی کارت‌به‌کارت توسط مدیریت برای {$plan->name}",
            ]);

            // تمدید اعتبار بدون سوختن روزها
            if ($user->expires_at && $user->expires_at->isFuture()) {
                $user->expires_at = $user->expires_at->addDays($plan->duration_days);
            } else {
                $user->expires_at = now()->addDays($plan->duration_days);
            }

            $user->is_approved = true;
            $user->save();

            // ثبت لاگ
            AuditLog::create([
                'id'          => 'man-' . now()->timestamp . rand(100, 999),
                'actor'       => Auth::user()->name ?? 'مدیر سامانه',
                'action'      => 'manual_payment_recorded',
                'entity_type' => 'payment',
                'entity_id'   => (string) $payment->id,
                'payload'     => json_encode([
                    'user'         => $user->name,
                    'phone'        => $user->phone,
                    'plan'         => $plan->name,
                    'amount'       => $payment->amount,
                    'reference_id' => $payment->reference_id,
                ], JSON_UNESCAPED_UNICODE),
                'created_at'  => now(),
            ]);

            // ارسال پیامک
            $shamsiExpiry = User::toJalali($user->expires_at, false);
            $smsService->sendPaymentSuccess(
                $user->phone ?? '',
                $plan->name,
                $payment->amount,
                $payment->reference_id,
                $shamsiExpiry
            );

            return back()->with('success', "پرداخت کارت‌به‌کارت با شماره فاکتور {$payment->invoice_no} ثبت و اعتبار تابلوی کاربر تمدید شد.");
        });
    }

    /**
     * ایجاد کد تخفیف جدید توسط سوپرادمین
     */
    public function storeCoupon(Request $request)
    {
        $request->validate([
            'code'         => ['required', 'string', 'unique:coupons,code'],
            'title'        => ['nullable', 'string'],
            'type'         => ['required', 'in:percent,fixed'],
            'value'        => ['required', 'numeric', 'min:1'],
            'min_amount'   => ['nullable', 'numeric', 'min:0'],
            'max_discount' => ['nullable', 'numeric', 'min:0'],
            'usage_limit'  => ['nullable', 'numeric', 'min:1'],
        ]);

        Coupon::create([
            'code'         => strtoupper(trim($request->code)),
            'title'        => $request->title,
            'type'         => $request->type,
            'value'        => $request->value,
            'min_amount'   => $request->min_amount ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit'  => $request->usage_limit,
            'is_active'    => true,
        ]);

        return back()->with('success', 'کد تخفیف جدید با موفقیت ایجاد شد.');
    }

    /**
     * فعال/غیرفعال‌سازی کد تخفیف
     */
    public function toggleCoupon(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);
        $status = $coupon->is_active ? 'فعال' : 'غیرفعال';
        return back()->with('success', "کد تخفیف {$coupon->code} {$status} شد.");
    }

    /**
     * تایید فیش پرداخت کارت‌به‌کارت و فعال‌سازی فوری اشتراک
     */
    public function approvePayment(Payment $payment, SmsService $smsService)
    {
        if ($payment->status === 'paid') {
            return back()->with('error', 'این تراکنش قبلاً تایید و فعال شده است.');
        }

        $user = $payment->user;
        $plan = $payment->plan;

        if (!$user || !$plan) {
            return back()->with('error', 'اطلاعات کاربر یا پلن اشتراک مرتبط با این فاکتور یافت نشد.');
        }

        DB::transaction(function () use ($payment, $user, $plan, $smsService) {
            $payment->update([
                'status'  => 'paid',
                'paid_at' => now(),
            ]);

            // تمدید اعتبار اشتراک کاربر بدون سوختن روزها (No Day Lost Guarantee)
            if ($user->expires_at && $user->expires_at->isFuture()) {
                $user->expires_at = $user->expires_at->addDays($plan->duration_days);
            } else {
                $user->expires_at = now()->addDays($plan->duration_days);
            }

            $user->is_approved = true;
            $user->save();

            // افزایش دفعات استفاده از کد تخفیف در صورت وجود
            if ($payment->coupon_id) {
                Coupon::where('id', $payment->coupon_id)->increment('used_count');
            }

            // ثبت لاگ ممیزی
            AuditLog::create([
                'id'          => 'appr-' . now()->timestamp . rand(100, 999),
                'actor'       => Auth::user()->name ?? 'مدیر سامانه',
                'action'      => 'payment_receipt_approved',
                'entity_type' => 'payment',
                'entity_id'   => (string) $payment->id,
                'payload'     => json_encode([
                    'user'         => $user->name,
                    'phone'        => $user->phone,
                    'plan'         => $plan->name,
                    'amount'       => $payment->amount,
                    'receipt_path' => $payment->receipt_path,
                ], JSON_UNESCAPED_UNICODE),
                'created_at'  => now(),
            ]);

            // ارسال پیامک تایید به کاربر
            try {
                $shamsiExpiry = User::toJalali($user->expires_at, false);
                $smsService->sendPaymentSuccess(
                    $user->phone ?? '',
                    $plan->name,
                    $payment->amount,
                    $payment->reference_id ?: $payment->invoice_no,
                    $shamsiExpiry
                );
            } catch (\Throwable $e) {
                Log::error('SMS notification error on approvePayment: ' . $e->getMessage());
            }
        });

        return back()->with('success', "فیش واریزی فاکتور {$payment->invoice_no} تایید شد و اشتراک {$plan->name} برای {$user->name} با موفقیت فعال گردید.");
    }

    /**
     * رد فیش پرداخت کارت‌به‌کارت
     */
    public function rejectPayment(Payment $payment, Request $request)
    {
        $reason = $request->input('reject_reason', 'تصویر فیش نامعتبر یا واریزی به حساب ننشسته است.');

        $payment->update([
            'status'      => 'failed',
            'description' => ($payment->description ? $payment->description . ' | ' : '') . 'دلیل رد: ' . $reason,
        ]);

        AuditLog::create([
            'id'          => 'rej-' . now()->timestamp . rand(100, 999),
            'actor'       => Auth::user()->name ?? 'مدیر سامانه',
            'action'      => 'payment_receipt_rejected',
            'entity_type' => 'payment',
            'entity_id'   => (string) $payment->id,
            'payload'     => json_encode([
                'user'   => $payment->user?->name,
                'reason' => $reason,
            ], JSON_UNESCAPED_UNICODE),
            'created_at'  => now(),
        ]);

        return back()->with('success', "فیش واریزی فاکتور {$payment->invoice_no} رد شد.");
    }
}
