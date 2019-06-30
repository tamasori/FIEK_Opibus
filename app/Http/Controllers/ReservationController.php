<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Reservation;
use Items;
use Auth;
use Redirect;
use Validator;
use Input;
use Errors;
use Overwatch;
use Notifications;
use User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationAcceptedToUser;
use App\Mail\ReservationRefusedToUser;

class ReservationController extends Controller
{
    public function index()
    {
        $res = Reservation::where("to_date",">=", \DB::raw('NOW()'))->get();
        return view("reservations.index")->with("reservations", $res);
    }

    public function acceptAll()
    {
        $res = Reservation::where("to_date",">=", \DB::raw('NOW()'))->orderBy("created_at", "DESC")->get();

        foreach ($res as $r) {
            if($this->canReserve($r->from_date,$r->to_date, $r->item_id)["reserve"]){    
                $r->accepted = 1;
                $r->save();
                Notifications::create([
                    'message' => "Foglalásodat elfogadták: " . Items::find($r->item_id)->name . "(" . $r->from_date . "-" . $r->to_date . ")",
                    'user_id' => $r->user_id,
                    'opened' => 0
                ]);
                $u = User::find($r->user_id);
                Mail::to($u->email)->send(new ReservationAcceptedToUser($u->id));
            }
        }
        
        return view("reservations.index")->with("reservations", $res);
    }

    public function accept($id)
    {
        $r = Reservation::find($id);
        $r->accepted = 1;
        $r->save();
        $res = Reservation::where("to_date",">=", \DB::raw('NOW()'))->orderBy("created_at", "DESC")->get();
        Notifications::create([
            'message' => "Foglalásodat elfogadták: " . Items::find($r->item_id)->name . "(" . $r->from_date . "-" . $r->to_date . ")",
            'user_id' => $r->user_id,
            'opened' => 0
        ]);
        $u = User::find($r->user_id);
        Mail::to($u->email)->send(new ReservationAcceptedToUser($u->id));
        
        
        return view("reservations.index")->with("reservations", $res);
    }

    public function create()
    {
        $items = Items::all()->filter(function($value, $key){
            return Auth::User()->CanAccessItem($value["id"]);
        });

        $template =  str_replace(array("\r\n", "\r", "\n"),'',view("reservations.template")->render());

        return view("reservations.create")->with("items", $items)->with("template", $template);
    }

    private function canReserve($from, $to, $id){

        $item = Items::find($id);

        foreach (Reservation::where("item_id", "=", $id)->orderByRaw('FIELD(user_id, '. Auth::User()->id . ') DESC')->orderBy("user_id")->get() as $res) {
            $res_from = new \DateTime($res->from_date);
            $res_to = new \DateTime($res->to_date);
            
            if($res_from < $to && $res_to > $from){
                if($res->accepted == 1 || $res->user_id == Auth::User()->id){
                    return array("message" => "Ez az időpont már folgalt! ".date("Y-m-d H:i", $from->getTimeStamp()). " - " . date("Y-m-d H:i", $to->getTimeStamp()),
                                 "reserve" => false) ;
                }
                else{
                    return array("message" => "A folglalás ebben az időpontban lehet, hogy később visszautasításra kerül. ".date("Y-m-d H:i", $from->getTimeStamp()). " - " . date("Y-m-d H:i", $to->getTimeStamp()),
                                 "reserve" => true) ;
                }
            }
        }

        if(!Auth::User()->CanAccessItem($id)){
            return array( "message" => "Nincs hozzáférése ehhez az eszközhöz!", "reserve" => false);
        }
        if(Errors::where("item_id", "=", $id)->where("status", "<>", "archive")->exists()){
            return array("message" =>  "Ez az eszköz hibás ezért nem foglalható le", "reserve" => false ) ;
        }
        if(!$item->IsSupervisor(-1)){
            $overwatch = false;
            foreach (Overwatch::whereIn("user_id", (array)json_decode($item->supervisor_id))->where("lab_id", "=", $item->lab_id)->get() as $ow) {
                $from_ow = new \DateTime($ow->from_date);
                $to_ow = new \DateTime($ow->to_date);
                if($from_ow <= $from && $to_ow >= $to){
                    $overwatch = true;
                }
            }
            
            if(!$overwatch){ 
                return array("message" => "Ehhez az eszközhöz felügyelő szükséges, viszont az adott időpontvan nincs elérhető felügyelő. " .date("Y-m-d H:i", $from->getTimeStamp()). " - " . date("Y-m-d H:i", $to->getTimeStamp()), "reserve" => false);
            }
        }

        foreach (Items::all() as $loop_item) {
            if($loop_item->Unaccesible($id)){
                foreach (Reservation::where("item_id", "=", $loop_item->id)->get() as $res) {
                    $res_from = new \DateTime($res->from_date);
                    $res_to = new \DateTime($res->to_date);
                    if($res_from < $to && $res_to > $from){
                        if($res->accepted === 1){
                            return array("message" => "Ez az időpont már folgalt! ".date("Y-m-d H:i", $from->getTimeStamp()). " - " . date("Y-m-d H:i", $to->getTimeStamp()),
                                         "reserve" => false) ;
                        }
                        else{
                            return array("message" => "A folglalás ebben az időpontban lehet, hogy később visszautasításra kerül. ".date("Y-m-d H:i", $from->getTimeStamp()). " - " . date("Y-m-d H:i", $to->getTimeStamp()),
                                         "reserve" => true) ;
                        }
                    }
                }
            }
        }        
        return array("message" => "", "reserve" => true);
    }


