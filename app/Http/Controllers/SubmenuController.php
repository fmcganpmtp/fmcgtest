<?php

namespace App\Http\Controllers;

use Validator;
use App\Submenu;
use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\VendorSubmenu;
use App\VendorProduct;
use App\VendorMenu;
use App\Product;
use App\VendorBusinessCategory;
use App\BusinessCategory;


class SubmenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $menu = Menu::all();
        $businessCategories = BusinessCategory::all();

        return view('backend/submenu/index', compact('menu', 'search','businessCategories'));
    }

    public function list(Submenu $submenu)
    {
        $query = $submenu;
        $query = $query->select(
            'menu.name as menu_name',
            'submenu.id',
            'submenu.name',
            'submenu.status'
        );
        $query = $query->leftJoin('menu', 'menu.id', '=', 'submenu.menu_id');
        $data = $this->datatable(
            $query,
            function ($query) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('submenu.id', 'LIKE', "%{$search}%");
                    $query->orWhere('submenu.name', 'LIKE', "%{$search}%");
                    $query->orWhere('submenu.status', 'LIKE', "%{$search}%");
                    $query->orWhere('menu.name', 'LIKE', "%{$search}%");
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
                    'status' => ucfirst($row->status),
                    'menu_name' => $row->menu_name,
                    'actions' => view('backend/submenu/actions', compact('row'))->render(),
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
            'menu_id' => [ 'required', 'integer' ],
            'status' => [ 'required', 'max:20' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'name',  'menu_id',  'status',  ]);
            if($request->hasFile('image')) {
                $input['image'] = Storage::disk('public')->putFile('submenu', $request->file('image'));
            }



            Submenu::create($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Submenu',
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
                'title' => 'Submenu',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }

    public function edit(Submenu $submenu)
    {
        $menus = Menu::all();
        $sel_business_category=Menu::select('business_categories.*')
        ->join('business_categories','business_categories.id','=','menu.business_category_id')
        ->where('menu.id', $submenu->menu_id)->first();
        $businessCategories = BusinessCategory::all();


        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/submenu/edit', compact('menus', 'submenu','businessCategories','sel_business_category'))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }

    public function update(Request $request, Submenu $submenu)
    {
        $validator = Validator::make(request()->all(), [
            'name' => [ 'required', 'max:100' ],
            'menu_id' => [ 'required', 'integer' ],
            'status' => [ 'required', 'max:20' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        DB::beginTransaction();
        try {
            $input = $request->only([ 'name',  'menu_id',  'status' ]);
            $input2 = $request->only([ 'name','status' ]);
            if($request->hasFile('image')) {
                $input['image'] = $input2['image'] = Storage::disk('public')->putFile('submenu', $request->file('image'));
            }
            if($input['menu_id'] != $submenu->menu_id) {
                $vendor_menus = VendorMenu::where('menu_id', $submenu->menu_id)->pluck('id');
                $vendor_menu_products = VendorProduct::whereIn('menu_id', $vendor_menus)->exists();
                $admin_products = Product::where('menu_id', $submenu->menu_id)->first();

                if($vendor_menu_products || $admin_products) {
                    return response()->json([
                        'alert' => [
                            'icon' => 'error',
                            'title' => 'Submenu',
                            'text' => 'menu  can\'t be change! as it is in use',
                        ],
                    ]);
                } else {
                    $vendor_sub_data = VendorSubmenu::where('submenu_id', $submenu->id)->get();

                    foreach($vendor_sub_data as $row) {
                        $vendor_menus = VendorMenu::where('menu_id', $input['menu_id'])->where('vendor_id', $row->vendor_id)->pluck('id');

                        if(!empty($vendor_menus)) {
                            VendorSubmenu::where('submenu_id', $submenu->id)
                            ->where('vendor_id', $row->vendor_id)
                            ->update(['vendor_menu_id' => $vendor_menus]);
                        } else {
                            $admin_menu = Menu::find($input['menu_id']);
                            $vendor_business_category = VendorBusinessCategory::where($admin_menu->business_category_id)->where('vendor_id', $row->vendor_id)->first();
                            if($vendor_business_category) {
                                $vendor_menu_id=VendorMenu::create([
                                    'name' => $admin_menu->name,
                                    'business_category_id' => $vendor_business_category->id,
                                    'menu_id' => $admin_menu->id,
                                    'vendor_id' => $row->vendor_id,
                                ])->id;
                            }else{
                                $new_cat_id=VendorBusinessCategory::create([
                                    'vendor_id' => $row->vendor_id,
                                    'business_category_id'=>$admin_menu->business_category_id
                                ])->id;

                                $vendor_menu_id=VendorMenu::create([
                                    'name' => $admin_menu->name,
                                    'business_category_id' =>$new_cat_id ,
                                    'menu_id' => $admin_menu->id,
                                    'vendor_id' => $row->vendor_id,
                                ])->id;

                            }
                            VendorSubmenu::where('submenu_id', $submenu->id)
                            ->where('vendor_id', $row->vendor_id)
                            ->update(['vendor_menu_id' => $vendor_menu_id]);

                        }

                    }

                }

            }
            // $input2['vendor_menu_id']=$vendor_menu_id;
            $submenu->update($input);
            VendorSubmenu::where('submenu_id', $submenu->id)->update($input2);
            // $vendor_menus

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Submenu',
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
                'title' => 'Submenu',
                'text' => 'Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }

    public function destroy(Submenu $submenu)
    {
        try {
            $submenu->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Submenu',
                    'text' => 'Submenu can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Submenu',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }
}
