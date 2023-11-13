<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\ContactRequest;
// use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact-us.index');
    }

    public function show($contactId)
    {
        $contact = Contact::findOrFail($contactId);

        return view('contact-us.message', ['message' => $contact]);
    }

    public function destroy($contactId)
    {
        $contact = Contact::findOrFail($contactId);

        $contact->delete();

        return redirect()->back()->with('success', 'Contact deleted successfully.');
    }

    public function getAllContacts()
    {
        // $messages = Contact::paginate(10); // Retrieve 10 contact messages per page
        // return view('contact.index', compact('messages'));
        // $messages = Contact::all(); // Assuming you have a "Contact" model
        // $messages = Contact::orderBy('created_at', 'desc')->get();
        $messages = Contact::orderBy('created_at', 'desc')->paginate(9); // Retrieve 10 contact messages per page
        return view('contact-us.contacts', ['messages' => $messages]);
    }

    public function store(ContactRequest $request)
    {
        // Validate the form data using ContactRequest (validation rules) 

        // Store the contact in the database
        Contact::create($request->validated());

        // Flash a success message to the session
        session()->flash('success', 'Your message has been submitted successfully!');

        // Redirect back to the form with the input data and validation errors, if any
        return redirect()->back()->withInput();
    }
}
