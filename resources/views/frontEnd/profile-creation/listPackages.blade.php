@extends('layouts.template')
@section('title', 'List Packages')
@section('content')
<?php
$old_pkg_id ='';
if(!is_null($old_subscription))
$old_pkg_id = $old_subscription->package_id;
?>
<div class="bg-light min-vh-100  align-items-center pack-listing package-new-out">
  <!--new-pack-style-->
   
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="pack-box-03">
          <div class="top-title">
            <h2>Select Your Plan on FMCG Land</h2>
          </div>
          <div class="pack-sec-1">
            <div class="row">
              <div class="col-lg-6 col-12">
                <h3>You are just one step away from the best the FMCG industry has to offer!</h3>
                <div class="pack-top-content">
                  <p>At FMCG Land we aim to deliver you the best the FMCG industry has to offer, with a personal plan for everybody. From Premium to Free. Get instant access to the leading B2B platform connecting the global FMCG industry. With networking, job postings, and trade show information beyond buying and selling. Grow your business in a comprehensive ecosystem where everyone profits.</p>
                  <p class="top-padding50">Need any help? Contact us at: <a href="mailto:support@fmcgland.com">support@fmcgland.com</a></p>
                </div>
                <a href="#" class="yellow-btn03">START YOUR PERSONAL PLAN NOW</a> </div>
              <div class="col-lg-6 col-12">
                <div class="pack-top-img"><img src="assets/images/pack-top-image.jpg"></div>
              </div>
            </div>
          </div>
          <!--sec1-->


          <div class="sectioon-2-table">
            <div class="row">
              <div class="col-lg-12">
                <div class="pack-table">
                    <?php 
                    
                    $count = $packages->count(); 
                          if($count>0) {
                    
                    ?>
<table class="table packageListCoverTable"  cellpadding="0" cellspacing="0">
    <tr>
        <td class="out-tbl" style="margin:0px 0px; padding:0px 0px; ">
            <table class="table table-bordered">
                
                <thead>

   <tr class="">
                    <th scope="col"  class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif" > <div class="th-border"></div></th>  
					<?php  $count=0; ?>
					@foreach ($packages as $package)
        
                    <th class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==$package->id?'active-yes':'active-no' }} @endif" scope="col"> <div class="th-border"></div>
                      <div class="pack-tble-th">
                        <h4>{{$package->name}} @if($package->id != $lowestpackage->id)   ({{$package->package_validity}}) @endif</h4>
                        <div class="dip-tbl">
                          <?php 
                          $validity=12;
                          if($package->package_validity=='One year')
                          $no_of_months = 12;
                          if($package->package_validity=='6 months')
                          $no_of_months = 6;
                          if($package->package_validity=='3 months')
                          $no_of_months = 3;
                          
                          ?>
                          <?php 
                          $price=  $package->package_basic_price/$no_of_months;
                          $price=explode('.',number_format((float)$price, 2, '.', ''));
                          $price_offer=  $package->package_offer_price/$no_of_months;
                          $price_offer=explode('.',number_format((float)$price_offer, 2, '.', '')); ?>
                          @if(($package->package_offer_price != "") && ($package->package_offer_price>0))
                          
                          <span class="del-prc1">
                          <h5><span class="pak-cur">€ </span> <del>{{$price[0]}}</del></h5>
                          <h6><b><del>{{$price[1]}}</del></b><br />
                         <span>/pm</span></h6>
                          </span>
                          
                          <h5><span class="pak-cur">€ </span> {{$price_offer[0]}}</h5>  
                          <h6><b>{{$price_offer[1]}}</b><br />
                          <span>/pm</span></h6>
                          
                          @else
                          <h5><span class="pak-cur">€ </span> {{$price[0]}}</h5>
                          <h6><b>{{$price[1]}}</b><br />
                         <span>/pm</span></h6>
                          
                          
                          @endif
                            
                            
                            
                        </div>
                      </div></th>
                    @endforeach
                  </tr>
