<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailText extends Model
{
    protected $table = 'emailtext';
    protected $fillable = ['name', 'command_name', 'description','message'];
    protected $hidden = ['id', 'user_id'];
}
