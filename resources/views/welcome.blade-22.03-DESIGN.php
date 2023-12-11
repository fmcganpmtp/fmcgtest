@extends('layouts.template')
<div class="home-out">
   @section('content')
   @section('title','FMCG | HOME')
   <script src="{{asset('/admin1/js/sweetalert.js')}}"></script>
   @if(Session::has('message'))
   <script>
      <?php if(Session::get('message')=="Email Verified") { ?>
        var message="<?php echo Session::get('message');?>";
      swal(message, { icon: "success",buttons: false,timer: 7000 });
      <?php } else { ?>
        var message="<?php echo Session::get('message');?>";
      swal(message, { icon: "error",buttons: false,timer: 7000 });
      <?php } ?>
       
   </script> 
   @endif
   @if(!is_null($slider))
   <section class="sliderC">
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-pause="false">
         <?php  $count = 0;  ?>
         <div class="carousel-indicators">
            @foreach ($slider->Sliderimage as $Slider_img)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$count}}" class="@if($count==0)  active @endif" aria-current="true" aria-label="Slide {{$count}}"></button>
            <?php $count++; ?>
            @endforeach 
         </div>
         <?php  $count = 0;  ?>
         <div class="carousel-inner">
            @foreach ($slider->Sliderimage as $Slider_img)  
            <div class="carousel-item @if($count==0)  active @endif" data-bs-interval="3000">
               <img src="{{ URL::asset('/assets/uploads/sliders/'.$Slider_img->image)}}"     class="d-block w-100" alt="...">
               <div class="carousel-caption">
                  <div class="banner-caption">
                     <h2>{{$Slider_img->title}}</h2>
                     <div class="banner-txt">
                        <p>{{$Slider_img->description}}</p>
                     </div>
                     @if($Slider_img->target!='')      
                     <a href="{{$Slider_img->target}}" target="_blank" class="bg-button">SHOP NOW</a>
                     @endif 
                  </div>
               </div>
            </div>
            <?php $count++; ?>
            @endforeach  
         </div>
         <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="visually-hidden">Previous</span> </button>
         <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="visually-hidden">Next</span> </button>
      </div>
   </section>
   @endif
   <!-- Start Popular Categories Area -->
   <section class="popular-categories pt-54 pb-30 wow fadeInUp d-flex align-content-center flex-wrap">
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <h1>POPULAR CATEGORIES</h1>
            </div>
         </div>
         <div class="row">
            @if(!empty($all_categories))
            @foreach($all_categories as $category)
            <div class="col-lg-2 col-6">
               <a href="{{route('Product.Listing',$category->slug)}}">
                  <div class="pop-cat-ic">
                     <div class="pop-cat-img">
                        <?php 
                           $img_url =asset('/uploads/categoryImages/'.$category->category_pic); 
                           if((is_null($category->category_pic)))
                           $img_url = asset('uploads/defaultImages/pop-ic-4.png');   
                           ?>
                        <img src="{{ $img_url }}" class="drk-img"> <img src="{{ $img_url}}" class="wt-img">
                     </div>
                     <h2>{{$category->name}}</h2>
                  </div>
               </a>
            </div>
            @endforeach
            @endif
         </div>
      </div>
   </section>
