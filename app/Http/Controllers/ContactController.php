<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /* ログインしていないとlogin画面に返す */
    public function __construct(){
        $this->middleware('auth');
    }


    public function index(){
        return view('contact');
    }
}
