<?php

namespace App\Http\Controllers;

use App\Models\DisplayItem;
use App\Models\DisplaySetting;
use App\Models\ProductSlide;
use App\Services\MarketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicDisplayController extends Controller
{
    protected $marketService;

    public function __construct(MarketService $marketService)
    {
        $this->marketService = $marketService;
    }

    public function show($username)
    {
        $user = \App\Models\User::where('username', $username)->firstOrFail();
        $this->validateDisplayToken($user);

        // بررسی تایید بودن اکانت
        if (!$user->is_approved && !$user->is_super_admin) {
            return response("<div style='font-family: Tahoma, sans-serif; direction: rtl; text-align: center; padding: 100px 20px; background: #fffbeb; min-height: 100vh; display: flex; align-items: center; justify-content: center;'><div style='max-width: 500px; background: #fff; border: 1px solid #fef3c7; padding: 40px 30px; border-radius: 24px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);'><div style='font-size: 56px; margin-bottom: 24px;'>⏳</div><h2 style='color: #b45309; margin-bottom: 12px; font-weight: 800;'>حساب در انتظار تأیید</h2><p style='color: #78350f; font-size: 15px; line-height: 1.7; margin: 0;'>حساب کاربری این گالری هنوز توسط مدیریت سامانه تأیید نشده است. لطفاً منتظر بمانید یا با مدیریت تماس بگیرید.</p></div></div>", 403, [
                'X-Robots-Tag' => 'noindex, follow',
            ]);
        }

        // بررسی انقضای زمانی حساب
        if ($user->expires_at && $user->expires_at->isPast() && !$user->is_super_admin) {
            return response("<div style='font-family: Tahoma, sans-serif; direction: rtl; text-align: center; padding: 100px 20px; background: #fef2f2; min-height: 100vh; display: flex; align-items: center; justify-content: center;'><div style='max-width: 500px; background: #fff; border: 1px solid #fecaca; padding: 40px 30px; border-radius: 24px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);'><div style='font-size: 56px; margin-bottom: 24px;'>⚠️</div><h2 style='color: #991b1b; margin-bottom: 12px; font-weight: 800;'>پایان اعتبار نمایشگر</h2><p style='color: #7f1d1d; font-size: 15px; line-height: 1.7; margin: 0;'>اعتبار زمانی استفاده از تابلوی این گالری به پایان رسیده است. لطفاً جهت تمدید اعتبار و فعال‌سازی مجدد با مدیریت سامانه تماس حاصل فرمایید.</p></div></div>", 402, [
                'X-Robots-Tag' => 'noindex, follow',
            ]);
        }

        $snapshot = $this->buildSnapshot($user);
        return view('display.live', ['snapshot' => $snapshot, 'username' => $username]);
    }

    public function snapshot($username)
    {
        $user = \App\Models\User::where('username', $username)->firstOrFail();
        $this->validateDisplayToken($user);

        if (!$user->is_approved && !$user->is_super_admin) {
            abort(403, 'حساب کاربری در انتظار تایید مدیریت است.');
        }

        if ($user->expires_at && $user->expires_at->isPast() && !$user->is_super_admin) {
            abort(402, 'اعتبار زمانی حساب به پایان رسیده است.');
        }

        // بروزرسانی خودکار و تضمینی نرخ تتر هر ۱۰ ثانیه (Self-Healing 10s Auto Refresh)
        try {
            $usdtCache = \App\Models\MarketCache::where('symbol', 'usdt')->first();
            $needsUsdtFetch = false;
            if (!$usdtCache || !$usdtCache->fetched_at) {
                $needsUsdtFetch = true;
            } else {
                $diff = now()->diffInSeconds($usdtCache->fetched_at);
                if ($diff >= 10) {
                    $needsUsdtFetch = true;
                }
            }

            if ($needsUsdtFetch) {
                \Illuminate\Support\Facades\Cache::lock('usdt_snapshot_fetch_lock', 6)->get(function () {
                    $this->marketService->fetchFastMovingPrices();
                });
            }
        } catch (\Throwable $e) {
            \Log::warning('Auto USDT refresh in snapshot error: ' . $e->getMessage());
        }

        return response()->json($this->buildSnapshot($user));
    }

    public function health($username)
    {
        $user = \App\Models\User::where('username', $username)->firstOrFail();
        $this->validateDisplayToken($user);

        if (!$user->is_approved && !$user->is_super_admin) {
            abort(403, 'حساب کاربری در انتظار تایید مدیریت است.');
        }

        if ($user->expires_at && $user->expires_at->isPast() && !$user->is_super_admin) {
            abort(402, 'اعتبار زمانی حساب به پایان رسیده است.');
        }

        $lastFetch = \App\Models\MarketCache::max('fetched_at');
        $isHealthy = $lastFetch && (max(0, now()->timestamp - \Illuminate\Support\Carbon::parse($lastFetch)->timestamp) < 600);

        return response()->json([
            'status'              => $isHealthy ? 'ok' : 'degraded',
            'lastSuccessfulFetch' => $lastFetch ?? now()->toISOString(),
        ]);
    }

    protected function validateDisplayToken($user): void
    {
        if (auth()->check() && auth()->id() === $user->id) {
            return;
        }

        $key = request()->query('key') ?? request()->cookie('display_token') ?? request()->header('X-Display-Token');
        if (!$key || $key !== $user->display_token) {
            abort(403, 'شما دسترسی به این تابلوی نمایشی را ندارید.');
        }
    }

    private function buildSnapshot($user)
    {
        $settings = DisplaySetting::where('user_id', $user->id)->firstOrFail();
        $items    = DisplayItem::where('user_id', $user->id)->orderBy('order')->get();
        $products = ProductSlide::where('user_id', $user->id)->with('images')->where('is_visible', true)->latest()->get();
        $priceFeed = $this->marketService->getPriceFeed($user);

        $lastFetch = \App\Models\MarketCache::max('fetched_at');

        $bingWallpaper = null;
        if (str_starts_with($settings->theme_mode ?? '', 'bing-')) {
            try {
                $bingWallpaper = app(\App\Services\BingWallpaperService::class)->getTodayWallpaper();
            } catch (\Throwable $e) {
                \Log::warning('Bing wallpaper snapshot error: ' . $e->getMessage());
                $bingWallpaper = [
                    'url' => '/images/bing/today.jpg',
                    'title' => 'عکس روز بینگ',
                    'copyright' => 'Bing Daily Wallpaper',
                ];
            }
        }

        return [
            'username'     => $user->username,
            'updatedAt'    => $lastFetch ? \Illuminate\Support\Carbon::parse($lastFetch)->toISOString() : now()->toISOString(),
            'apiTime'      => \Cache::get('market_api_last_time', '---'),
            'refreshIntervalSeconds' => $this->marketService->currentRefreshIntervalSeconds(),
            'displayItems' => $items,
            'priceFeed'    => $priceFeed,
            'products'     => $products,
            'settings'     => $settings,
            'bingWallpaper'=> $bingWallpaper,
        ];
    }

    /**
     * نمایش صفحه انتظار جفت‌سازی تلویزیون
     */
    public function showPairingScreen()
    {
        return view('display.pairing');
    }

    /**
     * اطمینان از وجود جدول tv_sessions در پایگاه داده (Self-Healing Schema)
     */
    public static function ensureTvSessionsTable(): void
    {
        try {
            if (!Schema::hasTable('tv_sessions')) {
                Schema::create('tv_sessions', function ($table) {
                    $table->id();
                    $table->string('session_code', 100)->unique()->index();
                    $table->string('activation_code', 10)->index();
                    $table->unsignedBigInteger('paired_user_id')->nullable()->index();
                    $table->string('paired_username', 100)->nullable();
                    $table->string('paired_token', 255)->nullable();
                    $table->boolean('is_paired')->default(false)->index();
                    $table->timestamp('expires_at')->nullable()->index();
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            \Log::warning('ensureTvSessionsTable error: ' . $e->getMessage());
        }
    }

    /**
     * چک کردن وضعیت جفت‌سازی توسط تلویزیون (Fast Cache + DB Persistence Fallback)
     */
    public function checkPairingStatus($session_code)
    {
        // ۱. بررسی کش موقت
        $data = Cache::get('pairing_' . $session_code);
        if ($data && !empty($data['username']) && !empty($data['token'])) {
            return response()->json([
                'paired' => true,
                'username' => $data['username'],
                'display_token' => $data['token']
            ]);
        }

        // ۲. بررسی دیتابیس در صورت نبود یا انقضای کش
        self::ensureTvSessionsTable();
        try {
            $dbSession = DB::table('tv_sessions')
                ->where('session_code', $session_code)
                ->where('is_paired', true)
                ->first();

            if ($dbSession && $dbSession->paired_username && $dbSession->paired_token) {
                // کش مجدد جهت تسریع درخواست‌های بعدی
                Cache::put('pairing_' . $session_code, [
                    'user_id'  => $dbSession->paired_user_id,
                    'username' => $dbSession->paired_username,
                    'token'    => $dbSession->paired_token,
                ], 7200);

                return response()->json([
                    'paired' => true,
                    'username' => $dbSession->paired_username,
                    'display_token' => $dbSession->paired_token
                ]);
            }
        } catch (\Throwable $e) {
            \Log::warning('checkPairingStatus DB error: ' . $e->getMessage());
        }

        return response()->json(['paired' => false]);
    }

    /**
     * جفت‌سازی دستگاه تلویزیون توسط گوشی طلافروش با تأییدیه امن و جلوگیری از CSRF
     */
    public function pairDevice(Request $request, $session_code)
    {
        $user = auth()->user();
        
        // اعتبارسنجی کد سشن
        if (!preg_match('/^[a-zA-Z0-9_\-]+$/', $session_code)) {
            abort(400, 'شناسه سشن نامعتبر است.');
        }

        // اطمینان از وجود display_token
        if (empty($user->display_token)) {
            $user->display_token = Str::random(32);
            $user->save();
        }

        // اگر درخواست GET بود، صفحه تأیید صریح نمایش داده می‌شود تا از حملات CSRF جلوگیری شود
        if ($request->isMethod('GET')) {
            $csrf = csrf_token();
            $actionUrl = route('admin.pair', ['session_code' => $session_code]);
            return response("
                <!DOCTYPE html>
                <html lang='fa' dir='rtl'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>تأیید اتصال تلویزیون</title>
                    <style>
                        body { font-family: Tahoma, system-ui, sans-serif; background: #0f172a; color: #f8fafc; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 20px; }
                        .card { background: #1e293b; border: 1px solid #334155; border-radius: 24px; padding: 40px 30px; max-width: 440px; text-align: center; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); }
                        .icon { font-size: 50px; margin-bottom: 20px; }
                        h2 { margin: 0 0 12px 0; font-size: 20px; color: #38bdf8; }
                        p { color: #94a3b8; font-size: 14px; line-height: 1.7; margin: 0 0 24px 0; }
                        .btn { background: #2563eb; color: #fff; border: none; border-radius: 14px; padding: 14px 28px; font-weight: bold; font-size: 15px; cursor: pointer; width: 100%; transition: background 0.2s; }
                        .btn:hover { background: #1d4ed8; }
                        .meta { background: #0f172a; border-radius: 12px; padding: 12px; margin-bottom: 20px; font-size: 13px; color: #cbd5e1; }
                    </style>
                </head>
                <body>
                    <div class='card'>
                        <div class='icon'>📺</div>
                        <h2>تأیید اتصال تلویزیون جدید</h2>
                        <p>آیا می‌خواهید این نمایشگر را به تابلوی گالری اختصاصی خود متصل نمایید؟</p>
                        <div class='meta'>کاربر: <b>" . e($user->name) . "</b> (" . e($user->username) . ")</div>
                        <form method='POST' action='{$actionUrl}'>
                            <input type='hidden' name='_token' value='{$csrf}'>
                            <button type='submit' class='btn'>✅ تأیید و اتصال به تلویزیون</button>
                        </form>
                    </div>
                </body>
                </html>
            ");
        }

        self::ensureTvSessionsTable();

        // ۱. بروزرسانی قطعی در دیتابیس
        try {
            DB::table('tv_sessions')->updateOrInsert(
                ['session_code' => $session_code],
                [
                    'is_paired'       => true,
                    'paired_user_id'  => $user->id,
                    'paired_username' => $user->username,
                    'paired_token'    => $user->display_token,
                    'updated_at'      => now(),
                ]
            );
        } catch (\Throwable $e) {
            \Log::warning('pairDevice DB update error: ' . $e->getMessage());
        }

        // ۲. انجام اتصال در کش برای ۲ ساعت
        Cache::put('pairing_' . $session_code, [
            'user_id' => $user->id,
            'username' => $user->username,
            'token' => $user->display_token
        ], 7200);

        if ($request->wantsJson() || $request->ajax() || $request->isJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تلویزیون با موفقیت متصل شد.'
            ]);
        }

        return response("<div style='font-family: Tahoma, sans-serif; direction: rtl; text-align: center; padding: 80px 20px; background: #f8fafc; min-height: 100vh; display: flex; align-items: center; justify-content: center;'><div style='max-width: 400px; background: #fff; border: 1px solid #e2e8f0; padding: 40px 30px; border-radius: 24px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);'><div style='font-size: 56px; margin-bottom: 24px;'>✅</div><h2 style='color: #0f172a; margin-bottom: 12px; font-weight: 800;'>اتصال با موفقیت انجام شد</h2><p style='color: #64748b; font-size: 15px; line-height: 1.7; margin: 0;'>تلویزیون شما با موفقیت به اکانت متصل شد و اکنون قیمت‌های طلای گالری شما را نمایش می‌دهد. می‌توانید این صفحه را در گوشی خود ببندید.</p></div></div>");
    }

    /**
     * نرمال‌سازی کامل و دقیق ارقام فارسی و عربی به انگلیسی و پاکسازی کاراکترهای اضافه
     */
    public static function normalizeDigits(string $input): string
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $cleaned = str_replace($persian, $english, $input);
        // حذف هرگونه فاصله، خط تیره، نیم‌فاصله و کاراکترهای کنترلی
        $cleaned = preg_replace('/[\s\-\x{200C}\x{200D}_]+/u', '', $cleaned);
        return strtoupper(trim($cleaned));
    }

    /**
     * ثبت سشن موقت تلویزیون در سرور با ذخیره دوگانه در دیتابیس و کش (اعتبار ۲ ساعت)
     */
    public function registerSession(Request $request)
    {
        self::ensureTvSessionsTable();

        $sessionCode = $request->input('session_code');
        $rawCode = (string) $request->input('activation_code', '');
        $activationCode = self::normalizeDigits($rawCode);

        if (!$sessionCode) {
            $sessionCode = 'sess-' . Str::random(16);
        }

        // پاکسازی خودکار سشن‌های قدیمی‌تر از ۲۴ ساعت جهت جلوگیری از انباشت رکوردها
        try {
            DB::table('tv_sessions')->where('expires_at', '<', now()->subDay())->delete();
        } catch (\Throwable $e) {}

        // اگر کدی ارسال نشده یا ۶ رقمی معتبر نیست، یک پین ۶ رقمی تصادفی و غیرتکراری تولید می‌کنیم
        if (empty($activationCode) || !preg_match('/^[0-9]{6}$/', $activationCode)) {
            $attempts = 0;
            do {
                $activationCode = (string) random_int(100000, 999999);
                $attempts++;
                $exists = DB::table('tv_sessions')
                    ->where('activation_code', $activationCode)
                    ->where('expires_at', '>', now())
                    ->exists();
            } while ($exists && $attempts < 10);
        }

        $expiresAt = now()->addHours(2);

        // ۱. ذخیره دائمی و تضمین‌شده در جدول دیتابیس tv_sessions
        try {
            DB::table('tv_sessions')->updateOrInsert(
                ['session_code' => $sessionCode],
                [
                    'activation_code' => $activationCode,
                    'is_paired'       => false,
                    'paired_user_id'  => null,
                    'paired_username' => null,
                    'paired_token'    => null,
                    'expires_at'      => $expiresAt,
                    'updated_at'      => now(),
                    'created_at'      => now(),
                ]
            );
        } catch (\Throwable $e) {
            \Log::warning('registerSession DB save error: ' . $e->getMessage());
        }

        // ۲. ذخیره پشتیبان در لایه کش به مدت ۲ ساعت (۷۲۰۰ ثانیه)
        Cache::put('tv_session_' . $activationCode, $sessionCode, 7200);
        Cache::put('tv_code_for_' . $sessionCode, $activationCode, 7200);

        return response()->json([
            'success' => true,
            'activation_code' => $activationCode,
            'session_code' => $sessionCode
        ]);
    }

    /**
     * جفت‌سازی دستی تلویزیون با پین ۶ رقمی در پنل مدیریت طلافروش
     */
    public function pairWithCode(Request $request)
    {
        self::ensureTvSessionsTable();

        $rawCode = (string) $request->input('activation_code', '');
        $activationCode = self::normalizeDigits($rawCode);
        
        if (empty($activationCode)) {
            return response()->json(['success' => false, 'message' => 'کد فعال‌سازی ۶ رقمی را وارد کنید.'], 400);
        }

        $sessionCode = null;

        // ۱. اولویت اول: جستجو در جدول پایدار دیتابیس tv_sessions
        try {
            $dbSession = DB::table('tv_sessions')
                ->where('activation_code', $activationCode)
                ->where('expires_at', '>', now())
                ->latest('id')
                ->first();

            if ($dbSession) {
                $sessionCode = $dbSession->session_code;
            }
        } catch (\Throwable $e) {
            \Log::warning('pairWithCode DB query error: ' . $e->getMessage());
        }

        // ۲. اولویت دوم: جستجو در Cache لاراول
        if (!$sessionCode) {
            $sessionCode = Cache::get('tv_session_' . $activationCode);
        }

        // ۳. اگر سشن پیدا نشد، بررسی انقضا برای پیام خطای شفاف
        if (!$sessionCode) {
            try {
                $expiredCheck = DB::table('tv_sessions')
                    ->where('activation_code', $activationCode)
                    ->where('expires_at', '<=', now())
                    ->first();

                if ($expiredCheck) {
                    return response()->json([
                        'success' => false,
                        'message' => 'اعتبار این کد ۶ رقمی به پایان رسیده است. لطفاً صفحه تلویزیون را رفرش فرمایید تا کد جدید تولید شود.'
                    ], 404);
                }
            } catch (\Throwable $e) {}

            return response()->json([
                'success' => false,
                'message' => 'کد فعال‌سازی وارد شده یافت نشد. لطفاً کد ۶ رقمی نمایش داده شده روی تلویزیون را با دقت وارد کنید.'
            ], 404);
        }

        $user = auth()->user();

        // اطمینان از وجود display_token
        if (empty($user->display_token)) {
            $user->display_token = Str::random(32);
            $user->save();
        }

        // بروزرسانی قطعی در دیتابیس
        try {
            DB::table('tv_sessions')
                ->where('session_code', $sessionCode)
                ->update([
                    'is_paired'       => true,
                    'paired_user_id'  => $user->id,
                    'paired_username' => $user->username,
                    'paired_token'    => $user->display_token,
                    'updated_at'      => now(),
                ]);
        } catch (\Throwable $e) {
            \Log::warning('pairWithCode DB update error: ' . $e->getMessage());
        }

        // بروزرسانی در کش برای واکنش سریع صفحه تلویزیون
        Cache::put('pairing_' . $sessionCode, [
            'user_id'  => $user->id,
            'username' => $user->username,
            'token'    => $user->display_token
        ], 7200);

        // پاکسازی کش اولیه کد
        Cache::forget('tv_session_' . $activationCode);

        return response()->json([
            'success' => true,
            'message' => 'تلویزیون با موفقیت متصل شد و هم‌اکنون تابلوی اختصاصی شما را نمایش می‌دهد.'
        ]);
    }

    /**
     * ارسال کد فعال‌سازی یا لینک جفت‌سازی از طریق پیامک به موبایل طلافروش
     */
    public function sendMagicSms(Request $request, \App\Services\SmsService $smsService)
    {
        self::ensureTvSessionsTable();

        $phone = \App\Services\SmsService::normalizeMobile((string) $request->input('phone', ''));
        if (!preg_match('/^09[0-9]{9}$/', $phone)) {
            return response()->json(['success' => false, 'message' => 'شماره موبایل نامعتبر است. فرمت صحیح: ۰۹xxxxxxxxx'], 422);
        }

        $rawCode = (string) $request->input('activation_code', '');
        $activationCode = self::normalizeDigits($rawCode);

        $exists = false;
        try {
            $exists = DB::table('tv_sessions')
                ->where('activation_code', $activationCode)
                ->where('expires_at', '>', now())
                ->exists();
        } catch (\Throwable $e) {}

        if (!$exists && !Cache::has('tv_session_' . $activationCode)) {
            return response()->json(['success' => false, 'message' => 'کد فعال‌سازی تلویزیون نامعتبر یا منقضی شده است. لطفا صفحه تلویزیون را رفرش کنید.'], 404);
        }

        $result = $smsService->sendOtp($phone, $activationCode);
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'کد فعال‌سازی ۶ رقمی به شماره ' . $phone . ' پیامک شد.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'خطا در ارسال پیامک'
        ], 500);
    }

    /**
     * مسیر اتصال سریع و جادویی از طریق لینک کوتاه پیامک شده /p/{code}
     */
    public function pairMagicShortLink(Request $request, $code)
    {
        self::ensureTvSessionsTable();

        $cleanCode = self::normalizeDigits((string) $code);
        $sessionCode = null;

        try {
            $dbSession = DB::table('tv_sessions')
                ->where('activation_code', $cleanCode)
                ->where('expires_at', '>', now())
                ->latest('id')
                ->first();

            if ($dbSession) {
                $sessionCode = $dbSession->session_code;
            }
        } catch (\Throwable $e) {}

        if (!$sessionCode) {
            $sessionCode = Cache::get('tv_session_' . $cleanCode);
        }

        if (!$sessionCode) {
            return response("<div style='font-family: Tahoma, sans-serif; direction: rtl; text-align: center; padding: 80px 20px; background: #fff1f2; min-height: 100vh; display: flex; align-items: center; justify-content: center;'><div style='max-width: 440px; background: #fff; border: 1px solid #fecdd3; padding: 40px 30px; border-radius: 24px; box-shadow: 0 10px 25px -5px rgba(225,29,72,0.1);'><div style='font-size: 56px; margin-bottom: 20px;'>⏱️</div><h2 style='color: #9f1239; margin-bottom: 12px; font-weight: 800; font-size: 20px;'>کد اتصال منقضی شده است</h2><p style='color: #881337; font-size: 14px; line-height: 1.8; margin-bottom: 24px;'>کد اتصال این تلویزیون به پایان رسیده است. لطفاً صفحه مرورگر تلویزیون مغازه را یکبار بازخوانی (رفرش) کنید تا کد جدید ۶ رقمی ایجاد شود.</p><a href='/tv' style='display: inline-block; background: #be123c; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-weight: bold; font-size: 14px;'>مشاهده صفحه تلویزیون</a></div></div>", 404);
        }

        if (auth()->check()) {
            $user = auth()->user();

            if (empty($user->display_token)) {
                $user->display_token = Str::random(32);
                $user->save();
            }

            try {
                DB::table('tv_sessions')
                    ->where('session_code', $sessionCode)
                    ->update([
                        'is_paired'       => true,
                        'paired_user_id'  => $user->id,
                        'paired_username' => $user->username,
                        'paired_token'    => $user->display_token,
                        'updated_at'      => now(),
                    ]);
            } catch (\Throwable $e) {}

            Cache::put('pairing_' . $sessionCode, [
                'user_id' => $user->id,
                'username' => $user->username,
                'token' => $user->display_token
            ], 7200);

            Cache::forget('tv_session_' . $cleanCode);

            return redirect()->route('admin.dashboard')->with('success_pair', 'تلویزیون مغازه با موفقیت به تابلوی گالری شما متصل شد! 🎉');
        }

        // اگر کاربر هنوز لاگین نکرده باشد، کد را در سشن نگه می‌داریم و به صفحه لاگین می‌فرستیم
        session(['pending_pair_code' => $cleanCode]);
        return redirect()->route('admin.login')->with('info', 'جهت اتصال این تلویزیون به تابلوی اختصاصی، لطفاً ابتدا وارد حساب کاربری خود شوید.');
    }
}
