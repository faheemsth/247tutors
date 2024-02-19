<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
     protected $appends =['booking_fee'];
    protected $fillable = [
        'request_refound',
        'booking_rescheduled_count',
    ];



    /*
     Tables Relationships
    */

    // public function tutorSubjectOffer() {
    //     return $this->belongsTo(TutorSubjectOffer::class, 'subject', 'subject_id');
    // }

    public function users(){
        return $this->belongsTo(User::class);
    }
    public function student(){
        return $this->belongsTo(User::class,'student_id');
    }
    public function tutor(){
        return $this->belongsTo(User::class,'tutor_id');
    }
    public function parent(){
        return $this->belongsTo(User::class,'parent_id');
    }
    public function sender(){
        return $this->belongsTo(Chat::class,'reciver_id');
    }

    public function tutorSubjectOffer() {
        return $this->belongsTo(TutorSubjectOffer::class, 'subject_id');
    }

    public function subjects() {
        return $this->belongsTo(\App\Models\Subject::class, 'subject_id');
    }
    
    public function TransactionFee() {
        return $this->hasMany(\App\Models\Transaction::class, 'booking_id');
    }


    public function getBookingFeeAttribute($value) {

      $booking_id = $this->id;

        $transaction=Transaction::where('booking_id', $booking_id)->first();

        if ($transaction) {
            return $transaction->amount;
         }else {
            return 'Free';
        }
  }

}
