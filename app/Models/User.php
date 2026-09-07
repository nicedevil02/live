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
}
