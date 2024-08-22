<?php

namespace App\Http\Controllers;

use App;
use App\DeliveryPartnerApiToken;
use App\Brand;
use App\BusinessCategory;
use App\Coupon;
use App\DeliveryAgent;
use App\DeliveryOrder;
use App\DeliverySlot;
use App\Menu;
use App\Option;
use App\Order;
use App\OrderItem;
use App\OrderStatus;
use App\Product;
use App\Rules\Base64Image;
use App\Submenu;
use App\User;
use App\UserNotification;
use App\Vendor;
use App\VendorBusinessCategory;
use App\VendorDeliverySlot;
use App\VendorMenu;
use App\VendorProduct;
use App\VendorSubmenu;
use App\VendorUser;
use App\VendorWorkingHours;
use Carbon\Carbon;
use Config;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\DeliveryPartner;
use App\DpAssignedOrder;
use App\DpAssignedOrderStatus;

use App\DpBillDetail;


class DeliveryPartnerAPIController extends Controller
{
    public function __construct()
    {
        // Set the timezone to your desired timezone
        date_default_timezone_set('Asia/Kolkata');
    }

    public function auth(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'mobile' => ['required', 'min:10', 'max:10', 'regex:/^([0-9\s]*)$/'],
        ]);

        $validator->setAttributeNames([
            'mobile' => 'Mobile number',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }

        $authKey = null;

        DB::beginTransaction();
        try {

            // $otp = mt_rand(1000,9999);
            $otp = 1234;

            $user = DeliveryPartner::where('mobile', $request->mobile)->where('status', 'active')->first();

            if ($user) {
                $user->update([
                    'otp' => $otp,
                    'otp_updated_at' => Carbon::now(),
                ]);
                $hashids = new Hashids('AUTHID', 14, 'abcdefghijklmnopqrstuvwxyz');
                $authKey = $hashids->encode($user->id);


                // sendSms($request->mobile, 'Your OTP to Login/Register Grofirst is ' . $otp . '. It will be valid for 3 minutes.', '123456');
                //  $sms=$this->otpMessage($request->mobile,$otp);
                // ($request->mobile != '1222213333') ? $this->otpMessage($request->mobile, $otp) : '';

            } else {
                return response()->json([
                    'errors' => [
                        'mobile' => [
                            __('The mobile number is not registered or is not active.'),
                        ],
                    ],
                    'toast' => __('Something went wrong.'),
                    'status' => false,
                ]);



            }
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'errors' => [
                    'mobile' => [
                        __('Something went wrong.'),
                    ],
                ],
                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }

        DB::commit();

        return response()->json([
            'auth_key' => $authKey,
            'status' => true,
        ]);
    }

    public function authVerify(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'otp' => ['required', 'min:4', 'max:4'],
            'auth_key' => ['required'],
        ], [
            'otp.min' => 'Invalid OTP,  Try again!',
            'otp.max' => 'Invalid OTP, Try again!',
            'otp.required' => 'OTP, Required!',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }

        $token = null;

        DB::beginTransaction();
        try {
            $hashids = new Hashids('AUTHID', 14, 'abcdefghijklmnopqrstuvwxyz');
            $authKey = $hashids->decode($request->auth_key);
            $userId = $authKey[0] ?? 0;

            $user = DeliveryPartner::where('id', $userId)->where('otp', $request->otp)->first();

            if (!$user) {
                return response()->json([
                    'errors' => [
                        'otp' => [
                            'Invalid OTP, Try again!',
                        ],
                    ],
                    'status' => false,
                ]);
            }

            $user = DeliveryPartner::where('id', $userId)
            ->where('otp', $request->otp)
            ->where('updated_at', '>=', Carbon::now()
            ->subMinutes(3)->toDateTimeString())
            ->first();

            if (!$user) {
                return response()->json([
                    'errors' => [
                        'otp' => [
                            __('OTP expired, Try again!'),
                        ],
                    ],
                    'toast' => __('OTP expired, Try again!'),
                    'status' => false,
                ]);
            }

            $random = Str::random(40);

            if ($user) {
                DeliveryPartnerApiToken::create([
                    'dp_id' => $user->id,
                    'api_token' => Hash::make($random),
                    'status' => 'active',
                ]);
            }

            $token = $user->id.'|'.$random;
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'errors' => [
                    'otp' => [
                        __('Something went wrong.'),
                    ],
                ],
                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }

        DB::commit();

        return response()->json([
            'name' => $user->name,
            'online' => $user->online,
            'profile_image' => $user->profile_image,
            'token' => $token,
            'status' => true,
        ]);
    }


    public function dashboard()
    {
        $authUser = authUser('deliverypartnerapi');
        return response()->json([
            'data' => [
                'name' => $authUser->name,
                'profile_image' => $authUser->profile_image,
                'online' => $authUser->online,
                ],
                'overview' => [
                    'pickup_orders' => 0,
                    'delivered_orders' => 0,
                    'undelivered_orders' => 0,
                    'cash_collected' => 0,
                    'unsettled_amount' => 0,

                ],
            'status' => true,
        ]);
    }
    public function waitingOrders(Request $request)
    {
        $authUser = authUser('deliverypartnerapi');
        $latitude = $authUser->delivery_latitude;
        $longitude = $authUser->delivery_longitude;
        $radius = $authUser->delivery_radius;


        // $orders = Order::select(DB::raw("orders.id,
        // ( 6371 * acos( cos( radians($latitude) ) * cos( radians( `delivery_latitude` ) ) * cos( radians( `delivery_longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `delivery_latitude` ) ) ) ) AS distance"))
        //     ->having('distance', '<=', $radius)
        //     // ->where('vendors.is_grofirst_vendor', true)
        //     ->get();
        // $orderIds = $orders->pluck('id')->toArray();

        $waitingorders = Order::select('vendors.name as vendor_name', 'vendors.logo as vendor_logo', 'orders.id as order_id', DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m-%d %H:%i:%s') AS ordered_time"), 'orders.created_at', DB::raw('COUNT(order_items.id ) as Itemcount'), 'delivery_date', 'delivery_time', 'delivery_address', 'delivery_location', DB::raw("ROUND(6371 * acos( cos( radians($latitude) ) * cos( radians( `delivery_latitude` ) ) * cos( radians( `delivery_longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `delivery_latitude` ) ) ), 1) AS distance"), 'dp_assigned_orders.created_at as assign_time')
    ->join('order_items', function ($join) {
        $join->on('orders.id', 'order_items.order_id');
    })
    ->join('vendors', 'vendors.id', 'orders.vendor_id')
    ->join('dp_assigned_orders', function ($join) use ($authUser) {
        $join->on('dp_assigned_orders.order_id', 'orders.id');
        $join->where('dp_assigned_orders.dp_id', $authUser->id);
        $join->where('dp_assigned_orders.status', 'assigned');

    })
    ->having('distance', '<=', $radius)
    // ->where('orders.status', 'placed')
    // ->whereIn('orders.id', $orderIds)
    ->groupBy('orders.id')
    ->havingRaw('TIMESTAMPDIFF(SECOND, assign_time, ?) <= 1200', [now()])
    ->orderBy('orders.id', 'ASC')
    ->get();
        foreach ($waitingorders as $key => $order) {
            $order_time = Carbon::createFromTimeString($order->assign_time);
            $post_time = $order_time->addMinutes(2)->timestamp;
            $now = Carbon::now()->timestamp;


            if (($now < $post_time) && ($order->status == 'ordered')) {
                $remaining_time = $post_time - $now; // Calculate remaining time in seconds

                $remaining_minutes = floor($remaining_time / 60); // Calculate remaining minutes
                $remaining_seconds = sprintf('%02d', $remaining_time % 60); // Calculate remaining seconds

                $confirmation_time = ($remaining_minutes.' - '.$remaining_seconds);


            } else {
                $confirmation_time = '';
            }
            $waitingorders[$key]['confirmation_time'] = $confirmation_time;

        }
        return response()->json([
            'data' => [
                'waitingorders' => $waitingorders
            ],
            'status' => true,
        ]);

    }
    public function waitingOrderDetails(Request $request)
    {

        $validator = \Validator::make(request()->all(), [
            'order_id' => ['required', 'integer'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser = authUser('deliverypartnerapi');
        $latitude = $authUser->delivery_latitude;
        $longitude = $authUser->delivery_longitude;
        $radius = $authUser->delivery_radius;
        $charge_per_km = $authUser->charge_per_km;


        $orders = Order::select(DB::raw("orders.id,
        ( 6371 * acos( cos( radians($latitude) ) * cos( radians( `delivery_latitude` ) ) * cos( radians( `delivery_longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `delivery_latitude` ) ) ) ) AS distance"))
            ->having('distance', '<=', $radius)
            // ->where('vendors.is_grofirst_vendor', true)
            ->get();
        $orderIds = $orders->pluck('id')->toArray();


        if(!in_array(request()->input('order_id'), $orderIds)) {
            return response()->json([
                'toast' => __('Order delivery not in your delivery area '),
                'status' => false,
            ]);
        }


        $order = Order::select(
            'vendors.name as vendor_name',
            'vendors.logo as vendor_logo',
            'orders.id as order_id',
            DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m-%d %H:%i:%s') AS ordered_time"),
            'orders.created_at',
            DB::raw('COUNT(order_items.id ) as Itemcount'),
            'delivery_date',
            'delivery_time',
            'users.name as customer_name',
            'delivery_address',
            'delivery_location',
            DB::raw("ROUND(6371 * acos( cos( radians($latitude) ) * cos( radians( `delivery_latitude` ) ) * cos( radians( `delivery_longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `delivery_latitude` ) ) ), 1) AS distance"),
            DB::raw("$charge_per_km * ROUND(6371 * acos( cos( radians($latitude) ) * cos( radians( `delivery_latitude` ) ) * cos( radians( `delivery_longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `delivery_latitude` ) ) ), 1) AS earnings"),
            'dp_assigned_orders.created_at as assigned_time'
        )
    ->join('order_items', function ($join) {
        $join->on('orders.id', 'order_items.order_id');
    })
    ->join('vendors', 'vendors.id', 'orders.vendor_id')
    ->join('users', 'users.id', 'orders.user_id')
    ->join('dp_assigned_orders', function ($join) use ($authUser) {
        $join->on('dp_assigned_orders.order_id', 'orders.id');
        $join->where('dp_assigned_orders.dp_id', $authUser->id);
        $join->where('dp_assigned_orders.status', 'assigned');

    })
    // ->where('orders.status', 'placed')
    // ->whereIn('orders.id', $orderIds)
    ->groupBy('orders.id')
    ->havingRaw('TIMESTAMPDIFF(SECOND, assigned_time, ?) <= 120', [now()])
    ->where('orders.id', request()->input('order_id'))
    ->orderBy('orders.id', 'ASC')
    ->first();

        if(! $order) {
            return response()->json([
                'toast' => __('Order no longer exist.'),
                'status' => false,
            ]);
        }
        $order_time = Carbon::createFromTimeString($order->assigned_time);
        $post_time = $order_time->addMinutes(2)->timestamp;
        $now = Carbon::now()->timestamp;


        if (($now < $post_time) && ($order->status == 'ordered')) {
            $remaining_time = $post_time - $now; // Calculate remaining time in seconds

            $remaining_minutes = floor($remaining_time / 60); // Calculate remaining minutes
            $remaining_seconds = sprintf('%02d', $remaining_time % 60); // Calculate remaining seconds

            $confirmation_time = ($remaining_minutes.' - '.$remaining_seconds);


        } else {
            $confirmation_time = '';
        }
        $order->confirmation_time = $confirmation_time;


        return response()->json([
            'data' => [
                'waitingorders' => $order
            ],
            'status' => true,
        ]);

    }
    public function acceptOrder(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'order_id' => ['required', 'integer'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser = authUser('deliverypartnerapi');
        $authUser = authUser('deliverypartnerapi');
        $latitude = $authUser->delivery_latitude;
        $longitude = $authUser->delivery_longitude;
        $radius = $authUser->delivery_radius;
        $charge_per_km = $authUser->charge_per_km;
        $orderstatus = [];
        $order = null;
        $orderexist = DpAssignedOrder::where('order_id', $request->order_id)
        ->where('dp_id', $authUser->id)
        // ->where('status', 'assigned')
        ->first();
        if(! $orderexist) {
            return response()->json([
                'toast' => __('Order no longer exist'),
                'status' => false,
            ]);
        }

        DB::beginTransaction();
        try {
            $input['status'] = 'accepted';
            $order_up = $orderexist->update($input);
            if($order_up) {
                DpAssignedOrder::where('order_id', $request->order_id)
                ->where('dp_id', '!=', $authUser->id)
                ->update(['status' => 'cancelled']);

                DpAssignedOrderStatus::create([
                    'dp_id' => $authUser->id,
                    'order_id' => $request->order_id,
                    'status' => 'order_accepted'
                ]);

            }

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([

                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }

        DB::commit();


        $order = Order::select(
            'vendors.name as vendor_name',
            'vendors.logo as vendor_logo',
            'vendors.primary_contact_number',
            'vendors.latitude as vendor_latitude',
            'vendors.longitude as vendor_longitude',
            'orders.id as order_id',
            'orders.status as order_status',
            DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m-%d %H:%i:%s') AS ordered_time"),
            'orders.created_at',
            DB::raw('COUNT(order_items.id ) as Itemcount'),
            'delivery_date',
            'delivery_time',
            'users.name as customer_name',
            'delivery_address',
            'delivery_location',
            DB::raw("ROUND(6371 * acos( cos( radians($latitude) ) * cos( radians( `delivery_latitude` ) ) * cos( radians( `delivery_longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `delivery_latitude` ) ) ), 1) AS distance"),
            DB::raw("$charge_per_km * ROUND(6371 * acos( cos( radians($latitude) ) * cos( radians( `delivery_latitude` ) ) * cos( radians( `delivery_longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `delivery_latitude` ) ) ), 1) AS earnings"),
            'dp_assigned_orders.created_at as assigned_time'
        )
    ->join('order_items', function ($join) {
        $join->on('orders.id', 'order_items.order_id');
    })
    ->join('vendors', 'vendors.id', 'orders.vendor_id')
    ->join('users', 'users.id', 'orders.user_id')

    ->join('dp_assigned_orders', function ($join) use ($authUser) {
        $join->on('dp_assigned_orders.order_id', 'orders.id');
        $join->where('dp_assigned_orders.dp_id', $authUser->id);
        $join->where('dp_assigned_orders.status', 'accepted');

    })
    // ->where('orders.status', 'placed')
    ->where('orders.id', request()->input('order_id'))
    ->first();
        if($order) {
            $orderstatus = DpAssignedOrderStatus::where('order_id', $order->order_id)->where('dp_id', $authUser->id)->get();

        }

        return response()->json([
            'data' => [
                'toast' => __('Order Accepted Successfully'),
                'orderdetails' => $order,
                'orderstatus' => $orderstatus
            ],
            'status' => true,
        ]);


    }

    public function arrivingstoreorderDetails(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'order_id' => ['required', 'integer'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $order_id = request()->input('order_id');
        $authUser = authUser('deliverypartnerapi');
        $latitude = $authUser->delivery_latitude;
        $longitude = $authUser->delivery_longitude;
        $radius = $authUser->delivery_radius;
        $charge_per_km = $authUser->charge_per_km;
        $orderstatus = [];
        $order = null;
        $status = 'accepted';

        $order = $this->OrderDetails($order_id, $status);


        if($order) {
            $orderstatus = DpAssignedOrderStatus::where('order_id', $order->order_id)->where('dp_id', $authUser->id)->get();

        }

        return response()->json([
            'data' => [
                'orderdetails' => $order,
                'orderstatus' => $orderstatus
            ],
            'status' => true,
        ]);

    }

    public function arrivedStoreOrder(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'order_id' => ['required', 'integer'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser = authUser('deliverypartnerapi');
        $orderstatus = $orderitems = [];
        $order = null;
        $order_id = $request->order_id;

        $status = 'accepted';

        $orderexist = DpAssignedOrder::where('order_id', $request->order_id)
        ->where('dp_id', $authUser->id)
        ->where('status', 'accepted')
        ->first();
        if(! $orderexist) {
            return response()->json([
                'toast' => __('Order no longer exist'),
                'status' => false,
            ]);
        }
        $updated_status =  DpAssignedOrderStatus::where('order_id', $order_id)
        ->where('dp_id', $authUser->id)->pluck('status')->toArray();
        if(in_array('arrived_at_store', $updated_status)) {
            return response()->json([
                'toast' => __('Arrived at store status already updated'),
                'status' => false,
            ]);

        }
        DB::beginTransaction();
        try {

            DpAssignedOrderStatus::create([
                'dp_id' => $authUser->id,
                'order_id' => $request->order_id,
                'status' => 'arrived_at_store'
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([

                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }

        DB::commit();
        $order = $this->OrderDetails($order_id, $status);
        if($order) {
            $orderitems = OrderItem::where('order_id', $order->order_id)->get();
            $orderstatus = DpAssignedOrderStatus::where('order_id', $order->order_id)->where('dp_id', $authUser->id)->get();

        }

        return response()->json([
            'data' => [
                'toast' => __('Arrived Store Status Updated Successfully'),
                'orderdetails' => $order,
                'orderstatus' => $orderstatus,
                'orderitems' => $orderitems,
            ],
            'status' => true,
        ]);


    }

    public function OrderItems(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'order_id' => ['required', 'integer'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $order_id = request('order_id');
        $orderitems = OrderItem::where('order_id', $order_id)->get();

        return response()->json([
            'data' => [
                'toast' => __(' Order Items listed Successfully'),
                'orderitems' => $orderitems,
            ],
            'status' => true,
        ]);

    }

    public function confirmMissingItems(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'order_id' => ['required', 'integer'],
            'item_ids' => ['required', 'array']
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser = authUser('deliverypartnerapi');
        $orderstatus = $orderitems = [];
        $order = null;
        $order_item_ids = $request->item_ids;


        $orderexist = DpAssignedOrder::where('order_id', $request->order_id)
        ->where('dp_id', $authUser->id)
        ->where('status', 'accepted')
        ->first();
        if(! $orderexist) {
            return response()->json([
                'toast' => __('Order no longer exist'),
                'status' => false,
            ]);
        }

        DB::beginTransaction();
        try {

            OrderItem::whereIn('id', $order_item_ids)->update([
                'status' => 'missing'
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([

                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }

        DB::commit();


        return response()->json([
            'data' => [
                'toast' => __('Missing items Confirmed Successfully'),
            ],
            'status' => true,
        ]);


    }


    public function confirmItems(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'order_id' => ['required', 'integer'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser = authUser('deliverypartnerapi');
        $orderstatus = $orderitems = [];
        $order = null;
        $order_id = $request->order_id;

        $status = 'accepted';

        $orderexist = DpAssignedOrder::where('order_id', $request->order_id)
        ->where('dp_id', $authUser->id)
        ->where('status', 'accepted')
        ->first();
        if(! $orderexist) {
            return response()->json([
                'toast' => __('Order no longer exist'),
                'status' => false,
            ]);
        }
        $updated_status =  DpAssignedOrderStatus::where('order_id', $order_id)
        ->where('dp_id', $authUser->id)->pluck('status')->toArray();
        if(in_array('confirm_items', $updated_status)) {
            return response()->json([
                'toast' => __('items comfirmed already'),
                'status' => false,
            ]);

        }
        DB::beginTransaction();
        try {

            DpAssignedOrderStatus::create([
                'dp_id' => $authUser->id,
                'order_id' => $request->order_id,
                'status' => 'confirm_items'
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([

                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }

        DB::commit();
        $order = $this->OrderDetails($order_id, $status);
        if($order) {
            $orderitems = OrderItem::where('order_id', $order->order_id)->get();
            $orderstatus = DpAssignedOrderStatus::where('order_id', $order->order_id)->where('dp_id', $authUser->id)->get();

        }

        return response()->json([
            'data' => [
                'toast' => __('Confirmed Order Items Successfully'),
                'orderdetails' => $order,
                'orderstatus' => $orderstatus,
                'orderitems' => $orderitems,
            ],
            'status' => true,
        ]);


    }

    public function confirmBillAmount(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'order_id' => ['required', 'integer'],
            'bill_amount' => ['required'],
            'bill_image[]' => ['nullable', new Base64Image(),'array'],

        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser = authUser('deliverypartnerapi');
        $orderstatus = $orderitems = [];
        $order = null;
        $order_id = $request->order_id;
        $bill_images = $request->file('bill_images');
        $status = 'accepted';
        $orderexist = DpAssignedOrder::where('order_id', $request->order_id)
        ->where('dp_id', $authUser->id)
        ->where('status', 'accepted')
        ->first();
        // OrderItem::
        if(! $orderexist) {
            return response()->json([
                'toast' => __('Order no longer exist'),
                'status' => false,
            ]);
        }
        $updated_status =  DpAssignedOrderStatus::where('order_id', $order_id)
        ->where('dp_id', $authUser->id)->pluck('status')->toArray();
        if(in_array('confirm_bill_amount', $updated_status)) {
            return response()->json([
                'toast' => __('Bill comfirmed already'),
                'status' => false,
            ]);

        }
        DB::beginTransaction();
        try {
        if(!empty($bill_images)) {
            foreach($bill_images as $bill_image) {


                if ($bill_image != '') {
                    $image = $bill_image;
                    $data = substr($image, strpos($image, ',') + 1);
                    $data = base64_decode($data);

                    $img = explode(',', $image);
                    $ini = substr($img[0], 11);
                    $type = explode(';', $ini);
                    $extension = $type[0] ?? '.jpg';

                    if ($extension == 'png' || $extension == 'jpg' || $extension = 'jpeg') {
                        $filePath = 'bill/'.fileName($extension);
                        Storage::disk('public')->put($filePath, $data);
                        $input['bill_image'] = $filePath;
                    }
                    $input['dp_id'] = $authUser->id;
                    $input['order_id'] = $order_id;
                    DpBillDetail::create($input);
                }
            }
        }
        DpAssignedOrderStatus::create([
            'dp_id' => $authUser->id,
            'order_id' => $request->order_id,
            'status' => 'confirm_bill_amount'
        ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([

                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }

        DB::commit();
        $order = $this->OrderDetails($order_id, $status);
        if($order) {
            $orderitems = OrderItem::where('order_id', $order->order_id)->get();
            $orderstatus = DpAssignedOrderStatus::where('order_id', $order->order_id)->where('dp_id', $authUser->id)->get();

        }

        return response()->json([
            'data' => [
                'toast' => __('Confirmed Order Items Successfully'),
                'orderdetails' => $order,
                'orderstatus' => $orderstatus,
                'orderitems' => $orderitems,
            ],
            'status' => true,
        ]);


    }



    public function OrderDetails($order_id = null, $status = null)
    {
        if($order_id && $status) {
            $authUser = authUser('deliverypartnerapi');
            $latitude = $authUser->delivery_latitude;
            $longitude = $authUser->delivery_longitude;
            $radius = $authUser->delivery_radius;
            $charge_per_km = $authUser->charge_per_km;

            $order = Order::select(
                'vendors.name as vendor_name',
                'vendors.logo as vendor_logo',
                'vendors.primary_contact_number',
                'vendors.latitude as vendor_latitude',
                'vendors.longitude as vendor_longitude',
                'orders.id as order_id',
                'orders.status as order_status',
                DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m-%d %H:%i:%s') AS ordered_time"),
                'orders.created_at',
                DB::raw('COUNT(order_items.id ) as Itemcount'),
                'delivery_date',
                'delivery_time',
                'users.name as customer_name',
                'delivery_address',
                'delivery_location',
                DB::raw("ROUND(6371 * acos( cos( radians($latitude) ) * cos( radians( `delivery_latitude` ) ) * cos( radians( `delivery_longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `delivery_latitude` ) ) ), 1) AS distance"),
                DB::raw("$charge_per_km * ROUND(6371 * acos( cos( radians($latitude) ) * cos( radians( `delivery_latitude` ) ) * cos( radians( `delivery_longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `delivery_latitude` ) ) ), 1) AS earnings"),
                'dp_assigned_orders.created_at as assigned_time'
            )
        ->join('order_items', function ($join) {
            $join->on('orders.id', 'order_items.order_id');
        })
        ->join('vendors', 'vendors.id', 'orders.vendor_id')
        ->join('users', 'users.id', 'orders.user_id')

        ->join('dp_assigned_orders', function ($join) use ($authUser, $status) {
            $join->on('dp_assigned_orders.order_id', 'orders.id');
            $join->where('dp_assigned_orders.dp_id', $authUser->id);
            $join->where('dp_assigned_orders.status', $status);

        })
        // ->where('orders.status', 'placed')
        ->where('orders.id', request()->input('order_id'))
        ->first();
            return $order;


        } else {

            return null;
        }
    }


    public function otpMessage($mobile, $otp)
    {
        $message = 'OTP: '.$otp.' is your GROFIRST verification code. Enter it to verify your number and get things at your doorstep! Thank you for choosing GROFIRST.';
        $template_id = '1707168380272951485';

        return sendSms($mobile, $message, $template_id, $otp);
    }


}
