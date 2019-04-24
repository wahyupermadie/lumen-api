<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Item;
use App\Template;
class Checklist extends Model
{
    protected $table="checklists";
    protected $dates = ['deleted_at'];
    public $fillable = [
        'object_domain',
        'template_id',
        'object_id',
        'description',
        'is_completed',
        'compeleted_at',
        'due',
        'urgency'
    ];
    public function item()
    {
        return $this->hasMany(Item::class);
    }
    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}