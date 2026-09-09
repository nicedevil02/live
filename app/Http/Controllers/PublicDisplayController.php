<?php

namespace App\Http\Controllers;

use App\Models\DisplayItem;
use App\Models\DisplaySetting;
use App\Models\ProductSlide;
use App\Services\MarketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

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
            return response("<div style='font-family: Tahoma, sans-serif; direction: rtl; text-align: center; padding: 100px 20px; background: #fffbeb; min-height: 100vh; display: flex; align-items: center; justify-content: center;'><div style='max-width: 500px; background: #fff; border: 1px solid #fef3c7; padding: 40px 30px; border-radius: 24px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);'><div style='font-size: 56px; margin-bottom: 24px;'>⏳</div><h2 style='color: #b45309; margin-bottom: 12px; font-weight: 800;'>حساب در انتظار تأیید</h2><p style='color: #78350f; font-size: 15px; line-height: 1.7; margin: 0;'>حساب کاربری این گالری هنوز توسط مدیریت سامانه تأیید نشده است. لطفاً منتظر بمانید یا با مدیریت تماس بگیرید.</p></div></div>", 403);
        }

        // بررسی انقضای زمانی حساب
        if ($user->expires_at && $user->expires_at->isPast() && !$user->is_super_admin) {
            return response("<div style='font-family: Tahoma, sans-serif; direction: rtl; text-align: center; padding: 100px 20px; background: #fef2f2; min-height: 100vh; display: flex; align-items: center; justify-content: center;'><div style='max-width: 500px; background: #fff; border: 1px solid #fecaca; padding: 40px 30px; border-radius: 24px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);'><div style='font-size: 56px; margin-bottom: 24px;'>⚠️</div><h2 style='color: #991b1b; margin-bottom: 12px; font-weight: 800;'>پایان اعتبار نمایشگر</h2><p style='color: #7f1d1d; font-size: 15px; line-height: 1.7; margin: 0;'>اعتبار زمانی استفاده از تابلوی این گالری به پایان رسیده است. لطفاً جهت تمدید اعتبار و فعال‌سازی مجدد با مدیریت سامانه تماس حاصل فرمایید.</p></div></div>", 402);
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

        $key = request()->query('key');
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

        return [
            'username'     => $user->username,
            'updatedAt'    => $lastFetch ? \Illuminate\Support\Carbon::parse($lastFetch)->toISOString() : now()->toISOString(),
            'apiTime'      => \Cache::get('market_api_last_time', '---'),
            'refreshIntervalSeconds' => $this->marketService->currentRefreshIntervalSeconds(),
            'displayItems' => $items,
            'priceFeed'    => $priceFeed,
            'products'     => $products,
            'settings'     => $settings,
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
     * چک کردن وضعیت جفت‌سازی توسط تلویزیون
     */
    public function checkPairingStatus($session_code)
    {
        $data = Cache::get('pairing_' . $session_code);
        if ($data) {
            return response()->json([
                'paired' => true,
                'username' => $data['username'],
                'display_token' => $data['token']
            ]);
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

        // انجام اتصال با متد POST و تایید توکن CSRF
        Cache::put('pairing_' . $session_code, [
            'user_id' => $user->id,
            'username' => $user->username,
            'token' => $user->display_token
        ], 300); // انقضا بعد از ۵ دقیقه

        if ($request->wantsJson() || $request->ajax() || $request->isJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تلویزیون با موفقیت متصل شد.'
            ]);
        }

        return response("<div style='font-family: Tahoma, sans-serif; direction: rtl; text-align: center; padding: 80px 20px; background: #f8fafc; min-height: 100vh; display: flex; align-items: center; justify-content: center;'><div style='max-width: 400px; background: #fff; border: 1px solid #e2e8f0; padding: 40px 30px; border-radius: 24px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);'><div style='font-size: 56px; margin-bottom: 24px;'>✅</div><h2 style='color: #0f172a; margin-bottom: 12px; font-weight: 800;'>اتصال با موفقیت انجام شد</h2><p style='color: #64748b; font-size: 15px; line-height: 1.7; margin: 0;'>تلویزیون شما با موفقیت به اکانت متصل شد و اکنون قیمت‌های طلای گالری شما را نمایش می‌دهد. می‌توانید این صفحه را در گوشی خود ببندید.</p></div></div>");
    }

    /**
     * ثبت سشن موقت تلویزیون در سرور
     */
    public function registerSession(Request $request)
    {
        $sessionCode = $request->input('session_code');
        $activationCode = strtoupper(trim($request->input('activation_code')));

        if (!$sessionCode || !$activationCode) {
            return response()->json(['success' => false, 'message' => 'اطلاعات ناقص است.'], 400);
        }

        // ذخیره جفت‌سازی موقت در کش برای ۱۰ دقیقه
        Cache::put('tv_session_' . $activationCode, $sessionCode, 600);

        return response()->json(['success' => true]);
    }

    /**
     * جفت‌سازی دستی تلویزیون با وارد کردن کد فعال‌سازی در پنل مدیریت
     */
    public function pairWithCode(Request $request)
    {
        $activationCode = strtoupper(trim($request->input('activation_code')));
        if (empty($activationCode)) {
            return response()->json(['success' => false, 'message' => 'کد فعال‌سازی را وارد کنید.'], 400);
        }

        $sessionCode = Cache::get('tv_session_' . $activationCode);
        if (!$sessionCode) {
            return response()->json(['success' => false, 'message' => 'کد فعال‌سازی نامعتبر یا منقضی شده است. لطفا تلویزیون را رفرش کنید تا کد جدید تولید شود.'], 404);
        }

        $user = auth()->user();

        // انجام فرآیند جفت‌سازی با استفاده از کش عمومی
        Cache::put('pairing_' . $sessionCode, [
            'user_id' => $user->id,
            'username' => $user->username,
            'token' => $user->display_token
        ], 300); // ۵ دقیقه انقضا

        // بعد از جفت‌سازی موفق، کد فعال‌سازی را پاک می‌کنیم
        Cache::forget('tv_session_' . $activationCode);

        return response()->json([
            'success' => true,
            'message' => 'تلویزیون با موفقیت متصل شد.'
        ]);
    }
}