    public function store(Request $request, $check = false)
    {
        $rules = array(
            'from_date.*' => 'required',
            'type_select.*' => 'required',
            'from_time.*' => 'required',
            'to_time.*' => 'required',
            'weeks.*' => 'required_if:type_select.*,2',
            'to_date.*' => 'required_if:type_select.*,1',
        );
        $errors = [];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            if($check){
                return $validator;
            }
            return Redirect::to('/foglalas/uj')
                ->withErrors($validator)
                ->withInput();
        }

        $ids = array_keys(Input::get("type_select"));
        foreach ($ids as $id) {
            $errors[$id] = [];
            if(Input::get("type_select")[$id] == 2){
                $begin = \DateTime::createFromFormat('Y.m.d. H.i.s',Input::get('from_date')[$id]." 00.00.00");
                $end = \DateTime::createFromFormat('Y.m.d. H.i.s',Input::get('from_date')[$id]." 00.00.00");
                $end->setTime(23,59,59); 
                $end = date('Y.m.d.', strtotime("+".Input::get("weeks")[$id]." week", $end->getTimeStamp()));
                $end = \DateTime::createFromFormat('Y.m.d.', $end);
    
                $interval = \DateInterval::createFromDateString('1 day');
                $period = new \DatePeriod($begin, $interval, $end);
                

                foreach ($period as $dt) {
                    $day_of_week = date( "w", $dt->getTimeStamp());
                    if(is_array(Input::get("weekday-".$day_of_week)) && array_key_exists($id, Input::get("weekday-".$day_of_week)) && Input::get("weekday-".$day_of_week)[$id]){
                        $dt2 = clone $dt;
                        $dt->modify("+ ".explode(':',Input::get("from_time")[$id])[0]. ' hours')->modify("+ ".explode(':',Input::get("from_time")[$id])[1]. ' minutes');
                        $dt2->modify("+ ".explode(':',Input::get("to_time")[$id])[0]. ' hours')->modify("+ ".explode(':',Input::get("to_time")[$id])[1]. ' minutes');

                        $error = $this->canReserve($dt, $dt2, $id);
                        if(!in_array($error["message"], $errors[$id]) && $error["message"] !== ""){
                            array_push($errors[$id], $error["message"]);
                        }

                        if(!$check && $error["reserve"] === true){
                            Reservation::create(array(
                                'user_id' => Auth::User()->id,
                                'from_date' => date("Y-m-d H:i", $dt->getTimeStamp()),
                                'to_date' => date("Y-m-d H:i", $dt2->getTimeStamp()),
                                'item_id' => $id,
                                'accepted' => "0"
                            ));
                            $u_n = User::whereRaw('can_access LIKE \'%{"menus":["all"]%\' OR can_access LIKE \'%"reservations"%\'')->get();
                                foreach ($u_n as $u) {
                                    Notifications::create([
                                        'message' => "Új foglalási kérelem: " . Items::find($id)->name . "(" . Auth::User()->name . ")",
                                        'user_id' => $u->id,
                                        'opened' => 0
                                    ]);
                                }
                        }
                    }
                }
            }
            else{
                $begin = \DateTime::createFromFormat('Y.m.d. H.i.s',Input::get('from_date')[$id]." 00.00.00");
                $end = \DateTime::createFromFormat('Y.m.d. H.i.s',Input::get('to_date')[$id]." 00.00.00");
                $end->setTime(23,59,59); 
                if(Input::get('from_date')[$id] == Input::get('to_date')[$id]){
                    $begin->modify("+ ".explode(':',Input::get("from_time")[$id])[0]. ' hours')->modify("+ ".explode(':',Input::get("from_time")[$id])[1]. ' minutes');
                    $end->modify("+ ".explode(':',Input::get("to_time")[$id])[0]. ' hours')->modify("+ ".explode(':',Input::get("to_time")[$id])[1]. ' minutes');
                    
                    $error = $this->canReserve($begin, $end, $id);
                    if(!in_array($error["message"], $errors[$id]) && $error["message"] !== ""){
                        array_push($errors[$id], $error["message"]);
                    }
                    if(!$check && $error["reserve"] === true){
                        Reservation::create(array(
                            'user_id' => Auth::User()->id,
                            'from_date' => date("Y-m-d H:i", $begin->getTimeStamp()),
                            'to_date' => date("Y-m-d H:i", $end->getTimeStamp()),
                            'item_id' => $id,
                            'accepted' => "0"
                        ));
                        $u_n = User::whereRaw('can_access LIKE \'%{"menus":["all"]%\' OR can_access LIKE \'%"reservations"%\'')->get();
                            foreach ($u_n as $u) {
                                Notifications::create([
                                    'message' => "Új foglalási kérelem: " . Items::find($id)->name . "(" . Auth::User()->name . ")",
                                    'user_id' => $u->id,
                                    'opened' => 0
                                ]);
                            }
                    }
                }
                else{
                    
                    $interval = \DateInterval::createFromDateString('1 day');
                    $period = new \DatePeriod($begin, $interval, $end);

                    foreach ($period as $dt) {
                        $dt2 = clone $dt;
                        $dt->modify("+ ".explode(':',Input::get("from_time")[$id])[0]. ' hours')->modify("+ ".explode(':',Input::get("from_time")[$id])[1]. ' minutes');
                        $dt2->modify("+ ".explode(':',Input::get("to_time")[$id])[0]. ' hours')->modify("+ ".explode(':',Input::get("to_time")[$id])[1]. ' minutes');
                        
                        $error = $this->canReserve($dt, $dt2, $id);
                        if(!in_array($error["message"], $errors[$id]) && $error["message"] !== ""){
                            array_push($errors[$id], $error["message"]);
                        }
                        if(!$check && $error["reserve"] === true){
                            Reservation::create(array(
                                'user_id' => Auth::User()->id,
                                'from_date' => date("Y-m-d H:i", $dt->getTimeStamp()),
                                'to_date' => date("Y-m-d H:i", $dt2->getTimeStamp()),
                                'item_id' => $id,
                                'accepted' => "0"
                            ));
                            $u_n = User::whereRaw('can_access LIKE \'%{"menus":["all"]%\' OR can_access LIKE \'%"reservations"%\'')->get();
                                foreach ($u_n as $u) {
                                    Notifications::create([
                                        'message' => "Új foglalási kérelem: " . Items::find($id)->name . "(" . Auth::User()->name . ")",
                                        'user_id' => $u->id,
                                        'opened' => 0
                                    ]);
                                }
                        }
                    }
                }
            }
        }
        if($check){
            return $errors;
        }
        return Redirect::To('/foglalas/uj')->with('success', 'Sikeres létrehozás!');
    }


    public function show($id)
    {
        return Redirect::To('/foglalas');
    }

    public function edit($id)
    {
        return Redirect::To('/foglalas');
    }


    public function update(Request $request, $id)
    {
        return Redirect::To('/foglalas');
    }


    public function destroy($id)
    {
        $r = Reservation::find($id);
        
        if($r != null){
            Notifications::create([
                'message' => "Foglalásodat elutasították: " . Items::find($r->item_id)->name . "(" . $r->from_date . "-" . $r->to_date . ")",
                'user_id' => $r->user_id,
                'opened' => 0
            ]);
            $u = User::find($r->user_id);
            Mail::to($u->email)->send(new ReservationRefusedToUser($u->id));
            if($r->user_id == Auth::User()->id){
                Reservation::find($id)->delete();
                if(Auth::User()->CanAccessMenu("rent")){
                    return Redirect::to("/foglalas")->with("success","Sikeres törlés.");   
                }
                else{
                    return Redirect::to("/foglalasaim")->with("success","Sikeres törlés.");  
                }
            }
            else{
                if(Auth::User()->CanAccessMenu("rent")){
                    return Redirect::to("/foglalas");   
                }
                else{
                    return Redirect::to("/foglalasaim");  
                }
            }
            
        }
        else{
            if(Auth::User()->CanAccessMenu("rent")){
                return Redirect::to("/foglalas");   
            }
            else{
                return Redirect::to("/foglalasaim");  
            }
        }
    }
}
