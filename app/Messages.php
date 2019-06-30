<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Messages extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'opened',
      ];
    protected $hidden = ['id', 'user_id'];

}
