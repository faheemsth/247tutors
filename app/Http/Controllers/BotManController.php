<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Session;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */

    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function($botman, $message) {
        if (str_contains($message, '@')) {
            $mail = $message;
            $this->sayBye($botman,$message);

        }
        elseif ($message == 'hi' || $message == 'Hi' || $message == 'Hello' || $message == 'Hey') {
            
            $this->askName($botman);
        }elseif($message == 'ok'){
            $this->sayBye($botman);
        }else{
                    if (!in_array(strtolower($message), ['hi', 'hello', 'hey'])) {
                Session::put('question', $message);
        }
            $botman->reply('Give me your gmail I can contact you soon. ');

        }

        });

        $botman->listen();
    }




    // public function emailsender()

    /**
     * Place your BotMan logic here.
     */
    public function askName($botman)
    {
        $botman->ask('Hello! What is your Name?', function(Answer $answer) {

            $name = $answer->getText();
            Session::put('name', $name);
            $this->say('Who can i help you '.$name. '?');
            // $this->say('Give me your gmail and mobile number I can contact you soon. '.$name);
        });
    }

    public function sayBye($botman,$message)
    {
           $imagePath = public_path('assets/images/247 NEW Logo 1.png');
        
            // user
            $data1 = [
                'newMessage' => 'Successfully Send Your Issue To 247Tutors Support Team',
                'email' => $message,
                'name' => Session::get('name'),
                'question' => Session::get('question'),
                
            ];
            $view = \view('pages.mails.chatbotemailUser', $data1);
            $view = $view->render();
            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";
            $mail->setfrom('support@247tutors.com', '247 Tutors');
            $mail->AddEmbeddedImage($imagePath, 'logo');
            $mail->isHTML(true);
            $mail->Subject = 'Successfully Send Your Issue To 247Tutors Support Team';
            $mail->Body = $view;
            $mail->AltBody = '';
            $mail->addaddress($message,Session::get('name'));
            $mail->isHTML(true);
            $mail->msgHTML($view);
            
            

            if (!$mail->send())
                throw new \Exception('Failed to send mail');
                
            // admin 'newMessage' => 'You have a new query from '.Session::get('name').'   '.$message,
           $data = [
                'newMessage' => 'You have a new query from',
                 'email' => $message,
                'name' => Session::get('name'),
                'question' => Session::get('question'),
                
            ];
            $view = \view('pages.mails.chatbotemailAdmin', $data);
            $view = $view->render();
            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";
            $mail->setfrom('support@247tutors.com', '247 Tutors');
            $mail->AddEmbeddedImage($imagePath, 'logo');
            $mail->isHTML(true);
            $mail->Subject = 'Support Query';
            $mail->Body = $view;
            $mail->AltBody = '';
            $mail->addaddress(optional(\App\Models\WebSetting::find(1))->field_value,'Admin');
            $mail->isHTML(true);
            $mail->msgHTML($view);
            
            

            if (!$mail->send())
                throw new \Exception('Failed to send mail');
            Session::forget('name');
            Session::put('name');
            Session::put('question');
            
           
            $botman->ask('Ok, Nice to meet you.We have get your email and mobile phone i can contact you shortly.If you have some arrgent query then contact '.optional(\App\Models\WebSetting::find(1))->field_value, function(Answer $answer) {

            $name = $answer->getText();

            $this->say('Bye '.$name);
        });
    }
}
