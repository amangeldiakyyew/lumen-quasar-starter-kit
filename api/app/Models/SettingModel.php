<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{

    protected $table = 'setting';
    protected $guarded = [];
    public $timestamps = false;

    public function group()
    {
        return $this->belongsTo('App\Models\SettingGroupModel', 'group_id', 'id');
    }
}
