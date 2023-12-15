<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    protected $contactFormMail;

    public function __construct(ContactFormMail $contactFormMail)
    {
        $this->contactFormMail = $contactFormMail;
    }
    
    public function submitForm(Request $request)
    {
        try{
            $data = $request->validate([
                'fname' => 'required|string',
                'lname' => 'required|string',
                'email' => 'required|email',
                'message' => 'required|string',
            ]);
    
            // Send email
            Mail::to('davidkingmushi@gmail.com')->send(new \App\Mail\ContactFormMail($data));
    
            
            return response()->json([
                'status'=> 'success',
                'message' => 'Form submitted successfully'
            ],200);
        }
        catch (\Exception $e) {
            // Log the exception or handle it as needed
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to submit the form. Please try again.',
            ], 500);
        }
    }
}
