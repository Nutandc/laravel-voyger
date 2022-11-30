<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'skills'
    ];
    use HasFactory;

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_has_skills');
    }
}
