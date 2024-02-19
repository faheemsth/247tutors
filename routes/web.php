<?php

use App\Models\User;
use App\Models\Wallet;
use App\Models\Booking;
use App\Events\NewTrade;
use App\Models\disclaimer;
use Illuminate\Http\Request;
use App\Models\TutorSubjectOffer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrgController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\RediractController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DisclaimerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TransactionController;

use App\Http\Controllers\JitsiMeetJWTController;
use App\Http\Controllers\SubjectOfferController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\WebsiteSettingController;
use App\Http\Controllers\LoginWithGoogleController;
use App\Http\Controllers\TutorExperienceController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\ReviewsController;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\TermsAndConditionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// *********************************************************************************************
// *                               Guest Pages Routes
// *********************************************************************************************
Route::get('/zoom', function () {
    // $rec = Kalizi\LaravelSpyhole\Models\SessionRecording::where('path','/zoom')->first();
    // dd($rec);
    return view('zoom');
});

Route::get('/BookingBeforThreeMinutesCron', [BookingController::class, 'BookingBeforThreeMinutesCron']);

Route::get('/locale/{locale}', function (Request $request, $locale) {
    Session::put('locale', $locale);
    return redirect()->back();
})->name('locale');

Route::Post('send/newsletter', [FrontendController::class,'SendNewsletter']);
Route::get('CounterShow', [FrontendController::class,'CounterShow']);


Route::get('SixteenMinutesInterviewReminder', [InterviewController::class,'SixteenMinutesInterviewReminder']);

Route::get('TwentyFourInterviewReminder', [InterviewController::class,'TwentyFourInterviewReminder']);


Route::get('SevenDayPaymentSendToTutorReminder', [PayoutController::class,'SevenDayPaymentSendToTutorReminder']);

Route::get('BookingSlotRelease', [InterviewController::class,'BookingSlotRelease']);


Route::get('/emailVerificationEmail', function () {
    return view('auth.verifytutor');
});
Route::match(['get', 'post'], '/botman', [BotManController::class,'handle']);

// Route::get('/online-meeting/{id}', [ChatController::class, 'onlinechat']);
Route::get('/online-meeting/{id}', [JitsiMeetJWTController::class, 'index']);
Route::get('/zoom-online-meeting/{id}', [JitsiMeetJWTController::class, 'zoom_meet']);

Route::get('/zoom-online-interiew-meeting/{id}', [JitsiMeetJWTController::class, 'zoom_meet_interview']);

Route::post('/saveRecording', [JitsiMeetJWTController::class, 'saveRecording']);

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('likeDislike', [FrontendController::class,'likeDislike']);

Route::get('auth/google', [LoginWithGoogleController::class, 'redirectToGoogle']);
Route::get('auth/magiclink/{email}', [LoginController::class, 'magicLogin']);
Route::get('/user-verify-login/{token}', [LoginController::class,'userverifyLoginToken'])->name('user-verify-login');

Route::get('auth/google/callback', [LoginWithGoogleController::class, 'handleGoogleCallback']);

Route::get('/find-tutor', [FrontendController::class, 'findTutor'])->name('findTutor');
Route::get('/student-apply-steps', [FrontendController::class, 'studentApplySteps'])->name('studentApplySteps');
Route::get('/tutor-apply-steps', [FrontendController::class, 'tutorApplySteps'])->name('tutorApplySteps');
Route::get('/organization-apply-steps', [FrontendController::class, 'organizationApplySteps'])->name('organizationApplySteps');
Route::get('/prices', [FrontendController::class, 'prices'])->name('prices');
Route::get('/blogs', [FrontendController::class, 'blogs'])->name('blogs');
Route::get('/single-post/{id}', [FrontendController::class, 'singlepost'])->name('post');
Route::get('/like/post/{id}', [FrontendController::class, 'likepost'])->name('likepost');
Route::get('/unlike/post/{id}', [FrontendController::class, 'unlikepost'])->name('unlikepost');

Route::post('/comments/store/{id}', [FrontendController::class, 'CommentsStore'])->name('CommentsStore');


Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');
Route::get('/tutor/profile/{id}', [FrontendController::class, 'tutor_profile']);
Route::post('disclaimer/request', [DisclaimerController::class,'disclaimer_request']);

