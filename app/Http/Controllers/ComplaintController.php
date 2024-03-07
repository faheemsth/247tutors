<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Booking;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Mail;
class ComplaintController extends Controller
{


    public function index(){

        $Complaints = Complaint::where('user_id',Auth::id());
        if(!empty($_GET['search'])){
            $Complaints->where('TicketID', $_GET['search']);
        }
        $Complaints = $Complaints->paginate(10);
        return view('pages.dashboard.complaint', compact('Complaints'));
    }


    public function complaintlog(){
if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $Complaints = Complaint::query();
        if(!empty($_GET['search'])){
            $Complaints->where('issues_detail', 'like', '%' . $_GET['search'] . '%')
                ->orWhere('subject', $_GET['search'])
                ->orWhere('booking_id', $_GET['search'])
                ->orWhere('TicketID', $_GET['search']);
        }

        if(!empty($_GET['status'])){
            $Complaints->where('role_id',$_GET['status']);
        }

        $Complaints = $Complaints->paginate(10);
        return view('pages.dashboard.complaintlog.logcomplaint', compact('Complaints'));
    }

    public function SubmitComptaint(Request $request)
    {
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');
        $booking=Complaint::where('booking_id',$request->booking_id)->first();
        if(!empty($booking)){
            return back()->with('error', 'This Complaint Already Exist');
        }
        $data = $request->all();
        $imageName = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $imageName);
        }
        $data['file']=$imageName;
        $data['user_id']=Auth::id();
        $data['role_id']=Auth::user()->role_id;

        $complant=Complaint::create($data);

        $ActivityLogs = new ActivityLog;
        $ActivityLogs->user_id = Auth::id();
        $ActivityLogs->title = "Complaint Created";
        $ActivityLogs->description = "#".$complant->TicketID." This Ticket Id Created By ".Auth::user()->first_name."  ".Auth::user()->last_name;
        $ActivityLogs->save();


        $tutor = User::find(optional($booking)->tutor_id);
        if(Auth::user()->role_id == 5){
            $student = User::find(optional($booking)->parent_id);
        }else{
           $student = User::find(optional($booking)->student_id); 
        }
        if(!empty($tutor) && !empty($student)){
           $data = [
            'tutorMessage' => 'Your Complaint Has Successfully Submited',
            'student' => $student->first_name . ' ' . $student->last_name,
            'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
            'complant' => $data['issues_detail']
         ]; 
         
           // Student
        
            $view = \view('pages.mails.ComplaintByStudent', $data);
            $view = $view->render();

            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";

            $mail->setfrom('support@247tutors.com', '247 Tutors');

            $mail->isHTML(true);
            $mail->Subject = Auth::user()->first_name . ' ' . Auth::user()->last_name.' Student Complaint Submission on 247Tutor';
            $mail->Body = $view;
            $mail->AddEmbeddedImage($imagePath, 'logo');
            $mail->AltBody = '';
            $mail->addaddress(!empty($tutor) ? $tutor->email : '', $tutor->first_name . ' ' . $tutor->last_name);
            $mail->isHTML(true);
            $mail->msgHTML($view);

            if (!$mail->send())
                throw new \Exception('Failed to send mail');



            // Tutor
            $view = \view('pages.mails.ComplaintByTutor', $data);
            $view = $view->render();

            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";

            $mail->setfrom('support@247tutors.com', '247 Tutors');

            $mail->isHTML(true);
            $mail->Subject = "Successful Submission of Your Complaint";
            $mail->Body = $view;
            $mail->AddEmbeddedImage($imagePath, 'logo');
            $mail->AltBody = '';
            $mail->addaddress(!empty($student) ? $student->email : '', $student->first_name . ' ' . $student->last_name);
            $mail->isHTML(true);
            $mail->msgHTML($view);

            if (!$mail->send())
                throw new \Exception('Failed to send mail');
                
        }else{
            
            $data = [
            'tutorMessage' => 'Your Complaint Has Successfully Submited',
            'student' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
            'tutor' => '',
            'complant' => $data['issues_detail']
            ];
         
            // Tutor
            $view = \view('pages.mails.ComplaintByTutor', $data);
            $view = $view->render();

            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";

            $mail->setfrom('support@247tutors.com', '247 Tutors');

            $mail->isHTML(true);
            $mail->Subject = "Successful Submission of Your Complaint";
            $mail->Body = $view;
            $mail->AddEmbeddedImage($imagePath, 'logo');
            $mail->AltBody = '';
            $mail->addaddress(!empty(Auth::user()) ? Auth::user()->email : '', Auth::user()->first_name . ' ' . Auth::user()->last_name);
            $mail->isHTML(true);
            $mail->msgHTML($view);

            if (!$mail->send())
                throw new \Exception('Failed to send mail');  
            
            
        }

        createNotification(Auth::user()->role_id,Auth::id(),'Comptaint','Comptaint By ' .Auth::user()->username);
        return back()->with('success', 'Complaint submitted successfully');
    }

    public function MarkAsRead($id)
    {
        Complaint::find($id)->update(['status' => "Processing"]);

        $ActivityLogs = new ActivityLog;
        $ActivityLogs->user_id = Auth::id();
        $ActivityLogs->title = "Complaint MarkAsRead";
        $ActivityLogs->description = "#".Complaint::find($id)->TicketID." This Ticket Id Mark As Read By ".Auth::user()->first_name."  ".Auth::user()->last_name;
        $ActivityLogs->save();

        return back()->with('success', 'Complaint Update successfully');
    }
    public function getinterview(Request $request)
    {
        $html = "";
        $complaint = Complaint::find($request->id);

        $html .= '<tr>
                    <td class="pe-5">Ticket No :</td>
                    <td>' . $complaint->TicketID . '</td>
                </tr>';

        $html .= '<tr class="pb-3 m-4">
                    <td class="pe-5">Complainer Name :</td>
                    <td>' . optional(User::find($complaint->user_id))->username . '</td>
                </tr>';

        if(!empty(User::find(optional(Booking::where('uuid', $complaint->booking_id)->first())->tutor_id))){
            
             $html .= '<tr class="pb-3 m-4">
                    <td class="pe-5">Tutor Name :</td>
                    <td>' . User::find(Booking::where('uuid', $complaint->booking_id)->first()->tutor_id)->username . '</td>
                </tr>';
            
           }
        $html .= '<tr class="pb-3 m-4">
                    <td class="pe-5">Booking Id :</td>
                   <td>' .  ($complaint->booking_id ?  $complaint->booking_id : 'N/A') . '</td>
                </tr>';

        $html .= '<tr class="pb-3 m-4">
                    <td class="pe-5">Status :</td>
                    <td>' . $complaint->status . '</td>
                </tr>';

        $html .= '<tr class="pb-3 m-4">
                    <td class="pe-5">Details :</td>
                   <td>' . $complaint->issues_detail . '</td>
                </tr>';
        if (!empty($complaint->file) && file_exists(public_path('images/'.$complaint->file))) {
                    $html .= '<tr class="pb-3 m-4">
                                <td class="pe-5">Image :</td>
                                <td>
                                <a download="' . asset('images/'.$complaint->file) . '" href="' . asset('images/'.$complaint->file) . '" target="_blank">
                                  <img src="' . asset('images/'.$complaint->file) . '" width="100" height="50">
                                </a>
                                </td>
                            </tr>';
                }

        return $html;
    }
    






























