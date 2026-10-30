<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LetterCategory extends Model
{
    protected $fillable = [
        'category_name',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function incomingLetters(): HasMany
    {
        return $this->hasMany(IncomingLetter::class, 'category_id');
    }

    public function outgoingLetters(): HasMany
    {
        return $this->hasMany(OutgoingLetter::class, 'category_id');
    }
}
