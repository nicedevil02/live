<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * نمایش لیست کاربران
     */
    public function index()
    {
        // نمایش تمام طلافروشان به جز خود سوپرادمین
        $users = User::where('id', '!=', auth()->id())->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * تأیید حساب کاربری
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_approved' => true]);

        AuditLog::create([
            'id'          => 'log-' . now()->timestamp . rand(100, 999),
            'actor'       => auth()->user()->name,
            'action'      => 'approve_user',
            'entity_type' => 'user',
            'entity_id'   => (string) $user->id,
            'payload'     => json_encode(['username' => $user->username]),
            'created_at'  => now(),
        ]);

        return back()->with('success', 'حساب کاربری ' . $user->name . ' با موفقیت تایید و فعال شد.');
    }

    /**
     * تغییر وضعیت فعال / معلق (لغو تأیید موقت یا فعال‌سازی مجدد)
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = !$user->is_approved;
        $user->save();

        AuditLog::create([
            'id'          => 'log-' . now()->timestamp . rand(100, 999),
            'actor'       => auth()->user()->name,
            'action'      => $user->is_approved ? 'activate_user' : 'suspend_user',
            'entity_type' => 'user',
            'entity_id'   => (string) $user->id,
            'payload'     => json_encode(['username' => $user->username, 'is_approved' => $user->is_approved]),
            'created_at'  => now(),
        ]);

        $statusMessage = $user->is_approved ? 'فعال و تایید شد' : 'به حالت تعلیق (غیرفعال) درآمد';
        return back()->with('success', "حساب کاربری {$user->name} با موفقیت {$statusMessage}.");
    }

    /**
     * مدیریت و تمدید انعطاف‌پذیر اعتبار زمانی کاربر (روزانه، ماهانه، تاریخ دلخواه و دسترسی نامحدود)
     */
    public function updateSubscription(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $actionType = $request->input('action_type', 'add_months');
        $note = '';

        // نقطه مبنای تمدید: اگر تاریخ قبلی در آینده است از همان ادامه دهد، وگرنه از زمان حال
        $baseDate = ($user->expires_at && $user->expires_at->isFuture()) 
            ? $user->expires_at->copy() 
            : now();

        $newExpire = null;

        switch ($actionType) {
            case 'add_days':
                $days = (int) $request->input('days', 14);
                $days = max(1, min(365, $days));
                $newExpire = $baseDate->addDays($days);
                $note = "تمدید به مدت {$days} روز";
                break;

            case 'add_months':
                $months = (int) $request->input('months', 1);
                $months = max(1, min(120, $months));
                $newExpire = $baseDate->addMonths($months);
                $note = "تمدید به مدت {$months} ماه";
                break;

            case 'exact_date':
                $dateStr = $request->input('exact_date');
                if (!$dateStr) {
                    return back()->withErrors(['exact_date' => 'لطفاً تاریخ انقضای معتبر انتخاب فرمایید.']);
                }
                try {
                    $newExpire = Carbon::parse($dateStr)->endOfDay();
                    $note = "تنظیم تاریخ انقضا تا پایان روز " . $newExpire->toDateString();
                } catch (\Exception $e) {
                    return back()->withErrors(['exact_date' => 'فرمت تاریخ انقضا نامعتبر است.']);
                }
                break;

            case 'lifetime':
                $newExpire = null; // دسترسی دائمی بدون محدودیت
                $note = "اعطای دسترسی دائمی و نامحدود (Lifetime)";
                break;

            case 'expire_now':
                $newExpire = now()->subMinute(); // منقضی کردن فوری
                $note = "منقضی کردن فوری اشتراک";
                break;

            default:
                return back()->withErrors(['action_type' => 'نوع عملیات تمدید نامعتبر است.']);
        }

        $user->update([
            'expires_at'  => $newExpire,
            'is_approved' => ($actionType !== 'expire_now'),
        ]);

        AuditLog::create([
            'id'          => 'log-' . now()->timestamp . rand(100, 999),
            'actor'       => auth()->user()->name,
            'action'      => 'update_subscription',
            'entity_type' => 'user',
            'entity_id'   => (string) $user->id,
            'payload'     => json_encode([
                'action_type'    => $actionType,
                'note'           => $note,
                'new_expires_at' => $newExpire ? $newExpire->toISOString() : 'lifetime'
            ]),
            'created_at'  => now(),
        ]);

        return back()->with('success', "اعتبار حساب کاربری {$user->name} با موفقیت تغییر یافت ({$note}).");
    }

    /**
     * متد قدیمی تمدید جهت سازگاری با درخواست‌های قبلی
     */
    public function extend(Request $request, $id)
    {
        $request->merge(['action_type' => 'add_months']);
        return $this->updateSubscription($request, $id);
    }

    /**
     * ورود مستقیم سوپرادمین به پنل طلافروش جهت تست و پشتیبانی (Impersonation)
     */
    public function impersonate($id)
    {
        $targetUser = User::findOrFail($id);

        if ($targetUser->id === auth()->id()) {
            return back()->with('error', 'شما هم‌اکنون با این حساب کاربری لاگین هستید.');
        }

        // ذخیره مشخصات سوپرادمین اصلی در نشست (Session)
        session()->put('impersonator_id', auth()->id());
        session()->put('impersonator_name', auth()->user()->name);

        // ورود موقت به عنوان طلافروش
        \Illuminate\Support\Facades\Auth::login($targetUser);

        AuditLog::create([
            'id'          => 'log-' . now()->timestamp . rand(100, 999),
            'actor'       => session('impersonator_name'),
            'action'      => 'impersonate_user',
            'entity_type' => 'user',
            'entity_id'   => (string) $targetUser->id,
            'payload'     => json_encode(['target_username' => $targetUser->username]),
            'created_at'  => now(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', "شما با موفقیت به عنوان همکار «{$targetUser->name}» وارد شدید.");
    }

    /**
     * بازگشت از حساب طلافروش به پنل سوپرادمین
     */
    public function leaveImpersonate()
    {
        $impersonatorId = session()->pull('impersonator_id');
        session()->forget('impersonator_name');

        if ($impersonatorId) {
            $superAdmin = User::find($impersonatorId);
            if ($superAdmin) {
                \Illuminate\Support\Facades\Auth::login($superAdmin);
                return redirect()->route('admin.users.index')->with('success', 'به پنل مدیریت کل (سوپرادمین) بازگشتید.');
            }
        }

        return redirect()->route('admin.login');
    }

    /**
     * تغییر پسورد کاربر توسط سوپرادمین
     */
    public function changePassword(Request $request, $id)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:4|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'password' => \Hash::make($validated['password'])
        ]);

        AuditLog::create([
            'id'          => 'log-' . now()->timestamp . rand(100, 999),
            'actor'       => auth()->user()->name,
            'action'      => 'change_user_password',
            'entity_type' => 'user',
            'entity_id'   => (string) $user->id,
            'payload'     => json_encode(['username' => $user->username]),
            'created_at'  => now(),
        ]);

        return back()->with('success', 'رمز عبور کاربر ' . $user->name . ' با موفقیت تغییر یافت.');
    }

    /**
     * حذف کامل کاربر طلافروشی
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $name = $user->name;
        $user->delete();

        AuditLog::create([
            'id'          => 'log-' . now()->timestamp . rand(100, 999),
            'actor'       => auth()->user()->name,
            'action'      => 'delete_user',
            'entity_type' => 'user',
            'entity_id'   => (string) $id,
            'payload'     => json_encode(['name' => $name]),
            'created_at'  => now(),
        ]);

        return back()->with('success', 'حساب کاربری ' . $name . ' با موفقیت از سیستم حذف گردید.');
    }
}
