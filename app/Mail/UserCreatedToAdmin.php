<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;
use Messages;
use User;

class UserCreatedToAdmin extends Mailable
{
    use Queueable, SerializesModels;
    protected $user_id;
    protected $save_user_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($uid,$suid)
    {
        $this->user_id = $uid;  
        $this->save_user_id = $suid;      
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::find($this->user_id);
        $view_r = 
        Messages::create(array(
            "user_id" => $this->save_user_id,
            "message" => view('emailTemplates.user_registration_toAdmin')->with("user", $user)->render(),
            "subject" => env("MAIL_SUBJECT","asdasd"),
            "opened" => "0",
        ));
        return $this->subject(env("MAIL_SUBJECT","asdasd"))->view('emailTemplates.user_registration_toAdmin')->with("user", $user);
    }
}
