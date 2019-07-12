<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Post::class, 200)->create()->each(function ($post) {
            
            $limit = rand(2,5);
            $tagIds = \App\Tag::inRandomOrder()->limit($limit)->get()->pluck('id');

            $post->tags()->attach($tagIds);

        });
    }
}
