<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = 'groups';

    protected $fillable = [
        'name',
        'user_id',
        'can_access'
      ];

      protected $hidden = ['id', 'user_id'];    

    public function CanAccessLab($lab){
      $data = json_decode($this->can_access, true);
      if($data != null){
        return in_array("all", $data["labs"]) || in_array($lab, $data["labs"]);
      }
      return false;
    }
  
    public function CanAccessMenu($menu){
      $data = json_decode($this->can_access, true);
      if($data != null){
        return in_array("all", $data["menus"]) || in_array($menu, $data["menus"]); 
      }
      return false;
    }

    public function CanAccessItem($item){
      $data = json_decode($this->can_access, true);
      if($data != null){
        return in_array("all", $data["items"]) ||in_array($item, $data["items"]);   
      }
      return false;
    }
}
