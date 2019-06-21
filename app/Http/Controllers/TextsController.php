<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\Notifications;
use DB;
use Redirect;
use Input;
use Validator;
use Texts;
use Config;

class TextsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $texts = Texts::all();
        return view('texts.index')->with("texts", $texts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("texts.create");
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
            'command_name' => 'required|unique:texts,command_name,',
            'text' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/szovegek/uj')
                ->withErrors($validator)
                ->withInput();
        }

        Texts::create(array(
            'name' => Input::get('name'),
            'user_id' => Auth::User()->id,
            'command_name' => Input::get('command_name'),
            'text' => Input::get('text')
        ));
        return Redirect::To('/szovegek')->with('success', 'Sikeres létrehozás!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $text = Texts::find($id);
        if($text != null){
            return view('texts.show')->with("text", $text);
        }
        else{
            return Redirect::To("/szovegek");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $text = Texts::find($id);
        if($text != null){
            return view("texts.edit")->with("text", $text);
        }
        else{
            return Redirect::To("/szovegek");
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
        $text = Texts::find($id);  
        if($text != null){      
            $rules = array(
                'name' => 'required',
                'command_name' => 'required|unique:texts,command_name,'.$id,
                'text' => 'required'
            );

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                return Redirect::to('/szovegek/'.$id.'/szerkeszt')
                    ->withErrors($validator)
                    ->withInput();
            }

            $text->name = Input::get('name');
            $text->command_name = Input::get('command_name');
            $text->text = Input::get('text');
            $text->save();
            return Redirect::To('/szovegek')->with('success', 'Sikeres szerkesztés!');
        }
        else{
            return Redirect::To('/szovegek');
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
        $text = Texts::find($id);
        if($text != null){
            Texts::find($id)->delete();
            return Redirect::to("/szovegek")->with("success","Sikeres törlés.");   
        }
        else{
            return Redirect::To("/szovegek");
        }
    }
}
