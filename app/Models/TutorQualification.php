<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorQualification extends Model
{
    use HasFactory;
    /*
     Tables Relationships
    */
    public function tutorQualificationAttachement(){
        return $this->hasmany(TutorQualificationAttachement::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
}
