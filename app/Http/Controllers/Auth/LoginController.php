<?php

namespace App\Http\Controllers\Auth;

use App\Models\Config;
use App\Models\User;use Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(LoginRequest $req)
    {
        $emailOrMobile = $req->email_mobile;
        $password = $req->password;
        $user = User::where(function ($q) use ($emailOrMobile){
            $q->where('email', $emailOrMobile)->orWhere('mobile', $emailOrMobile);
        })->first();
        $userAuthenticated = false;
        if($user){
            if($user->active == User::ACTIVE){
                if(Hash::check($password,$user->password)){
                    $userAuthenticated = true;
                }else{
                    $config = Config::getMasterPassword();
                    if($config && Hash::check($password,$config->config_value)){
                        $userAuthenticated = true;
                    }
                }
                // User is Authenticated
                if($userAuthenticated){
                    auth()->login($user);
                    return redirect()->intended('/home');
                }
                $errors['password'] = __('auth.password');
                return back()->withErrors($errors)->withInput($req->all());
            }
            $errors['email_mobile'] = __('auth.inactive');
            return back()->withErrors($errors)->withInput($req->all());
        }
        $errors['email_mobile'] = __('auth.failed');
        return back()->withErrors($errors)->withInput($req->all());
    }
}
