<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Checklist;
use App\Item;
use Illuminate\Database\Eloquent\SoftDeletes;
class Template extends Model
{
    use SoftDeletes;
    protected $table = "templates";
    protected $dates = ['deleted_at'];
    public $fillable = [
        'name',
    ];
    public function checklist()
    {
        return $this->hasOne(Checklist::class);
    }

    public function item()
    {
        return $this->hasMany(Item::class);
    }
}