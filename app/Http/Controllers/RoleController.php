<?php

namespace PYSCore\Http\Controllers;

use Illuminate\Http\Request;

use PYSCore\Http\Requests;
use PYSCore\Http\Controllers\Controller;
use PYSCore\Role;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        if(\Auth::user()->hasRole('update_user_role')) {
            redirect('/');
        }
    }

    public function getAll() {
        return Role::all();
    }
}
