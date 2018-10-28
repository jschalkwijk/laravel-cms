<?php

namespace CMS\Http\Controllers\admin;

use JornSchalkwijk\LaravelCMS\Models\Contact;
use CMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;

class ContactsController extends Controller
{
    use ControllerActionsTrait;

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

    public function action(Request $r,Contact $contact)
    {
        $this->Actions($r,$contact);
        return back();
    }


}
