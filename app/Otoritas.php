<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Otoritas extends Model
{
    protected $table = 'role_user';
    protected $fillable = ['user_id','role_id','user_type'];

    public function user() {
        return $this->hasOne('App\User','id','user_id');
    }
}

