<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateModel extends Model
{
    protected $table = 'state';
    protected $guarded = [];
    public $timestamps = false;

    public function country(){
        return $this->belongsTo('App\Models\CountryModel','country_id','id');
    }
}
