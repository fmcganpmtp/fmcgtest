@extends('layouts.template')
@section('title', 'Cart')
@section('content')

<sectiion class="seller-page-new no-bg">
  <div class="pr-banner">
    <!--<img src="assets/images/pr-banner.jpg">-->
  </div>
  <div class="container">
    <div class="row"> </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="pr-bottom">
          <div class="card  tp-30 wow fadeInUp"> 
		  <?php //print_r(Session::get('user_checkout_details')); ?>
      <form method="post" action="{{route('cart.submit')}}">
            <div class="row">
      
      @csrf
            <input type="hidden" name="package_id" value="{{ $package->id ?? '' }}">
            <input type="hidden" name="accounts_id" value="{{ $accounts->id ?? '' }}">
              <div class="col-lg-8 col-12">
                <div class="tableC">
                  <table class="table table-bordered">
                    <thead>
                       
                      <tr>
                      
                      
                        <th>Package name</th>
                        <th>Cost</th>
                        <th>Additional Profiles</th>
                        <th>Profile Cost</th>
                        <th>Validity</th>
                        <th>Auto renewal </th>
						@if(!empty(Session::get('last_oreder_total')))
							<th>Prev Discount </th>
						@endif
                        <th>Grand Total </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>{{ $package->name   }}
                          ({{ $package->user_type   }})</td>
                          <?php $offer_price = $package->package_offer_price ?? '';
                          if(($offer_price != "") || ($offer_price>0))
                          $basic_price=$package->package_offer_price;
                          else 
                          $basic_price=$package->package_basic_price;
                          ?>
                          <td>${{ $basic_price }}</td>
                          <?php 
                          if($package->subscription_type=="Extended") { 
                          $account_offer_price = $accounts->per_account_offer_price ?? '';
                          if(($account_offer_price != "") || ($account_offer_price>0))
                          $account_basic_price=$account_offer_price;
                          else 
                          $account_basic_price = $accounts->cost_per_account ?? '';
                          $no_of_accounts = $accounts->no_of_accounts ;
                          $profile_cost = $account_basic_price*$accounts->no_of_accounts ;
						  $grand_total = $basic_price + $profile_cost;
						  
						  if(!empty(Session::get('last_oreder_total'))) 
                          $grand_total = $basic_price + $profile_cost - Session::get('last_oreder_total');
					     
                          }
                          else {
                            $no_of_accounts = $account_basic_price = $profile_cost = "";
                            $grand_total = $basic_price ;
							if(!empty(Session::get('last_oreder_total'))) 
                            $grand_total = $basic_price - Session::get('last_oreder_total');
                          }
                          ?>

                          <td>{{ $no_of_accounts }}
                         @if($package->subscription_type=="Extended") (${{ $account_basic_price   }} / Profile) @endif</td>

                        <td>@if($package->subscription_type=="Extended") ${{ $profile_cost }} @endif</td>
                        <td>{{ $package->package_validity   }}</td>
                        <td>
						
						<?php
		  $order_type = $old_pkg_id ="";
          if(!empty(Session::get('order_type')))
          $order_type = Session::get('order_type');
		  if(!empty(Session::get('old_pkg_id')))
          $old_pkg_id = Session::get('old_pkg_id');
          if(!empty($old_pkg_id)||!empty($order_type)) { ?>
	<div class="switch-field"> 
    <input disabled type="radio" id="radio-{{$package->id}}" name="auto_renewal" value="1" {{ ($auto_renewal=="1")? "checked" : "" }} />
    <label for="radio-{{$package->id}}">On</label>
    <input disabled type="radio" id="radio-{{$package->package_id}}" name="auto_renewal" value="0" {{ ($auto_renewal=="0")? "checked" : "" }}/>
    <label for="radio-{{$package->package_id}}">Off</label>
    </div>
		<?php } else { ?>
	<div class="switch-field">
    <input type="radio" id="radio-{{$package->id}}" name="auto_renewal" value="1" checked/>
    <label for="radio-{{$package->id}}">On</label>
    <input type="radio" id="radio-{{$package->id}}2" name="auto_renewal" value="0" />
    <label for="radio-{{$package->id}}2">Off</label>
	</div>
		     <?php } ?>
 </td>
                        @if(!empty(Session::get('last_oreder_total')))
							<td>${{ Session::get('last_oreder_total') }} </td>
						@endif
						
						<td>${{ $grand_total }} </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-lg-4 col-12">
                <div class="paynment-right">
                  <h3>TOTAL</h3>
                  <ul>
                    <li>sub total<b>:</b></li>
                    <li><span>${{ $grand_total }}</span></li>
                  </ul>
                  <div class="form-group form-check">
                    <input required type="checkbox" value="yes" class="form-check-input" id="exampleCheck1" name="privacy_check">
                    <label class="form-check-label" for="exampleCheck1">I agree to the <a href="{{ route('privacy.policy') }}" target="_blank">privacy policy and terms of use</a></label>
                  </div>
                  <div class="form-group form-check">
                    <input required type="checkbox" value="yes" class="form-check-input" id="exampleCheck2" name="terms_check">
                    <label class="form-check-label" for="exampleCheck1"> I agree the <a href="{{ route('terms.condition') }}" target="_blank">terms and conditions</a></label>
                  </div>
                  
                    <!--  <button type="button" class="btn btn-success ck-out">checkout</button>-->
                    <button type="submit"  class="btn btn-success ck-out">Pay now</button>
                  
                  <h5>we accept</h5>
                  <div class="cards-C"><img src="{{ asset('/images/payment-icon2.png')}}"></div>
                </div>
              </div>
        
            </div>
			<input type="hidden" name="order_total" value="<?=$grand_total?>">
      </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
 
</sectiion>

@endsection

