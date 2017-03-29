<?php

namespace CMS\Http\Controllers\admin;

use CMS\Models\Contact;
use CMS\Models\UserActions;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;

class ContactsController extends Controller
{
    use UserActions;

    public function index()
    {
        $contacts = Contact::with('user')->where('trashed',0)->orderBy('contact_id','desc')->get();
        return view('admin.contacts.contacts')->with(['template'=>$this->adminTemplate(),'contacts'=>$contacts,'trashed' => 0]);
    }
    public function deleted()
    {
        $contacts = Contact::with('user')->where('trashed',1)->orderBy('contact_id','desc')->get();
        return view('admin.contacts.contacts')->with(['template'=>$this->adminTemplate(),'contacts'=>$contacts,'trashed' => 1]);
    }
    public function create()
    {

    }
    public function store(Request $r)
    {

    }

    public function update(Request $r,Contact $contact)
    {

    }

    public function edit(Contact $contact)
    {

    }

    public function action(Request $r)
    {
        $this->Actions($r,'contacts');
        return back();
    }


}
