<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingGroupModel extends Model
{

    protected $table = 'setting_group';
    protected $guarded = [];
    public $timestamps = false;

    public function settings()
    {
        return $this->hasMany('App\Models\SettingModel', 'group_id', 'id');
    }
}
