<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorQualificationAttachement extends Model
{
    use HasFactory;
    /*
     Tables Relationships
    */
    public function tutorQualification(){
        return $this->belongsTo(TutorQualification::class);
    }
}