</div>
<!-- End Popular Categories Area -->
<!-- most-popular-offer -->
<section class="most-popular-offer ">
   <div class="container">
      <div class="row wow fadeInUp">
         <div class="cl-lg-12">
            <div class="main-title">
               <h2>Most popular offers</h2>
            </div>
         </div>
      </div>
      <div class="row">
         @if(!empty($products))
         @foreach($products as $product)
         <div class="col-lg-3 col-12 wow fadeInUp">
            <a  href="{{ route('view.Sproduct',$product->id)}} ">
               <div class="product-thumbnail hovereffect">
                  <div class="pro-img">
                     <?php 
                        $prd_img = URL::asset('/images/no-image.jpg');
                        foreach($product->SellerProductImage as $prod_img) {
                         if($prod_img->thumbnail=='yes')
                         $prd_img = URL::asset('/uploads/productImages/'.$prod_img->image_path);
                        }
                        ?>
                     <img src="{{ $prd_img }}">
                  </div>
                  <div class="product-title">
                     <h3>{{ $product->name ?? ''}} </h3>
                     @if($validity==true)
                     <h4>
                        @if($product->price_on_request != 'Price on request')
                        <?php echo !empty($product->Currency->symbol) ? $product->Currency->symbol : '$' ?>{{ $product->product_price ?? ''}} 
                        @if($product->price_negotiable == 'Negotiable') (Price Negotiable) @endif
                        @else
                        Price on Request @endif
                     </h4>
                     <div class="pro-no-loc">
                        <?php $user_country_id = $product->User->country_id; ?>
                        @if(!empty($user_country_id))
                        <h5> <i class="fa fa-map-marker" aria-hidden="true"></i> {{ $product->country_name }} </h5>
                        @endif
                     </div>
                     @endif 
                  </div>
               </div>
            </a>
         </div>
         @endforeach
         @endif
      </div>
   </div>
</section>
</section>
<?php 
   $middleside_adds=$welcome_page_adds->where('position','Middle');
    if(count($middleside_adds)>0){
      $status='active';
   ?>
<section class="laege-add sun-glass wow fadeInUp">
   <div class="large-add-img">
      <div id="carouselExampleControls1" class="carousel slide" data-bs-ride="carousel">
         <div class="carousel-inner">
            <?php   foreach($middleside_adds as $item){
               if($item->media_type=='Video')
                  $url_path='uploads/advertisementVideo/'.$item->media_file;
               else
                   $url_path='uploads/advertiseImages/'.$item->media_file;
               if($item->media_type=='Video')
               $url_path='uploads/advertisementVideo/'.$item->media_file;
               else
               $url_path='uploads/advertiseImages/'.$item->media_file;
               
               if($item->media_type=='Video'){?>
            <div class="carousel-item {{$status}}">
               <div class="home-video">
                  <div align="center">
                     <div class="wrapper1">
                        <video playsinline autoplay="" muted="" loop="1">
                           <source src="{{ URL::asset($url_path)}}" width="100%" type="video/mp4">
                        </video>
                     </div>
                  </div>
               </div>
            </div>
            <?php } if($item->media_type=='Image'){?>
            <div class="carousel-item {{$status}}">
               <img src="{{ URL::asset($url_path)}}">
            </div>
            <?php } if($item->media_type=='YouTube'){?>
            <div class="carousel-item {{$status}}">
               <a href="{{$item->link_url}}" target="_blank"><img src="{{ URL::asset($url_path)}}"></a>
            </div>
            <?php }  
               $status='';
               }?> 
         </div>
      </div>
   </div>
</section>
<?php }?>
<section class="featured-products">
   <div class="container">
      <div class="row wow fadeInUp">
         <div class="col-lg-12">
            <div class="main-title">
               <h2>Featured Products</h2>
            </div>
         </div>
      </div>
      <div class="row wow fadeInUp">
         <?php 
            $rightside_adds=$welcome_page_adds->where('position','Right');
            
            if(count($rightside_adds)==0)
              $col_length=12;
            else
              $col_length=9;
            ?>
         <div class="col-lg-{{$col_length}} col-12">
            <div class="row">
               <div class="best-product-slider2 owl-carousel owl-theme">
                  @if(!empty($featured_products))
                  @foreach($featured_products as $product)
                  <div class=" col-12 ">
                     <a  href="{{ route('view.Sproduct',$product->id)}} ">
                        <div class="product-thumbnail hovereffect">
                           <div class="pro-img">
                              <?php 
                                 $prd_img = URL::asset('/images/no-image.jpg');
                                 foreach($product->SellerProductImage as $prod_img) {
                                  if($prod_img->thumbnail=='yes')
                                  $prd_img = URL::asset('/uploads/productImages/'.$prod_img->image_path);
                                 }
                                 ?>
                              <img src="{{ $prd_img }}">
                           </div>
                           <div class="product-title">
                              <h3>{{ $product->name ?? ''}} </h3>
                              @if($validity==true)
                              <h4> @if($product->price_on_request != 'Price on request')
                                 <?php echo !empty($product->Currency->symbol) ? $product->Currency->symbol : '$' ?>{{ $product->product_price ?? ''}} 
                                 @if($product->price_negotiable == 'Negotiable') (Price Negotiable) @endif
                                 @else
                                 Price on Request @endif
                              </h4>
                              <div class="pro-no-loc">
                                 <?php  $user_country_id = $product->User->country_id;?>
                                 @if(!empty($user_country_id))
                                 <h5> <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    {{ $product->country_name }}  
                                 </h5>
                                 @endif
                              </div>
                              @endif 
                           </div>
                        </div>
                     </a>
                  </div>
                  @endforeach
                  @endif
               </div>
            </div>
         </div>
         <?php 
            if(count($rightside_adds)!=0){ $status='active';?>
         <div class="col-lg-3 col-12">
            <div id="carouselExampleControls2" class="carousel slide" data-bs-ride="carousel">
               <div class="carousel-inner">
                  <?php   foreach($rightside_adds as $item){
                     if($item->media_type=='Video')
                       $url_path='uploads/advertisementVideo/'.$item->media_file;
                     else
                       $url_path='uploads/advertiseImages/'.$item->media_file;
                     
                     if($item->media_type=='Video'){?>
                  <div class="carousel-item {{$status}}">
                     <div class="home-video">
                        <div align="center">
                           <div class="wrapper1">
                              <video playsinline autoplay="" muted="" loop="">
                                 <source src="{{ URL::asset($url_path)}}" width="100%" type="video/mp4">
                              </video>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php } if($item->media_type=='Image'){?>
                  <div class="carousel-item {{$status}}">
                     <div class="rt-imageC">
                        <img src="{{ URL::asset($url_path)}}">
                     </div>
                  </div>
                  <?php } if($item->media_type=='YouTube'){?>
                  <div class="carousel-item {{$status}}">
                     <a href="{{$item->link_url}}" target="_blank">
                        <div class="rt-imageC"> 
                           <img src="{{ URL::asset($url_path)}}">
                        </div>
                     </a>
                  </div>
                  <?php }  $status='';}?> 
               </div>
            </div>
         </div>
         <?php } ?>
      </div>
   </div>
