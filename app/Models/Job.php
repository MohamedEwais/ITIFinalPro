<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = ['proTitle', 'description', 'skills','status','budget', 'duration','image','user_id', 'location_id', 'created_date'];
   
   

    public $timestamps = true;

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

}
