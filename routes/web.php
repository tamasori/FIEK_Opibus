<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Support\Facades\Mail;
use App\Mail\ItemErrorSubmittedToAdmin;

Route::get('/kijelentkezes', function () {
    if($user = Auth::user())
    {
        Auth::logout();
    }
    return Redirect::to("/belepes");
});

Route::get('/elfelejtett-jelszo/{code?}', "ResetCodeController@index");
Route::post('/elfelejtett-jelszo', "ResetCodeController@store");

Route::get('/testing', function () {
    return view("test");
});

Route::get('/', function () {
    if($user = Auth::user())
    {
        $items = Items::all()->filter(function($value, $key){
            return Auth::User()->CanAccessItem($value["id"]);
        });
        return view('vezerlopult')->with("items", $items);
    }
    return Redirect::to("/belepes");
});

Route::post('/', function () {
    if($user = Auth::user())
    {
        if(Input::get("type") == "error"){
            $rules = array(
                'item_id'    => 'required|exists:items,id', 
                'description' => 'required' 
            );
            
            $validator = Validator::make(Input::all(), $rules);
            
            
            if ($validator->fails()) {
                return Redirect::to('/')
                    ->withErrors($validator) 
                    ->withInput();
            } else {
                $error = Errors::create(array(
                    'user_id' => Auth::User()->id,
                    'item_id' => Input::get("item_id"),
                    'description' => Input::get("description"),
                    'status' => "published",
                    'worker_id' => "-1"
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
                return Redirect::to('/')
                    ->with("success","Sikeres bejelentés!");
            }
        }
    }
    return Redirect::to("/belepes");
});

Route::get('/belepes', function () {
    if($user = Auth::user())
    {
        return Redirect::to("/");
    }
    return view('login');
});

Route::post('/regisztracio', 'RegistrationController@store');

Route::get('/regisztracio', 'RegistrationController@create');
Route::get('/sikeres-regisztracio', function (){
    return view("sikeresRegisztracio");
});

Route::post('/belepes', function () {
    $rules = array(
        'email'    => 'required|email', 
        'password' => 'required|min:3' 
    );
    
    $validator = Validator::make(Input::all(), $rules);
    
    
    if ($validator->fails()) {
        return Redirect::to('belepes')
            ->withErrors($validator) 
            ->withInput(Input::except('password'));
    } else {
    
        $userdata = array(
            'email'     => Input::get('email'),
            'password'  => Input::get('password')
        );
    
        if (Auth::attempt($userdata)) {
            
            if(Auth::User()->accepted == "0"){
                Auth::logout();
                return Redirect::to('belepes')->withErrors(["invalidUserData" => "A fiók még nincs elfogadva munkatársaink által. Az feldolgozásig szíves türelmét kérjük!"]);
            }
            return Redirect::to('/');
    
        } else {        
    
            return Redirect::to('belepes')->withErrors(["invalidUserData" => "A megadott email cím és jelszó páros nem létezik adatbázisunkban!"]);
    
        }
    }
});


Route::group(['middleware' => 'auth'], function () {

    //Információ
    Route::get("/informaciok", function(){
        return view("information");
    });
    

    //Felhasználó legördülő menü
    Route::get("/profil-szerkesztese", 'UserDropdownActions@myprofile');
    Route::put("/profil-szerkesztese", 'UserDropdownActions@myprofileUpdate');
    Route::get("/foglalasaim", 'UserDropdownActions@myreservations');
    Route::get("/tevekenysegem", 'UserDropdownActions@mylogs');
    
    //Laborok
    Route::group(['middleware' => 'menu:labs'], function(){
        Route::get("/laborok", 'LabsController@index');
        Route::get("/laborok/uj", 'LabsController@create');
        Route::get("/laborok/{id}", 'LabsController@edit');
        
        Route::post("/laborok/uj", 'LabsController@store');
        Route::put("/laborok/{id}", 'LabsController@update');
        Route::delete("/laborok/{id}/", 'LabsController@destroy');
    });


    //Felhasználók
    Route::group(['middleware' => 'menu:users'], function(){
        Route::get("/felhasznalok", 'UserController@index');
        Route::get("/felhasznalok/uj", 'UserController@create');
        Route::get("/felhasznalok/{id}/szerkeszt", 'UserController@edit');
        Route::get("/felhasznalok/{id}", 'UserController@show');
        Route::get("/activate-user/{gid}/{uid}", 'UserController@activateUser');

        Route::post("/felhasznalok/uj/", 'UserController@store');
        Route::put("/felhasznalok/{id}/szerkeszt/", 'UserController@update');
        Route::delete("/felhasznalok/{id}/", 'UserController@destroy');
    });

    //Felhasználói csoportok
    Route::group(['middleware' => 'menu:groups'], function(){
        Route::get("/felhasznalo-csoportok", 'GroupsController@index');
        Route::get("/felhasznalo-csoportok/uj", 'GroupsController@create');
        Route::get("/felhasznalo-csoportok/{id}/szerkeszt", 'GroupsController@edit');
        Route::get("/felhasznalo-csoportok/{id}", 'GroupsController@show');

        Route::post("/felhasznalo-csoportok/uj", 'GroupsController@store');
        Route::put("/felhasznalo-csoportok/{id}/szerkeszt", 'GroupsController@update');
        Route::delete("/felhasznalo-csoportok/{id}", 'GroupsController@destroy');
    });

    //Szövegek
    Route::group(['middleware' => 'menu:texts'], function(){
        Route::get("/szovegek", 'TextsController@index');
        Route::get("/szovegek/uj", 'TextsController@create');
        Route::get("/szovegek/{id}/szerkeszt", 'TextsController@edit');
        Route::get("/szovegek/{id}", 'TextsController@show');

        Route::post("/szovegek/uj", 'TextsController@store');
        Route::put("/szovegek/{id}/szerkeszt", 'TextsController@update');
        Route::delete("/szovegek/{id}", 'TextsController@destroy');
    });

    //Hírek
    Route::group(['middleware' => 'menu:news'], function(){
        Route::get("/hirek", 'NewsController@index');
        Route::get("/hirek/uj", 'NewsController@create');
        Route::get("/hirek/{id}/szerkeszt", 'NewsController@edit');
        

        Route::post("/hirek/uj", 'NewsController@store');
        Route::put("/hirek/{id}/szerkeszt", 'NewsController@update');
        Route::delete("/hirek/{id}", 'NewsController@destroy');
    });
    Route::get("/hirek/{id}", 'NewsController@show');

    //Eszközök
    Route::group(['middleware' => 'menu:items'], function(){
        Route::get("/eszkozok", 'ItemsController@index');
        Route::get("/eszkozok/uj", 'ItemsController@create');
        Route::get("/eszkozok/{id}/szerkeszt", 'ItemsController@edit');
        Route::get("/eszkozok/{id}", 'ItemsController@show');

        Route::post("/eszkozok/uj", 'ItemsController@store');
        Route::put("/eszkozok/{id}/szerkeszt", 'ItemsController@update');
        Route::delete("/eszkozok/{id}", 'ItemsController@destroy');
    });


    //Hibabejelentések
    Route::group(['middleware' => 'menu:errors'], function(){
        Route::get("/hiba-bejelentesek", 'ErrorsController@index');
        Route::get("/hiba-bejelentesek/uj", 'ErrorsController@create');
        Route::get("/hiba-bejelentesek/{id}/szerkeszt", 'ErrorsController@edit');
        Route::get("/hiba-bejelentesek/{id}", 'ErrorsController@show');

        Route::post("/hiba-bejelentesek/uj", 'ErrorsController@store');
        Route::put("/hiba-bejelentesek/{id}/szerkeszt", 'ErrorsController@update');
        Route::delete("/hiba-bejelentesek/{id}", 'ErrorsController@destroy');
    });


    //Felügyelet
    Route::group(['middleware' => 'menu:overwatch'], function(){
        Route::get("/felugyelet-jelenlet", 'OverwatchController@index');
        Route::get("/felugyelet-jelenlet/uj", 'OverwatchController@create');

        Route::post("/felugyelet-jelenlet/uj", 'OverwatchController@store');
        Route::delete("/felugyelet-jelenlet/{id}", 'OverwatchController@destroy');
    });

    //Foglalás
    Route::group(['middleware' => 'menu:rent'], function(){
        Route::get("/foglalas", 'ReservationController@index');
        Route::get("/foglalas/elfogad-mind", 'ReservationController@acceptAll');
        Route::post("/foglalas/elfogad/{arr}", 'ReservationController@accept');

    });
    Route::get("/foglalas/uj", 'ReservationController@create');
    Route::post("/foglalas/uj", 'ReservationController@store');
    Route::delete("/foglalas/{id}", 'ReservationController@destroy');


    Route::group(['middleware' => 'menu:emails'], function(){
        Route::get("/email-szovegek", 'EmailTextController@index');
        Route::get("/email-szovegek/{id}/szerkeszt", 'EmailTextController@edit');
        Route::put("/email-szovegek/{id}/szerkeszt", 'EmailTextController@update');

    });

    Route::get("/fiokom", function(){

        DB::table('notifications')->where('user_id', '=', Auth::User()->id)->update(array('opened' => 1));
        DB::table('messages')->where('user_id', '=', Auth::User()->id)->update(array('opened' => 1));
        return view("userDropdownActions.emailandnoti");

    });
    Route::get("/get/item/{id}",  function ($id) {

        $item = DB::table('items')->where("id", "=", $id)->get()->toJson();
        return $item;

    });

    Route::post("/get/check", function(){
       return app()->call("App\Http\Controllers\ReservationController@store", ["check" => true]);
    });

});


