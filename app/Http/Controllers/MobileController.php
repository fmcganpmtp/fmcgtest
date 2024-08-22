<?php

namespace App\Http\Controllers;
use App\BannerSlider;
use App\Branch;
use App\Offer;
use App\Category;
use App\Coupon;
use App\Product;
use App\Stock;
use App\Favourite;
use App\Enquiry;
use Auth;
use App\User;
use App\Notification;
use App\Order;
use App\OrderItem;
use App\OrderStatus;
use App\Address;
use App\Location;
use App\State;
use Validator;
use App;
use Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Razorpay\Api\Api as RazorpayApi;
use Illuminate\Validation\Rule; 
use App\Mail\BasicMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Arr;

class MobileController extends Controller
{

    public function signup(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => [ 'required', 'max:100' ],
            'mobile' => [ 'required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10' ],
            'email' => [ 'nullable', 'email', 'max:100' ],
            'username' => [ 'required', 'unique:users,username', 'min:5', 'max:100' ],
            'password' => [ 'required', 'min:6' ],
            'fcm' => [ 'nullable', 'max:255' ],

            'address_type' => [ 'required', 'max:10' ],
            'address_line_1' => [ 'required' ],
            'address_line_2' => [ 'required' ],
            'address_line_3' => [ 'nullable' ],
            'address_mobile' => [ 'required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:15' ],
            'latitude' => [ 'required', 'max:100' ],
            'longitude' => [ 'required', 'max:100' ],
            
            
        ]);

        $validator->setAttributeNames([
            'mobile' => __('mobile number')
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }
 
        DB::beginTransaction();
        try {

            $input  = $request->only(['name', 'mobile', 'email', 'username', 'fcm']);

            $random = Str::random(40);
 
            $input['role_id'] = 1;
            $input['password'] = Hash::make($request->password);  
            $input['api_token'] = Hash::make($random);
            $input['status'] = 'active';
        
            $user = User::create($input);
 
            $address = Address::create([
                'user_id' => $user->id,
                'type' => $request->address_type,
                'line_1' => $request->address_line_1 ?? null,
                'line_2' => $request->address_line_2 ?? null,
                'line_3' => $request->address_line_3 ?? null,
                'mobile' => $request->address_mobile ?? null,
                'latitude' => $request->latitude ?? null,
                'longitude' => $request->longitude ?? null,
                'default' => 1
            ]);

            $token = $user->id . '|' . $random;
 
        } catch (\Exception $e) {

            DB::rollback();
 
            return response()->json([
                'errors' => [
                    'mobile' => [
                        __('Something went wrong.')
                    ]
                ],
                'toast'  => __('Something went wrong.'),
                'status' => false
            ]);
        }

        DB::commit();

        return response()->json([
            'data' => [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'authorization' => $token ?? null,
                'address_id' => $address->id ?? null
            ],
            'toast' => __('Your account has been created successfully.'),
            'status' => true
        ]);
    }

    public function signin(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'username' => ['required', 'min:5', 'max:100'],
            'password' => ['required', 'min:6']
        ]);

        $validator->setAttributeNames([
            'username' => 'User Name',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }

        $credentials = $request->only('username', 'password');

        if (Auth::once($credentials)) {
            $authUser = Auth::user();

            if($authUser->status != 'active'){

                Auth::logout();

                return response()->json([
                    'errors' => [
                        'username' => [
                            __('Account is blocked or temporarily not available.')
                        ]
                    ]
                ]);

            }

            $random = Str::random(40);

            $token = $authUser->id . '|' . $random;

            $fcm = $request->fcm ?? null;
 
            $authUser->update([
                'api_token' => Hash::make($random),
                'fcm' => $fcm
            ]);


            $address = Address::select('id', 'line_1', 'line_2', 'line_3', 'mobile', 'type', 'latitude', 'longitude')->where('default', true)->where('user_id', $authUser->id)->first();

            Auth::logout();
            
            return response()->json([
                'data' => [
                    'user_id' => $authUser->id,
                    'user_name' => $authUser->name,
                    'role_id' => $authUser->role_id,
                    'authorization' => $token,
                    'address' => $address
                ],
                'toast' => __('Login successfully.'),
                'status' => true
            ]);
        }

        return response()->json([
            'errors' => [
                'username' => [
                    __('These credentials do not match our records.')
                ]
                ],
            'toast' => __('These credentials do not match our records.'),
            'status' => false
        ]);
    }

    public function home(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'latitude' => [ 'required', 'max:100' ],
            'longitude' => [ 'required', 'max:100' ],
        ]);

 
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        } 

        $bannerSliders = BannerSlider::select('name', 'image')->orderBy('priority', 'desc')->get(); 
        
        $branchs = [];
        $getBranchs = Branch::nearby($request->latitude, $request->longitude);
        foreach($getBranchs as $branch){
            $branchs[] = [
                'id' => $branch->id, 
                'name' => $branch->name, 
                'location_name' => $branch->location_name, 
                'local_name' => $branch->local_name, 
                'local_location_name' => $branch->local_location_name, 
                'image' => $branch->image, 
                'distance' => round($branch->distance, 1) . ' km'
            ];
        }


        $categories = Category::select('id', 'name', 'local_name', 'image')->orderBy('name', 'asc')->orderBy('priority', 'desc')->get();

        $products = [];
        if( count($branchs) > 0 ){
            $getProducts =  Product::retrieve($branchs[0]['id'], 'featured', '', null, null, 10, 3);
            foreach($getProducts as $product){           
                $products[] =  $this->retrieve( $product );
            }
        }
        
        return response()->json([
            'data' => [
                'banner_sliders' => $bannerSliders,
                'branchs' => $branchs,
                'categories' =>  $categories,
                'featured_products' => $products
            ],
            'status' => true
        ]);
    } 

    public function products(Request $request)
    {

        $latitude = $request->latitude ?? null;
        $longitude = $request->longitude ?? null;
        $branch = $request->branch ?? null;
        $sortby = $request->sortby ?? 'featured';
        $search = $request->search ?? '';
        $category = $request->category ?? null;
        $categories = Category::select('name', 'local_name', 'image')->orderBy('name', 'asc')->orderBy('priority', 'desc')->get();
        $products = [];

        if($latitude & $longitude){
            $branch = Branch::nearby($request->latitude, $request->longitude)->pluck('id')->toArray();
        }
        
        
        $getProducts =  Product::retrieve($branch, $sortby, $search, $category, null, 30);
 
        foreach($getProducts as $product){           
            $products[] =  $this->retrieve( $product );
        }

        $productsPagination = $getProducts->toArray();

        $pagination = [
            'from' => $productsPagination['from'],
            'to' => $productsPagination['to'],
            'current_page' => $productsPagination['current_page'],
            'last_page' => $productsPagination['last_page'],
            'per_page' => $productsPagination['per_page'],
            'total' => $productsPagination['total']
        ];

        return response()->json([
            'data' => [
               'categories' => $categories,
                'products' => $products,
               'pagination' => $pagination
            ],
            'status' => true
        ]);
    } 
    
    public function product(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'product' => ['required', 'integer'],
            'branch' => ['required', 'integer']
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        } 

        $productId = $request->product ?? null;
        $branchId = $request->branch ?? null;
   
        $query = Product::select('products.*', 'stocks.id as stock_id', 'stocks.stock_status', 'stocks.minimum_quantity', 'stocks.stock_available', 'branches.id as branch_id', 'branches.name as branch_name', 'branches.location_name as branch_location_name', 'branches.local_name as branch_local_name', 'branches.local_location_name as branch_local_location_name', 'branches.image as branch_image');
        $query->join('stocks', 'stocks.product_id', '=', 'products.id');
        $query->join('branches', 'branches.id', '=', 'stocks.branch_id');
        $query->where('products.status', 'published');

        $query->where('products.id', $productId);
        $query->where('stocks.branch_id', $branchId);

        $getProduct = $query->first();

        $product = null;
        if($getProduct){
            $product = $this->retrieve( $getProduct );

            return response()->json([
                'data' => [
                    'products' => $product,
                ],
                'status' => true
            ]);
        }
        return response()->json([
            'status' => false
        ]);
    } 

    private function retrieve( $product ){
        $productVariants = [];
        if($product->attribute && $product->attribute->variants){
            foreach($product->attribute->variants as $variants) {
                if($variants && $product->productGroupVariant($variants->id, $product->branch_id)->count() >= 1){

                    $options = [];
                    foreach($product->productGroupVariant($variants->id, $product->branch_id)->get() as $option) {
                        if( $option->product->id == $product->id){
                            $options[] = [
                                'name' =>  $option->variantOption->value,
                                'product_id' => null
                            ];
                        }else{
                            $options[] = [
                                'name' =>  $option->variantOption->value,
                                'product_id' => $option->product->id
                            ];
                        }
                    }
                    $productVariants[] = [
                        'name' => $variants->name,
                        'options' => $options
                    ];
                }
            }
        }

        $shortDescription = explode(PHP_EOL, $product->description);
        $shortDescription = $shortDescription[0] ?? '';
        return [
            'id' => $product->id, 
            'name' => $product->name, 
            'local_name' => $product->local_name,
            'stock' => [
                'stock_status' => $product->stock_status,
                'minimum_quantity' => $product->minimum_quantity,
                'stock_available' => $product->stock_available,
            ],
            'short_description' => substr($shortDescription, 0, 100),
            'description' => $product->description,
            'local_description' => $product->local_description,
            'category' => [
                'id' => $product->category->id ?? null,
                'name' => $product->category->name ?? null,
                'local_name' => $product->category->local_name ?? null,
                'image' => $product->category->image ?? null,
            ],
            'brand' => [
                'id' => $product->brand->id ?? null,
                'name' => $product->brand->name ?? null,
                'local_name' => $product->category->local_name ?? null,
                'image' => $product->brand->image ?? null,
            ],
            'branch' => [
                'id' => $product->branch_id,
                'name' => $product->branch_name, 
                'location_name' => $product->branch_location_name,
                'local_name' => $product->branch_local_name,
                'local_location_name' => $product->local_location_name,
                'image' => $product->branch_image
            ],
            'product_variants' => $productVariants,
            'product_code' => $product->product_code,
            'type' => $product->type,
            'image' => $product->image,
            'gallery_image_1' => $product->gallery_image_1,
            'gallery_image_2' => $product->gallery_image_2,
            'gallery_image_3' => $product->gallery_image_3,
            'unit' => [
                'id' => $product->unit->id ?? null,
                'type' => $product->unit->type ?? null,
                'local_type' => $product->unit->local_type ?? null,
                'name' => $product->unit->name ?? null,
                'local_name' =>  $product->unit->local_name ?? null,
                'stepper' =>  $product->unit->stepper ?? null,
            ],
            'price' => $product->price,
            'selling_price' => $product->selling_price,
            'keywords' => $product->keywords,
        ];
    }

    public function coupons(Request $request)
    {
        $authUser = authUser('api');

        $coupons = Coupon::select('title', 'local_title', 'description', 'local_description', 'code', 'min_cart_amount', 'on_which_order', 'discount_amount')->where('status', 'published')->get();

        $totalOrders = Order::where('orders.user_id', $authUser->id)->count();
 
        return response()->json([
            'data' => [
                'coupons' => $coupons,
                'total_orders' => $totalOrders
            ],
            'status' => true
        ]);
    } 

    public function address(Request $request)
    {
        $authUser = authUser('api');
 
        $address = Address::select('id', 'line_1', 'line_2', 'line_3', 'mobile', 'type', 'default', 'latitude', 'longitude')->where('user_id', $authUser->id)->get();
    
        return response()->json([
            'data' => [
                'address' => $address,
            ],
            'status' => true
        ]);
    } 

    public function addressCreate(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'address_type' => [ 'required', 'max:10' ],
            'address_line_1' => [ 'required' ],
            'address_line_2' => [ 'required' ],
            'address_line_3' => [ 'nullable' ],
            'address_mobile' => [ 'required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:15' ],
            'latitude' => [ 'required', 'max:100' ],
            'longitude' => [ 'required', 'max:100' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }
 
        DB::beginTransaction();
        try {

            $authUser = authUser('api');

            Address::where('user_id', $authUser->id)->update([
                'default' => 0
            ]);

            $address = Address::create([
                'user_id' => $authUser->id,
                'type' => $request->address_type,
                'line_1' => $request->address_line_1 ?? null,
                'line_2' => $request->address_line_2 ?? null,
                'line_3' => $request->address_line_3 ?? null,
                'mobile' => $request->address_mobile ?? null,
                'latitude' => $request->latitude ?? null,
                'longitude' => $request->longitude ?? null,
                'default' => 1
            ]);
 
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'toast'  => __('Something went wrong.'),
                'status' => false
            ]);
        }

        DB::commit();

        return response()->json([
            'toast' => __('Address created successfully.'),
            'status' => true,
            'data' => [
                'address_id' => $address->id,
            ],
        ]);
    } 

    public function addressUpdate(Request $request, Address $address)
    {
        $validator = Validator::make(request()->all(), [
            'address_type' => [ 'required', 'max:10' ],
            'address_line_1' => [ 'required' ],
            'address_line_2' => [ 'required' ],
            'address_line_3' => [ 'nullable' ],
            'address_mobile' => [ 'required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:15' ],
            'latitude' => [ 'required', 'max:100' ],
            'longitude' => [ 'required', 'max:100' ],
            'default' => [ 'required', 'in:0,1' ]
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }

        $authUser = authUser('api');

        if($address->user_id != $authUser->id){
            return response()->json([
                'toast'  => __('You have no permission to update this address.'),
                'status' => false
            ]);   
        }

 
        DB::beginTransaction();
        try {

            if( $request->default == 1){
                Address::where('user_id', $authUser->id)->update([
                    'default' => 0
                ]);      
            }

            $address->update([
                'type' => $request->address_type,
                'line_1' => $request->address_line_1 ?? null,
                'line_2' => $request->address_line_2 ?? null,
                'line_3' => $request->address_line_3 ?? null,
                'mobile' => $request->address_mobile ?? null,
                'latitude' => $request->latitude ?? null,
                'longitude' => $request->longitude ?? null,
                'default' => $request->default
            ]);
 
        } catch (\Exception $e) {

            DB::rollback();
 
            return response()->json([
                'toast'  => __('Something went wrong.'),
                'status' => false
            ]);
        }

        DB::commit();

        return response()->json([
            'toast' => __('Address updated successfully.'),
            'status' => true
        ]);
    } 

    public function addressDefault(Request $request, Address $address)
    {

        $authUser = authUser('api');

        if($address->user_id != $authUser->id){
            return response()->json([
                'toast'  => __('You have no permission to delete this address.'),
                'status' => false
            ]);   
        }
 
        DB::beginTransaction();
        try {

            Address::where('user_id', $authUser->id)->update([
                'default' => 0
            ]);

            $address->update([
                'default' => 1
            ]);  
 
        } catch (\Exception $e) {

            DB::rollback();
 
            return response()->json([
                'toast'  => __('Something went wrong.'),
                'status' => false
            ]);
        }

        DB::commit();

        return response()->json([
            'toast' => __('Address set default successfully.'),
            'status' => true
        ]);
    } 

    public function addressDelete(Request $request, Address $address)
    {

        $authUser = authUser('api');

        if($address->user_id != $authUser->id){
            return response()->json([
                'toast'  => __('You have no permission to delete this address.'),
                'status' => false
            ]);   
        }

 
        DB::beginTransaction();
        try {

            if( $address->default == 1){
                $newDefaultAddress = Address::where('user_id', $authUser->id)->first();   
   
                $newDefaultAddress->update([
                    'default' => 1
                ]);  
            }


            $address->delete();
 
        } catch (\Exception $e) {

            DB::rollback();
 
            return response()->json([
                'toast'  => __('Something went wrong.'),
                'status' => false
            ]);
        }

        DB::commit();

        return response()->json([
            'toast' => __('Address deleted successfully.'),
            'status' => true
        ]);
    } 

    public function notifications(Request $request)
    {
        $authUser = authUser('api');
 
        $notifications = Notification::select('id', 'content', 'created_at')->where('user_id', $authUser->id)->get();
    
        return response()->json([
            'data' => [
                'notifications' => $notifications,
            ],
            'status' => true
        ]);
    } 

    public function notificationDelete(Request $request, Notification $notification)
    {

        $authUser = authUser('api');

        if($notification->user_id != $authUser->id){
            return response()->json([
                'toast'  => __('You have no permission to delete this notification.'),
                'status' => false
            ]);   
        }

 
        DB::beginTransaction();
        try {

            $notification->delete();
 
        } catch (\Exception $e) {

            DB::rollback();
 
            return response()->json([
                'toast'  => __('Something went wrong.'),
                'status' => false
            ]);
        }

        DB::commit();

        return response()->json([
            'toast' => __('Notification deleted successfully.'),
            'status' => true
        ]);
    } 

    public function notificationsClear(Request $request)
    {

        $authUser = authUser('api');
 
        DB::beginTransaction();
        try {

            Notification::where('user_id', $authUser->id)->delete();   
 
        } catch (\Exception $e) {

            DB::rollback();
 
            return response()->json([
                'toast'  => __('Something went wrong.'),
                'status' => false
            ]);
        }

        DB::commit();

        return response()->json([
            'toast' => __('Notifications cleared successfully.'),
            'status' => true
        ]);
    } 

    public function profile()
    {
        $authUser = authUser('api');
        return response()->json([
            'data' => [
                'user' =>  Arr::only($authUser->toArray(), ['name', 'email', 'mobile']),
            ],
            'status' => true
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => [ 'required', 'max:100' ],
            'mobile' => [ 'required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10' ],
            'email' => [ 'nullable', 'email', 'max:100' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }

        $authUser = authUser('api');
 
        DB::beginTransaction();
        try {

            $input  = $request->only(['name', 'mobile', 'email']);

            $authUser->update($input);
 
        } catch (\Exception $e) {

            DB::rollback();
 
            return response()->json([
                'toast'  => __('Something went wrong.'),
                'status' => false
            ]);
        }

        DB::commit();

        return response()->json([
            'toast' => __('Profile updated successfully.'),
            'status' => true
        ]);
    } 

    public function changePassword(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'current-password' => [ 'required', 'min:6', new MatchOldPassword('api') ],
            'password' => [ 'required', 'min:6' ],
        ]);

        $validator->setAttributeNames([
            'current-password' => __('current password'),
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }
 
        DB::beginTransaction();
        try {
            $authUser = authUser('api');

            $authUser->update(['password' => Hash::make($request->password)]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'errors' => [
                    'current-password' => 'Something went wrong.',
                ],
                'toast' => __('Something went wrong.'),
                'status' => false
            ]);
        }
        DB::commit();

        return response()->json([
            'toast' => __('Password updated successfully.'),
            'status' => true
        ]);
    }

    public function passwordResetRequest(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'username' => ['required', 'max:100'],
        ]);

        $validator->setAttributeNames([
            'username' => 'User Name',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }

        DB::beginTransaction();
        try {
 
            $otp = mt_rand(100000,999999);
            $username = $request->username;

            $user = User::where('username', $username)->where('status', 'active')->first();

            if($user){

                if($user->email){
                    Mail::to($user->email)->send( new OtpMail($otp) ); 
                }

                $user->update([
                    'otp' => $otp
                ]);
            }else{

                return response()->json([
                    'errors' => [
                        'username' => [
                            'Account is blocked or not available.'
                        ]
                    ],
                    'status' => false
                ]);

            } 
 
        } catch (\Exception $e) {

            DB::rollback();
 
            return response()->json([
                'errors' => [
                    'username' => [
                        'Something went wrong.'
                    ]
                ],
                'status' => false
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => true
        ]);
    }

    public function passwordResetVerify(Request $request)
    {   

        $validator = Validator::make(request()->all(), [
            'otp' => ['required', 'min:6', 'max:6'],
            'username' => ['required'],
            'password' => ['required', 'min:6']
        ],[
            'otp.min' => 'Invalid OTP,  Try again!',
            'otp.max' => 'Invalid OTP, Try again!',
            'mobile.required' => 'Invalid OTP, Try again!'
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }
 
        DB::beginTransaction();
        try {
 
            $user = User::where('username', $request->username)->where('status', 'active')->where('otp', $request->otp)->first();
 
            if(!$user){
                return response()->json([
                    'errors' => [
                        'otp' => [
                            'Invalid OTP, Try again!'
                        ]
                    ]
                ]);
            }

            $user = User::where('username', $request->username)->where('status', 'active')->where('otp', $request->otp)->where('updated_at', '>=', Carbon::now()->subMinutes(5)->toDateTimeString())->first();

            if(!$user){
                return response()->json([
                    'errors' => [
                        'otp' => [
                            __('OTP expired, Try again!')
                        ]
                    ],
                    'toast' => __('OTP expired, Try again!'),
                    'status' => false
                ]);
            }

            $random = Str::random(40);

            $user->update([
                'password' => Hash::make($request->password),
                'api_token' => Hash::make($random)
            ]);

            $token = $user->id . '|' . $random;
            
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'errors' => [
                    'otp' => [
                        __('Something went wrong.')
                    ]
                ],
                'toast' => __('Something went wrong.'),
                'status' => false
            ]);
        }

        DB::commit();

        return response()->json([
            'data' => [
                'authorization' => $token
            ],
            'toast' => __('Password reset successfully.'),
            'status' => true
        ]);
    }

    public function placeOrder(Request $request, Branch $branch, Address $address)
    {

        $authUser = authUser('api');
 
        if($address){
            if($address->user_id != $authUser->id){
                return response()->json([
                    'toast'  => __('Invalid address.'),
                    'status' => false
                ]);   
            }
        }

        $request->merge([
            'products' =>  ifJsonDecode($request->products),
        ]);
 

        $validator = Validator::make(request()->all(), [
            'final_amount' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:99999999.999' ],
            'note' => ['nullable'],
            'discount_code' => [ 'nullable',  'max:20' ],
            'products' => [ 'required', 'array' ],
            'products.*.id' => ['required', 'integer' ],
            'products.*.quantity' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'lt:99999999.99' ],
            'products.*.steper' => [ 'required', 'regex:/^\d+(\.\d{1,2})?$/', 'lt:99999999.99', 'gt:0' ],
            'products.*.price' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:99999999.999' ],
            'products.*.selling_price' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:99999999.999' , 'lte:products.*.price'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }
 
        DB::beginTransaction();
        try {   

            $cartProducts = $request->products ?? []; 
 
            $order = Order::create([
                'user_id' => $authUser->id,
                'address_latitude' => $address->latitude,
                'address_longitude' => $address->longitude,
                'address_line_1' => $address->line_1,
                'address_line_2' => $address->line_2,
                'address_line_3' => $address->line_3,
                'address_mobile' => $address->mobile,
                'address_type' => $address->type,
                'discount_code' => $request->discount_code,
                'total_amount' => 0,
                'delivery_charge' => 0,
                'discount_amount' => 0,
                'canceled_amount' => 0,
                'final_amount' => 0,
                'note' => $request->note,
                'status' => 'pending',
                'branch_id' => $branch->id,
            ]);

            OrderStatus::create([
                'status' => 'pending',
                'order_id' => $order->id
            ]);

            $total = 0;

            foreach($cartProducts as $cartProduct){

                $cartProductId = $cartProduct['id'] ?? 0;
                $quantity = $cartProduct['quantity'];

                $query = Product::select('products.*', 'stocks.id as stock_id', 'stocks.stock_status', 'stocks.minimum_quantity', 'stocks.stock_available');
                $query->join('stocks', 'stocks.product_id', '=', 'products.id');
                $query->where('stocks.branch_id', $branch->id);
                $query->where('products.id', $cartProductId);
                $product = $query->first();


                if(!$product){

                    DB::rollback();
            
                    return response()->json([
                        'status' => false,
                        'toast' => __('Try again, Invalid cart item.'),
                    ]);
                }
    
                if($product->status != 'published'){

                    DB::rollback();
            
                    return response()->json([
                        'status' => false,
                        'toast' => __('Try again, Invalid cart item.'),
                    ]);
                }

                if($product->price != $cartProduct['price']  || $product->selling_price != $cartProduct['selling_price']){

                    DB::rollback();
            
                    return response()->json([
                        'status' => false,
                        'toast' => __('Try again, Product price has been updated.'),
                    ]);
                }
 
                if($product->stock_status == 'limited' && $product->stock_available < $quantity){
                    DB::rollback();
            
                    return response()->json([
                        'status' => false,
                        'toast' => __('Try again, Stock not available.'),
                    ]);
                }
    
                if($product->minimum_quantity > $quantity){   
                    DB::rollback();
            
                    return response()->json([
                        'status' => false,
                        'toast' => __('Try again, The product has been updated.'),
                    ]);
                }
    
                if($product->unit->stepper != $cartProduct['steper']){
                    DB::rollback();
            
                    return response()->json([
                        'status' => false,
                        'toast' => __('Try again, The product has been updated.'),
                    ]);
                } 
                
                if($product->stock_status == 'limited' && ( $product->stock_available <= 0 || $product->stock_available < $product->minimum_quantity) ){
                    DB::rollback();
            
                    return response()->json([
                        'status' => false,
                        'toast' => __('Try again, Stock not available.'),
                    ]);
                }

                $productTotal = $product->selling_price * ( $quantity / $product->unit->stepper );
    
                $total = $total + $productTotal;


                if($product->stock_status == 'limited' ){

                    $stockAvailable = ($product->stock_available - $quantity);

                    if($stockAvailable < 0){
                        $stockAvailable = 0;
                    }

                    $stock = Stock::where('branch_id', $branch->id)->where('product_id', $product->id)->first();
                    
                    if($stock){
                        $stock->update([
                            'stock_available' => $stockAvailable
                        ]);
                    }
                }
 
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $product->name,
                    'local_product_name' => $product->local_name,
                    'product_image' => $product->image,
                    'product_id' => $product->id,
                    'category_id' => $product->category->id,
                    'brand_id' => $product->brand->id ?? null,
                    'product_code' =>  $product->product_code,
                    'unit_id' => $product->unit->id,
                    'unit_type' => $product->unit->type,
                    'local_unit_type' => $product->unit->local_type,
                    'stepper' => $product->unit->stepper,
                    'unit_name' => $product->unit->name,
                    'local_unit_name' => $product->unit->local_name,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'selling_price' => $product->selling_price,
                    'final_price' => $productTotal,
                    'status' => 'pending',
                    'branch_id' => $branch->id
                ]);
            }
 


            $discountAmount = 0;

            if($request->discount_code != ''){

                $coupon = Coupon::where('code', $request->discount_code)->first();
                $totalOrders = Order::where('orders.user_id', $authUser->id)->count();


                if($coupon && $total >= $coupon->min_cart_amount && $totalOrders  == $coupon->on_which_order){

                    $discountAmount = $coupon->discount_amount;

                }else{

                    return response()->json([
                        'status' => false,
                        'toast' => __('Invalid discount code.'),
                    ]);   
                }
            }

            
            
            $finalAmount =  $total - $discountAmount;
 
            if( $finalAmount !=  $request->final_amount ){

                DB::rollback();

                return response()->json([
                    'status' => false,
                    'toast' => __('Try again, Invalid cart request.'),
                ]);
            }

            $order->update([
                'total_amount' => $total,
                'delivery_charge' => 0,
                'discount_amount' => $discountAmount,
                'final_amount' => $finalAmount,
                'status' => 'placed'
            ]);

            OrderStatus::create([
                'status' => 'placed',
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => false,
                'toast' => __('Something went wrong.'),
            ]);
        }
        DB::commit();

        return response()->json([
            'toast' => __('Order placed Successfully.'),
            'status' => true,
        ]);
    }

    public function orders()
    {
        $authUser = authUser('api');

        $query = Order::select('orders.id', 'orders.address_line_1', 'orders.address_line_2', 'orders.address_line_3', 'orders.address_mobile', 'orders.address_type', 'orders.discount_code', 'orders.total_amount', 'orders.delivery_charge', 'orders.discount_amount', 'orders.canceled_amount', 'orders.final_amount', 'orders.note', 'orders.status', 'branches.id as branch_id', 'branches.name as branch_name', 'branches.location_name as branch_location_name', 'branches.image as branch_image', 'orders.created_at', 'orders.updated_at' );
        $query->join('branches', 'branches.id', '=', 'orders.branch_id');
        $query->where('orders.user_id', $authUser->id);
        $orders = $query->get();
 
        return response()->json([
            'data' => [
                'orders' => $orders,
            ],
            'status' => true
        ]);
    }

    public function orderDetail(Order $order)
    {
        $authUser = authUser('api');

        if($order->user_id !=  $authUser->id){
            return response()->json([
                'status' => true,
                'toast' => __('Try again, Invalid order.'),
            ]);
        }

        $items = OrderItem::select('product_name', 'local_product_name', 'product_type', 'product_image', 'unit_type', 'local_unit_type', 'stepper', 'unit_name', 'local_unit_name', 'quantity', 'price', 'selling_price', 'final_price')->where('order_id', $order->id)->get();

        $status = OrderStatus::select('status', 'public_note', 'created_at')->where('order_id', $order->id)->get();

        return response()->json([
            'data' => [
                'branch' => [
                    'name' => $order->branch->name,
                    'location_name' => $order->branch->location_name,
                    'phone' => $order->branch->phone,
                    'image' => $order->branch->image
                ],
                'address' => [
                    'latitude' => $order->latitude,
                    'longitude' => $order->longitude,
                    'line_1' => $order->address_line_1,
                    'line_2' => $order->address_line_2,
                    'line_3' => $order->address_line_3,
                    'mobile' => $order->address_mobile,
                    'type' => $order->address_type,   
                ],
                'discount_code' => $order->discount_code,
                'total_amount' => $order->total_amount,
                'delivery_charge' => $order->delivery_charge,
                'discount_amount' => $order->discount_amount,
                'final_amount' => $order->final_amount,
                'status' => $status,
                'items' => $items,
            ],
            'status' => true
        ]);
    }

    public function offers(Request $request)
    {
 
        $offers = Offer::select('name', 'image')->get(); 
         
        return response()->json([
            'data' => [
                'offers' => $offers,
            ],
            'status' => true
        ]);
    } 

    public function support(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'subject' => [ 'required', 'max:100' ],
            'content' => [ 'required' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }

        $authUser = authUser('api');

        if($authUser->email == ''){
            return response()->json([
                'toast' => __('Please update email on you\'r profile.'),
                'status' => false
            ]);
        }

        try {

            $adminMail = config('mail.admin', null);

            if($adminMail){
                Mail::to($adminMail)->send( new BasicMail($request->subject, $request->content, $authUser->email, $authUser->name)); 
            }
 
        } catch (\Exception $e) {
            return response()->json([
                'toast'  => __('Something went wrong.'),
                'status' => false
            ]);
        }
 
        return response()->json([
            'toast' => __('Thank you for contacting us, We will respond as soon as possible.'),
            'status' => true
        ]);
    } 

    public function deliveryOrders(Request $request)
    {
        $authUser = authUser('api');
        $status = $request->status ?? null;
        $query = Order::select('orders.id', 'orders.address_line_1', 'orders.address_line_2', 'orders.address_line_3', 'orders.address_mobile', 'orders.address_type', 'orders.discount_code', 'orders.total_amount', 'orders.delivery_charge', 'orders.discount_amount', 'orders.canceled_amount', 'orders.final_amount', 'orders.note', 'orders.status', 'branches.id as branch_id', 'branches.name as branch_name', 'branches.location_name as branch_location_name', 'branches.image as branch_image', 'orders.created_at', 'orders.updated_at' );
        $query->join('branches', 'branches.id', '=', 'orders.branch_id');
        
        if($status){
            $query->where('orders.status', $status);
        }

        $query->where('orders.delivery_person_id', $authUser->id);
        $orders = $query->get();
 
        return response()->json([
            'data' => [
                'orders' => $orders,
            ],
            'status' => true
        ]);
    }

    public function deliveryOrderDetail(Order $order)
    {
        $authUser = authUser('api');

        if($order->delivery_person_id !=  $authUser->id){
            return response()->json([
                'status' => true,
                'toast' => __('Try again, Invalid order.'),
            ]);
        }

        $items = OrderItem::select('product_name', 'local_product_name', 'product_type', 'product_image', 'unit_type', 'local_unit_type', 'stepper', 'unit_name', 'local_unit_name', 'quantity', 'price', 'selling_price', 'final_price')->where('order_id', $order->id)->get();

        $status = OrderStatus::select('status', 'public_note', 'created_at')->where('order_id', $order->id)->get();

        return response()->json([
            'data' => [
                'branch' => [
                    'name' => $order->branch->name,
                    'location_name' => $order->branch->location_name,
                    'phone' => $order->branch->phone,
                    'image' => $order->branch->image
                ],
                'address' => [
                    'latitude' => $order->latitude,
                    'longitude' => $order->longitude,
                    'line_1' => $order->address_line_1,
                    'line_2' => $order->address_line_2,
                    'line_3' => $order->address_line_3,
                    'mobile' => $order->address_mobile,
                    'type' => $order->address_type,   
                ],
                'discount_code' => $order->discount_code,
                'total_amount' => $order->total_amount,
                'delivery_charge' => $order->delivery_charge,
                'discount_amount' => $order->discount_amount,
                'final_amount' => $order->final_amount,
                'status' => $status,
                'items' => $items,
            ],
            'status' => true
        ]);
    }

    public function deliveryOnTheWay(Order $order)
    {
        $authUser = authUser('api');

        if($order->delivery_person_id !=  $authUser->id){
            return response()->json([
                'status' => true,
                'toast' => __('Try again, Invalid order.'),
            ]);
        }

        DB::beginTransaction();
        try {

            OrderStatus::create([
                'order_id' => $order->id,
                'public_note' => null,
                'status' => 'on-the-way'
            ]);
    
            $order->update([
                'status' => 'on-the-way'
            ]);
    
            foreach($order->items as $item){
                $item->update([
                    'status' => 'on-the-way'
                ]);
            }
 
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'toast'  => __('Something went wrong.'),
                'status' => false
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => true
        ]);
    }

    public function deliveryConfirm(Order $order)
    {
        $authUser = authUser('api');

        if($order->delivery_person_id !=  $authUser->id){
            return response()->json([
                'status' => true,
                'toast' => __('Try again, Invalid order.'),
            ]);
        }

        DB::beginTransaction();
        try {

            OrderStatus::create([
                'order_id' => $order->id,
                'public_note' => null,
                'status' => 'delivered'
            ]);
    
            $order->update([
                'status' => 'delivered'
            ]);
    
            foreach($order->items as $item){
                $item->update([
                    'status' => 'delivered'
                ]);
            }
 
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'toast'  => __('Something went wrong.'),
                'status' => false
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => true
        ]);
    }

}
