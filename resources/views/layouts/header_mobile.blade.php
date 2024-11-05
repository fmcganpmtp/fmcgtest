<!doctype html>
<html lang="zxx">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
      <!-- Bootstrap Min CSS -->
      <link rel="stylesheet" href="{{ asset('/mobile/css/bootstrap.min.css')}}">
      <!-- Owl Theme Default Min CSS -->
      <link rel="stylesheet" href="{{ asset('/mobile/css/owl.theme.default.min.css')}}">
      <!-- Owl Carousel Min CSS -->
      <link rel="stylesheet" href="{{ asset('/mobile/css/owl.carousel.min.css')}}">
      <!-- Remixicon CSS -->
      <!--<link rel="stylesheet" href="assets/css/remixicon.css">
         -->
      <!-- Meanmenu Min CSS -->
      <link rel="stylesheet" href="{{ asset('/mobile/css/meanmenu.min.css')}}">
      <!-- Animate Min CSS -->
      <link rel="stylesheet" href="{{ asset('/mobile/css/animate.min.css')}}">
      <link href="{{ asset('/mobile/css/chat.css')}}" rel="stylesheet">

      <link href="{{ asset('/font-awesome-4.6.3/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
      <!--<link href="assets/css/image-zoom.css" rel="stylesheet">
         -->
      <!-- Style CSS -->
      <link rel="stylesheet" href="{{ asset('/mobile/css/style.css')}}">
      <link rel="stylesheet" href="{{ asset('/mobile/css/extra.css')}}">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="{{ asset('/mobile/css/responsive.css')}}">
      <link href="{{ asset('/mobile/css/animate.css')}}" rel="stylesheet">
      <!-- Favicon -->
      <link rel="icon" type="image/png" href="{{ URL::asset('/images/favicon.png')}}">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;500;600;700;800;900&display=swap" rel="stylesheet">
      <script src="{{asset('/mobile/js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{asset('/mobile/js/jquery.min.js')}}"></script>
      <script src="{{ asset('js/jquery-ui.js')}}"></script>
      <script src="{{ asset('js/select2.min.js')}}"></script>
      <script src="{{ asset('js/bootstrap3-typeahead.min.js')}}"></script>
      <script src="{{asset('/admin1/js/sweetalert.js')}}"></script>
      <link href="{{ asset('css/jquery-ui1.css')}}" rel="stylesheet" type="text/css" media="all"/>
      <link rel="stylesheet" href="{{asset('/css/cookieconsent.css')}}" media="print" onload="this.media='all'">

      <!-- Title -->
      <title>@yield('title')</title>
		<meta name="description" content="@yield('description')">
        <meta property="og:title" content="@yield('title')" />
        <meta property="og:description" content="@yield('description')" />
        <?php $og_logo_url =   asset('images/og_logo.jpg'); ?>
        <meta property="og:image" content="{{ asset('images/og_logo.jpg') }}" />
      <script async src="https://tag.clearbitscripts.com/v1/pk_0d9018251a9f1ab180aed58c2059e241/tags.js" referrerpolicy="strict-origin-when-cross-origin"></script>
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-TG7NKKFFF4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-TG7NKKFFF4');
</script>
<script id="vtag-ai-js" async src="https://r2.leadsy.ai/tag.js" data-pid="2T80cbuqUotJS9AB" data-version="062024"></script>
   </head>
   <body>
      <div class="loaderajax" style="display: none;">
         <img  src="{{asset('img/loading-gif.gif')}}"/>
      </div>
      <!-- Start Preloader Area -->
      <!-- End Preloader Area -->
      <!-- Start Header Area -->
      <header class="header-area">
         <div class="header-part-1">
            <div class="container">
                
                         <?php
                        $company_logo="";			
                        foreach($view_composer_general as $general)
                        {
                        if( $general->item =='company_logo')
                        { $company_logo=$general->value; }
                        }
                        if(!empty($company_logo)) $img_url =asset('/assets/uploads/logo/'.$company_logo);
                        else $img_url =   asset('images/logo.png'); 
                        ?>
                     <div class="logo"> <a href="{{route('home')}}"> <img src="{{ $img_url }}" alt="Image"> </a> </div>
               <div class="row">
                  <div class=" col-3 flx1">
                      
                      <!--
                      <div class="mobile-responsive-menu">
							<div id='cssmenu'>
								<div id="head-mobile"></div>
								<div class="button menu-button"></div>
								<ul id="mobilemenu" class="ui-menu"></ul>
							</div>
						</div>
                      
                      -->
                      @if(!Route::is('companyDB')&&!Route::is('network') )
                     <div class="menu-btn"><a  onClick="openNav()"><i class="fa fa-caret-down" aria-hidden="true"></i>categories
