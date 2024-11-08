@extends('layouts.template')
@section('title', 'Edit Buyer Profile')
@section('content')
<?php 
function explodHr($opentime)
{
  $opentime = explode(":",$opentime);
  return $opentime;
}
?>
<style>
  input[type="time"]::-webkit-calendar-picker-indicator {
  display: none !important;
}
.off-ln-cat .select2-container--default .select2-selection--multiple,.cmp-type .select2-container--default .select2-selection--multiple {
  border: none !important;
  box-shadow:none!important;
}

.off-ln-cat .select2-container .select2-search--inline .select2-search__field, .cmp-type .select2-container .select2-search--inline .select2-search__field{ overflow:auto;}

.off-ln-cat .select2-container .select2-search--inline .select2-search__field,.cmp-type .select2-container .select2-search--inline .select2-search__field{height:30px;line-height:30px;}

.off-ln-cat  .select2-container .select2-selection--multiple,.cmp-type  .select2-container .select2-selection--multiple{ min-height:40px!important;  font-size: 14px;}

</style>
<sectiion class="seller-page">

  
  
  <style> 
		.edit_form{ display:none }
		.view_profile{ display:block }
		</style>
    @if($errors->any() || Session::has('message_not_match'))
      <style>
		.edit_form{ display:block !important; }
		.view_profile{ display:none !important; }
		</style>
	
	@endif()
  
  <div class="container seller-page-2 view_profile">
    <div class="row">
      <div class="col-lg-12">
      @if(Session::has('message')) <div class="alert alert-success">{{Session::get('message') }}</div> 
      @endif
   
        <div class="pr-bottom">
          <div class="card">
           
            <h3>Buyer profile</h3>
           
         <div class="row">
              <div class="col-lg-4 col-12">
                  
                   <?php 
                   //$company_image =  $user->BuyerCompany->company_image ?? '';
                  // if(($company_image!="")) 
					//$img_path = asset('uploads/BuyerCompany/').'/'.$company_image;
					if(!empty(Auth::guard('user')->user()->profile_pic)) 
                    $img_path = asset('/uploads/userImages/').'/'.Auth::guard('user')->user()->profile_pic;
                    else  $img_path = asset('uploads/defaultImages/default_avatar.png'); ?>
                <div class="pr-logo">
            <img class="prof_img" src="  {{ $img_path }} ">  </div>
  <a href="javascript:void(0)" onclick="editfrm()" class="default-btn view_profile" style="color:#fff;width: 200px;text-align: center;margin: 0 auto;">Edit Profile</a>
  
  
  
  
  
  
   <div class=" rt-form" style="margin-top:20px;">
                      <div class="form-group">
                      <label> User Status</label>
					  <select name="user_status" id="user_status" class="form-control ">
					  <option value="" @if(Auth::guard('user')->user()->user_status== "") selected @endif>Select Status</option>
					  <option value="Online" @if(Auth::guard('user')->user()->user_status== "Online") selected @endif >Online</option>
					  <option value="Away" @if(Auth::guard('user')->user()->user_status== "Away") selected @endif>Away</option>
					  <option value="Offline" @if(Auth::guard('user')->user()->user_status== "Offline") selected @endif>Offline</option>
					  <option value="Busy" @if(Auth::guard('user')->user()->user_status== "Busy") selected @endif>Busy</option>
					  
					  </select>
                      </div>
					  
					  
					 
					  </div>
  
  
  
  
  
  
  
  
            
            </div>
              <div class="col-lg-8 col-12">
                <div class="row">
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label> Name</label>
                       <span class="prof_val">{{$user->name??''}}</span>
                       </div>
					    </div>
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label> Surname</label>
                      <span class="prof_val">{{$user->surname??''}}</span>
                       </div>
					    </div>
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label>Email</label>
                   <span class="prof_val">{{$user->email??''}}</span>
                       </div>
					    </div>
                 
                  <div class="col-lg-6 col-12">
                  <div class="form-group pn-no">
                  <label>Phone number</label>
                   <span class="prof_val">{{$user->phone??''}}</span>
                       </div>
					    </div>
                 <!-- <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label> About</label>
					  <span class="prof_val">{{$user->about??''}}</span>
                    </div>
                  </div>-->
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label> Address </label>
                       <span class="prof_val">{{$user->address??''}}</span>
                    </div>
                  </div>


                  <div class="col-lg-6 col-12">
                  <div class="form-group">
                  <label>Country</label>
                 <span class="prof_val"> @foreach ($countries as $country)
                   @if($user->country_id== $country->id ) {{$country->name??''}}@endif
                    
                  @endforeach </span>
                </div>
			</div> 
			
			<div class="row">
			 <div class="col-lg-6 col-12">
                <div class="form-group overflow-hidden1">
                 <label>Hide Promotional Emails <b>:</b> </label>
                  <span class="prof_val">{{Auth::guard('user')->user()->hide_promo_email??'Yes'}}</span>
                  </div></div>
               <div class="col-lg-6 col-12">
                <div class="form-group overflow-hidden1">
               <label >Newsletter Emails<b>:</b> </label>
                    <span class="prof_val">{{ Auth::guard('user')->user()->newsletter_status??""}}</span>
              </div></div>
             </div>


                  
                </div>
              
              </div>
            </div>
          </div>
          
          
          
          
          
          
          
         
            
            
            <div class="card answer">
            <div class="row">
            
            <div class="col-lg-12"><h3>Company information </h3></div>
            </div>
            
            <div class="row">
            
            
            
           

                    <div class="col-lg-4 col-12">
                      <div class="form-group">
                        <label>   Company name</label>
                       <span class="prof_val"></span>
                </div>
			</div>
			<div class="col-lg-4 col-12">
                <div class="form-group">
                  <label>Company Type:</label>
                  <span class="prof_val"> 
                  <?php $c_types = $c_types_names =[]; ?>
                  @if(!empty(Auth::guard('user')->user()->BuyerCompany->company_type))
                   @foreach ($company_types as $company_type)
                               <?php $c_types = explode(",",Auth::guard('user')->user()->BuyerCompany->company_type);?>
                               @if(in_array($company_type->id, $c_types))
                               
                      <?php $c_types_names[] = $company_type->company_type ; ?>
                       @endif 
                   @endforeach 
                  @endif
                  <?php echo implode( ', ', $c_types_names ); ?>
                  </span>
                </div>
			</div>
                    <div class="col-lg-4 col-12">
                      <div class="form-group">
                         <label>Street: </label>
                      <span class="prof_val">{{$user->BuyerCompany->company_street ?? ''}}</span>
                </div>
			</div>
                    
                      <div class="col-lg-4 col-12">
                      <div class="form-group">
                        <label>Zip code: </label>
                      <span class="prof_val">{{$user->BuyerCompany->company_zip??''}}</span>
                </div>
			</div>
                   
                   
                   
                   
                             <div class="col-lg-4 col-12">
                      <div class="form-group">
                        <label> Location </label>
                       <label>Location: </label>
                     <span class="prof_val">{{ $user->BuyerCompany->company_location ?? ''}}</span>
                </div>
			</div>
                    
                    <div class="col-lg-4 col-12">
                <div class="form-group">
                  <label>About Company </label>
                  <span class="prof_val">{{$user->BuyerCompany->about_company??''}}</span>
                </div>
			</div>


                    <?php 
                  
          $openingTimes = $user->SellerOpeningTime ;  
          $SunOpen_am_pm = $MonOpen_am_pm = $TueOpen_am_pm = $WedOpen_am_pm = $ThusOpen_am_pm = $FriOpen_am_pm = $SatOpen_am_pm = $SunClose_am_pm = $MonClose_am_pm = $TueClose_am_pm = $WedClose_am_pm = $ThuClose_am_pm = $FriClose_am_pm = $ThuOpen_am_pm = $SatClose_am_pm =  $SunClosed = $MonClosed =  $TuesClosed = $WedClosed = $ThursClosed = $FriClosed = $SatClosed ="";
            ?>
                  @foreach($openingTimes as $openingTime ) 
                  <?php  
                  // $OpenHr= explodHr($openingTime->opening_time);
                  // $CloseHr= explodHr($openingTime->closing_time);  
                  $day =  $openingTime->day; 
                  ?>
                 
                 
                <?php  
                if($day=="Sunday") {
               
                if(!empty($openingTime->opening_time)) {
                  $SunOpenhr = $openingTime->opening_time; 
                  $SunCloseHr = $openingTime->closing_time; }
                  $SunClosed = $openingTime->closed; 
                  $SunOpen_am_pm  = $openingTime->Open_am_pm   ;  
                  $SunClose_am_pm    = $openingTime->Close_am_pm  ;
                }
                ?>
              
                  @if($openingTime->day=="Monday") 
                <?php 
                if(!empty($openingTime->opening_time)) {
                  $MonOpenhr = $openingTime->opening_time; 
                  $MonCloseHr = $openingTime->closing_time; }
                  $MonClosed = $openingTime->closed;
                  $MonOpen_am_pm  = $openingTime->Open_am_pm   ; 
                  $MonClose_am_pm    = $openingTime->Close_am_pm  ; 
                  ?>
                  @endif
                  @if($openingTime->day=="Tuesday")
                <?php  
                if(!empty($openingTime->opening_time)) { 
                  $TuesOpenhr = $openingTime->opening_time; 
                  $TuesCloseHr = $openingTime->closing_time; } 
                 $TuesClosed = $openingTime->closed;
                 $TueOpen_am_pm   = $openingTime->Open_am_pm   ; 
                 $TueClose_am_pm  = $openingTime->Close_am_pm  ; 
                  ?>
                  @endif
                  @if($openingTime->day=="Wednesday")
                <?php
                if(!empty($openingTime->opening_time)) {
                  $WedOpenhr = $openingTime->opening_time; 
                  $WedCloseHr = $openingTime->closing_time; }
                   $WedClosed = $openingTime->closed;
                   $WedOpen_am_pm    = $openingTime->Open_am_pm   ; 
                   $WedClose_am_pm   = $openingTime->Close_am_pm  ; 
                  ?>
                  @endif
                  @if($openingTime->day=="Thursday")
                <?php
                if(!empty($openingTime->opening_time)) {
                  $ThursOpenhr = $openingTime->opening_time; 
                  $ThursCloseHr = $openingTime->closing_time; }
                  $ThursClosed = $openingTime->closed;
                  $ThuOpen_am_pm  = $openingTime->Open_am_pm   ; 
                  $ThuClose_am_pm    = $openingTime->Close_am_pm  ; 
                  ?>
                  @endif
                  @if($openingTime->day=="Friday")
                <?php 
                if(!empty($openingTime->opening_time)) {
                  $FriOpenhr = $openingTime->opening_time; 
                  $FriCloseHr = $openingTime->closing_time; }
                  $FriClosed = $openingTime->closed;
                  $FriOpen_am_pm  = $openingTime->Open_am_pm   ; 
                  $FriClose_am_pm    = $openingTime->Close_am_pm  ; 
                  ?>
                  @endif
                  @if($openingTime->day=="Saturday")
                <?php  
                if(!empty($openingTime->opening_time)) {
                  $SatOpenhr = $openingTime->opening_time;
                  $SatCloseHr = $openingTime->closing_time; }
                  $SatClosed = $openingTime->closed;
                  $SatOpen_am_pm  = $openingTime->Open_am_pm   ; 
                  $SatClose_am_pm    = $openingTime->Close_am_pm  ; 
                  ?>
                  @endif  
                  
                  @endforeach
