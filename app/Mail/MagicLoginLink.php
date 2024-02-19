<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;


class MagicLoginLink extends Mailable
{
    use Queueable, SerializesModels;

    use Queueable, SerializesModels;

  public $plaintextToken;
  public $expiresAt;
  public $name;

  public function __construct($plaintextToken, $expiresAt, $name)
  {
    $this->plaintextToken = $plaintextToken;
    $this->expiresAt = $expiresAt;
    $this->name = $name;
  }

  public function build()
  {
    return $this->subject(
      config('app.name') . ' Click to Login'
    )->markdown('email.magic-login-link', [
      'url' => URL::temporarySignedRoute('user-verify-login', $this->expiresAt, [
        'token' => $this->plaintextToken,
      ]),
      'name'=> $this->name,
    ]);
  }

}
