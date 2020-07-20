<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class LegalController extends BaseController
{
    public function mentorRegister(Request $request)
    {
        return view('web.legal.users.register.mentor');
    }

    public function learnerRegister(Request $request)
    {
        return view('web.legal.users.register.learner');
    }
}
