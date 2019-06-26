<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMembers extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'team_members';

       //Primary Key
   public $primaryKey = 'id';

    protected $fillable = [
        'tm_team_id', 'tm_user_id'
    ];



}
