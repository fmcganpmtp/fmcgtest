<?php 
namespace App\Http\Controllers;
use Validator;
use App\Variant;
use App\Attribute;
use App\AttributeVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
 
class AttributeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $variants = Variant::all();
        return view('backend/attribute/index', compact(  'search', 'variants' ));
    }
 
    function list(Attribute $attribute) 
    {
        $query = $attribute;
        $query = $query->select(
        'attributes.id',     
        'attributes.name'    
        );
        $data = $this->datatable(
            $query,
            function ($query) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('attributes.name', 'LIKE', "%{$search}%");  
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
                    'actions' => view('backend/attribute/actions', compact('row'))->render(),
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
            'variants' => [ 'required', 'array' ],
            'variants.*' => ['integer']
        ]);
 
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
 
 
        DB::beginTransaction();
        try {
            $input = $request->only([ 'name' ]);

            $attribute = Attribute::create($input);
 
            foreach($request->variants as $variant){
                AttributeVariant::create([
                    'attribute_id' => $attribute->id,
                    'variant_id' => $variant
                ]);
            }

        } catch (\Exception $e) {
            DB::rollback();
 
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Attribute',
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
                'title' => 'Attribute',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
 
    public function edit(Attribute $attribute)
    {
        $variants = Variant::all();
 
        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/attribute/edit', compact(  'attribute', 'variants' ))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }
 
    public function update(Request $request, Attribute $attribute)
    {
        $validator = Validator::make(request()->all(), [
            'name' => [ 'required', 'max:100' ],
        ]);
 
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
 
        DB::beginTransaction();
        try {
            $input = $request->only([ 'name']);
 
            $deleteIds = array_diff($attribute->variants->pluck('id')->all(), $request->variants);
 
            AttributeVariant::whereIn('variant_id', $deleteIds)->where('attribute_id', $attribute->id)->delete();
 
            foreach($request->variants as $variant){
                
                if( !in_array( $variant, $attribute->variants->pluck('id')->all() ) ){
                    AttributeVariant::create([
                        'attribute_id' => $attribute->id,
                        'variant_id' => $variant
                    ]);
                }
            }
 
            $attribute->update($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Attribute',
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
                'title' => 'Attribute',
                'text' => 'Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
 
    public function destroy(Attribute $attribute)
    {
        try {
            $attribute->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Attribute',
                    'text' => 'Attribute can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Attribute',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }
}
