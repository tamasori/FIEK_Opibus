<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;
use Messages;
use User;

class ResetPasswordToUser extends Mailable
{
    use Queueable, SerializesModels;
    protected $user_id;
    protected $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($uid, $code)
    {
        $this->user_id = $uid;        
        $this->code = $code;        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::find($this->user_id);
        $resetlink = env("APP_URL") . "/elfelejtett-jelszo/". $this->code;
        $view_r = 
        Messages::create(array(
            "user_id" => $this->user_id,
            "message" => view('emailTemplates.resetPassword_toUser')->with("user", $user)->with("resetlink", $resetlink)->render(),
            "subject" => env("MAIL_SUBJECT","asdasd"),
            "opened" => "0",
        ));
        return $this->subject(env("MAIL_SUBJECT","asdasd"))->view('emailTemplates.resetPassword_toUser')->with("user", $user)->with("resetlink", $resetlink);
    }
}
