<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /* ログインしていないとlogin画面に返す */
    // public function __construct(){
    //     $this->middleware('auth');
    // }


    // public function index(){
    //     return view('contact');
    // }

    public function AdminContact(){
        $contacts = Contact::all();
        return view('admin.contact.index',compact('contacts'));
    }
}
