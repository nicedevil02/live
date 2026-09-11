<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $input = $request->validate([
            'email'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginValue = trim($input['email']);
        $password   = $input['password'];

        // ۱. بررسی آیا ورودی شماره موبایل است؟
        $normalizedPhone = SmsService::normalizeMobile($loginValue);
        $isPhone = preg_match('/^09[0-9]{9}$/', $normalizedPhone);
        $isEmail = filter_var($loginValue, FILTER_VALIDATE_EMAIL);

        $user = null;
        if ($isPhone) {
            $user = \App\Models\User::where('phone', $normalizedPhone)->first();
        } elseif ($isEmail) {
            $user = \App\Models\User::where('email', $loginValue)->first();
        } else {
            $user = \App\Models\User::where('username', $loginValue)->first();
        }

        // جستجوی تکمیلی در صورت عدم تطابق دقیق
        if (!$user) {
            $user = \App\Models\User::where('username', $loginValue)
                ->orWhere('email', $loginValue)
                ->orWhere('phone', $loginValue)
                ->first();
        }

        if ($user && Hash::check($password, $user->password)) {
            if (!$user->isAdmin()) {
                return back()->withErrors(['email' => 'این حساب کاربری دسترسی به پنل مدیریت ندارد.']);
            }

            // بررسی تایید بودن اکانت
            if (!$user->is_approved && !$user->is_super_admin) {
                return back()->withErrors(['email' => 'حساب کاربری شما در انتظار تأیید است. جهت فعال‌سازی فوری با پشتیبانی فنی طلالایو تماس بگیرید: ۰۹۱۸۷۰۰۹۰۶۴']);
            }

            // بررسی انقضای حساب کاربری
            if ($user->expires_at && $user->expires_at->isPast() && !$user->is_super_admin) {
                return back()->withErrors(['email' => 'اعتبار حساب کاربری شما به پایان رسیده است. جهت تمدید اشتراک با پشتیبانی فنی طلالایو تماس بگیرید: ۰۹۱۸۷۰۰۹۰۶۴']);
            }

            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'اطلاعات ورود (شماره موبایل، نام کاربری یا رمز عبور) اشتباه است.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    /**
     * ارسال کد تأیید ۵ رقمی پیامکی برای ورود سریع طلافروش به پنل
     */
    public function sendLoginOtp(Request $request, SmsService $smsService)
    {
        $inputPhone = $request->input('phone');
        if (!$inputPhone) {
            return response()->json(['success' => false, 'message' => 'لطفاً شماره موبایل خود را وارد نمایید.'], 422);
        }

        $phone = SmsService::normalizeMobile($inputPhone);
        if (!preg_match('/^09[0-9]{9}$/', $phone)) {
            return response()->json(['success' => false, 'message' => 'شماره موبایل نامعتبر است. فرمت صحیح: ۰۹xxxxxxxxx'], 422);
        }

        // بررسی وجود کاربر با این شماره
        $user = \App\Models\User::where('phone', $phone)->first();
        if (!$user) {
            return response()->json([
                'success'        => false,
                'message'        => 'این شماره موبایل در سامانه ثبت نشده است. لطفاً ابتدا از بخش ثبت‌نام، حساب گالری خود را بسازید.',
                'not_registered' => true
            ], 404);
        }

        if (!$user->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'این حساب کاربری دسترسی به پنل مدیریت ندارد.'], 403);
        }

        if (!$user->is_approved && !$user->is_super_admin) {
            return response()->json(['success' => false, 'message' => 'حساب شما در انتظار تأیید است. جهت فعال‌سازی فوری با پشتیبانی فنی طلالایو تماس بگیرید: ۰۹۱۸۷۰۰۹۰۶۴'], 403);
        }

        if ($user->expires_at && $user->expires_at->isPast() && !$user->is_super_admin) {
            return response()->json(['success' => false, 'message' => 'اعتبار زمانی حساب شما به پایان رسیده است. جهت تمدید اشتراک با پشتیبانی فنی طلالایو تماس بگیرید: ۰۹۱۸۷۰۰۹۰۶۴'], 403);
        }

        // ایجاد جدول otp_verifications در صورت عدم اجرا
        if (!\Illuminate\Support\Facades\Schema::hasTable('otp_verifications')) {
            \Illuminate\Support\Facades\Schema::create('otp_verifications', function ($table) {
                $table->id();
                $table->string('phone', 20)->index();
                $table->string('code', 10);
                $table->timestamp('expires_at')->index();
                $table->string('ip_address', 45)->nullable();
                $table->timestamps();
            });
        }

        // محدودیت ۶۰ ثانیه‌ای
        $recentOtp = DB::table('otp_verifications')
            ->where('phone', $phone)
            ->where('created_at', '>', now()->subSeconds(60))
            ->first();

        if ($recentOtp) {
            $secondsLeft = 60 - now()->diffInSeconds(\Illuminate\Support\Carbon::parse($recentOtp->created_at));
            return response()->json(['success' => false, 'message' => "لطفاً {$secondsLeft} ثانیه دیگر مجدداً تلاش نمایید."], 429);
        }

        $code = (string) rand(11111, 99999);

        DB::table('otp_verifications')->insert([
            'phone'      => $phone,
            'code'       => $code,
            'expires_at' => now()->addMinutes(3),
            'ip_address' => $request->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $smsResult = $smsService->sendOtp($phone, $code);

        if (!$smsResult['success']) {
            $msg = $smsResult['message'] ?? 'خطا در ارسال پیامک از طریق درگاه.';
            \Log::warning("Login OTP SMS failed for {$phone}: " . $msg);
            return response()->json(['success' => false, 'message' => $msg], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'کد تأیید ۵ رقمی ورود با موفقیت به موبایل شما پیامک شد.',
            'ttl'     => 120,
        ]);
    }

    /**
     * ورود مستقیم به پنل با کد یکبار مصرف پیامکی
     */
    public function loginWithOtp(Request $request)
    {
        $inputPhone = $request->input('phone');
        $code = trim($request->input('otp', ''));

        $phone = SmsService::normalizeMobile((string) $inputPhone);

        $request->validate([
            'phone' => ['required', 'string'],
            'otp'   => ['required', 'string', 'size:5'],
        ], [
            'phone.required' => 'شماره موبایل الزامی است.',
            'otp.required'   => 'کد تأیید پیامک‌شده را وارد نمایید.',
            'otp.size'       => 'کد تأیید باید ۵ رقم باشد.',
        ]);

        $user = \App\Models\User::where('phone', $phone)->first();
        if (!$user) {
            return back()->withInput()->withErrors(['phone' => 'حساب کاربری با این شماره موبایل یافت نشد.']);
        }

        if (!$user->isAdmin()) {
            return back()->withErrors(['phone' => 'این حساب کاربری دسترسی به پنل مدیریت ندارد.']);
        }

        if (!$user->is_approved && !$user->is_super_admin) {
            return back()->withErrors(['phone' => 'حساب کاربری شما در انتظار تأیید است. تماس با پشتیبانی فنی طلالایو: ۰۹۱۸۷۰۰۹۰۶۴']);
        }

        if ($user->expires_at && $user->expires_at->isPast() && !$user->is_super_admin) {
            return back()->withErrors(['phone' => 'اعتبار زمانی حساب شما به پایان رسیده است. تماس با پشتیبانی فنی طلالایو: ۰۹۱۸۷۰۰۹۰۶۴']);
        }

        // بررسی کد پیامکی
        $validOtp = DB::table('otp_verifications')
            ->where('phone', $phone)
            ->where('code', $code)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$validOtp) {
            return back()->withInput()->withErrors(['otp' => 'کد تأیید پیامک‌شده اشتباه است یا زمان آن منقضی شده است.']);
        }

        // حذف کدهای مصرف‌شده
        DB::table('otp_verifications')->where('phone', $phone)->delete();

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * نمایش فرم تنظیمات امنیتی
     */
    public function editSecurity()
    {
        return view('admin.security.index');
    }

    /**
     * به‌روزرسانی نام کاربری و رمز عبور ادمین
     */
    public function updateSecurity(Request $request)
    {
        $validated = $request->validate([
            'currentPassword' => 'required|string',
            'newUsername'     => 'nullable|string|min:3',
            'newPassword'     => 'nullable|string|min:4|confirmed',
        ]);

        $user = auth()->user();

        // بررسی رمز عبور فعلی
        if (!\Hash::check($validated['currentPassword'], $user->password)) {
            return response()->json(['message' => 'رمز عبور فعلی اشتباه است.'], 401);
        }

        // تغییر نام کاربری واقعی و شناسه تابلوی کاربر
        if (!empty($validated['newUsername'])) {
            $newUsername = strtolower(trim($validated['newUsername']));
            if (!preg_match('/^[a-z0-9_-]{3,30}$/', $newUsername)) {
                return response()->json(['message' => 'نام کاربری باید بین ۳ تا ۳۰ کاراکتر و فقط شامل حروف انگلیسی، اعداد، - و _ باشد.'], 422);
            }
            $exists = \App\Models\User::where('username', $newUsername)->where('id', '!=', $user->id)->exists();
            if ($exists) {
                return response()->json(['message' => 'این نام کاربری قبلاً توسط طلافروشی دیگری ثبت شده است.'], 422);
            }
            $user->username = $newUsername;
            $user->name = $newUsername;
        }

        // تغییر رمز عبور
        if (!empty($validated['newPassword'])) {
            $user->password = \Hash::make($validated['newPassword']);
        }

        $user->save();

        // لاگ
        \App\Models\AuditLog::create([
            'id'          => 'log-' . now()->timestamp . rand(100, 999),
            'actor'       => $user->name ?? 'admin',
            'action'      => 'update',
            'entity_type' => 'security_settings',
            'entity_id'   => (string) $user->id,
            'payload'     => json_encode(['ip' => $request->ip()]),
            'created_at'  => now(),
        ]);

        return response()->json(['message' => 'اطلاعات با موفقیت ذخیره شد.']);
    }

    /**
     * نمایش فرم ثبت نام
     */
    public function showRegisterForm()
    {
        return view('admin.register');
    }

    /**
     * ارسال کد تأیید ۵ رقمی پیامکی به شماره موبایل طلافروش
     */
    public function sendRegisterOtp(Request $request, SmsService $smsService)
    {
        $inputPhone = $request->input('phone');
        if (!$inputPhone) {
            return response()->json(['success' => false, 'message' => 'لطفاً شماره موبایل را وارد نمایید.'], 422);
        }

        $phone = SmsService::normalizeMobile($inputPhone);
        if (!preg_match('/^09[0-9]{9}$/', $phone)) {
            return response()->json(['success' => false, 'message' => 'شماره موبایل نامعتبر است. فرمت صحیح: ۰۹xxxxxxxxx'], 422);
        }

        // بررسی یکتایی شماره
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'phone')) {
            if (\App\Models\User::where('phone', $phone)->exists()) {
                return response()->json(['success' => false, 'message' => 'این شماره موبایل قبلاً در سامانه ثبت شده است. لطفاً از فرم ورود استفاده کنید.'], 422);
            }
        }

        // ایجاد خودکار جدول کدهای تایید در صورت اجرا نشدن مایگریشن
        if (!\Illuminate\Support\Facades\Schema::hasTable('otp_verifications')) {
            \Illuminate\Support\Facades\Schema::create('otp_verifications', function ($table) {
                $table->id();
                $table->string('phone', 20)->index();
                $table->string('code', 10);
                $table->timestamp('expires_at')->index();
                $table->string('ip_address', 45)->nullable();
                $table->timestamps();
            });
        }

        // محدودیت ارسال مجدد: ۶۰ ثانیه
        $recentOtp = DB::table('otp_verifications')
            ->where('phone', $phone)
            ->where('created_at', '>', now()->subSeconds(60))
            ->first();

        if ($recentOtp) {
            $secondsLeft = 60 - now()->diffInSeconds(\Illuminate\Support\Carbon::parse($recentOtp->created_at));
            return response()->json(['success' => false, 'message' => "لطفاً {$secondsLeft} ثانیه دیگر مجدداً تلاش نمایید."], 429);
        }

        $code = (string) rand(11111, 99999);

        DB::table('otp_verifications')->insert([
            'phone'      => $phone,
            'code'       => $code,
            'expires_at' => now()->addMinutes(3),
            'ip_address' => $request->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $smsResult = $smsService->sendOtp($phone, $code);

        if (!$smsResult['success']) {
            $msg = $smsResult['message'] ?? 'خطا در ارسال پیامک از طریق درگاه.';
            \Log::warning("Register OTP SMS failed for {$phone}: " . $msg);

            return response()->json([
                'success' => false,
                'message' => $msg,
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'کد تأیید ۵ رقمی به شماره شما پیامک شد.',
            'ttl'     => 120,
        ]);
    }

    /**
     * تولید خودکار شناسه انگلیسی یکتا برای آدرس تلویزیون از روی نام مغازه یا شماره موبایل
     */
    public static function generateUniqueSlug(string $shopName, string $phone): string
    {
        $map = [
            'آ' => 'a', 'ا' => 'a', 'ب' => 'b', 'پ' => 'p', 'ت' => 't', 'ث' => 's', 'ج' => 'j', 'چ' => 'ch', 'ح' => 'h', 'خ' => 'kh',
            'د' => 'd', 'ذ' => 'z', 'ر' => 'r', 'ز' => 'z', 'ژ' => 'zh', 'س' => 's', 'ش' => 'sh', 'ص' => 's', 'ض' => 'z', 'ط' => 't',
            'ظ' => 'z', 'ع' => 'a', 'غ' => 'gh', 'ف' => 'f', 'ق' => 'gh', 'ک' => 'k', 'گ' => 'g', 'ل' => 'l', 'م' => 'm', 'ن' => 'n',
            'و' => 'u', 'ه' => 'h', 'ی' => 'y', 'ي' => 'y', 'ك' => 'k', 'ئ' => 'y', 'ء' => '', 'أ' => 'a', 'إ' => 'e', 'ؤ' => 'o',
            'ة' => 'h', ' ' => '-', '‌' => '-'
        ];

        $chars = preg_split('//u', mb_strtolower(trim($shopName), 'UTF-8'), -1, PREG_SPLIT_NO_EMPTY);
        $transliterated = '';
        foreach ($chars as $ch) {
            if (isset($map[$ch])) {
                $transliterated .= $map[$ch];
            } elseif (preg_match('/[a-z0-9\-]/', $ch)) {
                $transliterated .= $ch;
            }
        }

        $slug = preg_replace('/-+/', '-', $transliterated);
        $slug = trim($slug, '-');

        if (strlen($slug) < 3) {
            $lastDigits = substr(preg_replace('/[^\d]/', '', $phone), -4);
            $slug = 'gold-' . ($lastDigits ?: rand(1000, 9999));
        }

        if (strlen($slug) > 25) {
            $slug = substr($slug, 0, 25);
            $slug = rtrim($slug, '-');
        }

        // بررسی یکتایی در جدول users
        $originalSlug = $slug;
        $counter = 2;
        while (\App\Models\User::where('username', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * ثبت نام طلافروشی جدید با شماره موبایل و فعال‌سازی فوری تست ۷ روزه
     */
    public function register(Request $request, SmsService $smsService)
    {
        $normalizedPhone = SmsService::normalizeMobile($request->input('phone', ''));
        $shopName = trim($request->input('name', ''));
        $inputSlug = trim($request->input('slug') ?: $request->input('username', ''));

        // اگر اسلاگ دستی وارد نشده باشد، خودکار و بدون نیاز به تفکر طلافروش ساخته می‌شود
        if (empty($inputSlug)) {
            $slug = self::generateUniqueSlug($shopName, $normalizedPhone);
        } else {
            $slug = strtolower(preg_replace('/[^a-z0-9_-]/', '', $inputSlug));
            if (strlen($slug) < 3) {
                $slug = self::generateUniqueSlug($shopName, $normalizedPhone);
            }
        }

        // رمز عبور: در صورت خالی بودن، رمز پیش‌فرض ۴ رقمی تولید می‌شود
        $password = $request->input('password');
        if (empty($password)) {
            $password = substr($normalizedPhone, -4) ?: '1234';
        }

        $request->merge([
            'phone'    => $normalizedPhone,
            'username' => $slug,
            'password' => $password,
        ]);

        // ایجاد خودکار ستون شماره در صورت اجرا نشدن مایگریشن
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'phone')) {
            \Illuminate\Support\Facades\Schema::table('users', function ($table) {
                $table->string('phone', 20)->nullable()->unique()->after('email');
                $table->timestamp('phone_verified_at')->nullable()->after('phone');
            });
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => ['required', 'string', 'regex:/^09[0-9]{9}$/', 'unique:users,phone'],
            'otp'      => 'required|string|size:5',
            'password' => 'nullable|string|min:4',
            'email'    => 'nullable|string|email|max:255|unique:users,email',
        ], [
            'name.required' => 'نام گالری / طلافروشی الزامی است.',
            'phone.regex'   => 'فرمت شماره موبایل نامعتبر است (مثال: 09187009064).',
            'phone.unique'  => 'این شماره موبایل قبلاً در سامانه ثبت شده است. لطفاً وارد شوید.',
            'otp.required'  => 'کد تأیید ۵ رقمی پیامک‌شده را وارد کنید.',
            'otp.size'      => 'کد تأیید باید ۵ رقم باشد.',
            'password.min'  => 'رمز عبور باید حداقل ۴ کاراکتر باشد.',
        ]);

        // اعتبارسنجی کد پیامکی
        $validOtp = DB::table('otp_verifications')
            ->where('phone', $validated['phone'])
            ->where('code', $validated['otp'])
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$validOtp) {
            return back()->withInput()->withErrors(['otp' => 'کد تأیید پیامک‌شده اشتباه است یا زمان آن منقضی شده است.']);
        }

        // حذف کدهای مصرف‌شده
        DB::table('otp_verifications')->where('phone', $validated['phone'])->delete();

        // ایجاد کاربر جدید با نقش ادمین، فعال فوری و دارای ۱۴ روز دوره تست رایگان
        $user = \App\Models\User::create([
            'name'              => $validated['name'],
            'username'          => $slug,
            'phone'             => $validated['phone'],
            'phone_verified_at' => now(),
            'email'             => !empty($validated['email']) ? $validated['email'] : ($slug . '@talalive.ir'),
            'password'          => Hash::make($password),
            'is_admin'          => true,
            'is_super_admin'    => false,
            'is_approved'       => true, // فعال فوری جهت تست بدون اصطکاک!
            'expires_at'        => now()->addDays(14), // دوره تست رایگان ۱۴ روزه
            'display_token'     => 'dt_' . Str::random(16),
        ]);

        // ایجاد تنظیمات پیش‌فرض برای مغازه جدید
        \App\Models\DisplaySetting::create([
            'user_id'             => $user->id,
            'theme_mode'          => 'dark-glass',
            'slider_interval_sec' => 8,
            'show_weight'         => true,
            'show_labor'          => true,
            'show_profit'         => true,
            'shop_name'           => $validated['name'],
            'phone'               => $validated['phone'],
            'instagram'           => '',
            'rubika'              => '',
        ]);

        // ایجاد فرمول پیش‌فرض برای مغازه جدید
        \App\Models\FormulaConfig::create([
            'user_id'          => $user->id,
            'buy_multiplier_a' => 740,
            'buy_divisor_b'    => 750,
        ]);

        // ایجاد آیتم‌های تابلوی پیش‌فرض برای مغازه جدید
        $items = [
            ['key' => 'gold18', 'label' => 'طلای ۱۸ عیار', 'order' => 1],
            ['key' => 'buy_gold', 'label' => 'گرم خرید ۱۸ عیار', 'order' => 2],
            ['key' => 'gold24', 'label' => 'طلای ۲۴ عیار', 'order' => 3],
            ['key' => 'coin_emami', 'label' => 'سکه امامی', 'order' => 4],
            ['key' => 'coin_bahar', 'label' => 'سکه بهار آزادی', 'order' => 5],
            ['key' => 'coin_nim', 'label' => 'نیم سکه', 'order' => 6],
            ['key' => 'coin_rob', 'label' => 'ربع سکه', 'order' => 7],
            ['key' => 'usd', 'label' => 'دلار', 'order' => 8],
            ['key' => 'euro', 'label' => 'یورو', 'order' => 9],
            ['key' => 'dirham', 'label' => 'درهم', 'order' => 10],
            ['key' => 'bitcoin', 'label' => 'بیت کوین', 'order' => 11],
            ['key' => 'ounce', 'label' => 'انس جهانی', 'order' => 12],
            ['key' => 'mesghal17', 'label' => 'مثقال ۱۷', 'order' => 13],
            ['key' => 'coin_gerami', 'label' => 'سکه گرمی', 'order' => 14],
            ['key' => 'usdt', 'label' => 'تتر', 'order' => 15],
        ];

        foreach ($items as $item) {
            \App\Models\DisplayItem::create([
                'user_id' => $user->id,
                'key'     => $item['key'],
                'label'   => $item['label'],
                'enabled' => true,
                'order'   => $item['order'],
            ]);
        }

        // اطلاع‌رسانی پیامکی آنی به مدیریت
        $smsService->notifyAdminNewRegistration($user->name, $user->phone);

        // ارسال پیامک خوش‌آمد و لینک تابلوی تلویزیون به طلافروش
        $smsService->sendWelcomeSms($user->phone, $user->name, $user->username);

        // لاگ ثبت‌نام
        \App\Models\AuditLog::create([
            'id'          => 'log-' . now()->timestamp . rand(100, 999),
            'actor'       => $user->name,
            'action'      => 'register_instant_trial',
            'entity_type' => 'user',
            'entity_id'   => (string) $user->id,
            'payload'     => json_encode(['ip' => $request->ip(), 'phone' => $user->phone], JSON_UNESCAPED_UNICODE),
            'created_at'  => now(),
        ]);

        // ورود خودکار طلافروش به پنل بدون معطلی
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with('success', 'به سامانه طلالایو خوش آمدید! دوره آزمایشی ۱۴ روزه گالری شما با موفقیت فعال شد.');
    }
}
