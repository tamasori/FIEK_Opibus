<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    public $NoLog;  //ez fontos ne töröld ki

    protected $table = 'logs';

    protected $fillable = [
        'user_id',
        'connected_id',
        'message',
        'ip_address',
        'old',
        'new'
      ];

    protected $hidden = ['id', 'user_id'];

}
