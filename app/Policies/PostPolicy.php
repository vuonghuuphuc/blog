<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(User $user)
    {
        if(!$user->email_verified_at){
            return false;
        }

        if(in_array($user->type, [
            'root',
            'admin',
            'publisher'
        ])){
            return true;
        }
    }

    public function create(User $user){
        return in_array($user->type, [
            'writer',
        ]);
    }

    public function update(User $user, Post $post){
        return $user->id == $post->user_id;
    }

    public function publish(User $user){
        
    }

}
