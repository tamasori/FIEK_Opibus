<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Groups;
use Redirect;
use Input;
use Validator;
use Config;
use Labs;
use Items;
use Auth;
use App\EmailText;

class EmailTextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("emailTexts.index");
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $EmailText = EmailText::find($id);
        if($EmailText != null){
            return view("emailTexts.edit")->with("current", $EmailText);
        }
        else{
            return Redirect::To("/email-szovegek");
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
        $EmailText = EmailText::find($id);
        if($EmailText != null){
            
            $EmailText->message = Input::get("text");
            $EmailText->save();

            $templateFile = fopen(resource_path("views/emailTemplates/" . $EmailText->command_name . ".blade.php"), "w");
            fwrite($templateFile,str_replace("&gt;",">",$EmailText->message)  );
            fclose($templateFile);

            return Redirect::To('/email-szovegek')->with('success', 'Sikeres szerkesztés!');
        }
        else{
            return Redirect::To("/email-szovegek");
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
