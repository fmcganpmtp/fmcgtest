<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class PermissionController extends Controller
{
    public function index()
    {

        $roles = Role::where('type', 'private')
        // ->where('created_by', 'system')
        ->get();
        $permissions = permissions();

        return view('backend/permission/index', compact('roles', 'permissions'));
    }

    public function edit()
    {

        $validator = Validator::make(request()->all(), [
            'value' => ['required', 'integer'],
        ]);

        $data = [];

        if ($validator->passes()) {
            $id = request()->input('value');

            $role = Role::findOrFail($id);
            $permissions = Permission::select('permission')->where('role_id', $role->id)->get();

            foreach ($permissions as $key => $permission) {
                $data[] = $permission->permission;
            }
        }

        $permissions = permissions();

        return response()->json([
            'jquery' => [
                [
                    'element' => '#permissions',
                    'method' => 'html',
                    'value' => view('backend/permission/view', compact('data', 'permissions'))->render(),
                ],
            ],
            'init' => ['#permissions'],
        ]);
    }

    public function update()
    {
        $validator = Validator::make(request()->all(), [
            'role_id' => ['required'],
            'permissions' => ['required'],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $input = request(['role_id', 'permissions']);

        $role = Role::findOrFail($input['role_id']);

        DB::beginTransaction();

        try {

            Permission::where('role_id', $role->id)->delete();

            foreach ($input['permissions'] as $permission) {
                Permission::create(['role_id' => $role->id, 'permission' => $permission]);
            }

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Permissions',
                    'title' => 'Something went wrong.',
                ],
            ]);
        }

        DB::commit();

        Cache::forget('permissions');

        $user = authUser();

        $response = [
            'alert' => [
                'icon' => 'success',
                'title' => 'Permissions',
                'text' => 'Updated successfully.',
            ],
        ];

        if ($user->role->id == $role->id) {
            $response['alert']['redirect'] = route('permission');
        }

        return response()->json($response);

    }
}
