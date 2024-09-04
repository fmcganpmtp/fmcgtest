<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
 use App\User;
use App\Models\Message;
use App\Models\Mynetworks;
use App\Models\Chat_contact_delete;
use App\Models\Wishlist;
use App\Models\Chatroom;
use App\Models\ChatNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 
use DB;
use App\Http\Controllers\FrontEnd\PublicMiddlewareController;
use GetStream\StreamChat\Client as StreamClient;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{

    protected $PublicMiddlewareController;
    public function __construct(PublicMiddlewareController $PublicMiddlewareController)
    {
        $this->PublicMiddlewareController = $PublicMiddlewareController;
    }
    
    public function getMyContacts(Request $request){
        
        if (!Auth::guard("user")->check()) 
            return response()->json([]);
        $active_sellers=$this->PublicMiddlewareController->getexpireduserslist(); 
        $user_id =  Auth::guard('user')->user()->id;
        //$contacts = Mynetworks::select('users.id','users.name','users.profile_pic','mynetworks.mynetwork_id')->join('users', 'users.id', 'mynetworks.mynetwork_id')->where('mynetworks.user_id',$user_id)->get();
        $deleted_id=Chat_contact_delete::where('seller_id',$user_id)->pluck('deleted_id')->all();
        
        $a = Message::select('messages.to_user as mynetwork_id')->where('from_user', $user_id)
        ->whereNotIn('to_user', $deleted_id)
        ->whereIn('to_user',$active_sellers)
        ->groupBy('to_user')->pluck('mynetwork_id')->toArray();

        $b = Message::select('messages.from_user as mynetwork_id')->where('to_user', $user_id)
        ->whereNotIn('from_user', $deleted_id)
        ->whereIn('from_user',$active_sellers)
        ->groupBy('from_user')->pluck('mynetwork_id')->toArray();
        if(is_array($a)&&is_array($b))
        $unioncontacts = array_merge($a,$b);
        else if(is_array($a))
        $unioncontacts = $a;
        else if(is_array($b))
        $unioncontacts =  $b;
        else
        $unioncontacts =[];
        $unioncontacts = array_unique($unioncontacts);
		$return_array=array();
		
		        
		
		
		
		
		$chat_data = array();
		$contacts = User::select('users.id','users.name','users.user_status','users.profile_pic','buyer_companies.company_image','buyer_companies.company_name','users.seller_type','users.parent_id')
		->leftJoin('buyer_companies', 'users.id', '=', 'buyer_companies.user_id')->whereIn('users.id',$unioncontacts)
        ->when($request->get('chat_cnt_search_name')!='', function ($query) use ($request) {
                $query->where(DB::raw('UPPER(CONCAT(users.name,COALESCE(buyer_companies.company_name,"")))'), 'LIKE','%'.strtoupper($request->get('chat_cnt_search_name')).'%');
            })
        ->get();
        
        
        
        
        
		if (!$contacts->isEmpty()) {
			foreach($contacts as $key=> $row){ 

                    if($row->seller_type=="Co-Seller")
                         $u_id=$row->parent_id;
                    else
                         $u_id=$row->id;
                    
                    $user_company = User::find($u_id);

                    if(!empty($user_company->BuyerCompany->company_image))
                    {  
                        $image=$user_company->BuyerCompany->company_image;
                        if($image!='')          
                            $contacts[$key]['company_image']  = $user_company->BuyerCompany->company_image;
                    }
                    

				$unreadCount = Message::where('from_user', $row->id)->where('to_user',$user_id)->where('message_status', 'unread')->count();
				$latestMessage = Message::where(function ($query) use ($user_id, $row) {
								$query->where('from_user', $user_id)
                                ->where('to_user',$row->id);
                        })
                        ->orWhere(function ($query) use ($user_id, $row) {
                            $query->where('from_user', $row->id)
                                ->where('to_user', $user_id);
                        })->latest()
                        ->first();
                if(!empty($latestMessage))
                    $msgid=$latestMessage->id;
                else
                    $msgid="";  

                    
                    

                
                          
				$chat_data[$key] = array('contact'=>$row,'latestMessage'=>$latestMessage,'unreadcount'=>$unreadCount,'msgid'=>$msgid);
				
			}
		}
         $sorted_data = collect($chat_data)->sortBy('msgid')->reverse()->toArray();
         $newsortedarray=[];
         foreach ($sorted_data as $key => $value) 
             $newsortedarray[]=$value;         
		 //$return_array = array('ajax_status' => true, 'chat_data' => $newsortedarray);
        return response()->json($newsortedarray);
    }
     public function getMyMessages($id = null){
         
       if (!Auth::guard("user")->check()) 
            return response()->json([]);
       $user_id =  Auth::guard('user')->user()->id;
         Message::where('from_user', $id)->where('to_user', $user_id)->update([ 'message_status' => 'read', ]);
    	$chat_data = Message::select('id','from_user','to_user','message_type','message','file','message_status',DB::raw('DATE(created_at) as Date'),
       DB::raw('DATE_FORMAT(TIME(created_at) ,"%H:%i")as Time'))->where(function ($query) use ($user_id, $id) {
							$query->where('from_user', $user_id)
                            ->where('to_user', $id);
                    })
                    ->orWhere(function ($query) use ($user_id, $id) {
                        $query->where('from_user', $id)
                            ->where('to_user', $user_id);
                    })->orderBy('id', 'DESC')->paginate(50);;
        $userdetails = User::select('name','profile_pic','seller_type','id','parent_id',DB::raw("null as company_image"))->where('id', $id)->first();

        if($userdetails->seller_type=="Co-Seller")
                $u_id=$userdetails->parent_id;
         else
                $u_id=$userdetails->id;
                    
        $user_company = User::find($u_id);

        if(!empty($user_company->BuyerCompany->company_image))
        {  
           $image=$user_company->BuyerCompany->company_image;
           if($image!='')          
                $userdetails->company_image  = $user_company->BuyerCompany->company_image;
        }

		$return_array = array('ajax_status' => true, 'chat_data' => $chat_data,'userdetails'=>$userdetails);
        return response()->json($return_array);
    }
    public function sentMessages(Request $request){
        if (!Auth::guard("user")->check()) 
            return response()->json([]);
        $user_id =  Auth::guard('user')->user()->id;
        $user=User::find($user_id);
        $company_name ="";
        if(!empty($user->BuyerCompany->company_name))
        $company_name = $user->BuyerCompany->company_name;
        Chat_contact_delete::where('seller_id',$user_id)
                                ->where('deleted_id',$request->selected_id)->delete();
        $file = $request->file('file');
        $insert_id=  0;
        if($file){
            $file = $request->file('file');
            $fileName = time().'.'.$request->file->extension();
            $request->file->move(public_path('/assets/uploads/chat/'), $fileName);
            $insert_id= Message::create([
            'from_user' => $user_id,
            'to_user' => $request->selected_id,
            'message_type' => $request->message_type,
            'company_name' => $company_name,
            'message' => $request->message,
            'file'=>$fileName,
            'message_status' => 'unread', 
            ])->id;
        }else{
            $insert_id= Message::create([
            'from_user' => $user_id,
            'to_user' => $request->selected_id,
            'message_type' => $request->message_type,
            'message' => $request->message,
            'company_name' => $company_name,
            'message_status' => 'unread', 
        ])->id;
        } 
        $chat_data = Message::find( $insert_id);
		$return_array = array('ajax_status' => true,'chat_data'=>$chat_data);
        return response()->json($return_array);
    }
    public function checkNewMessage($senter_id =null,$last_message =null){
        
        if (!Auth::guard("user")->check()) 
            return response()->json([]);
         
        $user_id =  Auth::guard('user')->user()->id;
    	$chat_data = Message::where(function ($query) use ($user_id, $senter_id,$last_message) {
							$query->where('from_user', $user_id)
                            ->where('to_user', $senter_id)->where('id','>',$last_message);
                    })
                    ->orWhere(function ($query) use ($user_id, $senter_id,$last_message) {
                        $query->where('from_user', $senter_id)
                            ->where('to_user', $user_id)->where('id','>',$last_message);
                    })->orderBy('id', 'ASC')->get();

        $userdetails = User::select('id','name','profile_pic','seller_type','parent_id',DB::raw("null as company_image"))->where('id', $senter_id)->first();

         if($userdetails->seller_type=="Co-Seller")
                $u_id=$userdetails->parent_id;
         else
                $u_id=$userdetails->id;
                    
        $user_company = User::find($u_id);

        if(!empty($user_company->BuyerCompany->company_image))
        {
            $image=$user_company->BuyerCompany->company_image;
            if($image!='')          
                $userdetails->company_image  = $user_company->BuyerCompany->company_image;
        }


		$return_array = array('ajax_status' => true, 'chat_data' => $chat_data,'userdetails'=>$userdetails);
        return response()->json($return_array);
    } 
    public function checkNotifications(Request $request){
        
        if (!Auth::guard("user")->check()) 
            return response()->json([]);
        $user_id =  Auth::guard('user')->user()->id;
        $wishlist_count = Wishlist::where('user_id','=',$user_id)->where('wishlist','=','Yes')->count();
        
        
        $active_sellers=$this->PublicMiddlewareController->getexpireduserslist(); 
        $deleted_id=Chat_contact_delete::where('seller_id',$user_id)->pluck('deleted_id')->all();      
               
        $chat_count = Message::where('to_user',$user_id)->where('message_status', 'unread')
                            ->whereNotIn('from_user', $deleted_id)
                            ->whereIn('from_user',$active_sellers)->count();
        
        $return_array = array('ajax_status' => true,'wishlist_count'=>$wishlist_count,'chat_count'=>$chat_count);
        return response()->json($return_array);
    } 
    
    public function hide_chat_contact(Request $request){
        
        if (!Auth::guard("user")->check()) 
            return response()->json([]);

        $login_id =  Auth::guard('user')->user()->id;
        $deleted_id=$request->input('deleted_id');
        $val=Chat_contact_delete::create(['seller_id'=>$login_id,'deleted_id'=>$deleted_id]);
        return json_encode($val);
       
    } 
    public function messagesPage(Request $request){
        if (!Auth::guard("user")->check()) 
        return redirect()->route('user-login');
        $default_chatroom = '';
        $chat_room_exist = 0;
        $sender_details = [];
        $client = new StreamClient(
            getenv("STREAM_API_KEY"),
            getenv("STREAM_API_SECRET"),
            null,
            null,
            9 // timeout
        );
        $myCompany = User::find(Auth::guard('user')->user()->id); 
        if($request->sender_id){
            $sender_details = User::find($request->sender_id);  
            $chatroom = [];
            $sender_company_id = '';
            $reciever_company_id = '';
            if($myCompany->parent_id!='')
                $sender_company_id = User::find($myCompany->parent_id)->BuyerCompany->id;
            else
                $sender_company_id = $myCompany->BuyerCompany->id;
            if($sender_details->parent_id!='')
                $reciever_company_id = User::find($sender_details->parent_id)->BuyerCompany->id;
            else
                $reciever_company_id = $sender_details->BuyerCompany->id;
            $chatroom = array($reciever_company_id,$sender_company_id);
            sort($chatroom);  
            $chatroom_exist = Chatroom::where('sender_company_id',$chatroom[0])->where('buyer_company_id', $chatroom[1])->first();
           
            if(!empty($chatroom_exist)){
                $default_chatroom = $chatroom_exist->chatroom;
                $chat_room_exist = 1;
            }else{
                Chatroom::create([
                    'chatroom' =>$chatroom[0].'_'.$chatroom[1],
                    'sender_company_id' =>$chatroom[0],
                    'buyer_company_id' =>$chatroom[1],
                    'created_by' =>Auth::guard('user')->user()->id
                ]);
                $default_chatroom = $chatroom[0].'_'.$chatroom[1];
                if(($sender_details->BuyerCompany->company_image!=""))
                    $cmp_img = asset('uploads/BuyerCompany/').'/'.$sender_details->BuyerCompany->company_image;
                else 
                    $cmp_img = asset('uploads/defaultImages/seller.jpg'); 
                $user = [
                    'id' => preg_replace('/[@\.]/', '_', $sender_details->email),
                    'name' => $sender_details->BuyerCompany->company_name.'|'.$sender_details->name.' '.$sender_details->surname.'|'.$sender_details->position.'|'.$request->sender_id,
                    'role' => 'admin',
                    'image' =>$cmp_img,
                ];        
                $client->updateUser($user);
            }
        }
        $username = preg_replace('/[@\.]/', '_', Auth::guard('user')->user()->email);
       
		$token = $client->createToken($username);
        //$user = $myCompany;
        return view( "frontEnd.pages.messages",compact('sender_details','token','myCompany','default_chatroom','chat_room_exist'));
    }
    public function ajaxmessages(Request $request){
        
        $default_chatroom = '';
        $chat_room_exist = 0;
        $sender_details = [];
        $client = new StreamClient(
            getenv("STREAM_API_KEY"),
            getenv("STREAM_API_SECRET"),
            null,
            null,
            9 // timeout
        );
        $myCompany = User::find(Auth::guard('user')->user()->id); 
        if($request->sender_id){
             $sender_details = User::find($request->sender_id);  
            $chatroom = [];
            $sender_company_id = '';
            $reciever_company_id = '';
            if($myCompany->parent_id!='')
                $sender_company_id = User::find($myCompany->parent_id)->BuyerCompany->id;
            else
                $sender_company_id = $myCompany->BuyerCompany->id;
            if($sender_details->parent_id!='')
                $reciever_company_id = User::find($sender_details->parent_id)->BuyerCompany->id;
            else
                $reciever_company_id = $sender_details->BuyerCompany->id;
            $chatroom = array($reciever_company_id,$sender_company_id);
            sort($chatroom);   
            $chatroom_exist = Chatroom::where('sender_company_id',$chatroom[0])->where('buyer_company_id', $chatroom[1])->first();
            $chat_room_exist =0;
            if(!empty($chatroom_exist)){
                $default_chatroom = $chatroom_exist->chatroom;
                $chat_room_exist = 1;
                if(($sender_details->BuyerCompany->company_image!=""))
                    $cmp_img = asset('uploads/BuyerCompany/').'/'.$sender_details->BuyerCompany->company_image;
                else 
                    $cmp_img = asset('uploads/defaultImages/seller.jpg'); 
                $user = [
                    'id' => preg_replace('/[@\.]/', '_', $sender_details->email),
                    'name' => $sender_details->BuyerCompany->company_name.'|'.$sender_details->name.' '.$sender_details->surname.'|'.$sender_details->position.'|'.$request->sender_id,
                    'role' => 'admin',
                    'image' =>$cmp_img, 
                ];        
                $client->updateUser($user);
            }else{
                // Chatroom::create([
                //     'chatroom' =>$chatroom[0].'_'.$chatroom[1],
                //     'sender_company_id' =>$chatroom[0],
                //     'buyer_company_id' =>$chatroom[1],
                //     'created_by' =>Auth::guard('user')->user()->id
                // ]);
                $default_chatroom = $chatroom[0].'_'.$chatroom[1];
                if(($sender_details->BuyerCompany->company_image!=""))
                    $cmp_img = asset('uploads/BuyerCompany/').'/'.$sender_details->BuyerCompany->company_image;
                else 
                    $cmp_img = asset('uploads/defaultImages/seller.jpg'); 
                $user = [
                    'id' => preg_replace('/[@\.]/', '_', $sender_details->email),
                    'name' => $sender_details->BuyerCompany->company_name.'|'.$sender_details->name.' '.$sender_details->surname.'|'.$sender_details->position.'|'.$request->sender_id,
                    'role' => 'admin',
                    'image' =>$cmp_img 
                ];        
                $client->updateUser($user);
            }
        }
        $username = preg_replace('/[@\.]/', '_', Auth::guard('user')->user()->email);
       
		$token = $client->createToken($username);
        $member1 =  preg_replace('/[@\.]/', '_', Auth::guard('user')->user()->email);
        $member2 =  preg_replace('/[@\.]/', '_', $sender_details->email);
        $return_array = array('ajax_status' => true,'sender_details'=>$sender_details,'token'=>$token,'member2'=>$member2,'default_chatroom'=>$default_chatroom,'member1'=>$username,'cmp_img'=>$cmp_img,'chat_room_exist'=>$chat_room_exist);
        return response()->json($return_array);
    }
    public function sentNotification(Request $request){
       $sender_id = Auth::guard('user')->user()->id;
       $sender_name = Auth::guard('user')->user()->name;
       $reciever_id = $request->reciever_id;

       if($reciever_id!=''){
        $reciever_profile = User::find($reciever_id);
        if(!empty($reciever_profile)&&$reciever_profile->parent_id==0){
            $all_child_users = User::where('parent_id',$reciever_id)->where('chat_notification',1)->where('status','Active')->get();

        }elseif(!empty($reciever_profile)&&$reciever_profile->parent_id!=0){
            $all_child_users = User::where('parent_id',$reciever_profile->parent_id)->where('chat_notification',1)->where('status','Active')->get();
        }
        $currentDateTime = Carbon::now();
        // Get the time 1 hour before the current time
        $oneHourBefore = $currentDateTime->subHour();
        $prev_notification = ChatNotification::where('last_notification', '>=', $oneHourBefore)->where('user1',$sender_id)->where('user2',$reciever_id)->count(); 
        if($prev_notification<=0){
            Mail::send('emails.ChatNotification', ['messaged_user' => $sender_name, 'user' => $reciever_profile->name], function($message) use($reciever_profile){
                    $message->to($reciever_profile->email);
                    $message->subject('Chat Notification - FMCG');
            });
            $chat_notification = [];
            $chat_notification = array(
                'user1' => $sender_id,
                'user2' => $reciever_id, 
            );
            ChatNotification::create($chat_notification);
        } 
        if( $all_child_users->isNotEmpty()){
            foreach($all_child_users as $users){
                $prev_notification = ChatNotification::where('last_notification', '>=', $oneHourBefore)->where('user1',$sender_id)->where('user2',$users->id)->count();
                if($prev_notification<=0){
                        Mail::send('emails.ChatNotification', ['messaged_user' => $sender_name, 'user' => $users->name], function($message) use($users){
                            $message->to($users->email);
                            $message->subject('Chat Notification - FMCG');
                    });
                    $chat_notification = [];
                    $chat_notification = array(
                        'user1' => $sender_id,
                        'user2' => $users->id, 
                    );
                    ChatNotification::create($chat_notification);
                }
            }
        }
        $return_array = array('ajax_status' => true, 'message' => 'Reciever account not found');
       }else{
            $return_array = array('ajax_status' => false, 'message' => 'Reciever account not found');
       }
       
        return response()->json($return_array);
    }
    public function createChatroom(Request $request){
        $default_chatroom = $request->default_chatroom;
        $chat_room_exist = 0;
        $sender_details = [];      
        $client = new StreamClient(
            getenv("STREAM_API_KEY"),
            getenv("STREAM_API_SECRET"),
            null,
            null,
            9 // timeout
        );   
        $myCompany = User::find(Auth::guard('user')->user()->id); 
        if($request->profile_id){
             $sender_details = User::find($request->profile_id);  
            $chatroom = [];
            $sender_company_id = '';
            $reciever_company_id = '';
            if($myCompany->parent_id!='')
                $sender_company_id = User::find($myCompany->parent_id)->BuyerCompany->id;
            else
                $sender_company_id = $myCompany->BuyerCompany->id;
            if($sender_details->parent_id!='')
                $reciever_company_id = User::find($sender_details->parent_id)->BuyerCompany->id;
            else
                $reciever_company_id = $sender_details->BuyerCompany->id;
            $chatroom = array($reciever_company_id,$sender_company_id);
            sort($chatroom);   
            $chatroom_exist = Chatroom::where('sender_company_id',$chatroom[0])->where('buyer_company_id', $chatroom[1])->first();
            $chat_room_exist =0;
            if(!empty($chatroom_exist)){
                $default_chatroom = $chatroom_exist->chatroom;
                $chat_room_exist = 1;
                if(($sender_details->BuyerCompany->company_image!=""))
                    $cmp_img = asset('uploads/BuyerCompany/').'/'.$sender_details->BuyerCompany->company_image;
                else 
                    $cmp_img = asset('uploads/defaultImages/seller.jpg'); 
                $user = [
                    'id' => preg_replace('/[@\.]/', '_', $sender_details->email),
                    'name' => $sender_details->BuyerCompany->company_name.'|'.$sender_details->name.' '.$sender_details->surname.'|'.$sender_details->position.'|'.$request->sender_id,
                    'role' => 'admin',
                    'image' =>$cmp_img, 
                ];        
                $client->updateUser($user);
            }else{
                if(($sender_details->BuyerCompany->company_image!=""))
                $cmp_img = asset('uploads/BuyerCompany/').'/'.$sender_details->BuyerCompany->company_image;
                else 
                $cmp_img = asset('uploads/defaultImages/seller.jpg'); 
                //$default_chatroom = $chatroom[0].'_'.$chatroom[1];
                Chatroom::create([
                    'chatroom' =>$default_chatroom,
                    'sender_company_id' =>$chatroom[0],
                    'buyer_company_id' =>$chatroom[1],
                    'created_by' =>Auth::guard('user')->user()->id
                ]);
                
            }
        }
        //$username = preg_replace('/[@\.]/', '_', Auth::guard('user')->user()->email);
        $member1 =  preg_replace('/[@\.]/', '_', Auth::guard('user')->user()->email);
        $member2 =  preg_replace('/[@\.]/', '_', $sender_details->email);
        $return_array = array('ajax_status' => true, 'member2'=>$member2,'default_chatroom'=>$default_chatroom,'member1'=>$member1,'cmp_img'=>$cmp_img);
        return response()->json($return_array);
    }
    public function deleteChatroom(Request $request){
        $default_chatroom = $request->default_chatroom;
        $chat_room_exist = 0;
        $sender_details = [];      
        Chatroom::where('chatroom',$request->default_chatroom)->delete();         
        $return_array = array('ajax_status' => true);
        return response()->json($return_array);
    }
}