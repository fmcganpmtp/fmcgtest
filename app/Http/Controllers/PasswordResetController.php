<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Auth;
use Carbon\Carbon;

use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function index()
    {   
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('frontend/password-reset/index');
    }


    public function reset(Request $request)
    {
        if( is_numeric( $request->email ) ){
            
            $validator = Validator::make(request()->all(), [
                'email' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10'],
            ],[
                'email.min' => __('The Mobile Number may not be less than 10 digits.'),
                'email.max' => __('The Mobile Number may not be greater than 10 digits.')
            ]);

            $validator->setAttributeNames([
                'email' => 'Mobile Number',
            ]);
 
        }else{

            $validator = Validator::make(request()->all(), [
                'email' => ['required', 'email'],
            ],[
                'email.email' => __('The Email / Mobile Number must be a valid email address or mobile number.'), 
            ]);

            $validator->setAttributeNames([
                'email' => 'Email / Mobile Number',
            ]);
        }
 

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
 
        DB::beginTransaction();
        try {
 
            $otp = mt_rand(100000,999999);
            $email = $request->email;

            if( is_numeric( $email ) ){
                $user = User::where('mobile', $email)->where('status', 'active')->where('mobile_verified', 1)->first();

            }else{
                $user = User::where('email', $email)->where('status', 'active')->where('email_verified', 1)->first();
            }
 
            if($user){

                                
                $user->update([
                    'otp' => $otp
                ]);

                if($user->email != '' && $user->email_verified == 1){
                    Mail::to($user->email)->send( new OtpMail($otp)); 
                }

                sendSms($user->mobile, 'Your OTP to Register / Access @laptopspareworld.com is ' . $user->otp . '. It will be valid for 3 minutes.', '1307164086364084790');


            }else{

                return response()->json([
                    'errors' => [
                        'email' => [
                            'Account is blocked or not available.'
                        ]
                    ],
                ]);

            } 
 
        } catch (\Exception $e) {

            DB::rollback();
 
            return response()->json([
                'errors' => [
                    'email' => [
                        'Something went wrong.'
                    ]
                ],
            ]);
        }

        DB::commit();
 
        return response()->json([
            'jquery' => [
                'element' => '#password-reset',
                'method' => 'html',
                'value' => view('frontend/password-reset/verify', compact('email'))->render()
            ],
            'init' => ['#password-reset']
        ]);
    }

    public function verify(Request $request)
    {   

        $validator = Validator::make(request()->all(), [
            'otp' => ['required', 'min:6', 'max:6'],
            'email' => ['required'],
            'password' => ['required', 'min:6']
        ],[
            'otp.min' => 'Invalid OTP,  Try again!',
            'otp.max' => 'Invalid OTP, Try again!',
            'mobile.required' => 'Invalid OTP, Try again!'
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
 
        DB::beginTransaction();
        try {

            $email = $request->email;

            if( is_numeric( $email ) ){
                $user = User::where('mobile', $email)->where('status', 'active')->where('mobile_verified', 1)->where('otp', $request->otp)->first();
            }else{
                $user = User::where('email', $email)->where('status', 'active')->where('email_verified', 1)->where('otp', $request->otp)->first();
            }  
 
            if(!$user){
                return response()->json([
                    'errors' => [
                        'otp' => [
                            'Invalid OTP, Try again!'
                        ]
                    ]
                ]);
            }


            if( is_numeric( $email ) ){
                $user = User::where('mobile', $email)->where('status', 'active')->where('mobile_verified', 1)->where('otp', $request->otp)->where('updated_at', '>=', Carbon::now()->subMinutes(3)->toDateTimeString())->first();
            }else{
                $user = User::where('email', $email)->where('status', 'active')->where('email_verified', 1)->where('otp', $request->otp)->where('updated_at', '>=', Carbon::now()->subMinutes(3)->toDateTimeString())->first();
            }  

            if(!$user){
                return response()->json([
                    'errors' => [
                        'otp' => [
                            'OTP expired, Try again!'
                        ]
                    ],
                    'redirect' => route('home') 
                ]);
            }

            $user->update([
                'mobile_verified' => 1,
                'password' => Hash::make($request->password)
            ]);

            Auth::login($user);
            
        } catch (\Exception $e) {

            DB::rollback();
 
            return response()->json([
                'errors' => [
                    'otp' => [
                        'Something went wrong.'
                    ]
                ],
            ]);
        }

        DB::commit();

        return response()->json([
            'redirect' => route('home'),
        ]);
    }

}
