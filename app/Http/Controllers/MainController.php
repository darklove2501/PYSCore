<?php

namespace PYSCore\Http\Controllers;

use PYSCore\Http\Requests;

class MainController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index() {
        return view("layouts.admin");
    }

    public function angularValidationMessages(){
        return view('angularValidationMessages');
    }
}
