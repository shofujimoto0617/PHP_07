<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Carbon;


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

    public function AdminAddContact(){
        return view('admin.contact.create');
    }

    public function AdminStoreContact(Request $request){
        Contact::insert([
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->route('admin.contact')->with('success','Contact Inserted Successfully');     
    }
}
