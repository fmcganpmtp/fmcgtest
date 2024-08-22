<?php 
namespace App\Http\Controllers;
use Validator;
use App\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
 
class VariantController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        return view('backend/variant/index', compact(  'search' ));
    }
 
    function list(Variant $variant) 
    {
        $query = $variant;
        $query = $query->select(
        'variants.id',     
        'variants.name'    
        );
        $data = $this->datatable(
            $query,
            function ($query) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('variants.id', 'LIKE', "%{$search}%");  
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
                    'name' => $row->name,
                    'actions' => view('backend/variant/actions', compact('row'))->render(),
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
        ]);
 
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
 
        DB::beginTransaction();
        try {
            $input = $request->only([ 'name',  ]);
 
  
            Variant::create($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Variant',
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
                'title' => 'Variant',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
 
    public function edit(Variant $variant)
    {
 
        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/variant/edit', compact(  'variant' ))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }
 
    public function update(Request $request, Variant $variant)
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
            $input = $request->only([ 'name',  ]);
 
  
            $variant->update($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Variant',
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
                'title' => 'Variant',
                'text' => 'Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
 
    public function destroy(Variant $variant)
    {
        try {
            $variant->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Variant',
                    'text' => 'Variant can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Variant',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }
}
