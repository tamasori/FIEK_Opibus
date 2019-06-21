<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Labs extends Model
{
    protected $table = 'labs';

    protected $fillable = [
        'name',
        'short_name',
        'user_id',
        'place'
      ];

    protected $hidden = ['id', 'user_id'];

}
