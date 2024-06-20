<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show home page.
     * 
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        return view("home.show");
    }
}
