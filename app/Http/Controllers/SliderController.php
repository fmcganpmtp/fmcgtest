<?php
namespace App\Http\Controllers;
use Validator;
use App\Slider;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $vendors = Vendor::all();
        return view('backend/slider/index', compact(  'vendors',  'search' ));
    }

    function list(Slider $slider)
{
        $query = $slider;
        $query = $query->select(
        'vendors.name as vendor_name',
        'sliders.id',
        'sliders.name',
        'sliders.image'
        );
        $query = $query->leftJoin('vendors', 'vendors.id', '=', 'sliders.vendor_id');
        $data = $this->datatable(
            $query,
            function ($query) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('sliders.id', 'LIKE', "%{$search}%");
                    $query->orWhere('sliders.name', 'LIKE', "%{$search}%");
                    $query->orWhere('sliders.image', 'LIKE', "%{$search}%");
                    $query->orWhere('vendors.name', 'LIKE', "%{$search}%");
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
                    'image' => $row->image,
                    'vendor_name' => $row->vendor_name,
                    'actions' => view('backend/slider/actions', compact('row'))->render(),
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
            'name' => [ 'required', 'max:100' ],
            'image' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'vendor_id' => [ 'required', 'integer' ],
            'priority' => [ 'required', 'integer' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'name',   'vendor_id',  'priority',  ]);


            if($request->hasFile('image')){
                $input['image'] = Storage::disk('public')->putFile('slider', $request->file('image'));
            }

            Slider::create($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Slider',
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
                'title' => 'Slider',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }

    public function edit(Slider $slider)
    {
        $vendors = Vendor::all();

        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/slider/edit', compact(  'vendors',  'slider' ))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }

    public function update(Request $request, Slider $slider)
    {
        $validator = Validator::make(request()->all(), [
            'name' => [ 'required', 'max:100' ],
            'image' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'vendor_id' => [ 'required', 'integer' ],
            'priority' => [ 'required', 'integer' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'name',   'vendor_id',  'priority',  ]);


            if($request->hasFile('image')){
                $input['image'] = Storage::disk('public')->putFile('slider', $request->file('image'));
            }

            $slider->update($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Slider',
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
                'title' => 'Slider',
                'text' => 'Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }

    public function destroy(Slider $slider)
    {
        try {
            $slider->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Slider',
                    'text' => 'Slider can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Slider',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }
}