</section>
<?php 
   if(!Auth::guard('user')->check())
     $user_type_status="Not_register";
   else if(Auth::guard('user')->check())
   {
     if(Auth::guard('user')->user()->usertype=="guest")
       $user_type_status="Not_register";
     else
        $user_type_status="registered";
   }
   if($user_type_status=="Not_register"){
   ?>
<section class="home-reg wow fadeInUp">
   <div class="home-reg-middle">
      <div class="container">
         <div class="row">
            <div class="col-lg-4 col-12">
               <div class="reg-lft">
                  <div class="rg-left-txt">
                     <h2>INCREASE YOUR<br />SALES OR FIND <br />
                        THE BEST DEALS<br />
                        ON FMCG LAND
                     </h2>
                     <!--           <span>buy cheap on</span> </h2>
                        <h3>fmcgland</h3>
                        <a href="" class="default-btn">register now</a>-->
                  </div>
                  <!--   <div class="rg-left-img"><img src="assets/images/rg-left-image.jpg"></div>-->
               </div>
            </div>
            <div class="col-lg-8 col-12">
               <div class="reg-right">
                  <div class="reg-right-inner">
                     <h4>JOIN OUR GROUP OF SATISFIED USERS</h4>
                     <h5>REGISTER NOW FOR FREE!</h5>
                     <a href="{{ route('user-register') }}" class="default-btn">I Want to Sell</a> <a href="{{ route('user-register') }}" class="default-btn">I Want to buy</a> 
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<?php } else{?>
<section class="home-reg home-reg-2 wow fadeInUp">
   <div class="home-reg-middle">
      <div class="container">
         <div class="row">
            <div class="col-lg-1 col-12">
               <div class="reg-lft">
               </div>
            </div>
            <div class="col-lg-10 col-12">
               <div class="reg-right">
                  <div class="reg-right-inner">
                     <h4>Welcome to FMCG Land</h4>
                     <h5>
                        The go-to destination to expand<br/>
                        your business like nowhere else.
                     </h5>
                     <h6>
                        Enjoy exploring our platform!
                     </h6>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<?php }?>

