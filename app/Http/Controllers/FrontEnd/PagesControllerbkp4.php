<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\SellerProduct;
use App\Models\SellerProductImage;
use App\Models\Category;
use App\Models\TopCategory;
use App\Models\Product;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Contentpage;
use App\Models\CompanyType;
use App\Models\Mynetworks;
use App\Models\Message;
use App\Models\Generalsetting;
use App\Models\Advertisement;
use App\User;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FrontEnd\PublicMiddlewareController;
class PagesController extends Controller
{
    protected $PublicMiddlewareController;
    public function __construct(
        PublicMiddlewareController $PublicMiddlewareController
    ) {
        $this->PublicMiddlewareController = $PublicMiddlewareController;
    }

    public function HomePage()
    {
        $active_sellers = $this->PublicMiddlewareController->getexpiredsellerslist();
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

        $products = SellerProduct::leftJoin(
            "users",
            "users.id",
            "=",
            "seller_products.user_id"
        )
            ->select("seller_products.*")
            ->where("users.status", "Active")
            ->whereIn("seller_products.user_id", $active_sellers)
            ->where("seller_products.status", "active")
            ->latest("seller_products.created_at")
            ->take(10)
            ->get();

        $featured_products = SellerProduct::leftJoin(
            "users",
            "users.id",
            "=",
            "seller_products.user_id"
        )
            ->select("seller_products.*")
            ->where("users.status", "Active")
            ->whereIn("seller_products.user_id", $active_sellers)
            ->where("seller_products.status", "active")
            ->where("seller_products.featured_product", "Yes")
            ->latest("seller_products.created_at")
            ->take(8)
            ->get();

        $newest_company = User::leftjoin(
            "buyer_companies",
            "buyer_companies.user_id",
            "=",
            "users.id"
        )
            ->where("users.usertype", "seller")
            // ->where('company',"Yes")
            ->where("users.status", "Active")
            ->where("buyer_companies.company_name", "<>", "null")
            ->where("buyer_companies.company_name", "<>", "")
            ->select("buyer_companies.*", DB::raw("'' as product_image"))
            ->orderBy("users.id", "DESC")
            ->take(4)
            ->get();

        foreach ($newest_company as $key => $value) {
            $company_product = User::find($value->user_id);
            $image_path = "";
            if (count($company_product->SellerProduct) > 0) {
                $seller_productimg =
                    $company_product->SellerProduct[0]->SellerProductImage;
                foreach ($seller_productimg as $img) {
                    if ($img->thumbnail == "yes") {
                        $image_path = asset(
                            "/uploads/productImages/" . $img->image_path
                        );
                    }
                }
                if ($image_path == "") {
                    $image_path = asset("/uploads/defaultImages/no_image.jpg");
                }
            } else {
                $image_path = asset("/uploads/defaultImages/no_image.jpg");
            }
            $newest_company[$key]->product_image = $image_path;
        }

        $countries = Country::all();
        $slider = Slider::where("show_home", "Yes")
            ->with("Sliderimage")
            ->first();
        $welcome_page_adds = Advertisement::leftJoin(
            "contentpages",
            "contentpages.id",
            "=",
            "advertisements.page_id"
        )
            ->whereRaw("? between start_date and end_date", [date("Y-m-d")])
            ->where("page", "Welcome Page")
            ->select(
                "media_type",
                "media_file",
                "link_url",
                "advertisements.title",
                "position"
            )
            ->get();

        $TopCategory = TopCategory::pluck("category_id")->all();
        $all_categories = DB::table("categories")
            ->whereIn("id", $TopCategory)
            ->get();
        $validity = $this->PublicMiddlewareController->checkUserContactValidity();
        return view(
            "welcome",
            compact(
                "slider",
                "products",
                "welcome_page_adds",
                "featured_products",
                "countries",
                "all_categories",
                "newest_company",
                "validity"
            )
        );
    }
    public function TermsAndCondition()
    {
        $terms = Contentpage::where("page", "Terms & Conditions")->first();
        return view("frontEnd.pages.TermsAndCondition", compact("terms"));
    }

    public function PrivacyPolicy()
    {
        $privacy = Contentpage::where("page", "Privacy Policy")->first();
        return view("frontEnd.pages.PrivacyPolicy", compact("privacy"));
    }
    public function RefundPolicy()
    {
        $refund_policy = Contentpage::where("page", "Refund Policy")->first();
        return view("frontEnd.pages.RefundPolicy", compact("refund_policy"));
    }

