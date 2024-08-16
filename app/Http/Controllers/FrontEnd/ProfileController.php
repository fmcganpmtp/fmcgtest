<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;  
use Illuminate\Validation\Rule;
use DB;
use App\Models\BuyerCompany;
use App\Models\CompanyRegion;
use App\Models\Chat_contact_delete;
use App\Models\CompanyType;
use App\Models\SellerOpeningTime;
use App\Models\OrderDetail;
use App\Models\Productbrand;
use App\Models\Country;
use App\Models\BusinessInsight;
use App\Models\KycFile;
use App\Models\SellerOfflineCategory;
use App\Models\Subscription;
use App\Models\SellerMessage;
use App\Models\Category;
use App\Models\Mynetworks;
use App\Models\Mynetwork_request;
use App\Models\Message;
use App\Models\SellerProduct;
use App\Models\LoginActivity;
use App\Models\ProfileAccountDeleteRequest;
use App\Models\SellerProductImage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\FrontEnd\PublicMiddlewareController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    protected $PublicMiddlewareController;
    public function __construct(
        PublicMiddlewareController $PublicMiddlewareController
    ) {
        $this->PublicMiddlewareController = $PublicMiddlewareController;
    }
        function isMobile() {
    if(isset($_SERVER['HTTP_USER_AGENT'])) {
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(tablet|ipad|amazon|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($useragent))) {
        return true ;
    } ;

    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
            return true ;
        }
    }
    return 0 ;
}

