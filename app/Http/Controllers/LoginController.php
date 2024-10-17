<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(REQUEST $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {

            $remember = $request->has('remember');

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {

                // If the "Remember Me" checkbox is checked, store its value in a cookie for 3 days
                if ($remember) {
                    Cookie::queue('remember_me', true, 4320); // 4320 minutes = 3 days
                } else {
                    Cookie::queue(Cookie::forget('remember_me')); // Clear the cookie if unchecked
                }

                if (Auth::user()->role === 'super-admin') {

                    return redirect()->route('superadmin.dashboard');
                } else if (Auth::user()->role === 'admin') {

                    return redirect()->route('admin.dashboard');
                } else {

                    return redirect()->route('account.dashboard');
                }
            } else {

                return redirect()->route('account.login')->with('error', 'Either email or password is incorrect.');
            }
        } else {

            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }
    }

    public function logout(REQUEST $request)
    {
        Auth::logout();
        return redirect()->route('account.login');
    }
}
