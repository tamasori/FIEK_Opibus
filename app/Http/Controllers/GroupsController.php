<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserAcceptedToUser;
use App\Http\Controllers\Controller;
use Groups;
use Redirect;
use Input;
use Validator;
use Config;
use Labs;
use Items;
use Auth;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Groups::all();
        return view("groups.index")->with("groups", $groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("groups.create");
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
            'name' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/felhasznalo-csoportok/uj')
                ->withErrors($validator)
                ->withInput();
        }

        $menus = [];
        if(Input::get('adminmenu-all')){
            array_push($menus, "all");
        }
        else{
            foreach (Config::get("constants.menus.administration") as $menu) {
                if(Input::get('adminmenu-'.$menu['perm'])){
                    array_push($menus, $menu['perm']);
                }
            }
        }

        $labs = [];
        if(Input::get('labs-all')){
            array_push($labs, "all");
        }
        else{
            foreach (Labs::all() as $lab) {
                if(Input::get('lab-'.$lab->id)){
                    array_push($labs, $lab->id);
                }
            }
        }

        $items = [];
        if(Input::get('items-all')){
            array_push($items, "all");
        }
        else {   
            foreach (Items::all() as $item) {
                if(Input::get('item-'.$item->id)){
                    array_push($items, $item->id);
                }
            }
        }

         $access_array = [];
         $access_array["menus"] = $menus;
         $access_array["labs"] = $labs;
         $access_array["items"] = $items;

         Groups::create(array(
             'name' => Input::get('name'),
             'user_id' => Auth::User()->id,
             'can_access' => json_encode($access_array, JSON_UNESCAPED_UNICODE)
         ));

         return Redirect::To('/felhasznalo-csoportok')->with('success', 'Sikeres létrehozás!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Groups::find($id);
        if($group != null){
            return view("groups.show")->with("group", $group);
        }
        else{
            return Redirect::To("/felhasznalo-csoportok");
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
        $group = Groups::find($id);
        if($group != null){
            return view("groups.edit")->with("group", $group);
        }
        else{
            return Redirect::To("/felhasznalo-csoportok");
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
        $group = Groups::find($id);
        if($group != null){
            $rules = array(
                'name' => 'required'
            );

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                return Redirect::to('/felhasznalo-csoportok/'.$id.'/szerkeszt')
                    ->withErrors($validator)
                    ->withInput();
            }

            $menus = [];
            if(Input::get('adminmenu-all')){
                array_push($menus, "all");
            }
            else{
                foreach (Config::get("constants.menus.administration") as $menu) {
                    if(Input::get('adminmenu-'.$menu['perm'])){
                        array_push($menus, $menu['perm']);
                    }
                }
            }

            $labs = [];
            if(Input::get('labs-all')){
                array_push($labs, "all");
            }
            else{
                foreach (Labs::all() as $lab) {
                    if(Input::get('lab-'.$lab->id)){
                        array_push($labs, $lab->id);
                    }
                }
            }

            $items = [];
            if(Input::get('items-all')){
                array_push($items, "all");
            }
            else {   
                foreach (Items::all() as $item) {
                    if(Input::get('item-'.$item->id)){
                        array_push($items, $item->id);
                    }
                }
            }

            $access_array = [];
            $access_array["menus"] = $menus;
            $access_array["labs"] = $labs;
            $access_array["items"] = $items;

            $group->name = Input::get('name');
            $group->can_access = json_encode($access_array, JSON_UNESCAPED_UNICODE);

            $group->save();

            return Redirect::To('/felhasznalo-csoportok')->with('success', 'Sikeres szerkesztés!');
        }
        else{
            return Redirect::To("/felhasznalo-csoportok");
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
        $group = Groups::find($id);
        if($group != null){
            Groups::find($id)->delete();
            return Redirect::to("/felhasznalo-csoportok")->with("success","Sikeres törlés.");   
        }
        else{
            return Redirect::To("/felhasznalo-csoportok");
        }
    }
}
