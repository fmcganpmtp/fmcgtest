<?php
namespace App\Http\Controllers;

use App;
use App\DeliverySlot;
use App\VendorDeliverySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Validator;

class VendorAPI2Controller extends Controller
{
    public function contactInformation()
    {
        $authUser = authUser('api');

        $vendor = null;
        if ($authUser->vendors->count() > 0) {
            $vendor = $authUser->vendors[0];
        }

        return response()->json([
            'data' => [
                'contact_informatiom' => Arr::only($vendor->toArray(), ['contact_person', 'primary_contact_number', 'secondary_contact_number']),
                'store_address' => Arr::only($vendor->toArray(), ['address', 'location', 'landmark', 'state', 'district', 'pincode']),
            ],
            'status' => true,
        ]);
    }

    public function contactInformationUpdate(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'contact_person' => ['required', 'max:100'],
            'primary_contact_number' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10'],
            'secondary_contact_number' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10'],
            'address' => ['required', 'max:255'],
            'location' => ['required', 'max:100'],
            'landmark' => ['nullable', 'max:100'],
            'state' => ['required', 'max:100'],
            'district' => ['required', 'max:100'],
            'pincode' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:10'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }

        DB::beginTransaction();
        try {

            $authUser = authUser('api');

            $vendor = null;
            if ($authUser->vendors->count() > 0) {
                $vendor = $authUser->vendors[0];
            }

            $input = $request->only(['contact_person', 'primary_contact_number', 'secondary_contact_number', 'address', 'location', 'landmark', 'state', 'district', 'pincode']);

            if ($vendor) {
                $vendor->update($input);
            }

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }

        DB::commit();

        return response()->json([
            'toast' => __('Contact information updated successfully.'),
            'status' => true,
        ]);
    }

    public function storeLocation()
    {
        $authUser = authUser('api');

        $vendor = null;
        if ($authUser->vendors->count() > 0) {
            $vendor = $authUser->vendors[0];
        }

        return response()->json([
            'data' => [
                'store_location' => Arr::only($vendor->toArray(), ['latitude', 'longitude']),
            ],
            'status' => true,
        ]);
    }

    public function storeLocationUpdate(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'latitude' => ['required', 'max:255'],
            'longitude' => ['required', 'max:100'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }

        DB::beginTransaction();
        try {

            $authUser = authUser('api');

            $vendor = null;
            if ($authUser->vendors->count() > 0) {
                $vendor = $authUser->vendors[0];
            }

            $input = $request->only(['latitude', 'longitude']);

            if ($vendor) {
                $vendor->update($input);
            }

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }

        DB::commit();

        return response()->json([
            'toast' => __('Store location updated successfully.'),
            'status' => true,
        ]);
    }

    public function deliveryDetails()
    {
        $authUser = authUser('api');

        $vendor = null;
        $selected_delivery_slots='';

        if ($authUser->vendors->count() > 0) {
            $vendor = $authUser->vendors[0];
        }
        $deliveryslots = '';
        if ($vendor->scheduled_delivery == '1') {
            $deliveryslots = DeliverySlot::all();
        }
        $vendor_slots = VendorDeliverySlot::where('vendor_id', $vendor->id)->first();
        if ($vendor_slots) {
            $selected_delivery_slots = DeliverySlot::whereIn('id', explode(',', $vendor_slots->slot_ids))->get();
        }

        return response()->json([
            'data' => [
                'delivery_distance' => Arr::only($vendor->toArray(), ['allow_orders_within', 'maximum_weight_to_deliver']),
                'packaging_fee' => $vendor->packaging_fee,
                'minimum_order_amount' => $vendor->min_order_amount,
                'scheduled_delivery' => $vendor->scheduled_delivery,
                'deliveryslots' => $deliveryslots,
                'selected_delivery_slots' => $selected_delivery_slots,
                'delivery_fee' => Arr::only($vendor->toArray(), ['free_delivery_upto', 'delivery_fee_per_km', 'avoide_delivery_fee', 'min_delivery_fee', 'min_delivery_upto_km', 'amount_to_avoid_min_delivery']),
            ],
            'status' => true,
        ]);
    }

    public function deliveryDetailsUpdate(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'allow_orders_within' => ['required', 'lt:9999999.9'],
            'maximum_weight_to_deliver' => ['required', 'lt:9999999.9'],
            'free_delivery_upto' => ['nullable', 'lt:9999999.9'],
            'delivery_fee_per_km' => ['nullable', 'lt:999999999.99'],
            'avoide_delivery_fee' => ['nullable', 'lt:999999999.99'],
            'packaging_fee' => ['nullable', 'lt:999999999.99'],
            'min_order_amount' => ['nullable', 'lt:999999999.99'],
            'min_delivery_fee' => ['nullable', 'lt:999999999.99'],
            'min_delivery_upto_km' => ['nullable', 'lt:999999999.99'],
            'amount_to_avoid_min_delivery' => ['nullable', 'lt:999999999.99'],
            'slot_id' => ['nullable', 'array', 'distinct'],
            "slot_id.*" => ['nullable', 'distinct']

        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false,
            ]);
        }
        $slot_arr = $request->slot_id;
        DB::beginTransaction();
        try {

            $authUser = authUser('api');

            $vendor = null;
            if ($authUser->vendors->count() > 0) {
                $vendor = $authUser->vendors[0];
            }

            $input = $request->only(['allow_orders_within', 'maximum_weight_to_deliver', 'free_delivery_upto', 'delivery_fee_per_km', 'avoide_delivery_fee', 'packaging_fee', 'min_order_amount', 'min_delivery_fee', 'min_delivery_upto_km', 'amount_to_avoid_min_delivery']);

            if (isset($input['free_delivery_upto'])&&$input['free_delivery_upto'] == null) {
                $input['free_delivery_upto'] = '0.0';
            }

            if (isset($input['avoide_delivery_fee'])&&$input['avoide_delivery_fee'] == null) {
                $input['avoide_delivery_fee'] = '0.0';
            }

            if (isset($input['delivery_fee_per_km'])&&$input['delivery_fee_per_km'] == null) {
                $input['delivery_fee_per_km'] = '0.0';
            }

            if ($vendor) {
                $vendor->update($input);
            }
            if (!empty($slot_arr)) {
                $vendor_slot = VendorDeliverySlot::where('vendor_id', $vendor->id)->first();
                if ($vendor_slot) {

                    $slot_ids = $vendor_slot->slot_ids;

                    $slot_ids = explode(',', $slot_ids);

                    foreach ($request->slot_id as $val) {
                        foreach (array_keys($slot_ids, $val) as $key) {
                            unset($slot_ids[$key]);
                        }
                        array_push($slot_ids, $val);
                    }

                    $updated_slot_ids = implode(',', $slot_ids);
                    VendorDeliverySlot::where('vendor_id', $vendor->id)->update(array('slot_ids' => $updated_slot_ids));
                } else {
                    $slot = VendorDeliverySlot::create([
                        'vendor_id' => $vendor->id,
                        'slot_ids' => implode(',', $request->slot_id),

                    ]);
                }
            }

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'toast' => __('Something went wrong.'),
                'status' => false,
            ]);
        }

        DB::commit();

        return response()->json([
            'toast' => __('Delivery details updated successfully.'),
            'status' => true,
        ]);
    }
}