public function complaintUpdate(Request $request)
{
    $complaint = Complaint::find($request->Tutorid);

    if (!$complaint) {
        return back()->with('error', 'Complaint not found.');
    }

    $student = User::find($complaint->user_id);
    $imagePath = public_path('assets/images/247 NEW Logo 1.png');
    if (!$student) {
        return back()->with('error', 'Student not found.');
    }
    
    // tutor for processing 

       if($request->status == 'Processing'){
        $Booking=Booking::where('uuid',$complaint->booking_id)->first();
            if(!empty($Booking))
            {
                $tutor=User::find($Booking->tutor_id);
                $data = [
                'tutorMessage' => 'Your Complaint Has Successfully Has ' . $request->status,
                'student' => $student->first_name . ' ' . $student->last_name,
                'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
                ];
                
                // student
                $view = view('pages.mails.ComplaintProcessingStudent', $data)->render();
                $mail = new PHPMailer(true);
                $mail->CharSet = 'UTF-8';
                $mail->setFrom('support@247tutors.com', '247 Tutors');
                $mail->isHTML(true);
                $mail->Subject = "Complaint Request Processing";
                $mail->Body = $view;
                $mail->AddEmbeddedImage($imagePath, 'logo');
                $mail->AltBody = '';
                $mail->addAddress($student->email, $student->first_name . ' ' . $student->last_name);
                $mail->isHTML(true);
                $mail->msgHTML($view);
                $mail->send();
                
                // tutor
                $view = view('pages.mails.ComplaintProcessingTutor', $data)->render();
                $mail = new PHPMailer(true);
                $mail->CharSet = 'UTF-8';
                $mail->setFrom('support@247tutors.com', '247 Tutors');
                $mail->isHTML(true);
                $mail->Subject = "Complaint Request Processing";
                $mail->Body = $view;
                $mail->AddEmbeddedImage($imagePath, 'logo');
                $mail->AltBody = '';
                $mail->addAddress($tutor->email, $tutor->first_name . ' ' . $tutor->last_name);
                $mail->isHTML(true);
                $mail->msgHTML($view);
                $mail->send();
            }else{
                
                $data = [
                'tutorMessage' => 'Your Complaint Has Successfully Has ' . $request->status,
                'student' => $student->first_name . ' ' . $student->last_name,
                ];
                
                // student
                $view = view('pages.mails.ComplaintProcessingStudent', $data)->render();
                $mail = new PHPMailer(true);
                $mail->CharSet = 'UTF-8';
                $mail->setFrom('support@247tutors.com', '247 Tutors');
                $mail->isHTML(true);
                $mail->Subject = "Complaint Request Processing";
                $mail->Body = $view;
                $mail->AddEmbeddedImage($imagePath, 'logo');
                $mail->AltBody = '';
                $mail->addAddress($student->email, $student->first_name . ' ' . $student->last_name);
                $mail->isHTML(true);
                $mail->msgHTML($view);
                $mail->send();
                
            }
           
        }else{
            
            
            $Booking=Booking::where('uuid',$complaint->booking_id)->first();
            if(!empty($Booking))
            {
                $tutor=User::find($Booking->tutor_id);
                $data = [
                'tutorMessage' => 'Your Complaint Has Successfully Has ' . $request->status,
                'student' => $student->first_name . ' ' . $student->last_name,
                'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
                ];
                
                // student
                $view = view('pages.mails.ComplaintCompleteStudent', $data)->render();
                $mail = new PHPMailer(true);
                $mail->CharSet = 'UTF-8';
                $mail->setFrom('support@247tutors.com', '247 Tutors');
                $mail->isHTML(true);
                $mail->Subject = "Complaint Request Completed";
                $mail->Body = $view;
                $mail->AddEmbeddedImage($imagePath, 'logo');
                $mail->AltBody = '';
                $mail->addAddress($student->email, $student->first_name . ' ' . $student->last_name);
                $mail->isHTML(true);
                $mail->msgHTML($view);
                $mail->send();
                
                // tutor
                $view = view('pages.mails.ComplaintCompleteTutor', $data)->render();
                $mail = new PHPMailer(true);
                $mail->CharSet = 'UTF-8';
                $mail->setFrom('support@247tutors.com', '247 Tutors');
                $mail->isHTML(true);
                $mail->Subject = "Complaint Request Completed";
                $mail->Body = $view;
                $mail->AddEmbeddedImage($imagePath, 'logo');
                $mail->AltBody = '';
                $mail->addAddress($tutor->email, $tutor->first_name . ' ' . $tutor->last_name);
                $mail->isHTML(true);
                $mail->msgHTML($view);
                $mail->send();
            }else{
                
                $data = [
                'tutorMessage' => 'Your Complaint Has Successfully Has ' . $request->status,
                'student' => $student->first_name . ' ' . $student->last_name,
                ];
                
                // student
                $view = view('pages.mails.ComplaintProcessingStudent', $data)->render();
                $mail = new PHPMailer(true);
                $mail->CharSet = 'UTF-8';
                $mail->setFrom('support@247tutors.com', '247 Tutors');
                $mail->isHTML(true);
                $mail->Subject = "Complaint Request Processing";
                $mail->Body = $view;
                $mail->AddEmbeddedImage($imagePath, 'logo');
                $mail->AltBody = '';
                $mail->addAddress($student->email, $student->first_name . ' ' . $student->last_name);
                $mail->isHTML(true);
                $mail->msgHTML($view);
                $mail->send();
                
            }
            
            
            
            
            
        }
        $complaint->status = $request->status;
        $complaint->save();
        return back()->with('success', 'Complaint updated and email sent successfully.');

}



























}
