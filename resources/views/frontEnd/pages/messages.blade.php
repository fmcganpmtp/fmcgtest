@extends('layouts.messagetemplate')
@section('title', 'Dashboard')
@section('content')


<div class="bg-light min-vh-100 mesaage-p">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="msg-bordr-bx">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Messages</button>
            </li>
            <!-- <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Forum</button>
            </li> -->
          </ul>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="msg-bordr-bx msg-border-bx2">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
              <div class="row no-spacing">
                <div class="col-lg-4 col-12 no-spacing">
                  <div class="tab-head">
                    <div class="tab-search">
                      <input type="text" placeholder="Search Messages" id="search_channel">
                    </div>
                  </div>
                  <div class="left-msg-listing" id="left_messages_list">
                     
                  
                  </div>
                </div>
                <div class="col-lg-8 col-12 no-spacing">
                  <div class="tab-head right-head">
                    <div class="row">
                      <div class="col-lg-6 col-12">
                        <div class="active-list" id="active_company_info">
                          <div class="list-ic"> </div>
                          <h4> </h4>
                        </div>
                      </div>
                      <div class="col-lg-6 col-12">
                        <div class="top-ic-bx"> 
                            <!-- <a href="#"><i class="fa fa-video-camera" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-star-o" aria-hidden="true"></i></a>  -->
                            <div class="dropdown"> 
                              <a href="javascript:void(0)" class="dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i> </a>  
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="javascript:void(0)" id="muteChatroom">Mute</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" id="blockChatroom" >Block</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" id="deleteChatroom">Delete</a></li>
                              </ul>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
				  
				  	<!--			  <div class="hr-border"></div>
-->
                  <div class="message-right-bx" id="message-right-bx" style="scroll-margin-bottom: 20px;bottom: 0px;">
                    <div class="messages-dtl-Outer">
                    </div>
                  </div>
				  
				  
				  
				 <!--end-lisin-->
				 
				 
				 
				 <!--textarea-->
				 
				 
				 
				 <div class="mesage-enter-area">
				 
				 <div class="msg-textarea-out">
				 <textarea name="" cols="" rows="" id="stream_chat_text" placeholder="Write a message"></textarea>
				 <div class="file-list" style="display:none;"></div>
				 </div>
				 
				 <div class="textarea-options">
				 <div class="row">
				 <div class="col-lg-6 col-12">
				 
				 <a href="javascript:void(0)" id="pic_upload"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
         <input type="file"   name="image_file" id="msg_attach_file" style="display:none"/>

				  <a href="javascript:void(0)" id="doc_upload"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
          <input type="file"   name="attach_file" id="msg_doc_attach_file" style="display:none"/>
				  <!-- <a href="#">GIF</a> -->
				   <a href="javascript:void(0)" id="show_emoji" ><i class="fa fa-smile-o" aria-hidden="true"></i></a>
				   
         
        <emoji-picker id="emoji-picker" style="display: none;"></emoji-picker>
				 	
				 </div>
				 
				
				 
				 <div class="col-lg-6 col-12"><button type="submit" class="message-send" id="send_message">Send</button></div>
				  </div>
				 
				 </div>
				 
				 </div> 
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
                </div>
                <!--9-->
              </div>
            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">...</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> 
<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="pop_image_body">
         
      </div>       
    </div>
  </div>
</div>
@endsection
@section('footer_script')
<style>
  .message-send{
    background:#f0f0f0!important;
  }
	.enable{
		background:#4472c4!important;
	}