    public function CookiePolicy()
    {
        $cookie_policy = Contentpage::where("page", "Cookie Policy")->first();
        return view("frontEnd.pages.CookiePolicy", compact("cookie_policy"));
    }

    public function AboutUs()
    {
        $about_us = Contentpage::where("page", "About Us")->first();
        return view("frontEnd.pages.AboutUs", compact("about_us"));
    }

    public function mynetwork()
    {
        if (Auth::guard("user")->check()) {
            if (Auth::guard("user")->user()->usertype == "guest") {
                return redirect(route("home"));
            }

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

        $active_sellers = $this->PublicMiddlewareController->getexpiredsellerslist();
        $user_id = $login_id = Auth::guard("user")->user()->id;
        $my_networks = Mynetworks::where("user_id", $login_id)
            ->pluck("mynetwork_id")
            ->first();
        $network_id = explode(",", $my_networks);
        $user = User::find($login_id);
        $network_list = User::select("name", "id", "profile_pic")
            ->whereIn("id", $network_id)
            ->whereIn("id", $active_sellers)
            ->get();

        $chat_data = [];
        if (!$network_list->isEmpty()) {
            foreach ($network_list as $key => $row) {
                $unreadCount = Message::where("from_user", $row->id)
                    ->where("to_user", $user_id)
                    ->where("message_status", "unread")
                    ->count();
                $latestMessage = Message::where(function ($query) use (
                    $user_id,
                    $row
                ) {
                    $query
                        ->where("from_user", $user_id)
                        ->where("to_user", $row->id);
                })
                    ->orWhere(function ($query) use ($user_id, $row) {
                        $query
                            ->where("from_user", $row->id)
                            ->where("to_user", $user_id);
                    })
                    ->orderBy("id", "desc")
                    ->take(5)
                    ->get();
                $chat_data[$key] = [
                    "contact" => $row,
                    "latestMessage" => $latestMessage,
                    "unreadcount" => $unreadCount,
                ];
            }
        }

        //   $usertype = Auth::guard('user')->user()->usertype;
        //   $values = [];
        //   if($usertype=="seller")
        //   {

        //           $sellerProducts = $user->SellerProduct;
        //           foreach ($sellerProducts as $sproduct) {
        //               foreach(explode(',', $sproduct->category_id) as $value) {
        //                 $values[] = trim($value);
        //               }
        //           }
        //           $values = array_unique($values);
        //   }

        //$categorylists=Category::whereIn('id',$values)->pluck('name')->all();
        $allcategorylists = Category::select("name", "id")
            ->where("parent_id", null)
            ->orderBy("name", "asc")
            ->get();
        $CompanyType = CompanyType::orderBy("company_type", "asc")->get();
        return view(
            "frontEnd.pages.my_networks",
            compact("chat_data", "user", "allcategorylists", "CompanyType")
        );
    }

    public function revokeFrom_network(Request $request)
    {
        $login_id = Auth::guard("user")->user()->id;
        $revok_userid = $request->get("user_id");
        $networks = Mynetworks::where("user_id", $login_id)
            ->pluck("mynetwork_id")
            ->first();
        $arrayData = explode(",", $networks);
        $network_users = "";
        foreach ($arrayData as $value) {
            if ($value == $revok_userid || $value == "") {
                continue;
            }
            $network_users .= trim($value) . ",";
        }
        DB::table("mynetworks")
            ->where("user_id", $login_id)
            ->update(["mynetwork_id" => $network_users]);
        $msg = "Removed from Networks";

        echo json_encode($msg);
    }

    public function BuyerInstructions()
    {
        $data = Contentpage::where("page", "Buyer Instructions")->first();
        return view("frontEnd.pages.BuyerInstructions", compact("data"));
    }
    public function SellerInstructions()
    {
        $data = Contentpage::where("page", "Seller Instructions")->first();
        return view("frontEnd.pages.SellerInstructions", compact("data"));
    }
    public function ContactUs()
    {
        return view("frontEnd.pages.ContactUs");
    }

    public function TwitterSearch()
    {
        return view("frontEnd.pages.TwitterSearch");
    }

    public function ContactSubmit(Request $request)
    {
        request()->validate([
            "name" => ["required", "string", "max:255"],
            "email" => ["required"],
            "phone" => ["required"],
            "message" => ["required"],
        ]);

        $name = $request->input("name");
        $email = $request->input("email");
        $phone = $request->input("phone");
        $msg = $request->input("message");

        Mail::send(
            "emails.ContactPageMail",
            [
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
                "msg" => $msg,
            ],
            function ($message) use ($request) {
                $company_email = Generalsetting::where(
                    "item",
                    "company_email"
                )->first()->value;

                if (!empty($company_email)) {
                    $message->to($company_email);
                } else {
                    $message->to("info@fmcg.com");
                }
                $message->subject("New support request - FMCG");
            }
        );

        return back()->with(
            "message",
            "Your Support Request Has Been Sent. Our Team Will be in Touch With You Soon. "
        );
    }

    public function headsearch(Request $request)
    {
        request()->validate([
            "search" => ["required"],
        ]);
        $query = $request->get("search");
        return \Redirect::route("Product.Listing", ["search_key" => $query]);
    }

    public function TypeaheadSearch(Request $request)
    {
        $active_sellers = $this->PublicMiddlewareController->getexpiredsellerslist();
        $validity = $this->PublicMiddlewareController->checkUserContactValidity();
        $query = $request->get("term");
        $productResult = SellerProduct::leftJoin(
            "users",
            "users.id",
            "=",
            "seller_products.user_id"
        )
            ->where("users.status", "Active")
            ->where("seller_products.status", "active")
            ->whereIn("seller_products.user_id", $active_sellers)
            ->where(
                DB::raw("lower(seller_products.name)"),
                "LIKE",
                "%" . strtolower($query) . "%"
            )
            ->select(
                DB::raw("seller_products.id AS new_id"),
                "seller_products.*"
            )
            ->with("SellerProductImage")
            ->take(5)
            ->get();

        $categoryResult = Category::where(
            DB::raw("lower(slug)"),
            "LIKE",
            "%" . strtolower($query) . "%"
        )
            ->select(DB::raw("id AS new_id"), "name", "category_pic", "slug")
            ->take(5)
            ->get();
        $new_array = [];
        foreach ($productResult as $data) {
            $product_image = $data->SellerProductImage;

            $img_url = asset("/uploads/defaultImages/no_image.jpg");
            $product_images = SellerProductImage::where(
                "product_id",
                "=",
                $data->new_id
            )->get();
            $cnt = count($product_images);
            if ($cnt > 0) {
                if (!empty($product_images)) {
                    foreach ($product_images as $productimage) {
                        if ($productimage->thumbnail == "yes") {
                            $img_url =
                                asset("/uploads/productImages/") .
                                "/" .
                                $productimage->image_path;
                        }
                    }
                }
            }

            if ($data->price_on_request != "Price on request") {
                $curreny_symbol = '$';
                if (!empty($data->Currency->symbol)) {
                    $curreny_symbol = $data->Currency->symbol;
                }

                $price = $curreny_symbol . $data->product_price;
                if ($data->price_negotiable == "Negotiable") {
                    $price .= "(Price Negotiable)";
                }
            } else {
                $price = "Price on Request ";
            }

            if (Auth::guard("user")->check() && $validity == true) {
                $user_country_id = $data->User->country_id;
                $countries = Country::where("id", $user_country_id)
                    ->pluck("name")
                    ->all();
                $Countries_names = implode(",", $countries);

                if ($Countries_names != "") {
                    $new_row["title"] =
                        $data->name .
                        " (" .
                        $price .
                        ')<br><i class="fa fa-map-marker" aria-hidden="true"></i> ' .
                        $Countries_names;
                } else {
                    $new_row["title"] = $data->name . " (" . $price . ")";
                }
            } else {
                $new_row["title"] = $data->name;
            }
            $new_row["image"] = $img_url;
            $new_row["search_key"] = $query;
            $new_row["url"] = route("view.Sproduct", [
                "productId" => $data->new_id,
                "search_key" => $query,
            ]);
            $row_set[] = $new_row;

            // $new_array[]=array('id'=>$data->new_id,'name'=>$data->name." (".$data->product_price.")",'image_path'=>$img_url);
        }

        foreach ($categoryResult as $data) {
            if ($data->category_pic == "") {
                $img_url = asset("/uploads/defaultImages/no_image.jpg");
            } else {
                $img_url = asset(
                    "/uploads/categoryImages/" . $data->category_pic
                );
            }

            $new_array[] = [
                "id" => $data->new_id,
                "name" => $data->name,
                "image_path" => $img_url,
            ];

            $new_row["title"] = $data->name;
            $new_row["image"] = $img_url;
            $new_row["url"] = route("Product.Listing", $data->slug);
            $row_set[] = $new_row;
        }
        return response()->json($row_set);
    }

    public function getsellerslist_search(Request $request)
    {
        $start_from = $request->input("start_from");
        $per_page = $request->input("per_page");
        $seller_name_search = strtoupper($request->input("seller_name"));
        $category_id = $request->input("category_id");
        $company_type = $request->input("company_type");
        $user_id = Auth::guard("user")->user()->id;

        $my_networks = Mynetworks::where("user_id", $user_id)
            ->pluck("mynetwork_id")
            ->first();
        $network_id = explode(",", $my_networks);

        $user_list = $this->PublicMiddlewareController->getexpireduserslist();
        $active_sellers = [];
        foreach ($user_list as $key => $value) {
            array_push($active_sellers, $value->id);
        }

        $user_data = User::leftJoin("buyer_companies", function ($join) {
            $join->on("buyer_companies.user_id", "=", "users.id");
            $join->orOn("buyer_companies.user_id", "=", "users.parent_id");
        })
            ->leftJoin("seller_products", function ($join) {
                $join->on("seller_products.user_id", "=", "users.id");
                $join->orOn("seller_products.user_id", "=", "users.parent_id");
            })
            ->where("users.status", "Active")
            ->where("users.id", "<>", $user_id)
            ->whereIn("users.id", $active_sellers)
            ->whereNotIn("users.id", $network_id)
            ->select(
                "users.name as user_name",
                "users.profile_pic",
                "users.varification_status",
                "buyer_companies.company_image as company_image",
                "users.id as main_id"
            );

        if ($seller_name_search != "") {
            $user_data = $user_data->where(
                DB::raw(
                    'UPPER(CONCAT(users.name,COALESCE(buyer_companies.company_name,"")))'
                ),
                "LIKE",
                "%" . $seller_name_search . "%"
            );
        }

        if ($company_type != 0) {
            $user_data = $user_data->where(
                "buyer_companies.company_type",
                $company_type
            );
        }
        $category_ids = [];
        if ($category_id != "0") {
            $categorylist = Category::where("parent_id", $category_id)
                ->pluck("id")
                ->all(); // all subcategories
            array_push($category_ids, $category_id); //prent category to array
            foreach ($categorylist as $value) {
                if (!in_array($value, $category_ids)) {
                    //subctegory id not in $category_id array
                    array_push($category_ids, $value);
                } //all category ids as array
                for ($i = 0; $i < count($category_ids); $i++) {
                    $category1 = Category::where(
                        "parent_id",
                        $category_ids[$i]
                    )->get();
                    foreach ($category1 as $value2) {
                        if (!in_array($value2->id, $category_ids)) {
                            array_push($category_ids, $value2->id);
                        }
                    }
                }
            }
            $user_data = $user_data->WhereIn("category_id", $category_ids);
        }

        $count = $user_data
            ->groupby("main_id")
            ->get()
            ->count();
        $user_data = $user_data
            ->groupby("main_id")
            ->orderby("user_name", "ASC")
            ->skip($start_from)
            ->take($per_page)
            ->get();

        $list_array = [];

        foreach ($user_data as $data) {
            $class_verified = "";
            if ($data->varification_status == "varified") {
                $class_verified = "active-border";
            }

            $user = User::find($data->user_id);

            $company_image = $data->company_image;
            if ($company_image != "") {
                $img_path =
                    asset("uploads/BuyerCompany/") . "/" . $company_image;
            } elseif (!empty($data->profile_pic)) {
                $img_path =
                    asset("/uploads/userImages/") . "/" . $data->profile_pic;
            } else {
                $img_path = asset("uploads/defaultImages/default_avatar.png");
            }

            $network_exist = false;

            $list_array[] = [
                "id" => $data->main_id,
                "name" => $data->user_name,
                "class_verified" => $class_verified,
                "varification_status" => $data->varification_status,
                "company_street" => $user->BuyerCompany->company_street ?? "",
                "company_name" => $user->BuyerCompany->company_name ?? "",
                "company_location" =>
                    $user->BuyerCompany->company_location ?? "",
                "img_path" => $img_path,
                "network_exist" => $network_exist,
            ];
        }
        $return_array = ["count" => $count, "sellers" => $list_array];
        return json_encode($return_array);
    }

    public function getnetwork_users_list(Request $request)
    {
        $user_list = $this->PublicMiddlewareController->getexpireduserslist();
        $active_sellers = [];
        foreach ($user_list as $key => $value) {
            array_push($active_sellers, $value->id);
        }
        $start_from = $request->input("start_from");
        $per_page = $request->input("per_page");
        $seller_name_search = strtoupper($request->input("seller_name"));
        $company_type = $request->input("company_type");
        $category_id = $request->input("category_id");

        $login_id = Auth::guard("user")->user()->id;

        $my_networks = Mynetworks::where("user_id", $login_id)
            ->pluck("mynetwork_id")
            ->first();
        $network_id = explode(",", $my_networks);

        $sellers_list = SellerProduct::leftJoin("users", function ($join) {
            $join->on("seller_products.user_id", "=", "users.id");
            $join->orOn("seller_products.user_id", "=", "users.parent_id");
        })
            ->whereIn("users.id", $network_id)
            ->whereIn("users.id", $active_sellers);
        $category_ids = [];

        if ($category_id != "0") {
            $categorylist = Category::where("parent_id", $category_id)
                ->pluck("id")
                ->all(); // all subcategories
            array_push($category_ids, $category_id); //prent category to array
            foreach ($categorylist as $value) {
                if (!in_array($value, $category_ids)) {
                    //subctegory id not in $category_id array
                    array_push($category_ids, $value);
                } //all category ids as array
                for ($i = 0; $i < count($category_ids); $i++) {
                    $category1 = Category::where(
                        "parent_id",
                        $category_ids[$i]
                    )->get();
                    foreach ($category1 as $value2) {
                        if (!in_array($value2->id, $category_ids)) {
                            array_push($category_ids, $value2->id);
                        }
                    }
                }
            }
            $sellers_list = $sellers_list->WhereIn(
                "category_id",
                $category_ids
            );
        }

        $sellers_list = $sellers_list
            ->groupby("users.id")
            ->pluck("users.id")
            ->all();

        $network_list = User::leftJoin("buyer_companies", function ($join) {
            $join->on("buyer_companies.user_id", "=", "users.id");
            $join->orOn("buyer_companies.user_id", "=", "users.parent_id");
        })
            ->select(
                "users.name",
                "users.id",
                "users.profile_pic",
                "users.varification_status"
            )
            ->whereIn("users.id", $network_id)
            ->whereIn("users.id", $active_sellers)

            ->when($category_id != 0, function ($query) use ($sellers_list) {
                $query->whereIn("users.id", $sellers_list);
            });

        if ($seller_name_search != "") {
            $network_list = $network_list->where(
                DB::raw(
                    'UPPER(CONCAT(users.name,COALESCE(buyer_companies.company_name,"")))'
                ),
                "LIKE",
                "%" . $seller_name_search . "%"
            );
        }

        if ($company_type != 0) {
            $network_list = $network_list->where(
                "buyer_companies.company_type",
                $company_type
            );
        }

        $count = $network_list->get()->count();
        $network_list = $network_list
            ->orderby("users.name", "ASC")
            ->skip($start_from)
            ->take($per_page)
            ->get();

        $mynetwork_list = [];
        foreach ($network_list as $data) {
            $class_verified = "";
            if ($data->varification_status == "varified") {
                $class_verified = "active-border";
            }

            $company_image = $data->BuyerCompany->company_image;
            if ($company_image != "") {
                $img_path =
                    asset("uploads/BuyerCompany/") . "/" . $company_image;
            } elseif (!empty($data->profile_pic)) {
                $img_path =
                    asset("/uploads/userImages/") . "/" . $data->profile_pic;
            } else {
                $img_path = asset("uploads/defaultImages/default_avatar.png");
            }

            $mynetwork_list[] = [
                "id" => $data->id,
                "name" => $data->name,
                "class_verified" => $class_verified,
                "varification_status" => $data->varification_status,
                "company_street" => $data->BuyerCompany->company_street ?? "",
                "company_name" => $data->BuyerCompany->company_name ?? "",
                "company_location" =>
                    $data->BuyerCompany->company_location ?? "",
                "img_path" => $img_path,
            ];
        }

        $return_array = [
            "count" => $count,
            "mynetwork_list" => $mynetwork_list,
        ];
        return json_encode($return_array);
    }
}
