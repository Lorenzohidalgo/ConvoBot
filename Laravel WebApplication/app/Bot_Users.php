<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bot_Users extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_chat_id', 'user_role_id',  'active'
    ];


    public function teams()
    {
        return $this->belongsToMany('App\Team', 'team_members', 'tm_user_id', 'tm_team_id');
    }

    public function linked()
    {
        return $this->hasOne('App\User', 'user_chat_id', 'user_chat_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Role', 'user_role_id', 'role_id');
    }
}