<section class="reseller-offers">
   <div class="container">
      <div class="row wow fadeInUp">
         <div class="col-lg-12">
            <div class="main-title">
               <h2>newly joined companies</h2>
            </div>
         </div>
      </div>
      <div class="row">
         @foreach ($newest_company as $company)
         @php
         if(($company->company_image!=""))
			$cmp_img = asset('uploads/BuyerCompany/').'/'.$company->company_image;
         else 
			$cmp_img = asset('uploads/defaultImages/seller.jpg');
			$abount_count=strlen($company->about_company) ;     
         if($abount_count>100)
			$abouts=substr($company->about_company,0,100)." ....";
         else
			$abouts=substr($company->about_company,0,100);    
         @endphp
         <div class=" col-lg-6 col-12 ">
            <a href="{{route('ViewSeller.profile',$company->user_id)}}">
               <div class="new-joinC">
                  <div class="row">
                     <div class="col-lg-8 col-12 o1">
                        <div class="left-njc">
                           <div class="njc-logo"><img src="{{$cmp_img}}"></div>
                           <h3>{{$company->company_name}}</h3>
                           <h4>{{$abouts}}</h4>
                        </div>
                     </div>
                     <div class="col-lg-4 col-12 o2">
                        <div class="njC"><img src="{{$company->product_image}}"></div>
                     </div>
                  </div>
               </div>
            </a>
         </div>
         @endforeach
      </div>
   </div>
   </div>
</section>










@if (count($site_testimonials) > 0) {
<section class="testi wow fadeInUp">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <h2>TESTIMONIAL<br/>
               <span>What Our Customers are Saying </span> 
            </h2>
         </div>
      </div>
      <div class="row">
         <div class="testimonial-slider owl-carousel owl-theme">
            @foreach($site_testimonials as $site_testimonial)
            <div class=" col-12">
               <div class="testiBx">
                  <div class="test-txt">
                     <p>{{$site_testimonial->comments}}</p>
                  </div>
                  <div class="tst-Ct">
                     <div class="testimonial-img">
                        <?php
                           if(!empty($site_testimonial->profile_pic)) 
                           $img_path = asset('/assets/uploads/testimonials/').'/'.$site_testimonial->profile_pic;
                           else  $img_path = asset('uploads/defaultImages/default_avatar.png'); ?>
                        <img class="img-center" src="{{ URL::asset($img_path)}}" alt="testimonial-img"> 
                     </div>
                     <div class="testimonial-caption">
                        <h5>{{$site_testimonial->name ?? ''}}</h5>
                        <label>{{$site_testimonial->title ?? ''}}</label>
                        <label>{{$site_testimonial->company_name ?? ''}}</label>
                        @if(!is_null($site_testimonial->star_rating))
                        <div class="star-ratings">
                           <ul class="rating">
                              <li> <i @if($site_testimonial->star_rating >= 1) class="fa fa-star" @else class="fa fa-star-o" @endif ></i> </li>
                              <li> <i @if($site_testimonial->star_rating >= 2) class="fa fa-star" @else class="fa fa-star-o" @endif></i> </li>
                              <li> <i @if($site_testimonial->star_rating >= 3) class="fa fa-star" @else class="fa fa-star-o" @endif></i> </li>
                              <li> <i @if($site_testimonial->star_rating >= 4) class="fa fa-star" @else class="fa fa-star-o" @endif></i> </li>
                              <li> <i @if($site_testimonial->star_rating >= 5) class="fa fa-star"  @else class="fa fa-star-o" @endif></i> </li>
                           </ul>
                        </div>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
         </div>
      </div>
   </div>
</section>
@endif

@endsection