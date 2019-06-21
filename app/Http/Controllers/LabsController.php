<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Labs;
use App\Notifications;
use DB;
use Redirect;
use Input;
use Validator;
use Auth;

class LabsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labs_s = DB::table("labs")->join('users', 'labs.user_id', '=', 'users.id')->select("labs.id as labid", "labs.name as labname", "labs.short_name as labshortname", "labs.created_at as labcreated", "users.name as username")->get();
        return view('labs.index')
        ->with('test', $labs_s);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('labs.create');
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
            'short_name' => 'required',
            'place' => 'required'
        );
        
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/laborok/uj')
                ->withErrors($validator) 
                ->withInput(Input::except('password'));
        }
        else{
            $lab = new Labs([

                'name' => Input::get("name"),
                'short_name' => Input::get("short_name"),
                'place' => Input::get("place"),
                'user_id' => Auth::User()->id

            ]);
            $lab->save();
            return Redirect::to('/laborok')->with("success","Sikeres mentés");
        }
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
        $lab  = Labs::find($id);
        return view("labs.edit")->with("lab", $lab);
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
        $not = new Notifications([
            'message' => "Teszt notification",
            'user_id' => Auth::User()->id,
            'opened' => 0
        ]);
        $not->save();

        $rules = array(
            'name' => 'required',
            'short_name' => 'required',
            'place' => 'required'
        );
        
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/laborok/'.$id.'/szerkeszt')
                ->withErrors($validator) 
                ->withInput(Input::except('password'));
        }
        else{

            $lab = Labs::find($id);
            $lab->name = Input::get("name");
            $lab->short_name = Input::get("short_name");
            $lab->place = Input::get("place");
            $lab->save();
            return Redirect::to('/laborok')->with("success","Sikeres mentés");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Labs::find($id)->delete();
        return Redirect::to("/laborok")->with("success","Sikeres törlés");
    }
}
