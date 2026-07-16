<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillAnalysis extends Model
{
     protected $fillable = [
        'user_id', 'application_id', 'resume_text', 'score',
        'matched_skills', 'missing_skills', 'recommendations', 'summary',
    ];

    protected $casts = [
        'matched_skills' => 'array',
        'missing_skills' => 'array',
        'recommendations' => 'array',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
