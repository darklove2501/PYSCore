<?php

namespace PYSCore;

use Illuminate\Database\Eloquent\Model;

class Role extends \Eloquent
{
    protected $table = 'roles';

    public $fillable = ['name'];

    public $timestamps = false;

    public function users() {
        return $this->belongsToMany('User', 'users_roles');
    }
}
