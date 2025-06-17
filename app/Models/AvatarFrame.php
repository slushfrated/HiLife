<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AvatarFrame extends Model
{
    protected $fillable = [
        'name',
        'image_path',
        'description',
        'achievement_id',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_avatar_frames')
            ->withTimestamps();
    }

    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }
} 