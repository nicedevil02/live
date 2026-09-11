<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected string $token;
    protected string $endpoint;
    protected int $template;
    protected string $adminPhone;

    public function __construct()
    {
        $this->token      = config('services.s_api.token', 'YHXBYFzp8RGLVUgspjKKtwrm/h4WkEKr2zRHnmv2t3auZQKdvKmz4hdD6H8WwQoYYg6ONc9bEO6pMf5rnLoo4y1d5G3uFr1FmOUs+kzq0Os=');
        $this->endpoint   = config('services.s_api.endpoint', 'https://s.api.ir/api/sw1/SmsOTP');
        $this->template   = (int) config('services.s_api.template', 1);
        $this->adminPhone = config('services.s_api.admin_phone', '09187009064');
    }

    /**
     * استانداردسازی شماره موبایل به فرمت 09xxxxxxxxx
     */
    public static function normalizeMobile(string $input): string
    {
        // تبدیل اعداد فارسی و عربی به انگلیسی
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $clean   = str_replace($persian, $english, trim($input));

        // حذف هر کاراکتر غیر عددی به جز مثبت
        $digits = preg_replace('/[^\d]/', '', $clean);

        if (str_starts_with($digits, '00989')) {
            $digits = '0' . substr($digits, 4);
        } elseif (str_starts_with($digits, '989')) {
            $digits = '0' . substr($digits, 2);
        } elseif (str_starts_with($digits, '9') && strlen($digits) === 10) {
            $digits = '0' . $digits;
        }

        return $digits;
    }

    /**
     * ارسال کد یکبار مصرف (OTP) از درگاه s.api.ir با خط خدماتی اشتراکی
     */
    public function sendOtp(string $mobile, string $code): array
    {
        $mobile = self::normalizeMobile($mobile);

        if (empty($this->token)) {
            Log::warning("SmsService: API Token is empty. OTP for {$mobile} is {$code}");
            return ['success' => false, 'message' => 'توکن وب‌سرویس پیامک تنظیم نشده است.'];
        }

        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept'        => 'application/json',
                ])->timeout(12)->post($this->endpoint, [
                    'code'     => (string) $code,
                    'mobile'   => $mobile,
                    'template' => $this->template,
                ]);

            $result = $response->json();
            $isSuccess = $response->successful() && !empty($result['success']);

            $this->logSms('otp_s_api_ir', $mobile, [
                'status'   => $isSuccess ? 'success' : 'failed',
                'code'     => $code,
                'response' => $result,
            ]);

            if ($isSuccess) {
                return ['success' => true, 'message' => 'کد تایید با موفقیت پیامک شد.'];
            }

            $errorMessage = $result['message'] ?? 'خطا در ارسال پیامک از طریق درگاه s.api.ir.';
            Log::error("SmsService OTP failed for {$mobile}: " . json_encode($result, JSON_UNESCAPED_UNICODE));

            return ['success' => false, 'message' => 'پیام درگاه پیامک: ' . $errorMessage, 'raw' => $result];

        } catch (\Throwable $e) {
            Log::error("SmsService Exception: " . $e->getMessage());
            return ['success' => false, 'message' => 'خطا در ارتباط با سرور پیامک: ' . $e->getMessage()];
        }
    }

    /**
     * ارسال نوتیفیکیشن پیامکی به مدیریت هنگام ثبت نام طلافروشی جدید
     */
    public function notifyAdminNewRegistration(string $shopName, string $mobile): bool
    {
        $adminMobile = self::normalizeMobile($this->adminPhone);
        if (empty($adminMobile) || empty($this->token)) {
            return false;
        }

        $this->logSms('admin_alert_event', $adminMobile, [
            'shop'     => $shopName,
            'customer' => $mobile,
            'note'     => 'طلافروشی جدید ثبت نام کرد و تست ۱۴ روزه فعال شد.',
        ]);

        return true;
    }

    /**
     * ثبت لاگ و اطلاع‌رسانی پیامکی لینک اختصاصی تابلو به طلافروش
     */
    public function sendWelcomeSms(string $mobile, string $shopName, string $slug): bool
    {
        $mobile = self::normalizeMobile($mobile);
        if (empty($mobile)) {
            return false;
        }

        $this->logSms('customer_welcome_event', $mobile, [
            'shop' => $shopName,
            'slug' => $slug,
            'url'  => 'https://talalive.ir/' . $slug,
            'note' => 'لینک تابلوی اختصاصی برای طلافروش ثبت شد.',
        ]);

        return true;
    }

    /**
     * دریافت وضعیت جامع اتصال به درگاه s.api.ir
     */
    public function getDiagnostics(): array
    {
        return [
            'provider'      => 's.api.ir (SmsOTP)',
            'endpoint'      => $this->endpoint,
            'token_active'  => !empty($this->token),
            'template'      => $this->template,
            'admin_phone'   => $this->adminPhone,
            'token_preview' => substr($this->token, 0, 15) . '...' . substr($this->token, -8),
        ];
    }

    /**
     * ثبت لاگ سیستمی ارسال پیامک
     */
    protected function logSms(string $type, string $target, array $payload): void
    {
        try {
            AuditLog::create([
                'id'          => 'sms-' . now()->timestamp . rand(100, 999),
                'actor'       => 'system',
                'action'      => $type,
                'entity_type' => 'sms_notification',
                'entity_id'   => $target,
                'payload'     => json_encode($payload, JSON_UNESCAPED_UNICODE),
                'created_at'  => now(),
            ]);
        } catch (\Throwable $e) {
            // نادیده گرفتن خطای لاگ جهت عدم توقف عملیات اصلی
        }
    }

    /**
     * ارسال پیامک تأیید پرداخت و تمدید اشتراک به طلافروش
     */
    public function sendPaymentSuccess(string $mobile, string $planName, int $amount, string $refId, string $expiryDate): bool
    {
        $mobile = self::normalizeMobile($mobile);
        if (empty($mobile)) return false;

        $amountFormatted = number_format($amount);
        $this->logSms('payment_success_sms', $mobile, [
            'plan'        => $planName,
            'amount'      => $amountFormatted,
            'ref_id'      => $refId,
            'expiry_date' => $expiryDate,
            'message'     => "طلافروش گرامی، پرداخت {$amountFormatted} تومان بابت {$planName} با پیگیری {$refId} انجام شد. اعتبار تابلوی شما تا {$expiryDate} تمدید گردید. طلالایو",
        ]);

        return true;
    }

    /**
     * اطلاع‌رسانی خرید اشتراک به مدیر سامانه
     */
    public function notifyAdminPayment(string $customerName, string $phone, string $planName, int $amount, string $refId): bool
    {
        $adminPhone = self::normalizeMobile($this->adminPhone);
        if (empty($adminPhone)) return false;

        $amountFormatted = number_format($amount);
        $this->logSms('admin_payment_notification', $adminPhone, [
            'customer' => $customerName,
            'phone'    => $phone,
            'plan'     => $planName,
            'amount'   => $amountFormatted,
            'ref_id'   => $refId,
            'message'  => "مدیر گرامی، خرید جدید در طلالایو ثبت شد: {$customerName} ({$phone}) - پلن: {$planName} - مبلغ: {$amountFormatted} تومان - پیگیری: {$refId}",
        ]);

        return true;
    }
}
