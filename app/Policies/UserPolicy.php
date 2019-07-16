<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        if(in_array($user->type, [
            'root',
        ])){
            return true;
        }
    }

    public function view(){
    
    }

    public function create(){
        
    }

    public function update(){
        
    }
    
}
