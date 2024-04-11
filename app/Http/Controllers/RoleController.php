<?php 
namespace App\Http\Controllers;
use Validator;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
 
class RoleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        return view('backend/role/index', compact(  'search' ));
    }
 
    function list(Role $role) 
    {
        $query = $role;
        $query = $query->select(
        'roles.id',     
        'roles.name',     
        'roles.type',     
        'roles.created_by'    
        );
        $data = $this->datatable(
            $query,
            function ($query) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('roles.name', 'LIKE', "%{$search}%");  
                    $query->orWhere('roles.type', 'LIKE', "%{$search}%");  
                    $query->orWhere('roles.created_by', 'LIKE', "%{$search}%");  
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
                    'type' => ucwords( $row->type ),
                    'created_by' => ucwords( $row->created_by ),
                    'actions' => view('backend/role/actions', compact('row'))->render(),
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
            $input = $request->only([ 'name']);
            
            $input['type'] = 'private';

            Role::create($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Role',
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
                'title' => 'Role',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
 
    public function edit(Role $role)
    {
 
        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/role/edit', compact(  'role' ))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }
 
    public function update(Request $request, Role $role)
    {
        $validator = Validator::make(request()->all(), [
            'name' => [ 'required', 'max:100' ],
        ]);
 
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }


        if($role->created_by == 'system'){
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Role',
                    'title' => 'System role can\'t edit.',
                ],
            ]);
        }
 
        DB::beginTransaction();
        try {
            $input = $request->only([ 'name']);
 
    
            $role->update($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Role',
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
                'title' => 'Role',
                'text' => 'Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
 
    public function destroy(Role $role)
    {

        
        if($role->created_by == 'system'){
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Role',
                    'title' => 'System role can\'t edit.',
                ],
            ]);
        }
        
        try {
            $role->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Role',
                    'text' => 'Role can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Role',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }
}
