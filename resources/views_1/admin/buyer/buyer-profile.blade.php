@extends('admin.master')
@section('title', 'Buyer Creation')
@section('breadcrumb') Buyer Creation @endsection
@section('content')



 <?php 
          if(!empty($seller))  
           {      
                      $name=$seller->name;
                      $surname=$seller->surname;
                      $email=$seller->email;
                      $about=$seller->about;
                      $address=$seller->address;
                      $company_name=$seller->BuyerCompany->company_name??'';
                      $company_street=$seller->BuyerCompany->company_street??'';
                      $company_location=$seller->BuyerCompany->company_location??'';
                      $company_type=$seller->BuyerCompany->company_type??''; 
                      $company_zip=$seller->BuyerCompany->company_zip??'';
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
     {            $name="";
                  $email="";
                  $company_name="";
                  $company_street="";
                  $country_id=$default_password=$address=$company_zip=$company_location=$surname=$company_type=$about="";
                  $accepted_payments="";
                  $opSundayhr=$SunOpen_am_pm =$clSundayhr = $SunClose_am_pm= $chSunday= $opMondayhr= $MonOpen_am_pm =$clMondayhr =$MonClose_am_pm =$chMonday =$opTuesdayhr=  $TueOpen_am_pm =$clTuesdayhr =$TueClose_am_pm=  $chTuesday= $opWednesdayhr =$WedOpen_am_pm= $clWednesdayhr= $WedClose_am_pm =$chWednesday= $opThursdayhr= $ThuOpen_am_pm=$clThursdayhr = $ThuClose_am_pm=  $chThursday= $opFridayhr= $FriOpen_am_pm = $clFridayhr =$FriClose_am_pm = $chFriday = $opSaturdayhr =$SatOpen_am_pm =$SatClose_am_pm= $clSaturdayhr=$chSaturday= "";
                   $languages_speak="";
                    $phone="";
                 $user_id="";      
                  $duty = 'Create' ;
      }?>


<div class="body flex-grow-1 px-3">
    <div class="container-lg">
      <div class="card-out mb-4 inner-form create-prof-new">
        <h2>{{$duty}} Buyer profile</h2>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 col-12">
            
            
            
            
       <div class="row">
        <div class="col-lg-12">
        <div class="pr-bottom">
        
        
          <div class="card">
          <div class="card-header">Personal information</div>
                  <div class="card-body">


          @if($duty=="Edit") 
               <form action="{{route('buyerprofile.update')}}" method="POST" enctype="multipart/form-data">
                   
         @else
              <form action="{{route('buyerprofile.store')}}" method="POST" enctype="multipart/form-data">
         @endif 
        
            @csrf
            <div class="row">
             <input type="hidden" name="user_id" value="{{$user_id}}">
              <div class="col-lg-12 col-12">
                <div class="row">
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label> Name <sup>*</sup></label>
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
                      <label> Surname <sup>*</sup></label>
                      <input type="text" class="form-control {{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" value="{{ old('surname', $surname)  }}">
                      @if ($errors->has('surname'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('surname') }}</strong>
                                 </span>
                             @endif
                    </div>
                  </div>
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label>Email <sup>*</sup></label>
                      <input type="text" class="form-control  {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email',$email) }}" >
                  @if ($errors->has('email'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('email') }}</strong>
                                 </span>
                             @endif
                    </div>
                  </div>
                  
                 @if($duty != 'Edit')
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label>Password <sup>*</sup></label>
                      <input type="password" class="form-control  {{ $errors->has('default_password') ? ' is-invalid' : '' }}"  name="default_password" value="{{ old('default_password',$default_password) }}" >
                  @if ($errors->has('default_password'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('default_password') }}</strong>
                                 </span>
                             @endif
                    </div>
                  </div>
                   @endif
                  <div class="col-lg-6 col-12">
                    <div class="form-group  pn-no">
                      <label>Phone <sup>*</sup></label>
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
                      <label> About</label>
                      <input type="text" class="form-control "  name="about" value="{{ old('about', $about)  }}" >
                    </div>
                  </div>
                  
                  
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label> Address <sup>*</sup></label>
                      <textArea rows="1"  name="address"   class="form-control  {{ $errors->has('address') ? ' is-invalid' : '' }}" > {{ old('address',$address) }}</textArea>
                       @if (($errors->has('address')))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{$errors->first('address') }}</strong>
                                 </span>
                             @endif
                    </div>
                  </div>

                  <div class="col-lg-6 col-12">
                      <div class="form-group">
                    <div class="file-drop-area form-group">
                      <label>Picture upload</label>
                      <input type="file"  name="profile_pic" class="file-input form-control" accept=".jfif,.jpg,.jpeg,.png,.gif">
                    </div>
                    @php if($duty == 'Edit'){
                      $user_image =  $seller->profile_pic ?? '';
                       if(($user_image!=""))
                      $user_image = asset('uploads/userImages/').'/'.$user_image;
                      else
                           $user_image = asset('uploads/defaultImages/').'/default_avatar.png';
                      @endphp
                     <img src="{{ $user_image}}" style="width:120px;">
                   @php  } @endphp
                  </div>
                    </div>
                </div>
              
              </div>
            </div>
          
          </div>
          
          </div>
        
            
        <div class="card mar-10">
            
                      <div class="card-header">Company information </div>

            
                    <div class="card-body">
            
            <div class="row">

                    <div class="col-lg-6 col-12">
                      <div class="form-group">
                        <label>   Company name<sup>*</sup></label>
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
                        <label>Street <sup>*</sup></label>
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
                        <label>Zip Code <sup>*</sup></label>
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
                        <label> Location <sup>*</sup></label>
                        <input class="form-control" type="text" name="company_location" value="{{ old('company_location',$company_location) }}" required >
                      </div>
                    </div>
                    
                    <div class="col-lg-6 col-12">
                      <div class="form-group">
                    <div class="file-drop-area form-group">
                      <label>Picture upload</label>
                      <input class="form-control" type="file" name="imgpicture" id="formFile" accept="image/*">
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
                    <div class="col-lg-6 col-12">
                      <div class="form-group">
                        <label> Preferred payments for its products <sup>*</sup></label>
                        <?php 

