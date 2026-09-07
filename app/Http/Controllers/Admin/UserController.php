<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;

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
     * تمدید اعتبار زمانی کاربر (بر اساس ماه‌های انتخابی)
     */
    public function extend(Request $request, $id)
    {
        $validated = $request->validate([
            'months' => 'required|integer|min:1|max:120',
        ]);

        $user = User::findOrFail($id);
        
        // اگر تاریخ انقضا در آینده باشد، به انتهای آن اضافه می‌شود، در غیر این صورت از زمان حال شروع می‌شود
        $currentExpire = ($user->expires_at && $user->expires_at->isFuture()) ? $user->expires_at : now();
        $newExpire = $currentExpire->addMonths($validated['months']);

        $user->update([
            'expires_at' => $newExpire,
            'is_approved' => true // تمدید خودکار حساب کاربری را در صورت منقضی بودن فعال می‌کند
        ]);

        AuditLog::create([
            'id'          => 'log-' . now()->timestamp . rand(100, 999),
            'actor'       => auth()->user()->name,
            'action'      => 'extend_subscription',
            'entity_type' => 'user',
            'entity_id'   => (string) $user->id,
            'payload'     => json_encode(['months' => $validated['months'], 'new_expires_at' => $newExpire->toISOString()]),
            'created_at'  => now(),
        ]);

        return back()->with('success', 'اعتبار حساب کاربری ' . $user->name . ' با موفقیت به مدت ' . $validated['months'] . ' ماه تمدید شد.');
    }

    /**
     * تغییر پسورد کاربر توسط سوپرادمین
     */
    public function changePassword(Request $request, $id)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:6|confirmed',
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
