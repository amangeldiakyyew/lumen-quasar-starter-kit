<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class InformationModel extends Model
{
    use Sluggable;

    protected $table = 'information';
    protected $guarded = [];
    public $timestamps = true;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
