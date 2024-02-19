<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Blog;
use App\Models\Page;
use App\Models\TutorQualification;
use App\Models\User;
use App\Models\Level;
use App\Models\Subject;
use App\Models\LikeDislike;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\BlogReply;
use Illuminate\Http\Request;
use App\Models\TutorSubjectOffer;
use Illuminate\Support\Facades\DB;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;


class FrontendController extends Controller
{

    //showing index page
    public function index()
    {
        $Subjects = Subject::distinct('name')->pluck('name');
        $subjectCounts = [];
        foreach ($Subjects as $Subject) {
            $subjectModel = Subject::where('name', $Subject)->with('tutorSubjectOffer', 'bookings')->first();
            if ($subjectModel) {
                $subjectCounts[$Subject] = [
                    'tutors' => $subjectModel->tutorSubjectOffer->count(),
                    'students' => $subjectModel->bookings->count(),
                ];
            }
        }
        $TutorSubjectOffers = TutorSubjectOffer::all();
        $stu_tutor_count = User::whereIn('role_id', [3, 4])->count();
        return view('frontend.home', compact('Subjects','subjectCounts','TutorSubjectOffers','stu_tutor_count'));
    }

    public function findTutor(Request $request)
    {
        $levels = Level::all();
        $Subjects = Subject::distinct('name')->pluck('name','id');
        $TutorSubjectOffers = TutorSubjectOffer::find_tutor($request);
        if ($request->ajax()) {
            return view('frontend.ajax', compact('TutorSubjectOffers', 'levels', 'Subjects'));
        }
        return view('frontend.find-tutor', compact('TutorSubjectOffers', 'levels', 'Subjects'));
    }

    public function studentApplySteps()
    {
        return view('frontend/student-apply-steps');
    }

    public function tutorApplySteps()
    {
        return view('frontend/tutor-apply-steps');
    }

    public function organizationApplySteps()
    {
        return view('frontend.organization-apply-steps');
    }
    
    
   public function CommentsStore(Request $request,$id)
    {
        if(Auth::check()){
         $BlogReply= new BlogReply;
         $BlogReply->post_id= $id;
         $BlogReply->user_id= Auth::id();
         $BlogReply->reply= $request->comment_text;
         $BlogReply->save();
         return back()->with('success','Comment Successfully');
        }else{
            return redirect('login');
        }

    }
    
    public function likepost($id)
    {
        if(!Auth::check())
        {
           return redirect('login');
        }
        
        $blog = Blog::find($id);
        if ($blog && $blog->is_like_by != Auth::id()) {
            $blog->is_like += 1;
            $blog->is_like_by = Auth::id();
            $blog->save();
            return back()->with('success','Like Successfully');
        } else {
            return back()->with('error','You Have Already Like');
        }
    }
    
    public function unlikepost($id)
    {
        if(!Auth::check())
        {
           return redirect('login');
        }
        $blog = Blog::where('id',$id)->first();
        if ($blog) {
            $blog->is_like -= 1;
            $blog->is_like_by = null;
            $blog->save();
            return back()->with('error','Unlike Successfully');
        } else {
            return back()->with('error','You Have Already Like');
        }
    }

    
    public function singlepost($id)
    {
        $blog = Blog::find($id);
        $reply=BlogReply::where('post_id',$id)->where('status','Active')->get();
        return view('frontend.singlepost',compact('blog','reply'));
    }

    public function prices()
    {
        return view('frontend.prices');
    }

    public function blogs(Request $request)
    {
        if (!empty($request->get('category'))) {
            $category = $request->get('category');

            // Use a switch statement for better readability
            switch ($category) {
                case 'tutors':
                    $category_id = 3;
                    break;
                case 'parent':
                    $category_id = 5;
                    break;
                case 'students':
                    $category_id = 4;
                    break;
                default:
                    $category_id = null;
                    break;
            }

            if ($category_id !== null) {
                $blogs = Blog::where('category_id', $category_id)->get();
            }
        } else {
            $blogs = Blog::all();
        }

        return view('frontend.blogs', compact('blogs'));
    }


