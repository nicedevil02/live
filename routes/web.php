<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DisplaySettingController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\PublicDisplayController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SourceController;
use App\Http\Controllers\Admin\FormulaController;
use App\Http\Controllers\Admin\DisplayItemController;
use App\Http\Controllers\Admin\UserController;

// ریشه سایت → نمایش صفحه جفت‌سازی تلویزیون (یا ریدایرکت به داشبورد در صورت لاگین)
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return resolve(App\Http\Controllers\PublicDisplayController::class)->showPairingScreen();
});

// مسیر جفت‌سازی تلویزیون
Route::get('/tv', [PublicDisplayController::class, 'showPairingScreen'])->name('display.tv');

// احراز هویت
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    // ثبت نام طلافروشی جدید
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register/send-otp', [AuthController::class, 'sendRegisterOtp'])->name('register.send-otp')->middleware('throttle:5,1');
    Route::post('/register', [AuthController::class, 'register']);
});

// پنل مدیریت محافظت شده
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // داشبورد
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/pair-code', [PublicDisplayController::class, 'pairWithCode'])->middleware('throttle:5,1')->name('pair-code');

    // اجرای امن مایگریشن‌ها از طریق مرورگر (مخصوص سوپرادمین)
    Route::get('/run-migrations', function () {
        if (!auth()->user()->is_super_admin) {
            abort(403, 'دسترسی غیرمجاز');
        }
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            $output = \Illuminate\Support\Facades\Artisan::output();
            return response("<div style='font-family: Tahoma, sans-serif; direction: rtl; padding: 30px; background: #0f172a; color: #38bdf8; border-radius: 20px; margin: 40px auto; max-width: 700px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3);'>
                <h3 style='color: #34d399; margin-top: 0;'>✅ عملیات پایگاه داده با موفقیت انجام شد:</h3>
                <pre style='background: #1e293b; color: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #334155; overflow-x: auto; font-family: monospace; font-size: 14px; text-align: left;' dir='ltr'>" . ($output ?: "Nothing to migrate. (دیتابیس بروز است)") . "</pre>
                <br>
                <a href='" . route('admin.dashboard') . "' style='color: #fbbf24; text-decoration: none; font-weight: bold; font-size: 15px;'>← بازگشت به داشبورد مدیریت</a>
            </div>");
        } catch (\Exception $e) {
            return response("<div style='font-family: Tahoma, sans-serif; direction: rtl; padding: 30px; background: #0f172a; color: #f87171; border-radius: 20px; margin: 40px auto; max-width: 700px;'>
                <h3 style='color: #f87171; margin-top: 0;'>❌ خطا در اجرای مایگریشن دیتابیس:</h3>
                <pre style='background: #1e293b; color: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #334155; overflow-x: auto; font-family: monospace; font-size: 14px; text-align: left;' dir='ltr'>" . $e->getMessage() . "</pre>
            </div>", 500);
        }
    })->name('run-migrations');

    // پاک کردن کش‌های سیستم از طریق مرورگر (مخصوص سوپرادمین)
    Route::get('/clear-cache', function () {
        if (!auth()->user()->is_super_admin) {
            abort(403, 'دسترسی غیرمجاز');
        }
        try {
            cache()->forget('smsir_default_line');
            cache()->forget('smsir_default_template_id');
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            \Illuminate\Support\Facades\Artisan::call('route:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            return response("<div style='font-family: Tahoma, sans-serif; direction: rtl; padding: 30px; background: #0f172a; color: #38bdf8; border-radius: 20px; margin: 40px auto; max-width: 700px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3);'>
                <h3 style='color: #34d399; margin-top: 0;'>✅ تمامی کش‌های سیستم با موفقیت پاک شدند:</h3>
                <ul style='color: #f8fafc; font-size: 14px; line-height: 1.8;'>
                    <li>کش عمومی برنامه (Cache) پاک شد.</li>
                    <li>کش خطوط و قالب‌های پیامکی SMS.ir بازنشانی شد.</li>
                    <li>تنظیمات پیکربندی (Config) پاک شد.</li>
                    <li>مسیرها و روت‌های کش شده (Routes) پاک شد.</li>
                    <li>تمپلیت‌های کامپایل شده (Views) پاک شد.</li>
                </ul>
                <br>
                <a href='" . route('admin.dashboard') . "' style='color: #fbbf24; text-decoration: none; font-weight: bold; font-size: 15px;'>← بازگشت به داشبورد مدیریت</a>
            </div>");
        } catch (\Exception $e) {
            return response("<div style='font-family: Tahoma, sans-serif; direction: rtl; padding: 30px; background: #0f172a; color: #f87171; border-radius: 20px; margin: 40px auto; max-width: 700px;'>
                <h3 style='color: #f87171; margin-top: 0;'>❌ خطا در پاکسازی کش:</h3>
                <pre style='background: #1e293b; color: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #334155; overflow-x: auto; font-family: monospace; font-size: 14px; text-align: left;' dir='ltr'>" . $e->getMessage() . "</pre>
            </div>", 500);
        }
    })->name('clear-cache');

    // بررسی وضعیت درگاه پیامک، خطوط فعال و تست ارسال (مخصوص سوپرادمین)
    Route::get('/sms-status', function (\App\Services\SmsService $smsService) {
        if (!auth()->user()->is_super_admin) {
            abort(403, 'دسترسی غیرمجاز');
        }
        $diag = $smsService->getDiagnostics();
        $testResult = null;
        if (request()->has('test')) {
            $testMobile = request('test') ?: '09187009064';
            $testResult = $smsService->sendOtp($testMobile, (string) rand(11111, 99999));
        }
        return view('admin.sms-status', compact('diag', 'testResult'));
    })->name('sms-status');

    // مدیریت کاربران (سوپر ادمین)
    Route::middleware(['super_admin'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/{id}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::post('/users/{id}/extend', [UserController::class, 'extend'])->name('users.extend');
        Route::post('/users/{id}/change-password', [UserController::class, 'changePassword'])->name('users.password');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // محصولات (ویترین)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{product}/images', [ProductController::class, 'addImageUrl'])->name('products.addImageUrl');
    Route::post('/products/{product}/images/upload', [ProductController::class, 'uploadImageFile'])->name('products.uploadImageFile');
    Route::delete('/products/{product}/images/{image}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
    Route::get('/sources', [SourceController::class, 'index'])->name('sources');
    Route::put('/sources/{key}', [SourceController::class, 'update'])->name('sources.update');
    Route::post('/sources/{key}/test', [SourceController::class, 'test'])->name('sources.test');
    Route::get('/formulas', [FormulaController::class, 'index'])->name('formulas');
    Route::put('/formulas/buy', [FormulaController::class, 'update'])->name('formulas.update');
    Route::get('/formulas/global-18k-preview', [FormulaController::class, 'global18kPreview'])->name('formulas.preview');
    Route::get('/display-items', [DisplayItemController::class, 'index'])->name('display-items');
    Route::put('/display-items', [DisplayItemController::class, 'update'])->name('display-items.update');
    Route::get('/display-control', [DisplaySettingController::class, 'index'])->name('display-control');
    Route::put('/display-settings', [DisplaySettingController::class, 'update'])->name('display-settings.update');
    Route::post('/publish', [DisplaySettingController::class, 'publish'])->name('publish');
    Route::get('/logs', [LogController::class, 'index'])->name('logs');
    Route::get('/security', [AuthController::class, 'editSecurity'])->name('security');
    Route::put('/security', [AuthController::class, 'updateSecurity'])->name('security.update');
    
    // جفت‌سازی تلویزیون هوشمند با گوشی (نیازمند تایید کاربر با متد POST)
    Route::match(['get', 'post'], '/pair/{session_code}', [PublicDisplayController::class, 'pairDevice'])->name('pair');
});

// صفحات فرود و سئوی هدفمند طلالایو (Pillar Pages & B2B SEO)
Route::get('/smart-gold-board', [PublicPageController::class, 'smartGoldBoard'])->name('public.smart-gold-board');
Route::get('/tv-setup-guide', [PublicPageController::class, 'tvSetupGuide'])->name('public.tv-setup-guide');
Route::get('/gold-calculator', [PublicPageController::class, 'goldCalculator'])->name('public.gold-calculator');
Route::get('/guides', [PublicPageController::class, 'guidesIndex'])->name('public.guides');

// صفحه نمایشگر اختصاصی مغازه (باید آخرین مسیر باشد تا با سایر آدرس‌ها تداخل نداشته باشد)
Route::get('/{username}', [PublicDisplayController::class, 'show'])->name('display.live');