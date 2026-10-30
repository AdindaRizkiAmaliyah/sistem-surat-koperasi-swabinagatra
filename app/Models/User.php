<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'department_id',
    'is_active',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
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
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relasi ke Departemen.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Relasi ke Surat Masuk.
     */
    public function incomingLetters(): HasMany
    {
        return $this->hasMany(IncomingLetter::class, 'created_by');
    }

    /**
     * Relasi ke Surat Keluar.
     */
    public function outgoingLetters(): HasMany
    {
        return $this->hasMany(OutgoingLetter::class, 'created_by');
    }

    /**
     * Relasi ke Disposisi yang Dikirim.
     */
    public function sentDispositions(): HasMany
    {
        return $this->hasMany(Disposition::class, 'from_user_id');
    }

    /**
     * Relasi ke Disposisi yang Diterima.
     */
    public function receivedDispositions(): HasMany
    {
        return $this->hasMany(Disposition::class, 'to_user_id');
    }

    /**
     * Relasi ke Lampiran yang Diunggah.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(LetterAttachment::class, 'uploaded_by');
    }

    /**
     * Relasi ke Riwayat Aktivitas.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }
}
