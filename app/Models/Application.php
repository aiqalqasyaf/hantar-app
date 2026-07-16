<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFactory> */
    use HasFactory;

     protected $fillable = [
        'user_id', 'company', 'role', 'status', 'applied_at', 'job_url', 'notes',
    ];

    protected $casts = [
        'applied_at' => 'date',
    ];

    protected $appends = ['applied_at_formatted'];

    protected function appliedAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->applied_at?->format('d-m-Y'),
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