<!--img src="{{ asset('/mobile/images/menu-btn.png')}}">--></a></div>
@endif
            
                  </div>
                  <div class=" col-6">
                      <div class="head-product-menu d-flex">
                           <a class="middle-menu-item d-block pt-2 px-2 {{ Route::is('home')  ? 'active' : '' }}" href="{{route('home')}}">Products</a> 
                                @if(Auth::guard('user')->check())   
                                     <a class="middle-menu-item d-block pt-2 {{ Route::is('companyDB')  ? 'active' : '' }}" href="{{route('companyDB')}}">Companies</a> 
                                @else
                                    <a class="middle-menu-item  d-block pt-2 {{ Route::is('network')  ? 'active' : '' }}" href="{{route('network')}}">Companies</a> 
                                @endif
                              
                      </div>
                  </div>
                  <div class=" col-3  ">
                      
                     <div class="head-right-05">
                        <?php    $img_path = asset('uploads/defaultImages/default_avatar.png'); 
                           if(Auth::guard('user')->check()) {  
                            $usertype = Auth::guard('user')->user()->usertype;
                           	if(!empty(Auth::guard('user')->user()->profile_pic)) 
                                           $img_path = asset('/uploads/userImages/').'/'.Auth::guard('user')->user()->profile_pic; ?> 
                        
                        
                        
                       
                        
                        
                        <div class="after-login">
                            
                           <div class="navbar-option-item navbar-option-language dropdown language-option log-out-C">
                              <button class="dropdown-toggle" type="button" id="language2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 <div class="log-user">
                                    <img src="{{$img_path}}">
                                 </div>
                                 <span class="user-name01"> </span>  
                              </button>
                              
                              <div class="dropdown-menu language-dropdown-menu" aria-labelledby="language2">
									{{--	@if($view_composer_profile_menu_visible_criteria['general_companyDashboard'] == 1 )--}}
                           <a class="dropdown-item" href="{{route('MyCompanyProfile')}}"> <i class="fa fa-user" aria-hidden="true"></i> Profile </a> 
                           @if(($view_composer_profile_menu_visible_criteria['flag_blocked_active'] != true) && $view_composer_profile_menu_visible_criteria['flag2'])
                           <a class="dropdown-item" href="{{route('companyDB')}}"> <i class="fa fa-sitemap" aria-hidden="true"></i> Network </a> 
                           <a class="dropdown-item" href="{{route('seller.products')}}"> <i class="fa fa-plus-square" aria-hidden="true"></i>Manage Products </a>
                           <a class="dropdown-item" href="{{route('BusinessInsight')}}"> <i class="fa fa-signal" aria-hidden="true"></i> Insights </a>
                           @endif
                           @if((Auth::guard('user')->user()->seller_type!='Co-Seller')  && $view_composer_profile_menu_visible_criteria['flag2'] == true)
                              <a class="dropdown-item" href="{{route('seller.kyc.approval')}}"> <i class="fa fa-clone" aria-hidden="true"></i> KYC approval @if(Auth::guard('user')->user()->varification_status!="varified" )<i class="fa fa-exclamation notific" aria-hidden="true" ></i>@endif</a>
                           @endif
									@if(($view_composer_profile_menu_visible_criteria['flag_blocked_active'] != true) && $view_composer_profile_menu_visible_criteria['flag2'])
									<!-- <a class="dropdown-item" href="{{route('seller.dashboard')}}"> <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a> -->
									@endif
								{{--	@endif  --}}
								{{-- @if($view_composer_profile_menu_visible_criteria['general_companyProfile'] == 1 )--}}
									<!-- <a class="dropdown-item" href="{{route('MyCompanyProfile')}}"> <i class="fa fa-user" aria-hidden="true"></i> My profile </a>  -->
								 {{-- @endif --}}
									@if((Auth::guard('user')->user()->seller_type!='Co-Seller')  && $view_composer_profile_menu_visible_criteria['flag2'] == true)
									<!-- <a class="dropdown-item" href="{{route('seller.kyc.approval')}}"> <i class="fa fa-clone" aria-hidden="true"></i> KYC approval @if(Auth::guard('user')->user()->varification_status!="varified" )<i class="fa fa-exclamation notific" aria-hidden="true" ></i>@endif</a> -->
									@endif
									@if(($view_composer_profile_menu_visible_criteria['flag_blocked_active'] != true) && $view_composer_profile_menu_visible_criteria['flag2'])
									{{-- @if($view_composer_profile_menu_visible_criteria['network_expand'] == 1)--}}
									{{-- <a class="dropdown-item" href="{{route('user.mynetwork')}}"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i>My Networks </a>--}}
									 <!-- <a class="dropdown-item" href="{{route('companyDB')}}"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Company Database </a> -->
									 
									{{-- @endif --}}
									@if( $view_composer_profile_menu_visible_criteria['general_companyDashboard'] == 1 && Auth::guard('user')->user()->seller_type!='Co-Seller' ) 
								<!--	<a class="dropdown-item" href="{{route('user.listcosellers')}}"> <i class="fa fa-toggle-on" aria-hidden="true"></i> Manage Co-Users </a> -->
									@endif
									
								{{--	@if($view_composer_profile_menu_visible_criteria['prd_menu_visble'] == 1 || $view_composer_profile_menu_visible_criteria['active_product_count'] >0)--}}
									<!-- <a class="dropdown-item" href="{{route('seller.products')}}"> <i class="fa fa-plus-square" aria-hidden="true"></i> Product </a> -->
								{{--	@endif --}}
									
								{{--	@if($view_composer_profile_menu_visible_criteria['market_productRequests'] == 1 || $view_composer_profile_menu_visible_criteria['market_createProductRequests'] ==1) --}}
									<!-- <a class="dropdown-item" href="{{ route('Product.Requests')}}"> <i class="fa fa-tasks" aria-hidden="true"></i> Product requests </a> -->
								{{--	@endif--}}
									@endif
									
									<a class="dropdown-item" href="{{ route('package.listing')}}"> <i class="fa fa-tasks" aria-hidden="true"></i> Subscription </a>
									
									<a class="dropdown-item" href="{{route('logout')}}"> <i class="fa fa-sign-out" aria-hidden="true"></i>Log out </a> 
								</div>
                              
                              
                              
                               @if($view_composer_profile_menu_visible_criteria['flag_blocked_active'] != true)
								@if($usertype !="guest" && $view_composer_profile_menu_visible_criteria['flag2'] == true)
 <!--                             <ul class="head-right  home-demo">-->
 <!--                                 <li class="wish-list wish_show">-->
 <!--                                     <a href="{{ route('WishlistItems')}}"><i class="fa fa-heart" aria-hidden="true">-->
 <!--</i><br>-->
	<!--									<div class="wish-count wishlist_count" @php if($view_composer_wishCount==0) {  echo 'style="display:none;"'; } @endphp>{{ $view_composer_wishCount ?? "" }}-->
	<!--						            </div>-->
	<!--						          </a>-->
	<!--						      </li>-->
							   
	<!--						@if( $view_composer_profile_menu_visible_criteria['network_chat'] == 1)      -->
	<!--						<li class="wish-list"><a href="javascript:void(0)" id="loadChatWindow"><img src="{{ asset('images/chat-ic-03.png') }}"> <br>-->
	<!--						@if($view_composer_chact_unreadcnt!=0)-->
	<!--						<div class="chat-count wish-count">{{ $view_composer_chact_unreadcnt}}</div>-->
	<!--						@else-->
	<!--						<div class="chat-count wish-count" style="display:none;"></div>-->
	<!--						@endif-->
	<!--						</a></li>-->
	<!--						@else-->
 <!--                            <li class="wish-list"><a href="javascript:void(0)" onclick="showerrorchat()"><img src="{{ asset('images/chat-ic-03.png') }}"></a></li>-->
 <!--                           @endif-->
 <!--                           --> 
 <!--                             </ul>-->
                              @endif
							@endif
                           </div>
                           
                           
                           
                           
                           
                           
                           
                           
                           
                        </div>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        <?php } else { ?>
                        <!--<ul class="head-right  home-demo">-->
                        <!--   <li><a href="{{route('user-login')}}"><i class="fa fa-user" aria-hidden="true"></i></a></li>-->
                         <!--  <li><a href="{{ route('user-register') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a></li>-->
                        <!--</ul>-->
                        <div class="dropdown menu-button-mob mt-2">
  <a class="dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="fa fa-bars" aria-hidden="true"></i>
  </a>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a class="dropdown-item" href="{{url('about-us')}}"><i class="fa fa-info-circle" aria-hidden="true"></i> About Us</a></li>
    <li><a class="dropdown-item" href="{{route('pricing')}}"><i class="fa fa-tag" aria-hidden="true"></i>Pricing</a></li> 
    <li><a class="dropdown-item" href="{{route('user-login')}}"><i class="fa fa-user" aria-hidden="true"></i>Sign in </a></li>
	<li><a class="dropdown-item" href="{{ route('user-register') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Register </a></li>
	<li><button class="btn btn-warning"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">Request Demo</button></li>
  </ul>
</div>
                        <?php } ?>
                     </div>
                     
                  </div>
                  
               </div>
            </div>
         </div>
         <!--header-part-->
         <div class="home-top-search">
            <div class="container">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="top-sech">
                         <?php
								$search_key_value = Request::get('search_key');
								if(!empty($search_key))
									$search_key_value = $search_key;
								if(!empty($category_Name_fr_slug))
									$search_key_value = $category_Name_fr_slug; ?>
									<form class="search-box" action="{{route('headsearch')}}">
                           @if(!Route::is('companyDB')&&!Route::is('network') )
								<input type="text"  name="search" autocomplete="off" id="search" class="form-control input-lg  {{ $errors->has('search') ? ' is-invalid' : '' }} hd_srch" value="{{$search_key_value}}" placeholder="Search Products"  >
                        @else
                        <input type="text"  name="search" autocomplete="off" id="search" class="form-control input-lg  {{ $errors->has('search') ? ' is-invalid' : '' }} hd_srch" value="{{$search_key_value}}" placeholder="Search companies based on Name/Keyword"  >
                        @endif
								@if ($errors->has('search'))
								<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('search') }}</strong>
								</span>
								@endif
								<button type="submit" class="search-btn hd_srch_btn"> <i class="fa fa-search" aria-hidden="true"></i> </button>
							</form>
                     </div>
                  </div>
               </div>
            </div>
         </div>


