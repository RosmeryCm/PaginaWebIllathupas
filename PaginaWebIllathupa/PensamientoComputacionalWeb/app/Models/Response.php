<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Response extends Model
{
    protected $fillable = ['user_id', 'activity_id', 'question_id', 'selected_option', 'is_correct'];
    protected function casts(): array { return ['is_correct' => 'boolean']; }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function activity(): BelongsTo { return $this->belongsTo(Activity::class); }
    public function question(): BelongsTo { return $this->belongsTo(Question::class); }
}
