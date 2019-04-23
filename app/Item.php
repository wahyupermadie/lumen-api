<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Item extends Model
{
    use SoftDeletes;
    protected $table = "items";
    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'is_completed',
        'checklist_id',
        'due',
        'urgency',
        'compeleted_at',
        'last_update_by',
    ];
}