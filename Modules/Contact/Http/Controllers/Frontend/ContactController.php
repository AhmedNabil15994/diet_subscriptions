<?php

namespace Modules\Contact\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Http\Requests\Frontend\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact::frontend.contact');
    }




    public function sendContact(ContactRequest $request)
    {
        $validated=$request->validated();

        $contactApply= Contact::create($validated);



        return Response()->json([true , __('You\'r  request sent and we will check it soon')]);
    }
}
