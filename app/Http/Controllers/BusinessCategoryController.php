<?php
namespace App\Http\Controllers;
use Validator;
use App\BusinessCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Menu;

class BusinessCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        return view('backend/business-category/index', compact(  'search'));
    }

    function list(BusinessCategory $businessCategory)
    {
        $query = $businessCategory;
        $query = $query->select(
        'business_categories.id',
        'business_categories.title',
        'business_categories.short_description'
        );
        $data = $this->datatable(
            $query,
            function ($query) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('business_categories.id', 'LIKE', "%{$search}%");
                    $query->orWhere('business_categories.title', 'LIKE', "%{$search}%");
                    $query->orWhere('business_categories.short_description', 'LIKE', "%{$search}%");
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
                    'short_description' => $row->short_description,
                    'image' => $row->image,
                    'actions' => view('backend/business-category/actions', compact('row'))->render(),
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
            'short_description' => [ 'required', 'max:255' ],
            'title_color' => [ 'required', 'max:20' ],
            'short_description_color' => [ 'required', 'max:20' ],
            'bg_color' => [ 'required', 'max:20' ],
            'image' => [ 'nullable', 'file', 'image', 'max: 10240' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'title',  'short_description', 'menu_id', 'title_color',  'short_description_color',  'bg_color',   ]);


            if($request->hasFile('image')){
                $input['image'] = Storage::disk('public')->putFile('business-category', $request->file('image'));
            }

            BusinessCategory::create($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Business Category',
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
                'title' => 'Business Category',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }

    public function edit(BusinessCategory $businessCategory)
    {
        $menus = Menu::where('status','show')->get();
        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/business-category/edit', compact(  'businessCategory', 'menus' ))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }

    public function update(Request $request, BusinessCategory $businessCategory)
    {
        $validator = Validator::make(request()->all(), [
            'title' => [ 'required', 'max:100' ],
            'short_description' => [ 'required', 'max:255' ],
            'title_color' => [ 'required', 'max:20' ],
            'short_description_color' => [ 'required', 'max:20' ],
            'bg_color' => [ 'required', 'max:20' ],
            'image' => [ 'nullable', 'file', 'image', 'max: 10240' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'title',  'short_description', 'menu_id',  'title_color',  'short_description_color',  'bg_color',   ]);


            if($request->hasFile('image')){
                $input['image'] = Storage::disk('public')->putFile('business-category', $request->file('image'));
            }

            $businessCategory->update($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Business Category',
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
                'title' => 'Business Category',
                'text' => 'Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }

    public function destroy(BusinessCategory $businessCategory)
    {
        try {
            $businessCategory->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Business Category',
                    'text' => 'Business Category can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Business Category',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }
}
