<?php

namespace App\Http\Controllers;

use Validator;
use App\Order;
use App\OrderItem;
use App\OrderStatus;
use App\OrderBill;


use App\User;
use App\Vendor;
use App\VendorUser;

use App\Menu;
use App\Submenu;
use App\Brand;
use App\UserNotification;
use App\Coupon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $order_status = $request->get('order_status');
        $payment_status = $request->get('payment_status');
        return view('backend/order/index', compact('search', 'order_status', 'payment_status'));
    }

    public function list(Order $order, Request $request)
    {
        $query = $order;
        $query = $query->select(
            'orders.id',
            'orders.id as order_id',
            'orders.created_at as date_time',
            'users.name as user_name',
            'users.id as user_id',
            'orders.final_amount',
            'orders.final_bill_amount',
            'vendors.name as vendor_name',
            'vendors.location as vendor_location',
            'orders.status',
            'orders.payment_status',
        );
        $query = $query->leftJoin('users', 'users.id', '=', 'orders.user_id');
        $query = $query->leftJoin('vendors', 'vendors.id', '=', 'orders.vendor_id');
        $data = $this->datatable(
            $query,
            function ($query) use ($request) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('vendors.name', 'LIKE', "%{$search}%");
                    $query->orWhere('vendors.location', 'LIKE', "%{$search}%");
                    $query->orWhere('users.name', 'LIKE', "%{$search}%");
                    $query->orWhere('users.mobile', 'LIKE', "%{$search}%");
                    $query->orWhere('orders.delivery_phone', 'LIKE', "%{$search}%");
                    $query->orWhere('orders.id', 'LIKE', "%{$search}%");
                }
                if ($request->filled('filter.order_status')) {
                    $query->where('orders.status', $request->input('filter.order_status'));
                }
                if ($request->filled('filter.payment_status')) {
                    $query->where('orders.payment_status', $request->input('filter.payment_status'));
                }
                if ($request->filled('filter.date_from')) {
                    $query->where('orders.created_at', '>=', date('Y-m-d', strtotime("0 day", strtotime($request->input('filter.date_from')))));
                }
                if ($request->filled('filter.date_to')) {
                    $query->where('orders.created_at', '<=', date('Y-m-d', strtotime("+1 day", strtotime($request->input('filter.date_to')))));
                }

            },
            function ($rows, $totalFiltered, $totalData) {
                $data = [];
                $start = request('start') ?? 0;
                $order = request('order.0.dir') ?? 'desc';
                $count = $totalFiltered - $start;
                $start = $start + 1;
                foreach ($rows as $row) {

                    $now = Carbon::now()->timestamp;
                    $post_time = Carbon::parse($row->date_time)->timestamp + 5 * 60; // Add 5 minutes in seconds
                    if (($now < $post_time) && ($row->status == 'ordered')) {
                        $remaining_time = $post_time - $now; // Calculate remaining time in seconds
                        $remaining_minutes = floor($remaining_time / 60); // Calculate remaining minutes
                        $remaining_seconds = sprintf('%02d', ($remaining_time % 60)); // Calculate remaining seconds
                        $row->confirmation_time = ($remaining_minutes . ' - ' . $remaining_seconds);
                    } else {
                        $row->confirmation_time = '';
                        Order::where('id', $row->id)->where('status', 'ordered')->update(['status' => 'expired']);

                    }
                    $data[] = [
                    'id' => $order == 'desc' ? $start++ : $count--,
                    'date_time' => Carbon::parse($row->date_time)->format('Y-m-d / h:i:A'),
                    'order_id' => $row->order_id,
                    'user_name' => $row->user_name,
                    'user_id' => $row->user_id,
                    'final_amount' => ($row->final_bill_amount)?$row->final_bill_amount:$row->final_amount,
                    'vendor_name' => $row->vendor_name,
                    'vendor_location' => $row->vendor_location,
                    'status' => $row->status .(($row->status == 'ordered' && $row->confirmation_time != '') ? '<div class="text-danger"> Expired with in '.$row->confirmation_time.'</div><div class="text-danger"> Expired Time :'.date('Y-m-d / h:i:A', $post_time).'</div>' : ''),
                    'payment_status' => $row->payment_status,
                    'actions' => view('backend/order/actions', compact('row'))->render(),
                    ];
                }
                return $data;
            }
        );
        return response()->json($data);
    }



    public function edit(Order $order)
    {
        // return $order;
        $users = User::all();
        $users = User::all();
        $vendors = Vendor::all();
        $bill_image = OrderBill::where('order_id',$order->id)->get();

        $paymentStatusOptions= array("online", "cod");

        $status = ['ordered','placed','prepare','prepared','picked','delivered','return','returned','cancelled','undelivered','expired'];
        return view('backend/order/edit', compact('users', 'users', 'vendors', 'order', 'status','paymentStatusOptions','bill_image'));
    }

    public function update(Request $request, Order $order)
    {
        $validator = Validator::make(request()->all(), [
            'vendor_id' => [ 'required', 'integer' ],
            'user_id' => [ 'required', 'integer' ],
            'delivery_geo_location' => [ 'required', 'max:255' ],
            'delivery_latitude' => [ 'required', 'max:100' ],
            'delivery_longitude' => [ 'required', 'max:100' ],
            'delivery_address' => [ 'required', 'max:255' ],
            'delivery_location' => [ 'required', 'max:100' ],
            'delivery_phone' => [ 'nullable', 'max:10' ],
            'delivery_type' => [ 'required', 'max:10' ],
            'delivery_weight' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:999999999.9' ],
            'delivery_distance' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:999999999.9' ],
            'delivery_charge' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'discount_code' => [ 'nullable' ],
            'discount_amount' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'total_amount' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'final_amount' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'commission_amount' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'note' => [ 'nullable' ],
            'status' => [ 'required', 'max:10' ],
            'assign_user_id' => [ 'nullable', 'integer' ],
            'is_confirm' => ['required'],
            'is_bill_confirm' => ['required'],
            'payment_status' => ['required'],
            'comments' => [ 'nullable' ],
            'payment_method' => ['required'],
            'bill_amount' => [ 'nullable' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $id=$order->id;
        $vender_id = $order->vendor_id;
        // DB::beginTransaction();
        // try {
            $input = $request->only([ 'vendor_id',  'user_id',  'delivery_geo_location',  'delivery_latitude',  'delivery_longitude',  'delivery_address',  'delivery_location',  'delivery_phone',  'delivery_type',  'delivery_weight',  'delivery_distance',  'total_price_amount','total_price_discount','delivery_charge',  'discount_code',  'discount_amount',  'total_amount',  'final_amount',  'commission_amount',  'note',  'status',  'assign_user_id','delivery_date','delivery_time','is_confirm','is_bill_confirm','payment_status','comments','payment_method','bill_amount' ]);
            if($input['discount_code'] != '') {

                $user_order_count = Order::where('user_id', $order->user_id)->where('id', '<=', $order->id)->count();
                $order_total_amount=$order->total_amount;
                $coupon_exists = Coupon::where('code',$input['discount_code'])->where('coupons.status', 'published')->exists();

                // $user_next_order_count = $user_order_count + 1;
                $order_exist_coupon = Order::where('orders.discount_code', $input['discount_code'])
                ->where('orders.id','!=', $order->id)
                ->where('orders.user_id', $order->user_id)->exists();

                $order_vendor_id=$order->vendor_id;
                if($order_exist_coupon||(!$coupon_exists)) {
                    return response()->json([
                        'alert' => [
                            'icon' => 'error',
                            'title' => 'Order',
                            'text' =>(!$coupon_exists)?'Invalid Coupon code':'Coupon Code already applied.',
                        ],
                    ]);
                }


                $coupons = Coupon::where('code',$input['discount_code'])->where('coupons.status', 'published')
                ->where(function ($query) use ($order_total_amount) {
                    $query->whereNull('min_cart_amount')
                        ->orWhere('min_cart_amount', '<=', $order_total_amount);
                })
                ->where(function ($query) use ($order_total_amount) {
                    $query->whereNull('max_cart_amount')
                        ->orWhere('max_cart_amount', '>=', $order_total_amount);
                })

                ->where(function ($query) use ($user_order_count) {
                    $query->Where('on_which_order', $user_order_count)->orWhere('on_which_order', '=', 0);
                })
                ->where(function ($query) use ($order_vendor_id) {
                    $query->whereNull('vendor_id')
                    ->orwhere('vendor_id', $order_vendor_id);
                });

                $coupon = $coupons->first();

                if(!$coupon){
                    return response()->json([
                        'alert' => [
                            'icon' => 'error',
                            'title' => 'Order',
                            'text' => 'Coupon code not applicable.',
                        ],
                    ]);
                }else{
                    $input['discount_amount']=$coupon->discount_amount;
                    $input['final_amount']=$order->total_amount-$coupon->discount_amount;

                    $input['final_amount']=$order->final_amount-$coupon->discount_amount;
                }
            }
            if($request->bill_amount!=''){  
                $vendor = Vendor::select('vendors.*', DB::raw("vendors.id,vendors.name,( 6371 * acos( cos( radians($order->delivery_latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($order->delivery_longitude ) ) + sin( radians($order->delivery_latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"))->where('status', 'active')->find($vender_id);
                $delivery_charge = $order->delivery_charge;
                if ($request->bill_amount >= $vendor->avoide_delivery_fee) {
                    $delivery_charge = 0.0;
                } elseif (($request->bill_amount >= $vendor->amount_to_avoid_min_delivery) && ($vendor->distance <= $vendor->min_delivery_upto_km)) {
                    $delivery_charge = 0.0;
                } elseif (($request->bill_amount < $vendor->amount_to_avoid_min_delivery) && ($vendor->distance <= $vendor->min_delivery_upto_km)) {
                    $delivery_charge = $vendor->min_delivery_fee;
                } else {
                    $delivery_charge = (Round((($vendor->distance) - ($vendor->min_delivery_upto_km)), 0.7) * ($vendor->delivery_fee_per_km)) + $vendor->min_delivery_fee;
                }
                $final_bill_amount  = ($request->bill_amount - $order->discount_amount) + $delivery_charge + $order->packaging_charge;
                $input['final_bill_amount']=$final_bill_amount;
                $commision_charge = $order->commision_charge;
                if ($vendor->commission_percentage > 1) {
                    $commision_charge = (($request->bill_amount * $vendor->commission_percentage) / 100);
                    $input['commission_amount']=$commision_charge;
                }
                $input['final_delivery_charge']=$delivery_charge;
            }
            $order->update($input);
            if($input['status'] == $request->status) {

                OrderStatus::create([
                    'vendor_id' => $order->vendor_id,
                    'order_id' => $order->id,
                    'status' => $request->status,
                    'public_note' => ($request->status == 'cancelled') ? 'cancelled by Admin' : '',
                ]);
                $user_id = ($request->status == 'ordered') ? VendorUser::find($order->vendor_id)->user_id : $order->user_id;
                UserNotification::create([
                    'user_id' => $user_id,
                    'relation_id' => $order->id,
                    'notification' => 'order_' . $request->status,
                    'relation_table' => 'orders',
                    'status' => 'unread',
                ]);

            }

            $file=($request->file('old_image'));
            $counter=0;
            if($file)
            {
                foreach($request->old_image as $image_file)
                {
                    $fileName = uniqid('bill_') . '.' . $image_file->getClientOriginalExtension();
                    $image_file->move(public_path('uploads/'), $fileName);
                    $sliderimage = OrderBill::create([
                        'order_id' => $id,
                        'bill_image' => $fileName,
                    ]);
                    $counter++;
                }
            }
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return response()->json([
        //         'alert' => [
        //             'icon' => 'error',
        //             'title' => 'Order',
        //             'text' => 'Something went wrong.',
        //         ],
        //     ]);
        // }
        // DB::commit();
        return response()->json([
            'alert' => [
                'icon' => 'success',
                'title' => 'Order',
                'text' => 'Updated successfully.',
                'redirect' => route('order'),
            ],
        ]);
    }

    public function delete_image(Request $request)
    {
        $image = OrderBill::find($request->id);
        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        $imagePath = public_path('uploads/') . $image->bill_image;
        if (file_exists($imagePath))
        {
            if (unlink($imagePath))
            {
                $image->delete();
                return response()->json(['success' => true, 'image_id' => $image->id], 200);
            }else
            {
                return response()->json(['error' => 'Failed to delete image file'], 500);
            }
            return response()->json(['error' => 'Image file not found'], 404);
        }
        else{
            return response()->json(['error' => 'Image file not found'], 404);
        }
    }

    public function show(Order $order)
    {
        $order = Order::select('orders.*', 'users.name as user_name', 'vendors.name as vendor_name', 'vendors.address as vendor_address', 'vendors.location as vendor_location', 'vendors.landmark as vendor_landmark', 'vendors.state as vendor_state', 'vendors.district as vendor_district', 'vendors.pincode as vendor_pincode', 'vendors.latitude as vendor_latitude', 'vendors.longitude as vendor_longitude', 'vendors.primary_contact_number', 'vendors.secondary_contact_number')
        ->join('vendors', 'vendors.id', 'orders.vendor_id')
        ->leftjoin('users', 'users.id', 'orders.assign_user_id')
        ->where('orders.id', $order->id)->first();
        $status = array("ordered", "placed", "prepared", "picked", "delivered", "cancelled", "expired");
        $order_status = OrderStatus::where('order_id', $order->id)->whereIn('status', $status)->latest()->get();
        $order_bills = OrderBill::where('order_id', $order->id)->get();

// return $order_bills;
// dd($order_bills);
        $orer_items = OrderItem::where('order_id', $order->id)->get();
        $users = User::all();
        $vendors = Vendor::all();
        return view('backend/order/show', compact('users', 'users', 'vendors', 'order', 'orer_items', 'order_status','order_bills'));
    }


    public function orderitems_list(Order $order)
    {
        $order_items = OrderItem::where('order_id', $order->id);
        $query = $order_items;
        $query = $query->select(
            'order_items.id',
            'order_items.product_name',
            'order_items.product_type',
            'menu.name as menu',
            'submenu.name as submenu',
            'brands.name as brand',
            'order_items.product_code',
            'order_items.weight',
            'order_items.quantity',
            'order_items.price',
            'order_items.selling_price',
            'order_items.final_price',
            'order_items.status',
        );
        $query = $query->join('orders', 'orders.id', '=', 'order_items.order_id');

        $query = $query->leftJoin('users', 'users.id', '=', 'orders.user_id');
        $query = $query->leftJoin('vendors', 'vendors.id', '=', 'orders.vendor_id');
        $query = $query->leftJoin('menu', 'menu.id', '=', 'order_items.menu_id');
        $query = $query->leftJoin('submenu', 'submenu.id', '=', 'order_items.submenu_id');
        $query = $query->leftJoin('brands', 'brands.id', '=', 'order_items.brand_id');


        $data = $this->datatable(
            $query,
            function ($query) {

            },
            function ($rows, $totalFiltered, $totalData) {
                $data = [];
                $start = request('start') ?? 0;
                $order = request('order.0.dir') ?? 'desc';
                $count = $totalFiltered - $start;
                $start = $start + 1;
                foreach ($rows as $row) {
                    $data[] = [
                    'id' => $order == 'desc' ? $start++ : $count--,
                    'product_name' => $row->product_name,
                    'product_type' => $row->product_type,
                    'menu' => $row->menu,
                    'submenu' => $row->submenu,
                    'brand' => $row->brand,
                    'product_code' => $row->product_code,
                    'product_quantity' => $row->quantity,
                    'weight' => $row->weight,
                    'quantity' => $row->quantity,
                    'price' => $row->price,
                    'selling_price' => $row->selling_price,
                    'final_price' => $row->final_price,
                    'status' => $row->status,
                    ];
                }
                return $data;
            }
        );
        return response()->json($data);
    }

    public function destroy(Order $order)
    {
        try {
            $order->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Order',
                    'text' => 'Order can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Order',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }

    public function changeOrderStatus(Request $request, Order $order)
    {
        DB::beginTransaction();
        try {

            $order->status = $request->status;
            $order->save();

            OrderStatus::create([
                'vendor_id' => $order->vendor_id,
                'order_id' => $order->id,
                'status' => $request->status,
                'public_note' => ($request->status == 'cancelled') ? 'cancelled by Admin' : '',
            ]);
            $user_id = ($request->status == 'ordered') ? VendorUser::find($order->vendor_id)->user_id : $order->user_id;
            UserNotification::create([
                'user_id' => $user_id,
                'relation_id' => $order->id,
                'notification' => 'order_' . $request->status,
                'relation_table' => 'orders',
                'status' => 'unread',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Order',
                    'text' => 'Something went wrong.',
                ],
            ]);
        }
        DB::commit();
        return response()->json([
            'alert' => [
                'icon' => 'success',
                'title' => 'Order #'.$order->id,
                'text' => 'Status Updated successfully.',
                'redirect' => route('order'),
            ],
        ]);
        // OrderDetails::where('order_id', $id)->where('status', '<>', 'cancelled')
        //     ->update(['status' => $request->status, 'status_on' => date('Y-m-d H:i:s')]);
        // $user_id = $order->user_id;


        //     $UserDetails = User::where('id', $user_id)->first();


        // return back()->with('success', 'Order Status successfully changed');
    }

}
