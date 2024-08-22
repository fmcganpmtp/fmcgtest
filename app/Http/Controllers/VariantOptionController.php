<?php 
namespace App\Http\Controllers;
use Validator;
use App\VariantOption;
use App\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
 
class VariantOptionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $variants = Variant::all();
        return view('backend/variant-option/index', compact(  'variants',  'search' ));
    }
 
    function list(VariantOption $variantOption) 
    {
        $query = $variantOption;
        $query = $query->select(
        'variants.name as variant_name', 
        'variant_options.id',     
        'variant_options.value'    
        );
        $query = $query->leftJoin('variants', 'variants.id', '=', 'variant_options.variant_id');
        $data = $this->datatable(
            $query,
            function ($query) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('variant_options.id', 'LIKE', "%{$search}%");  
                    $query->orWhere('variant_options.value', 'LIKE', "%{$search}%");  
                    $query->orWhere('variants.name', 'LIKE', "%{$search}%");  
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
                    'value' => $row->value,
                    'variant_name' => $row->variant_name,
                    'actions' => view('backend/variant-option/actions', compact('row'))->render(),
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
            'variant_id' => [ 'required', 'integer' ],
            'value' => [ 'required', 'max:100' ],
        ]);
 
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
 
        DB::beginTransaction();
        try {
            $input = $request->only([ 'variant_id',  'value',  ]);
 
   
            VariantOption::create($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Variant Option',
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
                'title' => 'Variant Option',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
 
    public function edit(VariantOption $variantOption)
    {
        $variants = Variant::all();
 
        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/variant-option/edit', compact(  'variants',  'variantOption' ))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }
 
    public function update(Request $request, VariantOption $variantOption)
    {
        $validator = Validator::make(request()->all(), [
            'variant_id' => [ 'required', 'integer' ],
            'value' => [ 'required', 'max:100' ],
        ]);
 
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
 
        DB::beginTransaction();
        try {
            $input = $request->only([ 'variant_id',  'value',  ]);
 
   
            $variantOption->update($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Variant Option',
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
                'title' => 'Variant Option',
                'text' => 'Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
 
    public function destroy(VariantOption $variantOption)
    {
        try {
            $variantOption->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Variant Option',
                    'text' => 'Variant Option can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Variant Option',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }
}
