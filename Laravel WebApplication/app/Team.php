<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

       //Primary Key


    protected $fillable = [
        'team_name', 'team_desc', 'team_capt_id'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'team_members', 'tm_team_id', 'tm_user_id');
    }

}
