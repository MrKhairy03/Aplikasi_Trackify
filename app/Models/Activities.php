<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activities extends Model
{
    protected $table = 'activities';

    protected $fillable = [
        'user_id',
        'action',
        'created_at',
        'updated_at',
    ];

    /**
     * Relasi ke user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