</header>
<div class="modal fade demo-modal" id="staticBackdrop"     aria-labelledby="staticBackdropLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Request Demo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                 <div class="mb-3">
                                  <label for="exampleFormControlInput1" class="form-label">Name</label>
                                  <input type="text" class="form-control" id="request_name" placeholder="John Smith">
                                  <span id="err_request_name" style="display:none">Please enter your name</span>
                                </div>
                                <div class="mb-3">
                                  <label for="exampleFormControlInput1" class="form-label">Email address</label>
                                  <input type="email" class="form-control" id="request_email" placeholder="name@example.com">
                                  <span id="err_request_email" style="display:none">Please enter your email address</span>
                                </div>
                                <div class="mb-3">
                                  <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
                                  <input type="text" class="form-control" id="request_phone" placeholder="+1123456">
                                  <span id="err_request_phone" style="display:none">Please enter your phone number</span>
                                </div>
                                <div class="mb-3">
                                  <label for="exampleFormControlTextarea1" class="form-label">Message</label>
                                  <textarea class="form-control" id="request_message" rows="3"></textarea>
                                  
                                </div>
                                <div class="mb-3 captcha">
                                 <label for="exampleFormControlTextarea1" class="form-label">Calculate the Value</label>
                                 <span>{!! App\Http\Controllers\FrontEnd\PagesController::generateCaptcha(config('captcha.default.type')) !!}</span>
                                 <button type="button" class="btn btn-danger reload" id="reload">↻</button>
                              </div>
                              <div class="mb-3">
                                 <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha" id="captcha">
                                 <span id="err_request_captcha" style="display:none">Please enter Captcha</span>
                              </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-save" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary btn-save" id="btn_request_demo">Submit</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <script  type="text/javascript">
    var url_subpath = '{{url('product-listing')}}/';
    var $fmcg = $.noConflict();
    
