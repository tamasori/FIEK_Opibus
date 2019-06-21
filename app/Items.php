<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use User;

class Items extends Model
{
    protected $table = 'items';

    protected $fillable = ['user_id', 'name', 'description', 'youtube_link', 'image', 'rules', 'lab_id', 'supervisor_id', 'remote_access'];

    protected $hidden = ['id', 'user_id'];

    public function Unaccesible($item){
        $data = json_decode($this->rules, true);
        if($data != null){
            return in_array($item, $data);   
        }
        return false;
    }

    public function IsSupervisor($id){
        $data = (array)json_decode($this->supervisor_id);
        if($data != null){
            return in_array($id, $data);   
        }
        return false;
    }

    public function Supervisors(){
        $string = ""; 
        foreach ((array)json_decode($this->supervisor_id) as $value) {
            if($value == -1){
                $string .= "Nincs felügyelő, ";
            }
            else{   
                $string .= User::find($value)->name . ", ";
            }
        }

        return substr($string, 0, -2);
    }
}
