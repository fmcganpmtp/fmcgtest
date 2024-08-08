<?php  if(!Auth::guard('user')->check()) {  ?>
<!-- Start Subscribe Area -->
<section class="subscribe-area ptb-54 wow">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-7">
				<div class="subscribe-content">
					<h3>Subscribe To Our Newsletter</h3>
					<p>The latest offers, the best deals and everything that is happening in the world of FMCG.</p>
				</div>
			</div>
			<div class="col-lg-5">
				<div class="newsletter-form">
					<input name="email" id="email" type="text" class="form-control {{ $errors->has('email')? ' is-invalid':''}}" placeholder="Your email address" required >
					@if ($errors->has('email'))
					<span class="invalid-feedback" role="alert">
					<strong>{{ $errors->first('email') }}</strong>
					</span>
					@endif
					<button class="submit-btn default-btn" id="submit_news" type="submit"> Subscribe </button>
				</div>
				<div id="newsletter_msg" style="color:green;"><p>&nbsp;</p></div>
			</div>
		</div>
	</div>
</section>
<?php } ?>
<!-- Start Footer  Area -->
<div class="footer-area pt-54 pb-30">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-sm-6">
				<div class="single-footer-widget">
					<div class="footer-logo">
						<?php
							$footer_logo= $site_about = "";			
							foreach($view_composer_general as $general)
							{
							if( $general->item =='footer_logo')
							  $footer_logo=$general->value; 
							 if( $general->item =='site_about')
							  $site_about=$general->value; 	
							}
							if(!empty($footer_logo)) $img_urlf =asset('/assets/uploads/logo/'.$footer_logo);
							else $img_urlf =   asset('images/footer-logo.png'); ?>
						<a href=""><img src="{{ $img_urlf }}"></a>
					</div>
					<div class="footer-about">
						<p>
							{{ $site_about ?? ''}}
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-sm-6">
				<div class="single-footer-widget">
					<h3>Information</h3>
					<ul class="import-link">
						@if(count($view_footer_info)>0)
						@foreach($view_footer_info as $data)
						<li><a href="{{url($data->seo_url)}}"> {{$data->page}}</a></li>
						@endforeach
						@endif
						<li><a href="{{route('contactus')}}"> Contact Us</a></li>
					</ul>
				</div>
			</div>
			
			<!--
			@if(count($view_footer_help)>0)
			<div class="col-lg-2 col-sm-6">
				<div class="single-footer-widget">
					<h3>Help</h3>
					<ul class="import-link">
						@foreach($view_footer_help as $data)
						<li><a href="{{url($data->seo_url)}}"> {{$data->page}}</a></li>
						@endforeach
					</ul>
				</div>
			</div>
			@endif
			-->
			<div class="col-lg-3 col-sm-6">
				<div class="single-footer-widget">
					<h3>Stay Connected </h3>
					<ul class="social-media">
						@if(!empty($view_composer_socialIcons))
						@foreach($view_composer_socialIcons as $view_composer_socialIcon)
						@if(($view_composer_socialIcon->type=="image"))
						<li><a href="{{$view_composer_socialIcon->link}}" target="_blank"><img style="width:30px;" src="{{ URL::asset('/assets/uploads/socialmedia/'.$view_composer_socialIcon->icon)}}" >
							</a>
						</li>
						@else
						<li><a href="{{$view_composer_socialIcon->link}}" target="_blank"><?php  echo $view_composer_socialIcon->icon; ?>
							</a>
						</li>
						@endif
						@endforeach
						@endif
					</ul>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="payment-icon"><img src="{{ asset('images/payment-icon.png') }}"></div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- End Footer  Area -->
<!-- Start Copy Right Area -->
<div class="copy-right-area">
	<div class="container">
		<p> Copyright © {{date("Y")}} Fmcg land, All rights reserved. Designed and developed by <a href="https://www.hermosoftech.com/" target="_blank">HermoSoftech<img src="{{ asset('images/hermosoftech.png') }}"></a> </p>
	</div>
