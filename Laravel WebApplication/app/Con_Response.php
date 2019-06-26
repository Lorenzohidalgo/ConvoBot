<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Con_Response extends Model
{

    public function sender()
    {
        return $this->hasOne('App\Bot_Users', 'user_chat_id', 'CR_USER_ID');
    }
}
