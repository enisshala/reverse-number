<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Number;

/**
 * Class HomeController.
 */
class PagesController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function terms()
    {
        return view('frontend.terms');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function privacy()
    {
        return view('frontend.privacy');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('frontend.about');
    }
}