</div>

<!-- End Copy Right Area -->
<!-- Start Go Top Area -->
<div class="go-top"> <i class="ri-arrow-up-s-fill"></i> <i class="ri-arrow-up-s-fill"></i> </div>
<!-- End Go Top Area -->
<!-- Jquery Min JS -->
@if(Auth::guard('user')->check())

@php
      $company_image =  $view_composer_user->BuyerCompany->company_image ?$view_composer_user->BuyerCompany->company_image : ''; 
      $member1 =  preg_replace('/[@\.]/', '_', Auth::guard('user')->user()->email);
    if(($company_image!=""))
      $cmp_img = asset('uploads/BuyerCompany/').'/'.$view_composer_user->BuyerCompany->company_image;
    else 
      $cmp_img = asset('uploads/defaultImages/seller.jpg'); 
	@endphp
<div class="nwe-msgC">
  <div class="new-message-outer-sec">
    <div class="new-msg-bx">
      <div class="chat-header">
        <div class="chat-top-user"><img src="{{ $cmp_img }}" /> </div>
        <h2>Messaging</h2>
      </div>
      <div class="msg-user-C">
        <div class="mag-search-c">
          <input type="text"placeholder="Search messages" id="filterList" />
          <button><i class="fa fa-search" aria-hidden="true"></i></button>
          <div class="msg-user-listing">
 
          </div>
        </div>
      </div>
      <button type="submit" class="close-quote"><i class="fa fa-chevron-down" aria-hidden="true"></i> </button>
    </div>
    <div class="msg-level-2">
      <div class="mssage-level-2-inner" id="box_chat_message">
        <div class="chat-user-head">
          <h4><span> </span><b class="cht-user-name"> </b></h4>
          <div class="chat-level-2close"><i class="fa fa-times" aria-hidden="true"></i> </div>
          <?php /*?><button type="button" onClick = "wm1()">200</button>
    <button type="button" onClick = "wm2()">50</button><?php */?>
          <div id="show-more" class="windo-size-button" > <a href="javascript:void(0)"><i class="fa fa-compress" aria-hidden="true"></i></a></div>
          <div id="show-less" style="display:none" class="windo-size-button"><a href="javascript:void(0)"></a><i class="fa fa-expand" aria-hidden="true"></i></div>
        </div>
        <div id="show-more-content" style="display:block!important;">
          <div class="left-msg-list-outer" id="left-msg-list-outer" >
             
              
             
          </div>
		  </div>
		  </div>
          <div class="chat-form-area">
            <div class="chat-entering-area">
              <textarea name="" cols="" rows="" placeholder="Write a message" id="stream_chat_text"></textarea>
			  <div class="file-list" style="display:none;"></div>
            </div>
            <div class="chat-options">
              <ul>
                <li><a href="javascript:void(0)" id="pic_upload"><i class="fa fa-picture-o" aria-hidden="true"></i></a></li>
				<input type="file"   name="image_file" id="msg_attach_file" style="display:none"/>
                <li><a href="javascript:void(0)" id="doc_upload"><i class="fa fa-paperclip" aria-hidden="true"></i></a></li>
				<input type="file"   name="attach_file" id="msg_doc_attach_file" style="display:none"/>
                <li><a href="javascript:void(0)" id="show_emoji" ><i class="fa fa-smile-o" aria-hidden="true"></i></a></li>
        		<emoji-picker id="emoji-picker" style="display: none;"></emoji-picker>
              </ul>
              <button  class="message-send" id="send_message">send</button>
            </div>
          </div>
        
      
    </div>
  </div>
  <!--message-outer-sec-->
  <button type="submit" class="new-msg-bx-button d-flex"><i class="fa fa-envelope-o" aria-hidden="true"></i> Messaging <span class="msg_btn_chat_note ml-2"></span></button>
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
@endif
@if(Auth::guard('user')->check())
<style>
	.enable{
		background:#4472c4!important;
	}
  .msg_btn_chat_note{
    display:block;
    width: 20px;
    height: 20px;
    text-align: center;
    line-height: 20px;
    background: #cb011b;
    color: #FFFFFF;
    top: 0;
    border-radius: 50%;
    right: 0;
    font-size: 11px;
  }
