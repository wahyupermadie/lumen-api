<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Checklist;
use App\Item;

class Template extends Model
{
    protected $table = "templates";
    protected $dates = ['deleted_at'];
    
    public function checklist()
    {
        return $this->hasOne(Checklist::class);
    }

    public function item()
    {
        return $this->hasMany(Item::class);
    }
}