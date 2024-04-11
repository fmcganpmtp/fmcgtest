<?php
namespace App\Http\Controllers;
use Validator;
use App\Coupon;
use App\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $vendors = Vendor::all();

        return view('backend/coupon/index', compact(  'search','vendors'));
    }

    function list(Coupon $coupon,Request $request)
    {
        $query = $coupon;
        $query = $query->select(
        'coupons.id',
        'coupons.title',
        'coupons.code',
        'coupons.status',
        'vendors.name as vendor_name'
        )->leftjoin('vendors','vendors.id','coupons.vendor_id');
        $data = $this->datatable(
            $query,
            function ($query)use($request) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('coupons.id', 'LIKE', "%{$search}%");
                    $query->orWhere('coupons.title', 'LIKE', "%{$search}%");
                    $query->orWhere('coupons.description', 'LIKE', "%{$search}%");
                    $query->orWhere('coupons.code', 'LIKE', "%{$search}%");
                    $query->orWhere('coupons.min_cart_amount', 'LIKE', "%{$search}%");
                    $query->orWhere('coupons.on_which_order', 'LIKE', "%{$search}%");
                    $query->orWhere('coupons.discount_amount', 'LIKE', "%{$search}%");
                    $query->orWhere('coupons.status', 'LIKE', "%{$search}%");
                }
                if ($request->filled('filter.coupon_status')) {
                    $query->where('coupons.status',$request->input('filter.coupon_status') );
                }
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
                    'title' => $row->title,
                    'vendor_name' => $row->vendor_name,

                    'code' => $row->code,
                    'status' => ucfirst( $row->status ),
                    'actions' => view('backend/coupon/actions', compact('row'))->render(),
                    ];
                }
                return $data;
            }
        );
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'title' => [ 'required', 'max:100' ],
            'description' => [ 'nullable', 'max:255' ],
            'tc' => [ 'nullable', 'max:255' ],
            'code' => [ 'required', 'max:20' ],
            'min_cart_amount' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'max_cart_amount' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999',  function ($attribute, $value, $fail) {
                $minCartAmount = request()->input('min_cart_amount');
                if ($minCartAmount !== null && $value <= $minCartAmount) {
                    $fail('The max cart amount must be greater than the min cart amount.');
                }
            }],
            'on_which_order' => [ 'required', 'integer' ],
            'discount_amount' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'status' => [ 'required', 'max:20' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'title',  'description', 'tc', 'code',  'min_cart_amount','max_cart_amount','on_which_order',  'discount_amount',  'status','vendor_id']);


            Coupon::create($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Coupon',
                    'text' => 'Something went wrong.',
                ],
            ]);
        }
        DB::commit();
        return response()->json([
            'reset' => true,
            'modal' => [
                'hide' => '#create-form',
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Coupon',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }


    public function show(Coupon $coupon)
    {
        $coupon->vendor_name = $coupon->vendor_id ? Vendor::find($coupon->vendor_id)->name : '';
      return view('backend/coupon/show',compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        $vendors = Vendor::all();

        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/coupon/edit', compact(  'coupon','vendors'))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validator = Validator::make(request()->all(), [
            'title' => [ 'required', 'max:100' ],
            'description' => [ 'nullable', 'max:255' ],
            'tc' => [ 'nullable', 'max:255' ],
            'code' => [ 'required', 'max:20' ],
            'min_cart_amount' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'max_cart_amount' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999',  function ($attribute, $value, $fail) {
                $minCartAmount = request()->input('min_cart_amount');
                if ($minCartAmount !== null && $value <= $minCartAmount) {
                    $fail('The max cart amount must be greater than the min cart amount.');
                }
            } ],
            'on_which_order' => [ 'required', 'integer' ],
            'discount_amount' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'status' => [ 'required', 'max:20' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'title',  'description', 'tc',  'code',  'min_cart_amount','max_cart_amount',  'on_which_order',  'discount_amount',  'status','vendor_id' ]);


            $coupon->update($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Coupon',
                    'text' => 'Something went wrong.',
                ],
            ]);
        }
        DB::commit();
        return response()->json([
            'reset' => true,
            'modal' => [
                'hide' => '#edit-form',
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Coupon',
                'text' => 'Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }

    public function destroy(Coupon $coupon)
    {
        try {
            // $coupon->delete();
            $coupon->update(['status'=>'deleted']);
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Coupon',
                    'text' => 'Coupon can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Coupon',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }
}
