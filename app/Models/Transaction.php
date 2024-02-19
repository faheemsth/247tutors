<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    /*
     Tables Relationships
    */
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function tutor(){
        return $this->belongsTo(User::class,'tutor_id');
    }
    public function sender(){
        return $this->belongsTo(Chat::class,'reciver_id');
    }
    public function tutorSubjectOffer() {
        return $this->belongsTo(TutorSubjectOffer::class, 'subject', 'subject_id');
    }

    public function subjects() {
        return $this->belongsTo(subject::class, 'subject');
    }
}
