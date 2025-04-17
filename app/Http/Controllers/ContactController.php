<?php

namespace App\Http\Controllers;

use App\Mail\ContactFilled;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            // 'phone' => 'required|digits:10|numeric',
            'subject' => 'required',
            'message' => 'required'
        ]);

        $contact = Contact::create($request->all());

        Mail::to('cinarcanturk@mi.com.tr')->queue(new ContactFilled($contact));

        return back();


    }
}