<?php
if(empty($SunOpenhr) || $SunOpenhr==":") $SunOpenhr="00:00" ; 
if(empty($SunCloseHr) || $SunCloseHr==":") $SunCloseHr="00:00" ; 
if(empty($MonOpenhr) || $MonOpenhr==":") $MonOpenhr="00:00" ; 
if(empty($MonCloseHr) || $MonCloseHr==":") $MonCloseHr="00:00" ; 
if(empty($TuesOpenhr) || $TuesOpenhr==":") $TuesOpenhr="00:00" ; 
if(empty($TuesCloseHr) || $TuesCloseHr==":") $TuesCloseHr="00:00" ;
if(empty($WedOpenhr) || $WedOpenhr==":") $WedOpenhr="00:00" ;
if(empty($WedCloseHr) || $WedCloseHr==":") $WedCloseHr="00:00" ; 
if(empty($ThursOpenhr) || $ThursOpenhr==":") $ThursOpenhr="00:00" ; 
if(empty($ThursCloseHr) || $ThursCloseHr==":") $ThursCloseHr="00:00" ; 
if(empty($FriOpenhr) || $FriOpenhr==":") $FriOpenhr="00:00" ; 
if(empty($FriCloseHr) || $FriCloseHr==":") $FriCloseHr="00:00" ; 
if(empty($SatOpenhr) || $SatOpenhr==":") $SatOpenhr="00:00" ; 
if(empty($SatCloseHr) || $SatCloseHr==":") $SatCloseHr="00:00" ; 
?>
           
                    
                      <div class="col-lg-4 col-12">
                          
                          
                      <div class="form-group">
                    <div class="file-drop-area form-group">
                      <label>Picture upload</label>
                      
                      <div class="row">
                          
                          <div class="col-lg-4">
                      
         
          

                            
                             @php    
                             
                             $cmp_img  = asset('uploads/defaultImages/seller.jpg');
                             $company_image =  $user->BuyerCompany->company_image ?? ''; @endphp
                                <?php if(($company_image!="")) {
									$cmp_img = asset('uploads/BuyerCompany/').'/'.$company_image;
									  } ?>
                                
                              <img src="<?=$cmp_img?>" >
                          
                  
                  
                    </div></div></div></div>
                    
                    
                    

               <div class="row">
                    <div class="col-lg-6 col-12">
                <div class="form-group overflow-hidden1">
                  <label>Accepted payments methods</label>
                  <?php 

           $accepted_payments="";
                if(!empty($user->BuyerCompany->accepted_payments) ) 
                    $accepted_payments = $user->BuyerCompany->accepted_payments; 
                     ?>
                     <span class="prof_val">{{$accepted_payments??''}}</span>
                </div>
			</div>
                  
				  </div>
              </div>
                    
                      
                    
                    
                      <div class="col-lg-6 col-12">
                <div class="form-group overflow-hidden1">
                  <label>Language</label>
                  <?php 

               $languages_speak="";
               if(!empty($user->BuyerCompany->languages_speak) ) 
                        $languages_speak = $user->BuyerCompany->languages_speak; 

              ?>
			  
			  <span class="prof_val">{{$languages_speak??''}}</span>
                </div>
			</div>

				 </div>
              </div>
                    
                    
                  </div>
                  
                  </div>
                  
                 
              
            </div> 

            <div class="card answer">
            <div class="row">
            
            <div class="col-lg-12"><h3>Opening Hours </h3></div>
            </div>
            
        <div class="row tm-sec">
                <div class="col-lg-3 col-12">
                  <div class="time-bx">
                    <h4>Sunday</h4>
                    <div class="row">
                     
					  @if($SunClosed=="Yes")
					<div class="col-lg-2 col-12">
                        <h5>Closed </h5>
                        
                      </div>
						@else
					<div class="col-lg-5 col-12">
                        <h5>Opening time</h5>
						{{$SunOpenhr??''}}
                       </div>
                      <div class="col-lg-5 col-12">
                        <h5>Closing time</h5>
						{{$SunCloseHr??''}}
                       
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="time-bx">
                    <h4>Monday</h4>
					
					
					<div class="row">
                     
					  @if($MonClosed=="Yes")
					<div class="col-lg-2 col-12">
                        <h5>Closed </h5>
                        
                      </div>
						@else
					<div class="col-lg-5 col-12">
                        <h5>Opening time</h5>
						{{$MonOpenhr??''}}
                       </div>
                      <div class="col-lg-5 col-12">
                        <h5>Closing time</h5>
						{{$MonCloseHr??''}}
                       
                      </div>
                      @endif
                    </div>
					
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="time-bx">
                    <h4>Tuesday</h4>
					
					
					
					<div class="row">
                     
					  @if($TuesClosed=="Yes")
					<div class="col-lg-2 col-12">
                        <h5>Closed </h5>
                        
                      </div>
						@else
					<div class="col-lg-5 col-12">
                        <h5>Opening time</h5>
						{{$TueOpenhr??''}}
                       </div>
                      <div class="col-lg-5 col-12">
                        <h5>Closing time</h5>
						{{$TueCloseHr??''}}
                       
                      </div>
                      @endif
                    </div>
					
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="time-bx">
                    <h4>Wednesday</h4>
					
					<div class="row">
                     
					  @if($WedClosed=="Yes")
					<div class="col-lg-2 col-12">
                        <h5>Closed </h5>
                        
                      </div>
						@else
					<div class="col-lg-5 col-12">
                        <h5>Opening time</h5>
						{{$WedOpenhr??''}}
                       </div>
                      <div class="col-lg-5 col-12">
                        <h5>Closing time</h5>
						{{$WedCloseHr??''}}
                       
                      </div>
                      @endif
                    </div>
					
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="time-bx">
                    <h4>Thursday</h4>
					
					<div class="row">
                     
					  @if($ThursClosed=="Yes")
					<div class="col-lg-2 col-12">
                        <h5>Closed </h5>
                        
                      </div>
						@else
					<div class="col-lg-5 col-12">
                        <h5>Opening time</h5>
						{{$ThursOpenhr??''}}
                       </div>
                      <div class="col-lg-5 col-12">
                        <h5>Closing time</h5>
						{{$ThursCloseHr??''}}
                       
                      </div>
                      @endif
                    </div>
					
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="time-bx">
                    <h4>Friday</h4>
					
					<div class="row">
                     
					  @if($FriClosed=="Yes")
					<div class="col-lg-2 col-12">
                        <h5>Closed </h5>
                        
                      </div>
						@else
					<div class="col-lg-5 col-12">
                        <h5>Opening time</h5>
						{{$FriOpenhr??''}}
                       </div>
                      <div class="col-lg-5 col-12">
                        <h5>Closing time</h5>
						{{$FriCloseHr??''}}
                       
                      </div>
                      @endif
                    </div>
					
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="time-bx">
                    <h4>Saturday</h4>
					
					<div class="row">
                     
					  @if($SatClosed=="Yes")
					<div class="col-lg-2 col-12">
                        <h5>Closed </h5>
                        
                      </div>
						@else
					<div class="col-lg-5 col-12">
                        <h5>Opening time</h5>
						{{$SatOpenhr??''}}
                       </div>
                      <div class="col-lg-5 col-12">
                        <h5>Closing time</h5>
						{{$SatCloseHr??''}}
                       
                      </div>
                      @endif
                    </div>
					
					
                  </div>
                </div>
              </div> 
           
         </div>
  
          
        </div>
		</div>
		</div>  
          
		  
		  
		  
		









