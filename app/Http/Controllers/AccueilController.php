<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $user = DB::table('users')->where('mail', $request->post()['mail'])->first();

        if (Hash::check($request->post()['pass'], $user->pass)) {
            session(['token' => $user->token]);
            flash('Connexion réussie, bonjour ' . $user->pseudo)->success();
        } else flash('Identification incorrecte')->warning();
        return redirect('/');
    }

    public function logout()
    {
        session()->forget('token');
        return redirect('/');
    }

    public function lang($lang)
    {
        if (in_array($lang, ['cn', 'jp', 'kr']))
            Cookie::queue('lang', $lang, 60*24*365);
        return redirect('');
    }
}