$fmcg(document).on('click','#btn_request_demo',function(){
     var url_request_demo = "{{route('demorequest')}}";
     var request_name = $fmcg('#request_name').val();
     var request_email = $fmcg('#request_email').val();
     var request_phone = $fmcg('#request_phone').val();
     var request_message = $fmcg('#request_message').val(); 
     var error = 0;
     var demo_button_outer = $fmcg('#demo_button_outer').html();
     var captcha = $fmcg('#captcha').val(); 
     if(request_name==''){
         $fmcg("#err_request_name").show();
         error++;
     }else{
         $fmcg("#err_request_name").hide();
     }
     if(request_email==''){
         $fmcg("#err_request_email").show();
         error++;
     }else{
         $fmcg("#err_request_email").hide();
     }
     if(request_phone==''){
         $fmcg("#err_request_phone").show();
         error++;
     }else{
         $fmcg("#err_request_phone").hide();
     }
     if(captcha==''){
         $fmcg("#err_request_captcha").show();
         error++;
     }else{
         $fmcg("#err_request_captcha").hide();
     }
     if(error==0){
      $fmcg('#demo_button_outer').html('<img width="50px" src="{{asset('img/Loading_icon.gif')}}"/>');
        $fmcg.ajax({
               url: url_request_demo,
               type: "post",
               async:true,
               cache: false,
                data:{
    	          "_token": "{{ csrf_token() }}",
    	          'request_name':request_name,
                   'request_email':request_email,
                   'request_phone':request_phone,
                   'request_message':request_message, 
                   'captcha':captcha
                },
               dataType: 'json',
               success: function(menu_structure){
                    
                  $fmcg('.Messages_demo').html(menu_structure.message);
					   $fmcg('#demo_button_outer').html(demo_button_outer);
					   $fmcg('#request_name').val('');
					   $fmcg('#request_email').val('');
					   $fmcg('#request_phone').val('');
				       $fmcg('#request_message').val(''); 
					   $fmcg('#captcha').val(''); 
					   $fmcg('#reload').trigger('click');
        } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
               $fmcg('.Messages_demo').html('Some error occured. Please try again');
				$fmcg('#demo_button_outer').html(demo_button_outer);
             }  
   
       })  ;
    }
     
});
</script>