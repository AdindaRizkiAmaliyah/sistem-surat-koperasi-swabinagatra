<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disposition extends Model
{
    protected $fillable = [
        'incoming_letter_id',
        'from_user_id',
        'to_user_id',
        'to_department_id',
        'instruction',
        'notes',
        'deadline',
        'status',
        'read_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'read_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function incomingLetter(): BelongsTo
    {
        return $this->belongsTo(IncomingLetter::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'to_department_id');
    }
}
