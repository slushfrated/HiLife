<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Title extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color',
        'achievement_id',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_titles')
            ->withPivot('is_selected')
            ->withTimestamps();
    }

    public function achievement(): BelongsTo
    {
        return $this->belongsTo(Achievement::class);
    }
} 