<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class OutgoingLetter extends Model
{
    protected $fillable = [
        'letter_number',
        'category_id',
        'department_id',
        'recipient',
        'subject',
        'letter_date',
        'sent_date',
        'summary',
        'status',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'letter_date' => 'date',
            'sent_date' => 'date',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(LetterCategory::class, 'category_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(LetterAttachment::class, 'letter');
    }
}
