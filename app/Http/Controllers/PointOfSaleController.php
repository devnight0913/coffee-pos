<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PointOfSaleController extends Controller
{
    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        return view("pos.show");
    }
}
