<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $verificationCode;
    public $userName;

    public function __construct($verificationCode, $userName)
    {
        $this->verificationCode = $verificationCode;
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->subject('Verification Code')
            ->view('auth.verification_code');
        
    }
}