</style> 
<script src="https://cdn.jsdelivr.net/npm/stream-chat"></script>
<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script> 
<script>
	var activeChatroom = '';
  var chatroom = 'fmcgChatRoom';  
  var token = '';
  var channel = '';
  var chatmembers = [];
  var chatmessages = []; 
  const apiKey = "{{env('STREAM_API_KEY')}}";
  const client = new StreamChat(apiKey);
	const url = "{{route('create-token')}}"; 
	var active_chat_room_unread = 0;
  var default_chatroom = '';
  var upload_file_type= 'alt';
  var upload_file_name = '';
  const username = "{{preg_replace('/[@\.]/', '_', Auth::guard('user')->user()->email)}}"; 
	@php
      $company_image =  $view_composer_user->BuyerCompany->company_image ?$view_composer_user->BuyerCompany->company_image : ''; 
      $member1 =  preg_replace('/[@\.]/', '_', Auth::guard('user')->user()->email);
    if(($company_image!=""))
      $cmp_img = asset('uploads/BuyerCompany/').'/'.$view_composer_user->BuyerCompany->company_image;
    else 
      $cmp_img = asset('uploads/defaultImages/seller.jpg'); 
	@endphp
  init(url, username);
  async function init(url,username){
    $fmcg.ajax({
        url:url,
        type:"POST",
        dataType: 'json',
        data:{
            "_token": "{{ csrf_token() }}",
            'username':username},
            success:function(data){ 
                token  = data.token;
                Chat(data.token, username,data.chatrooms) 
        },
        error: function (xhr) {
            var errors = JSON.parse(xhr.responseText);		 
            
        }
    });
  }
  async function Chat(token, id,chatrooms){ 
      await client.setUser({
              id,
              name: '{{$view_composer_user->BuyerCompany->company_name.'|'.$view_composer_user->name.'|'.$view_composer_user->position.'|'.$view_composer_user->id}}',
              image: '{{$cmp_img}}',
              role: 'admin',
          },
          token
      ); 
      $fmcg.each(chatrooms, async function(i, item) {  
      channel = client.channel("messaging", item); 
        await channel.addMembers([id], { text: 'New Member joined the channel.' });  
      });
      await checkChannels();
  }
	setInterval(async () => {
		if($fmcg("#filterList").val()=='')
      		await checkChannels()
    }, 5000);
	async function checkChannels(){
    const filter = { type: 'messaging', members: { $in: [username] } };
    const sort = { last_message_at: -1 };
    const channels = await client.queryChannels(filter, sort, {watch:true,presence:true}); 
    var html = '';
	  active_chat_room_unread = 0;
	  totalUnreadCount = 0;
      $fmcg.each(channels, function(i, item) {  
        if(default_chatroom == item.id){
          html+='<div class="msg-user-bx active" data_chat_id="'+item.id+'">';
          var company_image = '';
          var company_name = '';
          $fmcg.each(item.state.members, function(index, itemmembers) {  
            if(itemmembers.user_id != username){
              company_image = itemmembers.user.image;
              company_name  = itemmembers.user.name;
            }
              
          });
          //displayMessage(company_image,company_name,item.state.messageSets[0].messages);
        }else
          html+='<div class="msg-user-bx" data_chat_id="'+item.id+'">'; 
          $rowset = 0;        
          $fmcg.each(item.state.members, function(index, itemmembers) {  
            if(itemmembers.user_id != username &&!$rowset){
              var  namearray =  itemmembers.user.name.split("|");
                if(namearray[0] != '{{$current_user->BuyerCompany->company_name}}'){
                  html+='<div class="msg-user-bx-img"><div class="msg-USR-img"><img src="'+itemmembers.user.image+'" /></div></div>';
                  $rowset = 1;
                }
            }
          });
		  html+='<div class="msg-user-right">';
      $rowset = 0; 
          $fmcg.each(item.state.members, function(index, itemmembers) {  
            if(itemmembers.user_id != username&&!$rowset){
				      var  namearray =  itemmembers.user.name.split("|");
                if(namearray[0] != '{{$current_user->BuyerCompany->company_name}}'){
                  html+='<h4 class="company_name" data_id="'+namearray[3]+'">'+namearray[0]+'</h4>';
                  $rowset = 1;
                }
			        }
          });  

          html+='<div class="msg-left-txt">';
           
		  if(typeof item.state.messageSets[0].messages != 'undefined' && typeof item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1]!= 'undefined'&& typeof item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1].user!= 'undefined'){ //console.log(item.state.messageSets[0].messages[0]);
            var  namearray = item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1].user['name'].split("|"); 
          html+='<h6>'+namearray[1]+':</h6>';
          }             
          if(typeof item.state.messageSets[0].messages != 'undefined' && typeof item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1]!= 'undefined'&& typeof item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1].text!= 'undefined'){
            if(item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1].text.length>60)
            html+=item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1].text.slice(0,60)+'...';
            else
            html+=item.state.messageSets[0].messages[item.state.messageSets[0].messages.length-1].text;
          }
           
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
            html+='<div class="msg-user-date">'+formattedDate+'</div>';            
			if(item.state.unreadCount>0){
              html+='<div class="msg-unread"><span>'+item.state.unreadCount+'</span></div>';
              totalUnreadCount++;  
              if(default_chatroom == item.id){
               active_chat_room_unread = 1;
              }
            }
            if(totalUnreadCount>0){
              $fmcg(".chat-count").html(totalUnreadCount);
              $fmcg(".msg_btn_chat_note").html(totalUnreadCount);
              $fmcg(".msg_btn_chat_note").show();
              $fmcg(".chat-count").show();
            }else{
              $fmcg(".chat-count").html('');
              $fmcg(".msg_btn_chat_note").html();
              $fmcg(".msg_btn_chat_note").hide();
              $fmcg(".chat-count").hide();
            }
          }
          html+='</div>';
          html+='</div>';
          html+='</div>';
      });
        
      $fmcg('.msg-user-listing').html(html);
	  if(active_chat_room_unread>0){
        $fmcg('.msg-user-bx.active').trigger('click');
      }
    }  
	
	$fmcg(document).on('keyup','#stream_chat_text',async function(){
		if($fmcg(this).val()!=''){
			$fmcg("#send_message").addClass('enable');
		}else{
			$fmcg("#send_message").removeClass('enable');
		}
	});
	$fmcg(document).on('click','.msg-user-bx',async function(){
    channel_id = $fmcg(this).attr('data_chat_id');console.log(channel_id); 
	  default_chatroom = channel_id;
    $fmcg('.msg-user-bx').removeClass('active'); 
    $fmcg(this).addClass('active');
	  $fmcg(this).find(".msg-unread").remove();
    var logo_selected = $fmcg(this).find('div.msg-USR-img img').attr('src');
    var company_name = $fmcg(this).find('h4.company_name').html();
    await loadChannel(channel_id,logo_selected,company_name);
  });
  async function loadChannel(channel_id,logo_selected,company_name){
    channel = client.channel("messaging", channel_id);
	  await channel.markRead();
    
    const { memebrs, messages } =  await channel.watch({presence:true});
    channel.watch({presence:true});
      
    channel.on("user.watching.start", (event) => {
      console.log(`${event.user.id} started watching`);
    });
    displayMessage(logo_selected,company_name,messages);    
  } 
	function displayMessage(logo,company_name,messages){ 
		var html = '';
		html+= ' <div class="chat-user-head">';
		var  namearray = company_name.split("|"); 
    html+= '<h4><span><img src="'+logo+'" /></span><b class="cht-user-name">'+namearray[0]+'</b></h4>';
    html+= '<div class="chat-level-2close"><i class="fa fa-times" aria-hidden="true"></i> </div>';
    html+= '<div id="show-more" class="windo-size-button" > <a href="javascript:void(0)"><i class="fa fa-compress" aria-hidden="true"></i></a></div>';
    html+= '<div id="show-less" style="display:none" class="windo-size-button"><a href="javascript:void(0)"></a><i class="fa fa-expand" aria-hidden="true"></i></div>';
    html+= '</div>';
    html+= '<div id="show-more-content" >';
    html+= '<div class="left-msg-list-outer" id="left-msg-list-outer">';
		var old_date = '';
    console.log(messages);
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
            html+='<div class="messages-dtl-date"><span>'+formattedDate+'</span></div>';
            old_date = formattedDate; 
           }

           var  namearray = item.user.name.split("|"); 
           html+= '<div class="messages-dtl-list">';
           html+= '<div class="msg-name-comp-bx">';
           var url = "{{url('/company-profile')}}";
           if(namearray[3] != undefined)
           var url = "{{url('/company-profile')}}"+'/'+namearray[3];
           html+= '<div class="msg-logo-dtl" data_id="'+item.user.id+'"><a href="'+url+'" ><img src="'+item.user.image+'"></a></div>';
           html+= '<div class="msg-logo-dtl-txt">';
        
        html+= '<h3>'+namearray[0]+'<span>'+formattedTime+'</span></h3>';
        html+= '<h4>';
        if(namearray[1] != undefined)  
        html+= namearray[1];
        if(namearray[2] != undefined)  
        html+= ' - '+namearray[2];
        html+= '</h4>';
        html+= '</div>';
        html+= '</div>';
        html+= '<div class="detail-mesage-c">';
        $fmcg.each(item.attachments, function(attIndex, attachment_item) {  
          if(attachment_item.type == "image"){
            html+= '<div class="attachment_item"><a href="'+attachment_item.asset_url+'" class="popImge" data-bs-toggle="modal" data-bs-target="#chatModal"><img src="'+attachment_item.asset_url+'" /></a>';
            //if(typeof attachment_item.file_name != 'undefined')
            //html+= '<span>'+attachment_item.file_name+'</span>';
            html+= '</div>';
          }else{        
            // if(attachment_item.type=='pdf')  
            // msg_html+= '<div class="attachment_item"><a href="'+attachment_item.asset_url+'" download="'+attachment_item.file_name+'" target="_blank" onclick="forceDownload(\''+attachment_item.asset_url+'\',\''+attachment_item.file_name+'\')">';
            // else
            html+= '<div class="attachment_item"><a href="'+attachment_item.asset_url+'" download="'+attachment_item.file_name+'" target="_blank">';
            if(attachment_item.type!='alt')
            html+= '<div class="attachments-list" style=""><div class="thumbnail">  <i class="fa fa-file-'+attachment_item.type+'-o"></i>  ';
            else
            html+= '<div class="attachments-list" style=""><div class="thumbnail">  <i class="fa fa-file-o"></i>  ';
            if(typeof attachment_item.file_name != 'undefined')
            html+= '<p class="name">'+attachment_item.file_name+'</p> ';
            html+= '</div></div></a></div>';
          }
        });
        html+= item.html;
        html+= '</div>';
        html+= '</div>';        
      });   
    html+= '</div>';   
    $fmcg("#box_chat_message").html(html);
	  var objDiv = document.getElementById("left-msg-list-outer");
    objDiv.scrollTop = objDiv.scrollHeight;
  }
	$fmcg(document).on('click','#send_message',async function(){
    await sendMessage();
  });
	$fmcg(document).on('click','#pic_upload',function(){
    $fmcg('#msg_attach_file').trigger('click');    
  });
	$fmcg(document).on('change','#msg_attach_file',async function(event){        
    const files =event.target.files ;  
    const arr1 = event.target.value.split('\\');
    const name = arr1[arr1.length-1]; 
    const arr2 = event.target.value.split('.');
    const ext = arr2[arr2.length-1];
    upload_file_name = name;
    $fmcg('.file-list').show();
    $fmcg('.file-list').html(file(files,name,ext));
    $fmcg("#send_message").addClass('enable'); 
    $fmcg(".msg-user-bx.active").trigger('click');
  });
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
  $fmcg(document).on('click','#doc_upload',function(){
    $fmcg('#msg_attach_file').trigger('click');
  });
      // $fmcg(document).on('change','#msg_doc_attach_file',async function(event){
      //   const files =event.target.files ;  
        
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
      // $fmcg(".msg-user-bx.active").trigger('click');
      //   });
	async function sendMessage(){
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
      var profile_id = $fmcg('.msg-user-bx.active').find('.company_name').attr('data_id');     
      $fmcg.ajax({
	        url:"{{route('chat.sentNotification')}}",
	        type:"POST",
	        data:{
	          "_token": "{{ csrf_token() }}",
	          'reciever_id':profile_id
          },
          success:async function(data){ 
          ;
          },
          error: function (xhr) { 
              ;
          }
	    }); 
      $fmcg("#stream_chat_text").val('');
      $fmcg(".msg-user-bx.active").trigger('click');
      $fmcg('.file-list').html('');
	    $fmcg('.file-list').hide();
      $fmcg('#msg_attach_file').val("");
      if($fmcg("#stream_chat_text").val()!=''){
        $fmcg("#send_message").addClass('enable');
      }else{
        $fmcg("#send_message").removeClass('enable');
      }
    //   if($fmcg("#stream_chat_text").val()!=''){
    //     await channel.sendMessage({
    //      text:  $fmcg("#stream_chat_text").val()
    //     }); 
    //     $fmcg("#stream_chat_text").val('');
    //     $fmcg(".msg-user-bx.active").trigger('click');
    //   }
      
    }
		$fmcg('#show-more-content').show();
		$fmcg(function(){
	$fmcg("#filterList").keyup(function() {
		var valThis = $fmcg(this).val().toLowerCase();
		if (valThis == "") {
			$fmcg(".msg-user-listing > .msg-list-box").show();
		} else {
			$fmcg(".msg-user-listing > .msg-list-box").each(function() {
				var text = $fmcg(this).find('.msg-user-right > .company_name').text().toLowerCase();
				text.indexOf(valThis) >= 0 ? $fmcg(this).show() : $fmcg(this).hide();
			});
		}
    
    // Start - Unnecessary "matching results" code
		var remainingResults = $fmcg('.msg-user-listing > .msg-list-box[style!="display: none;"]').length;
		 
    // End - Unnecessary "matching results" code
    
	});
});
$fmcg(document).on('click','#show-more',function(){ 
	$fmcg('#show-more-content').hide(200);
	$fmcg('.chat-form-area').hide(200);
	$fmcg('#show-less').show();
	$fmcg('#show-more').hide();
});
$fmcg(document).on('click','#show-less',function(){  
	$fmcg('#show-more-content').show(200);
	$fmcg('.chat-form-area').show(200);
	$fmcg('#show-more').show();
	$fmcg(this).hide();
});
$fmcg(document).on('click','.popImge',function(){ 
  $fmcg('#pop_image_body').html($fmcg(this).html());
});

	</script>


