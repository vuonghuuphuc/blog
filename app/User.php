<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 
        'last_name', 
        'email', 
        'phone_number',
        'password',
        'type',
        'is_banned',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getNameAttribute(){
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getAvatarUrlAttribute(){
        if($this->avatar){
            return Storage::url($this->avatar);
        }
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->email ) ) ) . "?d=mp";
    }
    
    public function scopeAdmin($query){
        return $query->whereIn('type', [
            'root',
            'admin',
            'publisher',
            'writer',
        ]);
    }

    public function scopeMember($query){
        return $query->whereIn('type', [
            'member'
        ]);
    }

    public function getIsAdminAttribute(){
        return in_array($this->type, [
            'root',
            'admin',
            'publisher',
            'writer',
        ]);
    }

    public function posts(){
        return $this->hasMany(\App\Post::class, 'user_id');
    }
}
