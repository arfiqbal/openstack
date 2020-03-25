<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/all-vm';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function username(){
    //     return 'username';
    // }

    // protected function credentials(Request $request)
    // {
    //     return [
    //         'samaccountname' => $request->get('username'),
    //         'password' => $request->get('password'),
    //     ];
    // }

    public function authenticate(Request $request)
    {
       // $credentials = $request->only('username', 'password');

        if (Auth::attempt($this->$credentials)) {
            dd('login');
            //return redirect()->intended('dashboard');
        }

        dd('no login');
    }
}
