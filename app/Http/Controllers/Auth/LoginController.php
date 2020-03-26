<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LdapRecord\Laravel\Auth\ListensForLdapBindFailure;
use App\Ldap\User;

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

    use AuthenticatesUsers,ListensForLdapBindFailure;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->listenForLdapBindFailure();
    }

    public function username(){
        return 'username';
    }

    protected function credentials(Request $request)
    {
        return [
            'samaccountname' => $request->get('username'),
            'password' => $request->get('password'),
        ];
    }

    public function getLogin()
    {
        $users = User::get();
        dd($users);
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
       // $credentials = $request->only('username', 'password');

        if (Auth::attempt($this->credentials($request))) {
            dd('login');
            //return redirect()->intended('dashboard');
        }

        dd('no login');
    }
}