if(!empty(old('accepted_payments',$accepted_payments))){
 $accepted_payments=old('accepted_payments',$accepted_payments); 
}?>
                  <input  type="text"  class="multitags form-control  {{ $errors->has('accepted_payments') ? ' is-invalid' : ''}}" value="{{$accepted_payments}}" id='accepted_payments' name="accepted_payments"  style="width:100%;" >
                   
                    
                  @if ($errors->has('accepted_payments'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('accepted_payments') }}</strong>
                                 </span>
                             @endif
                </div>
                    </div>
                    
                      
                    
                    
                    <div class="col-lg-6 col-12">
                      <div class="form-group">
                        <label>The languages that he/she speaks for communication purposes </label>
                        <?php 
                   if(!empty(old('languages_speak',$languages_speak))){
                  $languages_speak=old('languages_speak',$languages_speak); 
                  }?>
                  <input  type="text"  class="multitags form-control  {{ $errors->has('languages_speak') ? ' is-invalid' : ''}}"  value="{{ $languages_speak}}" name="languages_speak"  style="width:100%;" />
                   
                  
                      </div>
                    </div>
                    
                    
                    <div class="col-lg-6 col-12">
                <div class="form-group">
                  <label>Country<sup>*</sup></label>
                  </label>
                  <select class="form-control  {{ $errors->has('country_id') ? ' is-invalid' : '' }}" aria-label="Default select example"    name="country_id" id="country_id" required>
                  <option value="">Country Name</option>
                  @foreach ($countries as $country)
                  <option value="{{$country->id}}">{{$country->name}}</option>
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


                      <input type="text"  value="{{old('clSundayhr',$clSundayhr) }}" name="clSundayhr"  class="form-control timepicker" placeholder="Closing time">
                    
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
                     <input type="text" value="{{old('opMondayhr',$opMondayhr) }}" name="opMondayhr"  class="form-control timepicker" placeholder="Opening time">
                     
          
           </div>
                    <div class="col-lg-4 col-12">
                     <input type="text" value="{{old('clMondayhr',$clMondayhr) }}" name="clMondayhr"  class="form-control timepicker" placeholder="Closing time">
                     
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
                      <input type="text" value="{{old('opTuesdayhr',$opTuesdayhr) }}" name="opTuesdayhr"  class="form-control timepicker" placeholder="Opening time">
                     
                    </div>
                    <div class="col-lg-4 col-12">
                      <input type="text" value="{{old('clTuesdayhr',$clTuesdayhr) }}" name="clTuesdayhr" class="form-control timepicker" placeholder="Closing time">
                     
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
                      <input type="text" value="{{old('opWednesdayhr',$opWednesdayhr) }}" name="opWednesdayhr"  class="form-control timepicker" placeholder="Opening time">


                      
           </div>
                    <div class="col-lg-4 col-12">
                      <input type="text" value="{{old('clWednesdayhr',$clWednesdayhr) }}" name="clWednesdayhr"  class="form-control timepicker" placeholder="Closing time">
                     
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
                      <input type="text" value="{{old('opThursdayhr',$opThursdayhr) }}" name="opThursdayhr"  class="form-control timepicker" placeholder="Opening time">
                       
           </div>
                    <div class="col-lg-4 col-12">
                     <input type="text" value="{{old('clThursdayhr',$clThursdayhr) }}" name="clThursdayhr" class="form-control timepicker" placeholder="Closing time">
                     
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
                      <input type="text" value="{{old('opFridayhr',$opFridayhr) }}" name="opFridayhr"  class="form-control timepicker" placeholder="Opening time">
                     
            </div>
                    <div class="col-lg-4 col-12">
                       <input type="text" value="{{old('clFridayhr',$clFridayhr) }}" name="clFridayhr" class="form-control timepicker" placeholder="Closing time">
                      
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
                     <input type="text" value="{{old('opSaturdayhr',$opSaturdayhr) }}" name="opSaturdayhr"  class="form-control timepicker" placeholder="Opening time">
                      
           </div>
                    <div class="col-lg-4 col-12">
                      <input type="text" value="{{old('clSaturdayhr',$clSaturdayhr) }}" name="clSaturdayhr" class="form-control timepicker" placeholder="Closing time">
                    
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
               
              </div> </div>
            </form>
              
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
     
      var country_id="{{ old('country_id',$country_id) }}";
      jQuery('#country_id').val(country_id);
      
    jQuery('#register').on( "click", function() {
 var full_number = input.getNumber(intlTelInputUtils.numberFormat.E164);
$("input[name='phone[full]'").val(full_number);
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