</thead>

                
                <tbody>
               
				  <tr class="gray-sel">
                    <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif"><b>General</b></td>
					@foreach ($packages as $package)
        
                    <?php $decsrpn = (strlen($package->package_description) > 200) ? substr($package->package_description,0,200).'...' : $package->package_description; ?>
                    <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==$package->id?'active-yes':'active-no' }} @endif"><div class="pkg-descr">{{$decsrpn}}</div></td>
                    @endforeach
					</tr>
                  <tr >
                    <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif">Company Profile</td>
					@foreach ($packages as $package)
        
                    <td  class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==$package->id?'active-yes':'active-no' }}@endif"><div class="{{ $package->general_companyProfile==1?'chk-green':'clode-red' }}"></div></td>
                    @endforeach
                  </tr>
                  <tr>
                    <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif">Company Dashboard</td>
					@foreach ($packages as $package)
        
                   <td  class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==$package->id?'active-yes':'active-no' }} @endif"><div class="{{ $package->general_companyDashboard==1?'chk-green':'clode-red' }}"></td>
                    @endforeach
                  </tr>
                  <tr>
                    <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif">Profile Insights</td>
					@foreach ($packages as $package)
        
                    <td  class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==$package->id?'active-yes':'active-no' }} @endif"><div class="{{ $package->general_profileInsights==1?'chk-green':'clode-red' }}"></div></td>
                    @endforeach
                  </tr>
                  <tr>
                    <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif">Access to Media Options</td>
					@foreach ($packages as $package)
                  <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==$package->id?'active-yes':'active-no' }} @endif"><div class="{{ $package->general_accesToMedia==1?'chk-green':'clode-red' }}"></div></td>
                    @endforeach
                  </tr>
                  <tr class="gray-sel">
                    <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif"><b>Marketplace</b></td>
					@foreach ($packages as $package)
        
                    <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==$package->id?'active-yes':'active-no' }} @endif"></td>
                    @endforeach
                  </tr>
                  <tr>
                    <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif">Search & find products</td>
					@foreach ($packages as $package)
        
                    <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==$package->id?'active-yes':'active-no' }} @endif"><div class="{{ $package->market_Search==1?'chk-green':'clode-red' }}"></div></td>
                    @endforeach
                  </tr>
                  <tr>
                    <td class="set-height @if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif">Product Uploads</td>
					@foreach ($packages as $package)
					<td class="marketUploads @if($currect_active_id=='') active-yes @else  {{ $currect_active_id==$package->id?'active-yes':'active-no' }} @endif">
                        <?php 
                        if($package->market_uploads!='') 
                        echo $package->market_uploads;
                        else
                        { ?>
                            <div class="unlimited un-top"><b>Unlimited</b><br />+ service FMCG Land <a href=""><i class="fa fa-info-circle" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Service"></i></a> </div>
                        <?php } ?>
                    </td>
                     @endforeach
                  </tr>
                  <tr>
                    <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif">View Product Requests</td>
					@foreach ($packages as $package)
        
                   <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==$package->id?'active-yes':'active-no' }} @endif"><div class="{{ $package->market_productRequests==1?'chk-green':'clode-red' }}"></div></td>
                    @endforeach
                  </tr>
                  <tr>
                    <td class="set-height2 @if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif">Create Product Requests </td>
					@foreach ($packages as $package)
        
                    <td class="createProductRequest @if($currect_active_id=='') active-yes @else {{ $currect_active_id==$package->id?'active-yes':'active-no' }} @endif">
                        <?php 
                        if($package->market_createProductRequests!=1) 
                        echo '<div class="clode-red"></div>';
                        else
                        echo '<div class="unlimited"><b>Unlimited</b> </div>'; ?>
                    </td>
                    @endforeach
                  </tr>
                  <tr class="gray-sel">
                    <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif"><b>Network Feed</b></td>
					@foreach ($packages as $package)
        
                   <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==$package->id?'active-yes':'active-no' }} @endif"></td>
                    @endforeach
                  </tr>
                  <tr>
                    <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif">Expand your Network</td>
					@foreach ($packages as $package)
                        <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==$package->id?'active-yes':'active-no' }} @endif"><div class="{{ $package->network_expand==1?'chk-green':'clode-red' }}"></div></td>
                    @endforeach
                  </tr>
                  <tr>
                    <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif">Chat with Network</td>
					@foreach ($packages as $package)
                     <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==$package->id?'active-yes':'active-no' }} @endif"><div class="{{ $package->network_chat==1?'chk-green':'clode-red' }}"></div></td>
                    @endforeach
                  </tr>
                  <!--
                 <tr  class="blank-tr">
                     <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==''?'active-yes':'active-no' }} @endif"></td>
                     	@foreach ($packages as $package )
                     <td class="@if($currect_active_id=='') active-yes @else {{ $currect_active_id==$package->id?'active-yes':'active-no' }} @endif"></td>
                    @endforeach
                 </tr>-->
                  <tr class="btn-tr">
                      <td class="white-bg"></td>
                      <?php $cnt=0;?>
                    @foreach ($packages as $package)
                    
                     <td class="@if($currect_active_id==$package->id) green-bg @else white-bg @endif">
                        
                       
                     
                @if($currect_active_id=='') 
                      @if($stripe_status=="Enabled" && $package->package_basic_price>0)
                            <a href="javascript:void(0)" class="default-btn table-btn"  tabindex="-1" aria-labelledby="MymodalLabel" aria-hidden="true" onclick="openCheckOutForm('{{$package->id}}','');"><span>subscribe now</span></a>
                           <!-- <a class="default-btn table-btn" href="{{route('subscription.checkout', ['pkg_id'=>$package->id, 'accounts_id'=>''])}}" ><span>subscribe now</span></a>-->
                      @else
                            <form method="post" action="{{route('cart.submit')}}" name="direct_submit">
                                   
                            @csrf
                            <input type="hidden" name="extended" value="no">
                            <input type="hidden" name="accounts_id" value="">
                            <input type="hidden" name="package_id" value="{{$package->id}}">
                            <button class="table-btn "><span>subscribe now</span></button>
                            </form>
                            
                      @endif 
                @elseif($currect_active_id==$package->id )  
                      
                      <div class="default-btn table-btn btn-white"  ><span>subscribed</span></div>
                      <?php
                      $today = Carbon::now(); 
					  $today = Carbon::createFromFormat('Y-m-d H:s:i', $today);
					  $purchsed_date = date('d - M - Y', strtotime($old_subscription->created_at)); 
                      $package_validity = $package->package_validity;
                      $Enddate =  $old_subscription->expairy_date;
                      $Enddate =  Carbon::createFromFormat('Y-m-d', $Enddate);
                      $dates_remining = $Enddate->diffInDays($today);
					  if($dates_remining<=15 && $cnt>0)
					  ?> 
                      @if($dates_remining<=15 && $cnt>0) 
						@if($package->package_basic_price>0)
						<a href="javascript:void(0)" class="default-btn table-btn no-bg-button btn-blue renew-btn1"  tabindex="-1" aria-labelledby="MymodalLabel" aria-hidden="true" onclick="openCheckOutForm('{{$package->id}}','Renew');"><span>Renew</span></a>
						@else
	                    <form method="post" action="{{route('cart.submit')}}" name="direct_submit">
                            @csrf
                            <input type="hidden" name="package_id" value="{{$package->id}}">
                            <input type="hidden" name="order_type" value="Renew">
                            <input type="hidden" name="old_pkg_id" value="{{$package->id}}">
                            <button class="btn btn-outline-info renw-nw">Renew</button>
                            </form>
	                    @endif 
					  @endif
                @else           
                     
                      @if( $package->package_basic_price>$old_subscription->current_pkg_price)
                     <a href="javascript:void(0)" class="default-btn table-btn no-bg-button btn-blue"  tabindex="-1" aria-labelledby="MymodalLabel" aria-hidden="true" onclick="openCheckOutForm('{{$package->id}}','Upgrade');"><span>Upgrade</span></a>
                     <!--<a class="default-btn table-btn" href="{{route('subscription.checkout', ['pkg_id'=>$package->id, 'accounts_id'=>''])}}" ><span>Upgrade</span></a> -->
                     @endif 
                   
                @endif  
                       
                          
                    </td>
                    <?php $cnt++; ?>
                    @endforeach
                  </tr>
                  <tr  class="blank-tr">
                     <td ></td>
                     	@foreach ($packages as $package )
                     <td >@if($currect_active_id==$package->id && $count>0) 
                     Expires on: <b>{{  date( 'M d , Y ', strtotime( $old_subscription->expairy_date ) ) }}</b>@endif</td>
                    <?php $count++; ?>
                    @endforeach
                 </tr>
                </tbody>
              </table>
        </td>
       
    </tr>
