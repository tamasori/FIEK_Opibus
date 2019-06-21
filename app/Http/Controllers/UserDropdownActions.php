<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Notifications;
use App\Logs;
use DB;
use Redirect;
use Input;
use Validator;
use Hash;
use Config;
use Labs;
use Items;
use Groups;
use Reservation;

class UserDropdownActions extends Controller
{
    public function myprofile(){
        $user = User::find(Auth::User()->id);
        return view("userDropdownActions.myprofile")->with("user", $user);
    }

    public function myprofileUpdate(){
        $user = User::find(Auth::User()->id);
        $rules = array(
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::User()->id
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/profil-szerkesztese')
                ->withErrors($validator) 
                ->withInput(Input::except('password'));
        }
        
         $password = $user->password;
         if(Input::get('password') != ""){
             $password = Hash::make(Input::get("password"));
         }

         $user->name = Input::get("name");
         $user->email = Input::get("email");
         $user->phone_number = Input::get("phone_number");
         $user->github = Input::get("github");
         $user->password = $password;

         $user->save();
         return Redirect::To("/profil-szerkesztese")->with("success", "Sikeres mentés!");
    }

    public function mylogs(){
        $logs = Logs::where("user_id", "=", Auth::User()->id)->orderBy('created_at','DESC')->get(); 
        return view("userDropdownActions.mylogs")->with("logs", $logs);
    }

    public function myreservations(){
        $reservations = Reservation::where("user_id", "=", Auth::User()->id)->get();
        return view("userDropdownActions.myreservations")->with("reservations", $reservations);
    }
}
