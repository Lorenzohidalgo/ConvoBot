<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alignment extends Model
{
    public function TIM()
    {
        return $this->hasOne('App\Bot_Users', 'user_chat_id', 'AL_TIM');
    }
    public function E1()
    {
        return $this->hasOne('App\Bot_Users', 'user_chat_id', 'AL_1E');
    }
    public function B1()
    {
        return $this->hasOne('App\Bot_Users', 'user_chat_id', 'AL_1B');
    }
    public function E2()
    {
        return $this->hasOne('App\Bot_Users', 'user_chat_id', 'AL_2E');
    }
    public function B2()
    {
        return $this->hasOne('App\Bot_Users', 'user_chat_id', 'AL_2B');
    }
    public function E3()
    {
        return $this->hasOne('App\Bot_Users', 'user_chat_id', 'AL_3E');
    }
    public function B3()
    {
        return $this->hasOne('App\Bot_Users', 'user_chat_id', 'AL_3B');
    }
    public function E4()
    {
        return $this->hasOne('App\Bot_Users', 'user_chat_id', 'AL_4E');
    }
    public function B4()
    {
        return $this->hasOne('App\Bot_Users', 'user_chat_id', 'AL_4B');
    }
}
