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
        if (Auth::check()) {

            if (Auth::user()->role === "super-admin") {
                return view('superadmin.dashboard');
            } else if (Auth::user()->role === "admin") {
                return view('admin.dashboard');
            } else {
                return view('dashboard');
            }
        } else {
            return view('login');
        }
    }

    public function authenticate(REQUEST $request)
    {

        $validator = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|email|exists:users,email',
            'password' => [
                'required',
                'min:8',                  // Minimum 8 characters
                'regex:/[a-z]/',          // At least one lowercase letter
                'regex:/[A-Z]/',          // At least one uppercase letter
                'regex:/[0-9]/',          // At least one number
                'regex:/[@$!%*#?&]/'      // At least one special character
            ],
            'remember' => 'sometimes|boolean', // Validate "remember me" checkbox
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

                    return redirect()->intended('superadmin/dashboard');
                } else if (Auth::user()->role === 'admin') {

                    return redirect()->intended('admin/dashboard');
                } else {

                    // return redirect()->route('account.dashboard');
                    return redirect()->intended('account/dashboard');
                }
            } else {

                return redirect()->intended('account/login')->with('error', 'Either email or password is incorrect.');
            }
        } else {

            return redirect()->intended('account/login')->withInput()->withErrors($validator);
        }
    }

    public function logout(REQUEST $request)
    {
        Auth::logout();
        return redirect()->route('account.login');
    }
}
