<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Item;
use App\Template;
class Checklist extends Model
{
    protected $table="checklists";
    protected $dates = ['deleted_at'];
    public function item()
    {
        return $this->hasMany(Item::class);
    }
    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}