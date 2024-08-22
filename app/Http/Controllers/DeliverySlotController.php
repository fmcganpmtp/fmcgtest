<?php

namespace App\Http\Controllers;
use App\DeliverySlot;
use App\VendorDeliverySlot;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeliverySlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        return view('backend/deliveryslot/index', compact('search' ));
    }

    function list(DeliverySlot $deliveryslot)
    {
        $query = $deliveryslot;
        $query = $query->select(
        'delivery_slots.id',
        'delivery_slots.slot_name',
        'delivery_slots.start',
        'delivery_slots.end'
        );
        $data = $this->datatable(
            $query,
            function ($query) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('delivery_slots.slot_name', 'LIKE', "%{$search}%");

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
                    'slot_name' => $row->slot_name,
                    'start' => $row->start,
                    'end' =>$row->end,
                    'actions' => view('backend/deliveryslot/actions', compact('row'))->render(),
                    ];
                }
                return $data;
            }

        );

        return response()->json($data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'slot_name' => [ 'required', 'max:100','unique:delivery_slots' ],
            'start' => [ 'required' ],
            'end' => [ 'required'],

        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'slot_name','start','end']);


            DeliverySlot::create($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Slot',
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
                'title' => 'Delivery Slot',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliverySlot $deliveryslot)
    {

        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/deliveryslot/edit', compact('deliveryslot' ))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliverySlot $deliveryslot)
    {
        $validator = Validator::make(request()->all(), [
            'slot_name' => [ 'required','unique:delivery_slots,slot_name,'.$deliveryslot->id ],
            'start' => [ 'required' ],
            'end' => [ 'required'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'slot_name','start','end']);


            $deliveryslot->update($input);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliverySlot $deliveryslot)
    {

        if(VendorDeliverySlot::whereRaw("find_in_set('".$deliveryslot->id."',slot_ids)")->exists()){
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Deliveryslot',
                    'text' => 'Delivery slot can\'t be deleted! as it is in use',
                ],
            ]);
        }

            try {
            $deliveryslot->delete();
        } catch (\Exception $e) {

        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Delivery slot',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }
}
