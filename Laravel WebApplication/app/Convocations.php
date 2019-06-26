<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convocations extends Model
{

    public function sender()
    {
        return $this->hasOne('App\Bot_Users', 'user_chat_id', 'CON_USER_ID');
    }

    public function team()
    {
        return $this->hasOne('App\Team', 'id', 'CON_TEAM_ID');
    }

    public function cancel()
    {
        return $this->hasOne('App\Cancel_Type', 'CT_ID', 'CON_CT');
    }

    public function training()
    {
        return $this->hasOne('App\Training_Type', 'TT_ID', 'CON_TT');
    }

    public function alignment()
    {
        return $this->hasOne('App\Alignment', 'AL_CON_ID', 'CON_ID');
    }

    public function accepted()
    {
        return $this->hasMany('App\Con_Response', 'CR_CON_ID', 'CON_ID')->where('CR_MSG', 'ACCEPTED');
    }

    public function denied()
    {
        return $this->hasMany('App\Con_Response', 'CR_CON_ID', 'CON_ID')->where('CR_MSG', '!=', 'ACCEPTED');
    }
}
