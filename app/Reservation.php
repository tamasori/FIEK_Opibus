<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = "reservation";
    
    protected $fillable = ['user_id', 'item_id', 'from_date', 'to_date', 'accepted'];
    protected $hidden = ['id', 'user_id'];
}
