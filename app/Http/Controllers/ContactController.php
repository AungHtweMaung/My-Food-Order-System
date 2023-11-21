<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // userContact page
    public function userContact()
    {
        return view('user.contact.contact');
    }

    // user sendMessage
    public function sendMessage(Request $request)
    {
        $this->messageValidationCheck($request);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ]);

        return back()->with(['MessageSent' => 'Message Sent Successfully.']);
    }

    // Message validation check
    public function messageValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required'
        ])->validate();
    }
}
