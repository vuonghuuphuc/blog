<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tag extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
    ];

    public function posts()
    {
        return $this->morphedByMany('App\Post', 'taggable');
    }
}