<div class="container seller-page-2 edit_form">
    <div class="row">
      <div class="col-lg-12">
           @if($errors->any())
     	    <div class="alert alert-danger">Some Error Occured</div>
           @endif

     <form  id="buyerformsubmit">
     <div class="pr-bottom">
          <div class="card">
         <div id="submitmessage"></div>
            <h3>Edit buyer profile</h3>
            @if(Session::has('message') && (Session::get('message') != "The old password does not match our records." )&& (Session::get('message') != "Your password has been changed!" )) <div class="alert alert-success">{{Session::get('message') }}</div> 
            @elseif(Session::has('message_not_match')) <div class="alert alert-danger">{{Session::get('message_not_match') }}</div> 
       @endif
         <div class="row">
              <div class="col-lg-3 col-12">
              <?php if(!empty(Auth::guard('user')->user()->profile_pic)) 
$img_path = asset('/uploads/userImages/').'/'.Auth::guard('user')->user()->profile_pic;
else  $img_path = asset('uploads/defaultImages/default_avatar.png'); ?>
                <div class="pr-logo">
            <img class="prof_img" src="  {{ $img_path }} "> <a href="javascript: void(0)" class="edit" id="upload_image"> <i class="fa fa-camera" aria-hidden="true"></i></a> </div>
                <input type="file" id="imgupload" class="image" name="image" style="display:none" accept="image/*" /> 
            <span id="txtimage"></span> 
            </div>
              <div class="col-lg-9 col-12">
                <div class="row">
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label> Name <sup>*</sup></label>
                      <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $user->name)  }}">
                      
                      <span id="txtname"></span>
                    </div>
                  </div>
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label> Surname <sup>*</sup></label>
                      <input type="text" class="form-control {{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" value="{{ old('surname', $user->surname)  }}">
                      <span id="txtsurname"></span>
                    </div>
                  </div>
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label>Email <sup>*</sup></label>
                      <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"  name="email" value="{{ old('email', $user->email)  }}">
                     <span id="txtemail"></span>
                    </div>
                  </div>
                 
                  <div class="col-lg-6 col-12">
                  <div class="form-group pn-no">
                  <label>Phone number<sup>*</sup></label>
                  <input name="full" type="text" value="{{  $user->phone ?? ''}}" id="phone" class="form-control pno05 {{ $errors->has('phone') ? ' is-invalid' : '' }} "/>

                  <span id="txtphone"></span>
                </div>
                  </div>
                 <!-- <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label> About</label>
                      <input type="text" class="form-control "  name="about" value="{{ old('about', $user->about)  }}" >
                    </div>
                  </div>-->
                  <div class="col-lg-6 col-12">
                    <div class="form-group">
                      <label> Address <sup>*</sup></label>
                      <input type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"  name="address" value="{{ old('address', $user->address)  }}" >
                      <span id="txtaddress"></span>
                    </div>
                  </div>


                  <div class="col-lg-6 col-12">
                  <div class="form-group">
                  <label>Country<sup>*</sup></label>
                  </label> 
                  <select name="country_id" id="country_id" class="form-control  {{ $errors->has('country_id') ? ' is-invalid' : '' }}" aria-label="Country"   >
                  <option value="">Country Name</option>
                  @foreach ($countries as $country)
                 
                  <option  {{old('country_id',$user->country_id) == $country->id ? 'selected' : ''}}   value="{{$country->id}}">{{$country->name}}</option>
                  @endforeach 
                  </select>
                  <span id="txtcountry"></span>
                </div>
                  </div>