</table>






 <?php } else echo '<h3 class="no-mor-pkg" style="color:green;"> No more package to upgrade!!</h3>'; ?>                
                  
                      
                     
                </div>
                
                
                <div class="tabale-switch-c">
                <div class="switch-field table-switch"> 
  <h6> Auto-Renew</h6>
  
  <div class="switch-btn-out">
     <input type="radio" id="radio-on" name="switch" value="1" checked="">
    <label for="radio-on">On</label>
    <input  type="radio" id="radio-off" name="switch" value="0" >
    <label for="radio-off">Off</label>
    </div>
  </div>
                
     </div>           <div class="tabl-btm-txt">
                  <div class="row">
                    <div class="col-lg-6 col-12">
                      <p>Welcome to our B2B social business platform! Join a community built for connections and opportunities. Whether you're a startup, wholesaler, distributor, or corporation, our platform streamlines networking. Discover like-minded professionals, explore collaborations, and access resources effortlessly. Let's shape the future of business together!</p>
                    </div>
                    <div class="col-lg-1 col-12">
                      <div class="assistance"><img src="assets/images/Assistance svg.png" /></div>
                    </div>
                    <div class="col-lg-5 col-12">
                      <h5>Need any assistance?</h5>
                      <p>Don't hesitate to contact us now. Our Support Team will be more than willing to help you out setting up your perfect personal plan.<br/>
                        <a href="{{route('contactus')}}">Contact us now!</a></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 
 <div class="modal fade payment-conf-modal" id="exampleModa5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      
