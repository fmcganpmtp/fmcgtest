@extends('admin.master')
@section('title', 'Seller Creation')
@section('breadcrumb') Seller Creation @endsection
@section('content')
<style>
  input[type="time"]::-webkit-calendar-picker-indicator {
  display: none !important;
}
</style>

 <?php 
          if(!empty($seller))  
           {      
                      $name=$seller->name;
                      $surname=$seller->surname;
                      $email=$seller->email;
                      $company_name=$seller->BuyerCompany->company_name??'';
                      $company_street=$seller->BuyerCompany->company_street??'';
                      $company_zip=$seller->BuyerCompany->company_zip??'';
                      $gst_no=$seller->BuyerCompany->gst_no??'';
                      $registration_number=$seller->BuyerCompany->registration_no??'';
                      $company_location=$seller->BuyerCompany->company_location??'';
                      $company_type=$seller->BuyerCompany->company_type??'';
                      $about_company=$seller->BuyerCompany->about_company??'';
                      $position=$seller->position;
                      $country_id=$seller->country_id;
                      $default_password=$seller->default_password;
                      $user_id=$seller->id;
                      $opSundayhr=$SunOpen_am_pm =$clSundayhr = $SunClose_am_pm= $chSunday= $opMondayhr= $MonOpen_am_pm =$clMondayhr =$MonClose_am_pm =$chMonday =$opTuesdayhr=  $TueOpen_am_pm =$clTuesdayhr =$TueClose_am_pm=  $chTuesday= $opWednesdayhr =$WedOpen_am_pm= $clWednesdayhr= $WedClose_am_pm =$chWednesday= $opThursdayhr= $ThuOpen_am_pm=$clThursdayhr = $ThuClose_am_pm=  $chThursday= $opFridayhr= $FriOpen_am_pm = $clFridayhr =$FriClose_am_pm = $chFriday = $opSaturdayhr =$SatOpen_am_pm =$SatClose_am_pm= $clSaturdayhr=$chSaturday="";

                $accepted_payments="";
                if(!empty($seller->BuyerCompany->accepted_payments) ) 
                    $accepted_payments = $seller->BuyerCompany->accepted_payments;

                 $languages_speak ="";
                if(!empty($seller->BuyerCompany->languages_speak) ) 
                   $languages_speak = $seller->BuyerCompany->languages_speak; 


                 $deliver_options=""; 
                 
                 if(!empty($seller->BuyerCompany->deliver_options) ) 
                   $deliver_options = $seller->BuyerCompany->deliver_options; 
    

                 foreach($SellerOpeningTimes as $SellerOpeningTime ) {


                if( $SellerOpeningTime->day=="Sunday") {
                
                      $opSundayhr=$SellerOpeningTime->opening_time;
                      $clSundayhr =$SellerOpeningTime->closing_time;
                      $chSunday=$SellerOpeningTime->closed;
                }

                if($SellerOpeningTime->day=="Monday"){ 
                 
                      $opMondayhr=$SellerOpeningTime->opening_time;
                      $clMondayhr =$SellerOpeningTime->closing_time;
                      $chMonday =$SellerOpeningTime->closed;
                    
                  }
                 if($SellerOpeningTime->day=="Tuesday"){
              
                   
                      $opTuesdayhr= $SellerOpeningTime->opening_time;
                      $clTuesdayhr =$SellerOpeningTime->closing_time;
                      $chTuesday=$SellerOpeningTime->closed;

                  
                }
                if($SellerOpeningTime->day=="Wednesday"){
                
                      $opWednesdayhr =$SellerOpeningTime->opening_time;
                      $clWednesdayhr= $SellerOpeningTime->closing_time;
                      $chWednesday=$SellerOpeningTime->closed;
                 
               }
               if($SellerOpeningTime->day=="Thursday")
               {
               
                      $opThursdayhr=$SellerOpeningTime->opening_time;
                      $clThursdayhr =$SellerOpeningTime->closing_time;
                      $chThursday=$SellerOpeningTime->closed;
                
              }
              if($SellerOpeningTime->day=="Friday")
              { 
                
                               
                      $opFridayhr=$SellerOpeningTime->opening_time;
                      $clFridayhr =$SellerOpeningTime->closing_time;
                      $chFriday =$SellerOpeningTime->closed;
                
              }
                if($SellerOpeningTime->day=="Saturday")
                {
                      $opSaturdayhr =$SellerOpeningTime->opening_time;
                      $clSaturdayhr= $SellerOpeningTime->closing_time ;
                      $chSaturday =$SellerOpeningTime->closed;
               }
                  
            }

                      
                      $phone=$seller->phone;
                      $duty = 'Edit' ;
    }
    else
     {           $name="";
                  $surname="";
                  $email="";
                  $company_name=$company_location=$company_type=$about_company="";
                  $company_street="";
                  $company_zip="";
                  $gst_no="";
                  $registration_number="";
                  $position="";
                  $country_id=$default_password="";
                  $accepted_payments="";
                  $opSundayhr=$SunOpen_am_pm =$clSundayhr = $SunClose_am_pm= $chSunday= $opMondayhr= $MonOpen_am_pm =$clMondayhr =$MonClose_am_pm =$chMonday =$opTuesdayhr=  $TueOpen_am_pm =$clTuesdayhr =$TueClose_am_pm=  $chTuesday= $opWednesdayhr =$WedOpen_am_pm= $clWednesdayhr= $WedClose_am_pm =$chWednesday= $opThursdayhr= $ThuOpen_am_pm=$clThursdayhr = $ThuClose_am_pm=  $chThursday= $opFridayhr= $FriOpen_am_pm = $clFridayhr =$FriClose_am_pm = $chFriday = $opSaturdayhr =$SatOpen_am_pm =$SatClose_am_pm= $clSaturdayhr=$chSaturday= "";
                   $deliver_options =$languages_speak="";
                    $phone="";
                 $user_id="";      
                  $duty = 'Creation' ;
      }?>
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
      <div class="card-out mb-4 inner-form create-prof-new">
        <h2>{{$duty}} seller profile</h2>
        <div class="card-body">


         @if($duty=="Edit") 
               <form action="{{route('sellerprofile.update')}}" method="POST" enctype="multipart/form-data">
                   
         @else
               <form action="{{route('sellerprofile.store')}}" method="POST" enctype="multipart/form-data">
         @endif   
         @csrf
        
        <div class="row">
            <div class="col-lg-12 col-12">
            <div class="card">
                 <div class="card-header">Profile {{$duty}}</div>
              <div class="card-body">
          <div class="row">
              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <input type="hidden" name="user_id" value="{{$user_id}}">
                  <label> Name<sup>*</sup></label>
                  <input type="text" class="form-control  {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name',$name) }}" name="name" >
                  @if ($errors->has('name'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('name') }}</strong>
                                 </span>
                             @endif
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label> Surname<sup>*</sup></label>
                  <input type="text" class="form-control  {{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" value="{{ old('surname',$surname) }}" >
                  @if ($errors->has('surname'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('surname') }}</strong>
                                 </span>
                             @endif
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>E-mail<sup>*</sup></label>
                  <input type="text" class="form-control  {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email',$email) }}" >
                  @if ($errors->has('email'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('email') }}</strong>
                                 </span>
                             @endif
                </div>
              </div>
               <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>Position</label> 
                  
                  <input type="text" class="form-control  {{ $errors->has('position') ? ' is-invalid' : '' }}"  name="position" value="{{ old('position',$position) }}" >
                  @if ($errors->has('position'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('position') }}</strong>
                                 </span>
                             @endif
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label> Company<sup>*</sup></label>
                  
                  <input type="text" class="form-control  {{ $errors->has('company_name') ? ' is-invalid' : '' }}"  name="company_name" value="{{ old('company_name',$company_name) }}" required>
                  @if ($errors->has('company_name'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('company_name') }}</strong>
                                 </span>
                             @endif
                </div>
              </div>

               <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>Company Type<sup>*</sup></label>
                  
                  <select name="company_type" id="company_type" class="form-control  {{ $errors->has('company_type') ? ' is-invalid' : '' }}" aria-label="Default select example" required >
                    <option value="">Company Type</option>
                  @if(!empty($company_types))
                  @foreach ($company_types as $val)
                  
                    <option {{old('company_type',$company_type) == $val->id ? 'selected' : ''}} value="{{$val->id}}">{{$val->company_type}}</option>
                    
                  @endforeach 
                  @endif
                  </select>
                  @if ($errors->has('company_type')) <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('company_type') }}</strong> </span> @endif </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>Street<sup>*</sup></label>
                  
                  <input type="text" class="form-control  {{ $errors->has('company_street') ? ' is-invalid' : '' }}"  name="company_street" value="{{ old('company_street',$company_street) }}" required>
                  @if ($errors->has('company_street'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('company_street') }}</strong>
                                 </span>
                             @endif
                </div>
              </div>
              <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label>Location<sup>*</sup></label>
                      <input type="text" class="form-control  {{ $errors->has('company_location') ? ' is-invalid' : '' }}"  name="company_location" value="{{ old('company_location', $company_location)  }}" required>
                      @if ($errors->has('company_location')) <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('company_location') }}</strong> </span> @endif </div>
                  </div>
              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>Zip code<sup>*</sup></label>  
                  
                  <input type="text" class="form-control  {{ $errors->has('company_zip') ? ' is-invalid' : '' }}"  name="company_zip" value="{{ old('company_zip',$company_zip) }}" required>
                  @if ($errors->has('company_zip'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('company_zip') }}</strong>
                                 </span>
                             @endif
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>Tax Registration No.</label>
                  <input type="text" class="form-control"  name="gst_no" value="{{ old('gst_no',$gst_no) }}">
   
                </div> 
              </div>
              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>Registration No</label>
                  <input type="text" class="form-control "  name="registration_number" value="{{ old('registration_number',$registration_number) }}"> 
                 
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>Country<sup>*</sup></label>
                  
                  <select class="form-control  {{ $errors->has('country_id') ? ' is-invalid' : '' }}" aria-label="Default select example"    name="country_id" id="country_id" required>
                  <option value="">Country Name</option>
                  @foreach ($countries as $val)
                  <option value="{{$val->id}}"   @if($val->id==old('country_id',$country_id))) selected="selected"  @endif >{{$val->name}}</option>
                  @endforeach 
                  </select>
                  @if ($errors->has('country_id'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('country_id') }}</strong>
                                 </span>
                             @endif
                </div>
              </div>
               
             
            </div>
            <div class="row">
              
              @if($duty != 'Edit')
              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>Password<sup>*</sup></label> 
                  
                   <input type="password" class="form-control  {{ $errors->has('default_password') ? ' is-invalid' : '' }}"  name="default_password" value="{{ old('default_password') }}" >
                  @if ($errors->has('default_password'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('default_password') }}</strong>
                                 </span>
                             @endif
                </div>
              </div>
               @endif

               <div class="col-lg-8 col-12">
                <div class="form-group">
                  <label>About Company</label>
                  <textarea name="about_company"  class="form-control {{ $errors->has('about_company') ? ' is-invalid' : '' }}"  >{{ $about_company}}</textarea>
                  @if ($errors->has('about_company')) <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('about_company') }}</strong> </span> @endif </div>
              </div>
              <div class="col-lg-12 col-12">
                <div class="form-group overflow-hidden1">
                  <label>Accepted payments methods<sup>*</sup></label>
                  </label>
                  <div class="float-end1">
