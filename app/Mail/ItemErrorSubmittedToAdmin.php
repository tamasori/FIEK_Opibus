<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;
use Messages;
use User;
use Errors;
use Labs;
use Items;

class ItemErrorSubmittedToAdmin extends Mailable
{
    use Queueable, SerializesModels;
    protected $user_id;
    protected $error_id;
    protected $item_id;
    protected $lab_id;
    protected $save_user_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($uid, $eid, $iid, $lid,$suid)
    {
        $this->user_id = $uid;
        $this->error_id = $eid;
        $this->item_id = $iid;
        $this->lab_id = $lid;
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
        $item = Items::find($this->item_id);
        $error = Errors::find($this->error_id);
        $lab = Labs::find($this->lab_id);
        $view_r = 
        Messages::create(array(
            "user_id" => $this->save_user_id,
            "message" => view('emailTemplates.itemerror_toAdmin')->with("user", $user)->with("hiba", $error)->with("eszkoz", $item)->with("labor", $lab)->render(),
            "subject" => env("MAIL_SUBJECT","asdasd"),
            "opened" => "0",
        ));
        return $this->subject(env("MAIL_SUBJECT","asdasd"))->view('emailTemplates.itemerror_toAdmin')->with("user", $user)->with("hiba", $error)->with("eszkoz", $item)->with("labor", $lab);
    }
}
