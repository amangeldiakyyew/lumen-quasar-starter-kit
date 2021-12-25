<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class CategoryModel extends Model
{
    use Sluggable;

    protected $table = 'category';
    protected $guarded = [];
    public $timestamps = true;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\CategoryModel', 'parent_id', 'id');
    }

    public function parents()
    {
        return $this->parent()->with('parents');
    }

    public function children()
    {
        return $this->hasMany('App\Models\CategoryModel', 'parent_id', 'id');
    }

    public function recursiveChildren()
    {
        return $this->children()->with('recursiveChildren');
    }
}
