<?php
namespace App\Http\Controllers;
use Validator;
use App\User;
use App\Role;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use App\Address;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $roles = Role::all();
        return view('backend/user/index', compact(  'roles',  'search' ));
    }

    function list(User $user)
    {
        $query = $user;
        $query = $query->select(
        'users.id',
        'users.doj',
        'users.name',
        'users.id as undelivered_orders',
        'users.mobile',
        'users.email',
        'roles.name as role_name',
        'users.status'
        );
        $query = $query->leftJoin('roles', 'roles.id', '=', 'users.role_id');
        $query = $query->leftJoin('vendor_users', 'vendor_users.user_id', '=', 'users.id');
        $query = $query->leftJoin('vendors', 'vendors.id', '=', 'vendor_users.vendor_id');
        $query = $query->where('roles.name','Developer');
        $data = $this->datatable(
            $query,
            function ($query) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('roles.name', 'LIKE', "%{$search}%");
                    $query->orWhere('users.name', 'LIKE', "%{$search}%");
                    $query->orWhere('users.email', 'LIKE', "%{$search}%");
                    $query->orWhere('users.mobile', 'LIKE', "%{$search}%");
                    $query->orWhere('users.status', 'LIKE', "%{$search}%");
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
                    'doj' => $row->doj == null ? '' : Carbon::parse( $row->doj )->format('d-m-Y'),
                    'name' => $row->name,
                    'mobile' => $row->mobile,
                    'email' => $row->email,
                    'role_name' => $row->role_name,
                    'undelivered_orders' => $row->undeliveredOrders()->count(),
                    'status' => ucwords( $row->status ),
                    'actions' => view('backend/user/actions', compact('row'))->render(),
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
            'role_id' => [ 'required', 'integer' ],
            'mobile' => [ 'required', 'unique:users,mobile', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10' ],
            'email' => [ 'nullable', 'email', 'max:100' ],
            'password' => [ 'nullable', 'min:6' ],
            'status' => [ 'required', 'max:10' ],
        ]);

        $validator->setAttributeNames([
            'mobile' => 'Mobile Number',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'name', 'email', 'mobile', 'username', 'role_id',  'status']);

            $input['password'] = Hash::make($request->password);

            $input['doj'] = Carbon::now();

            $input['mobile_verified'] = true;

            if($input['email'] != ''){
                $input['email_verified'] = true;
            }

            User::create($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'User',
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
                'title' => 'User',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/user/edit', compact(  'roles',  'user' ))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make(request()->all(), [
            'name' => [ 'required', 'max:100' ],
            'role_id' => [ 'required', 'integer' ],
            'mobile' => [ 'required',  'unique:users,mobile,' . $user->id . ',id', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10' ],

            'email' => [ 'nullable', 'email', 'max:100' ],
            'password' => [ 'nullable', 'min:6' ],
            'status' => [ 'required', 'max:10' ],
        ]);

        $validator->setAttributeNames([
            'mobile' => 'Mobile Number',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'name', 'email', 'mobile', 'role_id',  'status']);

            if($request->password){
                $input['password'] = Hash::make($request->password);
            }

            if($input['email'] != ''){
                if($input['role_id'] != 1){
                    $input['email_verified'] = true;
                }
            }

            $user->update($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'User',
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
                'title' => 'User',
                'text' => 'Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'User',
                    'text' => 'User can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'User',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }

    public function profile(Request $request)
    {
        $user = authUser();
        return view('backend/user/profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => [ 'required', 'max:100' ],
            'email' => [ 'nullable', 'email', 'max:100' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'name',  'email']);

            $user = authUser();
            $user->update($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'errors' => [
                    'name' => 'Something went wrong.',
                ],
            ]);
        }
        DB::commit();
        return response()->json([
            'alert' => [
                'icon' => 'success',
                'title' => 'User',
                'text' => 'Updated successfully.',
            ],
        ]);
    }


    public function changePassword(Request $request)
    {
        return view('backend/user/change-password');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'current-password' => [ 'required', 'min:6', new MatchOldPassword ],
            'password' => [ 'required', 'min:6' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $user = authUser();

            $user->update(['password' => Hash::make($request->password)]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'errors' => [
                    'current-password' => 'Something went wrong.',
                ],
            ]);
        }
        DB::commit();

        return response()->json([
            'alert' => [
                'icon' => 'success',
                'title' => 'User',
                'text' => 'Updated successfully.',
            ],
        ]);
    }


    public function address(User $user)
    {
        $getAddress = $user->address()->get();
        $role=$user->role()->first();

        $user->role=($role)?$role->name:'';
        //$getAddress = Address::where('user_id',$user->id);
        return view('backend/user/address', compact('getAddress', 'user'));
    }
}
