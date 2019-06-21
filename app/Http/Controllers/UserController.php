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
use Hash;
use Config;
use Labs;
use Items;
use Groups;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index')
        ->with('users', $users);
    }

    public function create()
    {
        $groups = Groups::all();
        return view('users.create')->with("groups", $groups);
    }


    public function store(Request $request)
    {
        $rules = array(
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/felhasznalok/uj')
                ->withErrors($validator) 
                ->withInput(Input::except('password'));
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

        \App\User::create(array(
            'name'     => Input::get("name"),
            'email'    => Input::get("email"),
            'accepted'    => Input::get("userEnable", 0),
            'github'    => Input::get("github"),
            'can_access'    => json_encode($access_array, JSON_UNESCAPED_UNICODE),
            'phone_number'    => Input::get("phone_number"),
    
            'password' => Hash::make(Input::get("password")),
        ));

       return Redirect::To('/felhasznalok')->with("success", "Sikeres mentés!");
    }


    public function show($id)
    {
        $user = User::find($id);
        if($user != null){
            return view("users.show")->with("user", $user);
        }
        else{
            return Redirect::To("/felhasznalok");
        }
    }
    
    public function edit($id)
    {
        $user = User::find($id);
        if($user != null){
            $groups = Groups::all();
            return view("users.edit")->with("user", $user)->with("groups", $groups);
        }
        else{
            return Redirect::To("/felhasznalok");
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $rules = array(
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:users,email,'.$id
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/felhasznalok/'.$id.'/szerkeszt')
                ->withErrors($validator) 
                ->withInput(Input::except('password'));
        }

        if($id != Auth::User()->id){
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
        }
        else{
            $access_array = $user->can_access;
        }

         $password = $user->password;
         if(Input::get('password') != ""){
             $password = Hash::make(Input::get("password"));
         }

         $accepted = Input::get("userEnable", 0);
         if($id == Auth::User()->id){
             $accepted = 1;
         }

         $user->name = Input::get("name");
         $user->email = Input::get("email");
         $user->github = Input::get("github");
         $user->phone_number = Input::get("phone_number");
         $user->password = $password;
         $user->accepted = $accepted;
         $user->can_access = json_encode($access_array, JSON_UNESCAPED_UNICODE);

         $user->save();
         return Redirect::To("/felhasznalok")->with("success", "Sikeres mentés!");
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if($user != null){

            if($id == Auth::User()->id){
                return Redirect::to("/felhasznalok")->with("deleteError", "Saját magát nem törölheti.");
            }
            User::find($id)->delete();
            return Redirect::to("/felhasznalok")->with("success","Sikeres törlés.");   
        }
        else{
            return Redirect::To("/felhasznalok");
        }
    }

    public function activateUser($gid, $uid)
    {
        $group = Groups::find($uid);
        $user = User::find($gid);
        $user->can_access = $group->can_access;
        $user->accepted = 1;
        $user->save();
        return Redirect::to("/felhasznalok")->with("success","Sikeres aktiválás.");  
    }
}
