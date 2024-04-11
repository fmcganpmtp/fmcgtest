<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeliveryPartner;
use App\Vendor;
use App\DpAssignedVendor;

use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeliveryPartnerController extends Controller
{
    public function list(Request $request, DeliveryPartner $deliverypartners)
    {
        $query = $deliverypartners;
        $query = $query->select(
            'delivery_partners.id',
            'delivery_partners.name',
            'delivery_partners.mobile',
            'delivery_partners.type',
            'delivery_partners.vehicle_number',
            'delivery_partners.online',
            'delivery_partners.status'
        );

        $data = $this->datatable(
            $query,
            function ($query) use ($request) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('delivery_partners.id', 'LIKE', "%{$search}%");
                    $query->orWhere('delivery_partners.name', 'LIKE', "%{$search}%");
                    $query->orWhere('delivery_partners.mobile', 'LIKE', "%{$search}%");

                }

                if ($request->filled('filter.deliverypartner_type')) {
                    $query->where('delivery_partners.type', $request->input('filter.deliverypartner_type'));
                }
            },
            function ($rows, $totalFiltered, $totalData) {
                $data = [];
                $start = request('start') ?? 0;
                $deliverypartnersDirection = request('delivery_partners.0.dir') ?? 'desc';

                $count = $totalFiltered - $start;
                $start = $start + 1;
                foreach ($rows as $row) {
                    $data[] = [
                    'id' => $deliverypartnersDirection == 'desc' ? $start++ : $count--,
                    'type' => ucfirst($row->type),
                    'name' => $row->name,
                    'mobile' => $row->mobile,
                    'vehicle_number' => $row->vehicle_number,
                    'online_status' => ($row->online == 1 ? 'Online' : 'Offline'),
                    'status' => $row->status,
                    'actions' => view('backend/delivery-partner/actions', compact('row'))->render(),
                    ];
                }
                return $data;
            }
        );
        return response()->json($data);
    }


    public function index(Request $request)
    {
        $search = $request->get('search');
        return view('backend/delivery-partner/index', compact('search'));
    }

    public function create()
    {
        return view('backend/delivery-partner/create');
    }


    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [

            'name' => [ 'required', 'max:150' ],
            'type' => [ 'required', 'max:10' ],
            'mobile' => [ 'required', 'unique:delivery_partners,mobile', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10' ],
            'driving_licence_number' => [ 'required', 'max:150' ],
            'contact_number_1' => [ 'required','regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10' ],
            'contact_number_2' => [ 'required','regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10' ],
            'age' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:100' ],
            'address' => [ 'nullable' ],
            'vehicle_number' => [ 'required', 'max:150' ],
            'vehicle_type' => [ 'required', 'max:150' ],
            'vehicle_model' => [ 'required', 'max:150' ],
            'profile_image' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'aadhar_card' => [ 'nullable', 'file','max:10240', 'mimes:jpeg,png,gif,pdf,doc,docx' ],
            'driving_licence' => [ 'nullable', 'file','max:10240', 'mimes:jpeg,png,gif,pdf,doc,docx' ],
            'rc' => [ 'nullable', 'file','max:10240', 'mimes:jpeg,png,gif,pdf,doc,docx' ],
            'charge_per_km' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'success_delivery_amount' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'weekend_incentive' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'daily_incentive' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'holiday_incentive' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ]

        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        DB::beginTransaction();
        try {
            $input = $request->only([ 'type','name','mobile','driving_licence_number','contact_number_1','contact_number_2','age','address','vehicle_number','vehicle_type','vehicle_model','charge_per_km','success_delivery_amount','weekend_incentive','daily_incentive','holiday_incentive','delivery_area','delivery_latitude','delivery_longitude','delivery_radius']);

            if($request->hasFile('profile_image')) {
                $input['profile_image'] = Storage::disk('public')->putFile('dp-documents', $request->file('profile_image'));
            }
            if($request->hasFile('aadhar_card')) {
                $input['aadhar_card'] = Storage::disk('public')->putFile('dp-documents', $request->file('aadhar_card'));
            }
            if($request->hasFile('driving_licence')) {
                $input['driving_licence'] = Storage::disk('public')->putFile('dp-documents', $request->file('driving_licence'));
            }
            if($request->hasFile('rc')) {
                $input['rc'] = Storage::disk('public')->putFile('dp-documents', $request->file('rc'));
            }
            DeliveryPartner::create($input);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Delivery Partner',
                    'text' => 'Something went wrong.',
                ],
            ]);
        }
        DB::commit();
        return response()->json([
            'reset' => true,
            'alert' => [
                'icon' => 'success',
                'title' => 'Delivery Partner',
                'text' => 'Created successfully.',
                'redirect' => route('deliverypartner'),
            ],
        ]);
    }
    public function show(DeliveryPartner $deliverypartner)
    {
        $assignedvendors = DpAssignedVendor::join('vendors', 'vendors.id', 'dp_assigned_vendors.vendor_id')
        ->where('dp_id', $deliverypartner->id)->get();
        $assignedvendor_ids = $assignedvendors->pluck('id')->toArray();

        $unassignedvendors = Vendor::where('status', 'active')->whereNotIn('id', $assignedvendor_ids)->get();

        return view('backend/delivery-partner/show', compact('deliverypartner', 'unassignedvendors', 'assignedvendors'));
    }


    public function edit(DeliveryPartner $deliverypartner)
    {

        return view('backend/delivery-partner/edit', compact('deliverypartner'));
    }

    public function update(Request $request, DeliveryPartner $deliverypartner)
    {
        $validator = Validator::make(request()->all(), [
            'name' => [ 'required', 'max:150' ],
            'type' => [ 'required', 'max:10' ],
            'mobile' => [ 'required',  'unique:delivery_partners,mobile,' . $deliverypartner->id . ',id', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10' ],
            'driving_licence_number' => [ 'required', 'max:150' ],
            'contact_number_1' => [ 'required','regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10' ],
            'contact_number_2' => [ 'required','regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10' ],
            'age' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:100' ],
            'address' => [ 'nullable' ],
            'vehicle_number' => [ 'required', 'max:150' ],
            'vehicle_type' => [ 'required', 'max:150' ],
            'vehicle_model' => [ 'required', 'max:150' ],
            'profile_image' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'aadhar_card' => [ 'nullable', 'file','max:10240', 'mimes:jpeg,png,gif,pdf,doc,docx'  ],
            'driving_licence' => [ 'nullable', 'file','max:10240', 'mimes:jpeg,png,gif,pdf,doc,docx' ],
            'rc' => [ 'nullable', 'file', 'max:10240', 'mimes:jpeg,png,gif,pdf,doc,docx'  ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }


        DB::beginTransaction();
        try {
            $input = $request->only([ 'type','name','mobile','driving_licence_number','contact_number_1','contact_number_2','age','address','vehicle_number','vehicle_type','vehicle_model','charge_per_km','success_delivery_amount','weekend_incentive','daily_incentive','holiday_incentive','delivery_area','delivery_latitude','delivery_longitude','delivery_radius']);

            if($request->hasFile('profile_image')) {
                $input['profile_image'] = Storage::disk('public')->putFile('dp-documents', $request->file('profile_image'));

            }

            if($request->hasFile('aadhar_card')) {
                $input['aadhar_card'] = Storage::disk('public')->putFile('dp-documents', $request->file('aadhar_card'));
            }

            if($request->hasFile('driving_licence')) {
                $input['driving_licence']  = Storage::disk('public')->putFile('dp-documents', $request->file('driving_licence'));
            }

            if($request->hasFile('rc')) {
                $input['rc'] =  Storage::disk('public')->putFile('dp-documents', $request->file('rc'));
            }

            if($request['remove_profile_image'] != null) {
                ($deliverypartner->profile_image != '') ? Storage::disk('public')->delete($deliverypartner->profile_image) : '';
                $input[ 'profile_image'] =  null;
            }
            if($request['remove_aadhar_card'] != null) {
                ($deliverypartner->aadhar_card != '') ? Storage::disk('public')->delete($deliverypartner->aadhar_card) : '';
                $input[ 'aadhar_card'] = null;
            }
            if($request['remove_driving_licence'] != null) {
                ($deliverypartner->driving_licence != '') ? Storage::disk('public')->delete($deliverypartner->driving_licence) : '';
                $input[ 'driving_licence'] =  null;
            }
            if($request['remove_rc'] != null) {
                ($deliverypartner->rc != '') ? Storage::disk('public')->delete($deliverypartner->rc) : '';
                $input[ 'rc']  = null;
            }
            $deliverypartner->update($input);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Delivery Partner',
                    'text' => 'Something went wrong.',
                ],
            ]);
        }
        DB::commit();
        return response()->json([
            'alert' => [
                'icon' => 'success',
                'title' => 'Delivery Partner',
                'text' => 'Updated successfully.',
                'redirect' => route('deliverypartner'),
            ],
        ]);
    }

    public function destroy(DeliveryPartner $deliverypartner)
    {
        try {
            $deliverypartner->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Deliverypartner',
                    'text' => 'Deliverypartner can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Deliverypartner',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }

    public function ChamgeActiveStatus(Request $request, DeliveryPartner $deliverypartner)
    {
        try {
            $input['status'] = $request->status;
            $status = ($input['status'] == 'active') ? 'Activated' : 'Blocked';
            $deliverypartner->update($input);
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Deliverypartner',
                    'text' => 'Somthing Went Wrong',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Deliverypartner',
                'text' =>  $status.' successfully.',
            ],
        ]);
    }

    public function ChangeOnlineStatus(Request $request, DeliveryPartner $deliverypartner)
    {
        try {
            $input['online'] = $request->status;
            $deliverypartner->update($input);
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Deliverypartner',
                    'text' => 'Somthing Went Wrong',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Deliverypartner',
                'text' =>  'Online Status updated successfully.',
            ],
        ]);
    }

    public function dpVendorAssign(Request $request, DeliveryPartner $deliverypartner)
    {

        $validator = Validator::make(request()->all(), [
            'assign_vendor' => [ 'required', 'max:150' ],

        ]);


        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        try {
            $assign_vendors = $request->assign_vendor;
            foreach($assign_vendors as $assign_vendor) {
                DpAssignedVendor::create([
                    'dp_id'=> $deliverypartner->id,
                    'vendor_id'=> $assign_vendor,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Deliverypartner',
                    'text' => 'Somthing Went Wrong',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Deliverypartner',
                'text' =>  'Vendor Assigned successfully.',
                'redirect' => route('deliverypartner.show', ['deliverypartner' => $deliverypartner->id]),

            ],
        ]);

    }

    public function assignedVendorList($dp_id)
    {

        $dpvendors = DpAssignedVendor::where('dp_id', $dp_id);

        $data = $this->datatable(
            $dpvendors,
            function ($query) {
                $query->select(['vendors.name AS vendor_name']); // Select the vendors.name field with an alias.
                $query->join('vendors', 'vendors.id', '=', 'dp_assigned_vendors.vendor_id');
                // Add any additional conditions or filters here, if needed.

            },
            function ($rows, $totalFiltered, $totalData) {
                $data = [];
                $start = request('start') ?? 0;
                $vendorDirection = request('order.0.dir') ?? 'desc';

                $count = $totalFiltered - $start;
                $start = $start + 1;
                foreach ($rows as $row) {
                    $data[] = [
                        'id' => $vendorDirection == 'desc' ? $start++ : $count--,
                        'name' => Vendor::find($row->vendor_id)->name, // Access the vendor_name alias.
                        'location' => Vendor::find($row->vendor_id)->location, // Access the vendor_name alias.
                        'contact' => Vendor::find($row->vendor_id)->primary_contact_number, // Access the vendor_name alias.


                    ];
                }

                return $data;
            }
        );



        return response()->json($data);
    }

}
