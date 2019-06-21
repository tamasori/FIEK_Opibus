<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Overwatch;
use Validator;
use Redirect;
use Input;
use Auth;

class OverwatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $overwatches = Overwatch::where("to_date",">=", \DB::raw('NOW()'))->get();
        $own_overwatches = Overwatch::where("user_id","=", Auth::User()->id)->where("to_date",">=", \DB::raw('NOW()'))->get();
        return view("overwatch.index")->with("overwatches", $overwatches)->with("own_overwatches",$own_overwatches);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("overwatch.create");
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
            'from_date' => 'required',
            'to_date' => 'required_if:type_select,1|required_if:type_select,2',
            'lab_select' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/felugyelet-jelenlet/uj')
                ->withErrors($validator)
                ->withInput();
        }

        if(Input::get("type_select") == 2){
            $begin = \DateTime::createFromFormat('Y.m.d. H.i.s',Input::get('from_date')." 00.00.00");
            $end = \DateTime::createFromFormat('Y.m.d. H.i.s',Input::get('from_date')." 00.00.00");
            $end = date('Y.m.d.', strtotime("+".Input::get("weeks")." week", $end->getTimeStamp()));
            $end->setTime(23,59,59); 
            $end = \DateTime::createFromFormat('Y.m.d.', $end);

            $interval = \DateInterval::createFromDateString('1 day');
            $period = new \DatePeriod($begin, $interval, $end);

            foreach ($period as $dt) {
                $day_of_week = date( "w", $dt->getTimeStamp());
                if(Input::get("weekday-".$day_of_week)){
                    $dt2 = clone $dt;
                    $from_date_dt = date("Y-m-d H:i", $dt->modify("+ ".explode(':',Input::get("from_time"))[0]. ' hours')->modify("+ ".explode(':',Input::get("from_time"))[1]. ' minutes')->getTimeStamp());
                    $to_date_dt = date("Y-m-d H:i", $dt2->modify("+ ".explode(':',Input::get("to_time"))[0]. ' hours')->modify("+ ".explode(':',Input::get("to_time"))[1]. ' minutes')->getTimeStamp());

                    if(Overwatch::where("from_date", ">=", $from_date_dt)->where("to_date", ">=", $to_date_dt)->where("from_date", "<=", $to_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->exists()){
                        $ow = Overwatch::where("from_date", ">=", $from_date_dt)->where("to_date", ">=", $to_date_dt)->where("from_date", "<=", $to_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->get()[0];
                        $ow->from_date = $from_date_dt;
                        $ow->save();
                    }
                    else if(Overwatch::where("to_date", "<=", $to_date_dt)->where("to_date", ">=", $from_date_dt)->where("from_date", "<=", $from_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->exists()){
                        $ow = Overwatch::where("to_date", "<=", $to_date_dt)->where("to_date", ">=", $from_date_dt)->where("from_date", "<=", $from_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->get()[0];
                        $ow->to_date = $to_date_dt;
                        $ow->save();
                    }
                    else if(Overwatch::where("to_date", "<=", $to_date_dt)->where("from_date", ">=", $from_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->exists()){
                        $ow = Overwatch::where("from_date", "<=", $to_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->get()[0];
                        $ow->from_date = $from_date_dt;
                        $ow->to_date = $to_date_dt;
                        $ow->save();
                    }
                    else if(Overwatch::where("to_date", ">=", $to_date_dt)->where("from_date", "<=", $from_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->exists()){
                        
                    }
                    else{
                        Overwatch::create(array(
                            'user_id' => Auth::User()->id,
                            'from_date' => $from_date_dt,
                            'to_date' => $to_date_dt,
                            'lab_id' => Input::get('lab_select')
                        ));
                    }

                    
                }
            }
        }
        else{
            $begin = \DateTime::createFromFormat('Y.m.d. H.i.s',Input::get('from_date')." 00.00.00");
            $end = \DateTime::createFromFormat('Y.m.d. H.i.s',Input::get('to_date')." 00.00.00");

            if(Input::get('from_date') == Input::get('to_date')){

                $from_date_dt = date("Y-m-d H:i", $begin->modify("+ ".explode(':',Input::get("from_time"))[0]. ' hours')->modify("+ ".explode(':',Input::get("from_time"))[1]. ' minutes')->getTimeStamp());
                    $to_date_dt = date("Y-m-d H:i", $end->modify("+ ".explode(':',Input::get("to_time"))[0]. ' hours')->modify("+ ".explode(':',Input::get("to_time"))[1]. ' minutes')->getTimeStamp());

                    if(Overwatch::where("from_date", ">=", $from_date_dt)->where("to_date", ">=", $to_date_dt)->where("from_date", "<=", $to_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->exists()){
                        $ow = Overwatch::where("from_date", ">=", $from_date_dt)->where("to_date", ">=", $to_date_dt)->where("from_date", "<=", $to_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->get()[0];
                        $ow->from_date = $from_date_dt;
                        $ow->save();
                    }
                    else if(Overwatch::where("to_date", "<=", $to_date_dt)->where("to_date", ">=", $from_date_dt)->where("from_date", "<=", $from_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->exists()){
                        $ow = Overwatch::where("to_date", "<=", $to_date_dt)->where("to_date", ">=", $from_date_dt)->where("from_date", "<=", $from_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->get()[0];
                        $ow->to_date = $to_date_dt;
                        $ow->save();
                    }
                    else if(Overwatch::where("to_date", "<=", $to_date_dt)->where("from_date", ">=", $from_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->exists()){
                        $ow = Overwatch::where("from_date", "<=", $to_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->get()[0];
                        $ow->from_date = $from_date_dt;
                        $ow->to_date = $to_date_dt;
                        $ow->save();
                    }
                    else if(Overwatch::where("to_date", ">=", $to_date_dt)->where("from_date", "<=", $from_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->exists()){
                        
                    }
                    else{
                        Overwatch::create(array(
                            'user_id' => Auth::User()->id,
                            'from_date' => $from_date_dt,
                            'to_date' => $to_date_dt,
                            'lab_id' => Input::get('lab_select')
                        ));
                    }
            }
            else{
                
                $interval = \DateInterval::createFromDateString('1 day');
                $end->setTime(23,59,59); 

                $period = new \DatePeriod($begin, $interval, $end);

                foreach ($period as $dt) {
                    $dt2 = clone $dt;

                    $from_date_dt = date("Y-m-d H:i", $dt->modify("+ ".explode(':',Input::get("from_time"))[0]. ' hours')->modify("+ ".explode(':',Input::get("from_time"))[1]. ' minutes')->getTimeStamp());
                    $to_date_dt = date("Y-m-d H:i", $dt2->modify("+ ".explode(':',Input::get("to_time"))[0]. ' hours')->modify("+ ".explode(':',Input::get("to_time"))[1]. ' minutes')->getTimeStamp());

                    if(Overwatch::where("from_date", ">=", $from_date_dt)->where("to_date", ">=", $to_date_dt)->where("from_date", "<=", $to_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->exists()){
                        $ow = Overwatch::where("from_date", ">=", $from_date_dt)->where("to_date", ">=", $to_date_dt)->where("from_date", "<=", $to_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->get()[0];
                        $ow->from_date = $from_date_dt;
                        $ow->save();
                    }
                    else if(Overwatch::where("to_date", "<=", $to_date_dt)->where("to_date", ">=", $from_date_dt)->where("from_date", "<=", $from_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->exists()){
                        $ow = Overwatch::where("to_date", "<=", $to_date_dt)->where("to_date", ">=", $from_date_dt)->where("from_date", "<=", $from_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->get()[0];
                        $ow->to_date = $to_date_dt;
                        $ow->save();
                    }
                    else if(Overwatch::where("to_date", "<=", $to_date_dt)->where("from_date", ">=", $from_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->exists()){
                        $ow = Overwatch::where("from_date", "<=", $to_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->get()[0];
                        $ow->from_date = $from_date_dt;
                        $ow->to_date = $to_date_dt;
                        $ow->save();
                    }
                    else if(Overwatch::where("to_date", ">=", $to_date_dt)->where("from_date", "<=", $from_date_dt)->where("user_id","=", Auth::User()->id)->where("lab_id","=", Input::get('lab_select'))->exists()){
                        
                    }
                    else{
                        Overwatch::create(array(
                            'user_id' => Auth::User()->id,
                            'from_date' => $from_date_dt,
                            'to_date' => $to_date_dt,
                            'lab_id' => Input::get('lab_select')
                        ));
                    }
                }
            }
        }

         return Redirect::To('/felugyelet-jelenlet')->with('success', 'Sikeres létrehozás!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Redirect::To('/felugyelet-jelenlet');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Redirect::To('/felugyelet-jelenlet');
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
        return Redirect::To('/felugyelet-jelenlet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ow = Overwatch::find($id);
        if($ow != null){
            if($ow->user_id == Auth::User()->id){
                Overwatch::find($id)->delete();
                return Redirect::to("/felugyelet-jelenlet")->with("success","Sikeres törlés.");   
            }
            else{
                return Redirect::To("/felugyelet-jelenlet");
            }
            
        }
        else{
            return Redirect::To("/felugyelet-jelenlet");
        }
    }
}
