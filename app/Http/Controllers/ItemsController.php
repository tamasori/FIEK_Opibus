<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Redirect;
use Input;
use Validator;
use Config;
use Items;
use Auth;
use Labs;
use User;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Items::all();
        return view("items.index")->with("items", $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("items.create");
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
            'lab_id' => 'required',
            'supervisor_id' => 'required|array',
            'file_url' => 'required'
        );
        
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/eszkozok/uj')
                ->withErrors($validator)
                ->withInput();
        }


        $items = [];
        foreach (Items::all() as $item) {
            if(Input::get('item-'.$item->id)){
                array_push($items, $item->id);
            }
        }

        Items::create(array(
            'name' => Input::get('name'),
            'user_id' => Auth::User()->id,
            'description' => Input::get('description'),
            'youtube_link' => Input::get('youtube_link'),
            'image'=> Input::get("file_url", " "),
            'lab_id' => Input::get('lab_id'),
            'supervisor_id' => json_encode( Input::get('supervisor_id'), JSON_UNESCAPED_UNICODE),
            'rules' => json_encode($items, JSON_UNESCAPED_UNICODE),
            'remote_access' => Input::get('remote_access', 0)
        ));

        return Redirect::To('/eszkozok')->with('success', 'Sikeres létrehozás!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Items::find($id);
        if($item != null){
            return view("items.show")->with("item", $item);
        }
        else{
            return Redirect::To("/eszkozok");
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
        $current_item = Items::find($id);
        if($current_item != null){
            return view("items.edit")->with("current_item", $current_item);
        }
        else{
            return Redirect::To("/eszkozok");
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
        $item = Items::find($id);
        if($item != null){
            $rules = array(
                'name' => 'required',
                'lab_id' => 'required',
                'supervisor_id' => 'required|array',
                'file_url' => 'required'
            );
    
            $validator = Validator::make(Input::all(), $rules);
    
            if ($validator->fails()) {
                return Redirect::to('/eszkozok/'.$id.'/szerkeszt')
                    ->withErrors($validator)
                    ->withInput();
            }
    
            $items = [];
            foreach (Items::all() as $el) {
                if(Input::get('item-'.$el->id)){
                    array_push($items, $el->id);
                }
            }

            $item->name =  Input::get('name');
            $item->description = Input::get('description');
            $item->youtube_link = Input::get('youtube_link');
            $item->image = Input::get("file_url");
            $item->lab_id = Input::get('lab_id');
            $item->supervisor_id = json_encode( Input::get('supervisor_id'), JSON_UNESCAPED_UNICODE);
            $item->rules = json_encode($items, JSON_UNESCAPED_UNICODE);
            $item->remote_access = Input::get('remote_access', 0);

            $item->save();
    
            return Redirect::To('/eszkozok')->with('success', 'Sikeres szerkesztés!');
        }
        else{
            return Redirect::To("/eszkozok");
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
        $item = Items::find($id);
        if($item != null){
            Items::find($id)->delete();
            return Redirect::to("/eszkozok")->with("success","Sikeres törlés.");   
        }
        else{
            return Redirect::To("/eszkozok");
        }
    }
}