@endif



<script>
    $fmcg(".new-msg-bx-button").click(function(){
        $fmcg(".new-msg-bx").slideToggle('slow');
	
		
    });
	
	$fmcg(".close-quote").click(function(){
        $fmcg(".new-msg-bx").slideToggle('slow');
		});
		
		
		
		
		
	
   </script>
   
  <script>
$fmcg(document).ready(function(){
	$fmcg(document).on('click','.msg-user-bx',async function(){
		$fmcg(".msg-level-2").show(200);
    });
	$fmcg(document).on('click','.chat-level-2close',async function(){ 
    	$fmcg(".msg-level-2").hide(100);
      default_chatroom = '';
  	});
});
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
  
$fmcg(document).on('click','.cht-ico',async function(e){  
     e.preventDefault();
     profile_id = $fmcg(this).attr("sender-id");
     $fmcg.ajax({
	        url:"{{route('chat.ajaxmessages')}}",
	        type:"POST",
	        data:{
	          "_token": "{{ csrf_token() }}",
	          'sender_id':profile_id},
	           success:async function(data){
	            
              var member2 = data.member2;
              var member1 = data.member1;
              //await client.setUser(data.token, member1);     
              default_chatroom = data.default_chatroom;
              if( data.chat_room_exist){  
                channel = client.channel("messaging", default_chatroom);
                //await channel.addMembers([member1,member2]); 
                //console.log(channel.addMembers([member1], { text: 'New Member joined the channel.' }));
                await channel.addMembers([member1], { text: 'New Member joined the channel.' }); 
                await channel.addMembers([member2], { text: 'New Member joined the channel.' }); 
              }else
              await createChannel(default_chatroom,member1,member2,data.cmp_img); 
              if($fmcg('.new-msg-bx').is(':hidden'))
              {     
              $fmcg('.new-msg-bx-button').trigger("click");
              }
              await loadDefaultChannel();      
	        },
	        error: function (xhr) { 
	            ;
	        }
	        });
    });
    async function loadDefaultChannel(){
      $fmcg(".msg-user-bx").each(function() {
       if($fmcg(this).attr('data_chat_id') == default_chatroom){
        $fmcg('.msg-user-bx').removeClass('active'); 
        $fmcg(this).addClass('active');
        $fmcg(this).trigger('click');
       }
      });
    }
    async function createChannel(chatroom,member1,member2,company_image){         
      channel = client.channel('messaging',chatroom, {
          name: chatroom,
          image: company_image,
          members: [member1, member2],
      });
      // Here, 'travel' will be the channel ID
      await channel.create();
    }
