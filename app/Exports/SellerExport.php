<?php

namespace App\Exports;

use App\User;
//use App\Models\SellerMessage;
use App\Models\Category;
use App\Models\SellerOfflineCategory;
use App\Models\SellerProduct;
use App\Models\CompanyType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Helpers\XMLWriter;

class SellerExport implements FromCollection,ShouldAutoSize,WithHeadings
{

     function __construct($search_key,$status,$company_type,$selected_country_id,$category_id,$sub_end_month,$sub_type) {
        $this->search_key = $search_key;
        $this->status = $status;
        $this->company_type = $company_type;
        $this->selected_country_id = $selected_country_id;
        $this->category_id = $category_id;
        $this->sub_end_month = $sub_end_month;
        $this->sub_type = $sub_type;
    } 
    public function collection()
    {
         

        $inr=0;
         $records = User::leftJoin('buyer_companies', 'buyer_companies.user_id', '=', 'users.id')
        ->leftJoin('countries', 'countries.id', '=', 'users.country_id')
        ->leftJoin('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        ->leftJoin('packages', 'subscriptions.package_id', '=', 'packages.id')
        ->where('subscriptions.package_id', '<>', null)
        -> where('subscriptions.status', '=', 'Active')	;
        if($this->status != '' || $this->status != null)
            $records=$records->where('users.status',$this->status);
        if($this->search_key != '' || $this->search_key != null) 
            $records=$records->where(DB::raw('CONCAT_WS(users.name,email,phone,buyer_companies.company_name,countries.name)'), 'LIKE','%'.$this->search_key.'%');
                /*->orwhere('email','Like','%'.$this->search_key.'%')
                ->orwhere('phone','Like','%'.$this->search_key.'%')
                ->orwhere('buyer_companies.company_name','Like','%'.$this->search_key.'%')
                ->orwhere('countries.name','Like','%'.$this->search_key.'%');*/
      
       if($this->company_type!='')
            {
            $company_type= $this->company_type;
			  $records = $records->Where(function ($query) use ($company_type) {
						foreach ($company_type as $term) {
							$query
								->orWhereRaw(
									'find_in_set("' . $term . '",buyer_companies.company_type)'
								);
						}
					});
            }
            else
            $records = $records ->where(function ($query){
						 $query->whereNotNull('buyer_companies.company_type')->orwhereNull('buyer_companies.company_type');
					});
					
		
		if($this->sub_end_month!='')
            { 
            $sub_end_month= $this->sub_end_month;
			  $records = $records
			             ->whereDate('subscriptions.expairy_date', '>=', NOW())
			            ->where('subscriptions.status','active')
			            // ->whereMonth('subscriptions.expairy_date', '=', '$sub_end_month');
			            ->whereRaw('extract(month from subscriptions.expairy_date) = ?', [$sub_end_month]);

			             
            }
            else
            $records = $records ->where(function ($query){
						 $query->whereNotNull('subscriptions.expairy_date')->orwhereNull('subscriptions.expairy_date');
					});
			
			if($this->sub_type!='')
            { 
            $sub_type= $this->sub_type;
			 /* $records = $records
			             ->whereDate('subscriptions.expairy_date', '>=', NOW())
			            ->where('subscriptions.status','active');
			            if($sub_type=='free') {
                        $records = $records ->where('packages.package_basic_price', '=', 0);
                        } elseif($sub_type=='paid') {
                         $records = $records ->Where('packages.package_basic_price', '>', 0);
                        }*/
                         if($sub_type=='free') {
                       $records = $records
                        //->whereDate('subscriptions.expairy_date', '>=', NOW())
			            //->where('subscriptions.status','active') 
			            ->where('packages.package_basic_price', '=', 0);
                        } elseif($sub_type=='paid') {
                         $records = $records
                        //->whereDate('subscriptions.expairy_date', '>=', NOW())
			            //->where('subscriptions.status','active') 
			            ->Where('packages.package_basic_price', '>', 0);
                        } elseif($sub_type=='both') {
                        
					   // $records ->Where('packages.package_basic_price', '>=', 0);	
					
                        }
			             
            }
            else
            $records = $records ->where(function ($query){
						 $query->whereNotNull('packages.package_basic_price')->orwhereNull('packages.package_basic_price');
					});		
					
			if($this->selected_country_id!='')
			$records = $records->whereIn('users.country_id',$this->selected_country_id);
		    else
            $records = $records ->where(function ($query){
						 $query->whereNotNull('users.country_id')->orwhereNull('users.country_id');
					});	
			$category_ids = [];  
            $sellers = [];
            $category_id=$this->category_id;
            if($category_id!='0'){
                $categorylist=Category::where('parent_id',$category_id)->pluck('id')->all();       // all subcategories                  
                array_push($category_ids,$category_id);  //parent category to array
                foreach ($categorylist as $value){
                if(!in_array($value, $category_ids)) //subctegory id not in $category_id array
                array_push($category_ids,$value); //all category ids as array
                for ($i=0; $i<count($category_ids);$i++){
                $category1=Category::where('parent_id',$category_ids[$i])->get();
                foreach ($category1 as  $value2){  
                if(!in_array($value2->id, $category_ids))
                array_push($category_ids,$value2->id);
                }                            
                }                
                }
                $sellers_list = SellerProduct::select('user_id')->distinct()->WhereIn('seller_products.category_id',$category_ids)->get()->pluck('user_id')->toArray();
                $offline_list = SellerOfflineCategory::select('user_id')->distinct()->WhereRaw( 'find_in_set("' . $category_id . '",seller_offline_categories.category_id)')->get()->pluck('user_id')->toArray();
                if(!empty($sellers_list)&&!empty($offline_list))
                    $combinedArray = array_merge($sellers_list, $offline_list);
                else
                $combinedArray = $sellers_list;
 
	            if(!empty($combinedArray)){
	                $uniqueArray = array_unique($combinedArray);
	                 $records = $records->whereIn('users.id',$uniqueArray);
                }else{
	            $records = $records->whereIn('users.id',$sellers);
	        }
            }
            
       $records=$records 
      // ->where('usertype','seller') 
       ->where('seller_type','Master')->where('users.status','<>','Deleted')     
        ->groupby('users.id')->orderBy('users.name','asc') 
        ->select('buyer_companies.company_name','packages.name as pkg_name',DB::raw("'' AS cmpny_type"),'users.name','users.surname','users.position','users.email','users.phone',DB::raw("countries.name as country_name"),
        DB::raw("CONCAT(buyer_companies.company_street, ',', buyer_companies.company_location, ',', buyer_companies.company_zip) as address"),DB::raw("'' AS ctgry")
        ,DB::raw("(SELECT date FROM subscriptions WHERE subscriptions.user_id = users.id order BY subscriptions.id DESC limit 1) as subscription_date"),DB::raw("(SELECT expairy_date FROM subscriptions WHERE subscriptions.user_id = users.id order BY subscriptions.id DESC limit 1) as expairy_date"),'users.id','buyer_companies.company_type')       
        ->get()->each(function ($row, $inr) {
                       // $row->no = ++$inr; 
                        $userId = $row->id;
                        $cmpny_type = $row->cmpny_type;
                        $user = User::find($userId);
                        $sellerProducts = $user->SellerProduct;
                        
                        ///////////////
        $parent_cat_id=[];
        $values = [];
        foreach ($sellerProducts as $sproduct) {
            $values[] = trim($sproduct->category_id);
            if($sproduct->status=="active" && $sproduct->product_visibility=="Yes"){
                $parent=Category::find($sproduct->category_id);
    
                if(!empty( $parent)) 
                 {  
                    $parent_id=$parent->id;
                    while(!empty($parent)) 
                    {   
                        $parent = $parent->parent;
                        if(!empty( $parent)) 
                            $parent_id=$parent->id;
                    }
                    $parent_cat_id[]= $parent_id; 
                }
            }
        }
        $parent_cat_id = array_unique($parent_cat_id);
       
        $values = array_unique($values);

        $parent_categorylists = Category::whereIn("id", $parent_cat_id)->orderBy('name',"ASC")->get();

        $category_product_count = [];
        foreach ($values as $row1) {
            $prdt_count = SellerProduct::where("status", "active")
                ->where("user_id", $userId)
                ->WhereRaw('find_in_set("' . $row1 . '",category_id)')
                ->count();
            $category_name = Category::find($row1, ["name", "category_pic"]);
            $category_product_count[] = [
                "product_count" => $prdt_count,
                "category" => $category_name,
            ];
        }
        arsort($category_product_count);
        $category_product_count = array_splice($category_product_count, 0, 3);

        $seller_Ofln_Cats = SellerOfflineCategory::select('category_id')->where('user_id', $userId)->first();
        if ($seller_Ofln_Cats) 
            $seller_offine_categorylists = explode(",", $seller_Ofln_Cats->category_id);
        else 
            $seller_offine_categorylists = []; 
        
        $categorylists = Category::whereIn("id", $parent_cat_id)
            ->orwhereIn("id", $seller_offine_categorylists)
            ->where('parent_id',null)
            ->whereNotNull('name')
            ->where('name','<>','')
            ->distinct() 
            ->orderBy('name','asc')
            ->pluck("name")
            ->all();
              $cats = implode( ', ', $categorylists );  
              $row->ctgry = $cats;
                        
                        
           $ctype_values = [];
            foreach (explode(",", $row->company_type) as $ctype_val) {
                $ctype_values[] = trim($ctype_val);
            }
			$ctype_values = array_unique($ctype_values);
			$ctypes = CompanyType::whereIn("id", $ctype_values)
            ->pluck("company_type")
            ->all();          
             $ctype = implode( ', ', $ctypes );  
             $row->cmpny_type = $ctype;           
                     
             $row->id = '';
             $row->company_type = '';
                        
                        
                    });


        return $records;  
       
    }

     public function headings() :array
    {
        
		return [" Company Name","Package" ," Company Type(s)"," Name"," Last name"," Job Title"," Mail address"," Phone#"," Country"," Location (City)"," Active product categories"," Subscription start","Subscription end"];
		//return [" SL No"," SELLER NAME ", " COMPANY NAME"," EMAIL"," PHONE"," CREATED AT"," ADDRESS"," COUNTRY NAME"," SUBSCRIPTION END"," Category"," Company Type"];
    }

     public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:L1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size'=>13,
                    ]
                ]);
            },
        ];
    }
 }   

?>