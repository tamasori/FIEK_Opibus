<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $table = 'notifications';
    protected $fillable = ["message", "user_id", "opened"];
    protected $hidden = ['id', 'user_id'];

}
