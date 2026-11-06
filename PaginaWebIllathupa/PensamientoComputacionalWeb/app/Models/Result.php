<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    protected $fillable = ['user_id', 'activity_id', 'score', 'total_questions', 'percentage', 'completed_at'];
    protected function casts(): array { return ['completed_at' => 'datetime']; }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function activity(): BelongsTo { return $this->belongsTo(Activity::class); }
}