<div id="checkOutFormContent"></div>
<form  role="form"  action="{{ route('session') }}" method="post"  class="require-validation"  data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_PK') }}" id="payment-form">
@csrf
<input type="hidden" name="name" value="{{Auth::guard('user')->user()->name}}">  
<input type="hidden" name="email" value="{{Auth::guard('user')->user()->email}}">

<input type="hidden" class="amount" value="" name="amount" >
<input type="hidden" class="item" value="" name="item" >
<input type="hidden" class="order_total" name="order_total" value="">
<input type="hidden" class="package_id" name="package_id" value="">
<!--    
<div class="form-row row">
<div class="col-xs-12 form-group required">
<label class="control-label">Name on Card</label> 
<input class="form-control" size="4" type="text" required>
</div>
</div>
    
<div class="form-row row">
<div class="col-xs-12 form-group card required">
<label class="control-label">Card Number</label> 
<input autocomplete="off" class="form-control card-number" size="20" type="text" required>
</div>
</div>
    
<div class="form-row row">
<div class="col-xs-12 col-md-4 form-group cvc required">
<label class="control-label"">CVC</label> 
<input autocomplete="off" class="form-control card-cvc" placeholder="ex. 311" size="4v type="text" required>
 </div>
 <div class="col-xs-12 col-md-4 form-group expiration required">
<label class="control-label">Expiration Month</label> 
<input class="form-control card-expiry-month" placeholder="MM" size="2" type="text" required>
</div>
 <div class="col-xs-12 col-md-4 form-group expiration required">
 <label class="control-label">Expiration Year</label> 
<input class="form-control card-expiry-year" placeholder="YYYY" size="4" type="text" required>
 </div>
 </div>
    
 <div class="form-row row">
 <div class="col-md-12 error form-group hide">
 <div class="alert-danger alert">Fill all the input fields</div>
 </div>
 </div>
 -->   
  <div class="row">
 <div class="col-xs-12">
 <button class="btn btn-primary btn-lg btn-block" type="submit" id="frm_strip_sub">Subscribe</button>
 </div>
 </div>
                            
 </form>
 </div>
 </div> 
</div>
        
</div>  


        
</div>                     
                   
                    </div>
                  </div>
                </div> 
  <!--pack-end-->

<style>