</script>










        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script defer src="{{ asset('js/cookieconsent.js')}}"></script>
        <script defer src="{{ asset('js/cookieconsent-init.js')}}"></script>
        <!-- Bootstrap Bundle Min JS -->
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
        <!-- Meanmenu Min JS -->
        <script src="{{ asset('js/meanmenu.min.js')}}"></script>
        <!-- Owl Carousel Min JS -->
        <script src="{{ asset('js/owl.carousel.min.js')}}"></script>
        <!-- Wow Min JS -->
        <script src="{{ asset('js/wow.min.js')}}"></script>
        <script src="{{ asset('js/form-validator.min.js')}}"></script>
        <script src="{{ asset('js/ajaxchimp.min.js')}}"></script>
        <script src="{{ asset('js/wow.js')}}"></script>
		<!-- Custom JS -->
        <script src="{{ asset('js/custom.js')}}"></script>
        
        
<script src="https://rawgit.com/mervick/emojionearea/master/dist/emojionearea.js"></script> 
        
		<script src="https://cdn.jsdelivr.net/npm/stream-chat"></script>
        
        

        
        
        
        
        
        
        
        
        
        
        
<script>

const elchat = document.createElement('div')
elchat.innerHTML = "Chat option is disabled as per the current package.Would you like to upgrade package? <a href='{{route('package.listing')}}'>Upgrade</a>"
    function showerrorchat(){
  swal({
  icon: "error",
  content: elchat,
});
}

