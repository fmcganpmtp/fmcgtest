<?php
namespace App\Http\Controllers;
use Validator;
use App\Menu;
use App\BusinessCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\VendorMenu;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $businessCategories = BusinessCategory::all();
        return view('backend/menu/index', compact(  'businessCategories',  'search' ));
    }

    function list(Menu $menu)
    {
        $query = $menu;
        $query = $query->select(
        'business_categories.title as business_category_title',
        'menu.id',
        'menu.name',
        'menu.image',
        'menu.status'
        );
        $query = $query->leftJoin('business_categories', 'business_categories.id', '=', 'menu.business_category_id');
        $data = $this->datatable(
            $query,
            function ($query) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('menu.id', 'LIKE', "%{$search}%");
                    $query->orWhere('menu.name', 'LIKE', "%{$search}%");
                    $query->orWhere('menu.status', 'LIKE', "%{$search}%");
                    $query->orWhere('business_categories.title', 'LIKE', "%{$search}%");
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
                    'status' => ucwords( $row->status ),
                    'business_category_title' => $row->business_category_title,
                    'actions' => view('backend/menu/actions', compact('row'))->render(),
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
            'business_category_id' => [ 'required', 'integer' ],
            'status' => [ 'required', 'max:20' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'name',  'business_category_id',  'status' ]);
            if($request->hasFile('image')){
                $input['image'] = Storage::disk('public')->putFile('menu', $request->file('image'));
            }

            Menu::create($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'menu',
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
                'title' => 'menu',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }

    public function edit(Menu $menu)
    {
        $businessCategories = BusinessCategory::all();

        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/menu/edit', compact(  'businessCategories',  'menu' ))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $validator = Validator::make(request()->all(), [
            'name' => [ 'required', 'max:100' ],
            'business_category_id' => [ 'required', 'integer' ],
            'status' => [ 'required', 'max:20' ],
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $input = $request->only([ 'name',  'business_category_id','status']);
            $input2=$request->only(['name','status']);
            if($request->hasFile('image')){
                $input['image']=$input2['image'] = Storage::disk('public')->putFile('menu', $request->file('image'));
            }



            $menu->update($input);
            VendorMenu::where('menu_id',$menu->id)->update($input2);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'menu',
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
                'title' => 'menu',
                'text' => 'Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }

    public function destroy(Menu $menu)
    {
        try {
            $menu->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'menu',
                    'text' => 'menu can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'menu',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }
}
