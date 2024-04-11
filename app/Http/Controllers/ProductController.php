<?php

namespace App\Http\Controllers;

use Validator;
use App\Product;
use App\Brand;
use App\BusinessCategory;
use App\Menu;
use App\Submenu;
use App\VendorProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        return view('backend/product/index', compact('search'));
    }

    public function list(Product $product)
    {
        $query = $product;
        $query = $query->select(
            'brands.name as brand_name',
            'business_categories.title as business_category_title',
            'menu.name as menu_name',
            'submenu.name as submenu_name',
            'products.id',
            'products.name',
            'products.variant_option',
            'products.price',
            'products.selling_price',
            'products.status'
        );
        $query = $query->leftJoin('brands', 'brands.id', '=', 'products.brand_id');
        $query = $query->leftJoin('business_categories', 'business_categories.id', '=', 'products.business_category_id');
        $query = $query->leftJoin('menu', 'menu.id', '=', 'products.menu_id');
        $query = $query->leftJoin('submenu', 'submenu.id', '=', 'products.submenu_id');
        $data = $this->datatable(
            $query,
            function ($query) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('products.id', 'LIKE', "%{$search}%");
                    $query->orWhere('products.name', 'LIKE', "%{$search}%");
                    $query->orWhere('products.short_description', 'LIKE', "%{$search}%");
                    $query->orWhere('products.variant_option', 'LIKE', "%{$search}%");
                    $query->orWhere('products.selling_price', 'LIKE', "%{$search}%");
                    $query->orWhere('products.type', 'LIKE', "%{$search}%");
                    $query->orWhere('products.description', 'LIKE', "%{$search}%");
                    $query->orWhere('products.keywords', 'LIKE', "%{$search}%");
                    $query->orWhere('products.product_code', 'LIKE', "%{$search}%");
                    $query->orWhere('brands.name', 'LIKE', "%{$search}%");
                    $query->orWhere('business_categories.title', 'LIKE', "%{$search}%");
                    $query->orWhere('menu.name', 'LIKE', "%{$search}%");
                    $query->orWhere('submenu.name', 'LIKE', "%{$search}%");
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
                    'variant_option' => $row->variant_option,
                    'selling_price' => $row->selling_price,
                    'brand_name' => $row->brand_name,
                    'business_category_title' => $row->business_category_title,
                    'menu_name' => $row->menu_name,
                    'submenu_name' => $row->submenu_name,
                    'actions' => view('backend/product/actions', compact('row'))->render(),
                    ];
                }
                return $data;
            }
        );
        return response()->json($data);
    }

    public function create(Request $request)
    {
        $brands = Brand::all();
        $businessCategories = BusinessCategory::all();
        $menu = Menu::all();
        $submenu = Submenu::all();
        return view('backend/product/create', compact('brands', 'businessCategories', 'menu', 'submenu', 'request'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'business_category_id' => [ 'required', 'integer' ],
            'menu_id' => [ 'required', 'integer' ],
            // 'submenu_id' => [ 'nullable', 'integer' ],
            'products.*.name' => [ 'required', 'max:150' ],
            // 'products.*.short_description' => [ 'required', 'max:100' ],
            //'products.*.variant_option' => [ 'required', 'max:255' ],
            'products.*.weight' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:999999999.9' ],
            'products.*.price' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'products.*.selling_price' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999', 'lte:products.*.price' ],
            'products.*.max_qty' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:99999999.99' ],
            'products.*.type' => [ 'nullable', 'max:10' ],
            'products.*.description' => [ 'nullable' ],
            'products.*.keywords' => [ 'nullable' ],
            'products.*.brand_id' => [ 'nullable', 'integer' ],
            'products.*.image' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'products.*.gallery_image_1' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'products.*.gallery_image_2' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'products.*.gallery_image_3' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'products.*.gallery_image_4' => [ 'nullable', 'file', 'image', 'max: 10240' ],

        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {

            $combinationKey = fileName(null, null);
            $products =  $request->products ?? [];
            $count = 0;
            foreach($products as $product) {
                $input = [];
                $input = $request->only([ 'business_category_id',  'menu_id',  'submenu_id']);

                $input['name'] = $product['name'];
                $input['short_description'] = $product['short_description'];
                $input['variant_option'] = ($product['variant_option']!='')?$product['variant_option']:' ';
                $input['weight'] = $product['weight'];
                $input['price'] = $product['price'];
                $input['selling_price'] = $product['selling_price'];
                $input['max_qty'] = $product['max_qty'];
                $input['type'] = $product['type'];
                $input['description'] = $product['description'];
                $input['keywords'] = $product['keywords'];
                $input['brand_id'] = $product['brand_id'];
                $input['combination_key'] = $combinationKey;
                $input['product_code'] = null;
                $input['status'] = 'active';
                $input['product_description'] = $product['product_description'];

                if(($request->hasFile('products.' . $count . '.image'))) {
                    $input['image'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.image'));
                }

                if($request->hasFile('products.' . $count . '.gallery_image_1')) {
                    $input['gallery_image_1'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.gallery_image_1'));
                }

                if($request->hasFile('products.' . $count . '.gallery_image_2')) {
                    $input['gallery_image_2'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.gallery_image_2'));
                }

                if($request->hasFile('products.' . $count . '.gallery_image_3')) {
                    $input['gallery_image_3'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.gallery_image_3'));
                }
                if($request->hasFile('products.' . $count . '.gallery_image_4')) {
                    $input['gallery_image_4'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.gallery_image_4'));
                }

                $count = $count + 1;
                Product::create($input);

            }

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Product',
                    'text' => 'Something went wrong.',
                ],
            ]);
        }
        DB::commit();
        return response()->json([
            'reset' => true,
            'alert' => [
                'icon' => 'success',
                'title' => 'Product',
                'text' => 'Created successfully.',
                'redirect' => route('product'),
            ],
        ]);
    }

    public function edit(Product $product)
    {
        $brands = Brand::all();
        $businessCategories = BusinessCategory::all();
        $menus = Menu::where('business_category_id', $product->business_category_id)->get();
        $submenus = Submenu::where('menu_id', $product->menu_id)->get();
        $products = $product->variation();
        return view('backend/product/edit', compact('brands', 'businessCategories', 'menus', 'submenus', 'product', 'products'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'business_category_id' => [ 'required', 'integer' ],
            'menu_id' => [ 'required', 'integer' ],
            'submenu_id' => [ 'nullable', 'integer' ],
            'products.*.id' => [ 'nullable', 'integer' ],
            'products.*.name' => [ 'required', 'max:150' ],
            'products.*.short_description' => [ 'nullable', 'max:100' ],
            //'products.*.variant_option' => [ 'required', 'max:255' ],
            'products.*.weight' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:999999999.9' ],
            'products.*.price' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'products.*.selling_price' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999', 'lte:products.*.price' ],
            'products.*.max_qty' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:99999999.99' ],
            'products.*.type' => [ 'nullable', 'max:10' ],
            'products.*.description' => [ 'nullable' ],
            'products.*.keywords' => [ 'nullable' ],
            'products.*.brand_id' => [ 'nullable', 'integer' ],
            'products.*.image' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'products.*.gallery_image_1' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'products.*.gallery_image_2' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'products.*.gallery_image_3' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'products.*.gallery_image_4' => [ 'nullable', 'file', 'image', 'max: 10240' ],

        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }


        // DB::beginTransaction();
        // try {
        $products = $request->products ?? [];

        $combinationKey =  '';
        $count = 0;


        $firstProductId = $products[0]['id'] ?? 0;
        $firstProductObj =  Product::find($firstProductId);

        if($firstProductObj) {
            $combinationKey = $firstProductObj->combination_key;
        }

        if($combinationKey  == '') {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Product',
                    'text' => 'Invalid Products.',
                ],
            ]);
        }

        $requestIds =  array_filter(Arr::pluck($products, 'id'));
        $getIds = Product::where('combination_key', $combinationKey)->pluck('id')->toArray();
        $delIds = array_diff($getIds, $requestIds);



        if(!empty($delIds)) {
            Product::whereIn('id', $delIds)->delete();
        }
        $update_fields = ['name','short_description','type','description','brand_id','keywords','weight','variant_option','product_description'];
        foreach($products as $product) {
            $input = [];
            $input2 = [];
            // $input=$input2= $request->only([ 'business_category_id',  'menu_id',  'submenu_id']);
            $input = $request->only([ 'business_category_id',  'menu_id',  'submenu_id']);

            $ext_product = Product::find($product['id']);
            foreach($update_fields as $value) {
                //  if($ext_product->$value!=$product[$value]){
                $input2[$value] = $product[$value];
                //  }
            }


            $input['id'] = $product['id'];

            $input['name'] = $product['name'];
            $input['short_description'] = $product['short_description'];
            $input['variant_option'] = ($product['variant_option']!='')?$product['variant_option']:' ';
            $input['weight'] = $product['weight'];
            $input['price'] = $product['price'];
            $input['selling_price'] = $product['selling_price'];
            $input['max_qty'] = $product['max_qty'];
            $input['type'] = $product['type'];
            $input['description'] = $product['description'];
            $input['keywords'] = $product['keywords'];
            $input['brand_id'] = $product['brand_id'];
            $input['product_description'] = $product['product_description'];




            if($request->hasFile('products.' . $count . '.image')) {
                $input[ 'image'] = $input2[ 'image'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.image'));
            }

            if($request->hasFile('products.' . $count . '.gallery_image_1')) {
                $input['gallery_image_1'] = $input2['gallery_image_1'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.gallery_image_1'));
            }

            if($request->hasFile('products.' . $count . '.gallery_image_2')) {
                $input['gallery_image_2'] = $input2['gallery_image_2'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.gallery_image_2'));
            }

            if($request->hasFile('products.' . $count . '.gallery_image_3')) {
                $input['gallery_image_3'] = $input2['gallery_image_3'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.gallery_image_3'));
            }
            if($request->hasFile('products.' . $count . '.gallery_image_4')) {
                $input['gallery_image_4'] = $input2['gallery_image_4'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.gallery_image_4'));
            }

            if($products[$count]['remove_image'] != null) {
                ($ext_product->image != '') ? Storage::disk('public')->delete($ext_product->image) : '';
                $input[ 'image'] = $input2[ 'image'] = null;
            }
            if($products[$count]['remove_gallery_1'] != null) {
                ($ext_product->gallery_image_1 != '') ? Storage::disk('public')->delete($ext_product->gallery_image_1) : '';
                $input[ 'gallery_image_1'] = $input2[ 'gallery_image_1'] = null;
            }
            if($products[$count]['remove_gallery_2'] != null) {
                ($ext_product->gallery_image_2 != '') ? Storage::disk('public')->delete($ext_product->gallery_image_2) : '';
                $input[ 'gallery_image_2'] = $input2[ 'gallery_image_2'] = null;
            }
            if($products[$count]['remove_gallery_3'] != null) {
                ($ext_product->gallery_image_3 != '') ? Storage::disk('public')->delete($ext_product->gallery_image_3) : '';
                $input[ 'gallery_image_3'] = $input2[ 'gallery_image_3'] = null;
            }
            if($products[$count]['remove_gallery_4'] != null) {
                ($ext_product->gallery_image_4 != '') ? Storage::disk('public')->delete($ext_product->gallery_image_4) : '';
                $input[ 'gallery_image_4'] = $input2[ 'gallery_image_4'] = null;
            }


            $count = $count + 1;
            $productObj =  Product::find($input['id']);
            unset($input['id']);

            if($productObj) {
                $productObj->update($input);

                VendorProduct::where('product_id', $productObj->id)->update($input2);

            } else {
                $input['combination_key'] = $combinationKey;
                $input['product_code'] = null;
                $input['status'] = 'active';
                Product::create($input);
            }
        }



        // } catch (\Exception $e) {
        //     DB::rollback();

        //     return response()->json([
        //         'alert' => [
        //             'icon' => 'error',
        //             'title' => 'Product',
        //             'text' => 'Something went wrong.',
        //         ],
        //     ]);
        // }
        // DB::commit();
        return response()->json([
            'alert' => [
                'icon' => 'success',
                'title' => 'Product',
                'text' => 'Updated successfully.',
                'redirect' => route('product'),
            ],
        ]);
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Product',
                    'text' => 'Product can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Product',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }

    public function menu(Request $request)
    {

        $id = $request->value ?? null;

        $menu = null;
        if($id) {
            $menu =  Menu::where('business_category_id', $id)->get();
        }

        return response()->json([
            'jquery' => [
                [
                    'element' => '#menu',
                    'method' => 'html',
                    'value' => view('backend/product/menu', compact('menu'))->render(),
                ],
                [
                    'element' => '#menu2',
                    'method' => 'html',
                    'value' => view('backend/product/menu', compact('menu'))->render(),
                ]
            ],
            'init' => ['#menu','#menu2'],
        ]);
    }

    public function submenu(Request $request)
    {

        $id = $request->value ?? null;

        $submenu = null;
        if($id) {
            $submenu =  Submenu::where('menu_id', $id)->get();
        }

        return response()->json([
            'jquery' => [
                [
                    'element' => '#submenu',
                    'method' => 'html',
                    'value' => view('backend/product/submenu', compact('submenu'))->render(),
                ],
            ],
            'init' => ['#submenu'],
        ]);
    }

    public function duplicate(Product $product)
    {
        $brands = Brand::all();
        $businessCategories = BusinessCategory::all();
        $menus = Menu::where('business_category_id', $product->business_category_id)->get();
        $submenus = Submenu::where('menu_id', $product->menu_id)->get();
        $products = $product->variation();
        $type = 'duplicate';
        // dd($product);
        return view('backend/product/edit', compact('brands', 'businessCategories', 'menus', 'submenus', 'product', 'products', 'type'));

    }
    public function duplicate_store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'business_category_id' => [ 'required', 'integer' ],
            'menu_id' => [ 'required', 'integer' ],
            // 'submenu_id' => [ 'nullable', 'integer' ],
            'products.*.name' => [ 'required', 'max:100' ],
            // 'products.*.short_description' => [ 'required', 'max:100' ],
            //'products.*.variant_option' => [ 'required', 'max:255' ],
            'products.*.weight' => [ 'required', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:999999999.9' ],
            'products.*.price' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999' ],
            'products.*.selling_price' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:9999999.999', 'lte:products.*.price' ],
            'products.*.max_qty' => [ 'nullable', 'regex:/^\d+(\.\d{1,3})?$/', 'lt:99999999.99' ],
            'products.*.type' => [ 'nullable', 'max:10' ],
            'products.*.description' => [ 'nullable' ],
            'products.*.keywords' => [ 'nullable' ],
            'products.*.brand_id' => [ 'nullable', 'integer' ],
            'products.*.image' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'products.*.gallery_image_1' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'products.*.gallery_image_2' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'products.*.gallery_image_3' => [ 'nullable', 'file', 'image', 'max: 10240' ],
            'products.*.gallery_image_4' => [ 'nullable', 'file', 'image', 'max: 10240' ],

        ]);

        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        // DB::beginTransaction();
        // try {

        $combinationKey = fileName(null, null);
        $products =  $request->products ?? [];
        $count = 0;
        foreach($products as $product) {
            $input = [];
            $input = $request->only([ 'business_category_id',  'menu_id',  'submenu_id']);

            $input['name'] = $product['name'];
            $input['short_description'] = $product['short_description'];
            $input['variant_option'] = ($product['variant_option']!='')?$product['variant_option']:' ';
            $input['weight'] = $product['weight'];
            $input['price'] = $product['price'];
            $input['selling_price'] = $product['selling_price'];
            $input['max_qty'] = $product['max_qty'];
            $input['type'] = $product['type'];
            $input['description'] = $product['description'];
            $input['keywords'] = $product['keywords'];
            $input['brand_id'] = $product['brand_id'];
            $input['combination_key'] = $combinationKey;
            $input['product_code'] = null;
            $input['status'] = 'active';
            $input['product_description'] = $product['product_description'];
            $product_data = Product::find($product['id']);

            if($request->hasFile('products.' . $count . '.image')) {
                $input[ 'image'] = $input2[ 'image'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.image'));
            } else {
                if($product_data){
                    if(($product_data->image!=null)&&$products[$count]['remove_image'] == null) {
                        $input['image'] = $this->make_duplicate_file($product_data->image);
                    }
                }

            }

            if($request->hasFile('products.' . $count . '.gallery_image_1')) {
                $input['gallery_image_1'] = $input2['gallery_image_1'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.gallery_image_1'));
            }else {
                if($product_data){
                    if(($product_data->gallery_image_1!=null)&&$products[$count]['remove_gallery_1'] == null) {
                        $input['gallery_image_1'] = $this->make_duplicate_file($product_data->gallery_image_1);
                    }
                }

            }

            if($request->hasFile('products.' . $count . '.gallery_image_2')) {
                $input['gallery_image_2'] = $input2['gallery_image_2'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.gallery_image_2'));
            }else {
                if($product_data){
                    if(($product_data->gallery_image_2!=null)&&$products[$count]['remove_gallery_2'] == null) {
                        $input['gallery_image_2'] = $this->make_duplicate_file($product_data->gallery_image_2);
                    }
                }

            }

            if($request->hasFile('products.' . $count . '.gallery_image_3')) {
                $input['gallery_image_3'] = $input2['gallery_image_3'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.gallery_image_3'));
            }else {
                if($product_data){
                    if(($product_data->gallery_image_3!=null)&&$products[$count]['remove_gallery_3'] == null) {
                        $input['gallery_image_3'] = $this->make_duplicate_file($product_data->gallery_image_3);
                    }
                }

            }
            if($request->hasFile('products.' . $count . '.gallery_image_4')) {
                $input['gallery_image_4'] = $input2['gallery_image_4'] = Storage::disk('public')->putFile('product', $request->file('products.' . $count . '.gallery_image_4'));
            }else {
                if($product_data){
                    if(($product_data->gallery_image_4!=null)&&$products[$count]['remove_gallery_4'] == null) {
                        $input['gallery_image_4'] = $this->make_duplicate_file($product_data->gallery_image_4);
                    }
                }

            }


            if($products[$count]['remove_image'] != null) {
                $input[ 'image'] = $input2[ 'image'] = null;
            }
            if($products[$count]['remove_gallery_1'] != null) {
                $input[ 'gallery_image_1'] = $input2[ 'gallery_image_1'] = null;
            }
            if($products[$count]['remove_gallery_2'] != null) {
                $input[ 'gallery_image_2'] = $input2[ 'gallery_image_2'] = null;
            }
            if($products[$count]['remove_gallery_3'] != null) {
                $input[ 'gallery_image_3'] = $input2[ 'gallery_image_3'] = null;
            }
            if($products[$count]['remove_gallery_4'] != null) {
                $input[ 'gallery_image_4'] = $input2[ 'gallery_image_4'] = null;
            }

            //
            $count = $count + 1;
            Product::create($input);

        }

        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return response()->json([
        //         'alert' => [
        //             'icon' => 'error',
        //             'title' => 'Product',
        //             'text' => 'Something went wrong.',
        //         ],
        //     ]);
        // }
        // DB::commit();
        return response()->json([
            'reset' => true,
            'alert' => [
                'icon' => 'success',
                'title' => 'Product',
                'text' => 'Duplicate product Created successfully.',
                'redirect' => route('product'),
            ],
        ]);
    }

    public function make_duplicate_file($file)
    {
        $originalImagePath = Storage::disk('public')->path('').$file;
        $newImageName = substr(sha1(uniqid(rand(), true)), 0, 32) . '.' . pathinfo($originalImagePath, PATHINFO_EXTENSION);
        $newImagedbPath = 'product/' . $newImageName;
        $newImagePath = Storage::disk('public')->path('').$newImagedbPath;
        if (copy($originalImagePath, $newImagePath)) {
            return $newImagedbPath;
        } else {
            return null;
        }
    }

}
