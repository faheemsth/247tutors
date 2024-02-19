<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use Notifiable;
    use HasRoles;

    protected $fillable=[
        'first_name',
        'last_name',
        'password',
        'phone',
        'email',
        'role_id',
        'gender',
        'dob',
        'facebook_link',
        'linkedin_link',
        'twitter_link',
        'status',
        'profile_description',
        'image',
        'address',
        'zipcode',
        'google_id',
        'username',
        'subjects',
        'cpfname',
        'cplname',
        'cpemail',
        'parent_id',
        'paypal_email',
        'parent_authority',
        'email_verified_at',
        'tutor_reschedule_warning',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function child() {
        return $this->belongsTo(User::class, 'parent_id');
    }
    public function role(){
        return $this->hasone(Role::class, 'id');
    }

    public function tutorSubjectOffers()
    {
        return $this->hasMany(TutorSubjectOffer::class,'tutor_id','id');
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'tutor_id', 'id');
    }

    public function loginTokens()
    {
      return $this->hasMany(LoginToken::class);
    }
    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array
    //  */
    // // protected $fillable = [
    // //     'Name' ,  'email', 'password',
    // // ];

    // /**
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
    //  */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    // /**
    //  * The attributes that should be cast to native types.
    //  *
    //  * @var array
    //  */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = Hash::make($value);
    // }


    // public function get_roles()
    // {
    //     $roles = [];
    //     foreach ($this->getRoleNames() as $key => $role) {
    //         $roles[$key] = $role;

    //     }

    //     return $roles;
    // }
    // /*
    //  Tables Relationships
    // */
    // public function subjects(){
    //     return $this->hasmany(Subject::class);
    // }

    // public function tutorQualification(){
    //     return $this->hasmany(tutorQualification::class);
    // }
    // public function tutorExperience(){
    //     return $this->hasmany(tutorExperience::class);
    // }
    // public function tutorAvailibility(){
    //     return $this->hasone(tutorAvailibility::class);
    // }
    // public function tutorSubjectOffer(){
    //     return $this->hasmany(tutorSubjectOffer::class);
    // }
    // public function booking(){
    //     return $this->hasone(Booking::class);
    // }
    // public function creditHours(){
    //     return $this->hasmany(creditHours::class);
    // }
    // public function role(){
    //     return $this->hasone(Role::class);
    // }
    // public function level(){
    //     return $this->hasmany(Level::class);
    // }
    // public function userAccountDetails(){
    //     return $this->hasmany(UserAccountDetail::class);
    // }
    // public function wallet(){
    //     return $this->hasone(Wallet::class);
    // }
    // public function companyWallet(){
    //     return $this->hasone(CompanyWallet::class);
    // }
    // public function transaction(){
    //     return $this->hasmany(Transaction::class);
    // }
    // public function orders(){
    //     return $this->hasmany(Order::class);
    // }
    // public function tutorReview(){
    //     return $this->hasone(TutorReview::class);
    // }
}
