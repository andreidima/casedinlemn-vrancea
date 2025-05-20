<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'activ',
        'role',
        'telefon',
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
            'activ' => 'boolean',
        ];
    }

    public function path($action = 'show')
    {
        return match ($action) {
            'edit' => route('users.edit', $this->id),
            'destroy' => route('users.destroy', $this->id),
            default => route('users.show', $this->id),
        };
    }

    /** 1️⃣ Define the one-to-many relationship to stock-movements */
    public function miscariStoc(): HasMany
    {
        return $this->hasMany(MiscareStoc::class, 'user_id');
    }
    /**
     * 2️⃣ Prevent deletion if the user has any movements
     */
    protected static function booted()
    {
        static::deleting(function (User $user) {
            if ($user->miscariStoc()->exists()) {
                // returning false halts the delete operation
                return false;
            }
        });
    }
}
