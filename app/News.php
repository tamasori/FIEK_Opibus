<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = ["title","excerpt","user_id","lead_picture","publish_on","article","status"];

    protected $hidden = ['id', 'user_id'];

}