const elprof = document.createElement('div')
elprof.innerHTML = "Profile view is disabled as per the current package.Would you like to upgrade package? <a href='{{route('package.listing')}}'>Upgrade</a>"
    function showerrorprofile(){
  swal({
  icon: "error",
  content: elprof,
});
}

const elnetwork = document.createElement('div')
elnetwork.innerHTML = "Expand Your Network option is disabled as per the current package. Would you like to upgrade package? <a href='{{route('package.listing')}}'>Upgrade</a>"
    function showerrornetwork(){
  swal({
  icon: "error",
  content: elnetwork,
});
}

const elinsight = document.createElement('div')
elinsight.innerHTML = "Insight option is disabled as per the current package. Would you like to upgrade package? <a href='{{route('package.listing')}}'>Upgrade</a>"
    function showerrorInsight(){
  swal({
  icon: "error",
  content: elinsight,
});
}

const elProdReq = document.createElement('div')
elProdReq.innerHTML = "Product request  is disabled as per the current package. Would you like to upgrade package? <a href='{{route('package.listing')}}'>Upgrade</a>"
    function showerrorPrdReq(){
  swal({
  icon: "error",
  content: elProdReq,
});
}

const elCrProdReq = document.createElement('div')
elCrProdReq.innerHTML = "Create Product request  is disabled as per the current package. Would you like to upgrade package? <a href='{{route('package.listing')}}'>Upgrade</a>"
    function showerrorCrPrdReq(){
  swal({
  icon: "error",
  content: elCrProdReq,
});
}

