<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overwatch extends Model
{
    protected $table = 'overwatch';

    protected $fillable = ['user_id', 'from_date', 'to_date', 'lab_id'];
    protected $hidden = ['id', 'user_id'];

}
