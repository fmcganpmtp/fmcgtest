<?php

namespace App\Http\Controllers;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\User;
use App\Category;
use App\Product;
use Carbon\Carbon;

class BaseController extends Controller
{

    public function home()
    {
        return view('backend/layout/preview');
    }

    public function offline()
    {
        return view('backend/layout/offline');
    }

    public function swjs()
    {
        return response(view('backend/layout/sw-js')->render(), 200)->header('Content-Type', 'text/javascript');
    }

    public function firebasejs()
    {
        return response(view('backend/layout/firebase-messaging-sw-js')->render(), 200)->header('Content-Type', 'text/javascript');
    }

    public function manifest()
    {

        $startUrl = route('dashboard');

        if(request()->view == 'mobile'){
            $startUrl = route('mobile');
        }

        return response()->json([
            'start_url' => $startUrl,
            'display' => 'standalone',
            'name' => config('app.name', 'Laravel'),
            'description' => config('app.name', 'Laravel'),
            'short_name' => config('app.name', 'Laravel'),
            'icons' => [
                [
                    'src' => 'favicons/android-chrome-192x192.png',
                    'sizes' => '192x192',
                    'type' => 'image/png'
                ],
                [
                    'src' => 'favicons/android-chrome-512x512.png',
                    'sizes' => '512x512',
                    'type' => 'image/png'
                ]
            ],
            'background_color' => config('app.theme_primary', '#663259'),
            'theme_color' => config('app.theme_primary', '#663259'),
        ]);
    }

    public function share()
    {
        $agent = new Agent();

        if($agent->isPhone()){
            if($agent->platform() == 'iOS'){
                return redirect(getOption('apple_app_store_link', '#'));
            }else{
                return redirect(getOption('google_play_store_link', '#'));
            }
        }

        return redirect()->route('home');
    }


    public function verification($code)
    {
        $user = User::where('verification_code', $code)->first();

        if(!$user){
            $title = __('Invalid verification code');
            $message = __('Your link has expired. Please try again!!');
            return view('frontend/verification/index', compact('title','message'));
        }

        $count = User::where('email', $user->email)->where('email_verified', 1)->count();

        if($count > 0){
            $title = __('Email already in use');
            $message = __('Your email already in use. Please try again!!');
            return view('frontend/verification/index', compact('title','message'));
        }

        $user->update([
            'email_verified' => 1,
            'verification_code' => null,
        ]);

        $title = __('Verified successfully');
        $message = __('Your email verified successfully.');
        return view('frontend/verification/index', compact('title','message'));
    }

    public function sitemap()
    {
        $products = Product::retrieve('featured', '', null, null, 10000);


        if (Cache::has('prodata')) {
            $prodata = Cache::get('prodata');
        }else{
            $prodata = [];
            foreach ($products as $product){
                $prodata[] = [
                    'loc' => route('website.product', ['slug' => $product->slug ]),
                    'lastmod' => Carbon::parse($product->updated_at)->format('Y-m-d')
                ];
            }
            Cache::forever('prodata',  $prodata);
        }

        return response()->view('frontend/sitemap/index', compact('prodata'))
        ->header('Content-Type', 'application/xml');
    }

    public function ajaxtiny(Request $request)
    {
        $file_path = app_path().'/images/content/';

        $file = $request->file('file');

        $fileName = time().'.'.$request->file->extension();

        $request->file->move(public_path('/assets/backend/tiny/'), $fileName);
        $data['location'] = '../../assets/backend/tiny/'.$fileName;
        echo json_encode($data);
    }


}
