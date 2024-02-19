<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    /*
     Tables Relationships
    */
    public function subjects(){
        return $this->hasmany(Subject::class);
    }
    public function tutorSubjectOffer(){
        return $this->hasmany(TutorSubjectOffer::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
    public function level(){
        return $this->hasMany(Subject::class,'levels');
    }
}