<div class="row">
<div class="col-lg-6 col-12 ck-bx9">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="hide_promo_email"  name="hide_promo_email" value="No" @if( Auth::guard('user')->
                  user()->hide_promo_email=="Yes") checked @endif >
                  <label class="form-check-label" for="hide_promo_email">Promotional Emails</label>
                </div>
              </div>
              <div class="col-lg-6 col-12 ck-bx9">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="newsletter_status"  name="newsletter_status" value="Yes"  @if( Auth::guard('user')->
                  user()->newsletter_status=="Yes") checked @endif >
                  <label class="form-check-label" for="newsletter_status">Newsletter Emails</label>
                </div>
              </div>
</div>


                  
                </div>
              
              </div>
            </div>
          </div>
          
          
          
          
          
          
          
         
            
            
            <div class="card answer">
            <div class="row">
            
            <div class="col-lg-12"><h3>Company information </h3></div>
            </div>
            
            <div class="row">
            
            
            
           

                    <div class="col-lg-4 col-12">
                      <div class="form-group">
                        <label>   Company name<sup>*</sup></label>
                        <input class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}" type="text" name="company_name"  value="{{ old('company_name', $user->BuyerCompany->company_name ?? '')  }}">
                       <span id="txtcompanyname"></span>
                      </div>
                    </div>
					<div class="col-lg-4 col-12">
                <div class="form-group">
                  <label>Company Type<sup>*</sup></label>
                  <div class="autocomplete form-group cmp-type" >
     
              <select type="text" multiple placeholder="Select" name="company_type[]" id='company_type' class="form-control{{ $errors->has('product_dimension') ? ' is-invalid' : '' }}" multiple="multiple">
              <?php $ctypes =[]; ?>
              @foreach ($company_types as $company_type)
                      @if(!empty($user->BuyerCompany->company_type))
                       <?php $ctypes = explode(",",$user->BuyerCompany->company_type);?>
                       @endif
                       @if(in_array($company_type->id, $ctypes))
                       <option value="{{ $company_type->id }}" selected="true" />{{ $company_type->company_type }}</option>
                       @else
                        <option value="{{ $company_type->id }}">{{ $company_type->company_type }}</option>
                       @endif 
             @endforeach 
              </select>
              
              
            </div>
                  
                 <span id="txtcompanytype"></span> </div>
              </div>
                    <div class="col-lg-4 col-12">
                      <div class="form-group">
                        <label>Street<sup>*</sup></label>
                        <input class="form-control {{ $errors->has('company_street') ? ' is-invalid' : '' }}" type="text" name="company_street" value="{{ old('company_street', $user->BuyerCompany->company_street ?? '')  }}">
                         <span id="txtcompanystreet"></span> 
                      </div>
                    </div>
                    
                      <div class="col-lg-4 col-12">
                      <div class="form-group">
                        <label>Zip Code <sup>*</sup></label>
                        <input class="form-control {{ $errors->has('company_zip') ? ' is-invalid' : '' }}" type="text"  name="company_zip" value="{{ old('company_zip', $user->BuyerCompany->company_zip ?? '')  }}">
                        <span id="txtcompanyzipcode"></span> 
                      </div>
                    </div>
                   
                   
                   
                   
                             <div class="col-lg-4 col-12">
                      <div class="form-group">
                        <label> Location<sup>*</sup> </label>
                        <input class="form-control {{ $errors->has('company_location') ? ' is-invalid' : '' }}" type="text" name="company_location" value="{{ old('company_location', $user->BuyerCompany->company_location ?? '')  }}">
                         <span id="txtcompanylocation"></span> 
                      </div>
                    </div>
                    
                    <div class="col-lg-4 col-12">
                <div class="form-group">
                  <label>About Company </label>
                  <textarea  name="about_company"  id="exampleFormControlTextarea1"  class="form-control {{ $errors->has('about_company') ? ' is-invalid' : '' }}"  >{{ old('about_company',$user->BuyerCompany->about_company ?? '')  }}</textarea>
                  @if ($errors->has('about_company'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('about_company') }}</strong>
                                 </span>
                             @endif
                </div>
              </div>


                    <?php 
                  
          $openingTimes = $user->SellerOpeningTime ;  
          $SunOpen_am_pm = $MonOpen_am_pm = $TueOpen_am_pm = $WedOpen_am_pm = $ThusOpen_am_pm = $FriOpen_am_pm = $SatOpen_am_pm = $SunClose_am_pm = $MonClose_am_pm = $TueClose_am_pm = $WedClose_am_pm = $ThuClose_am_pm = $FriClose_am_pm = $ThuOpen_am_pm = $SatClose_am_pm =  $SunClosed = $MonClosed =  $TuesClosed = $WedClosed = $ThursClosed = $FriClosed = $SatClosed ="";
            ?>
                  @foreach($openingTimes as $openingTime ) 
                  <?php  
                  // $OpenHr= explodHr($openingTime->opening_time);
                  // $CloseHr= explodHr($openingTime->closing_time);  
                  $day =  $openingTime->day; 
                  ?>
                 
                 
                <?php  
                if($day=="Sunday") {
               
                if(!empty($openingTime->opening_time)) {
                  $SunOpenhr = $openingTime->opening_time; 
                  $SunCloseHr = $openingTime->closing_time; }
                  $SunClosed = $openingTime->closed; 
                  $SunOpen_am_pm  = $openingTime->Open_am_pm   ;  
                  $SunClose_am_pm    = $openingTime->Close_am_pm  ;
                }
                ?>
              
                  @if($openingTime->day=="Monday") 
                <?php 
                if(!empty($openingTime->opening_time)) {
                  $MonOpenhr = $openingTime->opening_time; 
                  $MonCloseHr = $openingTime->closing_time; }
                  $MonClosed = $openingTime->closed;
                  $MonOpen_am_pm  = $openingTime->Open_am_pm   ; 
                  $MonClose_am_pm    = $openingTime->Close_am_pm  ; 
                  ?>
                  @endif
                  @if($openingTime->day=="Tuesday")
                <?php  
                if(!empty($openingTime->opening_time)) { 
                  $TuesOpenhr = $openingTime->opening_time; 
                  $TuesCloseHr = $openingTime->closing_time; } 
                 $TuesClosed = $openingTime->closed;
                 $TueOpen_am_pm   = $openingTime->Open_am_pm   ; 
                 $TueClose_am_pm  = $openingTime->Close_am_pm  ; 
                  ?>
                  @endif
                  @if($openingTime->day=="Wednesday")
                <?php
                if(!empty($openingTime->opening_time)) {
                  $WedOpenhr = $openingTime->opening_time; 
                  $WedCloseHr = $openingTime->closing_time; }
                   $WedClosed = $openingTime->closed;
                   $WedOpen_am_pm    = $openingTime->Open_am_pm   ; 
                   $WedClose_am_pm   = $openingTime->Close_am_pm  ; 
                  ?>
                  @endif
                  @if($openingTime->day=="Thursday")
                <?php
                if(!empty($openingTime->opening_time)) {
                  $ThursOpenhr = $openingTime->opening_time; 
                  $ThursCloseHr = $openingTime->closing_time; }
                  $ThursClosed = $openingTime->closed;
                  $ThuOpen_am_pm  = $openingTime->Open_am_pm   ; 
                  $ThuClose_am_pm    = $openingTime->Close_am_pm  ; 
                  ?>
                  @endif
                  @if($openingTime->day=="Friday")
                <?php 
                if(!empty($openingTime->opening_time)) {
                  $FriOpenhr = $openingTime->opening_time; 
                  $FriCloseHr = $openingTime->closing_time; }
                  $FriClosed = $openingTime->closed;
                  $FriOpen_am_pm  = $openingTime->Open_am_pm   ; 
                  $FriClose_am_pm    = $openingTime->Close_am_pm  ; 
                  ?>
                  @endif
                  @if($openingTime->day=="Saturday")
                <?php  
                if(!empty($openingTime->opening_time)) {
                  $SatOpenhr = $openingTime->opening_time;
                  $SatCloseHr = $openingTime->closing_time; }
                  $SatClosed = $openingTime->closed;
                  $SatOpen_am_pm  = $openingTime->Open_am_pm   ; 
                  $SatClose_am_pm    = $openingTime->Close_am_pm  ; 
                  ?>
                  @endif  
                  
                  @endforeach
