<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\Notifications;
use App\News;
use DB;
use Redirect;
use Input;
use Validator;
use Texts;
use Config;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::all();
        return view("news.index")->with("news", $news);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("news.create");
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
            'title' => 'required',
            'text' => 'required',
            'excerpt' => 'required',
            'status' => 'required',
            'publish_on' => 'nullable',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/hirek/uj')
                ->withErrors($validator)
                ->withInput();
        }
        $newDate = date("Y-m-d");

        if(Input::get('publish_on')){
            $originalDate = Input::get('publish_on');
            $newDate = date("Y-m-d h:m:s", strtotime($originalDate));
        }

        News::create(array(
            'title' => Input::get('title'),
            'user_id' => Auth::User()->id,
            'excerpt' => Input::get('excerpt'),
            'article' => Input::get('text'),
            'status' => Input::get('status'),
            'lead_picture' => Input::get('lead_image'),
            'publish_on' => $newDate
        ));
        return Redirect::To('/hirek')->with('success', 'Sikeres létrehozás!');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::find($id);
        if($news != null){
            return view("news.show")->with("news", $news);
        }
        else{
            return Redirect::To("/");
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
        $news = News::find($id);
        if($news != null){
            return view("news.edit")->with("news", $news);
        }
        else{
            return Redirect::To("/hirek");
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
            'title' => 'required',
            'text' => 'required',
            'excerpt' => 'required',
            'status' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/hirek/uj')
                ->withErrors($validator)
                ->withInput();
        }
        $newDate = Input::get('publish_on');

        if(Input::get('publish_on')){
            $originalDate = Input::get('publish_on');
            $newDate = date("Y-m-d h:m:s", strtotime($originalDate));
        }
        $news = News::find($id);
        if($news != null){

            $news->title = Input::get('title');
            $news->excerpt = Input::get('excerpt');
            $news->article = Input::get('text');
            $news->status = Input::get('status');
            $news->lead_picture = Input::get('lead_image');
            $news->publish_on = $newDate;
            $news->save();
        }
        else{
            return Redirect::To('/hirek');
        }
        return Redirect::To('/hirek')->with('success', 'Sikeres létrehozás!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::find($id);
        if($news != null){
            News::find($id)->delete();
            return Redirect::to("/hirek")->with("success","Sikeres törlés.");   
        }
        else{
            return Redirect::To("/hirek");
        }
    }
}
