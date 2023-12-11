<!doctype html>
<html lang="zxx">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="{{ URL::asset('/images/favicon.ico')}}" type="image/x-icon">
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
<!-- Bootstrap Min CSS -->
<link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css')}}">
<!-- Owl Theme Default Min CSS -->
<link rel="stylesheet" href="{{ asset('/css/owl.theme.default.min.css')}}">
<!-- Owl Carousel Min CSS -->
<link rel="stylesheet" href="{{ asset('/css/owl.carousel.min.css')}}">
<!-- Remixicon CSS -->
<link rel="stylesheet" href="{{ asset('/css/remixicon.css')}}">
<!-- Meanmenu Min CSS -->
<link rel="stylesheet" href="{{ asset('/css/meanmenu.min.css')}}">
<!-- Animate Min CSS -->
<link rel="stylesheet" href="{{ asset('/css/animate.min.css')}}">
<link href="{{ asset('/font-awesome-4.6.3/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
<!-- Style CSS -->
<link href="{{ asset('/css/image-zoom.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/css/extra.css')}}">
<link rel="stylesheet" href="{{ asset('/css/style.css')}}">
<!-- Responsive CSS -->
<link rel="stylesheet" href="{{ asset('/css/responsive.css')}}">
<link href="{{ asset('/css/animate.css')}}" rel="stylesheet">
<link href="{{ asset('/css/chat.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('/css/style_dataTable.css')}}">
<link rel="stylesheet" href="{{asset('/css/cookieconsent.css')}}" media="print" onload="this.media='all'">
<!-- Favicon -->
<link rel="icon" type="image/png" href="{{ URL::asset('/images/favicon.png')}}">
<!-- Title -->
<title>@yield('title')</title>
</head>
<body>
<!-- Start Preloader Area -->
<!-- End Preloader Area -->
<!-- Start Header Area -->
<header class="header-area">
  <!-- Start Top Header -->  
  <div class="top-header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <!--<ul class="header-left-content">
            <li> <a href="about.php"> About us </a> </li>
            <li><a href="">Advertisement</a></li>
            <li><a href="">For buyers</a></li>
            <li><a href="">For sellers</a></li>
          </ul>-->
        </div>
        <div class="col-lg-4">
          <div class="header-right-content"> <a href="mailto:contact@fmcgland.com"><i class="fa fa-envelope-o" aria-hidden="true"></i> contact@fmcgland.com</a> </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Start Top Header -->
  <!-- Start Middle Header -->
  <div class="middle-header middle-header-style-two">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-3">
			<?php  
				if(!empty($view_composer_topLogo->value)) $img_url =asset('/assets/uploads/logo/'.$view_composer_topLogo->value);
				else $img_url =   asset('images/logo.png'); 
			?>
			<div class="logo"> <a href="{{route('home')}}"> <img src="{{ $img_url }}" alt="Image"> </a> </div>
        </div>
        <div class="col-lg-4"> 
        <?php
			$search_key_value = Request::get('search_key');
			if(!empty($search_key))
				$search_key_value = $search_key;
		?>
			<form class="search-box" action="{{route('headsearch')}}"> 
             <input type="text" required name="search" autocomplete="off" id="search" class="form-control input-lg  {{ $errors->has('search') ? ' is-invalid' : '' }}" value="{{$search_key_value}}" placeholder="Search"  >
			 @if ($errors->has('search'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('search') }}</strong>
                                    </span>
                        @endif
			<button type="submit" class="search-btn"> <i class="ri-search-line"></i> </button>
			</form>

     







		</div>
        <div class="col-lg-5">
				<?php    
				if(Auth::guard('user')->check()) { 
				 $usertype = Auth::guard('user')->user()->usertype;
				
				    
				 //   $company_image =  $view_composer_user->BuyerCompany->company_image; 
                   // if(($company_image!="")) { 
				//	$img_path = asset('uploads/BuyerCompany/').'/'.$company_image;  
                 //   } 
					if(!empty(Auth::guard('user')->user()->profile_pic)) 
                    $img_path = asset('/uploads/userImages/').'/'.Auth::guard('user')->user()->profile_pic;
                    else  
                    $img_path = asset('uploads/defaultImages/default_avatar.png');
                   
					?>
					
						<div class="after-login">
            @if($usertype !="guest" && $view_composer_co_users_criteria['flag2'] == true)
							<ul class="head-right">
			 
							   <li class="wish-list wish_show"><a href="{{ route('WishlistItems')}}"><i class="fa fa-heart-o" aria-hidden="true"></i> </i><br>
								
								<div class="wish-count wishlist_count" @php if($view_composer_wishCount==0) {  echo 'style="display:none;"'; } @endphp>{{ $view_composer_wishCount ?? "" }}</div>
								</a></li>
								<li class="wish-list"><a href="javascript:void(0)" id="loadChatWindow"><i class="fa fa-comment-o" aria-hidden="true"></i> </i><br>
								
							    @if($view_composer_chact_unreadcnt!=0)
								<div class="chat-count wish-count">{{ $view_composer_chact_unreadcnt}}</div>
								@else
								<div class="chat-count wish-count" style="display:none;"></div>
								@endif
								</a></li>
							</ul>
                           @endif
							<div class="navbar-option-item navbar-option-language dropdown language-option log-out-C">
								<button class="dropdown-toggle" type="button" id="language2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									 <div class="pro-logo-out2">
									<div class="log-user  {{Auth::guard('user')->user()->varification_status=='varified' ? 'border-green' : ''}} ">
										<img class="avatar-img" src="{{$img_path}} " alt="{{Auth::User()->name ?? ''}}">
									</div>
									 @if(Auth::guard('user')->user()->varification_status=="varified")  <div class="active-tick"><i class="fa fa-check" aria-hidden="true"></i></div> @endif
									</div>
									<span class="user-name01"> {{ Auth::guard('user')->user()->name ?? '' }}</span> 
									@if(Auth::guard('user')->user()->varification_status!="varified" && $usertype=="seller" && $view_composer_co_users_criteria['flag2'] == true)<i class="fa fa-exclamation notific" aria-hidden="true" ></i>@endif
								</button>
								@if($usertype=="seller" )
								<div class="dropdown-menu language-dropdown-menu" aria-labelledby="language2"> 
									@if($view_composer_co_users_criteria['flag2'] == true)
									<a class="dropdown-item" href="{{route('seller.dashboard')}}"> <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>
									@endif  
									<a class="dropdown-item" href="{{route('ViewProfileSeller')}}"> <i class="fa fa-user" aria-hidden="true"></i> My profile </a> 
									@if($view_composer_co_users_criteria['flag2'] == true) 
									<a class="dropdown-item" href="{{route('user.mynetwork')}}"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i>My Networks </a> 
									@endif

									@if(Auth::guard('user')->user()->seller_type!='Co-Seller' && $view_composer_co_users_criteria['flag2'] == true)
									<a class="dropdown-item" href="{{route('seller.kyc.approval')}}"> <i class="fa fa-clone" aria-hidden="true"></i> KYC approval @if(Auth::guard('user')->user()->varification_status!="varified" )<i class="fa fa-exclamation notific" aria-hidden="true" ></i>@endif</a>
									@endif
									@if( $view_composer_co_users_criteria['flag'] == true && Auth::guard('user')->user()->seller_type!='Co-Seller' ) 
										  <a class="dropdown-item" href="{{route('user.listcosellers')}}"> <i class="fa fa-toggle-on" aria-hidden="true"></i> Manage co-sellers </a> 
									@endif

								<!--	<a class="dropdown-item" href="{{route('create.seller.profile')}}"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit profile </a> -->
								@if($view_composer_co_users_criteria['flag2'] == true) 
									<a class="dropdown-item" href="{{route('seller.products')}}"> <i class="fa fa-plus-square" aria-hidden="true"></i> Product </a>
								@endif
									@if( Auth::guard('user')->user()->seller_type!='Co-Seller' ) 
                  
									<a class="dropdown-item" href="{{ route('subscription.details')}}"> <i class="fa fa-tasks" aria-hidden="true"></i> Subscription details </a> 
									@endif

									<!-- <a class="dropdown-item" href="seller-Bulk-upload.php"> <i class="fa fa-upload" aria-hidden="true"></i> Bulk upload</a>  -->
									<a class="dropdown-item" href="{{route('logout')}}"> <i class="fa fa-sign-out" aria-hidden="true"></i>Log out </a> 
								</div>
								@elseif($usertype=="buyer" || $usertype =="guest")
								<div class="dropdown-menu language-dropdown-menu" aria-labelledby="language2"> 
									@if($usertype !="guest" && $view_composer_co_users_criteria['flag2'] == true)<a class="dropdown-item" href="{{route('buyer.dashboard')}}"> <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>@endif 
									@if($usertype !="guest") <a class="dropdown-item" href="{{route('ViewProfileBuyer')}}"> <i class="fa fa-user" aria-hidden="true"></i> My profile </a> 
									@else <a class="dropdown-item" href="{{route('ViewProfileGuest')}}"> <i class="fa fa-user" aria-hidden="true"></i> My profile </a> @endif
									
									
									
									@if($usertype !="guest" && Auth::guard('user')->user()->seller_type!='Co-Seller' && $view_composer_co_users_criteria['flag2'] == true)
									<a class="dropdown-item" href="{{route('seller.kyc.approval')}}"> <i class="fa fa-clone" aria-hidden="true"></i> KYC approval @if(Auth::guard('user')->user()->varification_status!="varified" )<i class="fa fa-exclamation notific" aria-hidden="true" ></i>@endif</a>
									@endif
									
									
									
									
									
									
									
									@if( Auth::guard('user')->user()->seller_type!='Co-Seller' ) 
									<a class="dropdown-item" href="{{ route('subscription.details')}}"> <i class="fa fa-tasks" aria-hidden="true"></i> Subscription details </a>
                                    @endif   
									
									
									

									 

									@if( $view_composer_co_users_criteria['flag'] == true && Auth::guard('user')->user()->seller_type!='Co-Seller' ) 
										  <a class="dropdown-item" href="{{route('user.listcosellers')}}"> <i class="fa fa-toggle-on" aria-hidden="true"></i> Manage co-buyers </a> 
									@endif 
                  @if($usertype !="guest" && $view_composer_co_users_criteria['flag2'] == true) 	 
								 <a class="dropdown-item" href="{{route('user.mynetwork')}}"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i>My Networks </a> 
									@endif
									<a class="dropdown-item" href="{{route('logout')}}"> <i class="fa fa-sign-out" aria-hidden="true"></i>Log out </a> 
								</div>
								@endif
							</div>							 
						</div>
			<?php } else { ?> 
				<ul class="head-right">
					<li><a href="{{route('user-login')}}"><i class="fa fa-user" aria-hidden="true"></i><br><b>Sign in</b></a></li>
					<li><a href="{{ route('user-register') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <br> <b>Register</b></a></li>
				</ul>
			<?php } ?>          
        </div>
      </div>
    </div>
  </div>
  <!-- Start Middle Header -->
  <!-- Start Navbar Area -->
  <div class="navbar-area navbar-area-style-two">
	<div class="mobile-responsive-nav">
      <div class="container">
        <div class="mobile-responsive-menu">        
			<div id='cssmenu'>
			  <div id="head-mobile"></div>
			  <div class="button menu-button"></div>
			  <ul class="fix-height">
				 @if(!empty($view_composer_TopmenuCats))
					@foreach($view_composer_TopmenuCats as $main)
					@if(count($main->subcategory)>0)
					<li> <a href="{{route('Product.Listing',['search_key'=>$main->slug])}}">{{$main->name}}</a>
					 @include('frontEnd/products/partial_mobile_view',['menu_items' => $main->subcategory])
					  </li>      
					@else           
					<li> <a href="{{route('Product.Listing',['search_key'=>$main->slug])}}">{{$main->name}}</a> </li>
					@endif   

					@endforeach
				 @endif 
			  </ul>
			</div>
			<div class="logo"> <a href="{{route('home')}}"><img src="{{URL::asset('images/logo.png')}}"> </a> </div>
        </div>
      </div>
    </div>
    <div class="desktop-nav">
      <div class="container">
         <nav class="navbar navbar-expand-md navbar-light">
          <div class="navbar-category">
            <button type="button" id="categoryButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ri-menu-line"></i> ALL CATEGORIES <i class="arrow-down ri-arrow-down-s-line"></i> </button>
            <div class="new-cat-menu">
              @if(!empty($view_composer_TopmenuCats))
               <ul class="menu">
                    @foreach($view_composer_TopmenuCats as $main)
                    @if(count($main->subcategory)>0)
                    <li> <a href="{{route('Product.Listing',['search_key'=>$main->slug])}}" class="sub-arrow">{{$main->name}}</a>
                      <div class="megadrop">
                         <h5>{{$main->name}}</h5>
                         <ul>
                     @include('frontEnd/products/partial_view_menu',['menu_items' => $main->subcategory])

                      </ul>
                      </div>
                      </li>      
                    @else           
                    <li> <a href="{{route('Product.Listing',['search_key'=>$main->slug])}}">{{$main->name}}</a> </li>
                    
                    @endif   

                    @endforeach
                    </ul>
              @endif           
            </div>
          </div>         
          <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
            <ul class="navbar-nav">  
                @if(!empty($view_composer_TopmenuCats_visible))
                @foreach($view_composer_TopmenuCats_visible as $visible_item)
                <li class="nav-item"><a href="{{route('Product.Listing',['search_key'=>$visible_item->category->slug])}}" class="nav-link">{{$visible_item->category->name ?? ""}}</a></li>
                @endforeach
                @endif 

                @if(!empty($view_top_content))
                @foreach($view_top_content as $item)
                <li class="nav-item"><a href="{{url($item->seo_url)}}" class="nav-link">{{$item->page}}</a></li>
                @endforeach
                @endif 
            </ul>
            <div class="others-options">
              <div class="top-social">
              <ul>
            @if(!empty($view_composer_socialIcons))
            @foreach($view_composer_socialIcons as $view_composer_socialIcon)
            @if(($view_composer_socialIcon->type=="image"))
            <li><a href="{{$view_composer_socialIcon->link}}" target="_blank"><img style="width:30px;" src="{{ URL::asset('/assets/uploads/socialmedia/'.$view_composer_socialIcon->icon)}}" >
            </a></li>
            @else
            <li><a href="{{$view_composer_socialIcon->link}}" target="_blank"><?php  echo $view_composer_socialIcon->icon; ?>
            </a></li>
            @endif
            @endforeach
                @endif
                
                </ul>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </div>  
  <!-- End Navbar Area -->
</header>