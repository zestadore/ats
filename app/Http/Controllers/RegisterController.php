<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function companySignup()
    {
        return view('application.profile.register');
    }
}
