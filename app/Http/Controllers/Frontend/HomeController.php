<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Number;

/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.index');
    }
}
