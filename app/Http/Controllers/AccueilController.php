<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AccueilController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->hasCookie('lang'))
            Cookie::queue('lang', 'jp', 60*24*365);
        return view('accueil');
    }

    public function login(Request $request)
    {

    }

    public function logout()
    {

    }

    public function lang($lang)
    {
        if (in_array($lang, ['cn', 'jp']))
            Cookie::queue('lang', $lang, 60*24*365);
        return redirect('');
    }
}