<?php
if(empty($SunOpenhr) || $SunOpenhr==":") $SunOpenhr="00:00" ; 
if(empty($SunCloseHr) || $SunCloseHr==":") $SunCloseHr="00:00" ; 
if(empty($MonOpenhr) || $MonOpenhr==":") $MonOpenhr="00:00" ; 
if(empty($MonCloseHr) || $MonCloseHr==":") $MonCloseHr="00:00" ; 
if(empty($TuesOpenhr) || $TuesOpenhr==":") $TuesOpenhr="00:00" ; 
if(empty($TuesCloseHr) || $TuesCloseHr==":") $TuesCloseHr="00:00" ;
if(empty($WedOpenhr) || $WedOpenhr==":") $WedOpenhr="00:00" ;
if(empty($WedCloseHr) || $WedCloseHr==":") $WedCloseHr="00:00" ; 
if(empty($ThursOpenhr) || $ThursOpenhr==":") $ThursOpenhr="00:00" ; 
if(empty($ThursCloseHr) || $ThursCloseHr==":") $ThursCloseHr="00:00" ; 
if(empty($FriOpenhr) || $FriOpenhr==":") $FriOpenhr="00:00" ; 
if(empty($FriCloseHr) || $FriCloseHr==":") $FriCloseHr="00:00" ; 
if(empty($SatOpenhr) || $SatOpenhr==":") $SatOpenhr="00:00" ; 
if(empty($SatCloseHr) || $SatCloseHr==":") $SatCloseHr="00:00" ; 
?>
           
                    
                      <div class="col-lg-4 col-12">
                          
                          
                      <div class="form-group">
                    <div class="file-drop-area form-group">
                      <label>Picture upload</label>
                      
                      <div class="row">
                          
                          <div class="col-lg-2">
                      
           @php 
           $company_image =  $user->BuyerCompany->company_image ?? '';
           if(($company_image!=""))
          $cmp_img = asset('uploads/BuyerCompany/').'/'.$company_image;
          else $cmp_img = asset('uploads/defaultImages/seller.jpg');
          @endphp
          
          <div class="uploadedimg">

             <img src="{{ $cmp_img}}" ></div>
         @php  @endphp
                      
                    </div>
                  
                    
                    <div class="col-lg-10 col-12">
                      <div class="form-group">
                    <div class="file-drop-area form-group">
                    
                      <input type="file" class="file-input form-control {{ $errors->has('company_image') ? ' is-invalid' : '' }} " name="company_image" id="company_image" accept="image/*" >
                     <span id="txtimgpicture"></span>  
                    </div>
                  </div>
                    </div>
                    
                    </div></div></div></div>
                    
                    
                    

               <div class="row">
                    <div class="col-lg-6 col-12">
                <div class="form-group overflow-hidden1">
                  <label>Accepted payments methods<sup>*</sup></label>
                  
                  <div class="autocomplete form-group sg-list" >
                    <?php 

           $accepted_payments="";
                if(!empty($user->BuyerCompany->accepted_payments) ) 
                    $accepted_payments = $user->BuyerCompany->accepted_payments; 

           if(!empty(old('accepted_payments',$accepted_payments)))
             $accepted_payments=old('accepted_payments',$accepted_payments); 
  
