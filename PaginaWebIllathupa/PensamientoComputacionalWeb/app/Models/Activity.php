<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    protected $fillable = ['title', 'description', 'dimension', 'instructions', 'published'];
    protected function casts(): array { return ['published' => 'boolean']; }
    public function questions(): HasMany { return $this->hasMany(Question::class); }
    public function results(): HasMany { return $this->hasMany(Result::class); }
}
