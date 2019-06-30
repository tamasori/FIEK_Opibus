<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Reservation; 
use Items;
use Auth;
use Redirect;
use Validator;
use Input;
use Errors;
use Overwatch;
use Notifications;
use Hash;
use App\ResetCode;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordToUser;

class ResetCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($code = "")
    {
        if(!empty($code) && ResetCode::where("code","=",$code)->where("used", "=","0")->exists()){
            $rcode = ResetCode::where("code","=",$code)->where("used", "=","0")->get()[0];
            $user = User::find($rcode->user_id);
            $user->password = Hash::make("changeme");
            $user->save();
            $rcode->used = "1";
            $rcode->save();
            return view("elfelejtettJelszo")->with("info","sikeres");
        }
        return view("elfelejtettJelszo")->with("code",$code);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'email' => 'required'
        );
        
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/');
        }
        else{
            $user = User::where("email","=",Input::get("email"))->get();
            
            if($user == false){
                return Redirect::to('/');
            }
            else{
                
                $uniqe = uniqid();
                $resetcode = new ResetCode([

                    'user_id' => $user[0]->id,
                    'code' => $uniqe,
                    'used' => "0",
    
                ]);
                $resetcode->save();
                Mail::to($user[0]->email)->send(new ResetPasswordToUser($user[0]->id,$uniqe));
                return Redirect::to('/');
            }
            
        }
    }
}
