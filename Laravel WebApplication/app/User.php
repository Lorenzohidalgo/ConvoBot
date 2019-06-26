<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_chat_id', 'user_role_id',  'active'
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

    public function teams()
    {
        return $this->belongsToMany('App\Team', 'team_members', 'tm_user_id', 'tm_team_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Role', 'user_role_id', 'role_id');
    }

    public function linked()
    {
        return $this->hasOne('App\Bot_Users', 'user_chat_id', 'user_chat_id');
    }
    
}