public function deleteEmployee(Request $request) {   
    $userId = Auth::guard("user")->user()->id;
    if($request->empId!=''){
        $status='Deleted';
        $user = User::find($request->empId);
        $user->status = 'Deleted';
        $user->save();
        return response()->json(['message' => 'Profile Deleted','status' => true]);
    }else{
        return response()->json(['message' => 'Profile not found','status' => false]);
    }     
}
   public function updateSellerEmployee(Request $request)
    { 
        $userId = Auth::guard("user")->user()->id;
        $user = User::find($userId);
        
        
        
        
            $rules=[
                "name" => "required",
                "surname" => "required",
                "position" =>"required",
                "email" => ["required","email",
                    "regex:/(.+)@(.+)\.(.+)/i",
                    Rule::unique("users")
                        ->ignore($userId)
                        ->where(function ($query) {
                            return $query->where("status", "<>", "Deleted");
                        }),
                ],
                
                "phone" => [
                    "required",
                    'regex:/^(^([+]+)(\d+)?$)$/',
                    Rule::unique("users")
                        ->ignore($userId)
                        ->where(function ($query) {
                            return $query->where("status", "<>", "Deleted");
                        }),
                ],
                
            ];
            
            
              
        $request->validate($rules);
        $input["name"] = $request->get("name");
        $input["surname"] = $request->get("surname");
        $input["email"] = $request->get("email");
        $input["phone"] = $request->get("phone");
        $input["position"] = $request->get("position");
        
        $input["company"] = "Yes";
       

        if ($user->email != $input["email"]) {
            $input["email_status"] = "No";
            $input["varification_status"] = "not varified";
        }

        DB::table("users")
            ->where("id", $userId)
            ->update($input);
            
        
       //  echo json_encode("Profile Updated");
       return response()->json(['message' => 'Profile Updated']);
    }
   public function remove_abtimage1(Request $request)
    {
        if($request->id != ''){
            //fetching brand data
            $buyerCompany = BuyerCompany::find($request->id);
            if($buyerCompany){
               
                
                
                if($buyerCompany->comp_about_img1 != ''){
                    
                     $buyerCompany->update(['comp_about_img1'=>'']);
                     if (File::exists("/uploads/BuyerCompanyBanner/" . $buyerCompany->comp_about_img1)) {
                        File::delete("/uploads/BuyerCompanyBanner/" . $buyerCompany->comp_about_img1);
                     }

                    $returnArray['result'] = true;
                    $returnArray['message'] = 'Image removed successfully.';
                } else {
                    $returnArray['result'] = false;
                    $returnArray['message'] = 'Failed. Image not found.';
                }
            } else {
                $returnArray['result'] = false;
                $returnArray['message'] = 'Failed. User details not found.';
            }
        } else {
            $returnArray['result'] = false;
            $returnArray['message'] = 'Failed. User details not found.';
        }
        return response()->json($returnArray);
    } 
    
    public function remove_abtimage2(Request $request)
    {
        if($request->id != ''){
            //fetching brand data
            $buyerCompany = BuyerCompany::find($request->id);
            if($buyerCompany){
               
                
                
                if($buyerCompany->comp_about_img2 != ''){
                    
                     $buyerCompany->update(['comp_about_img2'=>'']);
                     if (File::exists("/uploads/BuyerCompanyBanner/" . $buyerCompany->comp_about_img2)) {
                        File::delete("/uploads/BuyerCompanyBanner/" . $buyerCompany->comp_about_img2);
                     }

                    $returnArray['result'] = true;
                    $returnArray['message'] = 'Image removed successfully.';
                } else {
                    $returnArray['result'] = false;
                    $returnArray['message'] = 'Failed. Image not found.';
                }
            } else {
                $returnArray['result'] = false;
                $returnArray['message'] = 'Failed. User details not found.';
            }
        } else {
            $returnArray['result'] = false;
            $returnArray['message'] = 'Failed. User details not found.';
        }
        return response()->json($returnArray);
    }   
   public function submitForgetPasswordEmployees(Request $request)
      {
         
         if (Auth::guard("user")->check()) 
         Auth::guard("user")->logout();
         elseif (Auth::guard("admin")->check()) 
         Auth::guard("admin")->logout();
         $token = Str::random(64); 
         /* $request->validate([
              'email' => ['required','email','exists:users', 'regex:/(.+)@(.+)\.(.+)/i'],
          ]);*/
  
        
          
          $query =  DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
           
  
          Mail::send('emails.forgetPassword', ['token' => $token], function($message) use($request){
              $message->to($request->email);
              $message->subject('Reset Password - FMCG');
          });

          //Mail::to($request->email)->send(new UserCreatedMail($request));
  
        //  return back()->with('message', 'We have e-mailed your password reset link!');
        echo json_encode("We have e-mailed your password reset link!");
      } 
    public function CreateSellerProfile()
    {
        if (Auth::guard("user")->check()) {
            if (!$this->PublicMiddlewareController->checkUserlogin()) {
                Auth::guard("user")->logout();
                return redirect(route("home"))->with(
                    "message",
                    "Access Denied"
                );
            }
            if (
                !$this->PublicMiddlewareController->checkUserValidity() &&
                Auth::guard("user")->user()->seller_type == "Co-Seller"
            ) {
                Auth::guard("user")->logout();
                return redirect(route("home"));
            }
        }

        $user_id = Auth::guard("user")->user()->id;
        $user = User::find($user_id);
        $countries = Country::select("id", "name")->get();

        $delete_request = ProfileAccountDeleteRequest::where(
            "user_id",
            $user_id
        )
            ->where("status", "New")
            ->get();

        if (count($delete_request) > 0) {
            $delete_request_active = true;
        } else {
            $delete_request_active = false;
        }

        $company_types = CompanyType::select("id", "company_type")->get();
        //  if(empty($company_types )) $company_types ='';
        $usertype = Auth::guard("user")->user()->usertype;

       /* if ($usertype != "seller") {
            //if not seller redirect to home
            return redirect()->route("home");
        }*/
        return view(
            "frontEnd.profile-creation.CreateSeller",
            compact(
                "user",
                "countries",
                "company_types",
                "delete_request_active"
            )
        );
    }
    public function addNewEmployees(Request $request)
    {
        $package_data = DB::table("subscriptions")
            ->leftJoin("order_details","subscriptions.order_id","=","order_details.id")
            ->leftJoin("packages", "packages.id","=","order_details.package_id" )
            ->where("subscriptions.user_id", "=", Auth::guard("user")->user()->id )
            ->where("subscriptions.status", "Active")
            ->orderBy("subscriptions.id", "DESC")
            ->first();

        $user = User::where("parent_id",Auth::guard("user")->user()->id)
        ->where("status", "<>", "Deleted")
        ->get();

       /* if (
            count($user) >= $package_data->no_of_accounts ||
            $package_data->expairy_date < date("Y-m-d") ||
            $package_data->subscription_type != "Extended"
        ) {
            return json_encode("Co-Seller Adding count Exceeded!");
        }*/

        $request->validate([
            "name" => "required",
            "email" => [ "required", "email", "regex:/(.+)@(.+)\.(.+)/i",
                Rule::unique("users")->where(function ($query) {
                    return $query->where("status", "<>", "Deleted");
                }),
            ],
            "phone" => [  "required", 'regex:/^(^([+]+)(\d+)?$)$/',
                Rule::unique("users")->where(function ($query) {
                    return $query->where("status", "<>", "Deleted");
                }),
            ],
           // "username" => "required",
           /* 'password' => [ 'required', 'string',
                'min:8', 'confirmed',         // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],*/
        ]);

        $input = $request->all();
            if(!array_key_exists("unlimited_stock",$input))
            $input['unlimited_stock']='No';
          /*  if(!array_key_exists("stock_count",$input) || $input['stock_count']==null)
            $input['stock_count']=0;*/
            $parent_id=Auth::guard("user")->user()->id;
           if(Auth::guard("user")->user()->seller_type=="Co-Seller")
           $parent_id=Auth::guard("user")->user()->parent_id;
           
        $input["parent_id"] = $parent_id;
        $input["seller_type"] = "Co-Seller";
        $input["country_id"] =Auth::guard('user')->user()->country_id;
        $input["usertype"] = "seller";
        $input["status"] = "Invited";
        $usertype = Auth::guard("user")->user()->usertype;
        /*if ($usertype == "seller") {
            $input["usertype"] = "seller";
        }
        if ($usertype == "buyer") {
            $input["usertype"] = "buyer";
        }*/
       // $input["password"] = Hash::make($request->get("password"));
        $token = $token =Str::random(60) .$parent_id. date("Ymdss");
        $input["token_number"] = $token;
        if (request()->hasFile("imgupload_employee")) {
            $extension = request("imgupload_employee")->extension();
            $fileName = "user_pic" . time() . "." . $extension;
            $destinationPath = public_path() . "/uploads/userImages";
            request("imgupload_employee")->move($destinationPath, $fileName);
            $input["profile_pic"] = $fileName;
        }
        
        $user = User::create($input);
        
           
         Mail::send('emails.newEmployeeInvitation', ['email' => $request->email,'token' => $token,'name' => $request->name,'company_name' => Auth::guard("user")->user()->BuyerCompany->company_name??""], function($message) use($request){
              $message->to($request->email);
              $message->subject('Invitation to join - FMCG');
          }); 
          
        /*Mail::send(
            "admin/seller/email-template",
            [
                "name" => $input["name"],
                "email" => $input["email"],
               // "password" => $request->get("password"),
            ],
            function ($message) use ($input) {
                $message->from("example@gmail.com", "Fmcg");
                $message
                    ->to($input["email"], $input["name"])
                    ->subject("Fmcg Login Credential");
            }
        );*/
        $usertype = Auth::guard('user')->user()->usertype;  
        
            echo json_encode("Employee Added");

       
    }
    public function addPasswordForm() {
        Auth::guard("user")->logout();
       // dd(Request::get('email'));
          if($this->isMobile()) { 
		  //  return view('auth.passwords.addPassword_mobile', ['token' => $token]);
		    return view('auth.passwords.addPassword_mobile');
           
       } else {
         
           // return view('auth.passwords.addPassword', ['token' => $token]);
            return view('auth.passwords.addPassword');
        }
        
        
     }
     
     public function savePasswordForm(Request $request)
      {
          $request->validate([
           //   'email' =>[ 'required','email', 'regex:/(.+)@(.+)\.(.+)/i','exists:users'],
              'password' => [
                'required','string','min:8', 'confirmed', 'regex:/[a-z]/',  'regex:/[A-Z]/', 'regex:/[0-9]/','regex:/[@$!%*#?&]/'],
              'password_confirmation' => 'required'
          ]);
  
         
  
         /* if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }*/
  
          $user = User::where('email', $request->email)->Where("status",  "Invited")
                      ->update(['password' => Hash::make($request->password),'token_number' => "",'status' => "Active"]);
                    
 
     //     DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
          return redirect()->route('user-login');
      }
     
     
     
    public function ViewProfileSeller()
    {
        if (Auth::guard("user")->check()) {
            if (!$this->PublicMiddlewareController->checkUserlogin()) {
                Auth::guard("user")->logout();
                return redirect(route("home"))->with(
                    "message",
                    "Access Denied"
                );
            }
            if (
                !$this->PublicMiddlewareController->checkUserValidity() &&
                Auth::guard("user")->user()->seller_type == "Co-Seller"
            ) {
                Auth::guard("user")->logout();
                return redirect(route("home"));
            }
        }

        $user_id = Auth::guard("user")->user()->id;
        $user = User::find($user_id);
        $countries = Country::select("id", "name")->get();

        $delete_request = ProfileAccountDeleteRequest::where(
            "user_id",
            $user_id
        )
            ->where("status", "New")
            ->get();

        if (count($delete_request) > 0) {
            $delete_request_active = true;
        } else {
            $delete_request_active = false;
        }

        $company_types = CompanyType::select("id", "company_type")->get();
        //  if(empty($company_types )) $company_types ='';
        $usertype = Auth::guard("user")->user()->usertype;

       /* if ($usertype != "seller") {
            //if not seller redirect to home
            return redirect()->route("home");
        }*/
        
        
        $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get(); 
        $seller_OflnCats = SellerOfflineCategory::select('category_id')->where('user_id', $user_id)->first();
        if($this->isMobile()) { 
           return view("frontEnd.profile-creation.ViewProfileSeller_mobile",compact("user","countries","categories","seller_OflnCats","company_types","delete_request_active" ));
        } else {
            return view("frontEnd.profile-creation.ViewProfileSeller",compact("user","countries","company_types","categories","seller_OflnCats","delete_request_active" ));
        }
        
        
        
    }
    
    
    
    
    
    public function ViewSellerProfile($profId)
    {
       
        if (Auth::guard("user")->check()) {
            if (!$this->PublicMiddlewareController->checkUserlogin()) {
                Auth::guard("user")->logout();
                return redirect(route("home"))->with(
                    "message",
                    "Access Denied"
                );
            }
            if (
                !$this->PublicMiddlewareController->checkUserContactValidity()
            ) {
                Auth::guard("user")->logout();
                return redirect(route("home"));
            }
        }

        $userId = $profId;
        $user = User::find($userId);
        $sellerProducts = $user->SellerProduct;
        $values = [];
        if ($user->seller_type != "Master") {
            $user = User::find($user->parent_id);
        }
        $usertype = Auth::guard("user")->user()->usertype;
       /* if ($usertype == "guest") {
            //if guest redirect to home
            return redirect()->route("home");
        }*/
        $parent_cat_id=[];
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
        foreach ($values as $row) {
            $prdt_count = SellerProduct::where("status", "active")
                ->where("user_id", $userId)
                ->WhereRaw('find_in_set("' . $row . '",category_id)')
                ->count();
            $category_name = Category::find($row, ["name", "category_pic"]);
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
            
        

        $login_id = null;
        if (Auth::guard("user")->check()) {
            $login_id = Auth::guard("user")->user()->id;
        }
        $counts = Mynetworks::where("user_id", $login_id)
            ->whereRaw('find_in_set("' . $profId . '",mynetwork_id)')
            ->count();
        if ($counts > 0 || $profId == $login_id) {
            $network = false;
        } else {
            $network = true;
        }

        $my_products = SellerProduct::select("*")
            ->where("status", "active")
            ->where("user_id", $userId)
            ->where("status","<>", "deleted")
            ->latest()
            ->take(4)
            ->get();
        $my_networks = Mynetworks::where("user_id", $userId)
            ->pluck("mynetwork_id")
            ->first();
        $network_id = explode(",", $my_networks);
        $network_list = User::select("name", "id", "profile_pic")
            ->whereIn("id", $network_id)
            ->get();
        $chat_data = [];
        if (!$network_list->isEmpty()) {
            foreach ($network_list as $key => $row) {
                $unreadCount = Message::where("from_user", $row->id)
                    ->where("to_user", $userId)
                    ->where("message_status", "unread")
                    ->count();
                $latestMessage = Message::where(function ($query) use (
                    $userId,
                    $row
                ) {
                    $query
                        ->where("from_user", $userId)
                        ->where("to_user", $row->id);
                })
                    ->orWhere(function ($query) use ($userId, $row) {
                        $query
                            ->where("from_user", $row->id)
                            ->where("to_user", $userId);
                    })
                    ->orderBy("id", "desc")
                    ->take(5)
                    ->get();
                // })->latest()->first();
                $chat_data[$key] = [
                    "contact" => $row,
                    "latestMessage" => $latestMessage,
                    "unreadcount" => $unreadCount,
                ];
            }
        }
        //$profile_visit_count = BusinessInsight::where("profile_id",$userId)->count();
        $profile_visit_count = BusinessInsight::where("profile_id",$userId)->distinct('user_id')->count();
        $product_count = SellerProduct::where("user_id", $userId)
        ->where("status", "active")
        ->where("status","<>", "deleted")
        ->count();
        // $network_count = Mynetworks::where('user_id',$userId)->count();
        $network_ids = Mynetworks::select("mynetwork_id")
            ->where("user_id", $userId)
            ->first();
        $network_count = $network_ids
            ? count(explode(",", $network_ids)) - 1
            : 0;
       
        $clientIP = \Request::ip();
        $prof_vist_count=BusinessInsight::where('user_id','=',$login_id)->where('profile_id','=',$userId)->where('ip_address','=',$clientIP)->count();
        $insight = [];
        
        if($login_id!=$userId && $prof_vist_count==0) {
        $insight = [
            "user_id" => $login_id,
            "profile_id" => $profId,
            "ip_address" => $clientIP,
        ];
        BusinessInsight::create($insight);
        }

         if($this->isMobile())
         {
           return view(
            "frontEnd.profile-creation.SellerProfile_mobile",compact("user","categorylists", "network","profile_visit_count","product_count","network_count","category_product_count","parent_categorylists"));
           
       }
        else 
          { 
              return view( "frontEnd.profile-creation.SellerProfile",compact("user","categorylists","network","profile_visit_count","product_count", "network_count","category_product_count","parent_categorylists"));
              
        }
    }
    
    
    
    
    
    
    //list all categories
    public function offlineCategories(request $request) {
        
        $userId = $user_id = Auth::guard("user")->user()->id;
        $user = User::find($user_id);
        $sellerProducts = $user->SellerProduct;
        $values = [];
		
		
        if ($user->seller_type != "Master") {
            $user = User::find($user->parent_id);
        }
        /*$usertype = Auth::guard("user")->user()->usertype;
        if ($usertype == "guest") {
            //if guest redirect to home
            return redirect()->route("home");
        }*/
        $parent_cat_id=[];
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

        $categories = $parent_categorylists = Category::where('name','Like',$request->term.'%')->where('parent_id', null)->whereNotIn("id", $parent_cat_id)->orderBy('name',"ASC")
                                              ->select("id","name")
                                              ->get();
        
    //   $categories = Category::where('name','Like',$request->term.'%')->where('parent_id', null)->orderby('name', 'asc')
    //        ->select("id","name")
       //     ->get();
        return $categories;
}
public function CompanyTypes(request $request) {
        
           $company_types = CompanyType::where('company_type','Like',$request->term.'%')
           //->orderby('company_type', 'asc')
           ->select("id","company_type")
           ->get();
        
    //   $categories = Category::where('name','Like',$request->term.'%')->where('parent_id', null)->orderby('name', 'asc')
    //        ->select("id","name")
       //     ->get();
        return $company_types;
    }

public function offlineCategoriesAdmin(request $request) {
        
        
        $userId = $user_id = $request->user_id;
        if($user_id){
        $user = User::find($user_id);
        $sellerProducts = $user->SellerProduct;
        $values = [];
		if ($user->seller_type != "Master") {
            $user = User::find($user->parent_id);
        }
       
        $parent_cat_id=[];
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

        $categories = $parent_categorylists = Category::where('name','Like',$request->term.'%')->where('parent_id', null)->whereNotIn("id", $parent_cat_id)->orderBy('name',"ASC")
                                              ->select("id","name")
                                              ->get();
        }
        else
        $categories = $parent_categorylists = Category::where('name','Like',$request->term.'%')->where('parent_id', null)->orderBy('name',"ASC")
                                              ->select("id","name")
                                              ->get();
        return $categories;
}

    public function show()
    {
        $users = User::all();
        return view("frontEnd.pages.TermsAndCondition", compact("users"));
    }

    public function SendKYCMail(Request $request)
    {
        $token =Str::random(60) . Auth::guard("user")->user()->id . date("Ymdss");
        $user_id = Auth::guard("user")->user()->id;
        
        $token=Hash::make($token);
        $token=str_replace('/','a', $token);
		$token=str_replace('%','a', $token);

        $token_exists = DB::table("users")->where("token_number", $token)->exists();
        while ($token_exists) {
            $token =Str::random(60) .$user_id. date("Ymdss");
            $token=Hash::make($token);
            $token=str_replace('/','a', $token);
            $token=str_replace('%','a', $token);

            $token_exists = DB::table("users")->where("token_number", $token)->exists();
            if (!$token_exists)
                break;
        }
        DB::table("users")
            ->where("id", $user_id)
            ->update(["token_number" => $token]);

        Mail::send(
            "emails.KYCApprovalMailTemplate",
            ["token" => $token, "user_id" => Auth::guard("user")->user()->id],
            function ($message) use ($request) {
                $email = Auth::guard("user")->user()->email;
                $message->to($email);
                $message->subject("Verify Email - FMCG");
            }
        );
        return back()->with(
            "message",
            "Verfication Mail has Been Send to your Email!"
        );
    }

    public function sendBuyerApprovalMail(Request $request)
    {
        $token =
            Str::random(60) . Auth::guard("user")->user()->id . date("Ymdss");
        $user_id = Auth::guard("user")->user()->id;
        DB::table("users")
            ->where("id", $user_id)
            ->update(["token_number" => $token]);

        Mail::send(
            "emails.BuyerApprovalMail",
            ["token" => $token, "user_id" => Auth::guard("user")->user()->id],
            function ($message) use ($request) {
                $email = Auth::guard("user")->user()->email;
                $message->to($email);
                $message->subject("Verify Email - FMCG");
            }
        );
        return back()->with(
            "message",
            "Verfication Mail has Been Send to your Email!"
        );
    }

    public function SellerKYCApproval()
    {
        if (Auth::guard("user")->check()) {
            if (!$this->PublicMiddlewareController->checkUserlogin()) {
                Auth::guard("user")->logout();
                return redirect(route("home"))->with(
                    "message",
                    "Access Denied"
                );
            }

            if (
                !$this->PublicMiddlewareController->checkUserValidity() &&
                Auth::guard("user")->user()->seller_type == "Co-Seller"
            ) {
                Auth::guard("user")->logout();
                return redirect(route("home"));
            }
        }
        if (Auth::guard("user")->user()->seller_type == "Co-Seller") {
            return redirect()->route("home");
        }
        $user_id = Auth::guard("user")->user()->id;
        $email_status = User::where("id", $user_id)->value("email_status");
         if($this->isMobile()) { 
          return view(
            "frontEnd.profile-creation.SellerKYCAprroval_mobile",
            compact("email_status")
        );
            
        } else {
          
            return view(
            "frontEnd.profile-creation.SellerKYCAprroval",
            compact("email_status")
        );
        }
        }
    public function ApprovedKYC($token)
    {
        $user = User::where("token_number", $token)->first();
        $user_id=0;
     
        if (!empty($user) > 0) {
            $user_id=$user->id;

            $kycdocs_varified = DB::table("kyc_files")
            ->select(DB::raw("count('*') as status_cnt"))
            ->where("user_id", $user_id)
            ->where("status", "Active")
            ->pluck("status_cnt")
            ->first();

            $input["varification_status"] = "not varified";
            if ($kycdocs_varified == 3) 
                $input["varification_status"] = "varified";
            $input["email_status"] = "Yes";
            
            DB::table("users")
                ->where("id", $user_id)
                ->where("token_number", $token)
                ->update($input);
            $msg = "Email Verified";
            $status='success';
        } 
        else 
          { 
              $msg = "Token Number Expired.Please Resend Email.";
              $status='error';

          }
        

        if (Auth::guard("user")->check()) {
            
           $login_id=Auth::guard('user')->user()->id;
            if($login_id!=$user_id && $user_id!=0)
                Auth::guard('user')->loginUsingId($user_id);
                
            return redirect()
                    ->route("seller.kyc.approval")
                    ->with(["message"=>$msg,"status"=>$status]);
        } 
        else {
            if($msg == "Email Verified")
            {
                Auth::guard('user')->loginUsingId($user_id);
                LoginActivity::create(['user_id'=>Auth::guard('user')->id()]);

                if(Auth::guard('user')->user()->seller_type=='Co-Seller'){
                            $user_id=Auth::guard('user')->user()->parent_id;
                            $package_data = DB::table('subscriptions')
                                            ->leftJoin('order_details', 'subscriptions.order_id', '=', 'order_details.id')
                                            ->leftJoin('packages', 'packages.id', '=', 'order_details.package_id')
                                            ->leftJoin('package_accounts', 'package_accounts.id', '=', 'order_details.accounts_id')
                                            ->where('subscriptions.user_id', '=',$user_id)
                                            ->where('subscriptions.status','Active')
                                            ->select('subscriptions.id','subscriptions.expairy_date','packages.subscription_type')
                                            ->orderBy('subscriptions.id','DESC')->first();
                                                     
                            if(!empty($package_data)){  
                                if( $package_data->subscription_type=='Extended' && $package_data->expairy_date>=date('Y-m-d'))
                                {
 
                                }
                                else
                                { 
                                    Session::flush();
                                    Auth::guard('user')->logout(); 
                                    return redirect(route('home'))->with('message','Access Not Allowed,Please Check Your Package Validity'); 
                                }                          
                            }

                        }
                $user =OrderDetail::where('user_id',$user_id)->first(); 
                if(!empty($user) || Auth::guard('user')->user()->seller_type=='Co-Seller')
                        return redirect("/")->with("message", $msg);
                else
                    return redirect(route('package.listing'))->with("message", $msg); 
            }
            return redirect("/")->with(["message"=>$msg,"status"=>$status]);
        }
    }

    public function ApprovedBuyerEmail($token)
    {
        $user = User::where("token_number", $token)
            ->first();
        $user_id=0;

        if (!empty($user) > 0) {
            $user_id=$user->id;

            $input = ["email_status" => "Yes"];
            DB::table("users")
                ->where("id", $user_id)
                ->where("token_number", $token)
                ->update($input);
            $msg = "Email Verified";
        } else {
            $msg = "Email Not Verified";
        }

        if (Auth::guard("user")->check()) {
            return redirect()
                ->route("buyer.profile")
                ->with("message", $msg);
        } else {
            return redirect("/")->with("message", $msg);
        }
    }

    public function UpdateKycDoc(Request $request)
    { 
        $image = $request->file('image'); 
       /* if($image){
            $request->validate([
                'image' =>  'mimes:jpeg,jpg,png,gif,doc,docx,xls,pdf,webp|max:1000||dimensions:max_width=150,max_height=100',
            ]);
        }*/
       $request->validate(
           ['image' =>  'mimes:jpeg,jpg,png,gif,doc,docx,xls,pdf,webp'],
           [ 'image.mimes' => 'The  file must be of type: jpeg, jpg, png, gif, doc, docx, xls, pdf, webp.']);

    
    
        $file_type = request("file_type");
        $user_id = Auth::guard("user")->user()->id;
        $extension = request("image")->extension();
        $fileName = "kyc_doc" . time() . "." . $extension;
        $destinationPath = public_path() . "/uploads/KYCFiles";
        request("image")->move($destinationPath, $fileName);
        $data = [
            "user_id" => $user_id,
            "file_path" => $fileName,
            "reason" => "",
            "file_type" => $file_type,
        ];
        $KycDoc = "";
        //checking doc already exists or not
        
        $kycfile_data = KycFile::where('user_id',$user_id)
                         ->where("status",'<>', "Rejected")
                        ->where('file_type',$file_type)->first();
                 
        if(empty($kycfile_data))                
            $update = KycFile::create($data);
        else
            $kycfile_data->update($data);
        /*
        $KycDoc = KycFile::select("id", "status")
            ->where([["user_id", $user_id], ["file_type", "=", $file_type]])
            ->first();

        if (!empty($KycDoc->id)) {
            if ($KycDoc->status == "Rejected") {
                $data["status"] = "In-Active";
            }
            $update = DB::table("kyc_files")
               // ->where("status",'<>', "Rejected")
                ->where("id", $KycDoc->id)
                ->update($data);
        } else {
            $update = KycFile::create($data);
        }*/

        return redirect()
            ->route("seller.kyc.approval")
            ->with("message", "File Uploaded");
    }

   public function UpdateSeller(Request $request)
    { 
        $userId = Auth::guard("user")->user()->id;
        $user = User::find($userId);
        
        $profile_pic = $user->profile_pic??'';
        $company_image = $user->BuyerCompany->company_image;
        
        if (Auth::guard("user")->user()->seller_type != "Co-Seller" ) {
            $rules=[
                "name" => "required",
                "surname" => "required",
                "email" => [
                    "required",
                    "email",
                    "regex:/(.+)@(.+)\.(.+)/i",
                    Rule::unique("users")
                        ->ignore($userId)
                        ->where(function ($query) {
                            return $query->where("status", "<>", "Deleted");
                        }),
                ],
                "country_id" => "required",
                "about_company" => "required",
                "offline_categories" => "required",
               // "imgpicture" => "required",
                
                "offline_categories" => "required",
                "position" => "required",
                "accepted_payments" => "required",
                "phone" => [
                    "required",
                    'regex:/^(^([+]+)(\d+)?$)$/',
                    Rule::unique("users")
                        ->ignore($userId)
                        ->where(function ($query) {
                            return $query->where("status", "<>", "Deleted");
                        }),
                ],
                "company_name" => "required",
                "company_type" => "required",
                "company_street" => "required",
                // 'company_zip' => 'required|regex:/\b\d{5}\b/',
                "company_zip" => "required",
                "company_location" => "required",
            ];
            
            if($company_image=='')
             $rules['imgpicture'] = "required";
             
             if($profile_pic=='')
             $rules['profile_pic'] = "required";
              
            $request->validate($rules);
        } else {
            $rules=[
                "name" => "required",
                "surname" => "required",
                "email" => [
                    "required",
                    "email",
                    "regex:/(.+)@(.+)\.(.+)/i",
                    Rule::unique("users")
                        ->ignore($userId)
                        ->where(function ($query) {
                            return $query->where("status", "<>", "Deleted");
                        }),
                ],
                "phone" => [
                    "required",
                    'regex:/^(^([+]+)(\d+)?$)$/',
                    Rule::unique("users")
                        ->ignore($userId)
                        ->where(function ($query) {
                            return $query->where("status", "<>", "Deleted");
                        }),
                ],
            ];
            if($profile_pic=='')
             $rules['profile_pic'] = "required";
            $request->validate($rules);
        }



        $offline_categories = $request->get("offline_categories");
        $sOflinCats = SellerOfflineCategory::where("user_id", $userId)->first();
        $of_cats = '';
        if(!empty($offline_categories)){
        foreach($offline_categories as $offline_category) {
            $of_cats = $of_cats .$offline_category . ","; }
        }
        if (empty($sOflinCats)) {
         SellerOfflineCategory::create([
                "user_id" => $userId,
                "category_id" => $of_cats,
            ]);
       } else {
           $sOflinCats->update(["category_id" => $of_cats]);
        }

        

        $input["name"] = $request->get("name");
        $input["surname"] = $request->get("surname");
        $input["email"] = $request->get("email");
        $input["phone"] = $request->get("phone");
        $input["position"] = $request->get("position");
        $input["country_id"] = $request->get("country_id");
        $input["usertype"] = "seller";
        $input["company"] = "Yes";
        $input["hide_promo_email"] = $request->get("hide_promo_email");
        $input["newsletter_status"] = $request->get("newsletter_status");

        if ($user->email != $input["email"]) {
            $input["email_status"] = "No";
            $input["varification_status"] = "not varified";
        }

        DB::table("users")
            ->where("id", $userId)
            ->update($input);
            
        if($user->country_id!=$input["country_id"])    
        {
            $coUser_list=User::where('parent_id',$userId)->get();
	    	foreach ($coUser_list as $key => $value1) 
	    		DB::table('users')->where('id',$value1->id)->update(['country_id'=>$input["country_id"]]);	    	
        }
        $languages_speak = $deliver_options = $accepted_payments = "";
        if (!empty($request->get("languages_speak"))) {
            $languages_speak = $request->get("languages_speak");
        }

        if (!empty($request->get("deliver_options"))) {
            $deliver_options = $request->get("deliver_options");
        }

        if (!empty($request->get("accepted_payments"))) {
            $accepted_payments = $request->input("accepted_payments");
        }
        //seller
        $c_types = '';
        if(!empty($request->get("company_type"))){
        foreach($request->get("company_type") as $company_type) {
            $c_types = $c_types .$company_type . ","; }
        }
        $keywords_removed=[];
        if(!empty($request->get("about_company")))
        {
            $profile_keywords=$request->get("about_company");
           // str_replace(array('.', ','), '' , $profile_keywords);
            $profile_keywords = strtr($profile_keywords, array('.' => '', ',' => ''));
            $keywords = explode(" ", $profile_keywords);
            $omit_words = array('a','is','was','should','at','and'); 
            $keywords_removed=array_diff($keywords,$omit_words); 
            array_unique($keywords_removed);
            $keywords_removed = implode(',', $keywords_removed);
            
        } 
        else $keywords_removed=$user->BuyerCompany->profile_keywords;
       /* $profile_keywords_prev = $user->BuyerCompany->profile_keywords;
        $profile_keywords_prev =  explode(',', $profile_keywords_prev);
        $keywords_removed_merg =  array_merge($keywords_removed,$profile_keywords_prev); 
        array_unique($keywords_removed_merg);
        $keywords_removed_merg = implode(',', $keywords_removed_merg);*/
        $input = [
            "user_id" => $userId,
            "company_name" => $request->get("company_name"),
            "company_type" => $c_types,
            "company_street" => $request->get("company_street"),
            "company_zip" => $request->get("company_zip"),
            "company_location" => $request->get("company_location"),
            "company_land" => $request->get("company_land"),
            "registration_no" => $request->get("registration_number"),
            "deliver_options" => $deliver_options,
            "accepted_payments" => $accepted_payments,
            "languages_speak" => $languages_speak,
            "tax_reg_no" => $request->get("tax_reg_no"),
            "registration_number" => $request->get("registration_number"),
            "registration_number" => $request->get("registration_number"),
            "about_company" => $request->get("about_company"),
            "profile_keywords" => $keywords_removed,
            
        ]; 
        if (request()->hasFile("imgpicture")) {
            $validator = $request->validate([
                "imgpicture" => "required|image|mimes:jpeg,png,bmp,gif,svg",
            ]);
            $extension = request("imgpicture")->extension();
            $fileName = "company_pic" . time() . "." . $extension;
            $destinationPath = public_path() . "/uploads/BuyerCompany";
            request("imgpicture")->move($destinationPath, $fileName);
            $input["company_image"] = $fileName;
        }
        // Check seller company already or not if exists update else create

        $user = BuyerCompany::where("user_id", "=", $userId)->first();
        if (isset($user->id)) {
            $id = $user->id;
            $sellercmpy = DB::table("buyer_companies")
                ->where("id", $id)
                ->update($input);
        } else {
            $sellercmpy = BuyerCompany::create($input);
            $buyer_company_id = $sellercmpy->id;
            $buyer_input["company_id"] = $buyer_company_id;
            DB::table("buyer_companies")
                ->where("user_id", $userId)
                ->update($buyer_input);
        }

        $input = [
            "seller_id" => $userId,
        ];

        $checkSun = $request->get("chSunday");
        $input["day"] = "Sunday";
        $input["opening_time"] = $request->get("opSundayhr");
        $input["closing_time"] = $request->get("clSundayhr");
        $input["Open_am_pm"] = $request->get("SunOpen_am_pm");
        $input["Close_am_pm"] = $request->get("WedClose_am_pm");

        if ($checkSun == "Yes") {
            $input["closed"] = "Yes";
            $input["opening_time"] = "";
            $input["closing_time"] = "";
            $input["Open_am_pm"] = "";
            $input["Close_am_pm"] = "";
        } else {
            $input["closed"] = "No";
        }
        $sunday = SellerOpeningTime::where("seller_id", "=", $userId)
            ->where("day", "=", "Sunday")
            ->first();
        if (isset($sunday->id)) {
            $SellerOpeningTime = DB::table("seller_opening_times")
                ->where("id", $sunday->id)
                ->update($input);
        } else {
            $SellerOpeningTime = SellerOpeningTime::create($input);
        }

        $chMonday = $request->get("chMonday");
        $input["day"] = "Monday";
        $input["opening_time"] = $request->get("opMondayhr");
        $input["closing_time"] = $request->get("clMondayhr");
        $input["Open_am_pm"] = $request->get("MonOpen_am_pm");
        $input["Close_am_pm"] = $request->get("MonClose_am_pm");
        if ($chMonday == "Yes") {
            $input["closed"] = "Yes";
            $input["opening_time"] = "";
            $input["closing_time"] = "";
            $input["Open_am_pm"] = "";
            $input["Close_am_pm"] = "";
        } else {
            $input["closed"] = "No";
        }

        $monday = SellerOpeningTime::where("seller_id", "=", $userId)
            ->where("day", "=", "Monday")
            ->first();
        if (isset($monday->id)) {
            $SellerOpeningTime = DB::table("seller_opening_times")
                ->where("id", $monday->id)
                ->update($input);
        } else {
            $SellerOpeningTime = SellerOpeningTime::create($input);
        }

        $chTuesday = $request->get("chTuesday");
        $input["day"] = "Tuesday";
        $input["opening_time"] = $request->get("opTuesdayhr");
        $input["closing_time"] = $request->get("clTuesdayhr");
        $input["Open_am_pm"] = $request->get("TueOpen_am_pm");
        $input["Close_am_pm"] = $request->get("TueClose_am_pm");
        if ($chTuesday == "Yes") {
            $input["closed"] = "Yes";
            $input["opening_time"] = "";
            $input["closing_time"] = "";
            $input["Open_am_pm"] = "";
            $input["Open_am_pm"] = "";
        } else {
            $input["closed"] = "No";
        }
        $tuesday = SellerOpeningTime::where("seller_id", "=", $userId)
            ->where("day", "=", "Tuesday")
            ->first();
        if (isset($tuesday->id)) {
            $SellerOpeningTime = DB::table("seller_opening_times")
                ->where("id", $tuesday->id)
                ->update($input);
        } else {
            $SellerOpeningTime = SellerOpeningTime::create($input);
        }

        $chWednesday = $request->get("chWednesday");
        $input["day"] = "Wednesday";
        $input["opening_time"] = $request->get("opWednesdayhr");
        $input["closing_time"] = $request->get("clWednesdayhr");
        $input["Open_am_pm"] = $request->get("WedOpen_am_pm");
        $input["Close_am_pm"] = $request->get("WedClose_am_pm");
        if ($chWednesday == "Yes") {
            $input["closed"] = "Yes";
            $input["opening_time"] = "";
            $input["closing_time"] = "";
            $input["Open_am_pm"] = "";
            $input["Close_am_pm"] = "";
        } else {
            $input["closed"] = "No";
        }

        $wednesday = SellerOpeningTime::where("seller_id", "=", $userId)
            ->where("day", "=", "Wednesday")
            ->first();
        if (isset($wednesday->id)) {
            $SellerOpeningTime = DB::table("seller_opening_times")
                ->where("id", $wednesday->id)
                ->update($input);
        } else {
            $SellerOpeningTime = SellerOpeningTime::create($input);
        }
        $chThursday = $request->get("chThursday");
        $input["day"] = "Thursday";
        $input["opening_time"] = $request->get("opThursdayhr");
        $input["closing_time"] = $request->get("clThursdayhr");
        $input["Open_am_pm"] = $request->get("ThuOpen_am_pm");
        $input["Close_am_pm"] = $request->get("ThuClose_am_pm");
        if ($chThursday == "Yes") {
            $input["closed"] = "Yes";
            $input["opening_time"] = "";
            $input["closing_time"] = "";
            $input["Open_am_pm"] = "";
            $input["Close_am_pm"] = "";
        } else {
            $input["closed"] = "No";
        }

        $thursday = SellerOpeningTime::where("seller_id", "=", $userId)
            ->where("day", "=", "Thursday")
            ->first();
        if (isset($thursday->id)) {
            $SellerOpeningTime = DB::table("seller_opening_times")
                ->where("id", $thursday->id)
                ->update($input);
        } else {
            $SellerOpeningTime = SellerOpeningTime::create($input);
        }

        $chFriday = $request->get("chFriday");
        $input["day"] = "Friday";
        $input["opening_time"] = $request->get("opFridayhr");
        $input["closing_time"] = $request->get("clFridayhr");
        $input["Open_am_pm"] = $request->get("FriOpen_am_pm");
        $input["Close_am_pm"] = $request->get("FriClose_am_pm");
        if ($chFriday == "Yes") {
            $input["closed"] = "Yes";
            $input["opening_time"] = "";
            $input["closing_time"] = "";
            $input["Open_am_pm"] = "";
            $input["Close_am_pm"] = "";
        } else {
            $input["closed"] = "No";
        }

        $friday = SellerOpeningTime::where("seller_id", "=", $userId)
            ->where("day", "=", "Friday")
            ->first();
        if (isset($friday->id)) {
            $SellerOpeningTime = DB::table("seller_opening_times")
                ->where("id", $friday->id)
                ->update($input);
        } else {
            $SellerOpeningTime = SellerOpeningTime::create($input);
        }

        $chSaturday = $request->get("chSaturday");
        $input["day"] = "Saturday";
        $input["opening_time"] = $request->get("opSaturdayhr");
        $input["closing_time"] = $request->get("clSaturdayhr");
        $input["Open_am_pm"] = $request->get("SatOpen_am_pm");
        $input["Close_am_pm"] = $request->get("SatClose_am_pm");
        if ($chSaturday == "Yes") {
            $input["closed"] = "Yes";
            $input["opening_time"] = "";
            $input["closing_time"] = "";
            $input["Open_am_pm"] = "";
            $input["Close_am_pm"] = "";
        } else {
            $input["closed"] = "No";
        }

        $satday = SellerOpeningTime::where("seller_id", "=", $userId)
            ->where("day", "=", "Saturday")
            ->first();
        if (isset($satday->id)) {
            $SellerOpeningTime = DB::table("seller_opening_times")
                ->where("id", $satday->id)
                ->update($input);
        } else {
            $SellerOpeningTime = SellerOpeningTime::create($input);
        }

         echo json_encode("Profile Updated");
    }
    
    public function updateCompProf(Request $request)
    { 
        /*if($profId!=null)
        $userId = $profId;
        else*/
        $userId=Auth::guard("user")->user()->id;
        if(Auth::guard("user")->user()->seller_type=="Co-Seller")
        $userId=Auth::guard("user")->user()->parent_id;
        $user = User::find($userId);
        $profile_pic = $user->profile_pic??'';
        $company_image = $user->BuyerCompany->company_image;
        $rules=[
                "company_email" => [
                    "required",
                    "email",
                    "regex:/(.+)@(.+)\.(.+)/i",
                    Rule::unique("buyer_companies")
                        ->ignore($userId, 'user_id')
                        //->ignore($userId)
                        ->where(function ($query) {
                            return $query;
                            //->where("status", "<>", "Deleted");
                        }),
                ],
                
               /* "more_info_email" => [
                    "required",
                    "email",
                    "regex:/(.+)@(.+)\.(.+)/i",
                    
                ],*/
                
                
                "country_id" => "required",
                "offline_categories" => "required",
                "company_phone" => [
                    "required",
                    'regex:/^(^([+]+)(\d+)?$)$/',
                    Rule::unique("buyer_companies")
                        ->ignore($userId, 'user_id')
                        ->where(function ($query) {
                            return $query;
                            //->where("status", "<>", "Deleted");
                        }),
                ],
                "company_name" => "required",
                "company_type" => "required",
                "company_street" => "required",
                // 'company_zip' => 'required|regex:/\b\d{5}\b/',
                "company_zip" => "required",
                "company_location" => "required",
            ];
            if($company_image=='')
            $rules['image'] = "required";
            $request->validate($rules);
        



        $offline_categories = $request->get("offline_categories");
        $sOflinCats = SellerOfflineCategory::where("user_id", $userId)->first();
        $of_cats = '';
        if(!empty($offline_categories)){
        foreach($offline_categories as $offline_category) {
            $of_cats = $of_cats .$offline_category . ","; }
        }
        if (empty($sOflinCats)) {
         SellerOfflineCategory::create([
                "user_id" => $userId,
                "category_id" => $of_cats,
            ]);
       } else {
           $sOflinCats->update(["category_id" => $of_cats]);
        }

        

       
        //$input["email"] = $request->get("email");
        //["phone"] = $request->get("phone");
        $input["country_id"] = $request->get("country_id");
       // $input["usertype"] = "seller";
        $input["company"] = "Yes";

      /*  if ($user->email != $input["email"]) {   //new email status change
            $input["email_status"] = "No";
            $input["varification_status"] = "not varified";
        }*/

        DB::table("users")
            ->where("id", $userId)
            ->update($input);
            
        if($user->country_id!=$input["country_id"])    
        {
            $coUser_list=User::where('parent_id',$userId)->get();
	    	foreach ($coUser_list as $key => $value1) 
	    		DB::table('users')->where('id',$value1->id)->update(['country_id'=>$input["country_id"]]);	    	
        }
        
        $c_types = '';
        if(!empty($request->get("company_type"))){
        foreach($request->get("company_type") as $company_type) {
            $c_types = $c_types .$company_type . ","; }
        }
        
        $input = [
            "user_id" => $userId,
            "company_email" => $request->get("company_email"),
            "more_info_email" => $request->get("more_info_email"),
            "company_phone" => $request->get("company_phone"),
            "company_name" => $request->get("company_name"),
            "company_type" => $c_types,
            "company_street" => $request->get("company_street"),
            "company_zip" => $request->get("company_zip"),
            "company_location" => $request->get("company_location"),
            "company_land" => $request->get("company_land"),
            "company_website" => $request->get("company_website"),
            
            
        ];
        // Check seller company already or not if exists update else create

        $user = BuyerCompany::where("user_id", "=", $userId)->first();
        if (isset($user->id)) {
            $id = $user->id;
            $sellercmpy = DB::table("buyer_companies")
                ->where("id", $id)
                ->update($input);
        } else {
            $sellercmpy = BuyerCompany::create($input);
            $buyer_company_id = $sellercmpy->id;
            $buyer_input["company_id"] = $buyer_company_id;
            DB::table("buyer_companies")
                ->where("user_id", $userId)
                ->update($buyer_input);
        }

        

         echo json_encode("Profile Updated");
    }
    
    public function updateCompAbout(Request $request)
    { 
        //dd($request);
        $userId=Auth::guard("user")->user()->id;
        if(Auth::guard("user")->user()->seller_type=="Co-Seller")
        $userId=Auth::guard("user")->user()->parent_id;
        $user = User::find($userId);
        $rules=[ "about_company" => "required", ];
        $request->validate($rules);
        $keywords_removed=[];
        if(!empty($request->get("about_company")))
        {
            $profile_keywords=$request->get("about_company");
            $profile_keywords = strtr($profile_keywords, array('.' => '', ',' => ''));
            $keywords = explode(" ", $profile_keywords);
            $omit_words = array('a','is','was','should','at','and'); 
            $keywords_removed=array_diff($keywords,$omit_words); 
            array_unique($keywords_removed);
            $keywords_removed = implode(',', $keywords_removed);
            
        } 
        else $keywords_removed=$user->BuyerCompany->profile_keywords;
        $input = [];
        $fileName2 = $fileName ="";
        $destinationPath = public_path() . "/uploads/BuyerCompanyBanner";
        
        
        $input = [
            "user_id" => $userId,
            "about_company" => $request->get("about_company"),
            "profile_keywords" => $keywords_removed,
            
        ];
        if(request("comp_about_img1")) {
        $extension = request("comp_about_img1")->extension();
        $fileName = "company_abt" . time() . "." . $extension;
        $input["comp_about_img1"] =  $fileName;
        request("comp_about_img1")->move($destinationPath, $fileName);
        }
        if(request("comp_about_img2")) {
        $extension2 = request("comp_about_img2")->extension();
        $fileName2 = "company_abt" . time() . "." . $extension2;
        $input["comp_about_img2"] =  $fileName2;
        request("comp_about_img2")->move($destinationPath, $fileName2);
        }
        //dd($input);
        // Check seller company already or not if exists update else create

        $user = BuyerCompany::where("user_id", "=", $userId)->first();
        if (isset($user->id)) {
            $id = $user->id;
            $sellercmpy = DB::table("buyer_companies")
                ->where("id", $id)
                ->update($input);
        } else {
            $sellercmpy = BuyerCompany::create($input);
            $buyer_company_id = $sellercmpy->id;
            $buyer_input["company_id"] = $buyer_company_id;
            DB::table("buyer_companies")
                ->where("user_id", $userId)
                ->update($buyer_input);
        }

        

         echo json_encode("Updated Successfully!");
    }
    
    public function updateCompanyRegions(Request $request)
    { 
       // dd($request);
        
        
        $userId=Auth::guard("user")->user()->id;
        if(Auth::guard("user")->user()->seller_type=="Co-Seller")
        $userId=Auth::guard("user")->user()->parent_id;
        $user = User::find($userId);
       
        $input = [];
        
        
        
         $active=$expand='';
        if($request->has('active_country')) 
        $active= implode(',', $request->get("active_country")); //dd($active);
        if($request->has('expand_country')) 
        $expand= implode(',', $request->get("expand_country"));
        
        $input = [
            "user_id" => $userId,
            "active_countries" => $active,
            "expand_countries" =>$expand,
            
        ];
        

        $user = CompanyRegion::where("user_id", "=", $userId)->first();
        if (isset($user->id)) {
            $id = $user->id;
            $compReg = DB::table("company_regions")
                ->where("id", $id)
                ->update($input);
        } else {
            $compReg = CompanyRegion::create($input);
        }

        

         echo json_encode("Regions added Successfully!");
    }
    

    public function UpdateCompany(Request $request)
    {
        $user_id = Auth::guard("user")->user()->id;

        request()->validate([]);

        $input = [
            "user_id" => $user_id,
            "store_name" => $request->get("company_name"),
            "company_street" => $request->get("company_street"),
            "company_zip" => $request->get("company_zip"),
            "company_location" => $request->get("company_location"),
            "company_land" => $request->get("company_land"),
            "deliver_options" => $request->get("deliver_options"),
            "opening_hours" => $request->get("opening_hours"),
            "accepted_payments" => $request->get("accepted_payments"),
            "languages_speak" => $request->get("languages_speak"),
        ];

        if ($request->has("image")) {
            $validator = $request->validate([
                "image" => "required|image|mimes:jpeg,png,bmp,gif,svg",
            ]);
            $extension = request("image")->extension();
            $fileName = "company_pic" . time() . "." . $extension;
            $destinationPath = public_path() . "/uploads/BuyerCompany";
            request("image")->move($destinationPath, $fileName);
            $input["company_image"] = $fileName;
        }
        //  Company already exists or not
        $user = BuyerCompany::where("user_id", "=", $user_id)->first();
        if (isset($user->id)) {
            $id = $user->id;
            DB::table("buyer_companies")
                ->where("id", $id)
                ->update($input);
        } else { 
            $buyer_company_id = BuyerCompany::create($input)->id;
            $buyer_input["company_id"] = $buyer_company_id;
            DB::table("buyer_companies")
                ->where("user_id", $user_id)
                ->update($buyer_input);
        }
        return redirect()->route("home");
    }
    public function EditBuyerProfile()
    {
        if (Auth::guard("user")->check()) {
            if (!$this->PublicMiddlewareController->checkUserlogin()) {
                Auth::guard("user")->logout();
                return redirect(route("home"))->with(
                    "message",
                    "Access Denied"
                );
            }
        }

        $usertype = Auth::guard("user")->user()->usertype;
        /*if ($usertype == "seller") {
            //if not buyer or guest redirect to home
            return redirect()->route("home");
        }*/
        $countries = Country::select("id", "name")->get();
        $company_types = CompanyType::select("id", "company_type")->get();

        //if(empty($company_types )) $company_types ='';
        $user_id = Auth::guard("user")->user()->id;
        $user = User::find($user_id);

        $delete_request = ProfileAccountDeleteRequest::where(
            "user_id",
            $user_id
        )
            ->where("status", "New")
            ->get();

        if (count($delete_request) > 0) {
            $delete_request_active = true;
        } else {
            $delete_request_active = false;
        }

        return view(
            "frontEnd.profile-creation.EditBuyer",
            compact(
                "user",
                "countries",
                "company_types",
                "delete_request_active"
            )
        );
    }

    public function ViewProfileBuyer()
    {
        if (Auth::guard("user")->check()) {
            if (!$this->PublicMiddlewareController->checkUserlogin()) {
                Auth::guard("user")->logout();
                return redirect(route("home"))->with(
                    "message",
                    "Access Denied"
                );
            }
        }

        $usertype = Auth::guard("user")->user()->usertype;
        /*if ($usertype != "buyer") {
            //if not buyer or guest redirect to home
            return redirect()->route("home");
        }*/
        $countries = Country::select("id", "name")->get();
        $company_types = CompanyType::select("id", "company_type")->get();

        //if(empty($company_types )) $company_types ='';
        $user_id = Auth::guard("user")->user()->id;
        $user = User::find($user_id);
        $company_types = CompanyType::select("id", "company_type")->get();
        $delete_request = ProfileAccountDeleteRequest::where(
            "user_id",
            $user_id
        )
            ->where("status", "New")
            ->get();

        if (count($delete_request) > 0) {
            $delete_request_active = true;
        } else {
            $delete_request_active = false;
        }

        
        if($this->isMobile()) { 
          return view(
            "frontEnd.profile-creation.ViewProfileBuyer_mobile",
            compact(
                "user",
                "company_types",
                "countries",
                "company_types",
                "delete_request_active"
            )
        );
            
        } else {
          
            return view(
            "frontEnd.profile-creation.ViewProfileBuyer",
            compact(
                "user",
                "company_types",
                "countries",
                "company_types",
                "delete_request_active"
            )
        );
        }
    }

    public function ViewProfileGuest()
    {
        if (Auth::guard("user")->check()) {
            if (!$this->PublicMiddlewareController->checkUserlogin()) {
                Auth::guard("user")->logout();
                return redirect(route("home"))->with(
                    "message",
                    "Access Denied"
                );
            }
        }

        $usertype = Auth::guard("user")->user()->usertype;
        if ($usertype != "guest") {
            //if not buyer or guest redirect to home
            return redirect()->route("home");
        }
        $countries = Country::select("id", "name")->get();

        $user_id = Auth::guard("user")->user()->id;
        $user = User::find($user_id);

        $delete_request = ProfileAccountDeleteRequest::where(
            "user_id",
            $user_id
        )
            ->where("status", "New")
            ->get();

        if (count($delete_request) > 0) {
            $delete_request_active = true;
        } else {
            $delete_request_active = false;
        }

       
        if($this->isMobile()) { 
            return view("frontEnd.profile-creation.ViewProfileGuest_mobile",compact("user", "countries", "delete_request_active"));
        } else {
            return view("frontEnd.profile-creation.ViewProfileGuest",compact("user", "countries", "delete_request_active"));
        }
    }

    public function EditGuestProfile()
    {
        if (Auth::guard("user")->check()) {
            if (!$this->PublicMiddlewareController->checkUserlogin()) {
                Auth::guard("user")->logout();
                return redirect(route("home"))->with(
                    "message",
                    "Access Denied"
                );
            }
        }

        $usertype = Auth::guard("user")->user()->usertype;
        /*if ($usertype == "seller") {
            //if not buyer or guest redirect to home
            return redirect()->route("home");
        }*/
        $countries = Country::select("id", "name")->get();
        $company_types = CompanyType::select("id", "company_type")->get();

        $user_id = Auth::guard("user")->user()->id;
        $user = User::find($user_id);
        return view(
            "frontEnd.profile-creation.EditBuyer",
            compact("user", "countries", "company_types")
        );
    }
    public function GuestProfile()
    {
        $userId = Auth::guard("user")->user()->id;
        $usertype = Auth::guard("user")->user()->usertype;
        $email_status = User::where("id", $userId)->value("email_status");
        $order = OrderDetail::where("user_id", $userId)
            ->latest("updated_at")
            ->first();

        $subscriptions = Subscription::where("user_id", $userId)
            ->where("status", "Active")
            ->whereDate("expairy_date", ">", now())
            ->groupBy("package_id")
            ->orderBy("id", "DESC")
            ->latest("updated_at")
            ->first();
        if (empty($subscriptions)) {
            $subscriptions = "";
        }

        /*if ($usertype == "seller") {
            //if not seller redirect to home
            return redirect()->route("home");
        }*/

        $user = User::find($userId);
        $network = false;
        $countries = Country::select("id", "name")->get();

        $clientIP = \Request::ip();
        $insight = [];
        $company_type = "";
        if (!empty($user->BuyerCompany->company_type)) {
            $cType_id = $user->BuyerCompany->company_type;
            $company_type = CompanyType::where("id", $cType_id)
                ->pluck("company_type")
                ->first();
        }

        return view(
            "frontEnd.profile-creation.BuyerProfile",
            compact(
                "user",
                "order",
                "company_type",
                "network",
                "countries",
                "subscriptions",
                "email_status"
            )
        );
    }
    public function update_image(Request $request)
    {
        $validator = $request->validate([
            "image" => "required|image|mimes:jpeg,png,bmp,gif,svg",
        ]);
        $extension = request("image")->extension();
        $fileName = "user_pic" . time() . "." . $extension;
        $destinationPath = public_path() . "/uploads/userImages";
        request("image")->move($destinationPath, $fileName);
        $data = [
            "profile_pic" => $fileName,
        ];

        $user_id = Auth::guard("user")->user()->id;
        $update = User::find($user_id)->update($data);
        if ($update) {
            $response["success"] = true;
            $response["message"] = "Success! Record Updated Successfully.";
            $response["image_path"] = "uploads/userImages/" . $fileName;
        } else {
            $response["success"] = false;
            $response["message"] = "Error! Record Not Updated.";
        }
        return $response;
    }
    public function updateCompimage(Request $request)
    {
        $validator = $request->validate([
                'company_image' => 'required|image|mimes:jpeg,png,bmp,gif,svg|max:1024',
            ]);
        $extension = request("company_image")->extension();
        $fileName = "company_pic" . time() . "." . $extension;
        $destinationPath = public_path() . "/uploads/BuyerCompany";
        request("company_image")->move($destinationPath, $fileName);
        $data = [
            "company_image" => $fileName,
        ];

        
        $user_id=Auth::guard("user")->user()->id;
        if(Auth::guard("user")->user()->seller_type=="Co-Seller")
        $user_id=Auth::guard("user")->user()->parent_id;
        $update = BuyerCompany::where('user_id',$user_id)->update($data);
        if ($update) {
            $response["success"] = true;
            $response["message"] = "Success! Record Updated Successfully.";
            $response["image_path"] = "uploads/BuyerCompany/" . $fileName;
        } else {
            $response["success"] = false;
            $response["message"] = "Error! Record Not Updated.";
        }
        return $response;
    }
    
    public function updateProfimage(Request $request)
    {
        $validator = $request->validate([
            "image_original" => "required|image|mimes:jpeg,png,bmp,gif,svg",
        ]);
        $extension = request("image_original")->extension();
        $fileName = "user_pic" . time() . "." . $extension;
       $destinationPath = public_path() . "/uploads/userImages";
        request("image_original")->move($destinationPath, $fileName);
        $data = [
             "profile_pic" => $fileName,
        ];

         $user_id = Auth::guard("user")->user()->id;
        $update = User::find($user_id)->update($data);
        if ($update) {
            $response["success"] = true;
            $response["message"] = "Success! Record Updated Successfully.";
            $response["image_path"] = "uploads/userImages/" . $fileName;
        } else {
            $response["success"] = false;
            $response["message"] = "Error! Record Not Updated.";
        }
        return $response;
    }


    public function UpdateCompanyImage(Request $request)
    {
        $extension = request("image")->extension();
        $fileName = "company_pic" . time() . "." . $extension;
        $destinationPath = public_path() . "/uploads/BuyerCompany";
        request("image")->move($destinationPath, $fileName);
        $data = [
            "company_image" => $fileName,
        ];

        $user_id = Auth::guard("user")->user()->id;
        $update = DB::table("buyer_companies")
            ->where("user_id", $user_id)
            ->update($data);
        if ($update) {
            $response["success"] = true;
            $response["message"] = "Success! Record Updated Successfully.";
            $response["image_path"] = "uploads/BuyerCompany/" . $fileName;
        } else {
            $response["success"] = false;
            $response["message"] = "Error! Record Not Updated.";
        }
        return $response;
    }
    
    public function updateCompbanner(Request $request)
    {
        
        $validator = $request->validate([
                'image_banner' => 'required|image|mimes:jpeg,png,bmp,gif,svg|max:1024',
            ]);
            
            
        
        $extension = request("image_banner")->extension();
        $fileName = "company_banner" . time() . "." . $extension;
        $destinationPath = public_path() . "/uploads/BuyerCompanyBanner";
        request("image_banner")->move($destinationPath, $fileName);
        $data = [
            "campany_banner" => $fileName,
        ];

        $user_id=Auth::guard("user")->user()->id;
        if(Auth::guard("user")->user()->seller_type=="Co-Seller")
        $user_id=Auth::guard("user")->user()->parent_id;
        $update = DB::table("buyer_companies")
            ->where("user_id", $user_id)
            ->update($data);
        if ($update) {
            $response["success"] = true;
            $response["message"] = "Success! Record Updated Successfully.";
            $response["image_path"] = "uploads/BuyerCompanyBanner/" . $fileName;
        } else {
            $response["success"] = false;
            $response["message"] = "Error! Record Not Updated.";
        }
        return $response;
    }
    
    public function updateAbtimg1(Request $request)
    { 
        $validator = $request->validate([
                'about_image1' => 'required|image|mimes:jpeg,png,bmp,gif,svg|max:1024',
            ]);
        $extension = request("about_image1")->extension();
        $fileName = "company_abt" . time() . "." . $extension;
       
        $destinationPath = public_path() . "/uploads/BuyerCompanyBanner";
        request("about_image1")->move($destinationPath, $fileName);
        $data = [
            "comp_about_img1" => $fileName,
        ];

        
        $user_id=Auth::guard("user")->user()->id;
        if(Auth::guard("user")->user()->seller_type=="Co-Seller")
        $user_id=Auth::guard("user")->user()->parent_id;
        $update = DB::table("buyer_companies")
            ->where("user_id", $user_id)
            ->update($data);
        if ($update) {
            $response["success"] = true;
            $response["message"] = "Success! Record Updated Successfully.";
            $response["image_path"] = "uploads/BuyerCompanyBanner/" . $fileName;
        } else {
            $response["success"] = false;
            $response["message"] = "Error! Record Not Updated.";
        }
        return $response;
    }
    
    public function updateAbtimg2(Request $request)
    { 
        $validator = $request->validate([
                'about_image2' => 'required|image|mimes:jpeg,png,bmp,gif,svg|max:1024',
            ]);
        $extension = request("about_image2")->extension();
        $fileName = "company_abt" . time() . "." . $extension;
       
        $destinationPath = public_path() . "/uploads/BuyerCompanyBanner";
        request("about_image2")->move($destinationPath, $fileName);
        $data = [
            "comp_about_img2" => $fileName,
        ];

        
        $user_id=Auth::guard("user")->user()->id;
        if(Auth::guard("user")->user()->seller_type=="Co-Seller")
        $user_id=Auth::guard("user")->user()->parent_id;
        $update = DB::table("buyer_companies")
            ->where("user_id", $user_id)
            ->update($data);
        if ($update) {
            $response["success"] = true;
            $response["message"] = "Success! Record Updated Successfully.";
            $response["image_path"] = "uploads/BuyerCompanyBanner/" . $fileName;
        } else {
            $response["success"] = false;
            $response["message"] = "Error! Record Not Updated.";
        }
        return $response;
    }

    public function UpdateGuest(Request $request)
    {
        $userId = Auth::guard("user")->user()->id;
        $user = User::find($userId);
        $request->validate([
            "name" => "required",
            "surname" => "required",
            "email" => [
                "required",
                "email",
                "regex:/(.+)@(.+)\.(.+)/i",
                Rule::unique("users")
                    ->ignore($userId)
                    ->where(function ($query) {
                        return $query->where("status", "<>", "Deleted");
                    }),
            ],
            "phone" => [
                "required",
                'regex:/^(^([+]+)(\d+)?$)$/',
                Rule::unique("users")
                    ->ignore($userId)
                    ->where(function ($query) {
                        return $query->where("status", "<>", "Deleted");
                    }),
            ],
            "address" => "required",
            "country_id" => "required",
            "company_name" => "required",
        ]);

        $input = [
            "name" => $request->get("name"),
            "surname" => $request->get("surname"),
            "email" => $request->get("email"),
            "phone" => $request->get("phone"),
            "position" => $request->get("position"),
            "address" => $request->get("address"),
            "about" => $request->get("about"),
            "country_id" => $request->get("country_id"),
        ];

        if ($user->email != $input["email"]) {
            $input["email_status"] = "No";
            $input["varification_status"] = "not varified";
        }

        DB::table("users")
            ->where("id", $userId)
            ->update($input);

        $input1 = [
            "company_name" => $request->get("company_name"),
            "user_id" => $userId,
        ];
        

        $user = BuyerCompany::where("user_id", "=", $userId)->first();
        if (isset($user->id)) {
            DB::table("buyer_companies")
                ->where("user_id", $userId)
                ->update($input1);
        } else {
            $buyer_company_id = BuyerCompany::create($input)->id;
            $buyer_input["company_id"] = $buyer_company_id;
            DB::table("buyer_companies")
                ->where("user_id", $userId)
                ->update($buyer_input);
        }

        return redirect()
            ->route("ViewProfileGuest")
            ->with("message", "Profile Updated");
    }

    public function UpdateBuyer(Request $request)
    {
        $userId = Auth::guard("user")->user()->id;
        $user = User::find($userId);
        if (Auth::guard("user")->user()->seller_type != "Co-Seller") {
        $request->validate([
            "name" => "required",
            "surname" => "required",
            "email" => [
                "required",
                "email",
                "regex:/(.+)@(.+)\.(.+)/i",
                Rule::unique("users")
                    ->ignore($userId)
                    ->where(function ($query) {
                        return $query->where("status", "<>", "Deleted");
                    }),
            ],
            "phone" => [
                "required",
                'regex:/^(^([+]+)(\d+)?$)$/',
                Rule::unique("users")
                    ->ignore($userId)
                    ->where(function ($query) {
                        return $query->where("status", "<>", "Deleted");
                    }),
            ],
            "address" => "required",
            "country_id" => "required",
               'accepted_payments'      => 'required ',
            //'company_image' =>  'mimes:jpeg,jpg,png,gif,webp|max:1000||dimensions:max_width=150,max_height=100',
            "company_name" => "required",
            "company_street" => "required",
            "company_zip" => "required",
            "company_type" => "required",
            //
            // 'languages_speak'      => 'required ',
            // 'about_company'      => 'required ',
            "company_location" => "required ",
        ]);
            
        }
        else{
            
            $request->validate([
            "name" => "required",
            "surname" => "required",
            "email" => [
                "required",
                "email",
                "regex:/(.+)@(.+)\.(.+)/i",
                Rule::unique("users")
                    ->ignore($userId)
                    ->where(function ($query) {
                        return $query->where("status", "<>", "Deleted");
                    }),
            ],
            "phone" => [
                "required",
                'regex:/^(^([+]+)(\d+)?$)$/',
                Rule::unique("users")
                    ->ignore($userId)
                    ->where(function ($query) {
                        return $query->where("status", "<>", "Deleted");
                    }),
            ],
            "address" => "required",
            "country_id" => "required"
        ]);
            
        }

        $input = [
            "name" => $request->get("name"),
            "surname" => $request->get("surname"),
            "email" => $request->get("email"),
            "phone" => $request->get("phone"),
            "position" => $request->get("position"),
            "address" => $request->get("address"),
            "about" => $request->get("about"),
            "country_id" => $request->get("country_id"),
            "hide_promo_email" => $request->get("hide_promo_email"),
            "newsletter_status" => $request->get("newsletter_status"),
        ];

        if ($user->email != $input["email"]) {
            $input["email_status"] = "No";
            $input["varification_status"] = "not varified";
        }

        DB::table("users")
            ->where("id", $userId)
            ->update($input);
            
        if($user->country_id!=$input["country_id"])    
        {
            $coUser_list=User::where('parent_id',$userId)->get();
	    	foreach ($coUser_list as $key => $value1) 
	    		DB::table('users')->where('id',$value1->id)->update(['country_id'=>$input["country_id"]]);	    	
        }        

        $languages_speak = $deliver_options = $accepted_payments = "";
        if (!empty($request->get("languages_speak"))) {
            $languages_speak = $request->get("languages_speak");
        }

        if (!empty($request->get("deliver_options"))) {
            $deliver_options = $request->get("deliver_options");
        }

        if (!empty($request->get("accepted_payments"))) {
            $accepted_payments = $request->input("accepted_payments");
        }
        $c_types1 = '';
        if(!empty($request->get("company_type"))){
        foreach($request->get("company_type") as $company_type) {
            $c_types1 = $c_types1 .$company_type . ","; }
        } 
        $input = [
            "company_name" => $request->get("company_name"),
            "company_type" => $c_types1,
            "company_street" => $request->get("company_street"),
            "company_zip" => $request->get("company_zip"),
            "company_location" => $request->get("company_location"),
            "company_land" => $request->get("company_land"),
            "opening_hours" => $request->get("opening_hours"),
            "about_company" => $request->get("about_company"),
            "accepted_payments" => $accepted_payments,

            "user_id" => $userId,
            "languages_speak" => $languages_speak,
        ];
        if ($request->hasFile("company_image")) {
            $validator = $request->validate([
                "company_image" => "required|image|mimes:jpeg,png,bmp,gif,svg",
            ]);
            $extension = request("company_image")->extension();
            $fileName = "user_pic" . time() . "." . $extension;
            $destinationPath = public_path() . "/uploads/BuyerCompany";
            request("company_image")->move($destinationPath, $fileName);
            $input["company_image"] = $fileName;
        } 
        //  Company already exists or not
        $user = BuyerCompany::where("user_id", "=", $userId)->first();

        if (isset($user->id)) {
            DB::table("buyer_companies")
                ->where("user_id", $userId)
                ->update($input);
        } else {
            $buyer_company_id = BuyerCompany::create($input)->id;
            $buyer_input["company_id"] = $buyer_company_id;
            DB::table("buyer_companies")
                ->where("user_id", $userId)
                ->update($buyer_input);
        }

        $input = [
            "seller_id" => $userId,
        ];

        $checkSun = $request->get("chSunday");
        $input["day"] = "Sunday";
        $input["opening_time"] = $request->get("opSundayhr");
        $input["closing_time"] = $request->get("clSundayhr");
        $input["Open_am_pm"] = $request->get("SunOpen_am_pm");
        $input["Close_am_pm"] = $request->get("WedClose_am_pm");

        if ($checkSun == "Yes") {
            $input["closed"] = "Yes";
            $input["opening_time"] = "";
            $input["closing_time"] = "";
            $input["Open_am_pm"] = "";
            $input["Close_am_pm"] = "";
        } else {
            $input["closed"] = "No";
        }
        $sunday = SellerOpeningTime::where("seller_id", "=", $userId)
            ->where("day", "=", "Sunday")
            ->first();
        if (isset($sunday->id)) {
            $SellerOpeningTime = DB::table("seller_opening_times")
                ->where("id", $sunday->id)
                ->update($input);
        } else {
            $SellerOpeningTime = SellerOpeningTime::create($input);
        }

        $chMonday = $request->get("chMonday");
        $input["day"] = "Monday";
        $input["opening_time"] = $request->get("opMondayhr");
        $input["closing_time"] = $request->get("clMondayhr");
        $input["Open_am_pm"] = $request->get("MonOpen_am_pm");
        $input["Close_am_pm"] = $request->get("MonClose_am_pm");
        if ($chMonday == "Yes") {
            $input["closed"] = "Yes";
            $input["opening_time"] = "";
            $input["closing_time"] = "";
            $input["Open_am_pm"] = "";
            $input["Close_am_pm"] = "";
        } else {
            $input["closed"] = "No";
        }

        $monday = SellerOpeningTime::where("seller_id", "=", $userId)
            ->where("day", "=", "Monday")
            ->first();
        if (isset($monday->id)) {
            $SellerOpeningTime = DB::table("seller_opening_times")
                ->where("id", $monday->id)
                ->update($input);
        } else {
            $SellerOpeningTime = SellerOpeningTime::create($input);
        }

        $chTuesday = $request->get("chTuesday");
        $input["day"] = "Tuesday";
        $input["opening_time"] = $request->get("opTuesdayhr");
        $input["closing_time"] = $request->get("clTuesdayhr");
        $input["Open_am_pm"] = $request->get("TueOpen_am_pm");
        $input["Close_am_pm"] = $request->get("TueClose_am_pm");
        if ($chTuesday == "Yes") {
            $input["closed"] = "Yes";
            $input["opening_time"] = "";
            $input["closing_time"] = "";
            $input["Open_am_pm"] = "";
            $input["Open_am_pm"] = "";
        } else {
            $input["closed"] = "No";
        }
        $tuesday = SellerOpeningTime::where("seller_id", "=", $userId)
            ->where("day", "=", "Tuesday")
            ->first();
        if (isset($tuesday->id)) {
            $SellerOpeningTime = DB::table("seller_opening_times")
                ->where("id", $tuesday->id)
                ->update($input);
        } else {
            $SellerOpeningTime = SellerOpeningTime::create($input);
        }

        $chWednesday = $request->get("chWednesday");
        $input["day"] = "Wednesday";
        $input["opening_time"] = $request->get("opWednesdayhr");
        $input["closing_time"] = $request->get("clWednesdayhr");
        $input["Open_am_pm"] = $request->get("WedOpen_am_pm");
        $input["Close_am_pm"] = $request->get("WedClose_am_pm");
        if ($chWednesday == "Yes") {
            $input["closed"] = "Yes";
            $input["opening_time"] = "";
            $input["closing_time"] = "";
            $input["Open_am_pm"] = "";
            $input["Close_am_pm"] = "";
        } else {
            $input["closed"] = "No";
        }

        $wednesday = SellerOpeningTime::where("seller_id", "=", $userId)
            ->where("day", "=", "Wednesday")
            ->first();
        if (isset($wednesday->id)) {
            $SellerOpeningTime = DB::table("seller_opening_times")
                ->where("id", $wednesday->id)
                ->update($input);
        } else {
            $SellerOpeningTime = SellerOpeningTime::create($input);
        }
        $chThursday = $request->get("chThursday");
        $input["day"] = "Thursday";
        $input["opening_time"] = $request->get("opThursdayhr");
        $input["closing_time"] = $request->get("clThursdayhr");
        $input["Open_am_pm"] = $request->get("ThuOpen_am_pm");
        $input["Close_am_pm"] = $request->get("ThuClose_am_pm");
        if ($chThursday == "Yes") {
            $input["closed"] = "Yes";
            $input["opening_time"] = "";
            $input["closing_time"] = "";
            $input["Open_am_pm"] = "";
            $input["Close_am_pm"] = "";
        } else {
            $input["closed"] = "No";
        }

        $thursday = SellerOpeningTime::where("seller_id", "=", $userId)
            ->where("day", "=", "Thursday")
            ->first();
        if (isset($thursday->id)) {
            $SellerOpeningTime = DB::table("seller_opening_times")
                ->where("id", $thursday->id)
                ->update($input);
        } else {
            $SellerOpeningTime = SellerOpeningTime::create($input);
        }

        $chFriday = $request->get("chFriday");
        $input["day"] = "Friday";
        $input["opening_time"] = $request->get("opFridayhr");
        $input["closing_time"] = $request->get("clFridayhr");
        $input["Open_am_pm"] = $request->get("FriOpen_am_pm");
        $input["Close_am_pm"] = $request->get("FriClose_am_pm");
        if ($chFriday == "Yes") {
            $input["closed"] = "Yes";
            $input["opening_time"] = "";
            $input["closing_time"] = "";
            $input["Open_am_pm"] = "";
            $input["Close_am_pm"] = "";
        } else {
            $input["closed"] = "No";
        }

        $friday = SellerOpeningTime::where("seller_id", "=", $userId)
            ->where("day", "=", "Friday")
            ->first();
        if (isset($friday->id)) {
            $SellerOpeningTime = DB::table("seller_opening_times")
                ->where("id", $friday->id)
                ->update($input);
        } else {
            $SellerOpeningTime = SellerOpeningTime::create($input);
        }

        $chSaturday = $request->get("chSaturday");
        $input["day"] = "Saturday";
        $input["opening_time"] = $request->get("opSaturdayhr");
        $input["closing_time"] = $request->get("clSaturdayhr");
        $input["Open_am_pm"] = $request->get("SatOpen_am_pm");
        $input["Close_am_pm"] = $request->get("SatClose_am_pm");
        if ($chSaturday == "Yes") {
            $input["closed"] = "Yes";
            $input["opening_time"] = "";
            $input["closing_time"] = "";
            $input["Open_am_pm"] = "";
            $input["Close_am_pm"] = "";
        } else {
            $input["closed"] = "No";
        }

        $satday = SellerOpeningTime::where("seller_id", "=", $userId)
            ->where("day", "=", "Saturday")
            ->first();
        if (isset($satday->id)) {
            $SellerOpeningTime = DB::table("seller_opening_times")
                ->where("id", $satday->id)
                ->update($input);
        } else {
            $SellerOpeningTime = SellerOpeningTime::create($input);
        }

        echo json_encode("Profile Updated");
    }

    public function submitUserResetPasswordForm(Request $request)
    {
        $userId = Auth::guard("user")->user()->id;
        $request->validate([
            "oldPassword" => "required",
            "password" => [
                "required",
                "string",
                "min:8",
                "confirmed", // must be at least 10 characters in length
                "regex:/[a-z]/", // must contain at least one lowercase letter
                "regex:/[A-Z]/", // must contain at least one uppercase letter
                "regex:/[0-9]/", // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            "password_confirmation" => "required",
        ]);

        $usertype = Auth::guard("user")->user()->usertype;
        if (!Hash::check($request["oldPassword"],Auth::guard("user")->user()->password)) {
            if ($usertype == "buyer") {
                return redirect() ->route("ViewProfileBuyer") ->with(  "message_not_match", "The old password does not match our records." );
            } elseif ($usertype == "seller") {
                return redirect()->route("ViewProfileSeller")->with("message_not_match","The old password does not match our records." );
            } else {
                return redirect()->route("ViewProfileGuest")->with("message_not_match","The old password does not match our records." );
            }
        }

        $user = User::where("id", $userId)->update([
            "password" => Hash::make($request->password),
        ]);

        
        if ($usertype == "buyer") {
                return redirect()->route("ViewProfileBuyer") ->with("message", "Your password has been changed!");
            } elseif ($usertype == "seller") {
                return redirect()->route("ViewProfileSeller") ->with("message", "Your password has been changed!");
            }else {
                return redirect()->route("ViewProfileGuest") ->with("message", "Your password has been changed!");
            }
    }
    
    
    
    
   /* public function UserResetPassword(Request $request)
    { 
        $userId = Auth::guard("user")->user()->id; 
        $request->validate([
            "oldPassword" => "required",
            "password" => [
                "required",
                "string",
                "min:8",
                "confirmed", // must be at least 10 characters in length
                "regex:/[a-z]/", // must contain at least one lowercase letter
                "regex:/[A-Z]/", // must contain at least one uppercase letter
                "regex:/[0-9]/", // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            "password_confirmation" => "required",
        ]);

        $usertype = Auth::guard("user")->user()->usertype;
        if (!Hash::check($request["oldPassword"],Auth::guard("user")->user()->password)) {
            
                return redirect()->route("CompanyProfile", $userId)->with("message_not_match","The old password does not match our records." );
            
        }

        $user = User::where("id", $userId)->update([
            "password" => Hash::make($request->password),
        ]);

        
        
                return redirect()->route("CompanyProfile", $userId) ->with("message", "Your password has been changed!");
            
    }*/
    
public function UserResetPassword(Request $request)
    { 
        $userId = Auth::guard("user")->user()->id; 
        $request->validate([
            "oldPassword" => "required",
            "password" => [
                "required",
                "string",
                "min:8",
                "confirmed", // must be at least 10 characters in length
                "regex:/[a-z]/", // must contain at least one lowercase letter
                "regex:/[A-Z]/", // must contain at least one uppercase letter
                "regex:/[0-9]/", // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            "password_confirmation" => "required",
        ]);

        $usertype = Auth::guard("user")->user()->usertype;
        if (!Hash::check($request["oldPassword"],Auth::guard("user")->user()->password)) {
            
                //return redirect()->route("CompanyProfile", $userId)->with("message_not_match","The old password does not match our records." );
                return response()->json(['msg_old' => 'The old password does not match our records.']);
            
        }

        $user = User::where("id", $userId)->update([
            "password" => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Password updated successfully!']);
        
              //  return redirect()->route("CompanyProfile", $userId) ->with("message", "Your password has been changed!");
            
    }
    public function EditSellerProfile($userId)
    {
        $user = User::find($userId);
        return view(
            "frontEnd.profile-creation.EditSellerProfile",
            compact("user")
        );
    }

    public function SellerProfile()
    {
        if (Auth::guard("user")->check()) {
            if (!$this->PublicMiddlewareController->checkUserlogin()) {
                Auth::guard("user")->logout();
                return redirect(route("home"))->with(
                    "message",
                    "Access Denied"
                );
            }
            if (
                !$this->PublicMiddlewareController->checkUserValidity() &&
                Auth::guard("user")->user()->seller_type == "Co-Seller"
            ) {
                Auth::guard("user")->logout();
                return redirect(route("home"));
            }
        }
        $user_id = $userId = Auth::guard("user")->user()->id;
        $user = User::find($userId);
        $usertype = Auth::guard("user")->user()->usertype; 
       /* if ($usertype != "seller") {
            return redirect()->route("home");
        }*/
        
       
        
        
        
        
        
        
        

        $values = [];
        $sellerProducts = $user->SellerProduct;
        foreach ($sellerProducts as $sproduct) {
            foreach (explode(",", $sproduct->category_id) as $value) {
                $values[] = trim($value);
            }
        }
        $values = array_unique($values);
        $category_product_count = [];
        foreach ($values as $row) {
            $prdt_count = SellerProduct::where("status", "active")
                ->where("user_id", $userId)
                ->WhereRaw('find_in_set("' . $row . '",category_id)')
                ->count();
            $category_name = Category::find($row, ["name", "category_pic"]);
            $category_product_count[] = [
                "product_count" => $prdt_count,
                "category" => $category_name,
            ];
        }
        arsort($category_product_count);
        $category_product_count = array_splice($category_product_count, 0, 3);
        
        $categorylists = Category::whereIn("id", $values)
            ->pluck("name")
            ->all();

        $my_products = SellerProduct::select("*")
            ->where("status", "active")
            ->where("user_id", $userId)
            ->latest()
            ->take(4)
            ->get();
        $network = false;

        $my_networks = Mynetworks::where("user_id", $userId)
            ->pluck("mynetwork_id")
            ->first();
        $network_id = explode(",", $my_networks);
        $network_list = User::select("name", "id", "profile_pic")
            ->whereIn("id", $network_id)
            ->get();
        $chat_data = [];
        if (!$network_list->isEmpty()) {
            foreach ($network_list as $key => $row) {
                $unreadCount = Message::where("from_user", $row->id)
                    ->where("to_user", $userId)
                    ->where("message_status", "unread")
                    ->count();
                $latestMessage = Message::where(function ($query) use (
                    $userId,
                    $row
                ) {
                    $query
                        ->where("from_user", $userId)
                        ->where("to_user", $row->id);
                })
                    ->orWhere(function ($query) use ($userId, $row) {
                        $query
                            ->where("from_user", $row->id)
                            ->where("to_user", $userId);
                    })
                    ->orderBy("id", "desc")
                    ->take(5)
                    ->get();
                // })->latest()->first();
                $chat_data[$key] = [
                    "contact" => $row,
                    "latestMessage" => $latestMessage,
                    "unreadcount" => $unreadCount,
                ];
            }
        }
        //$profile_visit_count = BusinessInsight::where("profile_id",$userId)->count();
        $profile_visit_count = BusinessInsight::where("profile_id",$userId)->distinct('user_id')->count();
        $product_count = SellerProduct::where("user_id", $userId)->count();
        // $network_count = Mynetworks::where('user_id',$userId)->count();
        $network_ids = Mynetworks::select("mynetwork_id")
            ->where("user_id", $userId)
            ->first();
        $network_count = $network_ids
            ? count(explode(",", $network_ids)) - 1
            : 0;
        $sellerProducts = $user->SellerProduct;
        if (count($sellerProducts) > 0) {
            foreach ($sellerProducts as $sproduct) {
                $category = explode(",", $sproduct->category_id);
                foreach ($category as $value) {
                    $values[] = trim($value);
                }
            }
            $values = array_unique($values);
        }

        $categorylists = Category::whereIn("id", $values)
            ->whereNotNull('name')
            ->where('name','<>','')
            ->pluck("name")
            ->all();

        return view(
            "frontEnd.profile-creation.SellerProfile",
            compact(
                "user",
                "categorylists",
                "network",
                "my_products",
                "profile_visit_count",
                "product_count",
                "network_count",
                "category_product_count"
            )
        );
    }
 
    public function SellerDashboard()
    {
        if (Auth::guard("user")->check()) {
            if (!$this->PublicMiddlewareController->checkUserlogin()) {
                Auth::guard("user")->logout();
                return redirect(route("home"))->with(
                    "message",
                    "Access Denied"
                );
            }
            if (
                !$this->PublicMiddlewareController->checkUserContactValidity()
            ) {
                Auth::guard("user")->logout();
                return redirect(route("home"));
            }
        }
        $user_id = $userId = Auth::guard("user")->user()->id;
        $user = User::leftjoin(
            "buyer_companies",
            "buyer_companies.user_id",
            "users.id"
        )
            ->where("users.id", $userId)
            ->first();
        $usertype = Auth::guard("user")->user()->usertype;
       /* if ($usertype != "seller") {
            return redirect()->route("home");
        }*/
        $values = [];
        $sellerProducts = SellerProduct::Select("category_id")
            ->where("user_id", $userId)
            ->get();
        foreach ($sellerProducts as $sproduct) {
            foreach (explode(",", $sproduct->category_id) as $value) {
                $values[] = trim($value);
            }
        }
        $values = array_unique($values);
        $category_product_count = [];
        foreach ($values as $row) {
            $prdt_count = SellerProduct::where("status", "active")
                ->where("user_id", $userId)
                ->WhereRaw('find_in_set("' . $row . '",category_id)')
                ->count();
            $category_name = Category::find($row, ["name", "category_pic"]);
            $category_product_count[] = [
                "product_count" => $prdt_count,
                "category" => $category_name,
            ];
        }
        arsort($category_product_count);
        $category_product_count = array_splice($category_product_count, 0, 3);
        $categorylists = Category::whereIn("id", $values)
            ->pluck("name")
            ->all();
        $my_products = SellerProduct::select("*")
            ->where("status", "active")
            ->where("user_id", $userId)
            ->latest()
            ->take(4)
            ->get();
        $my_networks = Mynetworks::where("user_id", $userId)
            ->pluck("mynetwork_id")
            ->first();
        $network_id = explode(",", $my_networks);
        $user = User::find($userId);
        $network_list = User::select("name", "id", "profile_pic")
            ->whereIn("id", $network_id)
            ->where("id", "!=", $userId)
            ->get();
        $deleted_id = Chat_contact_delete::where("seller_id", $user_id)
            ->pluck("deleted_id")
            ->all();

        $a = Message::select("messages.to_user as mynetwork_id")
            ->where("from_user", $userId)
            ->whereNotIn("to_user", $deleted_id)
            ->groupBy("to_user")
            ->orderBy("messages.id", "DESC")
            ->pluck("mynetwork_id")
            ->toArray();

        $b = Message::select("messages.from_user as mynetwork_id")
            ->where("to_user", $userId)
            ->whereNotIn("from_user", $deleted_id)
            ->groupBy("from_user")
            ->orderBy("messages.id", "DESC")
            ->latest()
            ->pluck("mynetwork_id")
            ->toArray();
        if (is_array($a) && is_array($b)) {
            $unioncontacts = array_merge($a, $b);
        } elseif (is_array($a)) {
            $unioncontacts = $a;
        } elseif (is_array($b)) {
            $unioncontacts = $b;
        } else {
            $unioncontacts = [];
        }
        $unioncontacts = array_unique($unioncontacts);

        $return_array = [];
        $chat_data = [];
        $contacts = User::select(
            "users.id",
            "users.name",
            "users.user_status",
            "users.profile_pic",
            "buyer_companies.company_name"
        )
            ->leftJoin(
                "buyer_companies",
                "users.id",
                "=",
                "buyer_companies.user_id"
            )
            ->whereIn("users.id", $unioncontacts)
            ->where("users.id", "!=", $userId)
            ->take(4)
            ->get();
        if (!$contacts->isEmpty()) {
            foreach ($contacts as $key => $row) {
                $unreadCount = Message::where("from_user", $row->id)
                    ->where("to_user", $userId)
                    ->where("message_status", "unread")
                    ->count();
                $latestMessage = Message::where(function ($query) use (
                    $userId,
                    $row
                ) {
                    $query
                        ->where("from_user", $userId)
                        ->where("to_user", $row->id);
                })
                    ->orWhere(function ($query) use ($userId, $row) {
                        $query
                            ->where("from_user", $row->id)
                            ->where("to_user", $userId);
                    })
                    ->latest()
                    ->first();
                
                $chat_data[$key] = [
                    "contact" => $row,
                    "latestMessage" => $latestMessage,
                    "unreadcount" => $unreadCount,
                ];
            }
        }
        $network = "false";
        if(Auth::guard('user')->user()->seller_type=='Co-Seller')
            $d_userId=Auth::guard('user')->user()->parent_id;
        else
            $d_userId=$userId;
        //$profile_visit_count = BusinessInsight::where("profile_id",$d_userId)->count();
        $profile_visit_count = BusinessInsight::where("profile_id",$d_userId)->distinct('user_id')->count();
        $product_count = SellerProduct::where("user_id", $d_userId)->where("status", "active")->count();
        
        $active_users=$this->PublicMiddlewareController->getexpireduserslist(); 

        $network_ids = Mynetworks::where("user_id", $userId)
                        ->pluck("mynetwork_id")->first();
        if($network_ids!='')
        {
                $arrayData=explode(',', rtrim($network_ids,','));
                $network_count=User::whereIn('id',$arrayData)
                ->whereIn('users.id',$active_users)->count();  
        }
        else
                $network_count=0;
                
       $profile_views_week1 = BusinessInsight::where("profile_id", $userId)
            ->where("created_at", ">=", Carbon::now()->subdays(7))
            ->count();

        $profile_views_week2 = BusinessInsight::where("profile_id", $userId)
            ->where("created_at", "<=", Carbon::now()->subdays(7))
            ->where("created_at", ">=", Carbon::now()->subdays(14))
            ->count();

        $profile_views_week3 = BusinessInsight::where("profile_id", $userId)
            ->where("created_at", "<=", Carbon::now()->subdays(14))
            ->where("created_at", ">=", Carbon::now()->subdays(21))
            ->count();

        $profile_views_week4 = BusinessInsight::where("profile_id", $userId)
            ->where("created_at", "<=", Carbon::now()->subdays(21))
            ->where("created_at", ">=", Carbon::now()->subdays(28))
            ->count();

        
        if($this->isMobile()) { 
		return view(
            "frontEnd.profile-creation.dashboard_mobile",
            compact(
                "user",
                "profile_views_week1",
                "profile_views_week2",
                "profile_views_week3",
                "profile_views_week4",
                "categorylists",
                "network",
                "network_list",
                "chat_data",
                "my_products",
                "profile_visit_count",
                "product_count",
                "network_count",
                "category_product_count"
            )
        );
        } else {
          return view(
            "frontEnd.profile-creation.dashboard",
            compact(
                "user",
                "profile_views_week1",
                "profile_views_week2",
                "profile_views_week3",
                "profile_views_week4",
                "categorylists",
                "network",
                "network_list",
                "chat_data",
                "my_products",
                "profile_visit_count",
                "product_count",
                "network_count",
                "category_product_count"
            )
        );
        
        
          }
        
        
        
        
        
        
        
        
        
        
    }

    public function BuyerDashboard()
    {
        if (Auth::guard("user")->check()) {
            if (!$this->PublicMiddlewareController->checkUserlogin()) {
                Auth::guard("user")->logout();
                return redirect(route("home"))->with(
                    "message",
                    "Access Denied"
                );
            }
        }

        $user_id = $userId = Auth::guard("user")->user()->id;
        $usertype = Auth::guard("user")->user()->usertype;
        $email_status = User::where("id", $userId)->value("email_status");
        $subsription = Subscription::where("user_id", $userId)
            ->where("status", "Active")
            ->latest("updated_at")
            ->first();

        $my_networks = Mynetworks::where("user_id", $userId)
            ->pluck("mynetwork_id")
            ->first();
        $network_id = explode(",", $my_networks);
        $user = User::find($userId);
        $network_list = User::select("name", "id", "profile_pic")
            ->whereIn("id", $network_id)
            ->get();
        $deleted_id = Chat_contact_delete::where("seller_id", $user_id)
            ->pluck("deleted_id")
            ->all();
        $chat_data = [];

        $a = Message::select("messages.to_user as mynetwork_id")
            ->where("from_user", $userId)
            ->whereNotIn("to_user", $deleted_id)
            ->groupBy("to_user")
            ->pluck("mynetwork_id")
            ->toArray();

        $b = Message::select("messages.from_user as mynetwork_id")
            ->where("to_user", $userId)
            ->whereNotIn("from_user", $deleted_id)
            ->groupBy("from_user")
            ->pluck("mynetwork_id")
            ->toArray();
        if (is_array($a) && is_array($b)) {
            $unioncontacts = array_merge($a, $b);
        } elseif (is_array($a)) {
            $unioncontacts = $a;
        } elseif (is_array($b)) {
            $unioncontacts = $b;
        } else {
            $unioncontacts = [];
        }
        $unioncontacts = array_unique($unioncontacts);
        $return_array = [];
        $chat_data = [];
        $contacts = User::select(
            "users.id",
            "users.name",
            "users.user_status",
            "users.profile_pic",
            "buyer_companies.company_name"
        )
            ->leftJoin(
                "buyer_companies",
                "users.id",
                "=",
                "buyer_companies.user_id"
            )
            ->whereIn("users.id", $unioncontacts)
            ->get();
        if (!$contacts->isEmpty()) {
            foreach ($contacts as $key => $row) {
                $unreadCount = Message::where("from_user", $row->id)
                    ->where("to_user", $userId)
                    ->where("message_status", "unread")
                    ->count();
                $latestMessage = Message::where(function ($query) use (
                    $userId,
                    $row
                ) {
                    $query
                        ->where("from_user", $userId)
                        ->where("to_user", $row->id);
                })
                    ->orWhere(function ($query) use ($userId, $row) {
                        $query
                            ->where("from_user", $row->idd)
                            ->where("to_user", $userId);
                    })
                    ->latest()
                    ->first();
                $chat_data[$key] = [
                    "contact" => $row,
                    "latestMessage" => $latestMessage,
                    "unreadcount" => $unreadCount,
                ];
            }
        }
        $prof_visited = [];
        $prof_visited = BusinessInsight::where("user_id", $userId)
            ->where("profile_id", "!=", $userId)
            ->whereNotNull("profile_id")
            ->groupBy("profile_id")
            ->leftJoin("users", "users.id", "=", "business_insights.profile_id")
            ->latest("business_insights.created_at")
            ->take(4)
            ->get();

        $prods_visited = BusinessInsight::select(
            "business_insights.product_id",
            "seller_products.name"
        )
            ->where("business_insights.user_id", $userId)
            ->whereNotNull("product_id")
            ->groupBy("product_id")
            ->where("seller_products.id", "!=", "business_insights.product_id")
            ->leftJoin(
                "seller_products",
                "seller_products.id",
                "=",
                "business_insights.product_id"
            )
            ->latest("business_insights.created_at")
            ->take(4)
            ->get();
        $prod_data = [];
        if (!$prods_visited->isEmpty()) {
            foreach ($prods_visited as $key => $row) {
                $thumbImg = SellerProductImage::select("image_path")
                    ->where("product_id", $row->product_id)
                    ->where("thumbnail", "yes")
                    ->latest()
                    ->first();

                $prod_data[$key] = ["product" => $row, "thumbImg" => $thumbImg];
            }
        }

        
       /* if ($usertype == "seller") {
            //if not seller redirect to home
            return redirect()->route("home");
        }*/

        $user = User::find($userId);
        $network = false;
        
        
        
        if($this->isMobile()) { 
          return view(
            "frontEnd.profile-creation.buyer-dashboard_mobile",
            compact(
                "user",
                "chat_data",
                "prof_visited",
                "subsription",
                "prod_data",
                "network",
                "email_status"
            )
        );
            
        } else {
          
            return view(
            "frontEnd.profile-creation.buyer-dashboard",
            compact(
                "user",
                "chat_data",
                "prof_visited",
                "subsription",
                "prod_data",
                "network",
                "email_status"
            )
        );
        }
        
        
        
    }

    public function BusinessInsight()
    {
        if (Auth::guard("user")->check()) {
            if (!$this->PublicMiddlewareController->checkUserlogin()) {
                Auth::guard("user")->logout();
                return redirect(route("home"))->with( "message", "Access Denied" );
            }
            if (
                !$this->PublicMiddlewareController->checkUserContactValidity()
            ) {
                Auth::guard("user")->logout();
                return redirect(route("home"));
            }
        }
        $userId = Auth::guard("user")->user()->id;
        if(Auth::guard("user")->user()->parent_id >0){
            $userId = Auth::guard("user")->user()->parent_id;
        }
        $user = User::leftjoin( "buyer_companies", "buyer_companies.user_id", "users.id" )
                      ->where("users.id", $userId)
                      ->first();
        $usertype = Auth::guard("user")->user()->usertype; 
        /*if ($usertype != "seller") {
            return redirect()->route("home");
        }*/
        
        
     /*   $parent_categorylist = Category::where("parent_id",null)->pluck("id")->all(); // all subcategories
				
			foreach ($parent_categorylist as $category_id) { 
			$category_name = Category::find($category_id, ["name", "category_pic"]); 
			$subcategorys=[];
			$prdt_count = $prd_cnt_sub = 0;
            array_push($subcategorys, $category_id); //parent category to array
       
				
				
				$prdt_count = SellerProduct::where(function ($query) use ($subcategorys) {
                        foreach ($subcategorys as $term) {
                            $query->orWhereRaw('find_in_set("' . $term . '",category_id)');
                        }
                    })
				->where("status", "active")
                ->where("user_id", $userId)
                ->count();
				
            
            $category_product_count[] = [
                "product_count" => $prdt_count,
                "category" => $category_name,
            ];
      

                }
		 arsort($category_product_count); 
		 
        $category_product_count = array_splice($category_product_count, 0, 4);
        */
        
       
        $parent_categorylist = Category::where("parent_id",null)->where("name",'<>','')->pluck("id")->all(); // all parent
				
			foreach ($parent_categorylist as $category_id) { 
			$category_name = Category::find($category_id, ["name", "category_pic"]); 
			$subcategorys=[];
			$prdt_count = $prd_cnt_sub = 0;
            array_push($subcategorys, $category_id); //parent category to array
       
				
				$categorylist = Category::where("parent_id", $category_id)->pluck("id")->all();  // all subcategories
                foreach ($categorylist as $value) {
                if (!in_array($value, $subcategorys)) { //subctegory id not in $category_id array
                    array_push($subcategorys, $value); //first level subcats
                } //all category ids as array

                for ($i = 0; $i < count($subcategorys); $i++) {
                    $category1 = Category::where("parent_id",$subcategorys[$i])->get();
                    foreach ($category1 as $value2) {
                        if (!in_array($value2->id, $subcategorys)) {
                            array_push($subcategorys, $value2->id);  //second level subcats
                        }
                    }
                }
                }
				
				
				$prdt_count = SellerProduct::where(function ($query) use ($subcategorys) {
                        foreach ($subcategorys as $term) {
                            $query->orWhereRaw('find_in_set("' . $term . '",category_id)');
                        }
                    })
				->where("status", "active")
                ->where("user_id", $userId)
                ->count();
				
            
            $category_product_count[] = [
                "product_count" => $prdt_count,
                "category" => $category_name,
            ];
      

                }
		 arsort($category_product_count); 
		 
        $category_product_count = array_splice($category_product_count, 0, 4);
        
        
       
        $values = [];
        $sellerProducts = SellerProduct::Select("category_id")
                            ->where("user_id", $userId)
                            ->get();
        foreach ($sellerProducts as $sproduct) {
            foreach (explode(",", $sproduct->category_id) as $value) {
                $values[] = trim($value);
            }
        }
        $values = array_unique($values);
      /*  $category_product_count = [];
        foreach ($values as $row) {
            $prdt_count = SellerProduct::where("status", "active")
                ->where("user_id", $userId)
                ->WhereRaw('find_in_set("' . $row . '",category_id)')
                ->count();
            $category_name = Category::find($row, ["name", "category_pic"]);
            $category_product_count[] = [
                "product_count" => $prdt_count,
                "category" => $category_name,
            ];
        }
        arsort($category_product_count);
        $category_product_count = array_splice($category_product_count, 0, 4);*/
        
        $categoryinsight = Category::whereIn("id", $values)->paginate(5);

        $categorylists = Category::whereIn("id", $values)->get();
        if (!$categoryinsight->isEmpty()) {
            foreach ($categoryinsight as $key => $list) {
                $my_products = SellerProduct::where("user_id", "=", $userId)
                    ->WhereRaw('find_in_set("' . $list->id . '",category_id)')
                    ->pluck("id")
                    ->toArray();
                $categoryinsight[$key]->insight_count = BusinessInsight::whereIn(
                    "product_id",
                    $my_products
                )->count();
                $categoryinsight[$key]->month_count = BusinessInsight::whereIn(
                    "product_id",
                    $my_products
                )
                    ->where("created_at", ">=", Carbon::now()->subdays(30))
                    ->count();
                $categoryinsight[$key]->week_count = BusinessInsight::whereIn(
                    "product_id",
                    $my_products
                )
                    ->where("created_at", ">=", Carbon::now()->subdays(7))
                    ->count();
                $categoryinsight[$key]->repeat_count = BusinessInsight::whereIn(
                    "product_id",
                    $my_products
                )
                    ->groupBy("product_id")
                    ->having("product_id", ">", 1)
                    ->count();
            }
        }

        $profile_views_week1 = BusinessInsight::where("profile_id", $userId)
            ->where("created_at", ">=", Carbon::now()->subdays(7))
            ->distinct('user_id')->count();

        $profile_views_week2 = BusinessInsight::where("profile_id", $userId)
            ->where("created_at", "<=", Carbon::now()->subdays(7))
            ->where("created_at", ">=", Carbon::now()->subdays(14))
            ->distinct('user_id')->count();

        $profile_views_week3 = BusinessInsight::where("profile_id", $userId)
            ->where("created_at", "<=", Carbon::now()->subdays(14))
            ->where("created_at", ">=", Carbon::now()->subdays(21))
            ->distinct('user_id')->count();

        $profile_views_week4 = BusinessInsight::where("profile_id", $userId)
            ->where("created_at", "<=", Carbon::now()->subdays(21))
            ->where("created_at", ">=", Carbon::now()->subdays(28))
            ->distinct('user_id')->count();

        $visits = DB::table("business_insights")
            ->leftJoin("users", "users.id", "=", "business_insights.user_id")
            ->select("users.country_id")
            ->where("business_insights.profile_id", $userId)
            ->where("business_insights.user_id", "!=", $userId)
            ->whereNotNull("users.country_id")
            //->groupBy('users.country_id')
            ->groupBy("business_insights.user_id")
            // ->orderBy('visit_count', 'DESC')
            ->get();
        
        $values = [];
        foreach ($visits as $visit) {
            $country_name = DB::table("countries")
                ->where("id", $visit->country_id)
                ->pluck("name")
                ->first();
            $values[] = $country_name;
        }

        $country_count = [];
        $countedValues = array_count_values($values);
        foreach ($countedValues as $key => $value) {
            $country_count[] = ["c_count" => $value, "country" => $key];
        }

        
        arsort($country_count);
        $country_count = array_slice($country_count, 0, 15);

        $productlists = SellerProduct::where("user_id", "=", $userId)->paginate(
            5
        );
        if (!$productlists->isEmpty()) {
            foreach ($productlists as $key => $list) {
                $productlists[$key]->insight_count = BusinessInsight::where(
                    "product_id",
                    $list->id
                )->count();
                $productlists[$key]->month_count = BusinessInsight::where(
                    "product_id",
                    $list->id
                )
                    ->where("created_at", ">=", Carbon::now()->subdays(30))
                    ->count();
                $productlists[$key]->week_count = BusinessInsight::where(
                    "product_id",
                    $list->id
                )
                    ->where("created_at", ">=", Carbon::now()->subdays(7))
                    ->count();
                $productlists[$key]->repeat_count = BusinessInsight::where(
                    "product_id",
                    $list->id
                )
                    ->groupBy("product_id")
                    ->having("product_id", ">", 1)
                    ->count();
            }
        }

        $inr = 7;
        $dates_name = $repeated_userdata = $new_userdata = [];
        while ($inr > 0) {
            $date = Carbon::now()->subdays($inr);
            array_push($dates_name, $date->format("l"));
            $repeated_user = BusinessInsight::where("profile_id", $userId)
                ->whereDate("visited_at", "=", $date->format("Y-m-d"))
                ->select(DB::raw("count(*) as count"))
                ->groupBy("user_id")
                ->havingRaw("COUNT(*) > 1")
                ->count();

            $new_user = BusinessInsight::where("profile_id", $userId)
                ->whereDate("visited_at", "=", $date->format("Y-m-d"))
                ->select(DB::raw("count(*) as count"))
                ->groupBy("user_id")
                ->havingRaw("COUNT(*) = 1")
                ->count();

            array_push($repeated_userdata, $repeated_user);
            array_push($new_userdata, $new_user);

            $inr--;
        }
        if($this->isMobile()) { 
           return view( "frontEnd.profile-creation.business-insight_mobile",compact("user","country_count","profile_views_week1","profile_views_week2","profile_views_week3","profile_views_week4","category_product_count","categoryinsight","productlists","categorylists","dates_name","repeated_userdata","new_userdata"));
        } else {
            return view( "frontEnd.profile-creation.business-insight",compact("user","country_count","profile_views_week1","profile_views_week2","profile_views_week3","profile_views_week4","category_product_count","categoryinsight","productlists","categorylists","dates_name","repeated_userdata","new_userdata"));
        }
    }
    public function getbusinessCategories(Request $request)
    {
        $userId = Auth::guard("user")->user()->id;
        $user = User::find($userId);
        $columnIndex_arr = $request->get("order");
        $columnName_arr = $request->get("columns");
        $order_arr = $request->get("order");
        $search_arr = $request->get("search");

        $draw = $request->get("draw");
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page
        $columnIndex = $columnIndex_arr[0]["column"]; // Column index
        $columnName = $columnName_arr[$columnIndex]["data"]; // Column name
        $columnSortOrder = $order_arr[0]["dir"]; // asc or desc

        $values = [];
        $sellerProducts = $user->SellerProduct;
        foreach ($sellerProducts as $sproduct) {
            foreach (explode(",", $sproduct->category_id) as $value) {
                $values[] = trim($value);
            }
        }
        $values = array_unique($values);

        // $searchValue = $search_arr['value']; // Search value
        $totalRecords = Category::select("count(*) as allcount")
            ->whereIn("id", $values)
            ->count();
        $totalRecordswithFilter = Category::select("count(*) as allcount")
            ->whereIn("id", $values)
            ->count();

        // Get records, also we have included search filter as well
        $records = Category::select("*")
            ->whereIn("id", $values)
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = [];

        if (!$records->isEmpty()) {
            foreach ($records as $record) {
                $my_products = SellerProduct::where("user_id", "=", $userId)
                    ->WhereRaw('find_in_set("' . $record->id . '",category_id)')
                    ->pluck("id")
                    ->toArray();
                $status = BusinessInsight::whereIn(
                    "product_id",
                    $my_products
                )->count();
                $last_month = BusinessInsight::whereIn(
                    "product_id",
                    $my_products
                )
                    ->where("created_at", ">=", Carbon::now()->subdays(30))
                    ->count();
                $last_week = BusinessInsight::whereIn(
                    "product_id",
                    $my_products
                )
                    ->where("created_at", ">=", Carbon::now()->subdays(7))
                    ->count();
                $repeat_count = BusinessInsight::whereIn(
                    "product_id",
                    $my_products
                )
                    ->groupBy("product_id")
                    ->having("product_id", ">", 1)
                    ->count();
                $data_arr[] = [
                    "id" => $record->id,
                    "name" => $record->name,
                    "status" => $status,
                    "last_week" => $last_week,
                    "last_month" => $last_month,
                    "repeat_count" => $repeat_count,
                ];
            }
        }

        $response = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        ];
        echo json_encode($response);
    }

    public function getbusinessproducts(Request $request)
    {
        $userId = Auth::guard("user")->user()->id;
        $columnIndex_arr = $request->get("order");
        $columnName_arr = $request->get("columns");
        $order_arr = $request->get("order");
        $search_arr = $request->get("search");

        $draw = $request->get("draw");
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page
        $columnIndex = $columnIndex_arr[0]["column"]; // Column index
        $columnName = $columnName_arr[$columnIndex]["data"]; // Column name
        $columnSortOrder = $order_arr[0]["dir"]; // asc or desc

        // $searchValue = $search_arr['value']; // Search value
        $totalRecords = SellerProduct::select("count(*) as allcount")
            ->where("user_id", $userId)
            ->where("status", "!=", "deleted")
            ->count();
        $totalRecordswithFilter = SellerProduct::select("count(*) as allcount")
            ->where("user_id", $userId)
            ->where("status", "!=", "deleted")
            ->where(function ($query) use ($request) {
                if ($request->get("search_key") != "") {
                    $query->where(
                        "name",
                        "Like",
                        "%" . $request->get("search_key") . "%"
                    );
                }
            })
            ->count();

        // Get records, also we have included search filter as well
        $records = SellerProduct::select("*")
            ->where("user_id", $userId)
            ->where("status", "!=", "deleted")
            ->where("user_id", $userId)
            ->where(function ($query) use ($request) {
                if ($request->get("search_key") != "") {
                    $query->where(
                        "name",
                        "Like",
                        "%" . $request->get("search_key") . "%"
                    );
                }
            })
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = [];
//dd($records);
        if (!$records->isEmpty()) {
            foreach ($records as $record) {
                $status = BusinessInsight::where(
                    "product_id",
                    $record->id
                )->count();
                $last_month = BusinessInsight::where("product_id", $record->id)
                    ->where("created_at", ">=", Carbon::now()->subdays(30))
                    ->count();
                $last_week = BusinessInsight::where("product_id", $record->id)
                    ->where("created_at", ">=", Carbon::now()->subdays(7))
                    ->count();
                $repeat_count = BusinessInsight::where(
                    "product_id",
                    $record->id
                )
                    ->groupBy("product_id")
                    ->having("product_id", ">", 1)
                    ->count();
                $data_arr[] = [
                    "id" => $record->id,
                    "name" => $record->name,
                    "status" => $status,
                    "last_week" => $last_week,
                    "last_month" => $last_month,
                    "repeat_count" => $repeat_count,
                ];
            }
        }

        $response = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        ];
        echo json_encode($response);
    }

    public function BuyerContactRequest()
    {
        if (Auth::guard("user")->check()) {
            $userId = Auth::guard("user")->user()->id;
        }
        $usertype = Auth::guard("user")->user()->usertype;
       /* if ($usertype != "buyer") {
            return redirect()->route("home");
        }*/
        $sellermessages = SellerMessage::select("*")
            ->where("user_id", $userId)
            ->latest()
            ->paginate(5);

        return view(
            "frontEnd.profile-creation.buyer-contact-request",
            compact("sellermessages")
        );
    }

    public function SellerProductPendingApprovals()
    {
        if (Auth::guard("user")->check()) {
            if (!$this->PublicMiddlewareController->checkUserlogin()) 
            {
                Auth::guard("user")->logout();
                return redirect(route("home"))->with(
                    "message",
                    "Access Denied"
                );
            }
            if (
                !$this->PublicMiddlewareController->checkUserValidity() &&
                Auth::guard("user")->user()->seller_type == "Co-Seller"
            ) {
                Auth::guard("user")->logout();
                return redirect(route("home"));
            }
        }
        $userId = Auth::guard("user")->user()->id;
        $user = User::find($userId);
        $usertype = Auth::guard("user")->user()->usertype; 
        /*if ($usertype != "seller") {
            return redirect()->route("home");
        }*/
        $values = [];
        $sellerProducts = $user->SellerProduct;
        foreach ($sellerProducts as $sproduct) {
            foreach (explode(",", $sproduct->category_id) as $value) {
                $values[] = trim($value);
            }
        }
        $values = array_unique($values);
        $categorylists = Category::whereIn("id", $values)
            ->pluck("name")
            ->all();
        $categories = Category::all();
        $my_products = SellerProduct::select("*")
            ->where("status", "pending")
            ->where("user_id", $userId)
            ->get();

        return view(
            "frontEnd.profile-creation.Sproduct-pending-approve",
            compact("user", "categories", "categorylists", "my_products")
        );
    }

    public function getSellerPendingProductlist(Request $request)
    {
        $usertype = Auth::guard("user")->user()->usertype;
       /* if ($usertype != "seller") {
            return redirect()->route("home");
        }*/
        $columnIndex_arr = $request->get("order");
        $columnName_arr = $request->get("columns");
        $order_arr = $request->get("order");
        $search_arr = $request->get("search");

        $draw = $request->get("draw");
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page
        $columnIndex = $columnIndex_arr[0]["column"]; // Column index
        $columnName = $columnName_arr[$columnIndex]["data"]; // Column name
        $columnSortOrder = $order_arr[0]["dir"]; // asc or desc
        // $searchValue = $search_arr['value']; // Search value
        $userId = Auth::guard("user")->user()->id;
        $totalRecords = SellerProduct::select("count(*) as allcount")
            ->where("status", "pending")
            ->where("user_id", $userId)
            ->count();
        $totalRecordswithFilter = SellerProduct::select("count(*) as allcount")
            ->where("status", "pending")
            ->where("user_id", $userId)
            ->where(function ($query) use ($request) {
                if ($request->get("search_key") != "") {
                    $query->where(
                        "name",
                        "Like",
                        "%" . $request->get("search_key") . "%"
                    );
                }
                if ($request->get("category_id") != null) {
                    $query->whereRaw(
                        'find_in_set("' .
                            $request->get("category_id") .
                            '",category_id)'
                    );
                }

                if ($request->get("stock") != null) {
                    if ($request->get("stock") == "instock") {
                        $query->where("stock_count", ">", 0);
                    } else {
                        $query->where("stock_count", "<=", 0);
                    }
                }
            })
            ->count();

        // Get records, also we have included search filter as well
        $records = SellerProduct::select("*")
            ->where("status", "pending")
            ->where("user_id", $userId)
            ->where(function ($query) use ($request) {
                if ($request->get("search_key") != "") {
                    $query->where(
                        "name",
                        "Like",
                        "%" . $request->get("search_key") . "%"
                    );
                }
                if ($request->get("category_id") != null) {
                    $query->whereRaw(
                        'find_in_set("' .
                            $request->get("category_id") .
                            '",category_id)'
                    );
                }

                if ($request->get("stock") != null) {
                    if ($request->get("stock") == "instock") {
                        $query->where("stock_count", ">", 0);
                    } else {
                        $query->where("stock_count", "<=", 0);
                    }
                }
            })
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = [];

        foreach ($records as $record) {
            $strcat = $strcat_parent = "";
            $cat_selected = Category::where(
                "id",
                $record->category_id
            )->first();

            if (!empty($cat_selected)) {
                if ($cat_selected->getParentsNames()) {
                    foreach (
                        $cat_selected->getParentsNames()->reverse()
                        as $item_selected
                    ) {
                        $strcat_parent .= $item_selected->name . ">>";
                    }
                }
            }

            $strcat = "";

            $category = Category::where("id", $record->category_id)->first();
            if (!empty($category)) {
                if (is_null($category->parent_id)) 
                {
                    $strcat_parent = $category->name . ">>";
                } else {
                    $strcat = $category->name;
                }
            }

            $strimg = "";

            foreach ($record->SellerProductImage as $productimage) {
                if ($productimage->thumbnail == "yes") {
                    $strimg .=
                        '<div class="table-prof"><img style=" width:60px !important;" class="pr_img" src="' .
                        asset("/uploads/productImages/") .
                        "/" .
                        $productimage->image_path .
                        ' "></div>';
                }
            }
            $seller = User::find($userId);
            $start = $start + 1;
            $data_arr[] = [
                "id" => $record->id,
                "name" => $record->name,
                "company_name" => $seller->BuyerCompany->company_name ?? "",
                "location" => $seller->BuyerCompany->company_location ?? "",
                "product_price" => $record->product_price,
                "strcat_parent" => $strcat_parent,
                "strcat" => $strcat,
                "status" => $record->status,
                "created_at" => date(
                    "d/m/Y   \&\\n\b\s\p\; \&\\n\b\s\p\; \&\\n\b\s\p\;  g:i A",
                    strtotime($record->created_at)
                ),
                "strimg" => $strimg,
            ];
        }

        $response = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        ];
        echo json_encode($response);
    }

    public function profile_to_network(Request $request)
    {
        $login_id = Auth::guard("user")->user()->id;
        /*if(Auth::guard("user")->user()->seller_type=="Co-Seller")
                $login_id=Auth::guard("user")->user()->parent_id;*/
	
        $to_network_id = $request->get("user_id");
        $networks = Mynetworks::where("user_id", $login_id)->first();
        if (empty($networks)) {
            $network_users = $to_network_id . ",";
            Mynetworks::create([
                "user_id" => $login_id,
                "mynetwork_id" => $network_users,
            ]);
            $msg = "Added to Networks";
        } else {
            $network_users = $networks->mynetwork_id . $to_network_id . ",";
            $networks->update(["mynetwork_id" => $network_users]);
            $msg = "Added to Networks";
        }
        
        Mynetwork_request::create([
                "user_id" => $login_id,
                "network_id" => $to_network_id,
            ]);
        //$user = User::find($to_network_id);
        
        // Mail::send(
        //     "emails.MynetworkEmail",
        //     ["user_name" => $user->name, "profile_user_name" => Auth::guard("user")->user()->name],
        //     function ($message) use ($user) {
        //         $email = $user->email;
        //         $message->to($email);
        //         $message->subject("Network Adding Notification - FMCG");
        //     }
        // );
        Session::put("tab", "myCdb");
        echo json_encode($msg);
    }
   
    
    
    
   public function CompanyProfile($profId =null)
    {       
        $active_package="Yes" ;
        if (Auth::guard("user")->check()) {
            if (!$this->PublicMiddlewareController->checkUserlogin()) {
                Auth::guard("user")->logout();
                return redirect(route("home"))->with(
                    "message",
                    "Access Denied"
                );
            } 
            if (!$this->PublicMiddlewareController->checkUserContactValidity()) {
                $active_package="No" ;
              //  Auth::guard("user")->logout();
               // return redirect(route("home"));
            }
        }        
        if($profId!=null)
            $userId = $profId;
        else {
            $userId=Auth::guard("user")->user()->id;
            if(Auth::guard("user")->user()->seller_type=="Co-Seller")
                $userId=Auth::guard("user")->user()->parent_id;
		}
        $user = User::find($userId);      
        $active_region=$user->CompanyRegion->active_countries??"";
        $active_reg = explode(',',$active_region); 
        $active_reg_list = Country::select('*')
            ->whereIn("id", $active_reg)
            ->get();  
        $expand_regions=$user->CompanyRegion->expand_countries??"";
        $expand_reg = explode(',',$expand_regions);
        $expand_reg_list = Country::select('*')
            ->whereNotIn("id", $active_reg)
            ->whereIn("id", $expand_reg)
            ->get(); 
        $all_continents = Country::distinct() 
            ->where('continent','<>','')
            ->where('continent', '<>', null)
            ->orderBy('continent','asc')
            ->pluck("continent")
            ->all();     
        $active_continents = Country::whereIn("id", $active_reg)
            ->distinct() 
            ->orderBy('continent','asc')
            ->pluck("continent")
            ->all();    
        $remainining_toexpand = Country::whereNotIn("id", $active_reg)
            ->distinct() 
            ->orderBy('continent','asc')
           // ->pluck("continent")
            ->get();	    
        $expand_continents = Country::whereIn("id", $expand_reg)->whereNotIn("id", $active_reg)
            ->distinct() 
            ->orderBy('continent','asc')
            ->pluck("continent")
            ->all();    
            
        $active_users=$this->PublicMiddlewareController->getexpireduserslist(); 
       
        $network_ids = Mynetworks::where("user_id", $userId)
                        ->pluck("mynetwork_id")->first();
        if($network_ids!='')
        {
                $arrayData=explode(',', rtrim($network_ids,','));
                $network_count=User::whereIn('id',$arrayData)
                ->whereIn('users.id',$active_users)->count();  
        }
        else
        $network_count=0;         
        $values = [];
        $seller_type=$user->seller_type??"";
        if ($seller_type != "Master") {
            $parent_id=$user->parent_id??'';
            if($parent_id!='')
            $user = User::find($user->parent_id);
        }
        $usertype = Auth::guard("user")->user()->usertype;
        
        $toView_user = User::find($userId);
        
        
        
        $max_product_price = SellerProduct::where("seller_products.status", "active")
                ->where('product_visibility','Yes')
                ->where('price_on_request','<>','Price on request');
                if ($profId==null && Auth::guard("user")->user()->seller_type == "Co-Seller") {
                    $max_product_price = $max_product_price->where("user_id", Auth::guard("user")->user()->parent_id );
                }
                elseif ($profId!=null && $toView_user->seller_type == "Co-Seller"){
                    $max_product_price = $max_product_price->where("user_id", $toView_user->parent_id );
                }
                else{ $max_product_price = $max_product_price->where("user_id", $userId); }
                
                $max_product_price = $max_product_price->where("status", "active")
                ->max("product_price");
        $max_product_price = ceil($max_product_price ?? 0 );
        $distinctBrandIds = SellerProduct::distinct()->where('seller_products.user_id',$userId)->where("seller_products.status", "active")->where('seller_products.product_visibility','Yes')->pluck('brands');
        $brand_lists = Productbrand::select( "productbrands.id", "productbrands.name")->whereIn("id", $distinctBrandIds)->orderBy('name',"ASC")->get();
        $parent_cat_id = SellerProduct::distinct()->where('seller_products.user_id',$userId)->where("seller_products.status", "active")->where('seller_products.product_visibility','Yes')->pluck('parent_category_id')->toArray();
         
        $parent_categorylists = Category::whereIn("id", $parent_cat_id)->orderBy('name',"ASC")->get();
         
        $category_product_count = 0 ;
        $seller_Ofln_Cats = SellerOfflineCategory::select('category_id')->where('user_id', $userId)->first();
        if ($seller_Ofln_Cats) 
            $seller_offine_categorylists = explode(",", $seller_Ofln_Cats->category_id);
        else 
            $seller_offine_categorylists = []; 
        if(!empty($seller_offine_categorylists)&&!empty($parent_cat_id))
        $combinedArray = array_merge($seller_offine_categorylists, $parent_cat_id);
        else if(!empty($seller_offine_categorylists))
        $combinedArray = $seller_offine_categorylists;
        else
        $combinedArray = $parent_cat_id;
        $categorylists = Category::whereIn("id", $combinedArray) 
            ->where('parent_id',null)
            ->whereNotNull('name')
            ->where('name','<>','')
            ->distinct() 
            ->orderBy('name','asc')
            ->pluck("name")
            ->all();
            
           

        $login_id = null;
        if (Auth::guard("user")->check()) {
            $login_id = Auth::guard("user")->user()->id;
        }
        $counts = Mynetworks::where("user_id", $login_id)
            ->whereRaw('find_in_set("' . $userId . '",mynetwork_id)')
            ->count();
        if ($counts > 0 || $userId == $login_id) {
            $network = false;
        } else {
            $network = true;
        }

        $my_products = SellerProduct::select("*")
            ->where("status", "active")
            ->where("user_id", $userId)
            ->where("status","<>", "deleted")
            ->latest()
            ->take(4)
            ->get();
        $my_networks = Mynetworks::where("user_id", $userId)
            ->pluck("mynetwork_id")
            ->first();
        $network_id = explode(",", $my_networks);
        $network_list = User::select("name", "id", "profile_pic")
            ->whereIn("id", $network_id)
            ->get();
        $chat_data = [];
        if (!$network_list->isEmpty()) {
            foreach ($network_list as $key => $row) {
                $unreadCount = Message::where("from_user", $row->id)
                    ->where("to_user", $userId)
                    ->where("message_status", "unread")
                    ->count();
                $latestMessage = Message::where(function ($query) use (
                    $userId,
                    $row
                ) {
                    $query
                        ->where("from_user", $userId)
                        ->where("to_user", $row->id);
                })
                    ->orWhere(function ($query) use ($userId, $row) {
                        $query
                            ->where("from_user", $row->id)
                            ->where("to_user", $userId);
                    })
                    ->orderBy("id", "desc")
                    ->take(5)
                    ->get();
                // })->latest()->first();
                $chat_data[$key] = [
                    "contact" => $row,
                    "latestMessage" => $latestMessage,
                    "unreadcount" => $unreadCount,
                ];
            }
        }
        $profile_visit_count = BusinessInsight::where("profile_id",$userId)->distinct('user_id')->count();
        //->count();
        $product_count = SellerProduct::where("user_id", $userId)
        ->where("status", "active")
        ->where("status","<>", "deleted")
        ->count();

        $clientIP = \Request::ip();
        $prof_vist_count=BusinessInsight::where('user_id','=',$login_id)->where('profile_id','=',$userId)->where('ip_address','=',$clientIP)->count();
        
        $insight = [];
        if($login_id!=$userId && $prof_vist_count==0) {
        $insight = [
            "user_id" => $login_id,
            "profile_id" => $userId,
            "ip_address" => $clientIP,
        ];
        BusinessInsight::create($insight); }
       $company_types = CompanyType::select("id", "company_type")->get();
       $countries = Country::select("id","continent", "name")->get();
       $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get(); 
       $seller_OflnCats = SellerOfflineCategory::select('category_id')->where('user_id', $userId)->first();
       $delete_request = ProfileAccountDeleteRequest::where("user_id",Auth::guard("user")->user()->id)->where("status", "New")->get();
       
       if (count($delete_request) > 0) {
            $delete_request_active = true;
        } else {
            $delete_request_active = false;
        }
         if($this->isMobile())
         {
           return view(
            "frontEnd.profile-creation.CompanyProfile_mobile",compact("user","remainining_toexpand","delete_request_active","active_package","active_reg_list","expand_reg_list","active_continents","all_continents","expand_continents",'seller_OflnCats','categories','max_product_price',"countries","brand_lists",'company_types',"categorylists", "network","profile_visit_count","product_count","network_count","category_product_count","parent_categorylists"));
           
       }
        else 
          { 
              return view( "frontEnd.profile-creation.CompanyProfile",compact("user","remainining_toexpand","delete_request_active","active_package","active_reg_list","expand_reg_list","active_continents","all_continents","expand_continents",'seller_OflnCats','categories','max_product_price',"countries","brand_lists",'company_types',"categorylists","network","profile_visit_count","product_count", "network_count","category_product_count","parent_categorylists"));
              
        }
    }


    public function BuyerProfile()
    {
        $userId = Auth::guard("user")->user()->id;
        $usertype = Auth::guard("user")->user()->usertype;
        $email_status = User::where("id", $userId)->value("email_status");
        $order = OrderDetail::where("user_id", $userId)
            ->latest("updated_at")
            ->first();

        $subscriptions = Subscription::where("user_id", $userId)
            ->where("status", "Active")
            ->whereDate("expairy_date", ">", now())
            ->groupBy("package_id")
            ->orderBy("id", "DESC")
            ->latest("updated_at")
            ->first();
        if (empty($subscriptions)) {
            $subscriptions = "";
        }

       /* if ($usertype == "seller") {
            //if not seller redirect to home
            return redirect()->route("home");
        }*/

        $user = User::find($userId);
        $network = false;
        $countries = Country::select("id", "name")->get();

        $clientIP = \Request::ip();
        $insight = [];
        $company_type = "";
        if (!empty($user->BuyerCompany->company_type)) {
            $cType_id = $user->BuyerCompany->company_type;
            $company_type = CompanyType::where("id", $cType_id)
                ->pluck("company_type")
                ->first();
        }

        return view(
            "frontEnd.profile-creation.BuyerProfile",
            compact(
                "user",
                "order",
                "company_type",
                "network",
                "countries",
                "subscriptions",
                "email_status"
            )
        );
    }
    public function UpdateSellerProfile(Request $request)
    {
        $userId = Auth::guard("user")->user()->id;
        $user = User::find($userId);
        request()->validate([
            "store_name" => ["required", "string", "max:255"],
            "email" => [
                "required",
                "email",
                "regex:/(.+)@(.+)\.(.+)/i",
                Rule::unique("users")
                    ->ignore($userId)
                    ->where(function ($query) {
                        return $query->where("status", "<>", "Deleted");
                    }),
            ],
            "phone" => [
                "required",
                'regex:/^(^([+]+)(\d+)?$)$/',
                Rule::unique("users")
                    ->ignore($userId)
                    ->where(function ($query) {
                        return $query->where("status", "<>", "Deleted");
                    }),
            ],
        ]);

        $input = [
            "store_name" => $request->get("store_name"),
            "email" => $request->get("email"),
            "phone" => $request->get("phone"),
            "hide_promo_email" => $request->get("hide_promo_email"),
            "newsletter_status" => $request->get("newsletter_status"),
        ];
        DB::table("users")
            ->where("id", $userId)
            ->update($input);
        return redirect()
            ->route("edit.seller.profile", $userId)
            ->with("message", "Profile Updated");
    }
    
    
    
    
    
    

    public function NewsletterSubscription(Request $request)
    {
        $request->validate([
            "email" => [ "required", "regex:/(.+)@(.+)\.(.+)/i", "email",  "unique:newsletter_subscriptions",],
        ]);
        $query = DB::table("newsletter_subscriptions")->insert([
            "email" => $request->email,
        ]);
        echo json_encode("Thank You For Subscribing!");
    }

    public function loadproducts(Request $request)
    {
        $start_from = $request->input("start_from");
        $search_bykeyword = $request->input("search_bykeyword");
        $category_id = $request->input("category_id");
        $per_page = $request->input("per_page");
        $userId = $request->input("user_id");
        $user = User::find($userId);
        $seller_type = $user->seller_type;
        $parent_id = $user->parent_id;



        $loadProducts = SellerProduct::where("status", "active")->where('seller_products.product_visibility','Yes');
        if ($seller_type == "Co-Seller") {
            $loadProducts = $loadProducts->where("user_id", "=", $parent_id);
        } else {
            $loadProducts = $loadProducts->where("user_id", $userId);
        }

        if($category_id!="0"){
            $subcategorys=[];
            $categorylist = Category::where("parent_id", $category_id)->pluck("id")->all(); // all subcategories
            array_push($subcategorys, $category_id); //prent category to array

            foreach ($categorylist as $value) {
                if (!in_array($value, $subcategorys)) {
                    //subctegory id not in $category_id array
                    array_push($subcategorys, $value);
                } //all category ids as array

                for ($i = 0; $i < count($subcategorys); $i++) {
                    $category1 = Category::where("parent_id",$subcategorys[$i])->get();
                    foreach ($category1 as $value2) {
                        if (!in_array($value2->id, $subcategorys)) {
                            array_push($subcategorys, $value2->id);
                        }
                    }
                }
                }
          

            $loadProducts = $loadProducts->where(function ($query) use ($subcategorys) {
                        foreach ($subcategorys as $term) {
                            $query->orWhereRaw('find_in_set("' . $term . '",category_id)')
                                  ->where("seller_products.status", "active");
                        }
                    });
        }
        if($search_bykeyword!="")
            $loadProducts = $loadProducts->where(DB::raw("lower(seller_products.name)"),"LIKE","%" .strtolower($search_bykeyword)."%");
        

        $count = $loadProducts->count();
        $loadProducts = $loadProducts
            ->skip($start_from)
            ->take($per_page)
            ->get();

        $data_return = [];
        foreach ($loadProducts as $data) {
            $created_at = date("M d , Y", strtotime($data->created_at));
            $product_images = SellerProductImage::where(
                "product_id",
                "=",
                $data->id
            )->get();
            $prd_img=asset("images/no-image.jpg");
            $cnt = count($product_images);
            if ($cnt > 0) {
                if (!empty($product_images)) {
                    foreach ($product_images as $productimage) {
                        if ($productimage->thumbnail == "yes") {
                            $prd_img =
                                asset("/uploads/productImages/") ."/" . $productimage->image_path;
                        }
                    }
                }
            } else {
                $prd_img = asset("images/no-image.jpg");
            }

            $data_return[] = [
                "name" => $data->name,
                "user_id" => $userId,
                "prd_img" => $prd_img,
                "prd_id" => $data->id,
            ];
        }
        $return_array = ["count" => $count, "loadProducts" => $data_return];
        return json_encode($return_array);
    }
    public function loadproductsCompProf(Request $request)
    {
        $start_from = $request->input("start_from");
        $search_bykeyword = $request->input("search_bykeyword");
        $search_bbd = $request->input("search_bbd"); 
        $category_id = $request->input("category_id");
        $brand_id = $request->input("brand_id");
        $search_by_location = $request->input("search_by_location");
        $price_range = explode("-", $request->input("price_range")); 
        $start_range = $price_range[0];
        $end_range = $price_range[1];
        $priceOnRequest = $request->input("priceOnRequest");
        $per_page = $request->input("per_page");
        $userId = $request->input("user_id");
        $user = User::find($userId);
        $seller_type = $user->seller_type;
        $parent_id = $user->parent_id;
        $country_name=$user->Country->name ?? '';

                   
        $loadProducts = SellerProduct::leftJoin("wishlists", "wishlists.product_id", "=", "seller_products.id")
            ->where("seller_products.status", "active")->where('seller_products.product_visibility','Yes')->orderBy("seller_products.created_at",'DESC');
        if ($seller_type == "Co-Seller") {
            $loadProducts = $loadProducts->where("seller_products.user_id", "=", $parent_id);
        } else {
            $loadProducts = $loadProducts->where("seller_products.user_id", $userId);
        }

        if($category_id!="0"){
            $subcategorys=[];
            $categorylist = Category::where("parent_id", $category_id)->pluck("id")->all(); // all subcategories
            array_push($subcategorys, $category_id); //prent category to array

            foreach ($categorylist as $value) {
                if (!in_array($value, $subcategorys)) {
                    //subctegory id not in $category_id array
                    array_push($subcategorys, $value);
                } //all category ids as array

                for ($i = 0; $i < count($subcategorys); $i++) {
                    $category1 = Category::where("parent_id",$subcategorys[$i])->get();
                    foreach ($category1 as $value2) {
                        if (!in_array($value2->id, $subcategorys)) {
                            array_push($subcategorys, $value2->id);
                        }
                    }
                }
                }
          

            $loadProducts = $loadProducts->where(function ($query) use ($subcategorys) {
                        foreach ($subcategorys as $term) {
                            $query->orWhereRaw('find_in_set("' . $term . '",category_id)')
                                  ->where("seller_products.status", "active");
                        }
                    });
        }
        if ($brand_id != "") {
                //$brand_id = explode(",", $request->input("brand_id"));
                $loadProducts = $loadProducts->where("brands", $brand_id);
            }
            
            
           if($priceOnRequest==1)
            {
                $loadProducts = $loadProducts->where('seller_products.price_on_request','Price on request');
            }
            elseif($priceOnRequest==2)
            {
                $loadProducts = $loadProducts
                ->whereBetween( "seller_products.product_price",[$start_range, $end_range])
                ->where('seller_products.price_on_request','<>','Price on request');
            }
            else
            {
                $loadProducts = $loadProducts ->where(function ($query) use ($start_range,$end_range) {
                    $query->whereBetween( "seller_products.product_price",[$start_range, $end_range])
                       ->where('seller_products.price_on_request','<>','Price on request')
                       ->orWhere('seller_products.price_on_request','Price on request');
               });
            }  
            
            
            
        if($search_bykeyword!="")
            $loadProducts = $loadProducts->where(DB::raw("lower(seller_products.name)"),"LIKE","%" .strtolower($search_bykeyword)."%");
         if($search_bbd!="")
         { 
             //$search_bbd = \Carbon::createFromFormat('d/m/Y', $search_bbd);
            $date = Carbon::createFromFormat('Y-m-d', $search_bbd);
            $loadProducts = $loadProducts->
          
            whereDate('seller_products.product_expiry', '>=', $search_bbd);
         }
       if ($search_by_location != "") {
                //$brand_id = explode(",", $request->input("brand_id"));
              //  $loadProducts = $loadProducts->where("brands", $brand_id);
            }
        

        $count = $loadProducts->distinct('seller_products.id')->count();
   
        $loadProducts = $loadProducts
            ->select("seller_products.*", "wishlists.wishlist")
            ->groupBy('seller_products.id')
            ->skip($start_from)
            ->take($per_page)
            ->get();

        $data_return = [];
        foreach ($loadProducts as $data) {
            $created_at = date("M d , Y", strtotime($data->created_at));
            $product_images = SellerProductImage::where("product_id","=", $data->id )->get();
            $prd_img=asset("images/no-image.jpg");
            $cnt = count($product_images);
            if ($cnt > 0) {
                if (!empty($product_images)) {
                    foreach ($product_images as $productimage) {
                        if ($productimage->thumbnail == "yes") {
                            $prd_img =
                                asset("/uploads/productImages/") ."/" . $productimage->image_path;
                        }
                    }
                }
            } else {
                $prd_img = asset("images/no-image.jpg");
            }
            $curreny_symbol = '$';
            if (!empty($data->Currency->symbol)) {
                    $curreny_symbol = $data->Currency->symbol;
                }
           if(strtolower(trim($data->price_on_request)) != strtolower('Price on request')) {
                        if (strtolower(trim($data->price_negotiable)) == strtolower('Negotiable')) {
                            $product_price =$curreny_symbol.'&nbsp;'.$data->product_price ."<span class='nego-pric'> (Price Negotiable)</span>";
                        } else {
                            
                    $prod_price = $data->product_price;
                    $no_of_dec =0;
                   if (strpos($prod_price, ".") !== false) {
                         $v_fileFloatb = explode(".", $prod_price);
                         $no_of_dec = strlen($v_fileFloatb[1]);   
                   }

                  
                   if($no_of_dec==1)
                   $product_price = $curreny_symbol.'&nbsp;'.rtrim(rtrim(number_format($data->product_price,3), '0'), '.').'0';
                   else 
                   $product_price = $curreny_symbol.'&nbsp;'.rtrim(rtrim(number_format($data->product_price,3), '0'), '.');
                           
                        }
                    } else {
                        $product_price = "Price on Request";
                    }
                           
                      
                    
                          
            $data_return[] = [
                "wish_listed" => $data->wishlist,
                "name" => $data->name,
                "user_id" => $userId,
                "prd_img" => $prd_img,
                "price" => $product_price,
                "available_countries" => $country_name,
                "prd_id" => $data->id,
            ];
        } 
        $return_array = ["count" => $count, "loadProducts" => $data_return];
        return json_encode($return_array);
    }
    
    public function loadEmployeesCompProf(Request $request)
    {
        $start_from = $request->input("start_from");
        $per_page = $request->input("per_page");
        $userId = $request->input("user_id");
        $profId = $request->input("profId");
        
        if($profId!=null)
        $userId = $profId;
        
            $user = User::find($userId);
            if($user->seller_type=="Co-Seller")
            {
              $co_users = User::where("status", "<>", "Deleted")
                          ->Where("parent_id", $user->parent_id)
                          ->where(function ($query) {
                            $query ->where("status",  "Active")
                            ->orWhere("status",  "Invited");
                            })
                           ->orWhere("id", $user->parent_id);  
            }
            else{
                $co_users = User::where("status", "<>", "Deleted")
                          ->Where("parent_id", $user->id)
                          ->where(function ($query) {
                            $query ->where("status",  "Active")
                            ->orWhere("status",  "Invited");
                            })
                          ->orWhere("id", $user->id);
                                           
            }
        
        
        
        $count = $co_users->distinct('id')->count();
        $co_users = $co_users
                    ->groupBy('id')
                    ->skip($start_from)
                    ->take($per_page)
                    ->get();      
        

        $data_return = [];
        foreach ($co_users as $data) {
            if($data->profile_pic) 
            $prof_img=asset('uploads/userImages/').'/'.$data->profile_pic ;
            else
            $prof_img=asset('/uploads/defaultImages/images_not_avaailable.png');
            $parent="No";
            if (is_null($data->parent_id)) 
            $parent="Yes";
            $data_return[] = [
                "id" => $data->id,
                "name" => $data->name,
                "surname" => $data->surname??'',
                "position" => $data->position,
                "prof_img" => $prof_img,
                "parent" => $parent,
                "email" => $data->email,
                "phone" => $data->phone,
            ];
        } 
        $return_array = ["count" => $count, "loadEmployees" => $data_return];
        return json_encode($return_array);
    }
     public function resend_veryfication_email(Request $request)
    {
        $email_id=$request->input("email_id");
        $token =Str::random(60) . date("Ymdss");
        $user_data=DB::table("users")
            ->where("email", $email_id)->latest('id')->first();
        DB::table("users")
            ->where("email", $email_id)
            ->where("id",$user_data->id)
            ->update(["token_number" => $token]);
       
       Mail::send(
            "emails.KYCApprovalMailTemplate",
            ["token" => $token, "user_id" => $user_data->id],
            function ($message) use ($email_id) {
                $message->to($email_id);
                $message->subject("Verify Email - FMCG");
            }
        );
         
        return redirect(route('user-login'))->with('message','Email_not_verified:'.$email_id); 
    }
    public function updateNotificationStatus(Request $request)
    {
        $chat_notification=$request->input("chat_notification");
        $sender_id = Auth::guard('user')->user()->id;
        $users = User::find($sender_id);
        $users->chat_notification =  $chat_notification;
        $users->save(); 
        $return_array = array('ajax_status' => true);
    }
}
