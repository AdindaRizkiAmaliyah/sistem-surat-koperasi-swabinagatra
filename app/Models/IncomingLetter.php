<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class IncomingLetter extends Model
{
    protected $fillable = [
        'agenda_number',
        'letter_number',
        'category_id',
        'sender',
        'subject',
        'letter_date',
        'received_date',
        'summary',
        'destination',
        'status',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'letter_date' => 'date',
            'received_date' => 'date',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(LetterCategory::class, 'category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function dispositions(): HasMany
    {
        return $this->hasMany(Disposition::class);
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(LetterAttachment::class, 'letter');
    }
}
