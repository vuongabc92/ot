<?php

namespace King\Backend\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Auth controller
 */
class AuthController extends BackController{

    /**
     * Log in
     *
     * @param Illuminate\Http\Request $request
     *
     * @return response
     */
    public function login(Request $request) {

        $pass = true;

        if ($request->isMethod('POST')) {

            $credentials = $request->only('username', 'password');

            if (auth()->attempt($credentials, $request->has('remember'))) {
                return redirect()->intended(route('backend_dashboard'));
            }

            $pass = false;
        }

        return view('backend::auth.login', array('pass' => $pass));
    }

    /**
     * Log out
     *
     * @return redirect
     */
    public function logout() {

        auth()->logout();

        return redirect(route('backend_login'));
    }
}
