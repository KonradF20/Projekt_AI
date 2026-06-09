<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
     * Relacja: Użytkownik posiada wiele planów podróży.
     */
    public function travelPlans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TravelPlan::class);
    }

    // --- FUNKCJA SPRAWDZAJĄCA, CZY UŻYTKOWNIK JEST ADMINEM ---
    public function isAdmin(): bool
    {
        return in_array($this->email, [
            'admin@test.pl',
        ]);
    }

    // --- FUNKCJA ZABEZPIECZAJĄCA PANEL FILAMENT ---
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }
}
