<?php

namespace App\Http\Controllers;

use Validator;
use App\Vendor;
use App\Order;
use App\VendorBankDetail;
use App\VendorUser;

use App\Exports\VendorOrderExport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        return view('backend/vendor/index', compact('search'));
    }

    public function list(Request $request, Vendor $vendor)
    {
        $query = $vendor;
        $query = $query->select(
            'vendors.id',
            'vendors.name',
            'vendors.gst_number',
            'vendors.location',
            'vendors.state',
            'vendors.district',
            'vendors.contact_person',
            'vendors.primary_contact_number',
            'vendors.doa',
            'vendors.id as tdo',
            'vendors.status',
            'vendors.commission_percentage',
            'vendors.is_grofirst_vendor'

        );
        $data = $this->datatable(
            $query,
            function ($query) use ($request) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('vendors.id', 'LIKE', "%{$search}%");
                    $query->orWhere('vendors.name', 'LIKE', "%{$search}%");
                    $query->orWhere('vendors.gst_number', 'LIKE', "%{$search}%");
                    $query->orWhere('vendors.fssai_number', 'LIKE', "%{$search}%");
                    $query->orWhere('vendors.contact_person', 'LIKE', "%{$search}%");
                    $query->orWhere('vendors.primary_contact_number', 'LIKE', "%{$search}%");
                    $query->orWhere('vendors.secondary_contact_number', 'LIKE', "%{$search}%");
                    $query->orWhere('vendors.location', 'LIKE', "%{$search}%");
                    $query->orWhere('vendors.state', 'LIKE', "%{$search}%");
                    $query->orWhere('vendors.district', 'LIKE', "%{$search}%");
                    $query->orWhere('vendors.status', 'LIKE', "%{$search}%");
                }

                if ($request->filled('filter.vendor_status')) {
                    $query->where('vendors.status', $request->input('filter.vendor_status'));
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
                    'name' => $row->name,
                    'gst_number' => $row->gst_number,
                    'contact_person' => $row->contact_person,
                    'primary_contact_number' => $row->primary_contact_number,
                    'doa' => $row->doa,
                    'location' => $row->location,
                    'state' => $row->state,
                    'district' => $row->district,
                    'tdo' => $row->orders()->count(),
                    'status' => $row->status,
                    'vendor_type' => ($row->is_grofirst_vendor=='true')?'Grofirst':'Guest',

                    'actions' => view('backend/vendor/actions', compact('row'))->render(),
                    ];
                }
                return $data;
            }
        );
        return response()->json($data);
    }

    public function show(Vendor $vendor)
    {
        $vendor_bank=VendorBankDetail::where('vendor_id', $vendor->id)->first();
        $totalRevenue = Order::select(DB::raw('SUM((orders.final_amount * '.$vendor->commission_percentage.')/100) as total_revenue'), DB::raw('SUM(orders.final_amount) as total_sale_amount'))
       ->where('orders.vendor_id', $vendor->id)
       ->where('orders.status', 'delivered')
       ->first();
        $vendor->total_revenue=$totalRevenue->total_revenue;
        $vendor->total_sale_amount=$totalRevenue->total_sale_amount;
        $user=VendorUser::join('users','users.id','vendor_users.user_id')
        ->where('vendor_users.vendor_id',$vendor->id)->first();
        $vendor->mobile=($user)?$user->mobile:'';
        // $vendor=$vendor->select('vendors.*','users.mobile')
        // ->join('vendor_users','vendor_users.vendor_id','vendors.id')
        // ->join('users','users.id','vendor_users.user_id')
        // ->where('vendor_id',$vendor->id)
        // ->first();
        // dd($vendor);

        // $order = Order::select('orders.*','users.name as user_name','vendors.name as vendor_name')
        // ->join('vendors','vendors.id','orders.vendor_id')
        // ->leftjoin('users','users.id','orders.assign_user_id')
        // ->where('orders.id',$vendor->id)->first();
        return view('backend/vendor/show', compact('vendor', 'vendor_bank'));
    }


    public function update_status(Vendor $vendor, $status=null)
    {
        DB::beginTransaction();
        try {
            $input['status']=$status;
            $vendor->update($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Vendor',
                    'text' => 'Something went wrong.',
                ],
            ]);
        }
        DB::commit();

        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Vendor',
                'text' => $status.' successfully.',
            ],
        ]);


    }

    public function update_mainlogo(Vendor $vendor, Request $request)
    {

        $validator = Validator::make(request()->all(), [
            // 'name' => [ 'required', 'max:100' ],
            'main-logo' => [ 'nullable', 'file', 'image', 'max: 10240' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        DB::beginTransaction();
        try {

            if($request->hasFile('main-logo')) {
                $input['main_logo'] = Storage::disk('public')->putFile('logos', $request->file('main-logo'));
                $vendor->update($input);

            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Vendor',
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
                'title' => 'Vendor',
                'text' => 'Main Logo Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);


    }
    public function vendorOrderList(Vendor $vendor, Request $request)
    {
        $order = new Order();
        $total=Order::where('vendor_id', $vendor->id);
        $query = $order;
        $query = $query->select(
            'orders.id',
            'orders.id as order_id',
            'orders.created_at as date_time',
            'users.name as user_name',
            'users.id as user_id',
            'orders.final_amount',
            'vendors.name as vendor_name',
            'vendors.location as vendor_location',
            'orders.status',
            'orders.payment_status',
        );
        $query = $query->leftJoin('users', 'users.id', '=', 'orders.user_id');
        $query = $query->leftJoin('vendors', 'vendors.id', '=', 'orders.vendor_id');
        $data = $this->datatable(
            $query,
            function ($query) use ($request, $vendor) {
                $search = request('search.value') ?? '';
                $query->orWhere('vendor_id', $vendor->id);
                if (!empty($search)) {
                    $query->orWhere('vendors.name', 'LIKE', "%{$search}%");
                    $query->orWhere('vendors.location', 'LIKE', "%{$search}%");
                    $query->orWhere('users.name', 'LIKE', "%{$search}%");
                    $query->orWhere('users.mobile', 'LIKE', "%{$search}%");
                    $query->orWhere('orders.delivery_phone', 'LIKE', "%{$search}%");
                    $query->orWhere('orders.id', 'LIKE', "%{$search}%");
                }
                if ($request->filled('filter.type')) {
                    $selectedType = $request->input('filter.type');

                    if ($selectedType == 'today') {
                        $date = Carbon::now()->format('Y-m-d');
                        $query->whereDate('orders.created_at', $date);
                    } elseif ($selectedType == 'week') {
                        $startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
                        $endDate = Carbon::now()->endOfWeek()->format('Y-m-d');

                        $query->whereDate('orders.created_at', '>=', $startDate)
                        ->whereDate('orders.created_at', '<=', $endDate);
                    } elseif ($selectedType == 'month') {
                        $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                        $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
                        $query->whereDate('orders.created_at', '>=', $startDate)
                        ->whereDate('orders.created_at', '<=', $endDate);

                    } elseif ($selectedType == 'date-range') {
                        $startDate = $request->input('filter.date_from');
                        $endDate = $request->input('filter.date_to');
                        if ($startDate && $endDate) {
                            $startDate = Carbon::parse($startDate)->format('Y-m-d');
                            $endDate = Carbon::parse($endDate)->format('Y-m-d');
                            $query->whereDate('orders.created_at', '>=', $startDate)
                            ->whereDate('orders.created_at', '<=', $endDate);
                        } elseif ($startDate) {
                            $startDate = Carbon::parse($startDate)->format('Y-m-d');
                            $query->whereDate('orders.created_at', '>=', $startDate);
                        } elseif ($endDate) {
                            $endDate = Carbon::parse($endDate)->format('Y-m-d');
                            $query->whereDate('orders.created_at', '<=', $endDate);
                        }
                    }
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
            function ($rows, $totalFiltered, $total) {

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
                        Order::where('id', $row->id)->where('status', 'ordered')->update(['status'=>'expired']);

                    }
                    $data[] = [
                    'id' => $order == 'desc' ? $start++ : $count--,
                    'date_time' => Carbon::parse($row->date_time)->format('Y-m-d / h:i:A'),
                    'order_id' => $row->order_id,
                    'user_name' => $row->user_name,
                    'user_id' => $row->user_id,
                    'final_amount' => $row->final_amount,
                    'vendor_name' => $row->vendor_name,
                    'vendor_location' => $row->vendor_location,
                    'status' => $row->status .(($row->status=='ordered'&&$row->confirmation_time!='') ? '<div class="text-danger"> Expired with in '.$row->confirmation_time.'</div><div class="text-danger"> Expired Time :'.date('Y-m-d / h:i:A', $post_time).'</div>' : ''),
                    'payment_status' => $row->payment_status,
                    // 'actions' => view('backend/order/actions', compact('row'))->render(),
                    ];
                }
                return $data;
            }
        );
        return response()->json($data);
    }
    public function update_bank_details(Vendor $vendor, Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'account_number' => [ 'required', 'max:255'],
            'ifsc_code' => [ 'required', 'max:255' ],
            'bank_name' => [ 'required', 'max:255' ],
            'account_holder_name' => [ 'required', 'max:255' ],
            // 'file' => [ 'required', 'max:255' ],
            'file' => ['nullable', 'file', 'image', 'max: 10240'],

        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'account_number','ifsc_code','bank_name','account_holder_name']);
            $input['vendor_id']=$vendor->id;
            if($request->hasFile('file')) {
                $input['file'] = Storage::disk('public')->putFile('vendor/' . $vendor->id . '/' . 'bank-document/', $request->file('file'));

            }
            $bank_data=VendorBankDetail::where('vendor_id', $vendor->id)->first();
            if($bank_data) {
                $bank_data->update($input);

            } else {
                VendorBankDetail::create($input);
            }

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Vendor',
                    'text' => 'Something went wrong.',
                ],
            ]);
        }
        DB::commit();
        return response()->json([
            'alert' => [
                'icon' => 'success',
                'title' => 'Vendor',
                'text' => 'Bank Details Updated successfully.',
            ],
        ]);


    }
    public function update_commission_percentage(Vendor $vendor, Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'commission_percentage' => [ 'required','numeric','between:0,100'],

        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        DB::beginTransaction();
        try {
            $input=$request->only(['commission_percentage']);
            $vendor->update($input);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Vendor',
                    'text' => 'Something went wrong.',
                ],
            ]);
        }
        DB::commit();

        return response()->json([
            'alert' => [
                'icon' => 'success',
                'title' => 'Vendor',
                'text' => 'Commission Percentage Updated successfully.',
                'redirect' => back()->getTargetUrl(),
            ],
        ]);

    }

    public function vendor_revenue(Request $request)
    {
        $selectedType = $request->input('type');
        $vendor_id = $request->input('vendor_id');
        $vendor = Vendor::find($vendor_id);

        $totalRevenue = Order::select(DB::raw('SUM((orders.final_amount * '.$vendor->commission_percentage.')/100) as total_revenue'), DB::raw('SUM(orders.final_amount) as total_sale'));

        if ($selectedType == 'today') {
            $date = Carbon::now()->format('Y-m-d');
            $totalRevenue->whereDate('orders.created_at', $date);
        } elseif ($selectedType == 'week') {
            $startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
            $endDate = Carbon::now()->endOfWeek()->format('Y-m-d');
            // $totalRevenue->whereBetween('orders.created_at', [$startDate, $endDate]);
            // $startDate = Carbon::now()->subDays(7)->format('Y-m-d');
            // $endDate = Carbon::now()->format('Y-m-d');
            $totalRevenue->whereDate('orders.created_at', '>=', $startDate)
            ->whereDate('orders.created_at', '<=', $endDate);
        } elseif ($selectedType == 'month') {
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
            // $totalRevenue->whereBetween('orders.created_at', [$startDate, $endDate]);
            $totalRevenue->whereDate('orders.created_at', '>=', $startDate)
            ->whereDate('orders.created_at', '<=', $endDate);

        } elseif ($selectedType == 'date-range') {
            $startDate = $request->input('date_from');
            $endDate = $request->input('date_to');
            if ($startDate && $endDate) {
                $startDate = Carbon::parse($startDate)->format('Y-m-d');
                $endDate = Carbon::parse($endDate)->format('Y-m-d');
                // $totalRevenue->whereBetween('orders.created_at', [$startDate, $endDate]);
                $totalRevenue->whereDate('orders.created_at', '>=', $startDate)
                ->whereDate('orders.created_at', '<=', $endDate);
            } elseif ($startDate) {
                $startDate = Carbon::parse($startDate)->format('Y-m-d');
                $totalRevenue->whereDate('orders.created_at', '>=', $startDate);
            } elseif ($endDate) {
                $endDate = Carbon::parse($endDate)->format('Y-m-d');
                $totalRevenue->whereDate('orders.created_at', '<=', $endDate);
            }
        }


        $totalRevenue = $totalRevenue->where('orders.vendor_id', $vendor_id)->where('orders.status', 'delivered')->first();
        $totalRevenue->total_revenue =($totalRevenue->total_revenue)??0;
        $totalRevenue->total_sale =($totalRevenue->total_sale)??0;


        return response()->json([
            'totalRevenue' => 'Rs '.$totalRevenue->total_revenue,
            'totalSale' => 'Rs '.$totalRevenue->total_sale,

        ]);

    }

    public function orderExport(Request $request)
    {

        $selectedType = $request->type;
        $vendorID = $request->vendor_id;

        $query=Order::select(
            'orders.id',
            'orders.id as order_id',
            'orders.created_at as date_time',
            'users.name as user_name',
            'users.id as user_id',
            'orders.final_amount',
            'vendors.name as vendor_name',
            'vendors.location as vendor_location',
            'orders.status',
            'orders.payment_status',
        )->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->leftJoin('vendors', 'vendors.id', '=', 'orders.vendor_id');
        if ($request->type!='all') {

            if ($selectedType == 'today') {
                $date = Carbon::now()->format('Y-m-d');
                $query->whereDate('orders.created_at', $date);
            } elseif ($selectedType == 'week') {
                $startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
                $endDate = Carbon::now()->endOfWeek()->format('Y-m-d');

                $query->whereDate('orders.created_at', '>=', $startDate)
                ->whereDate('orders.created_at', '<=', $endDate);
            } elseif ($selectedType == 'month') {
                $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
                $query->whereDate('orders.created_at', '>=', $startDate)
                ->whereDate('orders.created_at', '<=', $endDate);

            } elseif ($selectedType == 'date-range') {
                $startDate = $request->input('date_from');
                $endDate = $request->input('date_to');
                if ($startDate && $endDate) {
                    $startDate = Carbon::parse($startDate)->format('Y-m-d');
                    $endDate = Carbon::parse($endDate)->format('Y-m-d');
                    $query->whereDate('orders.created_at', '>=', $startDate)
                    ->whereDate('orders.created_at', '<=', $endDate);
                } elseif ($startDate) {
                    $startDate = Carbon::parse($startDate)->format('Y-m-d');
                    $query->whereDate('orders.created_at', '>=', $startDate);
                } elseif ($endDate) {
                    $endDate = Carbon::parse($endDate)->format('Y-m-d');
                    $query->whereDate('orders.created_at', '<=', $endDate);
                }
            }
        }
        $orders = $query->where('orders.vendor_id', $vendorID)->orderBy('orders.created_at', 'DESC')->get();

        // $filePath = storage_path('framework\cache\laravel-excel\laravel-excel-5nIUp1j6cgzjGnf2jAMskIHgt0OaR4TV.xlsx');
        $ex= Excel::download(new VendorOrderExport($orders), 'vendor_orders_export.xlsx');
        $filePath = $ex->getFile()->getPathname();
        return Response::download($filePath, 'vendor_orders_export.xlsx');

        exit;
    }

    public function update_vendor_type(Vendor $vendor){

        DB::beginTransaction();
        try {
            $update_vendor_type=($vendor->is_grofirst_vendor=='true')?'false':'true';
            $input['is_grofirst_vendor']= $update_vendor_type;
            $vendor->update($input);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Vendor',
                    'text' => 'Something went wrong.',
                ],
            ]);
        }
        DB::commit();

        return response()->json([
            'alert' => [
                'icon' => 'success',
                'title' => 'Vendor',
                'text' => 'Vendor Type Updated successfully.',
            ],
        ]);

    }


}