Route::get('/countAllData', [FrontendController::class, 'countAllData']);
Route::get('/find-tutor', [FrontendController::class, 'findTutor'])->name('findTutor');
Route::get('/privacypolicy', function () {
    $TermsAndCondition=App\Models\TermsAndCondition::where('status','privacy_policy')->get();
    return view('frontend.policy',compact('TermsAndCondition'));
});
Route::get('/sitemap', function () {
    return view('frontend.sitemap');
});
Route::get('/testimonials', function () {
    $TermsAndCondition=App\Models\TermsAndCondition::where('status','terms_condition')->get();
    return view('frontend.testimonials',compact('TermsAndCondition'));
});
Route::get('/careers', function () {
    return view('frontend.careers');
});
Route::get('/videos-guides', function () {
    return view('frontend.lessonspace');
});

// *********************************************************************************************
// *                               Signup , Login in and Reset Password Routes
// *********************************************************************************************
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('showRegisterForm');

Route::get('/select-user-type', [RegisterController::class, 'select_user_type'])->name('select-user-type');
Route::get('/student-signup', [RegisterController::class, 'Student'])->name('Student');
Route::get('/tutor-signup', [RegisterController::class, 'Tutor'])->name('Tutor');
Route::get('/parent-signup', [RegisterController::class, 'Parent'])->name('Parent');
Route::get('/organization-signup', [RegisterController::class, 'Organization'])->name('Organization');
Route::post('/email-check', [RegisterController::class, 'email_check'])->name('email-check');
Route::post('/username-check', [RegisterController::class, 'username_check'])->name('username-check');

Route::post('register', [RegisterController::class,'register'])->name('register');
Route::get('/login-roles', [LoginController::class, 'loginRoles'])->name('login-roles');
Route::get('/roleget', [LoginController::class, 'roleget'])->name('roleget');

