<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\Country;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\SellerMessage;
use App\Models\SellerProduct;
use App\Models\Wishlist;
use App\Models\Productbrand;
use App\Models\SearchCondition;
use DB;
use Mail;
use App\Models\ReviewSubmit;
use App\User;
use URL;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\FrontEnd\PublicMiddlewareController;

class ProductController extends Controller
{

    protected $PublicMiddlewareController;
    public function __construct(PublicMiddlewareController $PublicMiddlewareController)
    {
        $this->PublicMiddlewareController = $PublicMiddlewareController;
    }



public function ReviewSubmit(Request $request)
    {
      request()->validate([
        "name" => ['required','string', 'max:255'],
        "email" =>['required'],
        "review_title" =>['required'],
        "review" =>['required'],
      ]);
      $user_id = Auth::guard('user')->user()->id;
      $input = [
        'user_id' => $user_id,
        'product_id' => $request->get('product_id'),
        'name' => $request->get('name'),
        'email' => $request->get('email'),
        'review_title' => $request->get('review_title'),
        'review' => $request->get('review'),
        'star_rating' => $request->get('star_rating'),
        
   ];
  $product_review = ProductReview::create( $input );
 
   return back()->with('message', 'Thank you for your review.');

}

  public function autocompleteSproductFrontend(request $request) {

        $user_list=$this->PublicMiddlewareController->getexpiredsellerslist(); 
        $active_sellers=[];
        foreach ($user_list as $key => $value) 
            array_push($active_sellers,$value->id);

        $user_id = Auth::guard('user')->user()->id;
        $products = SellerProduct::where('status','active')
        ->whereIn('seller_products.user_id',$active_sellers)
        ->where('name','Like',$request->term.'%')
        ->where('user_id',$user_id)
        ->select("id","name")
        ->limit(10)
        ->get();
        return $products;
        

    }

public function SelleMessage(Request $request)
    {
      request()->validate([
        "name" => ['required','string', 'max:255'],
        "email" =>['required'],
        "phone" =>['required'],
        "message" =>['required'],
      ]);

    $input['name'] = $name = $request->input('name');
    $input['email'] =   $email = $request->input('email'); 
    $input['phone'] =   $phone = $request->input('phone');
    $input['message'] =   $msg = $request->input('message');
    $input['product_id'] =   $product_id = $request->input('product_id');
    $input['seller_id'] =   $seller_id = $request->input('seller_id');
    $input['user_id'] =   $user_id = Auth::guard('user')->user()->id;

//dd($request->input('seller_email'));

      $seller_email = $request->input('seller_email');


      SellerMessage::create($input);
      $productname=SellerProduct::where('id',$product_id)->pluck('name')->first();
      Mail::send('emails.SellerMessage', ['name' => $name,'product_id' => $product_id,'productname' => $productname,'email' => $email,'phone' => $phone,'msg' => $msg], function($message) use($request){
     
       
      $message->to($request->input('seller_email'));
      $message->subject('New Message - FMCG');
  });
   //return back()->with('message', 'Mail has Been Send. We will contact you soon.');
   return response()->json(['success'=>'<div class="alert alert-success" >Message has been send successfully.</dv>']);
    }