?>
                    <input  type="text" class="multitags form-control {{ $errors->has('accepted_payments') ? ' is-invalid' : ''}}" name="accepted_payments" id="accepted_payments" value="{{$accepted_payments}}" style="width:100%;">
                   <span id="txtacceptedpay"></span> </div>
                </div>
              </div>
                    
                      
                    
                    
                      <div class="col-lg-6 col-12">
                <div class="form-group overflow-hidden1">
                  <label>Language</label>
                  <div class="autocomplete form-group sg-list" >
                    <?php 

               $languages_speak="";
               if(!empty($user->BuyerCompany->languages_speak) ) 
                        $languages_speak = $user->BuyerCompany->languages_speak; 

               if(!empty(old('languages_speak',$languages_speak)))
                 $languages_speak=old('languages_speak',$languages_speak); 

             
              ?>
                    <input  type="text"  class="multitags form-control" id='languages_speak' name="languages_speak" value="{{ $languages_speak}}" style="width:100%;">
                    @if ($errors->has('languages_speak')) <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('languages_speak') }}</strong> </span> @endif </div>
                </div>
              </div>
                    
                    
                  </div>
                  
                  </div>
                  
                 
              
            </div> 

            <div class="card answer">
            <div class="row">
            
            <div class="col-lg-12"><h3>Opening Hours </h3></div>
            </div>
            
              <div class="row">
              <!--<div class="col-lg-12 col-12">
                <div class="form-group overflow-hidden timimg-s">
                  <label>Opening hours</label>
                </div>
              </div>-->
              <div class="row tm-sec">
                <div class="col-lg-3 col-12">
                  <div class="time-bx">
                    <h4>Sunday</h4>
                    <div class="row">
                      <div class="col-lg-5 col-12">
                        <h5>Opening time</h5>
                        <input type="text" value="{{old('opSundayhr',$SunOpenhr) ?? '00:00' }}" name="opSundayhr" class="form-control timepicker" placeholder="Closing time">
                      </div>
                      <div class="col-lg-5 col-12">
                        <h5>Closing time</h5>
                        <input type="text" value="{{old('clSundayhr',$SunCloseHr) ?? '00:00' }}" name="clSundayhr"  class="form-control timepicker" placeholder="Closing time">
                      </div>
                      <div class="col-lg-2 col-12">
                        <h5>Closed </h5>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="chSunday"   @if(old('chSunday',$SunClosed)=="Yes") checked @endif   value="Yes">
                          <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="time-bx">
                    <h4>Monday</h4>
                    <div class="row">
                      <div class="col-lg-5 col-12">
                        <h5>Opening time</h5>
                        <input type="text" value="{{old('opMondayhr',$MonOpenhr) ?? '00:00' }}" name="opMondayhr"  class="form-control timepicker" placeholder="Opening time">
                      </div>
                      <div class="col-lg-5 col-12">
                        <h5>Closing time</h5>
                        <input type="text" value="{{old('clMondayhr',$MonCloseHr) ?? '00:00' }}" name="clMondayhr"  class="form-control timepicker" placeholder="Closing time">
                      </div>
                      <div class="col-lg-2 col-12">
                        <h5>Closed </h5>
                        <div class="form-check form-switch">
                          <input class="form-check-input" name="chMonday" type="checkbox" @if(old('chMonday',$MonClosed)=="Yes") checked @endif value="Yes" role="switch" id="flexSwitchCheckDefault">
                          <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="time-bx">
                    <h4>Tuesday</h4>
                    <div class="row">
                      <div class="col-lg-5 col-12">
                        <h5>Opening time</h5>
                        <input type="text" value="{{old('opTuesdayhr',$TuesOpenhr )?? '00:00' }}" name="opTuesdayhr"  class="form-control timepicker" placeholder="Opening time">
                      </div>
                      <div class="col-lg-5 col-12">
                        <h5>Closing time</h5>
                        <input type="text" value="{{old('clTuesdayhr',$TuesCloseHr) ?? '00:00' }}" name="clTuesdayhr"  class="form-control timepicker" placeholder="Closing time">
                      </div>
                      <div class="col-lg-2 col-12">
                        <h5>Closed </h5>
                        <div class="form-check form-switch">
                          <input class="form-check-input" name="chTuesday" type="checkbox" value="Yes"  @if(old('chTuesday',$TuesClosed)=="Yes")  checked  @endif role="switch"  id="flexSwitchCheckDefault">
                          <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="time-bx">
                    <h4>Wednesday</h4>
                    <div class="row">
                      <div class="col-lg-5 col-12">
                        <h5>Opening time</h5>
                        <input type="text" value="{{old('opWednesdayhr',$WedOpenhr) ?? '00:00' }}" name="opWednesdayhr"  class="form-control timepicker" placeholder="Opening time">
                      </div>
                      <div class="col-lg-5 col-12">
                        <h5>Closing time</h5>
                        <input type="text" value="{{old('clWednesdayhr',$WedCloseHr) ?? '00:00' }}" name="clWednesdayhr"  class="form-control timepicker" placeholder="Closing time">
                      </div>
                      <div class="col-lg-2 col-12">
                        <h5>Closed </h5>
                        <div class="form-check form-switch">
                          <input class="form-check-input" name="chWednesday" type="checkbox" @if(old('chWednesday',$WedClosed)=="Yes")  checked  @endif value="Yes" role="switch" id="flexSwitchCheckDefault">
                          <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="time-bx">
                    <h4>Thursday</h4>
                    <div class="row">
                      <div class="col-lg-5 col-12">
                        <h5>Opening time</h5>
                        <input type="text" value="{{old('opThursdayhr',$ThursOpenhr) ?? '00:00' }}" name="opThursdayhr" class="form-control timepicker" placeholder="Opening time">
                      </div>
                      <div class="col-lg-5 col-12">
                        <h5>Closing time</h5>
                        <input type="text" value="{{old('clThursdayhr',$ThursCloseHr) ?? '00:00' }}" name="clThursdayhr"  class="form-control timepicker" placeholder="Closing time">
                      </div>
                      <div class="col-lg-2 col-12">
                        <h5>Closed </h5>
                        <div class="form-check form-switch">
                          <input class="form-check-input" name="chThursday" type="checkbox" value="Yes"   @if(old('chThursday',$ThursClosed)=="Yes") checked @endif role="switch" id="flexSwitchCheckDefault">
                          <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="time-bx">
                    <h4>Friday</h4>
                    <div class="row">
                      <div class="col-lg-5 col-12">
                        <h5>Opening time</h5>
                        <input type="text" value="{{old('opFridayhr',$FriOpenhr) ?? '00:00' }}" name="opFridayhr"  class="form-control timepicker" placeholder="Opening time">
                      </div>
                      <div class="col-lg-5 col-12">
                        <h5>Closing time</h5>
                        <input type="text" value="{{old('clFridayhr',$FriCloseHr) ?? '00:00' }}" name="clFridayhr"  class="form-control timepicker" placeholder="Closing time">
                      </div>
                      <div class="col-lg-2 col-12">
                        <h5>Closed </h5>
                        <div class="form-check form-switch">
                          <input class="form-check-input" name="chFriday" type="checkbox" value="Yes"   @if(old('chFriday',$FriClosed)=="Yes") checked @endif role="switch" id="flexSwitchCheckDefault">
                          <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-12">
                  <div class="time-bx">
                    <h4>Saturday</h4>
                    <div class="row">
                      <div class="col-lg-5 col-12">
                        <h5>Opening time</h5>
                        <input type="text" value="{{old('opSaturdayhr',$SatOpenhr) ?? '00:00' }}" name="opSaturdayhr" class="form-control timepicker" placeholder="Opening time">
                      </div>
                      <div class="col-lg-5 col-12">
                        <h5>Closing time</h5>
                        <input type="text" value="{{old('clSaturdayhr',$SatCloseHr) ?? '00:00' }}" name="clSaturdayhr"  class="form-control timepicker" placeholder="Closing time">
                      </div>
                      <div class="col-lg-2 col-12">
                        <h5>Closed </h5>
                        <div class="form-check form-switch">
                          <input class="form-check-input" name="chSaturday" type="checkbox"  @if(old('chSaturday',$SatClosed)=="Yes") checked @endif value="Yes" role="switch" id="flexSwitchCheckDefault">
                          <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>  
             <div class="row">
                     <div class="col-lg-12">
                           
                  
                  <button type="submit">submit</button>
                    
                    </div>
                  </div>
         </div>
          </form>
          
        </div>
		</div>
		</div>  
          
		  
		  
		  
		
		  
		  
		  
		  <div class="card answer">
            <div class="row">
            
            <div class="col-lg-12"><h3>Change Password </h3></div>
            </div>
           
            <form action="{{ route('user.pw.reset') }}" method="POST">
                @csrf
            <div class="row">
            
            
            
              <input type="hidden" name="email" value="{{ Auth::guard('user')->user()->email}}">
                 <div class="col-lg-4 col-12">
                      <div class="form-group">
                        <label>Current password:</label>
                      <input name="oldPassword" type="password" class="form-control {{ $errors->has('oldPassword') ? ' is-invalid' : '' }}"  placeholder="" value="">
                     @if ($errors->has('oldPassword'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('oldPassword') }}</strong>
                            </span>
                        @endif
                      </div>
                    </div>
                    <div class="col-lg-4 col-12">
                      <div class="form-group">
                       <label>New password:</label>
                      <input value="" id="password" type="password" class="pr-password  form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                      </div>
                    </div>
                    
                      <div class="col-lg-4 col-12">
                      <div class="form-group">
                         <label>Confirm new password:</label>
                      <input  id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                      </div>
                    </div>
                   
                   
                    <div class="col-lg-4 col-12">
                      <div class="form-group">
                   <button type="submit" class="bl-btn">update password</button>
                   </div>
                    </div>
                   
                 
                    
                  </div>
                  
                  
                  </form>
                  
                  
                  
              
            </div> 
          
          
          
        </div>
      
      </div>
    </div>

  <style>
      .close span {
    color: #fff !important;
}
  </style>

  <div class="modal fade" id="Mymodal" tabindex="-1" aria-labelledby="MymodalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="MymodalLabel">Request for Account Delete</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="fnclosepopup1()"> <span aria-hidden="true">&times;</span> </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Reason:</label>
            <br>
            <textarea id="reason_delete" class="form-control" required></textarea>
          </div>
          <button  type="submit"  class="bl-btn mar-10" onClick="fnsubmitdelete()">SUBMIT</button>
        </div>
        <div class="modal-footer"> </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12"> <a href="javascript:void(0)" 
   @if($delete_request_active==false)
     onClick="deleteProfileaccount({{Auth::guard('user')->user()->id}})" 
     class="default-btn ctr mr-pro"
   @else
     class="default-btn ctr mr-pro gray-btn45"
      title="Already a Request for Account Delete Sent to Admin"
   @endif 
    >Request for Account Delete</a> </div>