<?php 

if(!empty(old('accepted_payments',$accepted_payments))){
 $accepted_payments=old('accepted_payments',$accepted_payments); 
}?>
                  <input  type="text"  class="multitags accepted_payments form-control{{ $errors->has('accepted_payments') ? ' is-invalid' : ''}}"  name="accepted_payments" style="width:100%;" value="{{$accepted_payments}}">
                    </select>
                  @if ($errors->has('accepted_payments'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('accepted_payments') }}</strong>
                                 </span>
                             @endif
                </div>
                </div>
              </div>
            </div>
            <div class="row">

              <div class="col-lg-12 col-12">
                <div class="form-group overflow-hidden1">
                  <label>Delivery option</label>
                  
                  <div class="float-end1">
                  <?php 
                  
                  if(!empty(old('deliver_options',$deliver_options))){
                  $deliver_options=old('deliver_options',$deliver_options); 
                  }?>


                  <input  type="text"  class="multitags deliver_options form-control  {{ $errors->has('deliver_options') ? ' is-invalid' : ''}}"  name="deliver_options"  style="width:100%;" value="{{$deliver_options}}">
                   </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-12">
                <div class="form-group overflow-hidden1">
                  <label>Language</label>
                  
                 

                  <div class="float-end1">
                  <?php 
                  if(!empty(old('languages_speak',$languages_speak))){
                  $languages_speak=old('languages_speak',$languages_speak); 
                  }?>
                  <input   type="text"  class="multitags languages_speak form-control {{ $errors->has('languages_speak') ? ' is-invalid' : ''}}"  name="languages_speak"  style="width:100%;" value="{{$languages_speak}}" >
                    </div>
                </div>
              </div>
            </div>

            <div class="row label-full-wth">
              <div class="col-lg-6 col-12">
                <div class="form-group pn-no">
                  <label>Phone number<sup>*</sup></label>
                  <input name="full" type="text" value="{{ old('phone',$phone) }}" id="phone" class="form-control pno05 {{ $errors->has('phone') ? ' is-invalid' : '' }} " maxlength="15"/>

                    <span  role="alert">
                                 @if($errors->has('phone'))
                                   <div class="error" style="font-size: .875em; color: #dc3545;">{{ $errors->first('phone') }}</div>
                                   @endif
                        </span>
                </div>
              </div>
              <div class="col-lg-6 col-12">
                <div class="form-group">
                  <div class="file-drop-area form-group">
                    <label>Picture upload (companies logo/picture)</label>
                    <input class="form-control" type="file" name="company_image" id="formFile" accept="image/*">
                  </div>

                   @php if($duty == 'Edit'){
                      $company_image =  $seller->BuyerCompany->company_image ?? '';
                       if(($company_image!=""))
                      $cmp_img = asset('uploads/BuyerCompany/').'/'.$company_image;
                      else
                           $cmp_img = asset('uploads/defaultImages/').'/seller.jpg';
                       
                      @endphp
                     <img src="{{ $cmp_img}}" style="width:120px;">
                   @php  } @endphp
                </div>
              </div>
            </div>
            <div class="row seller-pr25">
              <div class="col-lg-10 col-12">
                <div class="form-group overflow-hidden1 timimg-s">
                  <label>Opening hours</label>
                  <div class="row hrs-tiitle">
                    <div class="col-lg-2 col-12">
                      <div class="form-group overflow-hidden1 timimg-s">
                        <label> Week days</label>
                      </div>
                    </div>
                    <div class="col-lg-4 col-12">
                      <div class="form-group overflow-hidden1 timimg-s">
                        <label>Opening time</label>
                      </div>
                    </div>
                    <div class="col-lg-4 col-12">
                      <div class="form-group overflow-hidden1 timimg-s">
                        <label> Closing time</label>
                      </div>
                    </div>
                    <div class="col-lg-2 col-12">
                      <div class="form-group overflow-hidden1 timimg-s">
                        <label> Closed</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-2 col-12">
                      <div class="dys">Sunday</div>
                    </div>
                    <div class="col-lg-4 col-12">
                      
                       <input type="text"   value="{{old('opSundayhr',$opSundayhr) }}" name="opSundayhr" class="form-control timepicker" placeholder="Opening time">
                   
                   </div>
                    <div class="col-lg-4 col-12">


                      <input type="text"  value="{{old('clSundayhr',$clSundayhr) }}" name="clSundayhr" min="01" max="59" class="form-control timepicker" placeholder="Closing time">
                    
            </div>  
                    <div class="col-lg-2 col-12">
                      <div class="form-group overflow-hidden1 timimg-s">
                        <div class="form-check">
                          <input class="form-check-input" name="chSunday" {{ old('chSunday',$chSunday)=='Yes'?'checked':'' }} type="checkbox" value="Yes" id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckChecked"> Closed </label>
                        </div>
                      </div>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-lg-2 col-12">
                      <div class="dys">Monday</div>
                    </div>
                    <div class="col-lg-4 col-12">
                     <input type="text" value="{{old('opMondayhr',$opMondayhr) }}" name="opMondayhr" min="01" max="24" class="form-control timepicker" placeholder="Opening time">
                     
          
           </div>
                    <div class="col-lg-4 col-12">
                     <input type="text" value="{{old('clMondayhr',$clMondayhr) }}" name="clMondayhr" min="01" max="59" class="form-control timepicker" placeholder="Closing time">
                     
           </div>

                    <div class="col-lg-2 col-12">
                      <div class="form-group overflow-hidden1 timimg-s">
                        <div class="form-check">
                          <input class="form-check-input" {{ old('chMonday',$chMonday)=='Yes'?'checked':'' }} name="chMonday" type="checkbox" value="Yes" id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckChecked"> Closed </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-2 col-12">
                      <div class="dys">Tuesday</div>
                    </div>

                    <div class="col-lg-4 col-12">
                      <input type="text" value="{{old('opTuesdayhr',$opTuesdayhr) }}" name="opTuesdayhr" min="01" max="24" class="form-control timepicker" placeholder="Opening time">
                      
                    </div>
                    <div class="col-lg-4 col-12">
                      <input type="text" value="{{old('clTuesdayhr',$clTuesdayhr) }}" name="clTuesdayhr" min="01" max="59" class="form-control timepicker" placeholder="Closing time">
                     
           </div>
                    <div class="col-lg-2 col-12">
                      <div class="form-group overflow-hidden1 timimg-s">
                        <div class="form-check">
                          <input class="form-check-input" {{ old('chTuesday',$chTuesday)=='Yes'?'checked':'' }} name="chTuesday" type="checkbox" value="Yes" id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckChecked"> Closed </label>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-lg-2 col-12">
                      <div class="dys">Wednesday</div>
                    </div>
                    <div class="col-lg-4 col-12">
                      <input type="text" value="{{old('opWednesdayhr',$opWednesdayhr) }}" name="opWednesdayhr" min="01" max="24" class="form-control timepicker" placeholder="Opening time">
 
           </div>
                    <div class="col-lg-4 col-12">
                      <input type="text" value="{{old('clWednesdayhr',$clWednesdayhr) }}" name="clWednesdayhr" min="01" max="59" class="form-control timepicker" placeholder="Closing time">
                      
            </div>
                    <div class="col-lg-2 col-12">
                      <div class="form-group overflow-hidden1 timimg-s">
                        <div class="form-check">
                          <input class="form-check-input" {{ old('chWednesday',$chWednesday)=='Yes'?'checked':'' }} name="chWednesday" type="checkbox" value="Yes" id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckChecked"> Closed </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-2 col-12">
                      <div class="dys">Thursday</div>
                    </div>

                 

                    <div class="col-lg-4 col-12">
                      <input type="text" value="{{old('opThursdayhr',$opThursdayhr) }}" name="opThursdayhr" min="01" max="24" class="form-control timepicker" placeholder="Opening time">
                      
           </div>
                    <div class="col-lg-4 col-12">
                     <input type="text" value="{{old('clThursdayhr',$clThursdayhr) }}" name="clThursdayhr" min="01" max="59" class="form-control timepicker" placeholder="Closing time">
                    
           </div>
                    <div class="col-lg-2 col-12">
                      <div class="form-group overflow-hidden1 timimg-s">
                        <div class="form-check">
                          <input class="form-check-input" {{ old('chThursday',$chThursday)=='Yes'?'checked':'' }} name="chThursday" type="checkbox" value="Yes" id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckChecked"> Closed </label>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-2 col-12">
                      <div class="dys">Friday</div>
                    </div>
                    <div class="col-lg-4 col-12">
                      <input type="text" value="{{old('opFridayhr',$opFridayhr) }}" name="opFridayhr" min="01" max="24" class="form-control timepicker" placeholder="Opening time">
                      
            </div>
                    <div class="col-lg-4 col-12">
                       <input type="text" value="{{old('clFridayhr',$clFridayhr) }}" name="clFridayhr" min="01" max="59" class="form-control timepicker" placeholder="Closing time">
                      
            </div>
                    <div class="col-lg-2 col-12">
                      <div class="form-group overflow-hidden1 timimg-s">
                        <div class="form-check">
                          <input class="form-check-input" {{ old('chFriday',$chFriday)=='Yes'?'checked':'' }} name="chFriday" type="checkbox" value="Yes" id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckChecked"> Closed </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-2 col-12">
                      <div class="dys">Saturday</div>

                    </div>
                    <div class="col-lg-4 col-12">
                     <input type="text" value="{{old('opSaturdayhr',$opSaturdayhr) }}" name="opSaturdayhr" min="01" max="24" class="form-control timepicker" placeholder="Opening time">
                       
           </div>
                    <div class="col-lg-4 col-12">
                      <input type="text" value="{{old('clSaturdayhr',$clSaturdayhr) }}" name="clSaturdayhr" min="01" max="59" class="form-control timepicker" placeholder="Closing time">
                     
           </div>
                    <div class="col-lg-2 col-12">
                      <div class="form-group overflow-hidden1 timimg-s">
                        <div class="form-check">
                          <input class="form-check-input" {{ old('chSaturday',$chSaturday)=='Yes'?'checked':'' }} name="chSaturday" type="checkbox" value="Yes" id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckChecked"> Closed </label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            
            
            
              <div class="row">
              <div class="col-lg-12">
               
                  <button type="submit" class="bl-btn">submit</button>
               
              </div>
            
            
            
          
            </div>
                              
             </div>
        
            </div>
           
            
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>


