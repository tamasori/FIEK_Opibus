<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Errors extends Model
{
    protected $table = 'errors';
    protected $fillable = ['user_id', 'worker_id', 'description','item_id','status'];
    protected $hidden = ['id', 'user_id'];
}
