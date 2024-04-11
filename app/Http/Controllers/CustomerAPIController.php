<?php

namespace App\Http\Controllers;

use App;
use App\Address;
use App\Cart;
use App\Coupon;
use App\CustomerSearch;
use App\CustomerSupport;
use App\DeliverySlot;
use App\HomeBanner;
use App\Order;
use App\OrderItem;
use App\OrderStatus;
use App\Slider;
use App\User;
use App\UserNotification;
use App\Vendor;
use App\VendorBusinessCategory;
use App\VendorDeliverySlot;
use App\VendorMenu;
use App\VendorUser;
use App\BusinessCategory;
use App\DeliveryOrder;
use App\VendorProduct;
use App\VendorSubmenu;
use App\VendorWorkingHours;
use App\Option;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Validator;
use Config;
use Mail;
class CustomerAPIController extends Controller
{
    public function __construct()
    {
        // Set the timezone to your desired timezone
        date_default_timezone_set('Asia/Kolkata');
    }
    public function addressCreate(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'geo_location' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'location' => ['required', 'max:100'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10'],
            'type' => ['required', 'max:10'],
            'latitude' => ['required', 'max:100'],
            'longitude' => ['required', 'max:100'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }

        $authUser = authUser('api');

        $input = $request->only(['geo_location', 'latitude', 'longitude', 'address', 'location', 'phone', 'type','landmark']);

        $input['user_id'] = $authUser->id;

        DB::beginTransaction();
        try {

            $address = Address::create($input);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }

        DB::commit();
        return response()->json([
            'address_id' => $address->id,
            'toast' => __('Address created successfully.'),
            'status' => true,
        ]);
    }

    public function addressList(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'search' => ['nullable'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }

        $authUser = authUser('api');

        $address = Address::select('id', 'type', 'phone', 'latitude', 'longitude', DB::raw("CONCAT(geo_location,' ',address) AS location"),'landmark');
        if ($request->search) {
            $address->where(function ($query) use ($request) {
                $query->where('geo_location', 'LIKE', "%$request->search%");
                $query->orWhere('address', 'LIKE', "%$request->search%");
                $query->orWhere('location', 'LIKE', "%$request->search%");
            });
        }
        $address->where('user_id', $authUser->id);
        $address->orderBy('default', 'asc');
        $addresses = $address->get();

        if ($addresses) {
            return response()->json([
                'data' => [
                    'address' => $addresses,
                ],
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function addressEdit(Address $address)
    {
        $authUser = authUser('api');
        $address = Address::findOrFail($address->id);
        return response()->json([
            'data' => [
                'address' => Arr::only(
                    $address->toArray(),
                    ['geo_location', 'latitude', 'longitude', 'address', 'location', 'phone', 'type','landmark']
                )],
            'status' => true,
        ]);
    }

    public function addressUpdate(Request $request, Address $address)
    {
        $validator = Validator::make(request()->all(), [
            'geo_location' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'location' => ['required', 'max:100'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10'],
            'type' => ['required', 'max:10'],
            'latitude' => ['required', 'max:100'],
            'longitude' => ['required', 'max:100'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }

        $authUser = authUser('api');

        $input = $request->only(['geo_location', 'latitude', 'longitude', 'address', 'location', 'phone', 'type','landmark']);

        DB::beginTransaction();
        try {

            $address->update($input);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }

        DB::commit();

        return response()->json([
            'toast' => __('Address updated successfully.'),
            'status' => true,
        ]);
    }

    public function addressDestroy(Address $address)
    {

        $authUser = authUser('api');

        if ($authUser->id == $address->user_id) {

            DB::beginTransaction();
            try {

                $address->delete($address->id);

            } catch (\Exception $e) {

                DB::rollback();

                return response()->json([
                    'toast' => __('Something went wrong.'),
                    'status' => false,
                ]);
            }

            DB::commit();

            return response()->json([
                'toast' => __('Address deleted successfully.'),
                'status' => true,
            ]);
        } else {
            return response()->json([
                'toast' => __('User not verified.'),
                'status' => false,
            ]);
        }

    }

    public function addressSelect(Request $request, Address $address)
    {
        $authUser = authUser('api');
        $address = Address::where('id', $request->address_id)->where('user_id', $authUser->id)->first();

        if (!$address) {
            return response()->json([
                'toast' => __('Invalid Address'),
                'status' => false,
            ]);

        }

        DB::beginTransaction();
        try {

            Cart::where('user_id', $authUser->id)->delete();
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
                'address' => $address,
            ],
            'toast' => __('success'),
            'status' => true,
        ]);

    }

    public function home(Request $request)
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
        $authUser = authUser('api');
        $authUser_id = (authUser('api')) ? authUser('api')->id : 0;

        $longitude = $request->longitude ?? '';
        $latitude = $request->latitude ?? '';
        $img_path = '/uploads/';
        $home_banner = homeBanner::select(DB::raw('CONCAT("' . $img_path . '", image) as image '))->where('status', 'show')->first();
        $vendor_array = array();
        $vendor_menus = array();
        $grofirst_vendor = 'no';
        $pharma_vendor = 'no';


        $vendors = Vendor::select('allow_orders_within', 'free_delivery_upto', 'delivery_fee_per_km', DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo '), DB::raw("vendors.id,vendors.name,
        ( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"), DB::raw('CASE WHEN is_grofirst_vendor = "true" THEN "true" ELSE "false" END AS is_grofirst_vendor'))
            ->having('distance', '<=', DB::raw('vendors.allow_orders_within'))
            ->where('vendors.status', 'active')
            ->where('vendors.is_grofirst_vendor', true)
            ->orderBy('distance')            
            ->first(); 
         $vendors_all = Vendor::select('allow_orders_within', 'free_delivery_upto', 'delivery_fee_per_km', DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo '), DB::raw("vendors.id,vendors.name,
            ( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"), DB::raw('CASE WHEN is_grofirst_vendor = "true" THEN "true" ELSE "false" END AS is_grofirst_vendor'))
                ->having('distance', '<=', DB::raw('vendors.allow_orders_within'))
                ->where('vendors.status', 'active')
                //->where('vendors.is_grofirst_vendor', true)
    
                ->orderBy('distance')
                ->limit(20)
                ->get();
        $pharma_vendors = Vendor::select('allow_orders_within', 'free_delivery_upto', 'delivery_fee_per_km', DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo '), DB::raw("vendors.id,vendors.name,
            ( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"), DB::raw('CASE WHEN is_grofirst_vendor = "true" THEN "true" ELSE "false" END AS is_grofirst_vendor'))
        ->join('vendor_business_categories', 'vendor_business_categories.vendor_id', 'vendors.id')
        ->join('business_categories', 'business_categories.id', 'vendor_business_categories.business_category_id')
            ->having('distance', '<=', DB::raw('vendors.allow_orders_within'))
            ->where('business_categories.title', 'Pharma')

            ->where('vendors.status', 'active')
            ->orderBy('distance')
            ->limit(20)
            ->get();
        if($vendors) {
            $grofirst_vendor = 'yes';
        }
        if(count($pharma_vendors) > 0) {
            $pharma_vendor = 'yes';
        }

        if($vendors) {
           // array_push($vendor_array, $row->id);
            $vendor_menus = VendorMenu::select(
                '*',
                DB::raw('CASE WHEN image IS NOT NULL AND image <> "" THEN CONCAT("' . $img_path . '", image) ELSE NULL END AS image')
            )->where('vendor_id', $vendors->id)->orderBy('display_order', 'ASC')->get();
             

        }
        foreach ($vendors_all as $key => $row) {
            array_push($vendor_array, $row->id);
            // $vendor_menus = VendorMenu::select(
            //     '*',
            //     DB::raw('CASE WHEN image IS NOT NULL AND image <> "" THEN CONCAT("' . $img_path . '", image) ELSE NULL END AS image')
            // )->where('vendor_id', $row->id)->get();


        }
        // $categories = VendorBusinessCategory::select(DB::raw('CONCAT("' . $img_path . '", business_categories.image) as image'), 'business_categories.id', 'title', 'short_description', 'title_color', 'short_description_color', 'bg_color',DB::raw('COUNT("vendors.id") as store_count'))
        //     ->join('business_categories', 'business_categories.id', 'vendor_business_categories.business_category_id')
        //     ->join('vendors', 'vendors.id', 'vendor_business_categories.vendor_id')
        //     ->distinct('business_categories.id')
        //     ->whereIn('vendor_business_categories.vendor_id', $vendor_array)
        //     ->where('vendors.status', 'active')
        //     ->get();

        $categories = BusinessCategory::select(DB::raw('CONCAT("' . $img_path . '", business_categories.image) as image'), 'business_categories.id', 'title', 'short_description', 'title_color', 'short_description_color', 'bg_color', DB::raw('COUNT("vendors.id") as store_count'), DB::raw("group_concat(vendors.id) as `store_id`"))
        ->join('vendor_business_categories', 'vendor_business_categories.business_category_id', 'business_categories.id')
        ->join('vendors', 'vendors.id', 'vendor_business_categories.vendor_id')
        ->distinct('business_categories.id')
        ->whereIn('vendor_business_categories.vendor_id', $vendor_array)
        ->where('vendors.status', 'active')
        ->groupBy('business_categories.id')
        ->get();
        $count = 0;
        foreach($categories as $row){
            $categories[$count]->discount =  VendorProduct::select(DB::raw('MAX(100 - (ROUND((selling_price  * 100) / price, 1))) AS discount'))->where('business_category_id', $row->id)->whereIn('vendor_id', $vendor_array)->groupBy('business_category_id')->pluck('discount')->first();
            $count++;
        }

        $vendor_sliders = Vendor::select(DB::raw('CONCAT("' . $img_path . '", sliders.image) as image '), DB::raw("vendors.id as vendor_id,sliders.name,( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"), 'amount_to_avoid_min_delivery','allow_orders_within', 'free_delivery_upto', 'delivery_fee_per_km','avoide_delivery_fee','logo','main_logo',DB::raw('MAX(100 - (ROUND((selling_price  * 100) / price, 1))) AS discount'))
            ->join('sliders', 'sliders.vendor_id', 'vendors.id')
            ->leftjoin('vendor_products', 'vendor_products.vendor_id', 'vendors.id')
            ->having('distance', '<=', DB::raw('vendors.allow_orders_within'))
            ->where('vendors.status', 'active')
            ->groupBy('vendor_id')
            ->orderBy('distance')
            ->limit(20)
            ->get();

        $products = VendorProduct::select(
            'vendor_products.id',
            'vendor_products.name as product_name',
            'vendor_products.price',
            'vendor_products.selling_price',
            'carts.quantity as cart_quantity',
            'vendor_products.combination_key',
            'vendor_products.variant_option',
            'vendor_products.stock', 'vendor_products.available_at', 'vendor_products.available_to',
            'vendors.id as vendor_id',
            DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'),
            DB::raw('CONCAT("' . $img_path . '", vendors.logo) as vendor_logo '),
            DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount')
        )
            ->join('vendors', 'vendors.id', 'vendor_products.vendor_id')
        // ->join('vendor_business_categories', 'vendor_business_categories.vendor_id', 'vendors.id')
            ->join('business_categories', 'business_categories.id', 'vendor_products.business_category_id')
            ->leftjoin('carts', function ($join) use ($authUser_id) {
                $join->on('carts.product_id', 'vendor_products.id');
                $join->where('carts.user_id', '=', $authUser_id);

            })
        //->where('discount','>', 0)
            ->whereIn('vendors.id', $vendor_array)
            ->where('vendors.status', 'active')
            ->where('vendor_products.status', 'active')
            ->where('vendor_products.stock', 'in-stock')
            ->havingRaw('discount > 0')

            ->groupBy('vendor_products.combination_key')

            ->orderBy('discount', 'DESC')
            ->limit(12)->get();

        foreach ($products as $key => $row) {
            $varient_products = VendorProduct::select('vendor_products.id', 'vendor_products.name as product_name', 'vendor_products.price', 'vendor_products.selling_price', 'carts.quantity as cart_quantity', 'vendor_products.variant_option', 'vendor_products.combination_key', DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'), DB::raw('CONCAT("' . $img_path . '", vendors.logo) as vendor_logo '), DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'))
                ->join('vendors', 'vendors.id', 'vendor_products.vendor_id')
                ->join('business_categories', 'business_categories.id', 'vendor_products.business_category_id')
                ->leftjoin('carts', function ($join) use ($authUser_id) {
                    $join->on('carts.product_id', 'vendor_products.id');
                    $join->where('carts.user_id', '=', $authUser_id);

                })
                ->where('vendor_products.combination_key', $row->combination_key)
                ->where('vendors.status', 'active')
                ->orderBy('discount', 'DESC')

                ->get();
            $products[$key]['product_varients'] = $varient_products;
        }

        if ($products->isEmpty()) {
            $products = []; // Set products to null if it's empty
        }
        $cart_data = Cart::select(DB::raw('COUNT(carts.id) as cart_items_count'), DB::raw('SUM(vendor_products.selling_price * carts.quantity) as total_amount'))
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)
            ->where('vendor_products.stock', 'in-stock')
            ->first();
        $vendor_data =[];
        if($cart_data){
            $img_path = '/uploads/';
            $vendor_data = Vendor::select(
                'vendors.id',
                'vendors.name',
                'vendors.location',
                'vendors.free_delivery_upto',
                DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo '),
                'vendors.avoide_delivery_fee',
                'vendors.amount_to_avoid_min_delivery',
                'vendors.min_delivery_upto_km',
                'vendors.delivery_fee_per_km',
                'vendors.min_delivery_fee' 
            )
            ->join('vendor_products', 'vendor_products.vendor_id', 'vendors.id')
            ->join('carts', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)->first();
        }
        // DB::raw('CONCAT("' . $Product_imagepath . '", product_images.product_image) AS productimage');

        return response()->json([
            'data' => [
                'home_banner' => $home_banner,
                'categories' => $categories,
                // 'vendors' => $vendors,
                'products' => $products,
                'sliders' => $vendor_sliders,
                'cart_data' => $cart_data,
                'vendor_menus' => $vendor_menus,
                'pharma_vendor'=>$pharma_vendor,
                'grofirst_vendor' => $grofirst_vendor,
                'cart_store' => $vendor_data,

            ],
            'status' => true,
        ]);
    }
    public function storeList(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'category_id' => ['required'],
            'latitude' => ['required', 'numeric', 'max:100'],
            'longitude' => ['required', 'max:100'],
        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        // $authUser = authUser('api');
        $longitude = $request->longitude ?? '';
        $latitude = $request->latitude ?? '';
        $img_path = '/uploads/';
        $search = $request->search ?? null;
        $authUser_id = (authUser('api')) ? authUser('api')->id : 0;
        $time_str = time();
        $time = date('H:i:s', time());
        $post_time_str = time() + 60 * 60;
        $post_time = date('H:i:s', time() + 60 * 60);
        $slot_array = array();
        $final_slot_array = array();
        $today = Carbon::parse(date('Y-m-d H:i:s'))->dayName;
        $vendor_ids = [];
        $vendor_ids = VendorBusinessCategory::where('business_category_id', $request->category_id)->distinct()->pluck('vendor_id');
        $sliders = Slider::select(DB::raw("vendors.id as vendor_id,sliders.name as slider_name,( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"), DB::raw('CONCAT("' . $img_path . '", sliders.image) as image '), 'allow_orders_within')
            ->join('vendors', 'sliders.vendor_id', 'vendors.id')
            ->having('distance', '<=', DB::raw('vendors.allow_orders_within'))
            ->where('vendors.status', 'active')
            ->whereIn('vendors.id', $vendor_ids)
            ->orderBy('distance')
            ->limit(20)
            ->get();

        $stores = Vendor::select(DB::raw('vendors.id,vendors.name,vendors.location,vendors.star_rating,vendors.online,vendors.scheduled_delivery,free_delivery_upto,delivery_fee_per_km,CONCAT("' . $img_path . '", vendors.logo) as logo,CONCAT("' . $img_path . '", vendors.main_logo) as main_logo'), DB::raw('CONCAT("' . $img_path . '", vendors.image) as image '), DB::raw("( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"), 'allow_orders_within','avoide_delivery_fee',DB::raw('MAX(100 - (ROUND((selling_price  * 100) / price, 1))) AS discount'), DB::raw('CASE WHEN is_grofirst_vendor = "true" THEN "true" ELSE "false" END AS is_grofirst_vendor'))
            ->join('vendor_business_categories', 'vendor_business_categories.vendor_id', 'vendors.id')
            ->join('business_categories', 'business_categories.id', 'vendor_business_categories.business_category_id')
            ->leftjoin('sliders', 'sliders.vendor_id', 'vendors.id')
            ->leftjoin('vendor_products', 'vendor_products.vendor_id', 'vendors.id')
            ->leftjoin('vendor_working_hours', 'vendor_working_hours.vendor_id', 'vendors.id');
        if ($search) {
            $stores->where(function ($query) use ($search) {
                $query->orWhere('vendors.name', 'like', '%' . $search . '%');
                $query->orWhere('vendors.location', 'like', '%' . $search . '%');

            });
        }
        $stores = $stores->having('distance', '<=', DB::raw('vendors.allow_orders_within'))

            ->distinct('vendors.id')
            ->where('vendors.status', 'active')
            ->where('business_categories.id', $request->category_id)
            ->groupBy('vendors.id')
            ->orderBy('distance', 'ASC')
            ->get();
        $cart_data = Cart::select(DB::raw('COUNT(carts.id) as cart_items_count'), DB::raw('SUM(vendor_products.selling_price * carts.quantity) as total_amount'))
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)
            ->where('vendor_products.stock', 'in-stock')
            ->first();
        $vendor_data =[];
        if($cart_data){
            $img_path = '/uploads/';
            $vendor_data = Vendor::select(
                'vendors.id',
                'vendors.name',
                'vendors.location',
                'vendors.free_delivery_upto',
                DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo '),
                'vendors.avoide_delivery_fee',
                'vendors.amount_to_avoid_min_delivery',
                'vendors.min_delivery_upto_km',
                'vendors.delivery_fee_per_km',
                'vendors.min_delivery_fee' 
            )
            ->join('vendor_products', 'vendor_products.vendor_id', 'vendors.id')
            ->join('carts', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)->first();
        }
        foreach ($stores as $key => $row) {
            if ($row->scheduled_delivery == '1') {
                // $vendorslotes = VendorDeliverySlot::where('vendor_id', $row->id)->pluck('slot_ids')->first();
                $delivery_slots = DeliverySlot::orderBy('start', 'ASC')->get();
                $working_days = VendorWorkingHours::where('vendor_id', $row->id)->pluck('day')->toArray();
                $working_days_arr = VendorWorkingHours::where('vendor_id', $row->id)->get();

                if (($row->online == 1) && (in_array($today, array_map('ucfirst', $working_days)))) {

                    $working_hours = VendorWorkingHours::where('vendor_id', $row->id)->where('day', $today)->first();
                    $now = Carbon::now();
                    $start = Carbon::createFromTimeString($working_hours->from);
                    $end = Carbon::createFromTimeString($working_hours->to);

                    if ($now->between($start, $end)) {
                        $stores[$key]['working_status'] = "open";
                        $stores[$key]['next_opening'] = '';
                        $stores[$key]['next_day'] = '';
                    } else {
                        if (count($working_days) > 0) {
                            $j = ($now > $start) ? 1 : 0;
                            $k = ($now > $start) ? 7 : 6;

                            for ($i = $j; $i <= $k; $i++) {
                                $newDateTime = Carbon::now()->addDay($i);
                                $day = $newDateTime->format('l');
                                if (in_array($day, array_map('ucfirst', $working_days))) {
                                    $work = VendorWorkingHours::where('vendor_id', $row->id)->where('day', 'LIKE', "%{$day}%")
                                        ->first();
                                    $stores[$key]['next_opening'] = $work->from;
                                    $stores[$key]['next_day'] = $work->day;

                                    break;
                                }

                            }

                        } else {
                            $stores[$key]['next_opening'] = '';
                            $stores[$key]['next_day'] = '';
                        }
                        $stores[$key]['working_status'] = "closed";
                    }

                } else {
                    if (count($working_days) > 0) {
                        // dd($working_days_arr);
                        for ($i = 1; $i <= 7; $i++) {

                            $newDateTime = Carbon::now()->addDay($i);
                            $day = $newDateTime->format('l');
                            if (in_array($day, array_map('ucfirst', $working_days))) {
                                $work = VendorWorkingHours::where('vendor_id', $row->id)->where('day', 'LIKE', "%{$day}%")
                                    ->first();
                                $stores[$key]['next_opening'] = $work->from;
                                $stores[$key]['next_day'] = $work->day;

                                break;
                            }

                        }

                    } else {
                        $stores[$key]['next_opening'] = '';
                        $stores[$key]['next_day'] = '';
                    }
                    $stores[$key]['working_status'] = "closed";
                }
            } else {
                $stores[$key]['next_opening'] = '';
                $stores[$key]['next_day'] = '';
                $stores[$key]['working_status'] = "closed";

            }

            // $stores[$key]['next_delivery'] = (count($final_slot_array) > 0) ? $final_slot_array : null;

        }
        return response()->json([
            'data' => [
                'sliders' => $sliders,
                'stores' => $stores,
                'cart_data' => $cart_data,
                'cart_store'=>$vendor_data

            ],
            'status' => true,
        ]);

    }

    public function vendorProducts(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'vendor_id' => ['required'],
            'latitude' => ['required', 'numeric', 'max:100'],
            'longitude' => ['required', 'numeric', 'max:100'],
        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $img_path = '/uploads/';
        $vendor = Vendor::where('status', 'active')->find($request->vendor_id);

        if ($vendor == null) {
            return response()->json([
                'toast' => __('Invalid Vendor'),
                'status' => false,
            ]);
        }

        // $authUser_id = authUser('api')->id;
        $authUser_id = (authUser('api')) ? authUser('api')->id : 0;

        $longitude = $request->longitude ?? '';
        $latitude = $request->latitude ?? '';

        $search = $request->search ?? null;
        $selected_menu = $request->selected_menu ?? null;
        $selected_submenu = $request->selected_submenu ?? null;
        $next_slot_id = 0;

        $cart_data = Cart::select(DB::raw('COUNT(carts.id) as cart_items_count'), DB::raw('SUM(vendor_products.selling_price * carts.quantity) as total_amount'))
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)
            ->where('vendor_products.stock', 'in-stock')
            ->first();
        $vendor_data =[];
        if($cart_data){
            $img_path = '/uploads/';
            $vendor_data = Vendor::select(
                'vendors.id',
                'vendors.name',
                'vendors.location',
                'vendors.free_delivery_upto',
                DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo '),
                'vendors.avoide_delivery_fee',
                'vendors.amount_to_avoid_min_delivery',
                'vendors.min_delivery_upto_km',
                'vendors.delivery_fee_per_km',
                'vendors.min_delivery_fee' 
            )
            ->join('vendor_products', 'vendor_products.vendor_id', 'vendors.id')
            ->join('carts', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)->first();
        }
        // dd(Cart::where('carts.user_id', $authUser_id)->get());
        // dd(Cart::select('vendor_products.*')->join('vendor_products', 'carts.product_id', 'vendor_products.id')->get());

        // $vendorslotes = VendorDeliverySlot::where('vendor_id', $vendor->id)->pluck('slot_ids')->first();
        $delivery_slots = array();
        $delivery_slots = DeliverySlot::orderBy('start', 'ASC')->get();

        $working_days = VendorWorkingHours::where('vendor_id', $vendor->id)->pluck('day')->toArray();
        $time_str = time();
        $time = date('H:i:s', time());

        $post_time_str = time() + 60 * 60;
        $post_time = date('H:i:s', time() + 60 * 60);

        $today = Carbon::parse(date('Y-m-d H:i:s'))->dayName;

        $slot_array = array();

        $final_slot_array = array();

        if ((count($working_days) > 0) && (count($delivery_slots) > 0)) {

            foreach ($delivery_slots as $key => $slot) {

                $slot_time_arr = strtotime($slot->start);

                $diff = $slot_time_arr - $post_time_str;

                if ((($diff) > 0) && in_array($today, array_map('ucfirst', $working_days))) {
                    $slot_array[$key]['day'] = $today;
                    $slot_array[$key]['slot_id'] = $slot->id;
                    $slot_array[$key]['slot_name'] = $slot->slot_name;
                    // $slot_array[$key]['post_time'] = $post_time;
                    $slot_array[$key]['start_time'] = $slot->start;
                    $slot_array[$key]['end_time'] = $slot->end;
                    $slot_array[$key]['diff_time'] = $diff;
                }

            }
            if (!count($slot_array) > 0) {

                foreach ($delivery_slots as $key => $slot) {

                    $slot_time_arr = strtotime($slot->start);

                    $diff = $slot_time_arr - $post_time_str;
                    $day = $this->nextWorkingday($vendor->id);

                    $slot_array[$key]['day'] = $day;
                    $slot_array[$key]['slot_id'] = $slot->id;
                    $slot_array[$key]['slot_name'] = $slot->slot_name;
                    // $slot_array[$key]['post_time'] = $post_time;
                    $slot_array[$key]['start_time'] = $slot->start;
                    $slot_array[$key]['end_time'] = $slot->end;
                    $slot_array[$key]['diff_time'] = $diff;

                }

            }
            array_multisort(array_column($slot_array, "diff_time"), SORT_ASC, $slot_array);

            $final_slot_array = $slot_array[0];
        }

        $store_details = Vendor::select('id', 'name', 'address', 'location', 'landmark', 'state', 'district', 'pincode', 'scheduled_delivery', 'star_rating', 'online', 'free_delivery_upto', 'delivery_fee_per_km', DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo '), DB::raw("( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"), DB::raw('CASE WHEN is_grofirst_vendor = "true" THEN "true" ELSE "false" END AS is_grofirst_vendor'))
            ->where('id', $request->vendor_id)->get();

        foreach ($store_details as $key => $row) {

            if (($row->online == 1) && (in_array($today, array_map('ucfirst', $working_days)))) {
                $working_hours = VendorWorkingHours::where('vendor_id', $row->id)->where('day', $today)->first();
                $now = Carbon::now();
                $start = Carbon::createFromTimeString($working_hours->from);
                $end = Carbon::createFromTimeString($working_hours->to);

                if ($now->between($start, $end)) {
                    $store_details[$key]['working_status'] = "online";
                } else {
                    $store_details[$key]['working_status'] = "offline";
                }
            } else {
                $store_details[$key]['working_status'] = "offline";
            }

            $store_details[$key]['next_delivery'] = ((count($final_slot_array) > 0) && ($row->scheduled_delivery == 1)) ? $final_slot_array : null;

        }
        // $store_details[$key]['next_slot']='';
        $menus = VendorMenu::select('id', 'name')->where('vendor_id', $request->vendor_id)->where('status', 'show')->orderBy('display_order', 'ASC')->get();
        foreach ($menus as $key => $menu) {
            $product_ids = VendorProduct::where('vendor_products.menu_id', $menu->id)->groupBy('vendor_products.combination_key')->distinct()->pluck('id');

            $products = VendorProduct::select('vendor_products.id', 'vendor_products.name', 'vendor_products.price', 'vendor_products.selling_price', 'vendor_products.variant_option', 'vendor_products.type', 'vendor_products.stock', 'vendor_products.combination_key', 'vendor_menu.id as menu_id', 'vendor_menu.name as menu', 'vendor_menu.id as submenu_id', 'vendor_menu.name as submenu', 'carts.quantity as cart_quantity', 'vendors.id as vendors_id', DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'), DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'), 'vendor_products.product_id', 'vendor_products.available_at', 'vendor_products.available_to')
                ->join('vendors', 'vendors.id', 'vendor_products.vendor_id')
                ->join('vendor_business_categories', 'vendor_business_categories.vendor_id', 'vendors.id')
                ->join('business_categories', 'business_categories.id', 'vendor_business_categories.business_category_id')
                ->join('vendor_menu', 'vendor_menu.id', 'vendor_products.menu_id')
                ->leftjoin('vendor_submenu', 'vendor_submenu.id', 'vendor_products.submenu_id')
                ->leftjoin('carts', function ($join) use ($authUser_id) {
                    $join->on('carts.product_id', 'vendor_products.id');
                    $join->where('carts.user_id', '=', $authUser_id);

                });

            // ->join('vendor_products', 'business_categories.id', 'vendor_products.business_category_id');

            if ($search) {
                $products->where(function ($query) use ($search) {
                    $query->orWhere('vendor_products.name', 'like', '%' . $search . '%');
                    $query->orWhere('vendor_products.short_description', 'like', '%' . $search . '%');
                    $query->orWhere('vendors.name', 'like', '%' . $search . '%');
                    $query->orWhere('vendor_products.product_code', 'like', '%' . $search . '%');
                    $query->orWhere('vendor_products.keywords', 'like', '%' . $search . '%');

                });
            }
            if ($selected_menu) {
                // $products->where('vendor_products.menu_id', $selected_menu);
                $products->where(function ($query) use ($selected_menu) {

                    $query->where('vendor_products.menu_id', $selected_menu);
                });
            }
            if ($selected_submenu) {
                // $products->where('vendor_products.submenu_id', $selected_submenu);
                $products->where(function ($query) use ($selected_submenu) {
                    $query->where('vendor_products.submenu_id', $selected_submenu);
                });
            }



            $products = $products->where('vendor_products.vendor_id', $vendor->id)
                ->where('vendor_menu.status', 'show')
                ->where('vendor_products.menu_id', $menu->id)
                ->where('vendor_products.status', 'active')
                ->where('vendors.status', 'active')
                ->whereIn('vendor_products.id', $product_ids)
                ->distinct()

                // ->distinct('vendor_products.id')
                // ->groupBy('vendor_products.combination_key')
                // ->orderBy('discount')
                ->orderBy('vendor_products.display_order', 'ASC')
                ->paginate(6);

            foreach ($products as $index => $row) {
                $products_varients = VendorProduct::select(
                    'vendor_products.id',
                    'vendor_products.variant_option',
                    'vendor_products.name',
                    'vendor_products.price',
                    'vendor_products.selling_price',
                    'combination_key',
                    'stock', 'vendor_products.available_at', 'vendor_products.available_to',
                    'carts.quantity as cart_quantity',
                    DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount')
                )
                    ->leftjoin('carts', function ($join) use ($authUser_id) {
                        $join->on('carts.product_id', 'vendor_products.id');
                        $join->where('carts.user_id', '=', $authUser_id);

                    })
                    ->where('combination_key', $row->combination_key)
                    ->distinct()
                    ->orderBy('vendor_products.display_order', 'ASC')
                    ->get();
                $products[$index]['product_varients'] = $products_varients;

            }

            $submenus = VendorSubmenu::select('id', 'name')->where('vendor_menu_id', $menu->id)->orderBy('display_order', 'ASC')->get();
            if (count($submenus) > 0) {
                foreach ($submenus as $key2 => $submenu) {
                    $sub_product_ids = VendorProduct::where('vendor_products.menu_id', $menu->id)
                    ->where('vendor_products.submenu_id', $submenu->id)->groupBy('vendor_products.combination_key')->distinct()->pluck('id');

                    $submenuproducts = VendorProduct::select('vendor_products.id', 'vendor_products.name', 'vendor_products.price', 'vendor_products.selling_price', 'vendor_products.variant_option', 'vendor_products.type', 'vendor_products.combination_key', 'vendor_products.stock', 'vendor_menu.id as menu_id', 'vendor_menu.name as menu', 'carts.quantity as cart_quantity', 'vendors.id as vendors_id', DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'), DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'), 'vendor_products.product_id', 'vendor_products.available_at', 'vendor_products.available_to')
                        ->join('vendors', 'vendors.id', 'vendor_products.vendor_id')
                        ->join('vendor_business_categories', 'vendor_business_categories.vendor_id', 'vendors.id')
                        ->join('business_categories', 'business_categories.id', 'vendor_business_categories.business_category_id')
                        ->join('vendor_menu', 'vendor_menu.id', 'vendor_products.menu_id')
                        ->join('vendor_submenu', 'vendor_submenu.id', 'vendor_products.submenu_id')
                        ->leftjoin('carts', function ($join) use ($authUser_id) {
                            $join->on('carts.product_id', 'vendor_products.id');
                            $join->where('carts.user_id', '=', $authUser_id);

                        })
                        ->where('vendor_products.vendor_id', $vendor->id)
                        ->where('vendor_menu.status', 'show')
                        ->where('vendor_products.menu_id', $menu->id)
                        ->where('vendor_products.submenu_id', $submenu->id)
                        ->where('vendor_products.status', 'active')
                        ->where('vendors.status', 'active')
                        ->whereIn('vendor_products.id', $sub_product_ids)

                        // ->distinct('vendor_products.id')
                        // ->groupBy('vendor_products.combination_key')
                        ->distinct()

                        // ->orderBy('discount')
                        ->orderBy('vendor_products.display_order', 'ASC')
                        ->paginate(6);

                    foreach ($submenuproducts as $index2 => $row) {
                        $subproducts_varients = VendorProduct::select(
                            'vendor_products.id',
                            'vendor_products.variant_option',
                            'vendor_products.name',
                            'vendor_products.price',
                            'vendor_products.selling_price',
                            'vendor_products.combination_key',
                            'vendor_products.stock', 'vendor_products.available_at', 'vendor_products.available_to',
                            'carts.quantity as cart_quantity',
                            DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'),
                            'vendor_products.product_id'
                        )
                            ->leftjoin('carts', function ($join) use ($authUser_id) {
                                $join->on('carts.product_id', 'vendor_products.id');
                                $join->where('carts.user_id', '=', $authUser_id);

                            })
                            ->where('combination_key', $row->combination_key)
                            ->distinct()
                            ->orderBy('vendor_products.display_order', 'ASC')
                            ->get();
                        $submenuproducts[$index2]['product_varients'] = $subproducts_varients;

                    }
                    $submenus[$key2]['products'] = $submenuproducts;
                }
            }
            $menus[$key]['submenus'] = $submenus;
            $menus[$key]['products'] = $products;

        }

        return response()->json([
            'data' => [
                'cart_data' => $cart_data,
                'store' => $store_details,
                'menus' => $menus,
                'cart_store'=>$vendor_data
            ],
            'status' => true,
        ]);

    }
    public function nextWorkingday($vendor_id)
    {

        $working_days = VendorWorkingHours::where('vendor_id', $vendor_id)->pluck('day')->toArray();
        if (count($working_days) > 0) {
            //

            for ($i = 1; $i <= 7; $i++) {

                $newDateTime = Carbon::now()->addDay($i);
                $day = $newDateTime->format('l');
                if (in_array($day, array_map('ucfirst', $working_days))) {
                    return $day;

                    break;
                }

            }
        }
        return false;

    }
    public function nextWorkingdayDate($vendor_id)
    {

        $working_days = VendorWorkingHours::where('vendor_id', $vendor_id)->pluck('day')->toArray();
        if (count($working_days) > 0) {
            //

            for ($i = 1; $i <= 7; $i++) {

                $newDateTime = Carbon::now()->addDay($i);
                $day = $newDateTime->format('l');
                $day_date = $newDateTime->format('Y-m-d');
                if (in_array($day, array_map('ucfirst', $working_days))) {
                    return $day_date;

                    break;
                }

            }
        }
        return false;

    }
    public function productDetails(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'product_id' => ['required'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        // dd(Product::all());
        // $authUser_id = authUser('api')->id;
        $authUser_id = (authUser('api')) ? authUser('api')->id : 0;

        $img_path = '/uploads/';
        // dd(VendorProduct::all());
        $products_details = VendorProduct::select(
            'vendor_products.id',
            'vendor_products.product_id',
            'vendor_products.name',
            'vendor_products.description',
            'vendor_products.price',
            'vendor_products.selling_price',
            'vendor_products.variant_option',
            'vendor_products.type',
            'vendor_products.combination_key',
            'vendor_products.vendor_id',
            'vendor_products.menu_id',
            'vendor_products.submenu_id',
            'vendor_products.image',
            'vendor_products.stock', 'vendor_products.available_at', 'vendor_products.available_to',
            'vendor_products.product_description',
            'carts.quantity as cart_quantity',
            DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image '),
            DB::raw('CONCAT("' . $img_path . '", vendor_products.gallery_image_1) as gallery_image_1 '),
            DB::raw('CONCAT("' . $img_path . '", vendor_products.gallery_image_2) as gallery_image_2 '),
            DB::raw('CONCAT("' . $img_path . '", vendor_products.gallery_image_3) as gallery_image_3 '),
            DB::raw('CONCAT("' . $img_path . '", vendor_products.gallery_image_4) as gallery_image_4 '),
            DB::raw('100 - (ROUND((vendor_products.selling_price  * 100) / vendor_products.price, 1)) AS discount')
        )
            ->leftjoin('carts', function ($join) use ($authUser_id) {
                $join->on('carts.product_id', 'vendor_products.id');
                $join->where('carts.user_id', '=', $authUser_id);

            })
            ->where('vendor_products.id', $request->product_id)
            ->distinct('vendor_products.id')
            ->orderBy('discount')
            ->first();

        if ($products_details == null) {
            return response()->json([
                'toast' => __('Invalid Product'),
                'status' => false,
            ]);
        }

        $vendor = Vendor::where('status', 'active')->find($products_details->vendor_id);
        if (!$vendor) {
            return response()->json([
                'toast' => __('Invalid Vendor'),
                'status' => false,
            ]);
        }
        $cart_data = Cart::select(DB::raw('COUNT(carts.id) as cart_items_count'), DB::raw('SUM(vendor_products.selling_price * carts.quantity) as total_amount'))
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)
            ->where('vendor_products.stock', 'in-stock')
            ->first();
        $vendor_data =[];
        if($cart_data){
            $img_path = '/uploads/';
            $vendor_data = Vendor::select(
                'vendors.id',
                'vendors.name',
                'vendors.location',
                'vendors.free_delivery_upto',
                DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo '),
                'vendors.avoide_delivery_fee',
                'vendors.amount_to_avoid_min_delivery',
                'vendors.min_delivery_upto_km',
                'vendors.delivery_fee_per_km',
                'vendors.min_delivery_fee' 
            )
            ->join('vendor_products', 'vendor_products.vendor_id', 'vendors.id')
            ->join('carts', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)->first();
        }

        $products_varients = VendorProduct::select(
            'vendor_products.id',
            'vendor_products.variant_option',
            'vendor_products.type',
            'vendor_products.name',
            'vendor_products.price',
            'vendor_products.selling_price',
            'vendor_products.stock',
            'carts.quantity as cart_quantity', 'vendor_products.available_at', 'vendor_products.available_to',
            DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount')
        )
            ->leftjoin('carts', function ($join) use ($authUser_id) {
                $join->on('carts.product_id', 'vendor_products.id');
                $join->where('carts.user_id', '=', $authUser_id);
            })
            ->where('combination_key', $products_details->combination_key)
        // ->where('id', '!=', $products_details->id)
            ->distinct()
            ->orderBy('discount')
            ->get();

        $smilarproducts = VendorProduct::select('vendor_products.id', 'vendor_products.name', 'vendor_products.price', 'vendor_products.selling_price', 'vendor_products.variant_option', 'vendor_products.type', 'vendor_products.combination_key', 'vendor_products.stock', 'vendor_menu.id as menu_id', 'vendor_menu.name as menu', 'carts.quantity as cart_quantity', 'vendors.id as vendors_id', DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'), DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'), 'vendor_products.product_id', 'vendor_products.available_at', 'vendor_products.available_to')
            ->join('vendors', 'vendors.id', 'vendor_products.vendor_id')
            ->join('vendor_business_categories', 'vendor_business_categories.vendor_id', 'vendors.id')
            ->join('business_categories', 'business_categories.id', 'vendor_business_categories.business_category_id')
            ->join('vendor_menu', 'vendor_menu.id', 'vendor_products.menu_id')
            ->join('vendor_submenu', 'vendor_submenu.id', 'vendor_products.submenu_id')
            ->leftjoin('carts', function ($join) use ($authUser_id) {
                $join->on('carts.product_id', 'vendor_products.id');
                $join->where('carts.user_id', '=', $authUser_id);

            })
            ->where('vendor_products.vendor_id', $vendor->id)
            ->where('vendor_menu.status', 'show')
            ->where('vendor_products.menu_id', $products_details->menu_id)
            ->where('vendor_products.submenu_id', $products_details->submenu_id)
            ->where('vendor_products.status', 'active')
            ->where('vendors.status', 'active')
            ->where('vendor_products.id','!=', $products_details->id)

            // ->distinct('vendor_products.id')
            // ->groupBy('vendor_products.combination_key')
            ->distinct()

            // ->orderBy('discount')
            ->orderBy('vendor_products.display_order', 'ASC')
            ->paginate(5);

        return response()->json([
            'data' => [
                'product_details' => $products_details,
                'product_varients' => $products_varients,
                'cart_data' => $cart_data,
                'cart_store'=>$vendor_data,
                'smilarproducts'=>$smilarproducts,
            ],
            'status' => true,
        ]);

    }
    public function vendorMenus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => ['required'],

        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $vendor = Vendor::where('status', 'active')->find($request->vendor_id);
        $img_path = '/uploads/';

        if ($vendor) {
            $vendormenus = VendorMenu::select('id', 'name', DB::raw('CONCAT("' . $img_path . '", image) as image '))->where('vendor_id', $vendor->id)->orderBy('display_order', 'ASC')->get();
            if (count($vendormenus) > 0) {
                foreach ($vendormenus as $key => $vendormenu) {
                    $submenus = VendorSubmenu::select('id', 'name', 'vendor_menu_id', DB::raw('CONCAT("' . $img_path . '", image) as image '))->where('vendor_menu_id', $vendormenu->id)->orderBy('display_order', 'ASC')->get();
                    $vendormenus[$key]['submenus'] = $submenus;
                }
            }
        } else {
            return response()->json([
                'toast' => __('Invalid Vendor'),
                'status' => false,
            ]);

        }
        return response()->json([
            'data' => [
                'menus' => $vendormenus,
            ],
            'status' => true,

        ]);

    }

    public function productVarients(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'product_id' => ['required'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        // dd(Product::all());
        $authUser_id = authUser('api')->id;

        $img_path = '/uploads/';

        $products_details = VendorProduct::select(
            'id',
            'name',
            'combination_key',
            DB::raw('CONCAT("' . $img_path . '", image) as image ')
        )
            ->where('id', $request->product_id)
            ->distinct('id')

            ->first();

        if ($products_details == null) {
            return response()->json([
                'toast' => __('Invalid Product'),
                'status' => false,
            ]);
        }
        $products_varients = VendorProduct::select(
            'vendor_products.id',
            'vendor_products.variant_option',
            'vendor_products.name',
            'vendor_products.price',
            'vendor_products.selling_price',
            'vendor_products.type',
            'vendor_products.stock', 'vendor_products.available_at', 'vendor_products.available_to',
            DB::raw('100 - (ROUND((vendor_products.selling_price  * 100) / vendor_products.price, 1)) AS discount'),
            'carts.quantity as cart_quantity',
            DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image ')
        )

            ->leftjoin('carts', function ($join) use ($authUser_id) {
                $join->on('carts.product_id', 'vendor_products.id');
                $join->where('carts.user_id', '=', $authUser_id);
            })
            ->where('combination_key', $products_details->combination_key)
            ->where('vendor_products.status', 'active')
        // ->where('id', '!=', $products_details->id)
            ->distinct()
            // ->orderBy('discount')
            ->orderBy('vendor_products.display_order', 'ASC')
            ->get();

        return response()->json([
            'data' => [
                'product' => $products_details,
                'product_varients' => $products_varients,
            ],
            'status' => true,
        ]);

    }
    public function addtoCart(Request $request, Cart $cart)
    {
        $validator = Validator::make(request()->all(), [
            'product_id' => ['required'],
            'quantity' => ['required', 'integer', 'min:1', 'gt:0'],
            'type' => ['nullable', 'in:addtocart,clearcart'],

        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $img_path = '/uploads/';
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);

        }
        // $exist_cartdata = Cart::join('vendor_products', 'carts.product_id', 'vendor_products.id')
        // ->select('vendor_products.name as product_name', 'carts.quantity', 'vendor_products.vendor_id', 'vendor_products.id as product_id', 'vendor_products.price', 'vendor_products.selling_price', DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'), DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'))
        // ->where('carts.user_id', $authUser_id)
        // ->get();
        $Product = VendorProduct::find($request->product_id);
        if (!$Product) {
            return response()->json([
                'toast' => __('Invalid Product'),
                'status' => false,
            ]);
        }
        if (isset($request->type) && ($request->type == "clearcart")) {
            Cart::where('user_id', $authUser_id)->delete();
        }

        $cartvendor_id = Cart::join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)->pluck('vendor_products.vendor_id')->first();

        if ($cartvendor_id) {
            $vendor_data = Vendor::find($cartvendor_id);
            if ($Product->vendor_id != $cartvendor_id) {
                return response()->json([
                    'toast' => __('Another store products exist in the cart.'),
                    'status' => false,
                ]);
            }

            $cart_weight = Cart::select(DB::raw('SUM(vendor_products.weight * carts.quantity) as totalweight'))
                ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
                ->where('carts.user_id', $authUser_id)
                ->first();
            if ($cart_weight) {
                $total_weight = $cart_weight->totalweight + $Product->weight;
                if ($total_weight > $vendor_data->maximum_weight_to_deliver) {
                    return response()->json([
                        'toast' => __('Store weight limit exceeded'),
                        'status' => false,
                    ]);
                }
            }
        }

        $exist_cart_product = Cart::select(DB::raw('SUM(vendor_products.weight * carts.quantity) as totalweight'), 'carts.quantity')
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->Where('carts.product_id', $request->product_id)
            ->where('carts.user_id', $authUser_id)
            ->first();
        if ($exist_cart_product) {
            $total_quantity = $exist_cart_product->quantity + $request->quantity;
            // $total_product_weight = $exist_cart_product->totalweight + $Product->weight;

            // if ($total_product_weight > $Product->max_qty && $Product->max_qty != 0.00) {
            //     return response()->json([
            //         'toast' => __('Maximum Product weight limit exceeded'),
            //         'status' => false,
            //     ]);

            // }

            if (($Product->max_qty != '') && ($total_quantity > $Product->max_qty)) {
                return response()->json([
                    'toast' => __('Maximum Product Purchase limit exceeded'),
                    'status' => false,
                ]);

            }
        }

        $carts = Cart::Where('product_id', $request->product_id)->where('user_id', $authUser_id)->exists();
        $input = $request->only(['product_id', 'quantity']);

        $input['user_id'] = $authUser_id;
        DB::beginTransaction();

        if (!$carts) {

            try {
                $cart_action = Cart::create($input);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'toast' => __('Something went wrong.'),
                    'status' => false,
                ]);
            }
        } else {

            try {
                $cart_action = Cart::where('user_id', $authUser_id)
                    ->where('product_id', $request->product_id)
                    ->increment('quantity', $request->quantity);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'toast' => __('Something went wrong.'),
                    'status' => false,
                ]);
            }
        }
        DB::commit();
        $cartdata = Cart::select(
            'carts.id as cart_id',
            'carts.quantity as cart_quantity',
            'vendor_products.vendor_id',
            'vendor_products.weight',
            'vendor_products.id as product_id',
            'vendor_products.name as product_name',
            'vendor_products.price',
            'vendor_products.selling_price',
            'vendor_products.stock', 'vendor_products.available_at', 'vendor_products.available_to',
            DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'),
            DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'),
            DB::raw('carts.quantity * vendor_products.selling_price as total_price')
        )
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)
            ->get();
        return response()->json([
            'data' => [
                'cart' => $cartdata,
            ],
            'status' => true,
        ]);

    }
    public function showCart(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'address_id' => ['required'],
        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $img_path = '/uploads/';
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }

        $address = Address::where('id', $request->address_id)->where('user_id', $authUser_id)->first();
        if (!$address) {
            return response()->json([
                'toast' => __('Invalid Address'),
                'status' => false,
            ]);

        }
        $other_addresses = Address::where('user_id', $authUser_id)->where('id', '!=', $address->id)->get();
        $latitude = $address->latitude;
        $longitude = $address->longitude;
        $vendor_id = Cart::join('vendor_products', 'vendor_products.id', 'carts.product_id')->where('carts.user_id', $authUser_id)->pluck('vendor_products.vendor_id')->first();
        $vendor = Vendor::select('vendors.*', DB::raw("vendors.id,vendors.name,( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"))
            ->find($vendor_id);
        if ($vendor == null) {
            return response()->json([
                'data' => [
                    'cart' => [],
                ],
                'toast' => __('Your cart is empty'),
                'status' => true,
            ]);
        }

        // $vendorslotes = VendorDeliverySlot::where('vendor_id', $vendor->id)->pluck('slot_ids')->first();
        $delivery_slots = array();
        if (($vendor->scheduled_delivery == '1')) {
            $delivery_slots = DeliverySlot::orderBy('start', 'ASC')->get();
        }

        $working_days = VendorWorkingHours::where('vendor_id', $vendor->id)->pluck('day')->toArray();
        $time_str = time();
        $time = date('H:i:s', time());

        $post_time_str = time() + 60 * 60;
        $post_time = date('H:i:s', time() + 60 * 60);

        $today = Carbon::parse(date('Y-m-d H:i:s'))->dayName;
        $slot_array = array();
        $final_slot_array = array();

        if ((count($working_days) > 0) && (count($delivery_slots) > 0)) {
            foreach ($delivery_slots as $key => $slot) {

                $slot_time_arr = strtotime($slot->start);

                $diff = $slot_time_arr - $post_time_str;
                if ((($diff) > 0) && in_array($today, array_map('ucfirst', $working_days))) {

                    $slot_array[$key]['day'] = $today;
                    $slot_array[$key]['slot_id'] = $slot->id;
                    $slot_array[$key]['slot_name'] = $slot->slot_name;
                    // $slot_array[$key]['post_time'] = $post_time;
                    $slot_array[$key]['start_time'] = $slot->start;
                    $slot_array[$key]['end_time'] = $slot->end;
                    $slot_array[$key]['diff_time'] = $diff;
                }

            }
            if (!count($slot_array) > 0) {

                foreach ($delivery_slots as $key => $slot) {

                    $slot_time_arr = strtotime($slot->start);

                    $diff = $slot_time_arr - $post_time_str;
                    $day = $this->nextWorkingday($vendor->id);

                    $slot_array[$key]['day'] = $day;
                    $slot_array[$key]['slot_id'] = $slot->id;
                    $slot_array[$key]['slot_name'] = $slot->slot_name;
                    // $slot_array[$key]['post_time'] = $post_time;
                    $slot_array[$key]['start_time'] = $slot->start;
                    $slot_array[$key]['end_time'] = $slot->end;
                    $slot_array[$key]['diff_time'] = $diff;

                }

            }
            array_multisort(array_column($slot_array, "diff_time"), SORT_ASC, $slot_array);

            $final_slot_array = $slot_array[0];

        }

        $store_details = Vendor::select(
            'id',
            'name',
            'location',
            'free_delivery_upto',
            DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo '),
            'avoide_delivery_fee',
            'amount_to_avoid_min_delivery',
            'min_delivery_upto_km',
            'delivery_fee_per_km',
            'min_delivery_fee',
            DB::raw("vendors.id,vendors.name,( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"),
            DB::raw('CASE WHEN is_grofirst_vendor = "true" THEN "true" ELSE "false" END AS is_grofirst_vendor')
        )
            ->where('id', $vendor->id)->get();

        foreach ($store_details as $key => $row) {
            $store_details[$key]['next_delivery'] = ($final_slot_array) ? $final_slot_array : null;
        }

        $cartdata = Cart::select(
            'carts.id as cart_id',
            'vendor_products.name as product_name',
            'carts.quantity as cart_quantity',
            'vendor_products.vendor_id',
            'vendor_products.id as product_id',
            'vendor_products.price',
            'vendor_products.selling_price',
            'vendor_products.variant_option',
            'vendor_products.type',
            'vendor_products.status',
            'vendor_products.combination_key',
            'vendor_products.stock', 'vendor_products.available_at', 'vendor_products.available_to',
            DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'),
            DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'),
            // DB::raw('(CASE WHEN vendor_products.max_qty <= carts.quantity THEN "instock" ELSE "nostock" END) as stock')
            // DB::raw('(CASE WHEN vendor_products.stock = \'in-stock\' THEN "instock" ELSE "nostock" END) as stock'),
            DB::raw('carts.quantity * vendor_products.selling_price as total_price'),
        )
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)
            ->get();

        foreach ($cartdata as $key => $row) {
            $products_varients = VendorProduct::select(
                'id',
                'variant_option',
                'name',
                'price',
                'selling_price',
                'combination_key',
                'stock',
                DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount')
            )
                ->where('combination_key', $row->combination_key)
                ->get();
            $cartdata[$key]['product_varients'] = $products_varients;
        }

        $cart_total_amount = Cart::select(DB::raw('SUM(vendor_products.selling_price * carts.quantity) as totalamount'), DB::raw('SUM((vendor_products.price-vendor_products.selling_price) * carts.quantity) as total_discount'), DB::raw('SUM(vendor_products.price * carts.quantity) as totalpriceamount'))
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)
            ->where('vendor_products.stock', 'in-stock')
            ->first();
        // $total_amount = $cart_data->totalamount;
        $billdetails['total_price_amount'] = $cart_total_amount->totalpriceamount;

        $billdetails['product_discount'] = $cart_total_amount->total_discount;

        $total_amount = $billdetails['total_amount'] = $cart_total_amount->totalamount;

        // $vendors_distence  = Vendor::select(DB::raw("vendors.id,vendors.name,( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"))
        // ->find('')
        // ->join('')



        if ($total_amount >= $vendor->avoide_delivery_fee) {
            $delivery_charge = 0.0;

        } elseif (($total_amount >= $vendor->amount_to_avoid_min_delivery) && ($vendor->distance <= $vendor->min_delivery_upto_km)) {
            $delivery_charge = 0.0;

        } elseif (($total_amount < $vendor->amount_to_avoid_min_delivery) && ($vendor->distance <= $vendor->min_delivery_upto_km)) {
            $delivery_charge = $vendor->min_delivery_fee;

        } else {
            $delivery_charge = (Round((($vendor->distance) - ($vendor->min_delivery_upto_km)), 0.7) * ($vendor->delivery_fee_per_km)) + $vendor->min_delivery_fee;

        }
        ////old
        // if ($cart_total_amount->total_amount >= $vendor->avoide_delivery_fee) {
        //     $delivery_charge = 0.0;

        // } elseif (($cart_total_amount->total_amount >= $vendor->amount_to_avoid_min_delivery) && ($vendor->distance <= $vendor->min_delivery_upto_km)) {
        //     $delivery_charge = 0.0;

        // } elseif ($vendor->distance <= $vendor->min_delivery_upto_km) {
        //     $delivery_charge = $vendor->min_delivery_fee;

        // } else {
        //     $delivery_charge = $vendor->min_delivery_fee + ((Round($vendor->distance, 0.7) - $vendor->min_delivery_upto_km) * ($vendor->delivery_fee_per_km));

        // }
        $billdetails['delivery_charge'] = $delivery_charge;
        $billdetails['packaging_charge'] = $vendor->packaging_fee;
        // ,DB::raw("vendors.id,vendors.name,( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"
        //             $vendor1 = Vendor::select('vendors.*'
        //             ,DB::raw("(CASE WHEN vendors.avoide_delivery_fee <= ($vendor->distence) THEN '0.0' ELSE $vendor->distence*vendors.delivery_fee_per_km END) as ProductPrice"))
        //             ->find($vendor->id);
        // dd($vendor1);
        // dd(Coupon::all());

        $coupons = Coupon::where('status', 'published')
            ->where(function ($query) use ($cart_total_amount) {
                $query->whereNull('min_cart_amount')
                    ->orWhere('min_cart_amount', '<=', $cart_total_amount->totalamount);
            })
            ->where(function ($query) use ($cart_total_amount) {
                $query->whereNull('max_cart_amount')
                    ->orWhere('max_cart_amount', '>=', $cart_total_amount->totalamount);
            })
            ->where(function ($query) use ($vendor) {
                $query->whereNull('vendor_id')
                ->orWhere('vendor_id', $vendor->id);
            })
            ->get();

        return response()->json([
            'data' => [
                'store' => $store_details,
                'cart' => $cartdata,
                // 'coupons' => $coupons,
                'selected_address' => $address,
                'other_addresses' => $other_addresses,
                'billdetails' => $billdetails,
            ],
            'status' => true,
        ]);

    }

    public function clear_cart(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'type' => 'required|in:product,single,,all',
            'product_id' => 'required_if:type,product,single',
        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }

        $img_path = '/uploads/';

        switch ($request->type) {
            case 'single':
                $cart_product = Cart::select('carts.*')
                    ->Join('vendor_products', 'vendor_products.id', 'carts.product_id')
                    ->where('carts.user_id', $authUser_id)->where('vendor_products.id', $request->product_id)->first();
                if (!$cart_product) {
                    return response()->json([
                        'toast' => __('Requested product not found in cart'),
                        'status' => false,
                    ]);
                }

                if ($cart_product->quantity <= 1) {
                    return response()->json([
                        'toast' => __('You are reached minimum quantity.'),
                        'status' => false,
                    ]);
                }

                $cartupdation = Cart::where('carts.user_id', $authUser_id)->where('carts.product_id', $request->product_id)
                    ->decrement('quantity', 1);
                if ($cartupdation) {
                    $message = 'cart updated successfully.';
                }
                break;
            case 'product':
                $cart_product = Cart::select('carts.*', 'vendor_products.name as product_name')
                    ->Join('vendor_products', 'vendor_products.id', 'carts.product_id', 'carts.quantity')
                    ->where('carts.user_id', $authUser_id)->where('vendor_products.id', $request->product_id)->first();
                if (!$cart_product) {
                    return response()->json([
                        'toast' => __('Requested product not found in cart'),
                        'status' => false,
                    ]);
                }
                $removeproduct = Cart::where('user_id', $authUser_id)->where('product_id', $request->product_id)->delete();
                if ($removeproduct) {
                    $message = 'The Product ' . $cart_product->product_name . ' removed from cart.';
                }
                break;
            case 'all':
                Cart::where('user_id', $authUser_id)->delete();
                $message = 'Your cart empty.';

                break;
        }
        $cartdata = Cart::select(
            'carts.id as cart_id',
            'carts.quantity as cart_quantity',
            'vendor_products.vendor_id',
            'vendor_products.weight',
            'vendor_products.id as product_id',
            'vendor_products.name as product_name',
            'vendor_products.price',
            'vendor_products.selling_price',
            DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'),
            DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'),
            DB::raw('carts.quantity * vendor_products.selling_price as total_price')
        )
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)
            ->get();
        return response()->json([
            'data' => [
                'cart' => $cartdata,
                'toast' => __($message),
            ],
            'status' => true,
        ]);

    }

    public function couponList(Request $request)
    {
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }
        $cart_total_amount = Cart::select('vendor_products.vendor_id', DB::raw('SUM(vendor_products.selling_price * carts.quantity) as totalamount'))
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)
            ->first();
        if ($cart_total_amount->totalamount == null) {
            return response()->json([
                'toast' => __('Your cart is empty'),
                'status' => false,
            ]);
        }
        $vendor_id = $cart_total_amount->vendor_id;
        $order_exist_coupon_ids = Order::join('coupons', 'orders.discount_code', 'coupons.code')
            ->where('orders.user_id', $authUser_id)->pluck('coupons.id')->toArray();

        $all_coupons = Coupon::where('status', 'published')->get();
        $user_order_count = Order::where('user_id', $authUser_id)->count();
        $user_next_order_count = $user_order_count + 1;
        $coupons = Coupon::where('coupons.status', 'published')

            ->where(function ($query) use ($cart_total_amount) {
                $query->whereNull('min_cart_amount')
                    ->orWhere('min_cart_amount', '<=', $cart_total_amount->totalamount);
            })

            ->where(function ($query) use ($cart_total_amount) {
                $query->whereNull('max_cart_amount')
                    ->orWhere('max_cart_amount', '>=', $cart_total_amount->totalamount);
            })
            ->where(function ($query) use ($user_next_order_count) {
                $query->Where('on_which_order', $user_next_order_count)->orWhere('on_which_order', '=', 0);
            })
            ->where(function ($query) use ($vendor_id) {
                $query->whereNull('vendor_id')
                ->orwhere('vendor_id', $vendor_id);
            });

        if (count($order_exist_coupon_ids) > 0) {
            $coupons->whereNotIn('id', $order_exist_coupon_ids);
        }
        $coupons = $coupons->pluck('coupons.id')->toArray();


        foreach ($all_coupons as $key => $row) {
            if (in_array($row->id, $coupons)) {
                $all_coupons[$key]['apply_status'] = 'active';
            } else {
                $all_coupons[$key]['apply_status'] = 'inactive';

            }
        }

        return response()->json([
            'data' => [
                'coupons' => $all_coupons,
            ],
            'status' => true,
        ]);

    }
    public function applyCoupon(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'coupon_id' => ['required'],
        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }
        $coupon = Coupon::find($request->coupon_id);

        if (!$coupon) {
            return response()->json([
                'toast' => __('Invalid Coupon'),
                'status' => false,
            ]);
        }

        $cart_total_amount = Cart::select('vendor_products.vendor_id', DB::raw('SUM(vendor_products.selling_price * carts.quantity) as totalamount'))
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)
            ->first();
        if ($cart_total_amount->totalamount == null) {
            return response()->json([
                'toast' => __('Your cart is empty'),
                'status' => false,
            ]);
        }
        $vendor_id = $cart_total_amount->vendor_id;

        $user_order_count = Order::where('user_id', $authUser_id)->count();
        $user_next_order_count = $user_order_count + 1;

        $coupon_eligibility = Coupon::where('status', 'published')
            ->where(function ($query) use ($cart_total_amount) {
                $query->whereNull('min_cart_amount')
                    ->orWhere('min_cart_amount', '<=', $cart_total_amount->totalamount);
            })
            ->where(function ($query) use ($cart_total_amount) {
                $query->whereNull('max_cart_amount')
                    ->orWhere('max_cart_amount', '>=', $cart_total_amount->totalamount);
            })
            ->where(function ($query) use ($user_next_order_count) {
                $query->Where('on_which_order', $user_next_order_count)->orWhere('on_which_order', '=', 0);
            })
            ->where(function ($query) use ($vendor_id) {
                $query->whereNull('vendor_id')
                ->orwhere('vendor_id', $vendor_id);
            })

            ->find($request->coupon_id);

        if (!$coupon_eligibility) {
            return response()->json([
                'toast' => __('Not eligible for discount'),
                'status' => false,
            ]);
        }

        $order_exist = Order::Where('discount_code', $coupon->code)->where('user_id', $authUser_id)->where('status', 'places')->exists();
        if ($order_exist) {
            return response()->json([
                'toast' => __(' Coupon already applied'),
                'status' => false,
            ]);
        }

        return response()->json([
            'data' => [
                'coupon' => $coupon_eligibility,
            ],
            'status' => true,
        ]);

    }

    public function placeorder(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'address_id' => ['required'],
            'vendor_id' => ['required'],
            'coupon_id' => ['nullable', 'integer'],
            'fcm_token' => ['nullable'],
            'server_key' => ['nullable'],

        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }
        $address = Address::where('user_id', $authUser_id)->find($request->address_id);
        if (!$address) {
            return response()->json([
                'toast' => __('Invalid Address'),
                'status' => false,
            ]);
        }
        // $fcm_token=$request->fcm_token;
        // $server_key=$request->server_key;

        $latitude = $address->latitude;
        $longitude = $address->longitude;
        $vendor = Vendor::select('vendors.*', DB::raw("vendors.id,vendors.name,( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"))
            ->where('status', 'active')->find($request->vendor_id);
        if (!$vendor) {
            return response()->json([
                'toast' => __('Invalid Vendor'),
                'status' => false,
            ]);
        }
        $today = Carbon::parse(date('Y-m-d H:i:s'))->dayName;
        $working_days = VendorWorkingHours::where('vendor_id', $vendor->id)->pluck('day')->toArray();
        $now = Carbon::now();

        if (($vendor->online == 1) && (in_array($today, array_map('ucfirst', $working_days)))) {
            $working_hours = VendorWorkingHours::where('vendor_id', $vendor->id)->where('day', $today)->first();
            $start = Carbon::createFromTimeString($working_hours->from);
            $end = Carbon::createFromTimeString($working_hours->to);

            if ($now->between($start, $end)) {
                $next_opening = '';
                $next_day = '';
                $vendor->working_status = "online";

            } else {
                $next_opening = '';
                $next_day = '';
                $vendor->working_status = "offline";

                if (count($working_days) > 0) {
                    $j = ($now > $start) ? 1 : 0;
                    $k = ($now > $start) ? 7 : 6;

                    for ($i = $j; $i <= $k; $i++) {
                        $newDateTime = Carbon::now()->addDay($i);
                        $day = $newDateTime->format('l');
                        if (in_array($day, array_map('ucfirst', $working_days))) {
                            $work = VendorWorkingHours::where('vendor_id', $vendor->id)->where('day', 'LIKE', "%{$day}%")
                                ->first();
                            $next_opening = $work->from;
                            $next_day = $work->day;

                            break;
                        }

                    }

                }
            }
        } else {
            $next_opening = '';
            $next_day = '';
            $vendor->working_status = "offline";

            if (count($working_days) > 0) {
                // dd($working_days_arr);
                for ($i = 1; $i <= 7; $i++) {

                    $newDateTime = Carbon::now()->addDay($i);
                    $day = $newDateTime->format('l');
                    if (in_array($day, array_map('ucfirst', $working_days))) {
                        $work = VendorWorkingHours::where('vendor_id', $vendor->id)->where('day', 'LIKE', "%{$day}%")
                            ->first();
                        $next_opening = $work->from;
                        $next_day = $work->day;

                        break;
                    }

                }

            }
        }

        if ($vendor->working_status == 'offline') {
            return response()->json([
                'toast' => __('Sorry, vendor is offline. Please try again later.'),
                'next_opening_time' => $next_opening,
                'next_opening_day' => $next_day,
                'status' => false,
            ]);
        }
        // if (($vendor->free_delivery_upto) <= ($vendor->distance)) {
        //     $delivery_charge = Round($vendor->distance, 0.7) * ($vendor->delivery_fee_per_km);
        // } else {
        //     $delivery_charge = 0.0;
        // }
        $delivery_distance = $vendor->distance;
        $packaging_charge = $vendor->packaging_fee;

        $img_path = '/uploads/';
        $discount_amount = 0.0;
        $discount_code = '';
        $commision_charge = 0.0;

        $cart = Cart::where('carts.user_id', $authUser_id)->first();
        if (!$cart) {
            return response()->json([
                'toast' => __('Your cart is empty'),
                'status' => false,
            ]);
        }
        $cart_data = Cart::select(
            DB::raw('SUM(vendor_products.weight * carts.quantity) as totalweight'),
            DB::raw('SUM(vendor_products.selling_price * carts.quantity) as totalamount'),
            DB::raw('SUM(vendor_products.price * carts.quantity) as totalpriceamount'),
            DB::raw('SUM((vendor_products.price-vendor_products.selling_price)*carts.quantity) as totalpricediscount')
        )
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)
            ->where('vendor_products.stock', 'in-stock')
            ->first();
        $delivery_weight = $cart_data->totalweight;
        $total_price_amount = $cart_data->totalpriceamount;
        $total_amount = $cart_data->totalamount;
        $total_price_discount = $cart_data->totalpricediscount;
        if ($total_amount < $vendor->min_order_amount) {
            return response()->json([
                'toast' => __('Please purchase for minimum order amount Rs ' . $vendor->min_order_amount),
                'status' => false,
            ]);
        }

        if ($total_amount >= $vendor->avoide_delivery_fee) {
            $delivery_charge = 0.0;

        } elseif (($total_amount >= $vendor->amount_to_avoid_min_delivery) && ($vendor->distance <= $vendor->min_delivery_upto_km)) {
            $delivery_charge = 0.0;

        } elseif (($total_amount < $vendor->amount_to_avoid_min_delivery) && ($vendor->distance <= $vendor->min_delivery_upto_km)) {
            $delivery_charge = $vendor->min_delivery_fee;

        } else {
            $delivery_charge = (Round((($vendor->distance) - ($vendor->min_delivery_upto_km)), 0.7) * ($vendor->delivery_fee_per_km)) + $vendor->min_delivery_fee;

        }
        if ($request->coupon_id != '') {
            $coupon_data = Coupon::find($request->coupon_id);
            if (!$coupon_data) {
                return response()->json([
                    'toast' => __('Invalid Coupon'),
                    'status' => false,
                ]);
            }

            $discount_amount = $coupon_data->discount_amount;
            $discount_code = $coupon_data->code;

            $order_exist_coupon = Order::join('coupons', 'orders.discount_code', 'coupons.code')
            ->where('orders.user_id', $authUser_id)->where('coupons.code', $discount_code)->first();

            if ($order_exist_coupon) {
                return response()->json([
                    'toast' => __('Sorry... Your coupon code is already applied'),
                    'status' => false,
                ]);
            }
        }
        $final_amount = ($total_amount - $discount_amount) + $delivery_charge + $packaging_charge;
        if ($vendor->commission_percentage > 1) {
            $commision_charge = (($total_amount * $vendor->commission_percentage) / 100);
        }
        $type = 'order';
        $OrderPlace = $this->set_order($vendor->id, $authUser_id, $address->id, $delivery_weight, $delivery_distance, $delivery_charge, $packaging_charge, $total_price_amount, $total_price_discount, $discount_code, $discount_amount, $total_amount, $final_amount, $commision_charge, $type, $orderId = '');
        if ($OrderPlace) {
            // dd($OrderPlace['store_details']['primary_contact_number']);
            $order_id = $OrderPlace['order']['order_id'];
            $mobile = $OrderPlace['store_details']['primary_contact_number'];
            $message = " You've received a new order. Order ID: ".$order_id.". Kindly confirm the order. Thank you! GROFIRST";
            $template_id = '1707168640016923310';
            sendSms($mobile, $message, $template_id, $order_id, $type);

            $this->sendWebNotification($OrderPlace, $vendor);

            Cart::where('carts.user_id', $authUser_id)->delete();
            return response()->json(
                $OrderPlace
            );

        }
    }

    public function set_order($vendorID, $userID, $address_id, $delivery_weight, $delivery_distance, $delivery_charge, $packaging_charge, $total_price_amount, $total_price_discount, $discount_code, $discount_amount, $total_amount, $final_amount, $commision_charge, $type, $orderID = null)
    {
        $products_data = array();
        $address = Address::find($address_id);
        $storecode_number = $this->Orderstorecode($vendorID);
        $vendor = Vendor::find($vendorID);
        // $vendorslotes = VendorDeliverySlot::where('vendor_id', $vendorID)->pluck('slot_ids')->first();
        $delivery_slots = DeliverySlot::orderBy('start', 'ASC')->get();
        $working_days = VendorWorkingHours::where('vendor_id', $vendorID)->pluck('day')->toArray();

        $time_str = time();
        $time = date('H:i:s', time());

        $post_time_str = time() + 60 * 60;
        $post_time = date('H:i:s', time() + 60 * 60);

        $today = Carbon::parse(date('Y-m-d H:i:s'))->dayName;
        $slot_array = array();
        $final_slot_array = array();
        $delivery_date = '';
        $delivery_time = '';
        if ((count($working_days) > 0) && (count($delivery_slots) > 0)) {
            foreach ($delivery_slots as $key => $slot) {

                $slot_time_arr = strtotime($slot->start);

                $diff = $slot_time_arr - $post_time_str;
                if ((($diff) > 0) && in_array($today, array_map('ucfirst', $working_days))) {

                    $slot_array[$key]['day'] = date('Y-m-d');
                    $slot_array[$key]['slot_id'] = $slot->id;
                    $slot_array[$key]['slot_name'] = $slot->slot_name;
                    // $slot_array[$key]['post_time'] = $post_time;
                    $slot_array[$key]['start_time'] = $slot->start;
                    $slot_array[$key]['end_time'] = $slot->end;
                    $slot_array[$key]['diff_time'] = $diff;
                }

            }
            if (!count($slot_array) > 0) {

                foreach ($delivery_slots as $key => $slot) {

                    $slot_time_arr = strtotime($slot->start);

                    $diff = $slot_time_arr - $post_time_str;
                    $day = $this->nextWorkingdayDate($vendorID);

                    $slot_array[$key]['day'] = $day;
                    $slot_array[$key]['slot_id'] = $slot->id;
                    $slot_array[$key]['slot_name'] = $slot->slot_name;
                    // $slot_array[$key]['post_time'] = $post_time;
                    $slot_array[$key]['start_time'] = $slot->start;
                    $slot_array[$key]['end_time'] = $slot->end;
                    $slot_array[$key]['diff_time'] = $diff;

                }

            }
            array_multisort(array_column($slot_array, "diff_time"), SORT_ASC, $slot_array);

            $final_slot_array = $slot_array[0];
            if (count($final_slot_array) > 0) {
                $delivery_date = $final_slot_array['day'];
                $delivery_time = $final_slot_array['start_time'] . ' - ' . $final_slot_array['end_time'];
            }

        }

        $order['vendor_id'] = $vendorID;
        $order['user_id'] = $userID;
        $order['store_code_number'] = $storecode_number;
        $order['delivery_geo_location'] = $address->geo_location;
        $order['delivery_latitude'] = $address->latitude;
        $order['delivery_longitude'] = $address->longitude;
        $order['delivery_address'] = $address->address;
        $order['delivery_location'] = $address->location;
        $order['delivery_phone'] = $address->phone;
        $order['delivery_type'] = $address->type;
        $order['delivery_weight'] = $delivery_weight;
        $order['delivery_distance'] = $delivery_distance;
        $order['delivery_charge'] = $delivery_charge;
        $order['packaging_charge'] = $packaging_charge;
        $order['total_price_amount'] = $total_price_amount;
        $order['total_price_discount'] = $total_price_discount;
        $order['discount_code'] = $discount_code;
        $order['discount_amount'] = $discount_amount;
        $order['total_amount'] = $total_amount;
        $order['final_amount'] = $final_amount;
        $order['commission_amount'] = $commision_charge;
        $order['note'] = '';
        $order['status'] = 'ordered';
        $order['delivery_date'] = $delivery_date;
        $order['delivery_time'] = $delivery_time;
        $order['payment_status'] = 'pending';
        // $order['created_at'] = date('Y-m-d H:i:s');
        // Carbon::parse(date('Y-m-d H:i:s'))
        // $order['created_at']=date('Y-m-d H:i:s',strtotime(Carbon::now()->tz('Asia/Kolkata')));

        $order_create = Order::create($order);

        $order_id = $order_create->id;

        $order['packaging_charge'] = "$packaging_charge";

        $order['created_at'] = date('Y-m-d H:i:s', strtotime($order_create->created_at));

        // DB::beginTransaction();
        // try {
        //     $order_id = Order::create($order)->id;

        // } catch (\Exception $e) {

        //     DB::rollback();

        //     return response()->json([
        //         'toast' => __('Something went wrong.'),
        //         'status' => false,
        //     ]);
        // }
        DB::commit();
        if (($type == 'reorder') && ($orderID != '')) {
            $product_details = OrderItem::select(
                'order_items.order_id as order_id',
                'order_items.quantity as cart_quantity',
                'vendor_products.*',
                'vendor_products.id as product_id',
                'vendor_products.name as product_name',
                'vendor_products.price',
                'vendor_products.selling_price',
                'vendor_products.type',
                'vendor_products.stock', 'vendor_products.available_at', 'vendor_products.available_to',
                DB::raw('100 - (ROUND((vendor_products.selling_price  * 100) / vendor_products.price, 1)) AS discount'),
                DB::raw('order_items.quantity * vendor_products.selling_price as total_price'),
                // DB::raw('(CASE WHEN vendor_products.stock = \'in-stock\' THEN "instock" ELSE "nostock" END) as stock')
            )
                ->join('vendor_products', 'vendor_products.id', 'order_items.vendor_product_id')
                ->where('order_items.order_id', $orderID)
                ->where('vendor_products.stock', 'in-stock')
                ->get();
        } else {
            $product_details = Cart::select(
                'carts.id as cart_id',
                'carts.quantity as cart_quantity',
                'vendor_products.*',
                'vendor_products.id as product_id',
                'vendor_products.name as product_name',
                'vendor_products.price',
                'vendor_products.selling_price',
                'vendor_products.stock', 'vendor_products.available_at', 'vendor_products.available_to',
                DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'),
                DB::raw('carts.quantity * vendor_products.selling_price as total_price'),
                // DB::raw('(CASE WHEN vendor_products.stock = \'in-stock\' THEN "instock" ELSE "nostock" END) as stock')
            )

                ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
                ->where('carts.user_id', $userID)
                ->where('vendor_products.stock', 'in-stock')
                ->get();
        }
        if ($order_id) {

            OrderStatus::create([
                'vendor_id' => $vendorID,
                'order_id' => $order_id,
                'status' => 'ordered',
            ]);
            UserNotification::create([
                'user_id' => VendorUser::find($vendorID)->user_id,
                'relation_id' => $order_id,
                'notification' => 'order_ordered',
                'relation_table' => 'orders',
                'status' => 'unread',
            ]);

            $order['order_id'] = $order_id;
            $order['address_id'] = $address->id;
            $order['product_discount'] = 0;
            // $order['created_at'] = Order::find($order_id)->created_at;
            $order['store_code'] = $vendor->store_identification_code . $storecode_number;
            //    dd($order);
            foreach ($product_details as $key => $product) {
                $orderitems['vendor_id'] = $vendorID;
                $orderitems['order_id'] = $order_id;
                $orderitems['product_name'] = $product->product_name;
                $orderitems['product_image'] = $product->image;
                $orderitems['vendor_product_id'] = $product->product_id;
                $orderitems['product_type'] = $product->type;
                $orderitems['menu_id'] = $product->menu_id;
                $orderitems['submenu_id'] = $product->submenu_id;
                $orderitems['brand_id'] = $product->brand_id;
                $orderitems['product_code'] = $product->product_code;
                $orderitems['weight'] = $product->weight;
                $orderitems['quantity'] = $product->cart_quantity;
                $orderitems['price'] = $product->price;
                $orderitems['selling_price'] = $product->selling_price;
                $orderitems['final_price'] = $product->selling_price * $product->cart_quantity;
                $orderitems['status'] = 'available';

                $order['product_discount'] = $order['product_discount'] + (($product->price - $product->selling_price) * $product->cart_quantity);
                // $vendor_user_id=VendorUser::find($vendorID)->user_id;
                try {
                    DB::statement('SET FOREIGN_KEY_CHECKS=0');
                    OrderItem::create($orderitems);


                } catch (\Exception $e) {

                    DB::rollback();

                    return response()->json([
                        'toast' => __('Something went wrong.'),
                        'status' => false,
                    ]);
                }

                $products_data[] = $orderitems;
                $products_data[$key]['stock'] = $product->stock;
            }

        }
        DB::commit();
        $coupon_details = Coupon::where('code', $discount_code)->first();

        $img_path = '/uploads/';
        $store_details = Vendor::select('id', 'vendors.name', 'vendors.scheduled_delivery', 'vendors.location', 'online', DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo'), 'primary_contact_number', DB::raw('CASE WHEN is_grofirst_vendor = "true" THEN "true" ELSE "false" END AS is_grofirst_vendor'))->find($vendorID);
        $working_days = VendorWorkingHours::where('vendor_id', $store_details->id)->pluck('day')->toArray();
        $today = Carbon::parse(date('Y-m-d H:i:s'))->dayName;
        if (($store_details->online == 1) && (in_array($today, array_map('ucfirst', $working_days)))) {
            $working_hours = VendorWorkingHours::where('vendor_id', $store_details->id)->where('day', $today)->first();
            $now = Carbon::now();
            $start = Carbon::createFromTimeString($working_hours->from);
            $end = Carbon::createFromTimeString($working_hours->to);

            if ($now->between($start, $end)) {
                $store_details->working_status = "online";
            } else {
                $store_details->working_status = "offline";
            }
        } else {
            $store_details->working_status = "offline";
        }
        $status = array("ordered", "placed", "prepared", "picked", "delivered", "cancelled", "expired");
        // DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') AS created_at_formatted")
        $order_status_arr = array();
        foreach ($status as $row) {
            $order_status = OrderStatus::where('order_id', $order_id)->where('status', $row)->first();
            if ($order_status) {
                array_push($order_status_arr, ['status' => $row, 'time' => date('Y-m-d H:i:s', strtotime($order_status->created_at)), 'public_note' => $order_status->public_note]);
            } else {
                array_push($order_status_arr, ['status' => $row, 'time' => '', 'public_note' => '']);
            }

        }
        $order_timestamp = Carbon::parse($order['created_at'])->timestamp;
        $now = Carbon::now()->timestamp;

        $order_time = Carbon::createFromTimeString($order['created_at']);
        // $post_time = $order_time->addMinutes(5)->timestamp;
        $order['total_confirmation_time'] = '5 - 00';

        $post_time = Carbon::parse($order['created_at'])->timestamp + 5 * 60; // Add 5 minutes in seconds

        if ($now < $post_time) {
            $remaining_time = $post_time - $now; // Calculate remaining time in seconds

            $remaining_minutes = floor($remaining_time / 60); // Calculate remaining minutes
            $remaining_seconds = sprintf('%02d', ($remaining_time % 60)); // Calculate remaining seconds

            $order['confirmation_time'] = ($remaining_minutes . ' - ' . $remaining_seconds);

            // $diff = $post_time - $now;
            // $diff_time = number_format(($post_time - strtotime(date("Y-m-d H:i:s"))) / 60, 2);
            //$order->confirmation_time = str_replace('.',':',$diff_time);;
            // $order['confirmation_time'] = str_replace('.', ' - ', $diff_time);

        } else {
            $order['confirmation_time'] = '';
            if ($order['status'] == 'ordered') {
                $order['status'] = 'expired';
                Order::where('id', $order_id)->update([
                    'status' => 'expired',
                ]);
                // OrderStatus::where('order_id', $order_id)->update([
                //     'status' => 'expired',
                // ]);
                OrderStatus::create([
                    'vendor_id' => $vendorID,
                    'order_id' => $order_id,
                    'status' => 'expired',
                ]);
                // OrderItem::where('order_id', $order_id)->update([
                //     'status' => 'expired',
                // ]);
                UserNotification::create([
                    'user_id' => VendorUser::find($vendorID)->user_id,
                    'relation_id' => $order_id,
                    'notification' => 'order_expired',
                    'relation_table' => 'orders',
                    'status' => 'unread',
                ]);
            }

        }


        return array('status' => true, 'message' => 'Order placed successfully.',
            'store_details' => $store_details,
            'order' => $order, 'order_items' => $products_data, 'order_status' => $order_status_arr,'coupon_details' => $coupon_details,
        );

    }

    public function confirmOrder(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'order_id' => ['required'],

        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }
        $order = Order::where('id', $request->order_id)->where('user_id', $authUser_id)->first();
        if (!$order) {
            return response()->json([
                'toast' => __('Invalid Order'),
                'status' => false,
            ]);
        }

        //delivery_slot
        $vendorslotes = VendorDeliverySlot::where('vendor_id', $order->vendor_id)->pluck('slot_ids')->first();
        $delivery_slots = DeliverySlot::whereIn('id', explode(',', $vendorslotes))->orderBy('start', 'ASC')->get();
        $working_days = VendorWorkingHours::where('vendor_id', $order->vendor_id)->pluck('day')->toArray();
        $time_str = time();
        $time = date('H:i:s', time());

        $post_time_str = time() + 60 * 60;
        $post_time = date('H:i:s', time() + 60 * 60);

        $today = Carbon::parse(date('Y-m-d H:i:s'))->dayName;

        $slot_array = array();

        $final_slot_array = array();

        if ((count($working_days) > 0) && (count($delivery_slots) > 0)) {

            foreach ($delivery_slots as $key => $slot) {

                $slot_time_arr = strtotime($slot->start);

                $diff = $slot_time_arr - $post_time_str;

                if ((($diff) > 0) && in_array($today, array_map('ucfirst', $working_days))) {
                    $slot_array[$key]['day'] = $today;
                    $slot_array[$key]['slot_id'] = $slot->id;
                    $slot_array[$key]['slot_name'] = $slot->slot_name;
                    // $slot_array[$key]['post_time'] = $post_time;
                    $slot_array[$key]['start_time'] = $slot->start;
                    $slot_array[$key]['end_time'] = $slot->end;
                    $slot_array[$key]['diff_time'] = $diff;
                }

            }
            if (!count($slot_array) > 0) {

                foreach ($delivery_slots as $key => $slot) {

                    $slot_time_arr = strtotime($slot->start);

                    $diff = $slot_time_arr - $post_time_str;
                    $day = $this->nextWorkingday($order->vendor_id);

                    $slot_array[$key]['day'] = $day;
                    $slot_array[$key]['slot_id'] = $slot->id;
                    $slot_array[$key]['slot_name'] = $slot->slot_name;
                    // $slot_array[$key]['post_time'] = $post_time;
                    $slot_array[$key]['start_time'] = $slot->start;
                    $slot_array[$key]['end_time'] = $slot->end;
                    $slot_array[$key]['diff_time'] = $diff;

                }

            }
            array_multisort(array_column($slot_array, "diff_time"), SORT_ASC, $slot_array);

            $final_slot_array = $slot_array[0];
        }

        //delivery slot end

        DB::beginTransaction();
        try {

            $order->update([
                'status' => 'placed',
            ]);
            // OrderItem::where('order_id', $order->id)->update([
            //     'status' => 'placed',
            // ]);
            OrderStatus::create([
                'vendor_id' => $order->vendor_id,
                'order_id' => $order->id,
                'status' => 'placed',
            ]);     
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }
        DB::commit();
        $order_items = OrderItem::where('order_id', $request->order_id)->get();
        foreach ($order_items as $key => $item) {
            $order->product_discount = ($order->product_discount) + (($item->price - $item->selling_price) * $item->quantity);
        }
        $img_path = '/uploads/';
        $store_details = Vendor::select('vendors.name', 'vendors.location', DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo'))->find($order->vendor_id);
        $working_days = VendorWorkingHours::where('vendor_id', $store_details->id)->pluck('day')->toArray();
        $today = Carbon::parse(date('Y-m-d H:i:s'))->dayName;
        if (($store_details->online == 1) && (in_array($today, array_map('ucfirst', $working_days)))) {
            $working_hours = VendorWorkingHours::where('vendor_id', $store_details->id)->where('day', $today)->first();
            $now = Carbon::now();
            $start = Carbon::createFromTimeString($working_hours->from);
            $end = Carbon::createFromTimeString($working_hours->to);

            if ($now->between($start, $end)) {
                $store_details->working_status = "online";
            } else {
                $store_details->working_status = "offline";
            }
        } else {
            $store_details->working_status = "offline";
        }

        return response()->json([
            'toast' => __('Order confirmed successfully'),
            'store_details' => $store_details,
            'next_delivery_slot' => $final_slot_array,
            'status' => true,
            'order' => $order,
            'order_items' => $order_items,
        ]);

    }

    public function cancelOrder(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'order_id' => ['required'],

        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }
        // $order = Order::where('id', $request->order_id)->where('user_id', $authUser_id)->first();
        $order = Order::select('orders.*', DB::raw('CONCAT(vendors.store_identification_code,orders.store_code_number) as store_code'))
            ->leftjoin('vendors', 'vendors.id', 'orders.vendor_id')
            ->where('orders.id', $request->order_id)->where('orders.user_id', $authUser_id)->first();
        if (!$order) {
            return response()->json([
                'toast' => __('Invalid Order'),
                'status' => false,
            ]);

        }
        $img_path = '/uploads/';

        DB::beginTransaction();
        try {

            $order->update([
                'status' => 'cancelled',
            ]);

            // OrderItem::where('order_id', $order->id)->update([
            //     'status' => 'cancelled',
            // ]);
            OrderStatus::create([
                'vendor_id' => $order->vendor_id,
                'order_id' => $order->id,
                'status' => 'cancelled',
                'public_note' => 'cancelled by ' . authUser('api')->name,
            ]);

            UserNotification::create([
                'user_id' => VendorUser::find($order->vendor_id)->user_id,
                'relation_id' => $order->id,
                'notification' => 'order_cancelled_by_customer',
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
        $order_items = OrderItem::where('order_id', $order->id)->get();

        foreach ($order_items as $key => $item) {
            $order->product_discount = ($order->product_discount) + (($item->price - $item->selling_price) * $item->quantity);
        }

        $store_details = Vendor::select('vendors.id', 'vendors.name', 'vendors.location', DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo', DB::raw('CASE WHEN is_grofirst_vendor = "true" THEN "true" ELSE "false" END AS is_grofirst_vendor')))->find($order->vendor_id);

        $status = array("ordered", "placed", "prepared", "picked", "delivered", "cancelled", "expired");

        $order_status_arr = array();
        foreach ($status as $row) {
            $order_status = OrderStatus::where('order_id', $order->id)->where('status', $row)->first();
            if ($order_status) {
                array_push($order_status_arr, ['status' => $row, 'time' => date('Y-m-d H:i:s', strtotime($order_status->created_at)), 'public_note' => $order_status->public_note]);
            } else {
                array_push($order_status_arr, ['status' => $row, 'time' => '', 'public_note' => '']);
            }

        }

        return response()->json([
            'toast' => __('Order cancelled successfully'),
            'store_details' => $store_details,
            'status' => true,
            'order' => $order,
            'order_items' => $order_items,
            'order_status' => $order_status_arr,
        ]);

    }

    public function reOrder_old(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'address_id' => ['required'],
            'order_id' => ['required'],
            'coupon_id' => ['nullable', 'integer'],

        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }

        $order = Order::where('id', $request->order_id)->where('user_id', $authUser_id)->first();

        if (!$order) {
            return response()->json([
                'toast' => __('Invalid Order'),
                'status' => false,
            ]);
        }
        // $address = Address::where('user_id', $authUser_id)->find($request->address_id);
        $address = Address::where('id', $request->address_id)->where('user_id', $authUser_id)->first();

        if (!$address) {
            return response()->json([
                'toast' => __('Invalid Address'),
                'status' => false,
            ]);
        }
        $latitude = $address->latitude;
        $longitude = $address->longitude;
        $vendor = Vendor::select('vendors.*', DB::raw("vendors.id,vendors.name,( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"))
            ->where('status', 'active')->find($order->vendor_id);
        if (!$vendor) {
            return response()->json([
                'toast' => __('Invalid Vendor'),
                'status' => false,
            ]);
        }

        // if (($vendor->free_delivery_upto) <= ($vendor->distance)) {
        //     $delivery_charge = Round($vendor->distance, 0.7) * ($vendor->delivery_fee_per_km);
        // } else {
        //     $delivery_charge = 0.0;
        // }
        $delivery_distance = $vendor->distance;
        $packaging_charge = $vendor->packaging_fee;

        $img_path = '/uploads/';
        $discount_amount = 0.0;
        $discount_code = '';
        $commision_charge = 0.0;

        $orderitems = OrderItem::where('order_items.order_id', $order->id)->first();
        if (!$orderitems) {
            return response()->json([
                'toast' => __('Empty product'),
                'status' => false,
            ]);
        }
        $order_data = OrderItem::select(
            DB::raw('SUM(vendor_products.weight * order_items.quantity) as totalweight'),
            DB::raw('SUM(vendor_products.selling_price * order_items.quantity) as totalamount')
        )
            ->join('vendor_products', 'vendor_products.id', 'order_items.vendor_product_id')
            ->where('order_items.order_id', $order->id)
            ->first();
        $delivery_weight = $order_data->totalweight;
        $total_amount = $order_data->totalamount;

        if ($total_amount < $vendor->min_order_amount) {
            return response()->json([
                'toast' => __('Please purchase for minimum order amount'),
                'status' => false,
            ]);
        }

        if ($total_amount >= $vendor->avoide_delivery_fee) {
            $delivery_charge = 0.0;

        } elseif (($total_amount >= $vendor->amount_to_avoid_min_delivery) && ($vendor->distance <= $vendor->min_delivery_upto_km)) {
            $delivery_charge = 0.0;

        } elseif ($vendor->distance <= $vendor->min_delivery_upto_km) {
            $delivery_charge = $vendor->min_delivery_fee;

        } else {
            $delivery_charge = Round($vendor->distance, 0.7) * ($vendor->delivery_fee_per_km);

        }

        if ($request->coupon_id != '') {
            $coupon_data = Coupon::find($request->coupon_id);
            if (!$coupon_data) {
                return response()->json([
                    'toast' => __('Invalid Coupon'),
                    'status' => false,
                ]);
            }

            $discount_amount = $coupon_data->discount_amount;
            $discount_code = $coupon_data->code;
        }
        $final_amount = ($total_amount - $discount_amount) + $delivery_charge + $packaging_charge;
        if ($vendor->commission_percentage > 1) {
            $commision_charge = (($total_amount * $vendor->commission_percentage) / 100);
        }
        $type = 'reorder';
        $OrderPlace = $this->set_order($vendor->id, $authUser_id, $address->id, $delivery_weight, $delivery_distance, $delivery_charge, $packaging_charge, $discount_code, $discount_amount, $total_amount, $final_amount, $commision_charge, $type, $order->id);
        if ($OrderPlace) {
            return response()->json(
                $OrderPlace
            );

        }
    }

    public function reOrder(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'order_id' => ['required'],

        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }

        $order = Order::where('id', $request->order_id)->where('user_id', $authUser_id)->first();

        if (!$order) {
            return response()->json([
                'toast' => __('Invalid Order'),
                'status' => false,
            ]);
        }

        {

            $img_path = '/uploads/';
            $product_details = OrderItem::select(
                'order_items.order_id as order_id',
                'order_items.quantity as cart_quantity',
                'vendor_products.*',
                'vendor_products.id as product_id',
                'vendor_products.name as product_name',
                'vendor_products.price',
                'vendor_products.selling_price',
                'vendor_products.type',
                'vendor_products.stock', 'vendor_products.available_at', 'vendor_products.available_to',
                DB::raw('100 - (ROUND((vendor_products.selling_price  * 100) / vendor_products.price, 1)) AS discount'),
                DB::raw('order_items.quantity * vendor_products.selling_price as total_price'),
                // DB::raw('(CASE WHEN vendor_products.stock = \'in-stock\' THEN "instock" ELSE "nostock" END) as stock')
            )
                ->join('vendor_products', 'vendor_products.id', 'order_items.vendor_product_id')
                ->where('order_items.order_id', $order->id)
                ->get();
            foreach ($product_details as $product_row) {
                $Product = VendorProduct::find($product_row->product_id);
                if (!$Product) {
                    return response()->json([
                        'toast' => __('Invalid Product'),
                        'status' => false,
                    ]);
                }

                $cartvendor_id = Cart::join('vendor_products', 'carts.product_id', 'vendor_products.id')
                    ->where('carts.user_id', $authUser_id)->pluck('vendor_products.vendor_id')->first();

                if ($cartvendor_id) {
                    $vendor_data = Vendor::find($cartvendor_id);
                    if ($Product->vendor_id != $cartvendor_id) {
                        return response()->json([
                            'toast' => __('Another store products exist in the cart.'),
                            'status' => false,
                        ]);
                    }

                    $cart_weight = Cart::select(DB::raw('SUM(vendor_products.weight * carts.quantity) as totalweight'))
                        ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
                        ->where('carts.user_id', $authUser_id)
                        ->first();
                    if ($cart_weight) {
                        $total_weight = $cart_weight->totalweight + $Product->weight;
                        if ($total_weight > $vendor_data->maximum_weight_to_deliver) {
                            return response()->json([
                                'toast' => __('Store weight limit exceeded'),
                                'status' => false,
                            ]);
                        }
                    }
                }

                $exist_cart_product = Cart::select(DB::raw('SUM(vendor_products.weight * carts.quantity) as totalweight'), 'carts.quantity')
                    ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
                    ->Where('carts.product_id', $product_row->product_id)
                    ->where('carts.user_id', $authUser_id)
                    ->first();
                if ($exist_cart_product) {
                    $total_quantity = $exist_cart_product->quantity + $request->quantity;
                    // $total_product_weight = $exist_cart_product->totalweight + $Product->weight;

                    // if ($total_product_weight > $Product->max_qty && $Product->max_qty != 0.00) {
                    //     return response()->json([
                    //         'toast' => __('Maximum Product weight limit exceeded'),
                    //         'status' => false,
                    //     ]);

                    // }

                    if (($Product->max_qty != '') && ($total_quantity > $Product->max_qty)) {
                        return response()->json([
                            'toast' => __('Maximum Product Purchase limit exceeded'),
                            'status' => false,
                        ]);

                    }
                }
                $carts = Cart::Where('product_id', $product_row->product_id)->where('user_id', $authUser_id)->exists();
                $input['product_id'] = $product_row->product_id;

                $input['quantity'] = $product_row->cart_quantity;
                $input['user_id'] = $authUser_id;
                DB::beginTransaction();

                if (!$carts) {

                    try {
                        $cart_action = Cart::create($input);
                        // dd($product_row->product_id);

                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json([
                            'toast' => __('Something went wrong.'),
                            'status' => false,
                        ]);
                    }
                } else {

                    try {
                        $cart_action = Cart::where('user_id', $authUser_id)
                            ->where('product_id', $product_row->product_id)
                            ->increment('quantity', $product_row->cart_quantity);
                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json([
                            'toast' => __('Something went wrong.'),
                            'status' => false,
                        ]);
                    }
                }
                DB::commit();
            }
            $cartdata = Cart::select(
                'carts.id as cart_id',
                'carts.quantity as cart_quantity',
                'vendor_products.vendor_id',
                'vendor_products.weight',
                'vendor_products.id as product_id',
                'vendor_products.name as product_name',
                'vendor_products.price',
                'vendor_products.selling_price', 'vendor_products.available_at', 'vendor_products.available_to',
                'vendor_products.stock',
                DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'),
                DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'),
                DB::raw('carts.quantity * vendor_products.selling_price as total_price')
            )
                ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
                ->where('carts.user_id', $authUser_id)
                ->get();
            return response()->json([
                'data' => [
                    'toast' => __('Products added to cart successfully'),
                    'cart' => $cartdata,
                ],
                'status' => true,
            ]);

        }

    }

    public function checkOrderExpiry(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'order_id' => ['required'],

        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }
        // $order = Order::where('id', $request->order_id)->where('user_id', $authUser_id)->first();
        $order = Order::select('orders.*', DB::raw('CONCAT(vendors.store_identification_code,orders.store_code_number) as store_code'))
            ->leftjoin('vendors', 'vendors.id', 'orders.vendor_id')
            ->where('orders.id', $request->order_id)->where('orders.user_id', $authUser_id)->first();
        if (!$order) {
            return response()->json([
                'toast' => __('Invalid Order'),
                'status' => false,
            ]);

        }
        $img_path = '/uploads/';
        if (strtotime($order->created_at) < strtotime("-5 minutes") && ($order->status == "ordered")) {

            DB::beginTransaction();
            try {

                $order->update([
                    'status' => 'expired',
                ]);

                // OrderItem::where('order_id', $order->id)->update([
                //     'status' => 'expired',
                // ]);
                OrderStatus::create([
                    'vendor_id' => $order->vendor_id,
                    'order_id' => $order->id,
                    'status' => 'expired',
                ]);
                UserNotification::create([
                    'user_id' => VendorUser::find($vendorID)->user_id,
                    'relation_id' => $order_id,
                    'notification' => 'order_expired',
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
            $order->confirmation_time = '';

        } else {
            //    if(strtotime($order->created_at) > strtotime("-5 minutes")){
            $order_timestamp = Carbon::parse($order->created_at)->timestamp;
            $now = Carbon::now()->timestamp;

            $order_time = Carbon::createFromTimeString($order->created_at);
            $post_time = $order_time->addMinutes(5)->timestamp;
            if ($now < $post_time) {

                $remaining_time = $post_time - $now; // Calculate remaining time in seconds

                $remaining_minutes = floor($remaining_time / 60); // Calculate remaining minutes
                $remaining_seconds = sprintf('%02d', ($remaining_time % 60)); // Calculate remaining seconds
                $order->confirmation_time = ($remaining_minutes . ' - ' . $remaining_seconds);
                // $diff = $post_time - $now;
                // $order->confirmation_time = date('i - s', $diff);
                // $diff_time = number_format(($post_time - strtotime(date("Y-m-d H:i:s"))) / 60, 2);
                // $order->confirmation_time = str_replace('.', ' - ', $diff_time);
            } else {
                $order->confirmation_time = '';

            }

        }
        $order_items = OrderItem::where('order_id', $order->id)->get();
        foreach ($order_items as $key => $item) {
            $order->product_discount = ($order->product_discount) + (($item->price - $item->selling_price) * $item->quantity);
        }

        $store_details = Vendor::select('vendors.name', 'vendors.location', DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo', DB::raw('CASE WHEN is_grofirst_vendor = "true" THEN "true" ELSE "false" END AS is_grofirst_vendor')))->find($order->vendor_id);
        $working_days = VendorWorkingHours::where('vendor_id', $store_details->id)->pluck('day')->toArray();
        $today = Carbon::parse(date('Y-m-d H:i:s'))->dayName;
        if (($store_details->online == 1) && (in_array($today, array_map('ucfirst', $working_days)))) {
            $working_hours = VendorWorkingHours::where('vendor_id', $store_details->id)->where('day', $today)->first();
            $now = Carbon::now();
            $start = Carbon::createFromTimeString($working_hours->from);
            $end = Carbon::createFromTimeString($working_hours->to);

            if ($now->between($start, $end)) {
                $store_details->working_status = "online";
            } else {
                $store_details->working_status = "offline";
            }
        } else {
            $store_details->working_status = "offline";
        }

        $status = array("ordered", "placed", "prepared", "picked", "delivered", "cancelled", "expired");

        $order_status_arr = array();
        foreach ($status as $row) {
            $order_status = OrderStatus::where('order_id', $order->id)->where('status', $row)->first();
            if ($order_status) {
                array_push($order_status_arr, ['status' => $row, 'time' => date('Y-m-d H:i:s', strtotime($order_status->created_at)), 'public_note' => $order_status->public_note]);
            } else {
                array_push($order_status_arr, ['status' => $row, 'time' => '', 'public_note' => '']);
            }

        }

        return response()->json([
            // 'toast' => __('Order cancelled successfully'),
            'store_details' => $store_details,
            'status' => true,
            'order' => $order,
            'order_items' => $order_items,
            'order_status' => $order_status_arr,
        ]);

    }

    public function orderHistory(Request $request)
    {

        $authUser_id = authUser('api')->id;
        $now = Carbon::now()->timestamp;

        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }
        $img_path = '/uploads/';

        $orders = Order::select('vendors.id as vendor_id', 'name', 'location', 'orders.created_at', DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo'), 'orders.id as order_id', 'orders.status', 'orders.total_price_amount', 'orders.total_price_discount', 'orders.final_amount', 'orders.is_confirm', 'orders.bill_amount', 'orders.is_bill_confirm', 'orders.final_delivery_charge', 'orders.final_bill_amount', DB::raw('DATE_FORMAT(orders.created_at,"%Y-%m-%d %H:%i:00") as order_date'))
        // ->join('order_status', 'order_status.order_id', 'orders.id')
            ->join('vendors', 'vendors.id', 'orders.vendor_id')
            ->where('orders.user_id', $authUser_id)->latest()->paginate(20);

        if (count($orders) > 0) {
            foreach ($orders as $key => $order) {
                $order_timestamp = Carbon::parse($order->created_at)->timestamp;

                $order_time = Carbon::createFromTimeString($order->created_at);
                $post_time = $order_time->addMinutes(5)->timestamp;
                // $diff = $post_time - $now;

                $order_timestamp = strtotime($order->created_at);

                $order_time = strtotime(date('Y-m-d H:i:s'));
                $diff_time = number_format(($post_time - strtotime(date("Y-m-d H:i:s"))) / 60, 2);
                //  $post_time  ='';
                // // $post_time = $order_time->addMinutes(5)->timestamp;
                $diff = strtotime(date("Y-m-d H:i:s")) - strtotime($order->created_at); // echo date('i', $diff);

                if (($diff_time > 0) && ($order->status == 'ordered')) {
                    $remaining_time = $post_time - $now; // Calculate remaining time in seconds

                    $remaining_minutes = floor($remaining_time / 60); // Calculate remaining minutes
                    $remaining_seconds = sprintf('%02d', ($remaining_time % 60)); // Calculate remaining seconds
                    $orders[$key]['confirmation_time'] = ($remaining_minutes . ' - ' . $remaining_seconds);

                    $diff = $post_time - $now;
                    // $orders[$key]['confirmation_time'] = str_replace('.', ' - ', $diff_time);

                } else {
                    $orders[$key]['confirmation_time'] = '';
                    if ($order->status == 'ordered') {

                        Order::where('id', $order->order_id)->update([
                            'status' => 'expired',
                        ]);
                        // OrderStatus::where('order_id', $order->id)->update([
                        //     'status' => 'expired',
                        // ]);
                        OrderStatus::create([
                            'vendor_id' => $order->vendor_id,
                            'order_id' => $order->order_id,
                            'status' => 'expired',
                        ]);

                        // OrderItem::where('order_id', $order->order_id)->update([
                        //     'status' => 'expired',
                        // ]);
                        $orders[$key]['status'] = 'expired';

                        UserNotification::create([
                            'user_id' => VendorUser::find($order->vendor_id)->user_id,
                            'relation_id' => $order->order_id,
                            'notification' => 'order_expired',
                            'relation_table' => 'orders',
                            'status' => 'unread',
                        ]);
                    }

                }
                $orders[$key]['order_items'] = OrderItem::select('id', 'product_name', 'quantity')->where('order_id', $order->order_id)->get();
                $orders[$key]['public_note'] = OrderStatus::select('public_note')->where('order_id', $order->order_id)->latest()->first();
            }

            return response()->json([
                'orders' => $orders,
                'status' => true,

            ]);
        } else {
            return response()->json([
                'orders' => null,
                'status' => true,

            ]);
        }
    }

    public function searchKeyword(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'search' => ['nullable'],
            'category_id' => ['nullable'],
            'latitude' => ['required', 'max:100'],
            'longitude' => ['required', 'max:100'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser = authUser('api');
        $authUser_id = (authUser('api')) ? authUser('api')->id : 0;

        if ($request->search != '' && strlen($request->search)>3) {
            $input['keyword'] = $request->search;

            DB::beginTransaction();
            try {
                CustomerSearch::create($input);

            } catch (\Exception $e) {

                DB::rollback();

                return response()->json([
                    'toast' => __('Something went wrong.'),
                    'status' => false,
                ]);
            }
            DB::commit();

        }

        $longitude = $request->longitude ?? '';
        $latitude = $request->latitude ?? '';
        $img_path = '/uploads/';
        $search = $request->search ?? null;
        $category_id = $request->category_id ?? null;

        $popular_searches = CustomerSearch::select('keyword')->groupBy('keyword')->orderByRaw('COUNT(*) DESC')->take(10)->get();

        $categories = VendorBusinessCategory::select(DB::raw('CONCAT("' . $img_path . '", business_categories.image) as image '), DB::raw("business_categories.id,title, short_description, title_color,short_description_color,bg_color"))
            ->join('business_categories', 'business_categories.id', 'vendor_business_categories.business_category_id')
            ->join('vendors', 'vendors.id', 'vendor_business_categories.vendor_id')
            ->distinct('vendor_business_categories.business_category_id')
            ->where('vendors.status', 'active')
            ->get();

        // $stores = Vendor::select(DB::raw('vendors.id,vendors.name,vendors.location,vendors.star_rating,vendors.online,free_delivery_upto,delivery_fee_per_km,CONCAT("' . $img_path . '", vendors.logo) as logo '), DB::raw('CONCAT("' . $img_path . '", vendors.image) as image '), DB::raw("( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"), 'allow_orders_within','vendor_products.vendor_id as as_id')
        //     ->join('vendor_business_categories', 'vendor_business_categories.vendor_id', 'vendors.id')
        //     ->join('business_categories', 'business_categories.id', 'vendor_business_categories.business_category_id')
        //     ->leftjoin('sliders', 'sliders.vendor_id', 'vendors.id')
        //     ->leftjoin('vendor_working_hours', 'vendor_working_hours.vendor_id', 'vendors.id');
        // if ($search) {
        //     $stores->join('vendor_products',function($join) use($search){
        //         $join->on('vendor_products.vendor_id','vendors.id');
        //         $join->Where('vendor_products.name', 'like', '%' . $search . '%');
        //         $join->orWhere('vendor_products.short_description', 'like', '%' . $search . '%');
        //         // $join->orWhere('vendors.name', 'like', '%' . $search . '%');
        //         $join->orWhere('vendor_products.product_code', 'like', '%' . $search . '%');
        //     });

        // }
        // if ($category_id) {
        //     $products->where(function ($query) use ($search) {

        //         $query->orWhere('business_categories.id', $category_id);
        //     });
        // }
        // $stores = $stores->having('distance', '<=', DB::raw('vendors.allow_orders_within'))
        //     ->distinct('vendors.id')
        //     ->where('vendors.status', 'active')
        //     ->orderBy('distance', 'ASC')
        //     ->paginate(10);
        $product_ids = VendorProduct::groupBy('vendor_products.combination_key')->distinct()->pluck('id');

        $stores = VendorProduct::select(DB::raw('vendors.id,vendors.name,vendors.location,vendors.star_rating,vendors.online,vendors.scheduled_delivery,free_delivery_upto,delivery_fee_per_km,CONCAT("' . $img_path . '", vendors.logo) as logo ,CONCAT("' . $img_path . '", vendors.main_logo) as main_logo'), DB::raw('CONCAT("' . $img_path . '", vendors.image) as image '), DB::raw("( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"), 'allow_orders_within', DB::raw('CASE WHEN is_grofirst_vendor = "true" THEN "true" ELSE "false" END AS is_grofirst_vendor'))
            ->join('vendors', 'vendors.id', 'vendor_products.vendor_id')
            ->join('vendor_business_categories', 'vendor_business_categories.vendor_id', 'vendors.id')
            ->join('business_categories', 'business_categories.id', 'vendor_business_categories.business_category_id')
            ->join('vendor_menu', 'vendor_menu.id', 'vendor_products.menu_id')
            ->leftjoin('vendor_submenu', 'vendor_submenu.id', 'vendor_products.submenu_id')
            ->leftjoin('carts', function ($join) use ($authUser_id) {
                $join->on('carts.product_id', 'vendor_products.id');
                $join->where('carts.user_id', '=', $authUser_id);

            });
        // ->join('vendor_products', 'business_categories.id', 'vendor_products.business_category_id');

        if ($search) {
            $stores->where(function ($query) use ($search) {
                $query->orWhere('vendor_products.name', 'like', '%' . $search . '%');
                $query->orWhere('vendor_products.short_description', 'like', '%' . $search . '%');
                // $query->orWhere('vendors.name', 'like', '%' . $search . '%');
                $query->orWhere('vendor_products.product_code', 'like', '%' . $search . '%');
                $query->orWhere('vendor_products.keywords', 'like', '%' . $search . '%');

            });
        }
        if ($category_id) {
            $stores->where(function ($query) use ($search) {

                $query->orWhere('business_categories.id', $category_id);
            });
        }

        $stores = $stores->having('distance', '<=', DB::raw('vendors.allow_orders_within'))
            ->where('vendor_menu.status', 'show')
            ->where('vendor_products.status', 'active')
            ->where('vendors.status', 'active')
            ->whereIn('vendor_products.id', $product_ids)

            // ->distinct('vendors.id')
            // ->groupBy('vendor_products.combination_key')
            ->distinct()

            ->paginate(10);
        // dd($stores);
        $today = Carbon::parse(date('Y-m-d H:i:s'))->dayName;

        foreach ($stores as $key => $row) {
            if ($row->scheduled_delivery == '1') {

                // $vendorslotes = VendorDeliverySlot::where('vendor_id', $row->id)->pluck('slot_ids')->first();
                $delivery_slots = DeliverySlot::orderBy('start', 'ASC')->get();
                $working_days = VendorWorkingHours::where('vendor_id', $row->id)->pluck('day')->toArray();
                $working_days_arr = VendorWorkingHours::where('vendor_id', $row->id)->get();

                if (($row->online == 1) && (in_array($today, array_map('ucfirst', $working_days)))) {

                    $working_hours = VendorWorkingHours::where('vendor_id', $row->id)->where('day', $today)->first();
                    $now = Carbon::now();
                    $start = Carbon::createFromTimeString($working_hours->from);
                    $end = Carbon::createFromTimeString($working_hours->to);

                    if ($now->between($start, $end)) {
                        $stores[$key]['working_status'] = "open";
                        $stores[$key]['next_opening'] = '';
                        $stores[$key]['next_day'] = '';
                    } else {
                        if (count($working_days) > 0) {
                            $j = ($now > $start) ? 1 : 0;
                            $k = ($now > $start) ? 7 : 6;

                            for ($i = $j; $i <= $k; $i++) {
                                $newDateTime = Carbon::now()->addDay($i);
                                $day = $newDateTime->format('l');
                                if (in_array($day, array_map('ucfirst', $working_days))) {
                                    $work = VendorWorkingHours::where('vendor_id', $row->id)->where('day', 'LIKE', "%{$day}%")
                                        ->first();
                                    $stores[$key]['next_opening'] = $work->from;
                                    $stores[$key]['next_day'] = $work->day;

                                    break;
                                }

                            }

                        } else {
                            $stores[$key]['next_opening'] = '';
                            $stores[$key]['next_day'] = '';
                        }
                        $stores[$key]['working_status'] = "closed";
                    }

                } else {
                    if (count($working_days) > 0) {
                        for ($i = 1; $i <= 7; $i++) {

                            $newDateTime = Carbon::now()->addDay($i);
                            $day = $newDateTime->format('l');
                            if (in_array($day, array_map('ucfirst', $working_days))) {
                                $work = VendorWorkingHours::where('vendor_id', $row->id)->where('day', 'LIKE', "%{$day}%")
                                    ->first();
                                $stores[$key]['next_opening'] = $work->from;
                                $stores[$key]['next_day'] = $work->day;

                                break;
                            }

                        }

                    } else {
                        $stores[$key]['next_opening'] = '';
                        $stores[$key]['next_day'] = '';
                    }
                    $stores[$key]['working_status'] = "closed";
                }
            } else {
                $stores[$key]['next_opening'] = '';
                $stores[$key]['next_day'] = '';

                $stores[$key]['working_status'] = "closed";
            }

        }
        $dis_product_ids = VendorProduct::groupBy('vendor_products.combination_key')->distinct()->pluck('id');

        $products = VendorProduct::select(
            'vendor_products.id',
            'vendor_products.name',
            'vendor_products.price',
            'vendor_products.selling_price',
            'vendor_products.variant_option',
            'vendor_products.type',
            'vendor_products.stock',
            'vendor_products.combination_key',
            'vendor_menu.id as menu_id',
            'vendor_menu.name as menu',
            'vendor_submenu.id as submenu_id',
            'vendor_submenu.name as submenu',
            'carts.quantity as cart_quantity', 'vendor_products.available_at', 'vendor_products.available_to',
            'vendors.id as vendor_id',
            DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'),
            DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'),
            DB::raw('CONCAT("' . $img_path . '", vendors.logo) as vendor_logo '),
            DB::raw("( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"),
            'allow_orders_within'
        )
            ->join('vendors', 'vendors.id', 'vendor_products.vendor_id')
            ->join('vendor_business_categories', 'vendor_business_categories.vendor_id', 'vendors.id')
            ->join('business_categories', 'business_categories.id', 'vendor_business_categories.business_category_id')
            ->join('vendor_menu', 'vendor_menu.id', 'vendor_products.menu_id')
            ->leftjoin('vendor_submenu', 'vendor_submenu.id', 'vendor_products.submenu_id')
            ->leftjoin('carts', function ($join) use ($authUser_id) {
                $join->on('carts.product_id', 'vendor_products.id');
                $join->where('carts.user_id', '=', $authUser_id);

            });
        // ->join('vendor_products', 'business_categories.id', 'vendor_products.business_category_id');

        if ($search) {
            $products->where(function ($query) use ($search) {
                $query->orWhere('vendor_products.name', 'like', '%' . $search . '%');
                $query->orWhere('vendor_products.short_description', 'like', '%' . $search . '%');
                // $query->orWhere('vendors.name', 'like', '%' . $search . '%');
                $query->orWhere('vendor_products.product_code', 'like', '%' . $search . '%');
                $query->orWhere('vendor_products.keywords', 'like', '%' . $search . '%');

            });
        }
        if ($category_id) {
            $products->where(function ($query) use ($search) {

                $query->orWhere('business_categories.id', $category_id);
            });
        }

        $products = $products
            ->having('distance', '<=', DB::raw('vendors.allow_orders_within'))
            ->where('vendor_menu.status', 'show')
            ->where('vendors.status', 'active')
            ->whereIn('vendor_products.id', $dis_product_ids)
            // ->distinct('vendor_products.id')
            // ->groupBy('vendor_products.combination_key')
            ->distinct()
            ->orderBy('discount')
            ->paginate(6);

        foreach ($products as $key => $row) {
            $subproducts_varients = VendorProduct::select(
                'id',
                'variant_option',
                'name',
                'price',
                'selling_price',
                'combination_key', 'vendor_products.available_at', 'vendor_products.available_to',
                'stock',
                DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount')
            )
                ->where('combination_key', $row->combination_key)
                ->get();
            $products[$key]['product_varients'] = $subproducts_varients;
        }

        return response()->json([

            'data' => [
                'popular_searches' => $popular_searches,
                'categories' => $categories,
                'stores' => $stores,
                'products' => $products,
            ],
            'status' => true,
        ]);

    }

    public function customerSupport(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'subject' => ['required'],
            'comment' => ['required'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser = authUser('api');
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }
        $input = $request->only(['subject', 'comment']);
        $input['user_id'] = $authUser_id;
        DB::beginTransaction();
        try {
            CustomerSupport::create($input);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }
        DB::commit();

        Mail::send('Mail.customersupport',
        array(
            'subject' => $request->subject,
            'comment' => $request->comment,
        ), function ($message) use ($request) {
            $message->from('admin@grofirst.app', 'grofirst');
            $message->to('hello@grofirst.app');
            //$message->to('anpmtp@gmail.com');
            $message->subject('RE:Customer Support Request From Customer');
        });

        return response()->json([
            'toast' => __('Comment Stored Successfully.'),
            'status' => true,
        ]);

    }

    public function profileDetails(Request $request)
    {
        $authUser = authUser('api');
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }

        $user = User::select('users.name', 'users.email', 'users.mobile', 'users.doj', 'users.status', DB::raw('DATE_FORMAT(users.dob, "%d-%m-%Y") as dob'))->where('id', $authUser_id)->first();

        return response()->json([
            'user' => $user,
            'status' => true,
        ]);

    }

    public function profile_update(Request $request, User $user)
    {
        $authUser = authUser('api');
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }

        $validator = Validator::make(request()->all(), [
            'name' => ['required'],
            'email' => ['nullable', 'email', 'unique:users,email,' . $authUser_id],
            'dob' => ['required', 'date'],

        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $user = User::where('id', $authUser_id)->first();

        $input = $request->only(['name']);
        if ($request->email != '') {
            $input['email'] = $request->email;
        }
        $input['dob'] = date('Y-m-d', strtotime($request->dob));
        $user->update($input);

        DB::beginTransaction();
        try {

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }
        DB::commit();
        $user_data = User::select('users.name', 'users.email', 'users.mobile', 'users.doj', 'users.status', DB::raw('DATE_FORMAT(users.dob, "%d-%m-%Y") as dob'))->where('id', $authUser_id)->first();

        return response()->json([
            'user' => $user_data,
            'toast' => __('Profile Updated Successfully.'),
            'status' => true,
        ]);

    }

    public function vendorProductPagination(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'vendor_id' => ['required'],
            'menu_id' => ['nullable'],
            'submenu_id' => ['nullable'],

        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser = authUser('api');
        $authUser_id = (authUser('api')) ? authUser('api')->id : 0;
        $search = $request->search ?? null;
        // $selected_menu = $request->selected_menu ?? null;
        // $selected_submenu = $request->selected_submenu ?? null;

        $vendor = Vendor::where('status', 'active')->find($request->vendor_id);

        if ($vendor == null) {
            return response()->json([
                'toast' => __('Invalid Vendor'),
                'status' => false,
            ]);
        }
        $img_path = '/uploads/';

        $product_ids = VendorProduct::groupBy('vendor_products.combination_key')->distinct()->pluck('id');

        $products = VendorProduct::select('vendor_products.id', 'vendor_products.name', 'vendor_products.price', 'vendor_products.selling_price', 'vendor_products.variant_option', 'vendor_products.type', 'vendor_products.stock', 'vendor_products.combination_key', 'vendor_menu.id as menu_id', 'vendor_menu.name as menu', 'vendor_submenu.id as submenu_id', 'vendor_submenu.name as submenu', 'carts.quantity as cart_quantity', 'vendor_products.display_order', 'vendor_products.available_at', 'vendor_products.available_to', DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'), DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'))
            ->join('vendors', 'vendors.id', 'vendor_products.vendor_id')
            // ->join('vendor_business_categories', 'vendor_business_categories.vendor_id', 'vendors.id')
            // ->join('business_categories', 'business_categories.id', 'vendor_business_categories.business_category_id')
            ->join('vendor_menu', 'vendor_menu.id', 'vendor_products.menu_id')
            ->leftjoin('vendor_submenu', 'vendor_submenu.id', 'vendor_products.submenu_id')
            ->leftjoin('carts', function ($join) use ($authUser_id) {
                $join->on('carts.product_id', 'vendor_products.id');
                $join->where('carts.user_id', '=', $authUser_id);

            });
        if ($search) {
            $products->where(function ($query) use ($search) {
                $query->orWhere('vendor_products.name', 'like', '%' . $search . '%');
                $query->orWhere('vendor_products.short_description', 'like', '%' . $search . '%');
                $query->orWhere('vendors.name', 'like', '%' . $search . '%');
                $query->orWhere('vendor_products.product_code', 'like', '%' . $search . '%');
                $query->orWhere('vendor_products.keywords', 'like', '%' . $search . '%');

            });
        }

        if ($request->menu_id != '') {
            $products->where(function ($query) use ($request) {

                $query->where('vendor_products.menu_id', $request->menu_id);
            });
        }
        if ($request->submenu_id != '') {
            $products->where(function ($query) use ($request) {
                $query->where('vendor_products.submenu_id', $request->submenu_id);
            });

        }

        $products = $products->where('vendor_products.vendor_id', $request->vendor_id)
            ->where('vendor_menu.status', 'show')
            ->where('vendors.status', 'active')
            ->whereIn('vendor_products.id', $product_ids)
            // ->groupBy('vendor_products.id')
            // ->groupBy('vendor_products.combination_key')
            ->distinct('vendor_products.id')
            ->orderBy('vendor_products.display_order', 'ASC')



             ->orderBy('vendor_products.id')
            // ->selectRaw('GROUP_CONCAT(vendor_products.id) as grouped_ids')
            // ->selectRaw('GROUP_CONCAT(vendor_products.combination_key) as grouped_combination_keys')
            ->paginate(6);
        //    ->get();
        // dd($products);
        // $products=VendorProduct::select('vendor_products.id', 'vendor_products.name', 'vendor_products.price', 'vendor_products.selling_price', 'vendor_products.variant_option', 'vendor_products.type', 'vendor_products.stock', 'vendor_products.combination_key', DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'), DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'))
        // ->join('vendors', 'vendors.id', 'vendor_products.vendor_id')
        // ->join('vendor_menu', 'vendor_menu.id', 'vendor_products.menu_id')
        // ->leftjoin('vendor_submenu', 'vendor_submenu.id', 'vendor_products.submenu_id')

        // ->leftjoin('carts', function ($join) use ($authUser_id) {
        //     $join->on('carts.product_id', 'vendor_products.id');
        //     $join->where('carts.user_id', '=', $authUser_id);

        // });


        // $products=$products->whereIn('vendor_products.id',$product_ids)
        // ->distinct('vendor_products.id')
        // ->orderBy('vendor_products.display_order','ASC')
        // ->paginate(6);


        foreach ($products as $key => $row) {
            $subproducts_varients = VendorProduct::select(
                'vendor_products.id',
                'vendor_products.variant_option',
                'vendor_products.name', 'vendor_products.available_at', 'vendor_products.available_to',
                'price',
                'selling_price',
                'combination_key',
                'stock',
                'carts.quantity as cart_quantity',
                DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount')
            )
                ->where('combination_key', $row->combination_key)
                ->leftjoin('carts', function ($join) use ($authUser_id) {
                    $join->on('carts.product_id', 'vendor_products.id');
                    $join->where('carts.user_id', '=', $authUser_id);

                })
                ->orderBy('vendor_products.display_order', 'ASC')
                ->get();
            $products[$key]['product_varients'] = $subproducts_varients;
        }

        return response()->json([
            'products' => $products,
            'status' => true,
        ]);

    }
    public function offerProducts(Request $request)
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
        $authUser = authUser('api');
        $authUser_id = (authUser('api')) ? authUser('api')->id : 0;
        $longitude = $request->longitude ?? '';
        $latitude = $request->latitude ?? '';
        $img_path = '/uploads/';

        $vendor_array = array();

        $vendors = Vendor::select(DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo '), DB::raw("vendors.id,vendors.name,( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"), 'allow_orders_within')
            ->having('distance', '<=', DB::raw('vendors.allow_orders_within'))
            ->where('status', 'active')
            ->orderBy('distance')
            ->limit(20)
            ->get();
        foreach ($vendors as $row) {
            array_push($vendor_array, $row->id);
        }

        // $sliders = Vendor::select(DB::raw("vendors.id,vendors.name,( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"),DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo '))
        //     ->join('sliders', 'sliders.vendor_id', 'vendors.id')
        //     ->having('distance', '<=', 'allow_orders_within')
        //     ->where('vendors.status', 'active')
        //     ->orderBy('distance')
        //     ->limit(20)
        //     ->get();
        $sliders = Slider::select(DB::raw("vendors.id as vendor_id,sliders.name as slider_name,( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"), DB::raw('CONCAT("' . $img_path . '", sliders.image) as image '), 'allow_orders_within')
            ->join('vendors', 'sliders.vendor_id', 'vendors.id')
            ->having('distance', '<=', DB::raw('vendors.allow_orders_within'))
            ->where('vendors.status', 'active')
            ->orderBy('distance')
            ->limit(20)
            ->get();

        $products = VendorProduct::select(
            'vendor_products.id',
            'vendor_products.name as product_name',
            'vendor_products.price',
            'vendor_products.selling_price',
            'vendor_products.type',
            'vendor_products.combination_key',
            'carts.quantity as cart_quantity',
            'vendor_products.variant_option',
            'vendor_products.stock',
            'vendors.id as vendor_id', 'vendor_products.available_at', 'vendor_products.available_to',
            DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'),
            DB::raw('CONCAT("' . $img_path . '", vendors.logo) as vendor_logo '),
            DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount')
        )
            ->join('vendors', 'vendors.id', 'vendor_products.vendor_id')
            ->join('business_categories', 'business_categories.id', 'vendor_products.business_category_id')
            ->leftjoin('carts', function ($join) use ($authUser_id) {
                $join->on('carts.product_id', 'vendor_products.id');
                $join->where('carts.user_id', '=', $authUser_id);

            })
            ->whereIn('vendors.id', $vendor_array)
            ->where('vendors.status', 'active')
            ->where('vendor_products.status', 'active')
            ->where('vendor_products.stock', 'in-stock')
            ->havingRaw('discount > 0')
            ->groupBy('vendor_products.combination_key')
            ->orderBy('discount', 'DESC')
            ->limit(12)->get();

        foreach ($products as $key => $row) {
            $subproducts_varients = VendorProduct::select(
                'id',
                'variant_option',
                'name',
                'price',
                'selling_price',
                'combination_key',
                'stock',
                DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount')
            )
                ->where('combination_key', $row->combination_key)
                ->get();
            $products[$key]['product_varients'] = $subproducts_varients;
        }
        if ($products->isEmpty()) {
            $products = []; // Set products to null if it's empty
        }


        return response()->json([
            'sliders' => $sliders,
            'products' => $products,
            'status' => true,
        ]);
    }

    public function orderDetails(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'order_id' => ['required'],

        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }
        $order = Order::select('vendors.id as vendor_id', 'vendors.id', 'orders.id as order_id', 'orders.status', DB::raw('DATE_FORMAT(orders.created_at,"%Y-%m-%d %H:%i:00") as order_date'), 'orders.user_id', 'orders.store_code_number', 'orders.delivery_geo_location', 'orders.delivery_latitude', 'orders.delivery_longitude', 'orders.delivery_address', 'orders.delivery_location', 'orders.delivery_phone', 'orders.delivery_type', 'orders.delivery_weight', 'orders.delivery_distance', 'orders.delivery_charge', 'orders.packaging_charge', 'orders.total_price_amount', 'orders.total_price_discount', 'orders.discount_code', 'orders.discount_amount', 'orders.total_amount', 'orders.final_amount', 'orders.commission_amount', 'orders.note', 'orders.status', 'orders.assign_user_id', 'orders.updated_at', 'orders.payment_status', 'orders.delivery_date', 'orders.delivery_time', 'orders.created_at', 'orders.payment_method', 'orders.is_confirm', DB::raw('CONVERT(orders.bill_amount,CHAR) as bill_amount'), 'orders.is_bill_confirm', DB::raw('CONVERT(orders.final_delivery_charge,DOUBLE) as final_delivery_charge'), 'orders.final_bill_amount', 'comments', DB::raw('CONCAT(vendors.store_identification_code,orders.store_code_number) as store_code'))
            ->leftjoin('vendors', 'vendors.id', 'orders.vendor_id')
            ->where('orders.id', $request->order_id)->where('orders.user_id', $authUser_id)->first();
        if (!$order) {
            return response()->json([
                'toast' => __('Invalid Order'),
                'status' => false,
            ]);

        }
        $order->public_note = OrderStatus::select('public_note')->where('order_id', $order->order_id)->latest()->first();
        $img_path = '/uploads/';

        $order_items = OrderItem::where('order_id', $order->order_id)->get();

        foreach ($order_items as $key => $item) {
            $order->product_discount = ($order->product_discount) + (($item->price - $item->selling_price) * $item->quantity);
        }
        $order->total_confirmation_time = '5 - 00';

        $store_details = Vendor::select('vendors.id', 'vendors.name', 'vendors.location', DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo'), 'vendors.primary_contact_number', DB::raw('CASE WHEN is_grofirst_vendor = "true" THEN "true" ELSE "false" END AS is_grofirst_vendor'))->find($order->vendor_id);

        $status = array("ordered", "placed", "prepared", "picked", "delivered", "cancelled", "expired");
        $coupon_details = Coupon::where('code', $order->discount_code)->first();

        $order_status_arr = array();
        foreach ($status as $key1 => $row) {
            $order_status = OrderStatus::where('order_id', $order->order_id)->where('status', $row)->first();
            if ($order_status) {
                array_push($order_status_arr, ['status' => $row, 'time' => date('Y-m-d H:i:s', strtotime($order_status->created_at)), 'public_note' => $order_status->public_note]);
            } else {
                array_push($order_status_arr, ['status' => $row, 'time' => '', 'public_note' => '']);
            }

        }
        $order_timestamp = Carbon::parse($order->created_at)->timestamp;
        $now = Carbon::now()->timestamp;

        $order_time = Carbon::createFromTimeString($order->created_at);
        // $post_time = $order_time->addMinutes(5)->timestamp;

        //
        $post_time = Carbon::parse($order->created_at)->timestamp + 5 * 60; // Add 5 minutes in seconds
        $delivery_user_details =  DeliveryOrder::select('delivery_agents.name as deliveryboy_name','mobile')->join('delivery_agents', 'delivery_agents.id', 'delivery_orders.user_id')->where('order_id', $order->order_id)->first();
        if (($now < $post_time) && ($order->status == 'ordered')) {
            $remaining_time = $post_time - $now; // Calculate remaining time in seconds

            $remaining_minutes = floor($remaining_time / 60); // Calculate remaining minutes
            $remaining_seconds = sprintf('%02d', ($remaining_time % 60)); // Calculate remaining seconds

            $order->confirmation_time = ($remaining_minutes . ' - ' . $remaining_seconds);
            // $diff_time = number_format(($post_time - strtotime(date("Y-m-d H:i:s"))) / 60, 2);
            // $order->confirmation_time = str_replace('.', ' - ', $diff_time);

        } else {

            $order->confirmation_time = '';
            if ($order->status == 'ordered') {

                Order::where('id', $order->order_id)->update([
                    'status' => 'expired',
                ]);
                $order->status = 'expired';
                // OrderStatus::where('order_id', $order->order_id)->update([
                //     'status' => 'expired',
                // ]);
                OrderStatus::create([
                    'vendor_id' => $order->vendor_id,
                    'order_id' => $order->order_id,
                    'status' => 'expired',
                ]);
                // OrderItem::where('order_id', $order->order_id)->update([
                //     'status' => 'expired',
                // ]);
                UserNotification::create([
                    'user_id' => VendorUser::find($order->vendor_id)->user_id,
                    'relation_id' => $order->order_id,
                    'notification' => 'order_expired',
                    'relation_table' => 'orders',
                    'status' => 'unread',
                ]);

            }
        }

        // }
        return response()->json([
            'toast' => __('success'),
            'store_details' => $store_details,
            'status' => true,
            'order' => $order,
            'order_items' => $order_items,
            'order_status' => $order_status_arr,
            'coupon_details' => $coupon_details,
            'delivery_user'=>$delivery_user_details
        ]);

    }

    public function Notifications(Request $request)
    {

        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }
        DB::beginTransaction();
        try {
            UserNotification::where('user_id', $authUser_id)->update([
                'status' => 'read',
            ]);
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }
        DB::commit();
        $notifications = UserNotification::select('user_notifications.*', 'vendors.name as store_name', DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m-%d %H:%i:%s') AS ordered_time"), 'orders.created_at', DB::raw("DATE_FORMAT(user_notifications.created_at, '%Y-%m-%d %H:%i:%s') AS notification_time"), 'orders.store_code_number', 'orders.final_amount', 'orders.comments', 'orders.payment_method', 'delivery_agents.name as agent_name')

            ->leftjoin('orders', function ($join) {
                $join->on('orders.id', 'user_notifications.relation_id');
                $join->where('user_notifications.relation_table', '=', 'orders');

            })
            ->leftjoin('vendors', 'vendors.id', 'orders.vendor_id')
            ->leftjoin('delivery_orders', 'delivery_orders.order_id', 'orders.id')
            ->leftjoin('delivery_agents', function ($join2) {
                $join2->on('delivery_agents.id', 'delivery_orders.user_id');
                $join2->where('orders.status', 'picked');
            })
            ->where('user_notifications.user_id', $authUser_id)
            ->whereNotIn('user_notifications.notification', ['order_prepare','order_prepared'])

            ->orderBy('user_notifications.created_at', 'DESC')->get();
        // dd($notifications);
        foreach($notifications as $key => $row) {
            switch ($row->notification) {
                case 'order_ordered':

                    $notifications[$key]['message'] = 'Order placed successfully.Please Wait for store confirmation.';
                    break;
                case 'order_placed':
                    $notifications[$key]['message'] = 'Your order has been confirmed.Pay Rs '.$row->final_amount.' now';
                    break;
                case 'order_picked':
                    $notifications[$key]['message'] = 'Your order out for delivery.picked by '.(($row->agent_name) ?? 'grofirst');
                    break;
                case 'order_delivered':
                    $notifications[$key]['message'] = 'Your order has been delivered. '.$row->payment_method;
                    break;
                case 'order_cancelled':
                    $notifications[$key]['message'] = 'The vendor has been cancelled your order.'.$row->comments;
                    break;
                case 'order_cancelled_by_customer':
                    $notifications[$key]['message'] = 'You have cancelled the order.';
                    break;
                default:
                    $notifications[$key]['message'] = '';
                    break;
            }
            // if($row->notification=='order_ordered'){
            //     $notifications[$key]['message']='Order placed successfully.Please Wait for store confirmation.';
            // }elseif($row->notification=='order_placed'){
            //     $notifications[$key]['message']='Your order has been confirmed.Pay Rs '.$row->final_amount.' now';
            // }elseif($row->notification=='order_picked'){
            //     $notifications[$key]['message']='Your order out for delivery';
            // }elseif($row->notification=='order_delivered'){
            //     $notifications[$key]['message']='Your order has been delivered';
            // } elseif($row->notification=='order_cancelled'){
            //     $notifications[$key]['message']='The vendor has been cancelled your order.'.$row->comments;
            // }elseif($row->notification=='order_cancelled_by_customer'){
            //     $notifications[$key]['message']='You have cancelled the order.';
            // }

        }

        return response()->json([
            'toast' => __('success'),
            'notifications' => $notifications,
            'status' => true,

        ]);

    }

    public function Orderstorecode($vendor_id)
    {
        $latest = Order::where('vendor_id', $vendor_id)->latest()->first();
        if (!$latest) {
            return '101';
        }
        $store_code_number = $latest->store_code_number;
        return ($store_code_number + 1);
    }

    public function MinimalCart()
    {

        $authUser_id = authUser('api')->id;
        if ($authUser_id == '') {
            return response()->json([
                'toast' => __('Invalid User'),
                'status' => false,
            ]);
        }
        $cart_data = Cart::select(DB::raw('COUNT(carts.id) as cart_items_count'), DB::raw('SUM(vendor_products.selling_price * carts.quantity) as total_amount'))
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)
            ->where('vendor_products.stock', 'in-stock')
            ->first();
        $vendor_data =[];
        if($cart_data){
            $img_path = '/uploads/';
            $vendor_data = Vendor::select(
                'vendors.id',
                'vendors.name',
                'vendors.location',
                'vendors.free_delivery_upto',
                DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo '),
                'vendors.avoide_delivery_fee',
                'vendors.amount_to_avoid_min_delivery',
                'vendors.min_delivery_upto_km',
                'vendors.delivery_fee_per_km',
                'vendors.min_delivery_fee' 
            )
            ->join('vendor_products', 'vendor_products.vendor_id', 'vendors.id')
            ->join('carts', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)->first();
        }
        
        return response()->json([
            'cart_data' => $cart_data,
            'cart_store'=> $vendor_data
        ]);
    }

    public function getAppVersion()
    {

        DB::beginTransaction();
        try {
            $version = Option::where('key', 'app_version')->first()->value;

        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'toast' => __('Version details not exist.'),
                'status' => false,
            ]);


        }
        DB::commit();

        return response()->json([
            'app_version' => $version
        ]);
    }

    public function sendWebNotification($order_details, $vendor = null)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        // $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();
        // $serverKey = 'BGZJMNrvpFtIBz7SZq5g1a3xKo_ZQodMKjX3YsTSXsjt1sN83secRkodKy9DmpcH8N_GEcfczH1gbbY7jy7Qw-w';
        $user_data = VendorUser::join('users', 'users.id', 'vendor_users.user_id')
        ->where('vendor_id', $vendor->id)->first();
        
        $userapi = App\ApiToken::where('user_id', $user_data->user_id)->where('status', 'active')->latest()->get();
		 
        $FcmToken = [];
         
		if ((count($userapi) > 0)) {
			foreach ($userapi as $api) {
				if($api->fcm!='')
					array_push($FcmToken,$api->fcm);                    
			}
		}
         if(is_array($FcmToken))
                $FcmToken = array_unique($FcmToken);
		//dd($FcmToken);
        //$FcmToken = $user_data->fcm;
		$uFcmToken = [];
		foreach ($FcmToken as $tkn) {
			array_push($uFcmToken,$tkn);   
		}
        $serverKey = Config('app.firebase.server_key');
        $data = [
            "registration_ids" => $uFcmToken,
            "notification" => [
                "title" => 'New Order Recieved',
                "body" => 'Order Id is - '.$order_details['order']['order_id'],
            ],
            'delay_while_idle' => false,
            'priority' => 'high'
        ];
        $encodedData = json_encode($data);
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        // FCM response
        $result_decode = json_decode($result); 
        if(isset($result_decode) && ($result_decode->success == 1)) {
            return true;
        } else {
            return false;

        }
    }
    public function generalCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'coupon_code' => ['required']
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $authUser_id = authUser('api')->id;

        $cart_total_amount = Cart::select('vendor_products.vendor_id', DB::raw('SUM(vendor_products.selling_price * carts.quantity) as totalamount'))
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)
            ->first();
        if ($cart_total_amount->totalamount == null) {
            return response()->json([
                'toast' => __('Your cart is empty'),
                'status' => false,
            ]);
        }
        $vendor_id = $cart_total_amount->vendor_id;

        $order_exist_coupon = Order::join('coupons', 'orders.discount_code', 'coupons.code')
            ->where('orders.user_id', $authUser_id)->where('coupons.code', $request->coupon_code)->first();

        if ($order_exist_coupon) {
            return response()->json([
                'toast' => __('Sorry... Your coupon code is already applied'),
                'status' => false,
            ]);
        }
        $all_coupons = Coupon::where('status', 'published')->get();
        $user_order_count = Order::where('user_id', $authUser_id)->count();
        $user_next_order_count = $user_order_count + 1;

        $coupon = Coupon::where('coupons.code', $request->coupon_code)->whereIn('coupons.status', ['private','published'])

            ->where(function ($query) use ($cart_total_amount) {
                $query->whereNull('min_cart_amount')
                    ->orWhere('min_cart_amount', '<=', $cart_total_amount->totalamount);
            })

            ->where(function ($query) use ($cart_total_amount) {
                $query->whereNull('max_cart_amount')
                    ->orWhere('max_cart_amount', '>=', $cart_total_amount->totalamount);
            })
            ->where(function ($query) use ($vendor_id) {
                $query->whereNull('vendor_id')
                ->orwhere('vendor_id', $vendor_id);
            })

            ->where(function ($query) use ($user_next_order_count) {
                $query->Where('on_which_order', $user_next_order_count)->orWhere('on_which_order', '=', 0);
            });

        $coupon = $coupon->first();

        if(!$coupon) {
            return response()->json([
                'toast' => __('Inavalid Coupon Code'),
                'status' => false,
            ]);
        }
        return response()->json([
            'coupon' => $coupon,
            'status' => true,
        ]);

    }
    public function storeProfile(Request $request){
        $validator = Validator::make(request()->all(), [
            'vendor_id' => ['required'],
            'latitude' => ['required', 'numeric', 'max:100'],
            'longitude' => ['required', 'numeric', 'max:100'],
        ]);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $img_path = '/uploads/';
        $vendor = Vendor::where('status', 'active')->find($request->vendor_id);

        if ($vendor == null) {
            return response()->json([
                'toast' => __('Invalid Vendor'),
                'status' => false,
            ]);
        }

        // $authUser_id = authUser('api')->id;
        $authUser_id = (authUser('api')) ? authUser('api')->id : 0;

        $longitude = $request->longitude ?? '';
        $latitude = $request->latitude ?? '';
       
        $next_slot_id = 0;

        $cart_data = Cart::select(DB::raw('COUNT(carts.id) as cart_items_count'), DB::raw('SUM(vendor_products.selling_price * carts.quantity) as total_amount'))
            ->join('vendor_products', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)
            ->where('vendor_products.stock', 'in-stock')
            ->first();
        $vendor_data =[];
        if($cart_data){
            $img_path = '/uploads/';
            $vendor_data = Vendor::select(
                'vendors.id',
                'vendors.name',
                'vendors.location',
                'vendors.free_delivery_upto',
                DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo '),
                'vendors.avoide_delivery_fee',
                'vendors.amount_to_avoid_min_delivery',
                'vendors.min_delivery_upto_km',
                'vendors.delivery_fee_per_km',
                'vendors.min_delivery_fee' 
            )
            ->join('vendor_products', 'vendor_products.vendor_id', 'vendors.id')
            ->join('carts', 'carts.product_id', 'vendor_products.id')
            ->where('carts.user_id', $authUser_id)->first();
        }
        // dd(Cart::where('carts.user_id', $authUser_id)->get());
        // dd(Cart::select('vendor_products.*')->join('vendor_products', 'carts.product_id', 'vendor_products.id')->get());

        // $vendorslotes = VendorDeliverySlot::where('vendor_id', $vendor->id)->pluck('slot_ids')->first();
        $delivery_slots = array();
        $delivery_slots = DeliverySlot::orderBy('start', 'ASC')->get();

        $working_days = VendorWorkingHours::where('vendor_id', $vendor->id)->pluck('day')->toArray();
        $time_str = time();
        $time = date('H:i:s', time());

        $post_time_str = time() + 60 * 60;
        $post_time = date('H:i:s', time() + 60 * 60);

        $today = Carbon::parse(date('Y-m-d H:i:s'))->dayName;

        $slot_array = array();

        $final_slot_array = array();

        if ((count($working_days) > 0) && (count($delivery_slots) > 0)) {

            foreach ($delivery_slots as $key => $slot) {

                $slot_time_arr = strtotime($slot->start);

                $diff = $slot_time_arr - $post_time_str;

                if ((($diff) > 0) && in_array($today, array_map('ucfirst', $working_days))) {
                    $slot_array[$key]['day'] = $today;
                    $slot_array[$key]['slot_id'] = $slot->id;
                    $slot_array[$key]['slot_name'] = $slot->slot_name;
                    // $slot_array[$key]['post_time'] = $post_time;
                    $slot_array[$key]['start_time'] = $slot->start;
                    $slot_array[$key]['end_time'] = $slot->end;
                    $slot_array[$key]['diff_time'] = $diff;
                }

            }
            if (!count($slot_array) > 0) {

                foreach ($delivery_slots as $key => $slot) {

                    $slot_time_arr = strtotime($slot->start);

                    $diff = $slot_time_arr - $post_time_str;
                    $day = $this->nextWorkingday($vendor->id);

                    $slot_array[$key]['day'] = $day;
                    $slot_array[$key]['slot_id'] = $slot->id;
                    $slot_array[$key]['slot_name'] = $slot->slot_name;
                    // $slot_array[$key]['post_time'] = $post_time;
                    $slot_array[$key]['start_time'] = $slot->start;
                    $slot_array[$key]['end_time'] = $slot->end;
                    $slot_array[$key]['diff_time'] = $diff;

                }

            }
            array_multisort(array_column($slot_array, "diff_time"), SORT_ASC, $slot_array);

            $final_slot_array = $slot_array[0];
        }

        $store_details = Vendor::select('id', 'name', 'address', 'location', 'landmark', 'state', 'district', 'pincode', 'scheduled_delivery', 'star_rating', 'online', 'free_delivery_upto', 'delivery_fee_per_km', DB::raw('CONCAT("' . $img_path . '", vendors.logo) as logo '), DB::raw("( 6371 * acos( cos( radians($latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance"), DB::raw('CASE WHEN is_grofirst_vendor = "true" THEN "true" ELSE "false" END AS is_grofirst_vendor'))
            ->where('id', $request->vendor_id)->get();

        foreach ($store_details as $key => $row) {

            if (($row->online == 1) && (in_array($today, array_map('ucfirst', $working_days)))) {
                $working_hours = VendorWorkingHours::where('vendor_id', $row->id)->where('day', $today)->first();
                $now = Carbon::now();
                $start = Carbon::createFromTimeString($working_hours->from);
                $end = Carbon::createFromTimeString($working_hours->to);

                if ($now->between($start, $end)) {
                    $store_details[$key]['working_status'] = "online";
                } else {
                    $store_details[$key]['working_status'] = "offline";
                }
            } else {
                $store_details[$key]['working_status'] = "offline";
            }

            $store_details[$key]['next_delivery'] = ((count($final_slot_array) > 0) && ($row->scheduled_delivery == 1)) ? $final_slot_array : null;

        }
        // $store_details[$key]['next_slot']='';
        $menus = VendorMenu::select('id', 'name')->where('vendor_id', $request->vendor_id)->where('status', 'show')->orderBy('display_order', 'ASC')->get();
        $product_ids = VendorProduct::where('vendor_products.vendor_id', $vendor->id)->groupBy('vendor_products.combination_key')->distinct()->pluck('id');

        $hotedeals = VendorProduct::select('vendor_products.id', 'vendor_products.name', 'vendor_products.price', 'vendor_products.selling_price', 'vendor_products.variant_option', 'vendor_products.type', 'vendor_products.stock', 'vendor_products.combination_key', 'vendor_menu.id as menu_id', 'vendor_menu.name as menu', 'vendor_menu.id as submenu_id', 'vendor_menu.name as submenu', 'carts.quantity as cart_quantity', 'vendors.id as vendors_id', DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'), DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'), 'vendor_products.product_id', 'vendor_products.available_at', 'vendor_products.available_to')
            ->join('vendors', 'vendors.id', 'vendor_products.vendor_id')
            ->join('vendor_business_categories', 'vendor_business_categories.vendor_id', 'vendors.id')
            ->join('business_categories', 'business_categories.id', 'vendor_business_categories.business_category_id')
            ->join('vendor_menu', 'vendor_menu.id', 'vendor_products.menu_id')
            ->leftjoin('vendor_submenu', 'vendor_submenu.id', 'vendor_products.submenu_id')
            ->leftjoin('carts', function ($join) use ($authUser_id) {
                $join->on('carts.product_id', 'vendor_products.id');
                $join->where('carts.user_id', '=', $authUser_id);

            })->where('vendor_products.vendor_id', $vendor->id)
            ->where('vendor_menu.status', 'show') 
            ->where('vendor_products.status', 'active')
            ->where('vendors.status', 'active')
            ->whereIn('vendor_products.id', $product_ids)
            ->distinct() 
            ->orderBy('vendor_products.display_order', 'ASC')
            ->paginate(6);
        foreach ($menus as $key => $menu) {
            $product_ids = VendorProduct::where('vendor_products.menu_id', $menu->id)->groupBy('vendor_products.combination_key')->distinct()->pluck('id');

            $products = VendorProduct::select('vendor_products.id', 'vendor_products.name', 'vendor_products.price', 'vendor_products.selling_price', 'vendor_products.variant_option', 'vendor_products.type', 'vendor_products.stock', 'vendor_products.combination_key', 'vendor_menu.id as menu_id', 'vendor_menu.name as menu', 'vendor_menu.id as submenu_id', 'vendor_menu.name as submenu', 'carts.quantity as cart_quantity', 'vendors.id as vendors_id', DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'), DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'), 'vendor_products.product_id', 'vendor_products.available_at', 'vendor_products.available_to')
                ->join('vendors', 'vendors.id', 'vendor_products.vendor_id')
                ->join('vendor_business_categories', 'vendor_business_categories.vendor_id', 'vendors.id')
                ->join('business_categories', 'business_categories.id', 'vendor_business_categories.business_category_id')
                ->join('vendor_menu', 'vendor_menu.id', 'vendor_products.menu_id')
                ->leftjoin('vendor_submenu', 'vendor_submenu.id', 'vendor_products.submenu_id')
                ->leftjoin('carts', function ($join) use ($authUser_id) {
                    $join->on('carts.product_id', 'vendor_products.id');
                    $join->where('carts.user_id', '=', $authUser_id);

                });



            $products = $products->where('vendor_products.vendor_id', $vendor->id)
                ->where('vendor_menu.status', 'show')
                ->where('vendor_products.menu_id', $menu->id)
                ->where('vendor_products.status', 'active')
                ->where('vendors.status', 'active')
                ->whereIn('vendor_products.id', $product_ids)
                ->distinct()

                // ->distinct('vendor_products.id')
                // ->groupBy('vendor_products.combination_key')
                // ->orderBy('discount')
                ->orderBy('vendor_products.display_order', 'ASC')
                ->paginate(6);

            foreach ($products as $index => $row) {
                $products_varients = VendorProduct::select(
                    'vendor_products.id',
                    'vendor_products.variant_option',
                    'vendor_products.name',
                    'vendor_products.price',
                    'vendor_products.selling_price',
                    'combination_key', 'vendor_products.available_at', 'vendor_products.available_to',
                    'stock',
                    'carts.quantity as cart_quantity',
                    DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount')
                )
                    ->leftjoin('carts', function ($join) use ($authUser_id) {
                        $join->on('carts.product_id', 'vendor_products.id');
                        $join->where('carts.user_id', '=', $authUser_id);

                    })
                    ->where('combination_key', $row->combination_key)
                    ->distinct()
                    ->orderBy('vendor_products.display_order', 'ASC')
                    ->get();
                $products[$index]['product_varients'] = $products_varients;

            }

            $submenus = VendorSubmenu::select('id', 'name')->where('vendor_menu_id', $menu->id)->orderBy('display_order', 'ASC')->get();
            if (count($submenus) > 0) {
                foreach ($submenus as $key2 => $submenu) {
                    $sub_product_ids = VendorProduct::where('vendor_products.menu_id', $menu->id)
                    ->where('vendor_products.submenu_id', $submenu->id)->groupBy('vendor_products.combination_key')->distinct()->pluck('id');

                    $submenuproducts = VendorProduct::select('vendor_products.id', 'vendor_products.name', 'vendor_products.price', 'vendor_products.selling_price', 'vendor_products.variant_option', 'vendor_products.type', 'vendor_products.combination_key', 'vendor_products.stock', 'vendor_menu.id as menu_id', 'vendor_menu.name as menu', 'carts.quantity as cart_quantity', 'vendors.id as vendors_id', DB::raw('CONCAT("' . $img_path . '", vendor_products.image) as image'), DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'), 'vendor_products.product_id', 'vendor_products.available_at', 'vendor_products.available_to')
                        ->join('vendors', 'vendors.id', 'vendor_products.vendor_id')
                        ->join('vendor_business_categories', 'vendor_business_categories.vendor_id', 'vendors.id')
                        ->join('business_categories', 'business_categories.id', 'vendor_business_categories.business_category_id')
                        ->join('vendor_menu', 'vendor_menu.id', 'vendor_products.menu_id')
                        ->join('vendor_submenu', 'vendor_submenu.id', 'vendor_products.submenu_id')
                        ->leftjoin('carts', function ($join) use ($authUser_id) {
                            $join->on('carts.product_id', 'vendor_products.id');
                            $join->where('carts.user_id', '=', $authUser_id);

                        })
                        ->where('vendor_products.vendor_id', $vendor->id)
                        ->where('vendor_menu.status', 'show')
                        ->where('vendor_products.menu_id', $menu->id)
                        ->where('vendor_products.submenu_id', $submenu->id)
                        ->where('vendor_products.status', 'active')
                        ->where('vendors.status', 'active')
                        ->whereIn('vendor_products.id', $sub_product_ids)

                        // ->distinct('vendor_products.id')
                        // ->groupBy('vendor_products.combination_key')
                        ->distinct()

                        // ->orderBy('discount')
                        ->orderBy('vendor_products.display_order', 'ASC')
                        ->paginate(6);

                    foreach ($submenuproducts as $index2 => $row) {
                        $subproducts_varients = VendorProduct::select(
                            'vendor_products.id',
                            'vendor_products.variant_option',
                            'vendor_products.name',
                            'vendor_products.price',
                            'vendor_products.selling_price',
                            'vendor_products.combination_key',
                            'vendor_products.stock',
                            'carts.quantity as cart_quantity',
                            DB::raw('100 - (ROUND((selling_price  * 100) / price, 1)) AS discount'),
                            'vendor_products.product_id',
                            'vendor_products.available_at',
                            'vendor_products.available_to',
                        )
                            ->leftjoin('carts', function ($join) use ($authUser_id) {
                                $join->on('carts.product_id', 'vendor_products.id');
                                $join->where('carts.user_id', '=', $authUser_id);

                            })
                            ->where('combination_key', $row->combination_key)
                            ->distinct()
                            ->orderBy('vendor_products.display_order', 'ASC')
                            ->get();
                        $submenuproducts[$index2]['product_varients'] = $subproducts_varients;

                    }
                    $submenus[$key2]['products'] = $submenuproducts;
                }
            }
            $menus[$key]['submenus'] = $submenus;
            $menus[$key]['products'] = $products;

        }
        $vendor_sliders = Vendor::select(DB::raw('CONCAT("' . $img_path . '", sliders.image) as image '), DB::raw("vendors.id as vendor_id,sliders.name"))
        ->join('sliders', 'sliders.vendor_id', 'vendors.id') 
        ->where('vendors.status', 'active')->where('vendors.id', $vendor->id) 
        ->limit(20)
        ->get();
        $coupons = Coupon::where('coupons.status', 'published')->where('vendor_id', $vendor->id)->get();;
         
        return response()->json([
            'data' => [
                'cart_data' => $cart_data,
                'store' => $store_details,
                'menus' => $menus,
                'cart_store'=>$vendor_data,
                'hotedeals'=>$hotedeals,
                'vendor_sliders'=>$vendor_sliders,
                'coupons'=>$coupons
            ],
            'status' => true,
        ]);

    }

}
