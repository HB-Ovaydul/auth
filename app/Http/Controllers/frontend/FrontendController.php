<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Show Home Page
     */
    public function ShowHomePage()
    {
        return view('project.home');
    }

    /**
     * Show Home Page
     */
    public function ShowloginPage()
    {
        return view('project.login');
    }
}
