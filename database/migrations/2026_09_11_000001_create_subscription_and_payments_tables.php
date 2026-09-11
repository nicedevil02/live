<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ۱. جدول پلن‌های اشتراک
        if (!Schema::hasTable('subscription_plans')) {
            Schema::create('subscription_plans', function (Blueprint $table) {
                $table->id();
                $table->string('name');                      // نام پلن (مثلا: اشتراک ۱ ساله الماس)
                $table->string('slug')->unique();            // شناسه لاتین (مثلا: 12-months)
                $table->integer('duration_days');            // مدت زمان به روز (مثلا: 365)
                $table->unsignedBigInteger('price');         // قیمت پرداختی به تومان (مثلا: 3990000)
                $table->unsignedBigInteger('original_price')->nullable(); // قیمت قبل از تخفیف برای بازارگرم‌کنی (مثلا: 8280000)
                $table->json('features')->nullable();        // ویژگی‌ها به صورت آرایه JSON
                $table->string('badge_text')->nullable();    // متن نشان (مثلا: بیشترین صرفه اقتصادی - محبوب‌ترین)
                $table->boolean('is_popular')->default(false); // برجسته‌سازی به عنوان پلن پیشنهادی
                $table->boolean('is_active')->default(true); // وضعیت فعال بودن پلن
                $table->integer('sort_order')->default(0);   // ترتیب نمایش
                $table->timestamps();
            });

            // ثبت پلن‌های پیش‌فرض اولیه با قیمت‌های بازارگرم‌کنی
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
        }

        // ۲. جدول کدهای تخفیف
        if (!Schema::hasTable('coupons')) {
            Schema::create('coupons', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();            // کد تخفیف (مثلا: TALALIVE10)
                $table->string('title')->nullable();         // عنوان تخفیف (مثلا: تخفیف افتتاحیه)
                $table->enum('type', ['percent', 'fixed'])->default('percent'); // نوع تخفیف (درصدی یا مبلغ ثابت)
                $table->unsignedBigInteger('value');         // مقدار تخفیف (درصد یا تومان)
                $table->unsignedBigInteger('min_amount')->default(0); // حداقل مبلغ سفارش به تومان
                $table->unsignedBigInteger('max_discount')->nullable(); // سقف تخفیف برای درصدی به تومان
                $table->integer('usage_limit')->nullable();  // حداکثر دفعات استفاده کلی
                $table->integer('used_count')->default(0);   // تعداد دفعات استفاده شده
                $table->timestamp('expires_at')->nullable(); // تاریخ انقضای کد
                $table->boolean('is_active')->default(true); // وضعیت فعال بودن
                $table->timestamps();
            });

            // کد تخفیف نمونه
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
        }

        // ۳. جدول تراکنش‌ها و پرداخت‌های مالی
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->string('invoice_no')->unique();      // شماره فاکتور رسمی (مثلا: TL-260911-1023)
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('plan_id')->nullable()->constrained('subscription_plans')->onDelete('set null');
                $table->foreignId('coupon_id')->nullable()->constrained('coupons')->onDelete('set null');
                $table->unsignedBigInteger('amount');        // مبلغ نهایی پرداخت شده به تومان
                $table->unsignedBigInteger('discount_amount')->default(0); // مبلغ تخفیف کسر شده به تومان
                $table->string('gateway', 30)->default('zarinpal'); // درگاه پرداخت: zarinpal, zibal, manual
                $table->string('transaction_id')->nullable()->index(); // شناسه تراکنش درگاه (Authority یا TrackId)
                $table->string('reference_id')->nullable()->index();   // کد پیگیری نهایی شاپرک / شماره سند
                $table->string('card_pan', 30)->nullable();  // شماره کارت ماسک شده (مثلا: 6037****1234)
                $table->enum('status', ['pending', 'paid', 'failed', 'canceled'])->default('pending')->index();
                $table->timestamp('paid_at')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('description')->nullable();
                $table->json('metadata')->nullable();        // اطلاعات تکمیلی وب‌سرویس بانک
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('subscription_plans');
    }
};
