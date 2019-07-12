<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 
        'description', 
        'body', 
        'published_at',
    ];

    protected $hidden = [
        'body'
    ];

    public function getSlugAttribute(){
        return Str::slug($this->title, '-');
    }


    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function syncTags($tags){

        $tags = collect($tags);
        $tags = $tags->transform(function ($name) {
            return trim(strtolower($name));
        });
        $tags = $tags->unique();
        $tags = $tags->filter()->all();
        

        $tagIds = [];
        foreach($tags as $name){
            $tag = \App\Tag::where('name', $name)->first();
            if(!$tag){
                $tag = new \App\Tag();
                $tag->name = $name;
                $tag->save();
            }
            $tagIds[] = $tag->id;
        }

        $this->tags()->sync($tagIds);

    }

    public function getTags(){
        return $this->tags()->orderBy('name', 'ASC')->get()->pluck('name');
    }

    public function user(){
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }
}