</sectiion>
 



@endsection
@section('footer_script')
<link rel="stylesheet" href="{{ asset('/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('/css/jquery.passwordRequirements.css')}}">
<link rel="stylesheet" href="{{ asset('/admin1/css/bootstrap-tagsinput.css')}}">
<script src="{{ asset('/admin1/js/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{ asset('/admin1/js/tether.min.js')}}"></script>
<script src="{{ asset('/admin1/js/moment.min.js')}}"></script>
<script src="{{ asset('js/jquery.passwordRequirements.js')}}"></script>
<script src="{{ asset('js/jquery.passwordRequirements.min.js')}}"></script>
<script src="{{ asset('/admin1/js/bootstrap-datetimepicker.min.js')}}"></script>
<link rel="stylesheet" href="{{ asset('/admin1/css/bootstrap-datetimepicker.min.css')}}">

<script>
//var $fmcg = $.noConflict();
        $fmcg(document).ready( function () {
            $fmcg(".pr-password").passwordRequirements({});
             $fmcg(".timepicker").datetimepicker({
          format: "HH:mm",
          icons: {
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down"
          }
        });
             $fmcg("#buyerformsubmit").on('submit', function(e) {
                 //$fmcg(".loaderajax").show();
            e.preventDefault();
            var formData = new FormData($fmcg('#buyerformsubmit')[0]);
            formData.append('_token', "{{ csrf_token() }}"); 
            if($fmcg("#hide_promo_email").is(':checked'))
               formData.set("hide_promo_email", "Yes");  // checked
            else
               formData.set("hide_promo_email", "No");  // unchecked
                
            if($fmcg("#newsletter_status").is(':checked'))
                formData.set("newsletter_status", "Yes");  // checked
            else
               formData.set("newsletter_status", "No");  // unchecked 

                $fmcg.ajax({
                type: "post",
                url: "{{route('update.buyer')}}",
                data: formData,
                enctype : 'multipart/form-data',
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                    //$fmcg(".loaderajax").hide(); 
                  $fmcg("#submitmessage").empty().append('<div class="alert alert-success">'+data+'</div>');
                    $fmcg(window).scrollTop(0);
                    setTimeout(window.location.reload(),300);
                },
                error: function (xhr) {
                   // $fmcg(".loaderajax").hide();       
                    var errors = JSON.parse(xhr.responseText);
                    if(errors.errors.name)
                    $fmcg("#txtname").empty().append("<p style='color:red'>"+errors.errors.name[0]+"</p>");
                    else
                      $fmcg("#txtname").empty();
                    if(errors.errors.surname)
                    $fmcg("#txtsurname").empty().append("<p style='color:red'>"+errors.errors.surname[0]+"</p>");
                    else
                      $fmcg("#txtsurname").empty();
                    if(errors.errors.email)
                    $fmcg("#txtemail").empty().append("<p style='color:red'>"+errors.errors.email[0]+"</p>");
                    else
                      $fmcg("#txtemail").empty();
                    if(errors.errors.phone)
                    $fmcg("#txtphone").empty().append("<p style='color:red'>"+errors.errors.phone[0]+"</p>");
                    else
                      $fmcg("#txtphone").empty();
                    if(errors.errors.address)
                    $fmcg("#txtaddress").empty().append("<p style='color:red'>"+errors.errors.address[0]+"</p>");
                    else
                      $fmcg("#txtaddress").empty();
                    if(errors.errors.country_id)
                    $fmcg("#txtcountry").empty().append("<p style='color:red'>"+errors.errors.country_id[0]+"</p>");
                    else
                      $fmcg("#txtcountry").empty();
                    if(errors.errors.company_name)
                    $fmcg("#txtcompanyname").empty().append("<p style='color:red'>"+errors.errors.company_name[0]+"</p>");
                    else
                      $fmcg("#txtcompanyname").empty();
                    if(errors.errors.company_type)
                    $fmcg("#txtcompanytype").empty().append("<p style='color:red'>"+errors.errors.company_type[0]+"</p>");
                    else
                      $fmcg("#txtcompanytype").empty();

                    if(errors.errors.company_street)
                    $fmcg("#txtcompanystreet").empty().append("<p style='color:red'>"+errors.errors.company_street[0]+"</p>");
                    else
                      $fmcg("#txtcompanystreet").empty();
                    if(errors.errors.company_zip)
                    $fmcg("#txtcompanyzipcode").empty().append("<p style='color:red'>"+errors.errors.company_zip[0]+"</p>");
                    else
                      $fmcg("#txtcompanyzipcode").empty();
                    if(errors.errors.company_location)
                    $fmcg("#txtcompanylocation").empty().append("<p style='color:red'>"+errors.errors.company_location[0]+"</p>");
                    else
                      $fmcg("#txtcompanylocation").empty();
                    if(errors.errors.accepted_payments)
                    $fmcg("#txtacceptedpay").empty().append("<p style='color:red'>"+errors.errors.accepted_payments[0]+"</p>");
                    else
                      $fmcg("#txtacceptedpay").empty();

                    if(errors.errors.company_image)
                    $fmcg("#txtimgpicture").empty().append("<p style='color:red'>"+errors.errors.company_image[0]+"</p>");
                    else
                      $fmcg("#txtimgpicture").empty();

                    $fmcg("#submitmessage").empty().append('<div class="alert alert-warning">Profile Update Failed!!</div>');
                    $fmcg(window).scrollTop(0);
                               
                }
            });
          }); 
        });


        
    </script>
