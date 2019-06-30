<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreatedToAdmin;
use App\Mail\UserCreatedToUser;
Use App\User;
use Notifications;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if($user = Auth::user())
        {
            return Redirect::to("/");
        }
        return view('register');
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
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        );
        
        $validator = Validator::make(\Illuminate\Support\Facades\Input::all(), $rules);

        if ($validator->fails()) {
            return \Illuminate\Support\Facades\Redirect::to('regisztracio')
                ->withErrors($validator) 
                ->withInput( \Illuminate\Support\Facades\Input::except('password'));
        }

        /*$email_uniqe = User::where("email", "=", \Illuminate\Support\Facades\Input::get("email"))->exists();

        if($email_uniqe){
            return \Illuminate\Support\Facades\Redirect::to('regisztracio')
                ->withErrors(["emailExists" => "A megadott email cím már szerepel rendszerünkben!"]) 
                ->withInput( \Illuminate\Support\Facades\Input::except('password'));
        }*/

        $usr = \App\User::create(array(
            'name'     => \Illuminate\Support\Facades\Input::get("name"),
            'email'    => \Illuminate\Support\Facades\Input::get("email"),
            'accepted'    => '0',
            'can_access'    => '0',
            'phone_number'    => \Illuminate\Support\Facades\Input::get("phone_number"),
            'github'    => \Illuminate\Support\Facades\Input::get("github"),
    
            'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Facades\Input::get("password")),
        ));

        $u_n = User::whereRaw('can_access LIKE \'%{"menus":["all"]%\' OR can_access LIKE \'%"users"%\'')->get();
        foreach ($u_n as $u) {
            Notifications::create([
                'message' => "Új felhasználó regisztrált: " . \Illuminate\Support\Facades\Input::get("name") . "(" . \Illuminate\Support\Facades\Input::get("github") . ")",
                'user_id' => $u->id,
                'opened' => 0
            ]);
            Mail::to($u->email)->send(new UserCreatedToAdmin($usr->id,$u->id));
        }
        Mail::to($usr->email)->send(new UserCreatedToUser($usr->id));

        return \Illuminate\Support\Facades\Redirect::to("/sikeres-regisztracio");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
