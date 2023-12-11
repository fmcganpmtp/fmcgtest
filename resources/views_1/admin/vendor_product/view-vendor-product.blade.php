@extends('admin.master')
@section('title', 'View Product')
@section('breadcrumb') View Product @endsection
@section('content')
   



 
  <div class="body flex-grow-1 px-3">
    <div class="container-lg">
      <div class="card-out mb-4 inner-form">
        <h2>Product View</h2>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 col-12">
              <div class="card ">


         <div class="card-body ">
                 
           
           <div class="row align-items-center">
            <div class="col-lg-5">
            
    
    
            <ul id="glasscase" class="gc-start">
            
            <?php $cnt=count($product->SellerProductImageTemp) ; ?>
              @if($cnt>0)
              @if(!empty($product->SellerProductImageTemp))
						  @foreach ($product->SellerProductImageTemp as $product_image)
              <li><img src="{{URL::asset('/uploads/productImages/'.'/'.$product_image->image_path)}}" /></li>
                @endforeach
                @endif  
                @else    
              <li><img src="{{URL::asset('/uploads/defaultImages/no_image.jpg')}}" /></li>
            @endif
              </ul>
              <script type="text/javascript">
                var $ = jQuery;
                (function($) {
        $(document).ready( function () {
            $('#glasscase').glassCase({ 'thumbsPosition': 'bottom', 'widthDisplay' : 560});
        });
      })(jQuery);
    </script>
            </div>
            <div class="col-lg-6">
              <div class="product-content ml-15">
                <h3> {{$product->name}}  ({{$product->product_color}}) </h3>
                <div class="product-review">
                  
                 <?php 
             $stock_status ="<span style='color:#ff0000;'>Out Of Stock</span>";
             if($product->stock_count>0 || $product->unlimited_stock=='Unlimited' )
              $stock_status ="<span style='color:green;'>In Stock</span>";
             ?>
			 
                <div class="price"> <span class="new-price">
                     @if($product->price_on_request != 'Price on request')
                        <?php echo !empty($product->Currency->symbol) ? $product->Currency->symbol : '$' ?>{{ number_format($product->product_price,3) ?? ''}} 
                        @if($product->price_negotiable == 'Negotiable') (Price Negotiable) @endif
           
           
                     @else
                        
                        <div  class="new-price1">Price on Request</div>
                   @endif
            
                    
                <ul class="product-info">
                  <li> <span>Minimal order<b>:</b></span> {{$product->minimal_order ?? "NA"}}</li>
                  <li> <span>Available quantity<b>:</b></span> <?php echo $product->unlimited_stock=='Unlimited'? 'Unlimited Stock' : ( $product->stock_count=='' ? 'N/A' : $product->stock_count+0) ;?> </li>
                  <li> <span>Country<b>:</b></span>
                {{ $company_info->Country->name ?? "NA"}}      
                </li>
                  <!--<li> <span>Grade<b>:</b></span> {{$product->product_condition==""? "NA":$product->product_condition}} </li> -->
                  <li><span> Brand/Producer<b>:</b></span> {{ $product->Productbrand->name ?? 'N/A'}} </li>
                </ul>       
              </div>
            </div>
          </div>

                </div>
         
                
        <div class="row tb ">
        
        <div class="col-lg-12">
        	<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Description </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Product Information</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="company-tab" data-toggle="tab" href="#company" role="tab" aria-controls="company" aria-selected="false">Company information</a>
  </li>