</style>
<script src="https://cdn.jsdelivr.net/npm/stream-chat"></script> <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<script>
    var activeChatroom = '';
    var chatroom = 'fmcgChatRoom';  
    var token = '{{$token}}';
    var channel = '';
    var chatmembers = [];
    var chatmessages = []; 
    const apiKey = "{{env('STREAM_API_KEY')}}";
    const client = new StreamChat(apiKey);
    var default_chatroom = '{{$default_chatroom}}';
    var active_chat_room_unread = 0;    
    var upload_file_type= 'alt';
    var upload_file_name = '';
    var othermember_id = '';
    @php
      $company_image =  $myCompany->BuyerCompany->company_image ?$myCompany->BuyerCompany->company_image : ''; 
      $member1 =  preg_replace('/[@\.]/', '_', Auth::guard('user')->user()->email);
    if(($company_image!=""))
      $cmp_img = asset('uploads/BuyerCompany/').'/'.$myCompany->BuyerCompany->company_image;
    else 
      $cmp_img = asset('uploads/defaultImages/seller.jpg'); 
    if(!$chat_room_exist&&!empty($sender_details)){      
      $member2 = preg_replace('/[@\.]/', '_', $sender_details->email); @endphp
     // createChannel('{{$default_chatroom}}','{{$member1}}','{{$member2}}','{{$cmp_img}}');
    @php }  @endphp
    var member1 = '{{$member1}}' ;
    $fmcg(document).ready(async function() {      // Does not work with ASYNC
      await setUser(token, member1);
      @php if(!$chat_room_exist&&!empty($sender_details)){      
      $member2 = preg_replace('/[@\.]/', '_', $sender_details->email); @endphp
      await createChannel('{{$default_chatroom}}','{{$member1}}','{{$member2}}','{{$cmp_img}}');
      @php }  @endphp
      await checkChannels();
      await loadDefaultChannel();
    });
    //set up user
    setInterval(async () => {
      if($fmcg("#search_channel").val()=='')
      await checkChannels()
    }, 5000);
  $fmcg(function(){
	  $fmcg("#search_channel").keyup(function() { 
      var valThis = $fmcg(this).val().toLowerCase();
      if (valThis == "") {
        $fmcg("#left_messages_list > .msg-list-box").show();
      } else {
        $fmcg("#left_messages_list > .msg-list-box").each(function() {
          var text = $fmcg(this).find('.company_name').text().toLowerCase(); //console.log(text);
          text.indexOf(valThis) >= 0 ? $fmcg(this).show() : $fmcg(this).hide();
        });
      }
      
      // Start - Unnecessary "matching results" code
      var remainingResults = $fmcg('#left_messages_list > .msg-user-bx[style!="display: none;"]').length;
        
      // End - Unnecessary "matching results" code    
	});
});
$fmcg(document).on('keyup','#stream_chat_text',async function(){
  if($fmcg(this).val()!=''){
    $fmcg("#send_message").addClass('enable');
  }else{
    $fmcg("#send_message").removeClass('enable');
  }
});
    async function setUser(token, id){
      await client.setUser(
            {
                id,
                name: '{{$myCompany->BuyerCompany->company_name.'|'.$myCompany->name.' '.$myCompany->surname.'|'.$myCompany->position.'|'.$myCompany->id}}',
                image: '{{$cmp_img}}',
                role: 'admin',
            },
            token
        );
    }
    async function loadDefaultChannel(){
      $fmcg(".msg-list-box").each(function() {
       if($fmcg(this).attr('data_chat_id') == default_chatroom){
        $fmcg('.msg-list-box').removeClass('active'); 
        $fmcg(this).addClass('active');
        $fmcg(this).trigger('click');
       }
      });
    }
    //create channel    
    async function createChannel(chatroom,member1,member2,company_image){         
      channel = client.channel('messaging',chatroom, {
          name: chatroom,
          image: company_image,
          members: [member1, member2],
      });
      // Here, 'travel' will be the channel ID
      await channel.create();
    }
    //load chatrooms
    var totalUnreadCount = 0;
    async function checkChannels(){
      totalUnreadCount = 0;
      active_chat_room_unread=0;
      const filter = { type: 'messaging', members: { $in: [member1] } };
      const sort = { last_message_at: -1 };
      const channels = await client.queryChannels(filter, sort, {watch:true});      
      var html = '';
      console.log(channels);
      $fmcg.each(channels, function(i, item) {  
        if(default_chatroom == item.id){
          html+='<div class="msg-list-box active" data_chat_id="'+item.id+'">';
          var company_image = '';
          var company_name = '';
          $rowset = 0; 
          $fmcg.each(item.state.members, function(index, itemmembers) {  
            var  namearray = itemmembers.user.name.split("|"); 
            if(itemmembers.user_id != member1&&!$rowset){
              company_image = itemmembers.user.image;
              company_name  = namearray[0];
              $rowset = 1; 
            }              
          });           
          //displayMessage(company_image,company_name,item.state.messageSets[0].messages);
        }else
          html+='<div class="msg-list-box" data_chat_id="'+item.id+'">';
          html+='<div class="row">';
          html+='<div class="col-lg-3">';
          $rowset = 0; 
          $fmcg.each(item.state.members, function(index, itemmembers) {  
            if(itemmembers.user_id != member1&&!$rowset){
              var  namearray =  itemmembers.user.name.split("|");
                if(namearray[0] != '{{$current_user->BuyerCompany->company_name}}'){
              html+='<div class="msg-logo"><img src="'+itemmembers.user.image+'" /></div>';
              $rowset = 1; 
                }
            }
          });
          html+='</div>';
          html+='<div class="col-lg-9">';
          $rowset = 0; 
          $fmcg.each(item.state.members, function(index, itemmembers) {  
            var  namearray = itemmembers.user.name.split("|");
            if(itemmembers.user_id != member1&&!$rowset){
              if(namearray[0] != '{{$current_user->BuyerCompany->company_name}}'){
                html+='<h3 class="company_name">'+namearray[0]+'</h3>';
                $rowset = 1; 
              }

            }
          });
          
          html+='<div class="msg-left-txt">';
          
          if(typeof item.state.messageSets[0].messages != 'undefined' && typeof item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1]!= 'undefined'&& typeof item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1].user!= 'undefined'){
            var  namearray = item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1].user['name'].split("|");
          html+='<h6>'+namearray[1]+':</h6>';
          }             
         // html+='<p>'; 
          if(typeof item.state.messageSets[0].messages != 'undefined' && typeof item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1]!= 'undefined'&& typeof item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1].text!= 'undefined'){
            if(item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1].text.length>80)
            html+=item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1].text.slice(0,80)+'...';
            else
            html+=item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1].text;
          }
         // html+='</p>';
          html+='</div>';
          if(typeof item.state.messageSets[0].messages != 'undefined' && typeof item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1]!= 'undefined'&& typeof item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1].created_at!= 'undefined'){
            const dateStr =  item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1].created_at;
            const dateObj = new Date(dateStr);

            // Step 2: Define an array of month names
            const monthNames = [
              "Jan", "Feb", "Mar", "Apr", "May", "Jun",
              "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
            ];

            // Step 3: Extract the month and day from the Date object
            const month = monthNames[dateObj.getUTCMonth()]; // getUTCMonth() returns 0-based month index
            const day = dateObj.getUTCDate(); // getUTCDate() returns the day of the month

            // Step 4: Format the month and day into the desired format
            const formattedDate = `${month} ${day}`;
            html+='<div class="msg-dt">'+formattedDate+'</div>';
            if(item.state.unreadCount>0){
              html+='<div class="msg-unread"><span>'+item.state.unreadCount+'</span></div>';
              totalUnreadCount++;
              if(default_chatroom == item.id){
               active_chat_room_unread = 1;
              }
            }
            if(totalUnreadCount>0){
              $fmcg(".chat-count").html(totalUnreadCount);
              $fmcg(".chat-count").show();
            }else{
              $fmcg(".chat-count").html('');
              $fmcg(".chat-count").hide();
            }
           
          }
          html+='</div>';
          html+='</div>';
          html+='</div>';
          
      });
        
      $fmcg('#left_messages_list').html(html);
      if(default_chatroom ==''){  
            default_chatroom = $fmcg('.msg-list-box').first().attr('data_chat_id');
            $fmcg('.msg-list-box').first().addClass('active');
      }
      if(active_chat_room_unread>0){
        $fmcg('.msg-list-box.active').trigger('click');
      }
    } 
    function file(files,name,ext){
      let type = '';
      if(ext === 'pptx' || ext === 'ppt'){
        type = 'powerpoint';
      }else if(ext === 'png' || ext === 'jpg'){
        type = 'image';
      }else if(ext === 'xlsx'){
        type = 'excel';
      }else if(ext === 'pdf'){
        type = 'pdf';
      }else {
        type = 'alt';
      }

      let fileThumbnail = '';
      upload_file_type = type;
      if (files && files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
     
           //  $('.imagepreview').attr('src', e.target.result);
              fileThumbnail += '<div class="thumbnail">';
              fileThumbnail += '<img src="'+window.URL.createObjectURL(files[0])+'" style="width:50px" />';
              fileThumbnail += '  <p class="name">'+name+'</p>';
              fileThumbnail += '  <a href="#" class="attach_delete"><i class="fa fa-times"></i></a>';
              fileThumbnail += '</div>';
          
      }else{
        fileThumbnail += '<div class="thumbnail">';        
        fileThumbnail += '  <i class="fa fa-file-'+type+'-o"></i>';
        fileThumbnail += '  <p class="name">'+name+'</p>';
        fileThumbnail += '  <a href="#" class="attach_delete"><i class="fa fa-times"></i></a>';
        fileThumbnail += '</div>';
      }
      return fileThumbnail;
    }
    $fmcg(document).on('click','#deleteChatroom',async function(){      
      const destroy = await channel.delete();
      await checkChannels();
      $fmcg('.msg-list-box:first').trigger('click');
    });
    $fmcg(document).on('click','#muteChatroom',async function(){      
      const destroy = await channel.mute();
      await checkChannels();
      $fmcg('.msg-list-box:first').trigger('click');
    });
    $fmcg(document).on('click','#unmuteChatroom',async function(){      
      const destroy = await channel.unmute();
      await checkChannels();
      $fmcg('.msg-list-box:first').trigger('click');
    });
    $fmcg(document).on('click','#blockChatroom',async function(){  
      //await channel.update({disabled: true});
      await client.blockUser(othermember_id);
      await checkChannels();
      $fmcg('.msg-list-box:first').trigger('click');
    });
    $fmcg(document).on('click','#unblockChatroom',async function(){     
      //await channel.update({disabled: true});
      await client.unBlockUser(othermember_id);
      await checkChannels();
      $fmcg('.msg-list-box:first').trigger('click');
    });
    $fmcg(document).on('click','.popImge',function(){ 
      $fmcg('#pop_image_body').html($fmcg(this).html());
    });
    // Chat(token, member1);
    // async function Chat(token, id){
       
    //     await client.setUser(
    //         {
    //             id,
    //             name: '{{$myCompany->BuyerCompany->company_name}}',
    //             image: '{{$cmp_img}}',
    //             role: '{{($myCompany->position)!=""?$myCompany->position:"admin"}}',
    //         },
    //         token
    //     );
    //     //await initializeChannel();
    //     // @if(!$chat_room_exist&&!empty($sender_details))      
    //     // await createChannel('{{$default_chatroom}}','{{$member1}}','{{$member2}}','{{$cmp_img}}');
    //     // @endif 
    //     // await checkChannels();
    // }
    // async function checkChannels(){
    //   const filter = { type: 'messaging', members: { $in: [member1] } };
    //   const sort = { last_message_at: -1 };
    //   const channels = await client.queryChannels(filter, sort, {watch:true});
    //   console.log(channels);
    //   var html = '';
    //   $fmcg.each(channels, function(i, item) {  
    //     if(i==0){
    //       html+='<div class="msg-list-box active" data_chat_id="'+item.id+'">';
    //       var company_image = '';
    //       var company_name = '';
    //       $fmcg.each(item.state.members, function(index, itemmembers) {  
    //         if(itemmembers.user_id != member1){
    //           company_image = itemmembers.user.image;
    //           company_name  = itemmembers.user.name;
    //         }
              
    //       });
    //       displayMessage(company_image,company_name,item.state.messageSets[0].messages);
    //     }else
    //       html+='<div class="msg-list-box" data_chat_id="'+item.id+'">';
    //       html+='<div class="row">';
    //       html+='<div class="col-lg-3">';
    //       $fmcg.each(item.state.members, function(index, itemmembers) {  
    //         if(itemmembers.user_id != member1)
    //           html+='<div class="msg-logo"><img src="'+itemmembers.user.image+'" /></div>';
    //       });
    //       html+='</div>';
    //       html+='<div class="col-lg-9">';
    //       $fmcg.each(item.state.members, function(index, itemmembers) {  
    //         if(itemmembers.user_id != member1)
    //           html+='<h3 class="company_name">'+itemmembers.user.name+'</h3>';
    //       });
          
    //       html+='<div class="msg-left-txt">';
    //       html+='<p>'; 
    //       if(typeof item.state.messageSets[0].messages != 'undefined' && typeof item.state.messageSets[0].messages[0]!= 'undefined'&& typeof item.state.messageSets[0].messages[0].user!= 'undefined'){
    //       html+='<h6>'+item.state.messageSets[0].messages[0].user['name']+':</h6>';
    //       }             
    //       if(typeof item.state.messageSets[0].messages != 'undefined' && typeof item.state.messageSets[0].messages[0]!= 'undefined'&& typeof item.state.messageSets[0].messages[0].text!= 'undefined'){
    //       html+=item.state.messageSets[0].messages[0].text;
    //       }
    //       html+='</p>';
    //       html+='</div>';
    //       if(typeof item.state.messageSets[0].messages != 'undefined' && typeof item.state.messageSets[0].messages[0]!= 'undefined'&& typeof item.state.messageSets[0].messages[0].created_at!= 'undefined'){
    //         const dateStr =  item.state.messageSets[0].messages[0].created_at;
    //         const dateObj = new Date(dateStr);

    //         // Step 2: Define an array of month names
    //         const monthNames = [
    //           "Jan", "Feb", "Mar", "Apr", "May", "Jun",
    //           "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    //         ];

    //         // Step 3: Extract the month and day from the Date object
    //         const month = monthNames[dateObj.getUTCMonth()]; // getUTCMonth() returns 0-based month index
    //         const day = dateObj.getUTCDate(); // getUTCDate() returns the day of the month

    //         // Step 4: Format the month and day into the desired format
    //         const formattedDate = `${month} ${day}`;
    //         html+='<div class="msg-dt">'+formattedDate+'</div>';
    //         if(item.state.unreadCount>0)
    //         html+='<div class="msg-unread">'+item.state.unreadCount+'</div>';
    //       }
    //       html+='</div>';
    //       html+='</div>';
    //       html+='</div>';
    //   });
        
    //   $fmcg('#left_messages_list').html(html);
    // } 
    $fmcg(document).on('click','.attach_delete',async function(){
      $fmcg('.file-list').html('');
      $fmcg('#msg_attach_file').val("");
      $fmcg('.file-list').hide();
      if($fmcg("#stream_chat_text").val()!=''){
			  $fmcg("#send_message").addClass('enable');
      }else{
        $fmcg("#send_message").removeClass('enable');
      }
    });
    
    function displayMessage(logo,company_name,messages,mute_status){ 

      if(mute_status){
        $fmcg('#muteChatroom').text('Unmute')
        $fmcg('#muteChatroom').attr("id","unmuteChatroom");
      }else{
        $fmcg('#unmuteChatroom').text('Mute')
        $fmcg('#unmuteChatroom').attr("id","muteChatroom");
      }
      
      var html = '<div class="list-ic"><img src="'+logo+'"></div> <h4>'+company_name+'</h4>';     
     
      $fmcg("#active_company_info").html(html);
      var msg_html = '';
      var old_date = '';
      $fmcg.each(messages, function(i, item) {  
          const dateStr =  item.created_at;
          const dateObj = new Date(dateStr);

          // Step 2: Define an array of month names
          const monthNames = [
            "Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
          ];

          // Step 3: Extract the month and day from the Date object
          const month = monthNames[dateObj.getUTCMonth()]; // getUTCMonth() returns 0-based month index
          const day = dateObj.getDate(); // getUTCDate() returns the day of the month
          const hours = dateObj.getHours(); // getUTCHours() returns the hour
          const minutes = dateObj.getMinutes(); // getUTCMinutes() returns the minutes
          const formattedTime = `${hours}:${minutes.toString().padStart(2, '0')}`;  
          // Step 4: Format the month and day into the desired format
          const formattedDate = `${month} ${day}`; //console.log(formattedDate); 
          if(formattedDate!=old_date){
            msg_html+='<div class="messages-dtl-date"><span>'+formattedDate+'</span></div>';
            old_date = formattedDate; 
           }
        msg_html+= '<div class="messages-dtl-list">';
        msg_html+= '<div class="msg-name-comp-bx">';
        var url = "{{url('/company-profile')}}";
        var  namearray = item.user.name.split("|"); 
        if(namearray[3] != undefined)
        var url = "{{url('/company-profile')}}"+'/'+namearray[3];
        msg_html+= '<div class="msg-logo-dtl" data_id="'+item.user.id+'"><a href="'+url+'"><img src="'+item.user.image+'"></a></div>';
        msg_html+= '<div class="msg-logo-dtl-txt">';
        
        msg_html+= '<h3>'+namearray[0]+'<span>'+formattedTime+'</span></h3>';
        msg_html+= '<h4>';
        if(namearray[1] != undefined)  
        msg_html+= namearray[1];
        if(namearray[2] != undefined)  
        msg_html+= ' - '+namearray[2];
        msg_html+= '</h4>';
        msg_html+= '</div>';
        msg_html+= '</div>';
        msg_html+= '<div class="detail-mesage-c">';
        $fmcg.each(item.attachments, function(attIndex, attachment_item) {  
          if(attachment_item.type == "image"){
            msg_html+= '<div class="attachment_item"><a href="'+attachment_item.asset_url+'" class="popImge" data-bs-toggle="modal" data-bs-target="#chatModal"><img src="'+attachment_item.asset_url+'" /></a>';
            // if(typeof attachment_item.file_name != 'undefined')
            // msg_html+= '<span>'+attachment_item.file_name+'</span>';
            msg_html+= '</div>';
          }else{        
            // if(attachment_item.type=='pdf')  
            // msg_html+= '<div class="attachment_item"><a href="'+attachment_item.asset_url+'" download="'+attachment_item.file_name+'" target="_blank" onclick="forceDownload(\''+attachment_item.asset_url+'\',\''+attachment_item.file_name+'\')">';
            // else
            msg_html+= '<div class="attachment_item"><a href="'+attachment_item.asset_url+'" download="'+attachment_item.file_name+'" target="_blank">';
            if(attachment_item.type!='alt')
            msg_html+= '<div class="attachments-list" style=""><div class="thumbnail">  <i class="fa fa-file-'+attachment_item.type+'-o"></i>  ';
            else
            msg_html+= '<div class="attachments-list" style=""><div class="thumbnail">  <i class="fa fa-file-o"></i>  ';
            if(typeof attachment_item.file_name != 'undefined')
            msg_html+= '<p class="name">'+attachment_item.file_name+'</p> ';
            msg_html+= '</div></div></a></div>';
          }
        });
        msg_html+= item.html;
        msg_html+= '</div>';
        msg_html+= '</div>';        
      });
      $fmcg(".messages-dtl-Outer").html(msg_html);
      var objDiv = document.getElementById("message-right-bx");
      objDiv.scrollTop = objDiv.scrollHeight;
    }
    $fmcg(document).on('click','.msg-logo-dtl',async function(){
      profile_id = $(this).attr("data_id");
      window.location.href="";
    });
    
    $fmcg(document).on('click','.msg-list-box',async function(){
      channel_id = $fmcg(this).attr('data_chat_id');
      default_chatroom = channel_id;
      $fmcg('.msg-list-box').removeClass('active'); 
      $fmcg(this).addClass('active');
      $fmcg(this).find(".msg-unread").remove();
      var logo_selected = $fmcg(this).find('div.msg-logo img').attr('src');
      var company_name = $fmcg(this).find('h3.company_name').html();   
      await loadChannel(channel_id,logo_selected,company_name);

    });
    async function loadChannel(channel_id,logo_selected,company_name){
      channel = client.channel("messaging", channel_id);     
      var mute_status = false;
      $fmcg.each(channel.state.members, function(index, itemmembers) {  
          if(itemmembers.user_id == member1)
          mute_status = itemmembers.notifications_muted;
          else
          othermember_id = itemmembers.user_id;
        });
      await channel.markRead();
      const { memebrs, messages } =  await channel.watch();
      if(!channel.data.blocked){
        channel.watch();
        channel.on("user.watching.start", (event) => {
          // handle watch started event
          //console.log(`${event.user.id} started watching`);
        });
        $fmcg('.mesage-enter-area').show();
        $fmcg('#unblockChatroom').text('Block')
        $fmcg('#unblockChatroom').attr("id","blockChatroom");    
      }else{
        $fmcg('.mesage-enter-area').hide(); 
        $fmcg('#blockChatroom').text('Unblock')
        $fmcg('#blockChatroom').attr("id","unblockChatroom");       
      }
      displayMessage(logo_selected,company_name,messages,mute_status);
    
    }
    $fmcg(document).on('click','#send_message',async function(){
      await sendMessage();
    });
    $fmcg(document).on('click','#pic_upload',function(){
      $fmcg('#msg_attach_file').trigger('click');
    });
    async function sendMessage(){
      // if($fmcg("#stream_chat_text").val()!=''){
      //   await channel.sendMessage({
      //    text:  $fmcg("#stream_chat_text").val()
      //   }); 
      //   $fmcg("#stream_chat_text").val('');
      //   $fmcg(".msg-list-box.active").trigger('click');
      // }
      var vidFileLength = $fmcg("#msg_attach_file")[0].files.length; 
      if(vidFileLength != 0){
       // $fmcg('#msg_attach_file').prop('files')[0];
        var mimeType=$fmcg('#msg_attach_file').prop('files')[0]['type']; //mimeType=image/jpeg or application/pdf etc...        
        const response =  await channel.sendImage($fmcg('#msg_attach_file').prop('files')[0]); 
        if(response.file != undefined){
          if(mimeType.split('/')[0] === 'image'){
              await channel.sendMessage({
              text:  $fmcg("#stream_chat_text").val(),
              attachments: [
                  {
                      type: upload_file_type,
                      asset_url: response.file,
                      file_name: upload_file_name,
                  }
              ],
              });
          }else{
            await channel.sendMessage({
              text:  $fmcg("#stream_chat_text").val(),
              attachments: [
                  {
                      type: upload_file_type,
                      asset_url: response.file,
                      file_name: upload_file_name,
                  }
              ],
              });
          }
        }
      }else{
        if($fmcg("#stream_chat_text").val()!=''){
          await channel.sendMessage({
          text:  $fmcg("#stream_chat_text").val()
          }); 
        //  $fmcg("#stream_chat_text").val('');
          //$fmcg(".msg-list-box.active").trigger('click');
        }
      }
      $fmcg("#stream_chat_text").val('');
      $fmcg(".msg-list-box.active").trigger('click');
      $fmcg('.file-list').html('');
      $fmcg('.file-list').hide();
      $fmcg('#msg_attach_file').val("");
      if($fmcg("#stream_chat_text").val()!=''){
        $fmcg("#send_message").addClass('enable');
      }else{
        $fmcg("#send_message").removeClass('enable');
      }
    }
        $fmcg(document).on('change','#msg_attach_file',async function(event){
        const files =event.target.files ;  
        const arr1 = event.target.value.split('\\');
        const name = arr1[arr1.length-1];
       // o.name = name;
          
        upload_file_name = name;
        const arr2 = event.target.value.split('.');
        const ext = arr2[arr2.length-1];
        //o.ext = ext;

        $fmcg('.file-list').html(file(files,name,ext));
        $fmcg('.file-list').show();        
        $fmcg("#send_message").addClass('enable'); 
        //await getUrl(files[0]);
        // var mimeType=files[0]['type'];//mimeType=image/jpeg or application/pdf etc...


        // const response =  await channel.sendImage(files[0]); 
        // if(response.file != undefined){
        // if(mimeType.split('/')[0] === 'image'){
        //     await channel.sendMessage({
        //     text:  $fmcg("#stream_chat_text").val(),
        //     attachments: [
        //         {
        //             type: 'image',
        //             asset_url: response.file,
                    
        //         }
        //     ],
        //     });
        // }else{
        //   await channel.sendMessage({
        //     text:  $fmcg("#stream_chat_text").val(),
        //     attachments: [
        //         {
        //             type: 'file',
        //             asset_url: response.file,
        //         }
        //     ],
        //     });
        // }
         
      //}
      $fmcg(".msg-list-box.active").trigger('click');
      });
       async function getUrl(efilesvent){
        const response = await channel.sendImage(efilesvent); 
      }
      $fmcg(document).on('click','#doc_upload',function(){
        $fmcg('#msg_attach_file').trigger('click');
      });
      $fmcg(document).on('change','#msg_doc_attach_file',async function(event){
      //   const files =event.target.files ;  
      //   const arr1 = event.target.value.split('\\');
      //   const name = arr1[arr1.length-1];
      //  // o.name = name;

      //   const arr2 = event.target.value.split('.');
      //   const ext = arr2[arr2.length-1];
      //   //o.ext = ext;

      //   $fmcg('.file-list').append(file(files,name,ext));
      //   //await getUrl(files[0]);
      //   var mimeType=files[0]['type'];//mimeType=image/jpeg or application/pdf etc...        
      //   const response =  await channel.sendImage(files[0]); 
      //   if(response.file != undefined){
      //   if(mimeType.split('/')[0] === 'image'){
      //       await channel.sendMessage({
      //       text:  $fmcg("#stream_chat_text").val(),
      //       attachments: [
      //           {
      //               type: 'image',
      //               asset_url: response.file,
                    
      //           }
      //       ],
      //       });
      //   }else{
      //     await channel.sendMessage({
      //       text:  $fmcg("#stream_chat_text").val(),
      //       attachments: [
      //           {
      //               type: 'file',
      //               asset_url: response.file,
      //           }
      //       ],
      //       });
      //   }
         
     // } 
      $fmcg(".msg-list-box.active").trigger('click');
        });
        function forceDownload(pdf_url, pdf_name) {
          var x = new XMLHttpRequest();
          x.open("GET", pdf_url, true);
          x.responseType = 'blob';
          x.onload = function(e){
              saveAs(x.response, pdf_name, 'application/pdf');
          };
          x.send();
      } 
            $fmcg(document).on('keypress','#search_channel',async function(event){
       
          var key = event.which;
          var query = $fmcg("#search_channel").val();
          if(key == 13)  // the enter key code
            { 
              if(query!='')
              var filter = { type: 'messaging', members: { $in: [username] },name: { $autocomplete: query }};
              else
              var  filter = { type: 'messaging', members: { $in: [username] }};
              const sort = { last_message_at: -1 };
              const channels = await client.queryChannels(filter, sort, {watch:true});
              //console.log(channels);
              var html = '';
              $fmcg.each(channels, function(i, item) { 
                 
                  html+='<div class="msg-list-box" data_chat_id="'+item.id+'">';
                  html+='<div class="row">';
                  html+='<div class="col-lg-3">';
                  html+='<div class="msg-logo"><img src="'+item.data.image+'" /></div>';
                  html+='</div>';
                  html+='<div class="col-lg-9">';
                  html+='<h3 class="company_name">'+item.data.name+'</h3>';
                  html+='<div class="msg-left-txt">';
                  html+='<p>'; 
                  if(typeof item.state.messageSets[0].messages != 'undefined' && typeof item.state.messageSets[0].messages[0]!= 'undefined'&& typeof item.state.messageSets[0].messages[0].user!= 'undefined'){
                  html+='<h6>'+item.state.messageSets[0].messages[0].user['name']+':</h6>';
                  }             
                  if(typeof item.state.messageSets[0].messages != 'undefined' && typeof item.state.messageSets[0].messages[0]!= 'undefined'&& typeof item.state.messageSets[0].messages[0].text!= 'undefined'){
                  html+=item.state.messageSets[0].messages[0].text;
                  }
                  html+='</p>';
                  html+='</div>';
                  if(typeof item.state.messageSets[0].messages != 'undefined' && typeof item.state.messageSets[0].messages[0]!= 'undefined'&& typeof item.state.messageSets[0].messages[0].created_at!= 'undefined'){
                    const dateStr =  item.state.messageSets[0].messages[0].created_at;
                    const dateObj = new Date(dateStr);

                    // Step 2: Define an array of month names
                    const monthNames = [
                      "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                      "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                    ];

                    // Step 3: Extract the month and day from the Date object
                    const month = monthNames[dateObj.getUTCMonth()]; // getUTCMonth() returns 0-based month index
                    const day = dateObj.getUTCDate(); // getUTCDate() returns the day of the month

                    // Step 4: Format the month and day into the desired format
                    const formattedDate = `${month} ${day}`;
                    html+='<div class="msg-dt">'+formattedDate+'</div>';
                    if(item.state.unreadCount>0)
                    html+='<div class="msg-unread">'+item.state.unreadCount+'</div>';
                  }
                  html+='</div>';
                  html+='</div>';
                  html+='</div>';
              });
              
              $fmcg('#left_messages_list').html(html);
                  }
          }); 
    //       // $fmcg(document).on('click','#show_emoji',async function(event){
    //       //     const picker = new Picker();
    //       //     document.body.appendChild(picker);
    //       //     picker.addEventListener('emoji-click', event => {
    //       //     console.log(event); // will log something like the above
    //       //     $("#stream_chat_text").html($("#stream_chat_text").html()+event.detail.emoji.unicode);
    //       //   });
    //       // });
          
</script>
<script>
        $fmcg(document).ready(function() {
            // Show the emoji picker when the button is clicked
            $fmcg('#show_emoji').on('click', function() {
                $fmcg('#emoji-picker').toggle(); // Toggle visibility
            });

            // Add the selected emoji to the input field
            $fmcg('#emoji-picker')[0].addEventListener('emoji-click', function(event) {
                const emoji = event.detail.unicode;
                const input = $fmcg('#stream_chat_text');
                input.val(input.val() + emoji); // Append emoji to input value
                if($fmcg("#stream_chat_text").val()!=''){
                  $fmcg("#send_message").addClass('enable');
                }else{
                  $fmcg("#send_message").removeClass('enable');
                }
            });

            // Optionally, hide the emoji picker when clicking outside
            $fmcg(document).on('click', function(event) {
                if (!$fmcg(event.target).closest('#emoji-picker, #show_emoji').length) {
                    $fmcg('#emoji-picker').hide();
                }
            });
        });
    </script>
@endsection