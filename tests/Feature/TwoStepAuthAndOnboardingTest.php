<?php

namespace Tests\Feature;

use App\Models\DisplayItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TwoStepAuthAndOnboardingTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_and_register_routes_render_unified_tabbed_view(): void
    {
        $loginRes = $this->get('/admin/login');
        $loginRes->assertStatus(200);
        $loginRes->assertSee('ورود به پنل');
        $loginRes->assertSee('ثبت‌نام گالری');

        $registerRes = $this->get('/admin/register');
        $registerRes->assertStatus(200);
        $registerRes->assertSee('تأیید شماره تماس');
        $registerRes->assertSee('مشخصات گالری طلا');
    }

    public function test_two_step_registration_verifies_persian_otp_and_activates_onboarding(): void
    {
        Http::fake([
            '*' => Http::response(['success' => true], 200),
        ]);

        // Step 1-A: Request OTP
        $sendRes = $this->postJson(route('admin.register.send-otp'), [
            'phone' => '۰۹۱۲۳۴۵۶۷۸۹',
        ]);
        $sendRes->assertStatus(200)->assertJson(['success' => true]);

        $otpRow = DB::table('otp_verifications')->where('phone', '09123456789')->first();
        $this->assertNotNull($otpRow);

        // Convert OTP digits to Persian to verify Persian digit normalization
        $persianCode = str_replace(
            ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
            ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'],
            $otpRow->code
        );

        // Step 1-B: Verify wrong OTP fails cleanly
        $wrongRes = $this->postJson(route('admin.register.verify-otp'), [
            'phone' => '09123456789',
            'otp'   => '00000',
        ]);
        $wrongRes->assertStatus(422)->assertJson(['success' => false]);

        // Step 1-C: Verify valid Persian OTP succeeds without consuming record yet
        $verifyRes = $this->postJson(route('admin.register.verify-otp'), [
            'phone' => '۰۹۱۲۳۴۵۶۷۸۹',
            'otp'   => $persianCode,
        ]);
        $verifyRes->assertStatus(200)->assertJson([
            'success' => true,
            'phone'   => '09123456789',
        ]);

        // Step 2: Complete gallery details & password
        $regRes = $this->post(route('admin.register'), [
            'phone'    => '09123456789',
            'otp'      => $persianCode,
            'name'     => 'گالری طلای خورشید',
            'city'     => 'isfahan',
            'password' => '9876',
        ]);

        $regRes->assertRedirect(route('admin.dashboard'));
        $regRes->assertSessionHas('show_onboarding_tour', true);

        $user = User::where('phone', '09123456789')->first();
        $this->assertNotNull($user);
        $this->assertSame('گالری طلای خورشید', $user->name);
        $this->assertAuthenticatedAs($user);

        // Ensure no silver items were created for new gallery
        $this->assertSame(0, DisplayItem::where('user_id', $user->id)->whereIn('key', ['silver999', 'silver925'])->count());

        // Dashboard renders checklist + mobile-optimized onboarding & TV connection guide modal
        $dashRes = $this->actingAs($user)->get(route('admin.dashboard'));
        $dashRes->assertStatus(200);
        $dashRes->assertSee('راهنمای شروع سریع و راه‌اندازی تابلوی گالری');
        $dashRes->assertSee('آموزش و راه‌اندازی تابلوی');
        $dashRes->assertSee('talalive-guide-panel');
        $dashRes->assertSee('talalive-guide-footer');
        $dashRes->assertSee('talalive-tour-card');
        $dashRes->assertSee('hideFloatingPwaToast');
        $dashRes->assertSee('talalive.ir/tv');
        $dashRes->assertSee('اجرای تور نوری منوها');
    }

    public function test_send_register_otp_returns_already_registered_flag_for_existing_phone(): void
    {
        User::factory()->create([
            'phone'    => '09129998877',
            'username' => 'existing-gallery',
            'is_admin' => true,
        ]);

        $res = $this->postJson(route('admin.register.send-otp'), [
            'phone' => '09129998877',
        ]);

        $res->assertStatus(422)->assertJson([
            'success'            => false,
            'already_registered' => true,
            'phone'              => '09129998877',
        ]);
    }
}