 public function searchcat()
{

    $cat = \Input::get('cat');

    $cat = (int) $cat;

    $vacancies = \Vacancy::where('category_id', '=', $cat)->get();

    return \View::make('vacancies.empty')->with('vacancies', $vacancies); 

}






public function extendedidSearch(Request $request)
{

    $user_list=$this->PublicMiddlewareController->getexpiredsellerslist(); 
    $validity=$this->PublicMiddlewareController->checkUserContactValidity();
    
    $active_sellers=[];
    foreach ($user_list as $key => $value) 
        array_push($active_sellers,$value->id);
         
    $start_from=$request->input('start_from');
    $per_page=$request->input('per_page');

    $central_listing=[];
    $category_id=[];

      $price_range= explode("-", $request->input('price_range'));
      $start_range=$price_range[0];
      $end_range=$price_range[1];
      $search_key= $request->input('search');
      
    $header_search_key=$request->input('header_search_key');
    if($header_search_key!=''){  // No Category only serch terms ie top header search by term
    
                
                
               
                 $products = SellerProduct::leftJoin('users', 'users.id', '=', 'seller_products.user_id')
                ->select(['seller_products.name AS prd_name', 'seller_products.*'])
                ->where('users.status','Active')
                ->where('seller_products.status','active')
                ->whereIn('seller_products.user_id',$active_sellers)
                ->whereBetween('seller_products.product_price', [$start_range, $end_range])
                ->where(DB::raw('lower(seller_products.name)'), 'LIKE', '%'. strtolower($header_search_key). '%')
                ->with('SellerProductImage');
                
        if($request->input('category_id')!='') {
        $categorylist= explode(",", $request->input('category_id'));         
        foreach ($categorylist as $value) 
                {
                    if(!in_array($value, $category_id))
                        array_push($category_id,$value);
                                              
                for ($i=0; $i<count($category_id);$i++)
                {
                    $category1=Category::where('parent_id',$category_id[$i])->get();
                        foreach ($category1 as  $value2) 
                        {   
                              if(!in_array($value2->id, $category_id))
                                     array_push($category_id,$value2->id);
                        }                             
                 }
                  $products= $products->where(function ($query) use ($category_id,$start_range,$end_range,$search_key) {
                    foreach ($category_id as $id)
                    {
                        $query->orWhereRaw('find_in_set("'.$id.'",seller_products.category_id)')
                        ->whereBetween('seller_products.product_price', [$start_range, $end_range])
                        ->where('seller_products.status','active');
                    }
            });
                
               }
               
               
               
    }
                
                
                
        if($search_key!='')
               $products = $products->where(DB::raw('UPPER(CONCAT(seller_products.name,COALESCE(seller_products.product_description,"")))'), 'LIKE','%'.strtoupper($search_key).'%');
          
        
     
        
         if($request->input('country_id')!=''){
               $country_id= explode(",", $request->input('country_id'));       
               $products = $products->where(function ($query) use ($country_id) {
                    foreach ($country_id as $c_id)
                    {
                        $query->orWhereRaw('find_in_set("'.$c_id.'",country_id)');
                    }
               }); 
        }  

        if($request->input('brand_id')!=''){
               $brand_id= explode(",", $request->input('brand_id'));
               $products= $products->whereIn('brands',$brand_id );
        }  
                
            $count = $products->count();
             $products= $products->skip($start_from)->take($per_page)->get();  
                
                
                
            $brand_lists = $central_listing =[];
           // $search_key =  "";
           
       //Following Code for leftmenu Category checkbox list
       $left_menu_list=[];
       $values = [];
       $sellerProducts  = SellerProduct::select('seller_products.*')->with('SellerProductImage')
      ->leftJoin('users', 'users.id', '=', 'seller_products.user_id')  
      ->where('users.status','Active')
      ->whereIn('seller_products.user_id',$active_sellers)
      ->where(DB::raw('lower(seller_products.name)'), 'LIKE', '%'. strtolower($header_search_key). '%')
      ->where('seller_products.status','active')
      ->latest('seller_products.created_at')->get(); 
      
          foreach ($sellerProducts as $sproduct) {
          foreach(explode(',', $sproduct->category_id) as $value) {
         $values[] = trim($value);
         }
         } 
$values = array_unique($values); 
$categorylist=Category::where('parent_id',null)->whereIn('id',$values)->get(); 
foreach ($categorylist as  $value2) 
array_push($left_menu_list,['id'=>$value2->id,'name'=>$value2->name]);
                                                                   
  //left menu category end
      $Trendingproducts = SellerProduct::select('seller_products.*')->with('SellerProductImage')
      ->leftJoin('users', 'users.id', '=', 'seller_products.user_id')  
      ->where('users.status','Active')
      ->whereIn('seller_products.user_id',$active_sellers)
      ->where('seller_products.status','active')
      ->latest('seller_products.created_at')->take(5)->get();
      
      
     $data_return=[];
             foreach($products as $data) 
             {

                  $prd_img = URL::asset('/images/no-image.jpg'); 
                  foreach($data->SellerProductImage as $prod_img) {
                         if($prod_img->thumbnail=='yes')
                              $prd_img = URL::asset('/uploads/productImages/'.$prod_img->image_path);
                  }

$seller_id=$data->user_id;
$seller = User::find($seller_id);
$seller_country_id =DB::table('users')->where('id',$seller_id)->pluck('country_id')->first();
$seller_country_name =DB::table('countries')->where('id',$seller_country_id)->pluck('name')->first();  
                 

$country_name=$seller_country_name;



$curreny_symbol ='$';
if(!empty($data->Currency->symbol) )
$curreny_symbol = $data->Currency->symbol;

                    
                        
                        
                        
                        if($validity==false){
                        $product_price=$country_name="*****";
                     }
                    else{
                        
if($data->price_on_request != 'Price on request')
{
if($data->price_negotiable == 'Negotiable')  
    $product_price=$curreny_symbol.$data->product_price." (Price Negotiable)";
    else
    $product_price=$curreny_symbol.$data->product_price;
} else    $product_price= 'Price on Request'     ; 
                    }   
                        
                   

                    $data_return[]= array('product_name'=>$data->prd_name,'currency'=>$curreny_symbol,'product_thumbnail'=>$prd_img,'available_countries'=>$country_name,'price'=>$product_price,'stock_count'=>$data->stock_count,'product_id'=>$data->id);
            }


             $return_array=['count'=>$count,'product_data'=>$data_return,'central_listing'=>$central_listing];          
                
                
                       
}
//not header search normal filter
else{


   if($request->input('category_id')!='')
         
        $categorylist= explode(",", $request->input('category_id'));         
    

    elseif(!empty($request->input('topcategorysearch'))) 
    {  
                $category=Category::where('slug', 'LIKE',$request->input('topcategorysearch'))->first() ; //get one parent category
                $categorylist=Category::where('parent_id',$category->id)->pluck('id')->all();       // all subcategories                   
                array_push($category_id,$category->id);  //prent category to array
    }


                foreach ($categorylist as $value) 
                {
                    if(!in_array($value, $category_id)) //subctegory id not in $category_id array
                        array_push($category_id,$value); //all category ids as array
                                              
                for ($i=0; $i<count($category_id);$i++)
                {
                    $category1=Category::where('parent_id',$category_id[$i])->get();
                        foreach ($category1 as  $value2) 
                        {   
                              if(!in_array($value2->id, $category_id))
                                     array_push($category_id,$value2->id);
                        }                             
                 }
                
               }
               
        $products = SellerProduct::leftJoin('users', 'users.id', '=', 'seller_products.user_id')  
          ->select(['seller_products.name AS prd_name', 'seller_products.*'])
                       ->where('users.status','Active')
                       ->whereIn('seller_products.user_id',$active_sellers)
                        ->where(function ($query) use ($category_id,$start_range,$end_range,$search_key) {
                    foreach ($category_id as $id)
                    {
                        $query->orWhereRaw('find_in_set("'.$id.'",category_id)')
                        ->whereBetween('product_price', [$start_range, $end_range])
                        ->where('seller_products.status','active');
                    }
            });

      
        if($search_key!='')
              $products = $products->where(DB::raw('UPPER(CONCAT(seller_products.name,COALESCE(seller_products.product_description,"")))'), 'LIKE','%'.strtoupper($search_key).'%');
          
        
     
        
          
        if($request->input('country_id')!=''){
               $country_id= explode(",", $request->input('country_id'));       
               $products = $products->where(function ($query) use ($country_id) {
                    foreach ($country_id as $c_id)
                    {
                        $query->orWhereRaw('find_in_set("'.$c_id.'",country_id)');
                    }
               }); 
               
        }   

        if($request->input('brand_id')!=''){
               $brand_id= explode(",", $request->input('brand_id'));
               $products= $products->whereIn('brands',$brand_id );
               
        }  
$products= $products->whereBetween('seller_products.product_price', [$start_range, $end_range]);

        


             $count = $products->count();
             $products= $products->skip($start_from)->take($per_page)->get();     


             $data_return=[];
             foreach($products as $data) 
             {

                  $prd_img = URL::asset('/images/no-image.jpg'); 
                  foreach($data->SellerProductImage as $prod_img) {
                         if($prod_img->thumbnail=='yes')
                              $prd_img = URL::asset('/uploads/productImages/'.$prod_img->image_path);
                  }

$seller_id=$data->user_id;
$seller = User::find($seller_id);
$seller_country_id =DB::table('users')->where('id',$seller_id)->pluck('country_id')->first();
$seller_country_name =DB::table('countries')->where('id',$seller_country_id)->pluck('name')->first();  
$curreny_symbol ='$';
if(!empty($data->Currency->symbol) )
$curreny_symbol = $data->Currency->symbol;

                     if($validity==false){
                        $product_price=$country_name="*****";
                     }
                    else{
                        
if($data->price_on_request != 'Price on request')
{
    if($data->price_negotiable == 'Negotiable')  
    $product_price=$curreny_symbol.$data->product_price." (Price Negotiable)";
    else
    $product_price=$curreny_symbol.$data->product_price;
} else    $product_price= 'Price on Request'     ;           
                        

                    }

$country_name=$seller_country_name;
                    $data_return[]= array('product_name'=>$data->prd_name,'currency'=>$curreny_symbol,'product_thumbnail'=>$prd_img,'available_countries'=>$country_name,'price'=>$product_price,'stock_count'=>$data->stock_count,'product_id'=>$data->id);
            }


             $return_array=['count'=>$count,'product_data'=>$data_return,'central_listing'=>$central_listing];

}
  return json_encode($return_array);    



}






public function ProductListing($search_key=null)
{
  $validity=$this->PublicMiddlewareController->checkUserContactValidity();
    $user_list=$this->PublicMiddlewareController->getexpiredsellerslist(); 
    $active_sellers=[];
    foreach ($user_list as $key => $value) 
        array_push($active_sellers,$value->id);
        

 $header_search_key = $search_key;

    if(Auth::guard('user')->check())
       {
        if(!$this->PublicMiddlewareController->checkUserlogin()) 
        {
                               Auth::guard('user')->logout(); 
                               return redirect(route('home'))->with('message','Access Denied'); ; 
        }
       }

    $user_id = $user = $wish_listed = "";
    if(Auth::guard('user')->check()) { 
      $user_id = Auth::guard('user')->user()->id;
      $user = User::find($user_id);
      $usertype = Auth::guard('user')->user()->usertype;
     // $wish_listed=  Wishlist::where('product_id','=',$productId)->where('user_id','=',$user_id)->pluck('wishlist')->first();
    }
 
    $countries = Country::all(); 
        $categoryCount = Category::where(DB::raw('lower(slug)'), 'LIKE', ''. strtolower($search_key). '')->count(); //check category exists or not
    
    $search_conditions = SearchCondition::pluck('search_name')->all();   
       
//this if category exists
 if($categoryCount>0){
    
    $category_id=Category::where('slug', 'LIKE',$search_key)->pluck('id')->all() ;
    $categorylist=Category::whereIn('parent_id',$category_id)->get();
    $category_id_all=$central_listing=[];
    foreach ($categorylist as $value) 
    {
        if(!in_array($value->id, $category_id_all))
            array_push($category_id_all,$value->id);


        array_push($central_listing,['id'=>$value->id,'name'=>$value->name]);  
        
                                  
    for ($i=0; $i<count($category_id_all);$i++)
    {
        $category1=Category::where('parent_id',$category_id_all[$i])->get();
            foreach ($category1 as  $value2) 
            {   
                  if(!in_array($value2->id, $category_id_all))
                         array_push($category_id_all,$value2->id); 
            }                             
     }
   }

   $left_menu_list=[]; 
    for ($i=0; ($i<count($category_id_all) && count($categorylist)>0);$i++)
    {
           $categorylist=Category::where('id',$category_id_all[$i])->get();
           foreach ($categorylist as  $value2) 
                        array_push($left_menu_list,['id'=>$value2->id,'name'=>$value2->name]);
                                                                   
    }

    
    //if(count($category_id_all)==0)
     $category_id_all[]=$category_id[0];

    

    $brand_lists = SellerProduct::leftJoin('productbrands', 'productbrands.id', '=', 'seller_products.brands')
          ->leftJoin('users', 'users.id', '=', 'seller_products.user_id')
          ->orWhere(function($query) use($category_id_all) {
              foreach($category_id_all as $term) {
                  $query->orWhereRaw('find_in_set("'.$term.'",category_id)')->where('seller_products.status','active');
              };
        })
    ->where('users.status','Active')
    ->where('productbrands.name','<>','')
    ->whereIn('seller_products.user_id',$active_sellers)
    ->select('productbrands.id','productbrands.name',DB::raw('count(*) as count'))
    ->groupBy('seller_products.brands')->get();


    $search_conditions = SearchCondition::pluck('search_name')->all();    
   
   

    $Trendingproducts = SellerProduct::select('seller_products.*')->with('SellerProductImage')
      ->leftJoin('users', 'users.id', '=', 'seller_products.user_id')
       ->whereIn('seller_products.user_id',$active_sellers)  
      ->where('users.status','Active')
      ->Where(function($query) use($category_id_all) {
              foreach($category_id_all as $term) {
                  $query->orWhereRaw('find_in_set("'.$term.'",category_id)')->where('seller_products.status','active');
              };
        })
    ->where('seller_products.status','active')
    ->latest('seller_products.created_at')->take(5)->get();

    $max_product_price = SellerProduct::leftJoin('users', 'users.id', '=', 'seller_products.user_id')
          ->orWhere(function($query) use($category_id_all) {
              foreach($category_id_all as $term) {
                  $query->orWhereRaw('find_in_set("'.$term.'",category_id)')->where('seller_products.status','active');
              };
        })
    ->where('users.status','Active')
    ->whereIn('seller_products.user_id',$active_sellers)
    ->max('seller_products.product_price');

    $max_product_price=round($max_product_price?? 0,-1);
    
$header_search_key = '';
    return view('frontEnd.products.product-listing',compact('user','validity','header_search_key','brand_lists','search_conditions','search_key','Trendingproducts','left_menu_list','central_listing','max_product_price'));
}

//below code is for --> header pass search parameter not conatain category ie for product name search
else {
      $brand_lists = $central_listing =[];
      $search_key =  "";
           
       $left_menu_list=[];
          
       $values = [];
       $sellerProducts  = SellerProduct::select('seller_products.*')->with('SellerProductImage')
      ->leftJoin('users', 'users.id', '=', 'seller_products.user_id')  
      ->where('users.status','Active')
       ->whereIn('seller_products.user_id',$active_sellers)
      ->where(DB::raw('lower(seller_products.name)'), 'LIKE', '%'. strtolower($header_search_key). '%')
      ->where('seller_products.status','active')
      ->latest('seller_products.created_at')->get(); 
      
          foreach ($sellerProducts as $sproduct) {
          foreach(explode(',', $sproduct->category_id) as $value) {
         $values[] = trim($value);
         }
         } 
$values = array_unique($values); 
$categorylist=Category::where('parent_id',null)->whereIn('id',$values)->get(); 
foreach ($categorylist as  $value2) 
array_push($left_menu_list,['id'=>$value2->id,'name'=>$value2->name]);
           
$search_conditions = SearchCondition::pluck('search_name')->all();   /// admin selected search fids display in left side                                                     
  
      $Trendingproducts = SellerProduct::select('seller_products.*')->with('SellerProductImage')
      ->leftJoin('users', 'users.id', '=', 'seller_products.user_id')  
      ->where('users.status','Active')
       ->whereIn('seller_products.user_id',$active_sellers)
      ->where('seller_products.status','active')
      ->latest('seller_products.created_at')->take(5)->get();

      $max_product_price = SellerProduct::leftJoin('users', 'users.id', '=', 'seller_products.user_id')
            ->where('users.status','Active')
            ->whereIn('seller_products.user_id',$active_sellers)
            ->max('seller_products.product_price');

       $max_product_price=round($max_product_price?? 0,-1); 

      
           return view('frontEnd.products.product-listing',compact('user','validity','header_search_key','brand_lists','search_conditions','search_key','Trendingproducts','left_menu_list','central_listing','max_product_price'));
     }






}







}
