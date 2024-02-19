<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class DocumentsExpiryAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'documents:expiryalert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is used to send a mail alert to tutors for their documents expiry.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('role_id', 3)
            ->leftJoin('tutor_applications', 'users.id', '=', 'tutor_applications.tutor_id')
            ->select(
                'users.email',
                'users.first_name',
                'users.last_name',
                'enhaced_dbs_expiry',
                'user_id_expiry'
            )
            ->get();
        foreach ($users as $user) {
            $data = [
                'message' => 'File expired',
                'user' => $user,
            ];

            if ($user->user_id_expiry !== null && Carbon::now()->diffInDays(Carbon::createFromDate($user->user_id_expiry)) <= 5) {
                $environment = env('APP_ENV', 'local');
                if($environment == 'local'){
                    Mail::send('email.documentExpire', $data, function ($message) use ($user) {
                        $message->to($user->email, $user->first_name . ' ' . $user->last_name)
                            ->subject('User Id Expiry');
                        $message->from('support@247tutors.com', '247tutors.com');
                    });
                }else{
                    $view = \view('email.documentExpire',$data);
                    $view = $view->render();
                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";
                    $mail->setfrom('support@247tutors.com' , '247 Tutors');
                    $mail->isHTML(true);
                    $mail->Subject = 'User Id Expiry';
                    $mail->Body    = $view;
                    $mail->AltBody = '';
                    $mail->addaddress($user->email, $user->first_name.' '.$user->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);
            
                    if(!$mail->send()) throw new \Exception('Failed to send mail');
                }
            }

            if ($user->enhaced_dbs_expiry !== null && Carbon::now()->diffInDays(Carbon::createFromDate($user->enhaced_dbs_expiry)) <= 5) {
                Mail::send('email.documentExpire', $data, function ($message) use ($user) {
                    $message->to($user->email, $user->first_name . ' ' . $user->last_name)
                        ->subject('Enhaced Dbs Expiry');
                    $message->from('support@247tutors.com', '247tutors.com');
                });
            }
        }
    }
}
