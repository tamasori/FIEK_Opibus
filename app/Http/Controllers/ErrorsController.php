<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Items;
use User;
use Notifications;
use News;
use DB;
use Redirect;
use Input;
use Validator;
use Texts;
use Config;
use Errors;
use Mail;
use Labs;
use App\Mail\ItemErrorSubmittedToAdmin;;

class ErrorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::User()->id;
        $notUsersErrors = Errors::all();
        return view('itemErrors.index')
        ->with("notUsersErrors", $notUsersErrors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $items = Items::all();
        return view('itemErrors.create')
        ->with("users", $users)
        ->with("items", $items);
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
            'item_id' => 'required|exists:items,id',
            'worker_id' => 'required',
            'description' => 'required',
            'status' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/hiba-bejelentesek/uj')
                ->withErrors($validator)
                ->withInput();
        }

        $error = Errors::create(array(
            'item_id' => Input::get('item_id'),
            'user_id' => Auth::User()->id,
            'worker_id' => Input::get('worker_id'),
            'description' => Input::get('description'),
            'status' => Input::get('status')
        ));

        $u_n = User::whereRaw('can_access LIKE \'%{"menus":["all"]%\' OR can_access LIKE \'%"errors"%\'')->get();
            foreach ($u_n as $u) {
                Notifications::create([
                    'message' => "Új hibabejelentés: " . Items::find(Input::get('item_id'))->name . "(" . Auth::User()->name . ")",
                    'user_id' => $u->id,
                    'opened' => 0
                ]);

                Mail::to($u->email)->send(new ItemErrorSubmittedToAdmin(Auth::User()->id,$error->id,Input::get('item_id'),Labs::find(Items::find(Input::get('item_id'))->lab_id)->id,$u->id));
            }

        return Redirect::To('/hiba-bejelentesek')->with('success', 'Sikeres létrehozás!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::all();
        $items = Items::all();
        $error = Errors::find($id);
        if($error != null){
            return view("itemErrors.edit")->with("error",$error)
            ->with("users", $users)
            ->with("items", $items);  
        }
        else{
            return Redirect::To("/hiba-bejelentesek");
        }
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
        $rules = array(
            'item_id' => 'required|exists:items,id',
            'worker_id' => 'required',
            'description' => 'required',
            'status' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/hiba-bejelentesek/'. $id . "/szerkeszt")
                ->withErrors($validator)
                ->withInput();
        }
        $error = Errors::find($id);
        $error->item_id = Input::get('item_id');
        $error->worker_id = Input::get('worker_id');
        $error->description = Input::get('description');
        $error->status = Input::get('status');
        $error->save();

        $u_n = User::whereRaw('can_access LIKE \'%{"menus":["all"]%\' OR can_access LIKE \'%"errors"%\'')->get();
            foreach ($u_n as $u) {
                Notifications::create([
                    'message' => "Hibabejelentés frissült: " . Items::find(Input::get('item_id'))->name . "(" . Auth::User()->name . ")",
                    'user_id' => $u->id,
                    'opened' => 0
                ]);
            }
        if($error->status == "archive"){
            Notifications::create([
                'message' => "Az Ön által bejelentett hibát javítottuk: " . Items::find(Input::get('item_id'))->name,
                'user_id' => $error->user_id,
                'opened' => 0
            ]);
        }

        return Redirect::To('/hiba-bejelentesek')->with('success', 'Sikeres szerkesztés!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $error = Errors::find($id);
        if($error != null){
            $error->status = "archive";
            $error->save();
            return Redirect::to("/hiba-bejelentesek")->with("success","Sikeres törlés.");   
        }
        else{
            return Redirect::To("/hiba-bejelentesek");
        }
    }
}
