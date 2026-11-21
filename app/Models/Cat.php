<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'age_text', 'sex', 'description', 'adoption_status', 'is_published', 'photo_path'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}
