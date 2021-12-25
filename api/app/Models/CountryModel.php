<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{
    protected $table = 'country';
    protected $guarded = [];
    public $timestamps = false;

    public function states(){
        return $this->hasMany('App\Models\StateModel','country_id','id');
    }
}