</ul>
<div class="tab-content product-details-area " id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  
  <div class="tabs_item">
                  <div class="products-details-tab-content">
                    <p><?php echo $product->product_description ?$product->product_description : ""; ?></p>
                    </div>
                </div>
  
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
  
  
  <div class="tab_content">
                
                <div class="tabs_item">
                  <div class="products-details-tab-content">
                    <ul class="additional-information">
                        <li><span>Product avaialable in:</span>
                                               
                          
									@if(!empty($product->available_countries))
										<i class="fa fa-map-marker" aria-hidden="true"></i> 
											<?php $i = 1;  ?>
												@foreach ($countries as $country)
													<?php $selectedCountries = explode(",",$product->available_countries); $len = count($selectedCountries); ?>
														@if(in_array($country->id, $selectedCountries))
														{{ $country->name }}
													<?php if($i < $len){echo ',';} $i++;?>
														@endif 
			  
												@endforeach
                                       @else N/A
									@endif 
							                      
                          </li>
                      <li><span>Etiket / label language:</span> {{$product->label_language ?? 'N/A' }}</li>
                      <li><span>SKU:</span> {{$product->SKU ?? 'N/A' }}</li>
                      <li><span>Condition:</span> {{$product->product_condition ?? 'N/A' }}</li>
                      <li><span>Color:</span> {{$product->product_color ?? 'N/A' }}</li>
                      <li><span>Size:</span> {{$product->product_size ?? 'N/A' }}</li>
                      <li><span>Weight:</span> {{$product->product_weight ?? 'N/A' }}</li>
                      <li><span>Dimensions:</span> {{$product->product_dimension ?? 'N/A' }}</li>
                      <li><span>Location:</span> {{$product->location ?? 'N/A' }}</li>
                      <li><span>Feature:</span> {{$product->feature ?? 'N/A' }}</li>
                      <li><span>Brix (%):</span> {{$product->brix ?? 'N/A' }}</li>
                      <li><span>Packaging:</span> {{$product->packaging ?? 'N/A' }}</li>
                      <li><span>Place of origin:</span> {{$product->place_of_origin ?? 'N/A' }}</li>
                      <li><span>Model Number:</span> {{$product->model_number ?? 'N/A' }}</li>
                      <li><span>Primary ingredients:</span> {{$product->primary_ingredients ?? 'N/A' }}</li>
                      <li><span>Additives:</span> {{$product->additives ?? 'N/A' }}</li>
                      <li><span>Flavor:</span> {{$product->flavor ?? 'N/A' }}</li>
                      <li><span>Certification:</span> {{$product->certification ?? 'N/A' }}</li>
                      <li><span>Volume:</span> {{$product->volume ?? 'N/A' }}</li>
                      <li><span>BBD:</span> {{$product->BBD ?? 'N/A' }}</li>
                      <li><span>Expiry date:</span> {{$product->product_expiry ?? 'N/A' }}</li>
                    </ul>
                  </div>
                </div>
                
              </div>
  </div>


   <div class="tab-pane fade" id="company" role="tabpanel" aria-labelledby="company-tab">
  
  
  <div class="tab_content">
                
                <div class="tabs_item">
                  <div class="products-details-tab-content">
                        <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <td>Company name</td>
                          <td> {{ $company_info->BuyerCompany->company_name?? ''}}</td>
                        </tr>
                        <tr>
                          <td>Name </td>
                          <td>  {{ $company_info->name?? ''}}</td>
                        </tr>
                        <tr>
                          <td>Surname</td>
                          <td> {{ $company_info->surname?? ''}}</td>
                        </tr>
                        <tr>
                          <td>Address </td>
                          <td> 
                          <?php 
                          if(!empty($company_info->address)) echo $company_info->address."<br>";
						  if(!empty($company_info->BuyerCompany->company_street)) echo $company_info->BuyerCompany->company_street."<br>"; 
						  ?></td>
                        </tr>
                        <tr>
                          <td>Zip Code </td>
                          <td> {{ $company_info->BuyerCompany->company_zip?? ''}}</td>
                        </tr>
                        <tr>
                          <td>Place </td>
                          <td> {{ $company_info->BuyerCompany->company_location?? ''}}</td>
                        </tr>
                        <tr>
                          <td>Country </td>
                          <td> {{ $company_info->Country->name?? ''}} </td>
                        </tr>
                        <tr>
                          <td>Position </td>
                          <td> {{ $company_info->position?? ''}}</td>
                        </tr>
                        <tr>
                          <td>Languages  </td>
                          <td> {{ $company_info->BuyerCompany->languages_speak?? ''}}</td>
                        </tr>
                        
                         <tr>
                          <td>Opening hours </td>
                          <td>

                       <?php   
                       $yourDate  = Carbon::now();
                       $Today = Carbon::parse($yourDate)->format('l');
                       ?>
                            @if(!empty($company_info->SellerOpeningTime))
                          <table class="table table-bordered table-2">
                          @foreach ($company_info->SellerOpeningTime as $Spening)

                          <?php
                                if($Today==$Spening->day)
                                {  
                                      if($Spening->closed=='Yes' || (is_null($Spening->opening_time)) ||  (is_null($Spening->closing_time)) )   
                                                echo "<span style='color:red;'>Closed</span>";
                                                else
                                                { 
                                                            $check = false;
                                                            $opening_time =  $Spening->opening_time." ".$Spening->Open_am_pm ;
                                                            $closing_time =   $Spening->closing_time." ".$Spening->Close_am_pm;
                                                            $check = Carbon::now()->between($opening_time, $closing_time, true);
                                                
                                                            if($check)
                                                                echo "<span style='color:green;'>Opened</span>";
                                                            else
                                                                echo "<span style='color:red;'>Closed</span>";
                                                         
                                                }
                                }
                          ?>
                                                     
                          @endforeach
                    </table>
                      @endif
                    </td>
                        </tr>
                        <tr>
                          <td>Phone number </td>
                          <td> {{ $company_info->phone?? ''}}</td>
                        </tr>
                        
                        
                      </tbody>
                    </table>
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
        </div>

      </div>
    </div>
  </div>
  </div>
  
<!-- CoreUI and necessary plugins-->
<script src="{{asset('/admin1/vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script>
<script src="{{asset('/admin1/vendors/simplebar/js/simplebar.min.js')}}"></script>
<!--newly added for file upload preview-->

<script src="{{asset('/admin1/js/image-zoom.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin1/js/custom.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
<script src="{{asset('/admin1/js/bootstrap.min.js')}}"></script>
<link href="{{asset('/admin1/vendors/@coreui/icons/css/free.min.css')}}" rel="stylesheet">

    

@endsection