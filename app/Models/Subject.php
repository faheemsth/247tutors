<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $guarded = [];
    /*
     Tables Relationships
    */
    public function creditHours(){
        return $this->hasmany(CreditHour::class);
    }
    public function tutorSubjectOffer(){
        return $this->hasmany(TutorSubjectOffer::class,'subject_id');
    }
    public function tutorReview(){
        return $this->hasmany(TutorReview::class);
    }
    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function level(){
        return $this->belongsTo(Level::class,'levels');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class,'subject');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class,'subject_id');
    }
}
