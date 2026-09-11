<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'username',
        'phone',
        'phone_verified_at',
        'password',
        'display_token',
        'is_admin',
        'is_super_admin',
        'is_approved',
        'expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_super_admin' => 'boolean',
            'is_approved' => 'boolean',
            'expires_at' => 'datetime',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    public function isSubscribed(): bool
    {
        if ($this->is_super_admin || !$this->expires_at) {
            return false;
        }

        // ۱. اگر فاصله تاریخ ثبت‌نام تا تاریخ انقضا بیش از ۱۵ روز باشد، قطعا اشتراک خریداری شده است
        if ($this->created_at && $this->created_at->diffInDays($this->expires_at, false) > 15) {
            return true;
        }

        // ۲. اگر روزهای باقی‌مانده بیش از ۱۴ روز باشد (مانند تمدید ۱ ماهه، ۳ ماهه یا ۱ ساله)
        if ($this->trialDaysRemaining() > 14) {
            return true;
        }

        return false;
    }

    public function isTrial(): bool
    {
        if ($this->is_super_admin || !$this->expires_at) {
            return false;
        }

        return !$this->isSubscribed();
    }

    public function trialDaysRemaining(): int
    {
        if (!$this->expires_at) return 0;
        return max(0, (int) now()->diffInDays($this->expires_at, false));
    }

    /**
     * تبدیل تاریخ به فرمت شمسی (جلالی)
     */
    public static function toJalali(?\DateTimeInterface $date, bool $withTime = true): string
    {
        if (!$date) return 'نامحدود';

        $gy = (int) $date->format('Y');
        $gm = (int) $date->format('m');
        $gd = (int) $date->format('d');

        $g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = 355666 + (365 * $gy) + ((int)(($gy2 + 3) / 4)) - ((int)(($gy2 + 99) / 100)) + ((int)(($gy2 + 399) / 400)) + $gd + $g_d_m[$gm - 1];
        $jy = -1595 + (33 * ((int)($days / 12053)));
        $days %= 12053;
        $jy += 4 * ((int)($days / 1461));
        $days %= 1461;
        if ($days > 365) {
            $jy += (int)(($days - 1) / 365);
            $days = ($days - 1) % 365;
        }
        if ($days < 186) {
            $jm = 1 + (int)($days / 31);
            $jd = 1 + ($days % 31);
        } else {
            $jm = 7 + (int)(($days - 186) / 30);
            $jd = 1 + (($days - 186) % 30);
        }

        $formatted = sprintf('%04d/%02d/%02d', $jy, $jm, $jd);
        if ($withTime) {
            $formatted .= ' ' . $date->format('H:i');
        }

        return $formatted;
    }

    public function getShamsiExpiresAtAttribute(): string
    {
        return self::toJalali($this->expires_at);
    }

    public function displaySetting()
    {
        return $this->hasOne(DisplaySetting::class, 'user_id');
    }

    public function formulaConfig()
    {
        return $this->hasOne(FormulaConfig::class, 'user_id');
    }

    public function displayItems()
    {
        return $this->hasMany(DisplayItem::class, 'user_id');
    }

    public function productSlides()
    {
        return $this->hasMany(ProductSlide::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id')->latest();
    }
}
