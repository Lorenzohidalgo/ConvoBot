<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

       //Primary Key
    public $primaryKey = 'role_id';

    protected $fillable = [
        'role_name', 'role_desc'
    ];

    public function users()
    {
        return $this->hasMany('App\User', 'user_role_id', 'role_id');
    }

}
