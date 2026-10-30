<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'department_code',
        'department_name',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function dispositions(): HasMany
    {
        return $this->hasMany(Disposition::class, 'to_department_id');
    }

    public function outgoingLetters(): HasMany
    {
        return $this->hasMany(OutgoingLetter::class);
    }
}