Route::get('/login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);

//  Route::get('/login-1', function () { return view('pages.login'); });
//  Route::post('register', [RegisterController::class,'register']);
//  Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
//  Route::post('login', [LoginController::class,'login']);


Route::get('password/forget',  function () {
	return view('pages.forgot-password');
})->name('password.forget');

Route::get('verifyCode',  function () {
	return view('pages.verifyCode');
})->name('verifyCode');

Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');

Route::post('verifyCode', [ForgotPasswordController::class,'verifyCode'])->name('verifyCode.post');

Route::post('reset/password', [ForgotPasswordController::class,'ResetPassword'])->name('reset.password');

Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');


Route::get('/email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify')->middleware(['signed']);
Route::post('/email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// Route::get('account/verify','Auth\VerificationController@verifyAccount')->name('user.verify');

Route::get('account/verify',  function (Request $request) {
    $user = User::where('password', $request->token)->first();
    if (!is_null($user)) {
        if (!$user->email_verified_at) {

            $ActivityLogs = new ActivityLog;
            $ActivityLogs->user_id = $user->id;

            if ($request->role_id == 6) {
                $ActivityLogs->title = "New Organization";
                $ActivityLogs->description = "New Organization " . $user->first_name . ' ' . $user->last_name . " verifyAccount At ";
            } else if ($request->role_id == 5) {
                $ActivityLogs->title = "New Parent";
                $ActivityLogs->description = "New Parent " . $user->first_name . ' ' . $user->last_name . " verifyAccount At ";
            } else if ($request->role_id == 4) {
                $ActivityLogs->title = "New Student";
                $ActivityLogs->description = "New Student " . $user->first_name . ' ' . $user->last_name . " verifyAccount At ";
            } else if ($request->role_id == 3) {
                $ActivityLogs->title = "New Tutor";
                $ActivityLogs->description = "New Tutor " . $user->first_name . ' ' . $user->last_name . " verifyAccount At ";
            }
            $ActivityLogs->save();

            $user->email_verified_at = Carbon::now();
            if ($user->role_id == "5" || $user->role_id == "4") {
            $user->status = "Active";
            if($user->role_id == "5")
            {
                createNotification($user->role_id,Auth::id(),'Email verification',$user->username.'Has Verified His Parent Account');
            }

            if($user->role_id == "4")
            {
                createNotification($user->role_id,Auth::id(),'Email verification',$user->username.'Has Verified His Student Account');
            }

            }
            $user->save();
            if ($user->role_id == "3") {
                return redirect('profile_verification')->with('success', "Your e-mail is Successfully verified.");
            }
            return redirect('dashboard')->with('success', "Your e-mail is Successfully verified.");
        } else {
            return redirect()->route('login')->with('success', "Your e-mail is already verified. You can now login.");
        }
    }
})->name('password.forget');


Route::post('account/verification','Auth\VerificationController@verificationAccount')->name('user.verification');

// *********************************************************************************************
// *                               Super Admin Routes
// *********************************************************************************************
Route::group(['middleware' => 'auth'], function(){
	Route::get('/logout', [LoginController::class,'logout']);
    Route::post('/save_profile_verification', [TutorExperienceController::class, 'SaveprofileVerification'])->name('save.profile.verification');

    Route::middleware(['verified'])->group(function () {
        Route::get('/students/messages/',[ChatController::class,'chat']);
        Route::get('/parent/messages/',[ChatController::class,'chat']);
        Route::get('/tutor/messages/',[ChatController::class,'chat']);
        Route::get('/chat/{id}',[ChatController::class,'singlechat']);

        // Tutor Chats
        Route::get('/chats/{id}',[ChatController::class,'index']);
        Route::post('send/message',[ChatController::class,'send_message']);
        Route::get('get/message',[ChatController::class,'get_message']);
        Route::get('get/notification',[ChatController::class,'get_notification']);


        Route::get('/chat_with_students',[ChatController::class,'chat_with_students']);
        Route::post('/chat_with_students',[ChatController::class,'chat_send_to_student']);
        Route::post('create/group',[ChatController::class,'create_group']);
        Route::post('get_chat',[ChatController::class,'get_chat']);

        Route::get('dowunloadPdf',[UserController::class,'dowunloadPdf']);


        // user-card-create

        Route::post('user-card-create',[UserController::class,'user_card_create']);
        Route::post('user-card-create-profile',[UserController::class,'user_card_create_profile']);

         // super admin dashboard
        Route::get('/dashboard', function (Request $request) {
            if ($request->user()->role_id == 1) {

                $org=User::where('role_id', 6)->get();
                $students=User::where('role_id', 4)->get();
                $tutors=User::where('role_id', 3)->get();
                $parents=User::where('role_id', 5)->get();
                $recents = User::orderBy('id', 'desc')->paginate(5);

                $Completed=Booking::where('status', "Completed")->get();
                $Cancelled=Booking::where('status', "Cancelled")->get();
                $InProcess=Booking::where('status', "In Process")->get();
                $Scheduled=Booking::where('status', "Scheduled")->get();
                $Pending=Booking::where('status', "Pending")->get();
                return view('super-admin.dashboard',compact('org','students','tutors','parents','recents','Completed','Cancelled','InProcess','Scheduled','Pending'));

            } elseif ($request->user()->role_id == 2) {
                return redirect('admin_dashboard');
            } elseif ($request->user()->role_id == 3) {
                if(Auth::user()->status == 'Pending'){
                    return redirect('profile_verification');
                }
                return redirect('tutor/home');
            } elseif ($request->user()->role_id == 4) {
                return redirect('student/home');
            } elseif ($request->user()->role_id == 5) {
                return redirect('parent/home');
            } elseif ($request->user()->role_id == 6) {
                return redirect('organization/home');
            }
        })->name('dashboard');

        // complaint
        Route::get('/complaint', [ComplaintController::class,'index']);
        Route::post('/Submit/Comptaint', [ComplaintController::class,'SubmitComptaint']);

        // super admin dashboard terms_condition
        Route::get('/admin/terms_condition', [TermsAndConditionController::class,'index']);
        Route::post('/admin/terms_condition', [TermsAndConditionController::class,'Submit']);
        Route::get('/add/terms/condition', [TermsAndConditionController::class,'form']);
        Route::get('/delete/terms/condition/{id}', [TermsAndConditionController::class,'delete']);
        Route::get('/update/terms/condition/{id}', [TermsAndConditionController::class,'updateform']);



        // RefoundList

        Route::get('/admin/RefundList', [BookingController::class, 'RefoundList']);



        Route::get('/admin/privacy_policy', [TermsAndConditionController::class,'index_privacy_policy']);
        Route::post('/admin/privacy_policy', [TermsAndConditionController::class,'Submit_privacy_policy']);
        Route::get('/add/terms/privacy_policy', [TermsAndConditionController::class,'form_privacy_policy']);
        Route::get('/delete/terms/privacy_policy/{id}', [TermsAndConditionController::class,'delete_privacy_policy']);
        Route::get('/update/terms/privacy_policy/{id}', [TermsAndConditionController::class,'updateform_privacy_policy']);


        // super admin dashboard users

        Route::get('/users', [UserController::class,'index']);
        Route::get('/userVerify/{id}', [UserController::class,'userVerify']);

        Route::get('/user/get-list', [UserController::class,'getUserList']);
        Route::get('/user/create', [UserController::class,'create']);
        Route::post('/user/store', [UserController::class,'store'])->name('store-user');
        Route::get('/user/{id}/edit', [UserController::class,'edit']);
        Route::put('/user/{id}/update', [UserController::class,'update']);
        Route::get('/user/{id}/delete', [UserController::class, 'delete']);
        Route::get('/user/{id}/permissions', [UserController::class, 'permissions']);
        Route::post('/user/{id}/permissions', [UserController::class, 'permission_post']);


        Route::post('complaint/stages/submit', [UserController::class, 'ComplaintStagesSubmit']);



        Route::get('/profile_details', [DashboardController::class,'detailprofile']);
        Route::post('/update/profile/info', [DashboardController::class,'upload_file']);
        Route::post('/update/profile/password', [DashboardController::class,'upload_passwd']);
        Route::post('/update/profile', [DashboardController::class,'upload_profile_img']);
        // students
        Route::get('/students', [DashboardController::class,'students']);
        Route::post('/update-user-status', [DashboardController::class,'update_user_status']);


        // tutors

        Route::get('/tutors', [UserController::class,'tutors']);
        Route::get('/tutorProfile/{id}', [UserController::class,'tutorProfile']);
        Route::post('/update-document-status', [UserController::class,'updateTutorStatus']);
        Route::post('/update-user-profile-status', [UserController::class,'updateUserStatus']);

        // Interview

        Route::get('/interview', [InterviewController::class,'index']);
        Route::post('save/interview', [InterviewController::class,'save']);

        //
        Route::get('delete/newsletter/{id}', [FrontendController::class,'DeleteNewsletter']);

        Route::get('/parents', [UserController::class,'parent']);
        Route::get('/organizations', [UserController::class,'organization']);
        Route::get('/verify_tutor', [UserController::class,'verification']);
        // coupons

        Route::get('/coupons', [CouponController::class,'index']);
        Route::post('/get-coupon', [CouponController::class,'get_coupon']);
        Route::post('/tutor/update/{id}', [UserController::class,'update_tutor']);


        Route::post('/create-coupon', [CouponController::class,'create_coupon']);
        // super admin dashboard users
        Route::get('/newsletter', [FrontendController::class, 'list'])->name('newsletter.list');
        Route::get('/setting/pages', [PageController::class, 'setting'])->name('website');
        Route::get('/setting/blog', [PageController::class, 'bloglisting'])->name('bloglist');


        Route::get('/setting/blog-comments',function () {
            if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
            $BlogReplies = App\Models\BlogReply::all();
            return view('super-admin.comment.commentlist',compact('BlogReplies'));
        })->name('commentlist');

        Route::get('/change/reply/status/{id}/{status}',function ($id,$status) {

            $BlogReplies = App\Models\BlogReply::where('id',$id)->first();
            $BlogReplies->status = $status;
            $BlogReplies->save();
            return back()->with('success',$status.' Status Successfully');


        })->name('change.reply.status');



        Route::get('/setting/document_types', [PageController::class, 'doctypeList'])->name('documentTypes');
        Route::post('/save_document_types', [PageController::class, 'storeDocType'])->name('save_document_types');
        Route::post('/update_document_types', [PageController::class, 'updateDocType'])->name('update_document_types');
        Route::post('/update_tutor_document', [TutorExperienceController::class, 'updateDocs'])->name('update_tutor_document');
       // super admin blog create

        Route::get('/blog/create', [BlogController::class, 'blog_create']);
        Route::post('/blog/create', [BlogController::class, 'blog_create_Request']);
        Route::get('/blog/update', [BlogController::class, 'blog_update']);
        Route::post('/blog/update', [BlogController::class, 'blog_update_Request']);
        Route::get('/blog/delete', [BlogController::class, 'blog_delete']);

        Route::post('/save_website_setting', [WebsiteSettingController::class, 'saveSetting']);



        //   levels
        Route::get('level', [LevelController::class, 'index']);
        Route::get('/level/create', [LevelController::class, 'create']);
        Route::post('/level/store', [LevelController::class, 'store']);
        Route::get('level/delete/{id}', [LevelController::class, 'level_delete']);
        Route::get('level/update/{id}', [LevelController::class, 'level_update']);
        Route::post('level/update/{id}', [LevelController::class, 'level_update_post']);


        //  admin booking
        Route::post('complaint/Update', [ComplaintController::class, 'complaintUpdate']);


        Route::get('admin/bookings', [BookingController::class, 'index']);
        Route::get('ActivityLogs', [BookingController::class, 'ActivityLog']);
        Route::get('booking/update/{id}', [BookingController::class, 'booking_update']);
        Route::post('get-booking-details', [BookingController::class, 'booking_details']);
        Route::get('Complaintlogs', [ComplaintController::class, 'complaintlog']);

        Route::get('get/interview', [ComplaintController::class,'getinterview']);


        Route::get('get/refund', [BookingController::class,'getrefund']);
        Route::post('refund/Update', [BookingController::class, 'refundUpdate']);


        Route::get('mark-as-read/{id}', [ComplaintController::class, 'MarkAsRead']);
        Route::get('/transaction', [TransactionController::class, 'transaction']);



        //  admin dashboard
        Route::get('/admin_dashboard', function () { return view('pages.dashboard'); });

        //  tutor profile
        Route::get('/tutor/home', function () {
            $disclaimer=Disclaimer::where('user_id',Auth::id())->first();
            $booking=Booking::where('tutor_id',Auth::id())->count();
            $student=Booking::where('tutor_id',Auth::id())->distinct('student_id')->count();
            $subject=TutorSubjectOffer::where('tutor_id',Auth::id())->count();
            $wallet = Wallet::where('user_id', Auth::id())->first();
            $Wallettotal = optional($wallet)->withdrawn + optional($wallet)->balance ?? 0;

            return view('pages.dashboard.tutordashboard',compact('disclaimer','booking','student','subject','Wallettotal'));
        })->name('tutor.home');
        Route::get('/tutor_profile', [TutorExperienceController::class, 'tutor_profile']);

        Route::get('/tutor/settings', [TutorExperienceController::class, 'update_tutor']);
        Route::get('/profile_verification', [TutorExperienceController::class, 'profileVerification'])->name('profile.verification');
        Route::get('/tutor/payments', [TutorExperienceController::class, 'tutor_payments']);
        Route::get('/tutor/payout', [PayoutController::class,'payout']);
        Route::post('/Upload/Profile', [TutorExperienceController::class, 'upload_profile_img']);
        Route::post('/update_tutor_post', [TutorExperienceController::class, 'update_tutor_post']);
        Route::get('/tutor_payments_post', [TutorExperienceController::class, 'tutor_payments_post']);
        Route::get('/bookings', [BookingController::class, 'bookings']);
        Route::post('/booking-update', [TutorExperienceController::class, 'booking_update']);
        Route::get('/verify_transaction/{id}/{id2}', [TutorExperienceController::class, 'verify_transaction']);
        Route::get('/create', [ParentController::class, 'create']);
        Route::get('/parent/payments', [ParentController::class,'parent_payments']);
        Route::get('/booking-status-change', [BookingController::class, 'booking_status_change'])->name('booking-status-change');
        Route::get('/booking-status-compeleted', [BookingController::class, 'booking_status_compeleted'])->name('booking-status-compeleted');
        Route::post('/endJitsiMeeting', [BookingController::class, 'endJitsiMeeting']);
        Route::post('/check-slot', [BookingController::class, 'checkSlot']);

        Route::post('/request-refound', [BookingController::class, 'request_refound']);
        Route::post('/rescheduled_meeting', [BookingController::class, 'rescheduled_meeting'])->name('rescheduled.meeting');
        Route::post('/availability/store', [TutorExperienceController::class, 'availability_store']);
        Route::post('availability/update', [TutorExperienceController::class, 'availability_update']);
        Route::get('/availability/delete/{id}', [TutorExperienceController::class, 'availability_delete']);
        Route::get('apperove_rescheduled_meeting', [BookingController::class, 'apperove_rescheduled_meeting'])->name('apperove_rescheduled_meeting');

         //   subjects
        Route::get('/subjects', [SubjectController::class, 'index']);
        Route::post('/subject/store', [SubjectController::class, 'store']);
        Route::get('/subject/delete/{id}', [SubjectController::class, 'delete']);
        Route::post('/subject/update/{id}', [SubjectController::class, 'update_post']);

        Route::get('/reviews/student', [ReviewsController::class, 'ReviewStudent']);
        Route::get('/reviews/tutor', [ReviewsController::class, 'ReviewTutor']);
        Route::get('/reviews/parent', [ReviewsController::class, 'ReviewParent']);



        // subject offer store
        Route::post('/subject/offer/store', [SubjectOfferController::class, 'store']);
        Route::get('/subject/offer/delete/{id}', [SubjectOfferController::class, 'delete']);
        Route::post('/subject/offer/update/{id}', [SubjectOfferController::class, 'update']);

        // students
        Route::get('student/profile', function () { return view('pages.dashboard.profiledetailstudent');});
        Route::post('/Upload/Image', [StudentController::class, 'upload_profile_img']);
        Route::post('/update_student_post', [StudentController::class, 'update_student_post']);
        Route::get('/student_profile', [StudentController::class, 'student_profile']);



        Route::get('/tutor/book/{id}', [StudentController::class, 'book_tutor']);

        Route::get('/tutor/wallet/book/{id}', [StudentController::class, 'book_tutor_wallet']);





        Route::post('/book_tutor_post', [BookingController::class, 'book_tutor_post'])->name('stripe.post');

        Route::post('/book_by_wallet_post', [BookingController::class, 'book_by_wallet_post'])->name('book.by.wallet.post');




        Route::post('/stripe_post_wallet', [BookingController::class, 'stripe_post_wallet'])->name('stripe.post.wallet');
        Route::get('/student/payments', [StudentController::class, 'student_payments']);

        Route::post('/book_free_lesson', [BookingController::class, 'book_free_lesson'])->name('book.free.lesson');


        Route::get('/student_profile/{id}', [StudentController::class, 'student_profile_get']);
        Route::get('parent/home',[StudentController::class,'home']);
        Route::get('student/home',[StudentController::class,'home']);

        Route::get('AjaxFetchChatUnredList',[StudentController::class,'AjaxFetchChatUnredList']);

        Route::get('/chatchat',[StudentController::class,'chat']);
        Route::get('/single_chat',[StudentController::class,'singlechat']);

        // parents
        Route::get('/parent2', [ParentController::class, 'index']);
        Route::get('/parent_profile', [ParentController::class, 'parent_profile']);
        Route::get('/parent/profile', [ProfileController::class, 'profile_setting']);
        Route::post('/Upload/Profile', [ProfileController::class, 'upload_profile_img']);
        Route::post('/profile-setting', [ProfileController::class, 'profile_setting_post']);
        Route::post('/add_student', [StudentController::class, 'add_student']);
        Route::get('/delete-student', [StudentController::class, 'delete_student']);


        Route::get('/show_student/{id}', [ParentController::class, 'show_student']);
        Route::get('parent/students', [ParentController::class, 'your_students']);
        Route::get('book_lessons', [ParentController::class, 'book_lessons']);
        Route::get('get-subject', [ParentController::class, 'get_subject']);
        Route::post('get-slots', [StudentController::class, 'getSlots']);


        // organization
        Route::get('/organization/home', [OrgController::class, 'organization_pending'])->name('organization.dashboard');
        Route::get('/organization_pending', [OrgController::class, 'organization_pending'])->name('organization.pending');


            // Profile route
            Route::get('/profile', function () { return view('pages.profile'); });
            // roles
            Route::get('/roles', [RolesController::class,'index']);
            Route::get('/role/get-list', [RolesController::class,'getRoleList']);
            Route::post('/role/create', [RolesController::class,'create']);
            Route::get('/role/edit/{id}', [RolesController::class,'edit']);
            Route::post('/role/update', [RolesController::class,'update']);
            Route::get('/role/delete/{id}', [RolesController::class,'delete']);
            // permission
            Route::get('/permission', [PermissionController::class,'index']);
            Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
            Route::post('/permission/create', [PermissionController::class,'create']);
            Route::get('/permission/update', [PermissionController::class,'update']);
            Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);

           // get permissions
           Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);

           // Basic demo routes



           /////////////////////////////Start Recording
           Route::get('/start-recording', [BookingController::class, 'startRecording']);
           Route::get('/stop-recording', [BookingController::class, 'stopRecording']);

    });
});