<script>
  function fnclosepopup1(){
      $fmcg(document).ready( function () {
          $fmcg("#Mymodal").modal('hide');
        });
   
}

function fnsubmitdelete(){

  $fmcg.ajax({
            url: "{{ url('profile_account_delete') }}",
               type: "get",
               data:{ 
                   _token:'{{ csrf_token() }}',
                   user_id: '<?=Auth::guard('user')->user()->id?>',
                   reason:$fmcg("#reason_delete").val() ,
               },
               async:true,
               cache: false,
               dataType: 'json',
               success: function(){ 
                
                
          $fmcg("#Mymodal").modal('hide');
     
   
                 swal("Request for removing your account successfully placed. Our admin will remove it very soon", "", "success");
                 location.reload();
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
               swal(errorThrown, "", "error");
             }  
   
           })  ;

}
function deleteProfileaccount(userid){

  $fmcg("#reason_delete").val('');
  swal({
    title:"Do you really want to delete? " ,
    text: "",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      
        $fmcg('#Mymodal').modal('show');
       

    } 
    else {
          
        }
    });  
}

  
  $fmcg(document).ready(function() {
      var route1 = "{{route('company.types')}}";
   $fmcg('#company_type').select2({
     placeholder: 'Select',

    
    ajax: {
      url: route1,
      dataType: 'json',
      delay: 250,
      processResults: function(data) {
        return {
          results: $fmcg.map(data, function(item) {
            return {
              html:"<span>"+item.company_type+"</span>",
              text: item.company_type,
              id: item.id
            }
          })
        };
      },
      cache: true,

    }
  });   
         $fmcg('.multitags').tagsinput({
            trimValue: true,
            confirmKeys: [13, 44],
            focusClass: 'my-focus-class'
          });     
});

</script>

<link rel="stylesheet" href="{{ asset('/css/intlTelInput.css')}}">
<script src="{{ asset('js/intlTelInput.min.js')}}"></script>


<script>

function editfrm(){


 $fmcg(".edit_form").css("display", "block");
 $fmcg(".view_profile").hide();
 // $fmcg(".edit_form").show();
}



  var input = window.intlTelInput(document.querySelector("#phone"), {
  separateDialCode: true,
  preferredCountries:["in"],
  hiddenInput: "phone",
  utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
});


    $fmcg(document).ready( function () {
    $fmcg('#register').on( "click", function() {
 var full_number = input.getNumber(intlTelInputUtils.numberFormat.E164);
$fmcg("input[name='phone[full]'").val(full_number);

});
});
        </script>
<script type="text/javascript">
    $fmcg( document ).ready(function() {
        $fmcg('#upload_image').click(function(){  
            $fmcg('#imgupload').trigger('click'); 
        });


$fmcg(".image").change(function(e) { 
var data = new FormData();
data.append('image', $fmcg('input[type=file]')[0].files[0]);
data.append('_token', "{{ csrf_token() }}");
$fmcg.ajax({
        url:'{{route('update-image')}}',
        type: 'POST',
        data : data,
        enctype : 'multipart/form-data',
        contentType: false,
        processData: false,
        success: function( data ) { 
            var baseUrl = "{{asset('')}}";
            var imageUrl = baseUrl + data.image_path;
            $fmcg('.prof_img').attr('src', imageUrl);
         
        },
        error: function() {
            alert('Upload Failed');
        }
   });   
});


});
    </script>
 <script type="text/javascript">
                
        $fmcg(document).ready( function () {
           $fmcg('#user_status').on('change', function() {
  var status = this.value ;
 
    $fmcg.ajax({
            url: "{{ url('user_status') }}",
               type: "get",
               data:{ 
                   _token:'{{ csrf_token() }}',
                   user_id: '<?=Auth::guard('user')->user()->id?>',
                   user_status:status ,
               },
               async:true,
               cache: false,
               dataType: 'json',
               success: function(){ 
                 swal("Status Updated..", "", "success");
                 //location.reload();
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
               swal(errorThrown, "", "error");
             }  
   
           })  ;

  
});
        });
    </script>
<style type="text/css">
  
  @media (min-width: 1300px) {
.container {width: 1290px!important;}

.cb4-1{    flex: 0 0 18%;
    max-width: 25%;}
    
    .cb4-2{    flex: 0 0 14%;
    max-width: 25%;}
}
</style>
@endsection