<link rel="stylesheet" href="{{ asset('/admin1/css/bootstrap-datetimepicker.min.css')}}">
<script src="{{ asset('/admin1/js/datepickerjquery.min.js')}}"></script>
<script src="{{ asset('/admin1/js/moment.min.js')}}"></script>
<script src="{{ asset('/admin1/js/twitter-bootstrapbootstrap.min.js')}}"></script>
<script src="{{ asset('/admin1/js/bootstrap-datetimepicker.min.js')}}"></script>

<link rel="stylesheet" href="{{ asset('/admin1/css/intlTelInput.css')}}">
<script src="{{ asset('/admin1/js/intlTelInput.min.js')}}"></script>

<script>
  var input = window.intlTelInput(document.querySelector("#phone"), {
  separateDialCode: true,
  preferredCountries:["in"],
  hiddenInput: "phone",
  utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
});

(function(jQuery) {
    jQuery(document).ready( function () {

  jQuery('.multitags').tagsinput({
    trimValue: true,
    confirmKeys: [13, 44],
    focusClass: 'my-focus-class'
  });
      
 jQuery(".timepicker").datetimepicker({
          format: "HH:mm",
          icons: {
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down"
          }
        });
     
      
    jQuery('#register').on( "click", function() {
      var full_number = input.getNumber(intlTelInputUtils.numberFormat.E164);
      jQuery("input[name='phone[full]'").val(full_number);
    });
});
})(jQuery);
        </script>

<link rel="stylesheet" href="{{ asset('/admin1/css/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{ asset('/admin1/css/tagsbootstrap.min.css')}}">
<script src="{{ asset('/admin1/js/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{ asset('/admin1/js/tether.min.js')}}"></script>


<script src="{{ asset('/admin1/js/moment.min.js')}}"></script>
<script src="{{ asset('/admin1/js/bootstrap-datetimepicker.min.js')}}"></script>

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css'>
<!-- <link rel="stylesheet" href="{{ asset('/admin1/css/font-awesome5.8.1cssall.min.css')}}">  
 -->
 <link rel="stylesheet" href="{{ asset('/admin1/css/bootstrap-datetimepicker.min.css')}}">


<style type="text/css">
  
  .label-info{
    background-color: dimgray !important;
    border-radius: 5px;
    padding: 2px;
  }
  .bootstrap-tagsinput
  {
    width: 100%;
  }
</style>

  @endsection