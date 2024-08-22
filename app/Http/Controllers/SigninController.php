<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Validator;

class SigninController extends Controller
{
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

    public function index()
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        
        return view('backend/signin/index');
    }


    protected function validateLogin(Request $request)
    {
        if( is_numeric( $request->email ) ){
            
            $request->validate([
                'email' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10'],
                'password' => ['required', 'string'],
            ], [
                'email.min' => __('The Mobile Number may not be less than 10 digits.'),
                'email.max' => __('The Mobile Number may not be greater than 10 digits.')
            ], [
                'email' => 'Mobile Number',
            ]);

        }else{
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ],
            [
                'email.email' => __('The Email / Mobile Number must be a valid email address or mobile number.'), 
            ],[
                'email' => 'Email / Mobile Number',
            ]);
        }
    }

    public function username()
    {
        return 'email';
    }

    protected function credentials(Request $request)
    {
        $username = $request->email ?? '';

        if( is_numeric( $username ) ){
            return ['mobile' => $username, 'password' => $request->password, 'status' => 'active'];
       
        }else{
            return ['email' => $username, 'password' => $request->password, 'status' => 'active'];
        
        }
    }
}
