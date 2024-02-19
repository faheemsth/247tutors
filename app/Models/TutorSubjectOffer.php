<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorSubjectOffer extends Model
{
    use HasFactory;
    protected $guarded = [];
    /*
     Tables Relationships
    */
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'subject_id', 'subject');
    }


    public static function find_tutor($request)
    {

        $query = $request->input('query');
        $level = $request->input('level');
        $sort = $request->input('sort');
        $gender = $request->input('gender');
        $selectedSubjects = $request->input('subjects');
        $subject = $request->input('subject');
        $minPrice = floatval($request->input('min_price'));
        $zipcode = $request->input('zipcode');
        $maxPrice = floatval($request->input('max_price'));


        $tutor = User::where('status', 'Active')->where('role_id', 3);
        $zero = 0;
        $tutor->whereHas('tutorSubjectOffers', function ($query) use ($zero) {
            $query->where('fee', '!=', $zero);
        });


        // search avaibilty
        if ($request->get('availabilityData')) {
            $days = [];
            $slots = [];
            foreach ($request->get('availabilityData') as $availabilityItem) {
                $days[] = $availabilityItem['day'];
                $slots[] = $availabilityItem['slot'];
            }
            $tutor->whereHas('availabilities', function ($query) use ($days, $slots) {
                $query->whereIn('day_of_the_week', array_map('intval', $days));
                $query->where(function ($query) use ($slots) {
                    foreach ($slots as $slot) {
                        $query->orWhere(function ($query) use ($slot) {
                            if ($slot == 'Morning') {
                                $query->where('schedule_time', 'Morning');
                            } elseif ($slot == 'Afternoon') {
                                $query->where('schedule_time', 'Afternoon');
                            } elseif ($slot == 'Evening') {
                                $query->where('schedule_time', 'Evening');
                            }
                        });
                    }
                });
            });
        }
        // search zipcode
        if (!empty($zipcode)) {
            $tutor->where(\DB::raw('CAST(users.zipcode AS DECIMAL)'), 'like', "%$zipcode%");
        }

        // search Subjects
        if (!empty($subject)) {
            $selectedSubject =  Subject::where('name',$subject)->first()->id;
            $tutor->whereHas('tutorSubjectOffers', function ($query) use ($selectedSubject) {
                $query->where('subject_id', $selectedSubject);
            });
        }

        // search selectedSubjects
        if (!empty($selectedSubjects)) {
            $tutor->whereHas('tutorSubjectOffers', function ($query) use ($selectedSubjects) {
                $query->whereIn('subject_id', array_values($selectedSubjects));
            });
        }
        // search level
        if (!empty($level)) {
            $tutor->whereHas('tutorSubjectOffers', function ($query) use ($level) {
                $query->where('levelstring', $level);
            });
        }
        // search minPrice
        if (!empty($minPrice)) {
            $tutor->whereHas('tutorSubjectOffers', function ($query) use ($minPrice) {
                $query->where(\DB::raw('CAST(fee AS DECIMAL)'), '>=', $minPrice);
            });
        }
        // search maxPrice
        if (!empty($maxPrice)) {
            $tutor->whereHas('tutorSubjectOffers', function ($query) use ($maxPrice) {
                $query->where(\DB::raw('CAST(fee AS DECIMAL)'), '<=', $maxPrice);
            });
        }
        // sort my min and max price
        if (!empty($gender) && ($gender == 'low to high' || $gender == 'high to low')) {
            $direction = ($gender == 'low to high') ? 'asc' : (($gender == 'high to low') ? 'desc' : 'asc');
            $tutor->join('tutor_subject_offers', 'users.id', '=', 'tutor_subject_offers.tutor_id')
                  ->orderByRaw('CAST(tutor_subject_offers.fee AS DECIMAL) ' . $direction)
                  ->select('users.*');
        }


        if (!empty($gender) && ($gender == 'Online' || $gender == 'In Person' || $gender == 'Both')) {
            $direction = ($gender == 'Online') ? 1 : (($gender == 'In Person') ? 2 : (($gender == 'Both') ? 3 : ''));
            $tutor->join('tutor_applications', 'users.id', '=', 'tutor_applications.tutor_id')
                  ->where('tutor_applications.tutor_type', $direction)
                  ->select('users.*');
        }



        // search gender
        if ($gender == 'Male') {
            $tutor->where('gender', 'Male');
        }
        // search gender
        if ($gender == 'Female') {
            $tutor->where('gender', 'Female');
        }

        if ($gender == 'Any') {
            $tutor->whereIn('gender', ['Female', 'Male']);
        }

        // search query for name
        if (!empty($query)) {
            $tutor->where('first_name', 'like', "%$query%")
                ->orWhere('last_name', 'like', "%$query%");
        }
        $FeeNotNull = 0;

        $tutor->whereHas('tutorSubjectOffers', function ($query) use ($FeeNotNull) {
            $query->where('fee', '!=', $FeeNotNull);
        });


        $tutor->where('status', 'Active')->where('role_id', 3);
        $tutors = $tutor->paginate(20, ['*'], 'page', $request->page);

        // dd($tutors);
        return $tutors;

    }

}
