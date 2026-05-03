<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DisplaySettingController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\PublicDisplayController;
use App\Http\Middleware\RequestAuditMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SourceController;
use App\Http\Controllers\Admin\FormulaController;
use App\Http\Controllers\Admin\DisplayItemController;

Route::middleware([RequestAuditMiddleware::class])->group(function () {
    // ریشه سایت → صفحه اصلی نمایشی
    Route::get('/', [PublicDisplayController::class, 'show'])->name('display.live');

    // احراز هویت
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    // پنل مدیریت محافظت شده
    Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
        // داشبورد
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
        // مابقی مسیرها بعداً اضافه می‌شوند...
    });
});