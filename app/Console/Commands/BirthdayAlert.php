<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class BirthdayAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthday:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send birthday mail alert to users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('role_id', '!=', 1)->where('dob', '!=', null)->get();
        foreach ($users as $user) {
            if (date("m-d", strtotime($user->dob)) == date("m-d")) {
                $data = [
                    'message' => 'Happy Birthday To You',
                    'user' => $user,
                ];
                try {
                    $environment = env('APP_ENV', 'local');
                    if($environment == 'local'){
                        Mail::send('email.birthday', $data, function ($message) use ($user) {
                            $message->to($user->email, $user->first_name . ' ' . $user->last_name)
                                ->subject('Birthday Wish');
                            $message->from('support@247tutors.com', '247tutors.com');
                        });
                    }else{

                        $view = \view('email.birthday',$data);
                        $view = $view->render();
                        $mail = new PHPMailer();
                        $mail->CharSet = "UTF-8";
                        $mail->setfrom('support@247tutors.com' , '247 Tutors');
                        $mail->isHTML(true);
                        $mail->Subject = 'Birthday Wish';
                        $mail->Body    = $view;
                        $mail->AltBody = '';
                        $mail->addaddress($user->email, $user->first_name.' '.$user->last_name);
                        $mail->isHTML(true);
                        $mail->msgHTML($view);
                
                        if(!$mail->send()) throw new \Exception('Failed to send mail');

                    }
                } catch (\Exception $e) {
                    \Log::error('Error sending birthday email: ' . $e->getMessage());
                }
            }
        }
    }
}