.out-tbl{border-bottom:1px solid #fff!important;}
.blank-tr{border:none!important;}

.tabale-switch-c{overflow:hidden;}
.table-switch{}
.table-switch{display:table;float:right;}
.table-switch h6{text-align:center;}

.table-switch label{margin-right:0px;}

.switch-field input:checked + label{background:#4ea72e;}

.table-switch label {
    margin-right: 6px;
    padding: 8px 25px;
    border-radius: 2px !important;color:#000; border:1px solid #000;
}


th.active-no,td.active-no {
    background:rgba(102, 102, 102, 0.2);
}
td.green-bg {
    background: green;
}
td.white-bg {
    background: white;
}

.table-btn{ margin-top : 0;}
.switch-field-new{float:right;}
.tabl-btm-txt{ margin-top:50px; }





.pack-table tr{border-color:#8d8d8d;
}

.pack-table thead{border-bottom:1px solid #8d8d8d!important;
    
}

.pack-table table thead tr{ color:#000;}


.gray-sel {
    background: #e8e8e8!important;
    height: 59px; border:1px solid #000!important;
}


.pack-table .gray-sel {
    border-color: #000!important;
}

.green-bg{background:none; padding:0px;}

.table-btn{width:100%;}

.btn-tr td {
    padding: 0px!important;}
    
    .btn-tr {border-color:#fff!important;}
    


        .btn-tr td {border-color:#fff!important;}
        
        .blank-tr {border-color:#fff!important;}
                .blank-tr td {border-color:#fff!important;}
                
 .blank-tr td {
    padding: 2px !important;
}    


.gray-sel td {
    border-bottom: 0px!important;    border-top: 1.5px solid #000;
}

       .pack-table .gray-sel {
    /* border-color: #000 !important; */
    border: 0px !important;
}         

</style>








<style>
.payment-conf-modal .modal-content{ border:5px solid #0ba4e0; border-radius:15px; color:#000; padding:15px; text-align:center}
.credit-card-box h2, .payment-conf-modal h2{ font-weight:900; font-size:29px; margin-bottom:20px;}
.credit-card-box h2 span, .payment-conf-modal h2 span{ color:#0ba4e0}
.credit-card-box h3, .payment-conf-modal h3{ font-weight:300; font-size:18px;}

.credit-card-box h4, .payment-conf-modal h4{ font-weight:300; font-size:40px; margin:15px auto;}
.credit-card-box h5, .payment-conf-modal h5{ text-transform:uppercase; font-weight:bold; margin:15px auto; color:#7b7b7b;}

.credit-card-box .modal-body,  .payment-conf-modal .modal-body{ padding:0px;}

.credit-card-box .btn-close,  .payment-conf-modal .btn-close { position:absolute; right:0px; top:0px; color:#0ba4e0!important; background:none; font-size:20px; font-weight:500; opacity:1; z-index:20;}


.credit-card-box img,  .payment-Cards img{ max-width:300px;}


.payment-Cards{ margin:30px auto; display:table;}

.payment-conf-modal .modal-dialog {
        min-width:600px!important;}
		
		.payment-form { text-align:left; margin:0px auto; width:60%;}
		.payment-form input{ background:none; height:30px; border:1px solid #787878; padding-left:10px; margin-bottom:15px;}
		
		.subscribe-button{ background:#0ba4e0; color:#fff; padding:10px 25px; border-radius:10px!important; display:block; width:100%; font-size:18px!important; font-weight:bold;}
.card {
    
    border:0 none !important;
   
}
label {
    text-align: left; float:left; font-size:13px;
}









#payment-form{ text-align:left; margin:0px auto; width:70%;}
#payment-form input{ background:none; height:30px; border:1px solid #787878; padding-left:10px; margin-bottom:15px;}
		
#payment-form .alert-danger {
    color: #842029;
    background-color: #f8d7da;
    border-color: #f5c2c7;
    padding: 2px;
    font-size: 13px;
    text-align: center;
}

#payment-form .btn-block{ background:#0ba4e0; color:#fff; padding:10px 25px; font-weight:bold; border-radius:10px!important; display:block; width:100%; 
font-size:18px!important; }
.btn-block span{text-transform:none!important;font-weight:bold!important;}

.table-btn span{text-transform:capitalize;!important;font-weight:bold!important;}
.no-bg-button{border-color:#fff;}

.no-bg-button span{ background:none!important;color:#0ba4e0!important;}



.green-bg span{background:#01734f!important;color:#fff;}


.renew-btn1 span{ background:none!important;
}


.btn-tr td {
    border-color: #fff !important;
    vertical-align: text-bottom;
}



</style>

  
</div>

@endsection

@section('footer_script')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
  $fmcg(".account_li").click(function(){ 
      var accounts_id = $fmcg(this).attr('id');
      var package_id =$fmcg(this).attr('data-id');
      $fmcg('.accounts_id'+package_id).val(accounts_id);
      $fmcg(this).parents('.drpbuttonli').find('.p1').text($fmcg(this).find('a').text()); 
      $fmcg(this).parents('.drpbuttonli').find('.p1').val($fmcg(this).find('a').text()); 
   });
   


        
        
        
  function openCheckOutForm(id,order_type){ 


  $fmcg.ajax({ 
                            type : 'post',
                            url:"{{ route('GetPackageDetail') }}",
                            data:{
                              _token:'{{ csrf_token() }}',
                              'package_id':id,
                              @if($old_pkg_id!='')
                              'old_pkg_id':{{$old_pkg_id}},
                              @else
                              'old_pkg_id':"",
                              @endif
                              'order_type':order_type
                              
                              
                            },
                            success:function(data)
                            {
                                   let item = JSON.parse(data);
                                   console.log(item);
 $fmcg(".amount").val(item.order_total);
 $fmcg(".item").val(item.name);
 $fmcg(".order_total").val(item.order_total);
 $fmcg(".package_id").val(item.id);
 $fmcg("#payment-form").submit();
 /*                                  var string ='';
string += '<div class="container">';
string += '<div class="row">';
//string += '<div class="col-md-6 col-md-offset-3">';
string += '<div class="panel panel-default credit-card-box">';
string += '<div class="panel-body">';
// string += '<a href="#" class="close" data-dismiss="alert" aria-label="close">close×</a>';
string += '<a href="javascript:void(0)" class="close btn-close" data-dismiss="alert" aria-label="close" onclick="closepop()">×</a>';
@if (Session::has('success'))
string += '<div class="alert alert-success text-center">';
string += '<p>{{ Session::get("success") }}</p>';
string += '</div>';
 @endif
var  sub_url = "{{ route('session1') }}"  ; 
var stripe_key = "{{ env('STRIPE_PK') }}"; 
var email = "{{Auth::guard('user')->user()->email}}";
var name = "{{Auth::guard('user')->user()->name}}";
if(item.order_type=='Renew')
string += '<h2>Renew <span> ';
else
string += '<h2>Upgrade to<span> ';
string += item.name+' ('+item.package_validity+')</span></h2>';
if(item.remaining_amount>0)
{
string += '<h3><i class="fa fa-eur" aria-hidden="true"></i>'+item.price+' - ('+item.remaining_months+' months remaining<sup>*</sup> ';
	  
string += '<i class="fa fa-eur" aria-hidden="true"></i> '+item.last_pkg_permonth+') =</h3>';
}	  
string += '<h4><i class="fa fa-eur" aria-hidden="true"></i> '+item.order_total+'</h4>';
string += '<h5>select payment method</h5>';
	  
string += '<div class="payment-Cards"><img src="{{asset("assets/images/payment-cards.jpg")}}"></div>';
string += '<h5>credit / debit card information</h5>';

                                
                                  
                                 $fmcg('#exampleModa5').modal('show');
                                 $fmcg("#checkOutFormContent").empty();
                                 $fmcg("#checkOutFormContent").append(string);
  */                               
                                  
                                   
                            },
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
                 //$fmcg(".loaderajax").hide();
               swal(errorThrown, "", "error");
             }


                      });

}      
        
</script>

    
<script type="text/javascript">


function closepop(){
    $fmcg('#exampleModa5').modal('hide');
}

$fmcg(function() { 
   var $form = $fmcg(".require-validation");
     
  //  $fmcg('form.require-validation').on('submit', function(e) { 
      $fmcg("#payment-form").on('submit', function(e) {
        var $form = $fmcg(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
       /* $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('hide');
    
        $fmcg('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
          var $input = $fmcg(el);
          if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
          }
        });
     
        if (!$form.data('cc-on-file')) { 
          e.preventDefault();
          Stripe.setPublishableKey('pk_test_51MwMwdF94aNmqob9nKmIWt3acLn2PRNbDVaZVseKhPbWJiWAb2D9r3Y84Kw1rDvTEUxzTfPFYW3CVQjlpqTE5oYI00EGe5gwJo');
          Stripe.createToken({
            number: $fmcg('.card-number').val(),
            cvc: $fmcg('.card-cvc').val(),
            exp_month: $fmcg('.card-expiry-month').val(),
            exp_year: $fmcg('.card-expiry-year').val()
          }, stripeResponseHandler);
        } */
    
    });
      

    function stripeResponseHandler(status, response) {
        if (response.error) { 
            $fmcg('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else { 
            /* token contains id, last4, and card type */
            var token = response['id'];
                 
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
     
});
</script>
@endsection
