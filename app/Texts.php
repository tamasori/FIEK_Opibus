<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Texts extends Model
{
    protected $table = 'texts';

    protected $fillable = ['name', 'user_id', 'command_name', 'text'];

    public static function GetText($id){
        $text = Texts::where('command_name', '=', $id)->get()[0];
        return $text->text;
    }

}