const elMyPrdReq = document.createElement('div')
elMyPrdReq.innerHTML = "My Product request option is disabled as per the current package. Would you like to upgrade package? <a href='{{route('package.listing')}}'>Upgrade</a>"
    function showerrorMyPrdReq(){
  swal({
  icon: "error",
  content: elMyPrdReq,
});
}

const elGeneral = document.createElement('div')
elGeneral.innerHTML = "This option is disabled as per the current package.Would you like to upgrade package? <a href='{{route('package.listing')}}'>Upgrade</a>"
    function showerrorGeneral(){
  swal({
  icon: "error",
  content: elGeneral,
});
}

</script> 
<script  type="text/javascript">
//var $fmcg = $.noConflict();
	$fmcg(document).ready(function(){
	    $fmcg( "#submit_news" ).click(function() {
	    
	    var email = $fmcg('#email').val(); 
	    if(email!='')
	    { 
	        var load_image='{{ asset('images/ajax-loder.gif')}}';
	        var loading_image_newltr='<img src="'+load_image+'" alt="" style="width:27px;" />';
	        $fmcg("#newsletter_msg").empty().append(loading_image_newltr);
	        $fmcg.ajax({
	        url:"{{route('newsletter.subscription')}}",
	        type:"POST",
	        data:{
	          "_token": "{{ csrf_token() }}",
	          'email':email},
	           success:function(data){
	            $fmcg('#email').val('');
	            $fmcg("#newsletter_msg").empty().append("<p style='color:white'>"+data.replace('"','').replace('"','')+"</p>");
	        },
	        error: function (xhr) {
	           var errors = JSON.parse(xhr.responseText);
	           $fmcg("#newsletter_msg").empty().append("<p style='color:red'>"+errors.errors.email[0]+"</p>");
	            
	        }
	        });
	        
	    }
	    });
	    
	    $fmcg(".subscr").click(function(){
	            $fmcg(".shw-btn").show(1000);
	    });
	   $fmcg("#categoryButton2").click(function(){
              $fmcg(".menu-backdrop2").toggle();
        });
      $fmcg(".menu-backdrop2").click(function(){
    	    $fmcg(".menu-backdrop2").hide();
    	  });
    	  $fmcg(".menu-backdrop2").click(function(){
    	    $fmcg(".new-cat-menu").hide();
    	  });
	});
	$fmcg(document).ready(function () {
	$fmcg('.hd_srch_btn').prop('disabled', true);
	
	$fmcg('.hd_srch').on('keyup', function () {
	var serch_text = $fmcg(".hd_srch").val(); 
	if (serch_text != '' ) { 
	$fmcg('.hd_srch_btn').prop('disabled', false);
	} else {
	$fmcg('.hd_srch_btn').prop('disabled', true);
	}
	});
	});
	wow = new WOW(
	{
	animateClass: 'animated',
	offset:       100,
	callback:     function(box) {
	console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
	}
	});
	wow.init();
</script>




