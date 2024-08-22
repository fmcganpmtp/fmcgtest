<?php

namespace App\Http\Controllers;

use App;
use App\DeliveryAgent;
use App\DeliveryAgentApiToken;
use App\DeliveryOrder;
use App\Order;
use App\OrderItem;
use Carbon\Carbon;
use Hashids\Hashids;
use App\UserNotification;
use App\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;

class DeliveryBoyAPIController extends Controller
{

    public function auth(Request $request)
    {

        $validator = Validator::make(request()->all(), [
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

            $otp = mt_rand(1000,9999);

            $delivery_agent = DeliveryAgent::where('mobile', $request->mobile)->first();

            if ($delivery_agent) {
                if ($delivery_agent->verified == '1') {
                    $delivery_agent->update([
                        'otp' => $otp,
                        'updated_at' => Carbon::now(),
                    ]);
                } else {
                    return response()->json([
                        'toast' => __('User not verified'),
                        'status' => false,
                    ]);

                }
            } else {
                return response()->json([
                    'toast' => __('Invalid User, Try again!'),
                    'status' => false,
                ]);
            }
            $message="OTP: ".$otp." is your GROFIRST verification code. Enter it to verify your number and get things at your doorstep! Thank you for choosing GROFIRST.";
            $template_id='1707168380272951485';
            $sms=sendSms($request->mobile,$message,$template_id,$otp);
            // $sms=$this->otpMessage($delivery_agent->mobile,$otp);


            $hashids = new Hashids('AUTHID', 14, 'abcdefghijklmnopqrstuvwxyz');
            $authKey = $hashids->encode($delivery_agent->id);
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
        $validator = Validator::make(request()->all(), [
            'otp' => ['required', 'min:4', 'max:4'],
            'auth_key' => ['required'],
        ], [
            'otp.min' => 'Invalid OTP,  Try again!',
            'otp.max' => 'Invalid OTP, Try again!',
            'id.required' => 'Invalid OTP, Try again!',
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
            $agent_id = $authKey[0] ?? 0;

            $delivery_agent = DeliveryAgent::where('id', $agent_id)->where('otp', $request->otp)->first();
            if (!$delivery_agent) {
                return response()->json([
                    'errors' => [
                        'otp' => [
                            'Invalid OTP, Try again!',
                        ],
                    ],
                    'status' => false,
                ]);
            }

            $delivery_agent = DeliveryAgent::where('id', $agent_id)->where('otp', $request->otp)->where('updated_at', '>=', Carbon::now()->subMinutes(3)->toDateTimeString())->first();

            if (!$delivery_agent) {
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

            DeliveryAgentApiToken::create([
                'agent_id' => $delivery_agent->id,
                'api_token' => Hash::make($random),
                'status' => 'active',
            ]);

            $token = $delivery_agent->id . '|' . $random;
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
            'name' => $delivery_agent->name ?? 'Guest',
            'token' => $token,
            'status' => true,
        ]);
    }

    public function readytodeliverOrders(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'latitude' => ['required', 'max:100'],
            'longitude' => ['required', 'max:100'],
        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser_id = authUser('api')->id;

        $longitude = $request->longitude ?? '';
        $latitude = $request->latitude ?? '';
        $authUser = authUser('api');
        $authUser_id = authUser('api')->id;

        $readyorders_count = Order::join('order_items', function ($join) {
            $join->on('orders.id', 'order_items.order_id');
            // $join->where('order_items.status', '=', 'prepared');
        })->where('orders.status', 'prepared')

            ->OrderBy('orders.id', 'DESC')->count();

        $readyorders = Order::select('orders.id as order_id', 'orders.final_amount', 'orders.status', 'orders.delivery_time', 'orders.created_at', 'users.name', 'orders.delivery_address', 'orders.delivery_location',
            DB::raw("( 6371 * acos( cos( radians($latitude) ) * cos( radians( `delivery_latitude` ) ) * cos( radians( `delivery_longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `delivery_latitude` ) ) ) ) AS distance"))
            ->join('order_items', function ($join) {
                $join->on('orders.id', 'order_items.order_id');
                // $join->where('order_items.status', '=', 'prepared');
            })->where('orders.status', 'prepared')
            ->join('users', 'users.id', 'orders.user_id')
            ->having('distance', '<=', 10)
            ->OrderBy('orders.id', 'DESC')->get();
        foreach ($readyorders as $key => $order) {
            $item = OrderItem::select(DB::raw('COUNT(order_items.id )as itemcount'))->where('order_id', $order->order_id)->first();
            $readyorders[$key]['itemcount'] = $item->itemcount;
        }

        return response()->json([
            'data' => [
                'readyorders_count' => $readyorders_count,
                'readyorders' => $readyorders,

            ],
            'status' => true,
        ]);

    }

    public function OrderPickup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', 'integer'],
        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
         // $authUser = authUser('api');
        // $authUser_id = authUser('api')->id;
        $authDeliveryUser = authUser('deliveryagentapi');
        // dd($authDeliveryUser);
        if (!$authDeliveryUser) {

            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);

        }

        $order = Order::select('orders.id', 'orders.vendor_id','orders.user_id')->where('orders.id', $request->order_id)
        // ->where('orders.status','prepared')
            ->join('order_items', 'order_items.order_id', 'orders.id')
            ->join('delivery_agents',function($join)use($authDeliveryUser){
                $join->on('delivery_agents.vendor_id','orders.vendor_id');
                $join->where('delivery_agents.id',$authDeliveryUser->id);
            })->first();

        if ($order == null) {
            return response()->json([
                'toast' => __('Invalid Order'),
                'status' => false,
            ]);
        }
        $authUser_id=$authDeliveryUser->id;

        $pickup = DeliveryOrder::where('order_id', $order->id)->where('user_id', $authUser_id)->where('status', 'picked')->first();
        if ($pickup) {
            return response()->json([
                'toast' => __('Order already picked'),
                'status' => false,
            ]);
        }

        $input = $request->only(['order_id']);
        $input['user_id'] = $authUser_id;
        $input['status'] = 'picked';

        DB::beginTransaction();
        try {
            $delivery = DeliveryOrder::create($input);
            $order->update([
                'status' => 'picked',
            ]);
            OrderItem::where('order_id', $order->id)->update([
                'status' => 'picked',
            ]);
            OrderStatus::create([
                'vendor_id' => $order->vendor_id,
                'order_id' => $order->id,
                'status' => 'picked',
            ]);
            UserNotification::create([
                'user_id' => $order->user_id,
                'relation_id' =>  $order->id,
                'notification' => 'order_picked',
                'relation_table' => 'orders',
                'status' => 'unread',
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
            'toast' => __('Order picked successfully'),
            'status' => true,
        ]);

    }

    public function updateorderOutofdelivery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', 'integer'],
        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }

        $order = Order::select('orders.id', 'orders.vendor_id')->where('orders.id', $request->order_id)
            ->join('order_items', 'order_items.order_id', 'orders.id')
            ->first();
        if ($order == null) {
            return response()->json([
                'toast' => __('Invalid Order'),
                'status' => false,
            ]);
        }
        $authUser = authUser('api');
        $authUser_id = authUser('api')->id;
        $pickup = DeliveryOrder::where('order_id', $order->id)->where('user_id', $authUser_id)->where('status', 'picked')->first();

        if ($pickup == null) {
            return response()->json([
                'toast' => __('Order not picked'),
                'status' => false,
            ]);
        }

        $input = $request->only(['order_id']);
        $input['user_id'] = $authUser_id;
        $input['status'] = 'picked';

        DB::beginTransaction();
        try {
            $delivery = DeliveryOrder::create($input);
            $order->update([
                'status' => 'picked',
            ]);
            // OrderItem::where('order_id', $order->id)->update([
            //     'status' => 'out-of-delivery',
            // ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }

        DB::commit();

        return response()->json([
            'toast' => __('success'),
            'status' => true,
        ]);

    }

    public function deliveredOrders(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'latitude' => ['required', 'max:100'],
            'longitude' => ['required', 'max:100'],
        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser_id = authUser('deliveryagentapi')->id;

        $longitude = $request->longitude ?? '';
        $latitude = $request->latitude ?? '';
        $authUser = authUser('deliveryagentapi');
        $vendorUser_id = authUser('deliveryagentapi')->vendor_id;

        $deliveredorders_count = Order::join('order_items', function ($join) {
            $join->on('orders.id', 'order_items.order_id');
            // $join->where('order_items.status', '=', 'delivered');
        })
            ->join('delivery_orders', function ($join) use ($vendorUser_id) {
                $join->on('delivery_orders.order_id', 'orders.id');
                $join->where('delivery_orders.user_id', '=', $vendorUser_id);
                $join->where('delivery_orders.status', '=', 'delivered');
            })
            ->where('orders.status', 'delivered')
            ->OrderBy('orders.id', 'DESC')->count();

        $deliveredorders = Order::select('orders.id as order_id', 'orders.final_amount', 'orders.status', 'orders.delivery_time', 'orders.created_at', 'users.name', 'orders.delivery_address', 'orders.delivery_location',
            // DB::raw("( 6371 * acos( cos( radians($latitude) ) * cos( radians( `delivery_latitude` ) ) * cos( radians( `delivery_longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `delivery_latitude` ) ) ) ) AS distance")
        )
            ->join('order_items', function ($join) {
                $join->on('orders.id', 'order_items.order_id');
                // $join->where('order_items.status', '=', 'ordered');
            })->where('orders.status', 'ordered')
            ->join('users', 'users.id', 'orders.user_id')
            ->join('delivery_orders', function ($join) use ($vendorUser_id) {
                $join->on('delivery_orders.order_id', 'orders.id');
                $join->where('delivery_orders.user_id', '=', $vendorUser_id);
                $join->where('delivery_orders.status', '=', 'delivered');
            })
        // ->having('distance', '<=', 10)
            ->OrderBy('orders.id', 'DESC')->get();

        foreach ($deliveredorders as $key => $order) {
            $item = OrderItem::select(DB::raw('COUNT(order_items.id )as itemcount'))->where('order_id', $order->order_id)->first();
            $deliveredorders[$key]['itemcount'] = $item->itemcount;
        }

        return response()->json([
            'data' => [
                'deliveredorders_count' => $deliveredorders_count,
                'deliveredorders' => $deliveredorders,

            ],
            'status' => true,
        ]);

    }

    public function acceptedOrders(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'latitude' => ['required', 'max:100'],
            'longitude' => ['required', 'max:100'],
        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser_id = authUser('api')->id;

        $longitude = $request->longitude ?? '';
        $latitude = $request->latitude ?? '';
        $authUser = authUser('api');
        $authUser_id = authUser('api')->id;
        $acceptedorders_count = Order::join('order_items', function ($join) {
            $join->on('orders.id', 'order_items.order_id');
            // $join->where('order_items.status', '=', 'picked');
        })
            ->join('delivery_orders', function ($join) use ($authUser_id) {
                $join->on('delivery_orders.order_id', 'orders.id');
                $join->where('delivery_orders.user_id', '=', $authUser_id);
                $join->where('delivery_orders.status', '=', 'picked');
            })
            ->where('orders.status', 'picked')
            ->OrderBy('orders.id', 'DESC')->count();

        $acceptedorders = Order::select('orders.id as order_id', 'orders.final_amount', 'orders.status', 'orders.delivery_time', 'orders.created_at', 'users.name', 'orders.delivery_address', 'orders.delivery_location')
            ->join('order_items', function ($join) {
                $join->on('orders.id', 'order_items.order_id');
                // $join->where('order_items.status', '=', 'picked');
            })->where('orders.status', 'picked')
            ->join('users', 'users.id', 'orders.user_id')
            ->join('delivery_orders', function ($join) use ($authUser_id) {
                $join->on('delivery_orders.order_id', 'orders.id');
                $join->where('delivery_orders.user_id', '=', $authUser_id);
                // $join->where('delivery_orders.status','=', 'picked');
            })
            ->OrderBy('orders.id', 'DESC')->get();

        foreach ($acceptedorders as $key => $order) {
            $item = OrderItem::select(DB::raw('COUNT(order_items.id )as itemcount'))->where('order_id', $order->order_id)->first();
            $acceptedorders[$key]['itemcount'] = $item->itemcount;
        }

        return response()->json([
            'data' => [
                'acceptedorders_count' => $acceptedorders_count,
                'acceptedorders' => $acceptedorders,

            ],
            'status' => true,
        ]);

    }
    public function outofdeliveryOrders(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'latitude' => ['required', 'max:100'],
            'longitude' => ['required', 'max:100'],
        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser_id = authUser('api')->id;

        $longitude = $request->longitude ?? '';
        $latitude = $request->latitude ?? '';
        $authUser = authUser('api');
        $authUser_id = authUser('api')->id;

        $outofdelivery_count = Order::join('order_items', function ($join) {
            $join->on('orders.id', 'order_items.order_id');
            // $join->where('order_items.status', '=', 'out-of-delivery');
        })
            ->join('delivery_orders', function ($join) use ($authUser_id) {
                $join->on('delivery_orders.order_id', 'orders.id');
                $join->where('delivery_orders.user_id', '=', $authUser_id);
                // $join->where('delivery_orders.status','=', 'out-of-delivery');
            })
            ->where('orders.status', 'picked')
            ->OrderBy('orders.id', 'DESC')->count();

        $outofdeliveryorders = Order::select('orders.id as order_id', 'orders.final_amount', 'orders.status', 'orders.delivery_time', 'orders.created_at', 'users.name', 'orders.delivery_address', 'orders.delivery_location')
            ->join('order_items', function ($join) {
                $join->on('orders.id', 'order_items.order_id');
                // $join->where('order_items.status', '=', 'out-of-delivery');
            })->where('orders.status', 'picked')
            ->join('users', 'users.id', 'orders.user_id')
            ->join('delivery_orders', function ($join) use ($authUser_id) {
                $join->on('delivery_orders.order_id', 'orders.id');
                $join->where('delivery_orders.user_id', '=', $authUser_id);
                // $join->where('delivery_orders.status','=', 'out-of-delivery');
            })
            ->OrderBy('orders.id', 'DESC')->get();

        foreach ($outofdeliveryorders as $key => $order) {
            $item = OrderItem::select(DB::raw('COUNT(order_items.id )as itemcount'))->where('order_id', $order->order_id)->first();
            $outofdeliveryorders[$key]['itemcount'] = $item->itemcount;
        }

        return response()->json([
            'data' => [
                'outofdelivery_count' => $outofdelivery_count,
                'outofdeliveryorders' => $outofdeliveryorders,

            ],
            'status' => true,
        ]);

    }
}
