<?php 
namespace App\Http\Controllers;
use Validator;
use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
 
class BrandController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        return view('backend/brand/index', compact(  'search' ));
    }
 
    function list(Brand $brand) 
    {
        $query = $brand;
        $query = $query->select(
        'brands.id',     
        'brands.name',     
        'brands.image'    
        );
        $data = $this->datatable(
            $query,
            function ($query) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('brands.id', 'LIKE', "%{$search}%");  
                    $query->orWhere('brands.name', 'LIKE', "%{$search}%");  
                    $query->orWhere('brands.image', 'LIKE', "%{$search}%");  
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
                    'actions' => view('backend/brand/actions', compact('row'))->render(),
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
        ]);
 
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
 
        DB::beginTransaction();
        try {
            $input = $request->only([ 'name',   ]);
 
              
            if($request->hasFile('image')){ 
                $input['image'] = Storage::disk('public')->putFile('brand', $request->file('image'));
            }
 
            Brand::create($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Brand',
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
                'title' => 'Brand',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
 
    public function edit(Brand $brand)
    {
 
        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/brand/edit', compact(  'brand' ))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }
 
    public function update(Request $request, Brand $brand)
    {
        $validator = Validator::make(request()->all(), [
            'name' => [ 'required', 'max:100' ],
            'image' => [ 'nullable', 'file', 'image', 'max: 10240' ],
        ]);
 
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
 
        DB::beginTransaction();
        try {
            $input = $request->only([ 'name',   ]);
 
              
            if($request->hasFile('image')){ 
                $input['image'] = Storage::disk('public')->putFile('brand', $request->file('image'));
            }
 
            $brand->update($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Brand',
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
                'title' => 'Brand',
                'text' => 'Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
 
    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Brand',
                    'text' => 'Brand can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Brand',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }
}
