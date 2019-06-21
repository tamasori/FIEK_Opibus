<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'accepted', 'can_access', 'phone_number', 'remember_token', 'github'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'id', 'user_id'];

    public function CanAccessLab($lab){
        $data = json_decode($this->can_access, true);
        if(is_array($data) && array_key_exists("labs", $data)){
          return in_array("all", $data["labs"]) || in_array($lab, $data["labs"]);
        }
        return false;
      }
  
    public function CanAccessMenu($menu){
      $data = json_decode($this->can_access, true);
      if(is_array($data) && array_key_exists("menus", $data)){
        return in_array("all", $data["menus"]) || in_array($menu, $data["menus"]); 
      }
      return false;
    }

    public function CanAccessItem($item){
      $data = json_decode($this->can_access, true);
      if(is_array($data) && array_key_exists("items", $data)){
        return in_array("all", $data["items"]) ||in_array($item, $data["items"]);             
      }
      return false;
    }

    public function AnyMenu(){
      $data = json_decode($this->can_access, true);
      $any = false;
      if(is_array($data) && array_key_exists("menus", $data)){
        if(count($data["menus"]) > 0) $any = true;
      }
      return $any;
    }
}
