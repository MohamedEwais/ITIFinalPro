<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Skill extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class,"User");
    }
    // public function skill()
    // {
    //     return $this->belongsTo(Skill::class, 'skill_id');
    // }
}

