<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_uid',
        'employee_id',
        'user_type',
        'status',
        'avatar_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
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
        ];
    }

    /**
     * Ensure email addresses are stored in lowercase for case-insensitive lookups.
     */
    protected function email(): Attribute
    {
        return Attribute::make(
            set: static fn (?string $value): ?string => $value !== null ? strtolower($value) : null,
        );
    }

    public function address(): HasOne
    {
        return $this->hasOne(UserAddress::class);
    }

    public function mobileNumbers(): HasMany
    {
        return $this->hasMany(UserMobileNumber::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'dealer_id');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class, 'dealer_id');
    }

    public function getAvatarUrl(): ?string
    {
        if (! $this->avatar_path) {
            return null;
        }

        if (! Storage::disk('public')->exists($this->avatar_path)) {
            return null;
        }

        return asset('storage/' . ltrim($this->avatar_path, '/'));
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->getAvatarUrl();
    }

}
