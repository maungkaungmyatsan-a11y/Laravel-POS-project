<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //contact Page
    public function contactPage()
    {

        $contactList = Contact::select('contacts.id as contact_id', 'contacts.user_id', 'contacts.user_name', 'contacts.phone', 'contacts.user_email', 'contacts.title', 'contacts.message', 'contacts.created_at')
                                ->when(request('userName'), function ($query) {
                                    $query->where('contacts.user_name', 'like', '%' . request('userName') . '%');
                                })
                                ->orderBy('contacts.created_at', 'desc')
                                ->get();


        return view('admin.dashboard.contact', compact('contactList'));
    }


    public function contactDetails($id){

        $contactList = Contact::find($id);
        return view('admin.dashboard.contactDetails',compact('contactList'));
    }
}
