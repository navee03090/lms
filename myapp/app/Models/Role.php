<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function isAdmin(): bool
    {
        return $this->slug === 'admin';
    }

    public function isInstructor(): bool
    {
        return $this->slug === 'instructor';
    }

    public function isStudent(): bool
    {
        return $this->slug === 'student';
    }
}
