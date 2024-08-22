<?php

namespace App\Http\Controllers;

use App\HomeBanner;
use App\Vendor;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeBannerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $vendors = Vendor::all();
        return view('backend/home-banner/index', compact('vendors', 'search'));
    }

    function list(HomeBanner $homebanner) {
        $query = $homebanner;
        $query = $query->select(
            'id',
            'image',
            'status',
            'created_at'
        );
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
                        'image' =>"<img src=".asset('uploads/' . $row->image)." class='img-thumbnail custom-file-preview' width='100'/>",
                        'status'=>$row->status,
                        'actions' => view('backend/home-banner/actions', compact('row'))->render(),
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
            'status' => [ 'required'],
            'image' => [ 'nullable', 'file', 'image', 'max: 10240' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $input['status']=$request->status;
        // if($request->hasFile('image')){
        //     $input['image'] = Storage::disk('public')->putFile('home-banner', $request->file('image'));
        // }

        HomeBanner::create($input);
        DB::beginTransaction();
        try {

            if($request->hasFile('image')){
                $input['image'] = Storage::disk('public')->putFile('home-banner', $request->file('image'));
            }

            HomeBanner::create($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'HomeBanner',
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
                'title' => 'HomeBanner',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
    public function edit(HomeBanner $homebanner)
    {
        $vendors = Vendor::all();

        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/home-banner/edit', compact(  'vendors',  'homebanner' ))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }

    public function update(Request $request, HomeBanner $homebanner)
    {
        $validator = Validator::make(request()->all(), [
            'image' => [ 'nullable', 'file', 'image', 'max: 10240' ],

        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $input['status']=$request->status;
        // if($request->hasFile('image')){
        //     $input['image'] = Storage::disk('public')->putFile('home-banner', $request->file('image'));
        //     $homebanner->update($input);

        // }

        DB::beginTransaction();
        try {


            if($request->hasFile('image')){
                $input['image'] = Storage::disk('public')->putFile('home-banner', $request->file('image'));

            }
            $homebanner->update($input);


        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Home Banner',
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
                'title' => 'Home Banner',
                'text' => 'Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }

    public function destroy(HomeBanner $homebanner)
    {
        try {
            $homebanner->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'HomeBanner',
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
                'title' => 'Home Banner',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }

}
