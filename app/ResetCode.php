<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResetCode extends Model
{
    protected $table = 'resetcodes';

    protected $fillable = ['user_id', 'code', 'used'];
    protected $hidden = ['id', 'user_id'];
}
