<?php

namespace App\Http\Middleware;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\BuyerCompany;
use App\Models\Package;
use App\Models\Subscription;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard === 'admin') {
                    return redirect(RouteServiceProvider::ADMIN);
                }
                else {
                    if(Auth::guard('user')->user()) {
                        
                        $id = Auth::guard('user')->user()->id;
                        if(Auth::guard('user')->user()->seller_type=="Co-Seller")
                        $id = Auth::guard('user')->user()->parent_id;
                        
                        if(Auth::guard('user')->user()->email_status=="No")
                        { 

                    //         $token =Str::random(60) .$id. date("Ymdss");
                            
                    //         $token=Hash::make($token);
                    //         $token=str_replace('/','a', $token);
		                  //  $token=str_replace('%','a', $token);

                    //         $token_exists = DB::table("users")->where("token_number", $token)->exists();
                    //         while ($token_exists) {
                    //             $token =Str::random(60) .$id. date("Ymdss");
                    //             $token=Hash::make($token);
                    //             $token=str_replace('/','a', $token);
                    //     		$token=str_replace('%','a', $token);

                    //             $token_exists = DB::table("users")->where("token_number", $token)->exists();
                    //             if (!$token_exists)
                    //                 break;
                    //         }
                            
                    //         DB::table("users")
                    //             ->where("id", $id)
                    //             ->update(["token_number" => $token]);
                    //       $email_id=Auth::guard("user")->user()->email;
                           // email verification
                            // Mail::send(
                            //     "emails.KYCApprovalMailTemplate",
                            //     ["token" => $token],
                            //     function ($message)  {
                            //         $email = Auth::guard("user")->user()->email;
                            //         $message->to($email);
                            //         $message->subject("Verify Email - FMCG");
                            //     }
                            // );
                           // Session::flush();
                           // Auth::guard('user')->logout(); 
                           //return redirect(route('user-login'))->with('message','Email_not_verified:'.$email_id); 
                        } 

                        if(Auth::guard('user')->user()->status=='Deleted'||Auth::guard('user')->user()->status=='Blocked'||Auth::guard('user')->user()->status=='Rejected')
                        { 
                                    Session::flush();
                                    Auth::guard('user')->logout(); 
                                    return redirect(route('home'))->with('message','You are not allowed to login'); 
                        }    

                        if(Auth::guard('user')->user()->seller_type=='Co-Seller'){
                            $parent_id=Auth::guard('user')->user()->parent_id;
                            $package_data = DB::table('subscriptions')
                                            ->leftJoin('order_details', 'subscriptions.order_id', '=', 'order_details.id')
                                            ->leftJoin('packages', 'packages.id', '=', 'order_details.package_id')
                                            ->leftJoin('package_accounts', 'package_accounts.id', '=', 'order_details.accounts_id')
                                            ->where('subscriptions.user_id', '=',$parent_id)
                                            ->where('subscriptions.status','Active')
                                            ->select('subscriptions.id','subscriptions.expairy_date','packages.subscription_type')
                                            ->orderBy('subscriptions.id','DESC')->first();
                                                     
                            if(!empty($package_data)){  
                                //if( $package_data->subscription_type=='Extended' && $package_data->expairy_date>=date('Y-m-d'))
                                if( $package_data->expairy_date>=date('Y-m-d'))
                                {
 
                                }
                                else
                                { 
                                  
                                  ///////////////////////////////
									    $user_parent_id = Auth::guard('user')->user()->parent_id;
                                        $user=User::find($user_parent_id);
                                        
                                        $updt_old = DB::table("subscriptions")
                                                        ->where("user_id", $user_parent_id)
                                        				->where('status','Active')
                                                        ->orderBy("id", "desc")
                                                        ->take(1);
                                        $package = Package::where('status','Active')
                                        			->orderBy("package_basic_price", "asc")
                                        			->first();				
                                        
                                        
                                       $order_data=array(
                                        'user_id'=>$user_parent_id,
                                        'package_id'=> $package->id,
                                        'order_type'=>'',
                                        'name'=>$user->name??'',
                                        'email'=>$user->email??'',
                                        'phone'=>$user->phone??'',
                                        'address'=>$user->address??'',
                                        'country'=>$user->country_id??'',
                                        'zip'=>$user->store_zip??'',
                                        'city'=>$user->store_city??'',
                                        ); 
                                        $order=OrderDetail::create($order_data); 
                                        
                                        			$updt_old->update(["status" => "Expired"]);
                                        			$input = [
                                                    "user_id" => $user_parent_id,
                                                    "package_id" => $package->id,
                                                    "type" => 'seller',
                                                    "date" => Carbon::today(),
                                                    "order_id" => $order->id,
                                                    "order_total" => 0,
                                                    "auto_renewal" => 1,
                                        			"expairy_date" => Carbon::now()->addMonths(12),
                                        			"status" => "Active",
                                                ];
                                                 $subscription =   Subscription::create($input);
									    ///////////////////////////////
                                  
                                  
                                   /* Session::flush();
                                    Auth::guard('user')->logout(); 
                                    return redirect(route('home'))->with('message','Access Not Allowed,Please Check Your Package Validity'); */
                                }                          
                            }

                        }       


                   // $user =OrderDetail::where('user_id',$id)->first(); 
                    
                    $user =User::find($id);
                    
                    
                    
                    $package_data = DB::table('subscriptions')
                                            ->leftJoin('order_details', 'subscriptions.order_id', '=', 'order_details.id')
                                            ->leftJoin('packages', 'packages.id', '=', 'order_details.package_id')
                                           /// ->leftJoin('package_accounts', 'package_accounts.id', '=', 'order_details.accounts_id')
                                            ->where('subscriptions.user_id', '=',$id)
                                            ->where('subscriptions.status','Active')
                                            ->select('subscriptions.id','subscriptions.expairy_date','packages.subscription_type')
                                            ->orderBy('subscriptions.id','DESC')->first();
								if(!empty($package_data)){  
									if( $package_data->expairy_date>=date('Y-m-d'))
									{
									    $company_image=$user->BuyerCompany->company_image??'';
									    $about_company=$user->BuyerCompany->about_company??'';
										if(($company_image=='') ||($about_company==''))
											return redirect(route('MyCompanyProfile'));
										
										
										//check logged out from admin
										$prev_url = url('').'/login/admin';
										$prev_url1 = url('').'/login/user';
                                        $prev_url2 = url('').'/register/user';
                                        $prev_url3 = url('').'/forgot-password';
                                        $prev_url4 = url('').'/add-password';
                                        $prev_url5 = url('').'/password/reset';
                                        $prev_url6 = url('').'/employees/password/reset';
                                        
										if (session()->has('link') && (session('link') != $prev_url) && (session('link') != $prev_url1) && (session('link') != $prev_url2)  && (session('link') != $prev_url3)  && (session('link') != $prev_url4)  && (session('link') != $prev_url5)  && (session('link') != $prev_url6) && !str_contains(session('link'), $prev_url4) && !str_contains(session('link'), $prev_url) && !str_contains(session('link'), $prev_url1) && !str_contains(session('link'), $prev_url2) && !str_contains(session('link'), $prev_url3)  && !str_contains(session('link'), $prev_url5) && !str_contains(session('link'), $prev_url6))
											return redirect(session('link'));
										else
											return redirect(route('home'));
										session()->forget('link');
                            
									}
									else
									{ 
									    /////////////////////////////// add free package to expired users
									    $user_id = Auth::guard('user')->user()->id;
                                        $user=User::find($user_id);
                                        
                                        $updt_old = DB::table("subscriptions")
                                                        ->where("user_id", $user_id)
                                        				->where('status','Active')
                                                        ->orderBy("id", "desc")
                                                        ->take(1);
                                        $package = Package::where('status','Active')
                                        			->orderBy("package_basic_price", "asc")
                                        			->first();				
                                        
                                        
                                       $order_data=array(
                                         'user_id'=>$user_id,
                                        'package_id'=> $package->id,
                                        'order_type'=>'',
                                        'name'=>$user->name??'',
                                        'email'=>$user->email??'',
                                        'phone'=>$user->phone??'',
                                        'address'=>$user->address??'',
                                        'country'=>$user->country_id??'',
                                        'zip'=>$user->store_zip??'',
                                        'city'=>$user->store_city??'',
                                        ); 
                                        $order=OrderDetail::create($order_data); 
                                        
                                        			$updt_old->update(["status" => "Expired"]);
                                        			$input = [
                                                    "user_id" => $user_id,
                                                    "package_id" => $package->id,
                                                    "type" => 'seller',
                                                    "date" => Carbon::today(),
                                                    "order_id" => $order->id,
                                                    "order_total" => 0,
                                                    "auto_renewal" => 1,
                                        			"expairy_date" => Carbon::now()->addMonths(12),
                                        			"status" => "Active",
                                                ];
                                                    Subscription::create($input);
									    ///////////////////////////////
										return redirect(route('home'));
									}
									}
                                
                                else
                                { 
                                   return redirect(route('package.listing')); 
                                }
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                  /*  if(is_null(Auth::guard('user')->user()->BuyerCompany->company_image) ||is_null(Auth::guard('user')->user()->BuyerCompany->about_company))
                            return redirect(route('MyCompanyProfile'));
                    elseif(!empty($user) || Auth::guard('user')->user()->seller_type=='Co-Seller')
                    {       //check logged out from admin
                            $prev_url = url('').'/login/admin';
                            $prev_url1 = url('').'/login/user';
                            
                            
                            
                            if (session()->has('link') && (session('link') != $prev_url) && (session('link') != $prev_url1) )
                                return redirect(session('link'));
                            else
                                return redirect(route('home'));
                                //
                            session()->forget('link');
                            
                    }
                    else
                            return redirect(route('package.listing')); */
                    }
                    
                }
                
            }
        }

        return $next($request);
    }
}
