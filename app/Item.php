<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = "items";
    protected $dates = ['deleted_at'];
}