    public function faq()
    {
        return view('frontend.faqs');
    }
    public function tutor_profile($id)
    {
        $tutor = User::find($id);
        $subjects = Subject::with('level')->get();
        $tutorsubjectoffers = TutorSubjectOffer::where('tutor_id', $tutor->id)->with(['level', 'tutor', 'subject'])->get();
        $availabilitys = Availability::where('tutor_id', $tutor->id)->get();
        $TutorQualifications=TutorQualification::where('tutor_id',$id)->get();
        $students = array();
        if (Auth::check() && Auth::user()->role_id == 5) {
            $students = User::where('role_id', '4')->where('parent_id', Auth::id())->get();
            return view('pages.dashboard.profiletutor', compact('TutorQualifications','availabilitys', 'tutor', 'subjects', 'tutorsubjectoffers','students'));
        }
        $AllSubjects = Subject::distinct('name')->pluck('name');
       
        return view('pages.dashboard.profiletutor', compact('TutorQualifications','availabilitys', 'tutor', 'subjects', 'tutorsubjectoffers','students','AllSubjects'));
    }
    public function likeDislike(Request $request)
    {
        if (Auth::check()) {
            $LikeDislikes = LikeDislike::firstOrNew(
                ['to_user_id' => $request->tutor, 'from_user_id' => Auth::id()],
                ['action' => 0] // Default action if the record is new
            );

            $LikeDislikes->action = ($LikeDislikes->action == 0) ? 1 : 0;
            $LikeDislikes->save();

            return back();
        }
        return redirect('login');
    }



    public function SendNewsletter(Request $request)
    {
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');

        // Validate the request data
        $request->validate([
            'email' => 'required|email|unique:newsletters', // Add any additional validation rules as needed
        ]);
        $data = [
            'tutorMessage' => 'Thank You for Subscribing to Our Newsletter!',
        ];

        $ActivityLogs = new ActivityLog;
        $ActivityLogs->user_id = Auth::id() ?? null;
        $ActivityLogs->title = "Newsletter Email ";
        $ActivityLogs->description = "Newsletter By  ".$request->email;
        $ActivityLogs->save();


        $environment = env('APP_ENV', 'local');
        if ($environment == 'local') {
            // Send email to tutor
            Mail::send('pages.mails.newslatter', $data, function ($message) use ($request) {
                $message->to(User::where('role_id',1)->first()->email,'Admin')
                    ->subject('New User Newslatter Messages');
                $message->from($request->email, $request->email);
            });
        } elseif ($environment == 'production') {
            $view = \view('pages.mails.newslatter', $data);
            $view = $view->render();

            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";

            $mail->setfrom('support@247tutors.com', '247 Tutors');
            $mail->AddEmbeddedImage($imagePath, 'logo');
            
            $mail->isHTML(true);
            $mail->Subject = 'Thank You for Subscribing to Our Newsletter!';
            $mail->Body = $view;
            $mail->AltBody = '';
            $mail->addaddress($request->email, $request->email);
            $mail->isHTML(true);
            $mail->msgHTML($view);

            if (!$mail->send())
                throw new \Exception('Failed to send mail');
        }

        // If validation passes, proceed with saving the data
        $data = new Newsletter;
        $data->email = $request->email;
        $data->save();

        // You can return a response or redirect as needed
        return response()->json(['success' => true, 'message' => 'Newsletter subscribed successfully']);
    }

    public function list(Request $request)
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $blogs = Newsletter::query();
        $search = $request->input('search');
        if (!empty($search)) {
            $blogs->where('email', 'like', '%' . $search . '%');
        }
        
        if (!empty($request->input('date'))) {
            
            if($request->input('date') == 'Today'){
                $blogs->whereDate('created_at', today());
            }
            
            if($request->input('date') == '15 Days'){
                $blogs->whereDate('created_at', '>=', now()->subDays(15));
            }
            
            if($request->input('date') == '30 Days'){
                $blogs->whereDate('created_at', '>=', now()->subDays(30));
            }
            
        }
        
        $blogs=$blogs->paginate(5);
        return view('super-admin.Pages.Newsletter.list', compact('blogs'));

    }
    
        public function deleteNewsletter($id)
        {
            if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
            $newsletter = Newsletter::find($id);
            if (!$newsletter) {
                return back()->with('error', 'Sorry Newsletter Not Found');
            } else {
                $newsletter->delete();
                return back()->with('success', 'Newsletter deleted successfully');
            }
        }

    
    

    public function CounterShow(){
     $countmessg = Chat::where('reciver_id', Auth::id())
    ->where('status', 0)
    ->select('sender_id')
    ->groupBy('sender_id')
    ->with('sender')
    ->count();
    if(Auth::user()->role_id == 4){
    $countBooking = Booking::where('student_id', Auth::id())->where('status', 'Pending')->count();
    }
    if(Auth::user()->role_id == 3){
    $countBooking = Booking::where('tutor_id', Auth::id())->where('status', 'Pending')->count();

    }
    if(Auth::user()->role_id == 5){
        $countBooking = Booking::where('parent_id', Auth::id())->where('status', 'Pending')->count();

    }
    return response()->json(['countmessg' => $countmessg, 'countBooking' => $countBooking]);
    }
}
