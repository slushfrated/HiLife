<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'type',
        'target',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('unlocked_at', 'progress')
            ->withTimestamps();
    }
}
