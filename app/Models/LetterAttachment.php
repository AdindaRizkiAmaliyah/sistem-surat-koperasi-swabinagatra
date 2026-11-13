<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LetterAttachment extends Model
{
    protected $fillable = [
        'letter_type',
        'letter_id',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
        'uploaded_by',
        'public_id',
        'public_token',
        'is_public',
        'published_at',
        'revoked_at',
        'file_hash',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'is_public' => 'boolean',
            'published_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    public function letter(): MorphTo
    {
        return $this->morphTo();
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
