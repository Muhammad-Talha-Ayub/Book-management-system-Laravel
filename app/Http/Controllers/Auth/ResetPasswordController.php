<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    // if we use laravel login form we are going to use the above
    protected $redirectTo='/admin/author';

    public function showResetForm($token)
    {
        // You can pass both the token and the email variables to your view using the compact function
// return view('custom_auth.reset_password', compact('token', 'email'));

        return view('custom_auth.reset_password', compact('token'));
        // return view(‘auth.passwords.reset’, compact(‘email’));
    }
      public function sendEmail(Request $email) 
    { 
    return view(‘custom_auth.email’, compact(‘email’));
      }  
// return view('email', compact('email'));
// Get the email value from the request $email = $request->input(‘email’);
}
