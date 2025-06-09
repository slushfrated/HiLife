<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'primary_color',
        'secondary_color',
        'background_color',
        'text_color',
        'preview_image',
        'unlock_requirement',
    ];
} 