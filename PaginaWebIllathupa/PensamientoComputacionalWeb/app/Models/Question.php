<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = ['activity_id', 'statement', 'options', 'correct_option', 'feedback_correct', 'feedback_incorrect'];
    protected function casts(): array { return ['options' => 'array']; }
    public function activity(): BelongsTo { return $this->belongsTo(Activity::class); }
}
