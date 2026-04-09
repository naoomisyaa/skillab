<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'gender',
        'phone_number',
        'bio',
        'profile_photo',
        'portfolio_pdf',
        'email',
        'password',
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

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class)->withTimestamps();
    }

    public function sentRequests(): HasMany
    {
        return $this->hasMany(CollaborationRequest::class, 'requester_id');
    }

    public function receivedRequests(): HasMany
    {
        return $this->hasMany(CollaborationRequest::class, 'requested_id');
    }

    public function neededSkills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'needed_skill_user')->withTimestamps();
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->profile_photo
            ? Storage::url($this->profile_photo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random&color=fff';
    }

    public function getPortfolioPdfUrlAttribute(): ?string
    {
        return $this->portfolio_pdf ? Storage::url($this->portfolio_pdf) : null;
    }

    public function getWhatsappUrlAttribute(): ?string
    {
        return $this->phone_number
            ? 'https://wa.me/' . preg_replace('/\D/', '', $this->phone_number)
            : null;
    }
}
