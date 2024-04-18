@extends('layouts.template_mobile')
@section('title', 'Company Profile')
@section('content')
<?php               if((request()->route('profId')==null)) {
                                if(!empty(Auth::guard('user')->user()->profile_pic)) 
                                $img_path = asset('/uploads/userImages/').'/'.Auth::guard('user')->user()->profile_pic;
                                else  
                                $img_path = asset('uploads/defaultImages/default_avatar.png');
                                $u_name = Auth::guard('user')->user()->name ." " .Auth::guard('user')->user()->surname;
                                //$u_name = Auth::guard('user')->user()->name ;
                                $u_position = Auth::guard('user')->user()->position??"";
                                $u_email = Auth::guard('user')->user()->email;
                                $u_phone = Auth::guard('user')->user()->phone;
                      } 
                      
                      else{
                                if(!empty($user->profile_pic)) 
                                $img_path = asset('/uploads/userImages/').'/'.$user->profile_pic;
                                else  
                                $img_path = asset('uploads/defaultImages/default_avatar.png');
                                $u_name = $user->name;
                                $u_position = $user->position??"";
                                $u_email = $user->email;
                                $u_phone = $user->phone;
                      }
                      
                      
                      ?>
<section class="my-prof-new">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="prf-out-c11">
          <div class="profile-Container"> 
                     <?php
                        $company_image =  $user->BuyerCompany->company_image ?? ''; 
                        if(($company_image!=""))
                        $cmp_img = asset('uploads/BuyerCompany/').'/'.$user->BuyerCompany->company_image;
                        else $cmp_img = asset('uploads/defaultImages/seller.jpg');
                        
                        
                        $edit_co = $edit="No";
                        if(Auth::guard('user')->user()->seller_type=="Co-Seller")
                          {  if($user->id == Auth::guard('user')->user()->parent_id  && $active_package == "Yes")
                            $edit="Yes"; 
                          }
                        elseif($user->id == Auth::guard('user')->user()->id  && $active_package == "Yes")  
                            $edit="Yes";
                        
                        
                        /*if($user->id == Auth::guard('user')->user()->id &&  $user->seller_type=='Master' && $active_package == "Yes") 
                        $edit_co="Yes";*/
                      ?>
              
          
            
            <div class="cover-c profile_top">
              <div class="cover-image"><img src="{{$user->BuyerCompany->campany_banner==''?asset('assets/images/cover-image.jpg'):asset('/uploads/BuyerCompanyBanner/').'/'.$user->BuyerCompany->campany_banner}}"></div>
              <div class="pro-img-row">
                <div class="row">
                  <div class="col-lg-4 col-12">
                      
                    <div class="prof-imgg"><img src="{{$cmp_img}}"></div>
                  </div>
                  <div class="col-lg-8 col-12"> @if($edit=="Yes") <a  href="javascript:void(0)" onclick="editfrm()"  class="greenButton">Edit</a>
                  @else
                    @if($view_composer_profile_menu_visible_criteria['network_expand'] == 1  && $network==true )
                        <a href="javascript:void(0)" class="green-button clsa{{$user->id}}" onclick="addtonetwork({{$user->id}})" ><i class="fa fa-plus" aria-hidden="true"></i> Add To Network</a>
                    @else
                      <!--  <a href="javascript:void(0)" onclick="showerrornetwork" class="green-button ad-nw12">Add To Networks</a> -->
                    @endif
                  
                  <!--
					  @if( $view_composer_profile_menu_visible_criteria['network_chat'] == 1)
					  <a href="javascript:void(0)" class="green-button cht-ico" onclick="EnableChatRequest({{$user->id}})"><i class="fa fa-comments" aria-hidden="true"></i>Message</a>
					  @else
                    <a onclick="showerror()" href="JavaScript:void(0);" class="cht-ico"><i class="fa fa-comments" aria-hidden="true"></i>Start chat</a>
					  @endif
                      -->   
                  @endif</div>
                </div>
              </div>
            </div>
            
        
            
            <div class="cover-c edit_form" style="display:none;">
              <div class="cover-image"><img src="{{$user->BuyerCompany->campany_banner==''?asset('assets/images/cover-image.jpg'):asset('/uploads/BuyerCompanyBanner/').'/'.$user->BuyerCompany->campany_banner}}
             "  class="banner_img"> <a href="javascript: void(0)"  id="upload_cmpBanner" class="edit-btn-prf"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a> </div>
              <input type="file" id="imgupload_banner" class="image_banner" name="image_banner" style="display:none" accept="image/*" />
              <div class="pro-img-row">
                <div class="row">
                  <div class="col-lg-4 col-12">
                    <div class="prof-imgg"><img src="{{$cmp_img}}" class="prof_img"> <a href="javascript: void(0)"  id="upload_image" class="edit-btn-prf"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a> </div>
                     <!--<input type="file" id="imgupload" class="image" name="image" style="display:none" accept="image/*" />-->
                     <input type="file" id="imgupload" class="company_image" name="company_image" style="display:none" accept="image/*" />
                      <span id="txtimgpicture"></span> 
                  </div>
                  <div class="col-lg-8 col-12"><!-- <a href="javascript: void(0)" class="greenButton btn-save">Save</a> --></div>
                </div>
              </div>
            </div>
            
              <div id="bnner_image_error"></div>
              <div id="company_logo_error"></div>
            
            <div class="prof-inner-C">
			<div class="profile_top">
              <div class="pro-basic-info">
                <h2>{{$user->BuyerCompany->company_name ?$user->BuyerCompany->company_name:$user->name }}
                @if($user->varification_status=="varified") 
                <img src="{{ asset('assets/images/grenn-varified.png')}}" class="varified-ic">
                @endif
                </h2>
                
             <?php   $c_types = $c_types_names =[]; 
		            if($user->BuyerCompany->company_type) { 
				  
				    foreach ($company_types as $company_type)
				    {
							   $c_types = explode(",",$user->BuyerCompany->company_type);
							   if(in_array($company_type->id, $c_types))
							    $c_types_names[] = $company_type->company_type ;
				    } 
				    $c_types_names =  implode( ', ', $c_types_names ); ?>
				    <h3>{{$c_types_names}}</h3>
		           <?php } ?>
                
                
                
                @if(!empty($categorylists))
                    @foreach($categorylists as $categorylist)
                    <?php $categorylist_all[] = $categorylist ; ?>
                   
                    @endforeach
                     <h4>{{ implode( ', ', $categorylist_all ) }}</h4>
                    @else
                  <!--  <p style="color:#ff0000;">No Categories</p>-->
                    @endif
                
              </div>
              <div class="pr-adrrs-blk">
                <div class="row">
                  <div class="col-lg-4 col-12">
                    <ul class="bsc-inf">
                     @if($user->BuyerCompany?->company_email)
                      <li class="inf"><a href="mailto:{{$user->BuyerCompany?->company_email}}">{{$user->BuyerCompany?->company_email}}</a></li>
                      @endif
                      @if($user->BuyerCompany?->company_phone)
                      <li class="tl"><a href="tel:{{ $user->phone}}">{{ $user->BuyerCompany?->company_phone ?? '' }}</a></li>
                      @endif  
                     
                      
                      @if($user->BuyerCompany?->company_website)
                      <?php $web = (strlen($user->BuyerCompany->company_website) > 17) ? substr($user->BuyerCompany->company_website,0,17).'...' : $user->BuyerCompany->company_website; ?>
                      <li class="wb">
                          <?php 
                          $url = (!preg_match("~^(?:f|ht)tps?://~i", $user->BuyerCompany->company_website))?"http://" . $user->BuyerCompany->company_website:$user->BuyerCompany->company_website;
                          ?>
                          
                          <a href="{{$url}}" target="_blank">{{ $user->BuyerCompany?->company_website }}</a>
                          
                          </li>
                      @endif
                    </ul>
                  </div>
                  <div class="col-lg-4 col-12">
                    @if($user->Country?->name)
                    <ul class="prf-adr">
                     
                      @if($user->BuyerCompany->company_street)<li>{{ $user->BuyerCompany->company_street ?? '' }}</li>@endif
                      @if($user->BuyerCompany->company_location)<li>{{(strlen($user->BuyerCompany->company_location) > 10) ? substr($user->BuyerCompany->company_location,0,10).'...' : $user->BuyerCompany->company_location  }}, {{ $user->BuyerCompany->company_zip ?? '' }}</li>@endif
                     
                      <li>{{(strlen($user->Country->name) > 17) ? substr($user->Country->name,0,17).'...' : $user->Country->name  }}</li>
                    </ul>
                    @endif
                  </div>
                  <div class="col-lg-4 col-12">
                      
                   
                    
                    <div class="prf-count">
                    
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    <td> <h5>{{$profile_visit_count}}+</h5></td>
                    <td><h6>Profile Views</h6></li></td>
                    </tr>
                    <tr>
                    <td><h5>{{$network_count}}</h5></td>
                    <td><h6>Network Connections</h6></li></td>
                    </tr>
                    <tr>
                    <td><h5>{{$product_count}}+</h5></td>
                    <td>                        <h6>Products</h6></li>
                    </td>
                    </tr>
                    </table>
                    
      </div>              
                    
                    
                    
                    
                    
                    
                  </div>
                </div>
              </div>
           </div>   
			  
			  
			  
			  
			  <div class="edit_top" style="display:none;">
			      
			    <div class="prof-relative">
                <form  id='compny_profile'>	
                <div class="pro-basic-info">
                <h2>
                <input placeholder="Company Name" type="text" class="form-control  {{ $errors->has('company_name') ? ' is-invalid' : '' }}"  name="company_name" value="{{ old('company_name', $user->BuyerCompany->company_name ?? '')  }}" >
                     <span id="txtcompany"></span>
                <h3>
                  <div class="dropdown">
                    <div class="autocomplete form-group cmp-type" >
     
              <select type="text" multiple placeholder="Select Company Types" name="company_type[]" id='company_type' class="form-control{{ $errors->has('product_dimension') ? ' is-invalid' : '' }}" multiple="multiple">
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
                   <span id="txtcompanytype"></span>  
                  </div>
                </h3>
                <h4>
                  <div class="dropdown">
                    <div class="autocomplete form-group off-ln-cat" >
     
              <select type="text" multiple placeholder="Select Product Categories" name="offline_categories[]" id='offline_categories' class="form-control{{ $errors->has('product_dimension') ? ' is-invalid' : '' }}" multiple="multiple">
              <?php $off_cats =[]; ?>
              @foreach ($categories as $category)
                      @if(!empty($seller_OflnCats->category_id))
                       <?php $off_cats = explode(",",$seller_OflnCats->category_id);?>
                       @endif
                       @if(in_array($category->id, $off_cats))
                       <option value="{{ $category->id }}" selected="true" />{{ $category->name }}</option>
                       @else
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                       @endif 
             @endforeach 
              </select>
              
              
            </div>
                  <span id="offline_categories1"></span>     
                  </div>
                </h4>
              </div>
              <div class="pr-adrrs-blk">
                <div class="row">
                  <div class="col-lg-4 col-12">
                    <ul class="bsc-inf">
                         <li class="inf">
                        <input placeholder="Company Email" type="text" class="form-control  {{ $errors->has('company_email') ? ' is-invalid' : '' }}" name="company_email" value="{{ old('company_email', $user->BuyerCompany?->company_email)  }}" >
                        <span id="txtemail"></span>
                      </li>
                        <li class="tl">
                        <input placeholder="Company Phone" name="full" type="text" value="{{ old('company_phone') ? old('company_phone') : $user->BuyerCompany?->company_phone ?? '' }}" id="phone" class="form-control pno05 {{ $errors->has('company_phone') ? ' is-invalid' : '' }} " maxlength="15"/>
                        <span id="txtphone"></span>
                      </li>
                     
                      
                      <li class="wb">
                        
						<input placeholder="Company Website" name="company_website" type="text" value="{{ old('company_website') ? old('company_website') : $user->BuyerCompany->company_website ?? '' }}" id="company_website" class="form-control pno05 {{ $errors->has('company_website') ? ' is-invalid' : '' }} " />
                        <span id="txtwebsite"></span>
                      </li>
                     <!-- <li class="inf">
                        <input placeholder="More Info Email" type="text" class="form-control  {{ $errors->has('more_info_email') ? ' is-invalid' : '' }}" name="more_info_email" value="{{ old('more_info_email', Auth::guard('user')->user()->BuyerCompany?->more_info_email)  }}" >
                      <span id="txtemail"></span>
                      </li>-->
                    </ul>
                  </div>
                  <div class="col-lg-4 col-12">
                    <ul class="prf-adr">
                      <li>
						<input placeholder="Street" type="text" class="form-control  {{ $errors->has('company_street') ? ' is-invalid' : '' }}"  name="company_street" value="{{ old('company_street', $user->BuyerCompany->company_street ?? '')  }}" >
                     <span id="txtcompanystreet"></span>
                      </li>
                      <li>
                        
						<input placeholder="City" type="text" class="form-control  {{ $errors->has('company_location') ? ' is-invalid' : '' }}"  name="company_location" value="{{ old('company_location', $user->BuyerCompany->company_location ?? '')  }}" >
                       <span id="txtcompanylocation"></span>
                      </li>
                     <li><input placeholder="Zipcode"  type="text" class="form-control  {{ $errors->has('company_zip') ? ' is-invalid' : '' }}"  name="company_zip" value="{{ old('company_zip', $user->BuyerCompany->company_zip ?? '')  }}" >
                     <span id="txtcompanyzipcode"></li>					  
                      <li>
                       
						<select name="country_id" id="country_id" class="form-control  {{ $errors->has('country_id') ? ' is-invalid' : '' }}" aria-label="Default select example"  >
                    <option value="">Country Name</option>
                    
                  @foreach ($countries as $country)
                  
                    <option {{old('country_id',$user->country_id) == $country->id ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                    
                  @endforeach 
                  
                  </select>
                  <span id="txtcnryid"></span>
                      </li>
                    </ul>
                  </div>
                  <div class="col-lg-4 col-12">
                    <div class="prf-count">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    <td> <h5>{{$profile_visit_count}}+</h5></td>
                    <td><h6>Profile Views</h6></li></td>
                    </tr>
                    <tr>
                    <td><h5>{{$network_count}}</h5></td>
                    <td><h6>Network Connections</h6></li></td>
                    </tr>
                    <tr>
                    <td><h5>{{$product_count}}+</h5></td>
                    <td>                        <h6>Products</h6></li>
                    </td>
                    </tr>
                    </table>
                    </div>
                  </div>
                </div>
              </div>
              <a  href="javascript:void(0)" class="greenButton  btn-cancel_top2 prof-save-btn" onclick="HideEdit()">Cancel</a>
              <button type="submit" class="greenButton  btn-save prof-save-btn">Save</button>
              </div>
              
</form>					
<!--</div>-->

</div><!--relative-->	
		  
			  
	<div id="submitmessage"></div>		  
			  
			  
			 
			  
			  
			  
			  
			  
			  
			  
			  <!--<div class="tab_btm">-->
			  <!--tab-->
              <div class="prf-tab-sec">
                <div class="pr-tab-menu">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link {{ (Request::get('tab')=="about"  || !(isset($_GET['tab'])))? 'active':"" }}"  id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="{{ (Request::get('tab')=="about" || !(isset($_GET['tab']))) ? 'true':"false" }}">About</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Products</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link {{ Request::get('tab')=="regions"? 'active':"" }}" id="myRegions" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="{{ Request::get('tab')=="regions"? 'true':"false" }}">Regions</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link {{ Request::get('tab')=="employees"? 'active':"" }} "   id="myEmplyees" data-bs-toggle="tab" data-bs-target="#myEmplyees-contact1" type="button" role="tab" aria-controls="myEmplyees-contact1" aria-selected="{{ Request::get('tab')=="employees"? 'true':"false" }} "> Employees </button>
                    </li>
                    <?php //if($user->id == Auth::guard('user')->user()->id)?>
                    @if(request()->route('profId')==null)
                    <li class="nav-item" role="presentation">
                      <button class="nav-link {{ Request::get('tab')=="myprofile"? 'active':"" }}" id="myPrfile" data-bs-toggle="tab" data-bs-target="#myPrfile-contact2" type="button" role="tab" aria-controls="myPrfile-contact2" aria-selected="{{ Request::get('tab')=="myprofile"? 'true':"false" }}">My profile</button>
                    </li>
                    @endif
                  </ul>
                  
                 
                  </div>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane {{ (Request::get('tab')=="about" || !(isset($_GET['tab'])))? 'active':"" }}" id="home" role="tabpanel" aria-labelledby="home-tab">
                      
                    <div class="row pr-row view_tab1">
                         @if($edit=="Yes") <a  href="javascript:void(0)" onclick="edittab1()"  class="greenButton">Edit</a>@endif
                      <div class="col-lg-6 col-12">
                        <div class="prf-abt-txt">
                          <p> <?php echo $user->BuyerCompany->about_company; ?></p>
                         </div>
                      </div>
                      <div class="col-lg-6 col-12">
                          @if($user->BuyerCompany->comp_about_img1)
                        <div class="cmpny-prof"><img src="{{$user->BuyerCompany->comp_about_img1==''?asset('assets/images/cover-image.jpg'):asset('/uploads/BuyerCompanyBanner/').'/'.$user->BuyerCompany->comp_about_img1}}"></div>
                        @endif
                        @if($user->BuyerCompany->comp_about_img2)
                        <div class="cmpny-prof"><img src="{{$user->BuyerCompany->comp_about_img2==''?asset('assets/images/cover-image.jpg'):asset('/uploads/BuyerCompanyBanner/').'/'.$user->BuyerCompany->comp_about_img2}}"></div>
                        @endif
                        </div>
                    </div>
                    
                 <div class="edit_tab1" style="display:none;"> 
                    <form id="form_about">
                    <div class="row pr-row ">
                      <div class="col-lg-6 col-12">
                        <div class="prf-abt-txt">
                            
                                
                                <textarea name="about_company" id="mytextarea" style="height:300px !important;" class="form-control{{ $errors->has('about_company') ? ' is-invalid' : '' }}" >{{  $user->BuyerCompany->about_company ?? ''  }}</textarea>
                                
                                <span id="txtabt"></span>
                                <a   href="javascript:void(0)" onclick="HideEditAbout()"   class="greenButton  btn-cancel_2 prof-save-btn" >Cancel</a>
                                <button type="submit" class="greenButton btn-save">Save</button>
                            
                          </div>
                      </div>
                      <div class="col-lg-6 col-12">
                       
                       <div class="cmpny-prof"><img class="abt1_img" src="{{$user->BuyerCompany->comp_about_img1==''?asset('assets/images/no_img.jpg'):asset('/uploads/BuyerCompanyBanner/').'/'.$user->BuyerCompany->comp_about_img1}}"><a href="javascript: void(0)"  id="upload_abtimg1" class="edit-btn-prf"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>
                       @if($user->BuyerCompany->comp_about_img1)
                       <a href="javascript:void(0)" onclick="removeImageabt1({{ $user->BuyerCompany->id }})" class="btn abt1_remove"><span class="red_round remove-input-field"><i class="fa fa-minus-circle" aria-hidden="true"></i></span></a>
                      @endif
                       </div>
                       <input type="file" id="imgupload_abtimg1" class="about_image1" name="about_image1" style="display:none" accept="image/*" />
                       <div id="about_img1_error"></div>
                       <div class="cmpny-prof"><img class="abt2_img" src="{{$user->BuyerCompany->comp_about_img2==''?asset('assets/images/no_img.jpg'):asset('/uploads/BuyerCompanyBanner/').'/'.$user->BuyerCompany->comp_about_img2}}"><a href="javascript: void(0)"  id="upload_abtimg2" class="edit-btn-prf"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>
                        @if($user->BuyerCompany->comp_about_img2)
                       <a href="javascript:void(0)" onclick="removeImageabt2({{ $user->BuyerCompany->id }})" class="btn abt2_remove"><span class="red_round remove-input-field"><i class="fa fa-minus-circle" aria-hidden="true"></i></span></a>
                       @endif
                       </div>
                       <input type="file" id="imgupload_abtimg2" class="about_image2" name="about_image2" style="display:none" accept="image/*" />
                      <div id="about_img2_error"></div>
                       </div>
                    </div>
                    </form>
                    
                    </div>
                
                    
                    
                    
                  </div>
                  <div class="tab-pane " id="profile" role="tabpanel" aria-labelledby="profile-tab">
                      <input type="hidden" id="start_from" value="0">
			
			
			 <style>/*
.sidenav-ns {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 115;
    top: 0; bottom:0;
    right:auto; left:0;
 
    overflow-x: hidden;
    transition: 0.4s; background:#fff;padding-bottom:30px;
   
}

 */
 
.sidenav-ns {display:none; }

.my-prof-new .pro-lft-widget{border:1px solid #d6d6d6}

.closebtn-ns{
    position: absolute;
    top: 10px; 
    right: 20px;
    font-size: 36px;
    margin-left: 0px; color:#fff;  width:50px; height:50px;  z-index:20; text-align:center; display:none;
}


.menu-button2{padding:15px 0px;}

.menu-button2 .fa{background:#f3f3f3;width:40px; height:35px; border-radius:5px; line-height:36px; cursor:pointer; text-align:center; border:1px solid #e0dcdc;} 

/*
.filter-cat .select2-container--focus { left:auto!important;}
.select2-container--open{ left:auto!important; right:auto!important;}

.select2-container--open .select2-dropdown--below {
    left: 15px!important;}
    */

</style>
					  
					  
	<div class="menu-button2"><a  onClick="openNav2()"><i class="fa fa-filter" aria-hidden="true"></i>
</a></div>			
	<div id="mySidenav-45" class="sidenav-ns "> <a href="javascript:void(0)" class="closebtn-ns" onClick="closeNav2()"><span>&times;</span></a>
  <div class="pro-list-menu">			
				
				
	<div class="pro-lft-widget">
          <div class="widget-sidebar">
            <div class="sidebar-widget  borddr-bx1 categories tpp">
              <div class="filter-cat">
                <h3>Search by Keyword</h3>
                <div class="autocomplete form-group sg-list">
                  <div class="srch-left-3">
                    <input type="text" name="keyword" id="search_by_name" class="form-control" placeholder="Search" autocomplete="off">
                    <button type="submit" class="search_keyword_icon"><i class="fa fa-search" aria-hidden="true"></i></button>
                  </div>
                </div>
              </div>
              <div class="filter-cat">
                <h3>Search by Category</h3>
                <div class="autocomplete form-group sg-list">
                  <div class="srch-left-3">
                    <div class="form-group">
                      
                      <select id="search_by_category" class="form-control" onchange="fnbtnsearchproduct()">
                        <option value="0" >Select Category</option>
                        @if($parent_categorylists)
                            @foreach($parent_categorylists as $item)
                             <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        @endif 
                    </select>
                    </div>
                  </div>
                </div>
              </div>
             
             
             <div class="filter-cat">
                <h3>Search by Brand</h3>
                <div class="autocomplete form-group sg-list">
                  <div class="srch-left-3">
                    <div class="form-group">
                      
                      <select id="search_by_brand" class="form-control" onchange="fnbtnsearchproduct()">
                        <option value="" >Select Brand</option>
                        @if($brand_lists)
                            @foreach($brand_lists as $data)
                             <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                           
                        @endif 
                    </select>
                    </div>
                  </div>
                </div>
              </div>
             
             
             <!--
             <div class="filter-cat">
                <h3>Search by Location</h3>
                <div class="autocomplete form-group sg-list">
                  <div class="srch-left-3">
                    <div class="form-group">
                      
                      <select id="search_by_location" class="form-control" onchange="fnbtnsearchproduct()">
                        <option value="" >Search by Location</option>
                        @if($countries)
                            @foreach($countries as $data)
                             <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                           
                        @endif 
                    </select>
                    </div>
                  </div>
                </div>
              </div>
             -->
               
    <div class="filter-cat">            
<div class="sidebar-widget filter borddr-bx1  price-ranger01">
   <h3>Filter By Price</h3>
   <div class="grey_slide" style="display:none;">
      <img src="{{ asset('images/grey_slid.jpg')}}" />
   </div>
   <div class="price-fi-out">
      <input type="text" id="p-range" class="js-range-slider" name="my_range"  value="" data-skin="round" data-type="double" data-min="0"  data-max={{$max_product_price}} />
   </div>
   <div class="row price-fliter-Box">
      <div class="col-lg-6 col-12">
         <label>Price From :</label>
         <input type="text" id="p-start"  placeholder="0" onblur="range_selfupdate()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="price_from"  />
      </div>
      <div class="col-lg-6 col-12">
         <label>Price To :</label>
         <input type="text" id="p-end"  placeholder="{{$max_product_price}}" onblur="range_selfupdate()"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="price_to" />  
      </div>
   </div>
   <div class="row">
      <div class="col-lg-6 col-12">
         <label><input type="radio" class="chkPriceFilter rad1" id="p-req-both" name="priceOnRequest"  value="2"  style="width:auto !important;"  data-waschecked="false">&nbsp;Price Only</label>
      </div>
      <div class="col-lg-6 col-12">
         <label><input type="radio" class="chkPriceFilter rad2" id="p-req-only" name="priceOnRequest" value="1" style="width:auto !important;">&nbsp;Price on Request</label>
      </div>
   </div>
</div>
              
  </div>            
              
              
             
              <div class="filter-cat">
                <h3>Search by Best Before Date</h3>
                <div class="autocomplete form-group sg-list">
                  
                  <div class="srch-left-3">
                    <input  type="text" onfocus="(this.type='date')" onblur="(this.type='text')"  name="search_bbd" id="search_bbd" class="form-control" placeholder="Select Date"  onchange="fnbtnsearchproduct()">
                    <!--<button type="submit" class="search_keyword_icon"><i class="fa fa-search" aria-hidden="true"></i></button>-->
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>			
				
				
</div></div>
<!--<script>
function openNav2() {
    document.getElementById("mySidenav-45").style.width = "100%";
}

function closeNav2() {
    document.getElementById("mySidenav-45").style.width = "0";
}
</script>-->













				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
					  
                      <div class="row " id="product-listing"></div>
                    <div class="row">
                     
                    </div>
                  </div>
                  <div class="fade {{ Request::get('tab')=="regions"? 'active':"" }}" id="contact" role="tabpanel" aria-labelledby="myRegions"  >
                      <div class="chart-outer">
                          <div id="chartdiv"></div>
                      </div>

			           	
					
                    <div class="map-descrip map-descrip_view">
                        @if($edit=="Yes")<a  href="javascript:void(0)" onclick="editmap()"  class="greenButton">Edit</a>@endif
                      <div class="row">
                        <div class="col-lg-6 col-12">
                          <h3><b class="rg-active"></b>Regions we are active in</h3>
                       
						  @if (count($active_continents)>0)
                         @foreach($active_continents as $val)
						  <div class="country-list">
						  <div class="row">
						  	<div class="col-lg-5 col-12">
							<h4>{{$val}}</h4>
							</div>
							
							<div class="col-lg-7 col-12">
							<ul>
							    @foreach($active_reg_list as $row)
                                @if($row['continent']==$val)<li>{{$row['name']}}</li>@endif
                                 @endforeach
                               
                              </ul>
							</div>
						  </div>
						 </div>
						 @endforeach	 
				      	@endif
					
						  
						  
                        </div>
						
                        <?php
                            $expand_reg = explode(',',$user->CompanyRegion->expand_countries);
                            $active_reg = explode(',',$user->CompanyRegion->active_countries); 
                            ?>
						<div class="col-lg-6 col-12">
                          <h3><b class="exp"></b>Regions we would like to expand to</h3>
                        @if (count($expand_continents)>0)
                         @foreach($expand_continents as $val)
						  <div class="country-list">
						  <div class="row">
						  	<div class="col-lg-5 col-12">
						  	    <?php foreach($expand_reg_list as $row) {
                                
                                 if($row['continent']==$val) { ?>	<h4>{{$val}}</h4><?php   break; } } ?>
                                
                                
						
							</div>
							
							<div class="col-lg-7 col-12">
							<ul>
							    @foreach($expand_reg_list as $row)
                                @if(!in_array($row['id'],$active_reg))
                                @if($row['continent']==$val)<li>{{$row['name']}}</li>@endif
                                @endif
                                 @endforeach
                               
                              </ul>
							</div>
						  </div>
						 </div>
						 @endforeach	 
				      	@endif
						  
                          </ul>
                        </div>
						
                      </div>
                      
                      <!--<div class="row"><div class="col-lg-12">
                          @if($user->BuyerCompany?->more_info_email)
                          <div class="map-info">
                              <h6>More info:<br/>
                            <a href="mailto:{{$user->BuyerCompany?->more_info_email}}">{{$user->BuyerCompany?->more_info_email}}</a>
                              </h6>
                            
                          </div>
                          @endif
                      </div></div>-->
                    </div>
					
					
					
					<div class="map-descrip map-descrip_edit" style="display:none;">
					    
					<form id="region-form">
					    
                      <div class="row">
                        <div class="col-lg-6 col-12">
						
                        <h3><b class="rg-active"></b>Regions we are active in</h3>
						
                        <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
						
                        <h2 class="accordion-header" id="headingOne">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Select active regions</button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        <div class="map-edit-menu">
                            <?php
                            $expand_reg = explode(',',$user->CompanyRegion->expand_countries);
                            $active_reg = explode(',',$user->CompanyRegion->active_countries); 
                            ?>
                        <ul  class="accordion accordion1">
                            @foreach($all_continents as $val)
                                <?php $all_count = $selected_count =0; //to find parent checkbox checkedif all seleted ?> 
                                @foreach($countries as $row)
                                    @if($row['continent']==$val)
                                        <?php $all_count++; ?>
                                        @if(in_array($row['id'],$active_reg))
                                            <?php $selected_count++; ?>
                                        @endif
                                    @endif
                               @endforeach
                            <?php $val_clas = str_replace(' ', '-', $val); ?>
                            <li>
                                
                            <div class="link">
                              
                            <input type="checkbox"  {{($all_count === $selected_count)?'checked':''}} class="parent_cont{{$val_clas}} parent-check-active" onclick="SelctAllSub('{{$val_clas}}')">{{$val}}<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                                
                               @foreach($countries as $row)
                                @if($row['continent']==$val)
                                    <li> 
                                        <input class="sub_countries_cont{{$val_clas}}" id="cntry_id{{$row['id']}}" name="active_country[]" type="checkbox" value="{{$row['id']}}" {{in_array($row['id'],$active_reg)?'checked':''}}> <label for="cntry_id{{$row['id']}}">{{$row['name']}}</label>
                                    </li>
                                @endif
                               @endforeach
                              
                              
                              
                            </ul>
                          </li>
                           @endforeach	
                          </ul>
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
						  
                          <div class="col-lg-6 col-12">
                          <h3><b class="exp"></b>Regions we would like to expand to</h3>
						  
						  
						<div class="accordion" id="accordionExample2">
                        <div class="accordion-item">
						
                        <h2 class="accordion-header" id="headingOne2">
                          <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne"> Select Regions of Interest </button>
                        </h2>
                        <div id="collapseOne2" class="accordion-collapse collapse " aria-labelledby="headingOne2" data-bs-parent="#accordionExample2">
                        <div class="accordion-body">
                        <div class="map-edit-menu">
                        <ul  class="accordion accordion2">
                            
                            
                             @foreach($all_continents as $val)
                             <?php $all_count = $selected_count =0; ?>
                                @foreach($countries as $row)
                                    @if($row['continent']==$val)
                                        <?php $all_count++; ?>
                                        @if(in_array($row['id'],$expand_reg))
                                            <?php $selected_count++; ?>
                                        @endif
                                    @endif
                               @endforeach
                             <?php $val_clas = str_replace(' ', '-', $val); ?>
                            <li>
                            <div class="link">
                              
                              <input type="checkbox" {{($all_count === $selected_count)?'checked':''}} class="parent_contExpnd{{$val_clas}}" onclick="SelctAllSubExpnd('{{$val_clas}}')">{{$val}}<i class="fa fa-chevron-down"></i></div>
                              
                            <ul class="submenu">
                               
                                 @foreach($remainining_toexpand as $row)
                                 @if(!in_array($row['id'],$active_reg))
                                  @if($row['continent']==$val)<li> <input class="sub_countries_Subcont{{$val_clas}} cntry{{$row['id']}}" id="cuntry_id{{$row['id']}}"  name="expand_country[]" type="checkbox" value="{{$row['id']}}"  {{in_array($row['id'],$expand_reg)?'checked':''}}> <label for="cuntry_id{{$row['id']}}">{{$row['name']}}</label></li>@endif
                                  @endif
                                 @endforeach
                             </ul>
                          </li>
                           @endforeach
                           </ul>
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>  
						  
                      </div>
                    </div>
                    <a   href="javascript:void(0)" onclick="HideEditRegions()"   class="greenButton  btn-cancel_2 prof-save-btn" >Cancel</a>
                    <button type="submit" class="greenButton btn-save" value="Save">Save</button>
                    </form>
                  </div>
				</div>
                  <div class="tab-pane  {{ Request::get('tab')=="employees"? 'active':"" }}" id="myEmplyees-contact1" role="tabpanel" aria-labelledby="myEmplyees">
                      @if($edit=="Yes")  <a href="javascript:void(0)" onclick="edittabEployees()" class="greenButton">Edit</a> @endif
                      
                      <input type="hidden" id="start_from_empEdit" value="0">
                      <input type="hidden" id="edit_active" value="no">
                      <div class="row edit_employees" id="employee-listing-edit" >
                      
                   <a   href="javascript:void(0)" onclick="HideEditEmployees()"   class="greenButton  btn-cancel_2 prof-save-btn edit_emp_icon" style="display:none;">Cancel</a>  
                   <div class="col-lg-4 col-12 edit_emp_icon" style="display:none;">
                      <div class="prf-inner add-user-sect  ">
                        <div class="tab-prf-image add-us-img"><img src="assets/images/add-user.png"></div>
                        <a href="#" class="invite-us-btn"  data-bs-toggle="modal" data-bs-target="#exampleModa5">Invite</a> </div>
                    </div>
                  </div>
                  </div>
                  <div class="tab-pane {{ Request::get('tab')=="myprofile"? 'active':"" }}" id="myPrfile-contact2" role="tabpanel" aria-labelledby="myPrfile">
                    <div class="pr-tab-inner">
                      
                      <div class="my-prfile-view">
                         @if(request()->route('profId')==null) <a href="javascript:void(0)" onclick="editMyProfile()" class="greenButton">Edit</a>@endif
                      
                      <div class="row">
                        <div class="col-lg-3 col-12">
                      
                          <div class="tab-profile-user-img"><img src="{{$img_path}}"></div>
                        </div>
                        <div class="col-lg-9 col-12">
                          <ul class="bsc-inf">
                            <li class="us-nam">{{$u_name}}</li>
                            @if($u_position)<li class="des">{{$u_position}}</li>@endif
                            <li class="inf"><a href="mailto:{{$u_email}}">{{$u_email}}</a></li>
                            <li class="tl"><a href="tel:{{$u_phone}}">{{$u_phone}}</a></li>
                          </ul>
                        </div>
                      </div>
                      
                      </div>
                      
                      <div class="my-prfile-edit" style="display:none;">
                          <div class="row">
                      <div class="col-lg-3 col-12">
                          
                        <div class="tab-profile-user-img">
                           <img src="{{$img_path}}" class="prof_img_original"> <a href="javascript: void(0)"  id="upload_image_original" class="edit-btn-prf"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a> 
                            <input type="file" id="imgupload_original" class="image_original" name="image_original" style="display:none" accept="image/*" />
                        </div>
                      </div>
                      <div class="col-lg-9 col-12">
                       <form id="my-prof-edit">
                           <ul class="bsc-inf prf-edit-form">
                          <li class="us-nam">
                            <div class="row">
                              <div class="col-lg-6 col-12">
                                <input placeholder="First Name" type="text" class="form-control" value="{{ old('name', Auth::guard('user')->user()->name) }}" name="name" >
                                <span id="txtusername_prof_emp"></span>
                              </div>
                              <div class="col-lg-6 col-12">
                                <input placeholder="Last Name" type="text" class="form-control " name="surname" value="{{ old('surname', $user->surname)  }}"  >
                                <span id="txtsurname_prof_emp"></span></div>
                              </div>
                            
                            </li>
                            <li class="des">
                              <input placeholder="Role" type="text" class="form-control "  name="position" value="{{ old('position', Auth::guard('user')->user()->position ?? '')  }}" >
                                <span id="txtposition_prof_emp"></span>
                              </li>
                              <li class="tl">
                              <input  placeholder="Phone" name="full" type="text" value="{{ old('phone') ? old('phone') : Auth::guard('user')->user()->phone ?? '' }}" id="phone_prof_emp" class="form-control pno05  " maxlength="15"/>
                                <span id="txtphone_prof"></span>
                              </li>
                            <li class="inf">
                              <input placeholder="Email" type="text" class="form-control" name="email" value="{{ old('email', Auth::guard('user')->user()->email)  }}" >
                            <span id="txtemail_prof_emp"></span>
                              </li>
                          
                        </ul>
                        <button type="submit" class="greenButton btn-save" value="Save">Save</button>
                        
                       </form>
                        <button class="greenButton  btn-cancel_2 prof-save-btn" onclick="HideEditprof()">Cancel</button>
                      </div>
                    </div>
                    
                      </div>
                      
                      <span id="submitmessage_prof" style="display:none;"></span>
                      <?php
                      $parent_id="";
                      if(Auth::guard('user')->user()->seller_type=="Co-Seller")
                            $parent_id=Auth::guard('user')->user()->parent_id;
                      ?>
                      @if($user->id == Auth::guard('user')->user()->id || $user->id == $parent_id )
                      <div class="ch-pwd">
                        
                        <h3>Change Password</h3>
                        <form  id='cf-form'>
                        @csrf
                        <input type="hidden" name="email" value="{{ Auth::guard('user')->user()->email}}">    
                        <div class="row">
                          <div class="col-lg-4 col-12">
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Current Password</label>
                              <input name="oldPassword" id="cntpw" type="password" class="form-control {{ $errors->has('oldPassword') ? ' is-invalid' : '' }}"  placeholder="" value="{{ old('oldPassword') }}" required>
                              <span id="old_pw"></span>
                            </div>
                          </div>
                          <div class="col-lg-4 col-12">
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">New Password</label>
                              <input value="{{ old('password') }}" id="password" type="password" class="pr-password  form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                               <span id="new_pw"></span>
                            </div>
                          </div>
                          <div class="col-lg-4 col-12">
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
                              <input value="{{ old('password_confirmation') }}" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            <span id="confirm_pw"></span>
                            </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-lg-8 col-12"></div>
                          <div class="col-lg-4 col-12">
                            <button type="submit" class="blue-button">Update Password</button>
                          </div>
                        </div>
                        </form>
         <div id="pw_updated"></div>   
                        
                        <a href="javascript:void(0)" 
   @if($delete_request_active==false)
     onClick="deleteProfileaccount({{Auth::guard('user')->user()->id}})" 
     class="default-btn ctr mr-pro"
   @else
   onClick="deletedProfileaccount({{Auth::guard('user')->user()->id}})" 
     class="default-btn ctr mr-pro gray-btn45"
      title="Already a Request for Account Delete Sent to Admin"
   @endif 
    >Request for Account Delete</a> 
                        
                        
                        
                        
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
        
        </div>

      </div>
    </div>
  </div>
  <!--container-->
 
  <!-- Modal -->

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
  
  

<div class="modal fade" id="exampleModa5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Invite</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
					  <form id="divcosellers"> 
                        <ul class="bsc-inf prf-edit-form">
                            
                           <!-- 
                            <li>
                                <div class="row">
                                <div class="col-lg-3 col-12">
                <div class="pr-logo"><img src="{{asset('/uploads/defaultImages/images_not_avaailable.png')}}" class="prof_img_employee" id="prof_img_employee" > <a href="javascript: void(0)" id="upload_image_employees" class="edit"> <i class="fa fa-camera" aria-hidden="true"></i></a> </div>
                <input type="file" id="imgupload_employee" class="image" name="imgupload_employee" accept=".jfif,.jpg,.jpeg,.png,.gif" style="display:none"     onchange="loadFile(event)"/>
              </div><div class="col-lg-9 col-12">&nbsp;</div>
              </div>
                            </li>
                           --> 
                            
                            
                          <li class="us-nam">
                            <div class="row">
							
                              <div class="col-lg-6 col-12">
                                
								<input  placeholder="First Name" type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" required value="{{ old('name') }}" >
                                <span id="txtname_employee"></span>
							  </div>
                              <div class="col-lg-6 col-12">
								<input  placeholder="Last Name" type="text" name="surname" class="form-control {{ $errors->has('surname') ? ' is-invalid' : '' }}" required value="{{ old('surname') }}" >
                                <span id="txtsurname_employee"></span>
							  </div>
                            </div>
                          </li>
                          <li class="des">
						  
						  
                          <input  placeholder="Role" type="text" name="position" class="form-control {{ $errors->has('position') ? ' is-invalid' : '' }}" required value="{{ old('position') }}" >
						   <span id="txtrole_employee"></span>
						  </li>
                          
						  <li class="tl">
						  <input  placeholder="Phone" id="phone_employee" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="full"  required maxlength="15" value="{{ old('phone') }}">
						 <span id="txtphone_employee"></span>
						 </li>
						 <li class="inf">
						  <input placeholder="Email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required value="{{ old('email') }}">
							<span id="txtemail_employee"></span>
						  </li>
                          
                          
                       <!--<li class="us-nam">
                            <div class="row">
                              <div class="col-lg-6 col-12">
                                <input  placeholder="Password"  autocomplete="off" id="password_c"  type="password" class="pr-password  form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required value="{{ old('password') }}">
								<span id="txtpassword_employee"></span>
								</div>
                              <div class="col-lg-6 col-12">
								<input  placeholder="Confirm Password"  autocomplete="off" type="password" id="password-confirm" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation"  value="{{ old('password_confirmation') }}">
								<span id="txtpassword_confirmation_employee"></span>
								</div>
                            </div>
                          </li> -->
                        </ul>
                        <button type="submit" class="green-button btn-save">Send Invite</button>
						</form>
						
						
                      </div>
                      <div class="modal-footer"> </div>
                    </div>
                  </div>
                </div>










  
  
  
  
  
  
</section>
<style>
   
#chartdiv {
  width: 100%;
  height: 500px;
  position:relative;
}
.chart-outer{
    display:block;
    width: 100%;
  height: 500px;
}
</style>

        <script src="{{ asset('js/io_range-slider.min.js')}}"></script>
        <link rel="stylesheet" href="{{ asset('/css/io_rangeslider.css')}}"> 
        <link rel="stylesheet" href="{{ asset('/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('/css/jquery.passwordRequirements.css')}}">
        <script src="{{ asset('js/jquery.passwordRequirements.js')}}"></script>
        <script src="{{ asset('js/jquery.passwordRequirements.min.js')}}"></script>
        <link rel="stylesheet" href="{{ asset('/css/intlTelInput.css')}}">
        <script src="{{ asset('js/intlTelInput.min.js')}}"></script>
       
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.2.2/tinymce.min.js"></script> 
                    
<script type="text/javascript">

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
    else { }
    });  
}

function deletedProfileaccount(userid){
//swal("Already a Request for Account Delete Sent to Admin", "", "success");
 swal("Already a Request for Account Delete Sent to Admin");
}
function fnclosepopup1(){
     $fmcg("#Mymodal").modal('hide');
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
                 var url = new URL(window.location.href);
                 url.searchParams.set('tab','myprofile');
                 window.location.href = url.href;
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
               swal(errorThrown, "", "error");
             }  
   
           })  ;

}



   function addtonetwork(userid)
   {
      // $fmcg(".loaderajax").show();
    $fmcg.ajax({
            url: "{{ url('profile_to_network') }}",
               type: "get",
               data:{ 
                   user_id: userid,
               },
               async:false,
               cache: false,
               dataType: 'json',
               success: function(data){ 
                   //$fmcg(".loaderajax").hide();
                 swal(data, "", "success");
                 $fmcg(".clsa"+userid).remove();
                 $fmcg(".clschat"+userid).show();
                
                 $fmcg("#network_list").empty();
                 getnetworkList();
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
                // $fmcg(".loaderajax").hide();
               swal(errorThrown, "", "error");
             }  
   
           })  ;
  }
    function EnableChatRequest(seller_id){
          $fmcg(".message-input").css("display", "block");
          $fmcg("#frame").css("display", "block");
          $fmcg(".content").css("display", "block");
          $fmcg("#frame").css("width", "95%");
        
         
          $fmcg("#selected_id").val(seller_id);
          loadMessage();
          $fmcg("#frame").show();
          senter = seller_id;
          $fmcg("#txt_message").focus();      
           
        
}


        function removeImageabt1(id = null){ 
            if(confirm('Do you want to remove image?')){
                if(id != null){
                    $fmcg.ajax({
                        type:'GET',
                        url:'{{ route("abt1.removeImage") }}',
                        data:{id: id, '_token':'{{csrf_token()}}'},
                        success:function(response){
                            if(response.result){
                               
                                $fmcg(".abt1_img").attr("src", "{{asset('assets/images/no_img.jpg')}}");
                                $fmcg(".abt1_remove").hide();
                                
                               
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                } else {
                    alert('Image remove failed. Something went wrong.');
                }
            }
        }

        function removeImageabt2(id = null){ 
            if(confirm('Do you want to remove image?')){
                if(id != null){
                    $fmcg.ajax({
                        type:'GET',
                        url:'{{ route("abt2.removeImage") }}',
                        data:{id: id, '_token':'{{csrf_token()}}'},
                        success:function(response){
                            if(response.result){
                               
                                $fmcg(".abt2_img").attr("src", "{{asset('assets/images/no_img.jpg')}}");
                                $fmcg(".abt2_remove").hide();
                               
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                } else {
                    alert('Image remove failed. Something went wrong.');
                }
            }
        }
        





 //var $fmcg = $.noConflict();
    tinymce.init({ selector:'textarea#mytextarea',
    plugins: '',
    imagetools_cors_hosts: ['picsum.photos'],
    menubar: 'file edit view insert format tools table help',
    toolbar: 'undo redo | bold italic | fontselect fontsizeselect formatselect  |   ltr rtl',
    toolbar_sticky: true,
    autosave_ask_before_unload: true,
    autosave_interval: "30s",
    autosave_prefix: "{path}{query}-{id}-",
    autosave_restore_when_empty: false,
    autosave_retention: "2m",
    image_advtab: true,
    content_css: '//www.tiny.cloud/css/codepen.min.css',
    link_list: [
      { title: 'My page 1', value: 'http://www.tinymce.com' },
      { title: 'My page 2', value: 'http://www.moxiecode.com' }
    ],
    image_list: [
      { title: 'My page 1', value: 'http://www.tinymce.com' },
      { title: 'My page 2', value: 'http://www.moxiecode.com' }
    ],
    image_class_list: [
      { title: 'None', value: '' },
      { title: 'Some class', value: 'class-name' }
    ],
    importcss_append: true,
    height: 400,
    file_picker_callback: function (callback, value, meta) {
      /* Provide file and text for the link dialog */
      if (meta.filetype === 'file') {
        callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
      }

      /* Provide image and alt text for the image dialog */
      if (meta.filetype === 'image') {
        callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
      }

      /* Provide alternative source and posted for the media dialog */
      if (meta.filetype === 'media') {
        callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
      }
    },
    templates: [
          { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
      { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
      { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
    ],
    template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
    template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
    height: 300,
    image_caption: true,
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    noneditable_noneditable_class: "mceNonEditable",
    toolbar_mode: 'sliding',
    contextmenu: "link image imagetools table",
    valid_elements: "*[*]",
    images_upload_handler: function (blobInfo, success, failure) {
    var xhr, formData;
    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', "{{route('content.ajaxtiny')}}");
    xhr.onload = function() {
      var json;

      if (xhr.status != 200) {
      failure('HTTP Error: ' + xhr.status);
      return;
      }
      json = JSON.parse(xhr.responseText);

      if (!json || typeof json.location != 'string') {
      failure('Invalid JSON: ' + xhr.responseText);
      return;
      }
      success(json.location);
    };
    formData = new FormData();
    formData.append('_token', "{{ csrf_token() }}");
    formData.append('file', blobInfo.blob(), blobInfo.filename());
    xhr.send(formData);
    }
  });

  </script>
 
 
 <script type="text/javascript">
 function SelctAllSub(continent){
    
     if ($fmcg(".parent_cont"+continent).is(':checked')) 
     $fmcg( ".sub_countries_cont"+continent ).prop( "checked", true );
     else
     $fmcg( ".sub_countries_cont"+continent ).prop( "checked", false );
     
 }
  function SelctAllSubExpnd(continent){
    
     if ($fmcg(".parent_contExpnd"+continent).is(':checked')) 
     $fmcg( ".sub_countries_Subcont"+continent ).prop( "checked", true );
     else
     $fmcg( ".sub_countries_Subcont"+continent ).prop( "checked", false );
     
 }
 $fmcg('#upload_image_original').click(function(){  
$fmcg('#imgupload_original').trigger('click'); 

 });
$fmcg(".image_original").change(function(e) {  
     
var data = new FormData();
data.append('image_original', this.files[0]);
data.append('_token', "{{ csrf_token() }}"); 
$fmcg.ajax({
        url:'{{route('updateProfimage')}}',
        type: 'POST',
        data : data,
        enctype : 'multipart/form-data',
        contentType: false,
        processData: false,
        success: function( data ) { 
            var baseUrl = "{{asset('')}}";
            var imageUrl = baseUrl + data.image_path;
            $fmcg('.prof_img_original').attr('src', imageUrl);
          //  $fmcg('#changeimage').html('<img src="'+ imageUrl +'" height="120px" width="150px">');
        },
        error: function() {
          //  alert('Upload Failed');
        }
       });   
    });		
 
  function editMyProfile(){

 $fmcg(".my-prfile-edit").show();
 $fmcg(".my-prfile-view").hide();
  }
  
 function HideEdit(){ //alert('test');
 $fmcg(".edit_top").css("display", "none");
 $fmcg(".profile_top").css("display", "block");
 $fmcg(".profile_top").show();
 $fmcg(".edit_form").hide();
 $fmcg(window).scrollTo(0, document.body.scrollHeight);
  }
  function HideEditAbout(){ 
   $fmcg(".edit_tab1").css("display", "none");
   $fmcg(".view_tab1").css("display", "flex");
   $fmcg(window).scrollTo(0, document.body.scrollHeight);
  }
  function HideEditprof(){ 
  $fmcg(".my-prfile-view").show();
  $fmcg(".my-prfile-edit").hide();
$fmcg("#submitmessage_prof").css("display", "none");
  }

    
 
 
 function deleteconfirm(id){
      $fmcg('#delete_emp'+id).submit(function(e) { 
          e.preventDefault();
            var formData = new FormData($fmcg('#delete_emp'+id)[0]);
            formData.append('_token', "{{ csrf_token() }}"); 
            // Send an AJAX request
             $fmcg.ajax({
                type: "post",
                url: "{{ route('deleteCoEmployee') }}",
                data: formData,
                enctype : 'multipart/form-data',
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                    //$fmcg(".loaderajax").hide();
                    swal('Employee Deleted!'); 
                    
                    $fmcg('.edt-emp'+id).hide();
                    //data.message
                   /* if(data)
                        $fmcg("#mail_send_success").empty().append("<p style='color:red'>"+data+"</p>");
                      else
                        $fmcg("#mail_send_success").empty();*/ 
                       
                        
                },
                error: function (xhr) {
                 
                   
                  $fmcg(window).scrollTo(0, document.body.scrollHeight);
                   // $fmcg(window).scrollTop(0);
                               
                }
            });

        });
         
         
            

        
      
     
  
     
 
}
var input = window.intlTelInput(document.querySelector("#phone_prof_emp"), {
  separateDialCode: true,
  preferredCountries:["nl"],
  hiddenInput: "phone",
  utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
});
var input = window.intlTelInput(document.querySelector("#phone"), {
  separateDialCode: true,
  preferredCountries:["nl"],
  hiddenInput: "company_phone",
  utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
}); 
 var input = window.intlTelInput(document.querySelector("#phone_employee"), {
  separateDialCode: true,
  preferredCountries:["nl"],
  hiddenInput: "phone",
  utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
});
 var loadFile = function(event) {
    var output = document.getElementById('prof_img_employee');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
  function empEdit(id) {
      
      
      if (jQuery('.edit-prf-btnc'+id).hasClass("clicked-once")) {
			jQuery('.edit-prf-btnc'+id).hide(); 
			jQuery('.edit-prf-btnc'+id).removeClass("clicked-once");
    }
    else {
			jQuery('.edit-prf-btnc'+id).addClass("clicked-once");
			jQuery('.edit-prf-btnc'+id).show(); 
    }
      
  }

  jQuery('#upload_image_employees').click(function(){  
            jQuery('#imgupload_employee').trigger('click'); 
      });
      
 


  </script>       
<script>


$fmcg(document).ready(function() {
        $fmcg('#my-prof-edit').submit(function(e) { 
            e.preventDefault();

            // Serialize the form data
           //const formData = new FormData(form);
           var formData = new FormData($fmcg('#my-prof-edit')[0]); 
            formData.append('_token', "{{ csrf_token() }}"); 
            // Send an AJAX request
             $fmcg.ajax({
                type: "post",
                url: "{{ route('updateSellerEmployee') }}",
                data: formData,
                enctype : 'multipart/form-data',
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data.message){
                  $fmcg("#submitmessage_prof").show();
                  $fmcg("#submitmessage_prof").empty().append('<div class="alert alert-success">'+data.message+'</div>'); 
                  $fmcg("#submitmessage_prof").delay(1000).fadeOut(1000);
                    }
                   // setTimeout(window.location.reload(),10);
                    var url = new URL(window.location.href);
                    url.searchParams.set('tab','myprofile');
                    window.location.href = url.href;
                 /*   
                  $fmcg(".my-prfile-edit").css("display", "none");
                   $fmcg(".my-prfile-view").show();
                   $fmcg(".my-prfile-edit").hide();
                    */
                        
                },
                error: function (xhr) {
                   // $fmcg(".loaderajax").hide();
                    //$fmcg("#btnsubmit").prop('disabled', false);
                

                    var errors = JSON.parse(xhr.responseText);  
                   
                    
                   if(errors.errors.name)
                    $fmcg("#txtusername_prof_emp").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.name[0]+"</p>");
                    else
                      $fmcg("#txtusername_prof_emp").empty();
                      
                    if(errors.errors.email) {
                    $fmcg("#txtemail_prof_emp").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.email[0]+"</p>"); }
                    else
                      $fmcg("#txtemail_prof_emp").empty();
                    if(errors.errors.surname)
                    $fmcg("#txtsurname_prof_emp").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.surname[0]+"</p>");
                    else
                      $fmcg("#txtsurname_prof_emp").empty();
                    if(errors.errors.phone)
                    $fmcg("#txtphone_prof").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.phone[0]+"</p>");
                    else
                      $fmcg("#txtphone_prof").empty();
				    if(errors.errors.position)
                    $fmcg("#txtposition_prof_emp").empty().append("<p style='color:red'>"+errors.errors.position[0]+"</p>");
                    else
                      $fmcg("#txtposition_prof_emp").empty();
                        
                  $fmcg(window).scrollTo(0, document.body.scrollHeight);
                   // $fmcg(window).scrollTop(0);
                               
                }
            });

        });
    });
	
	


$fmcg('document').ready(function() {
 // var errorcount='<?php echo count($errors);?>';
 //   if(errorcount>0)
   // $fmcg('#exampleModa5').modal('show');
    $fmcg("#divcosellers").on('submit', function(e) {
            //$fmcg(".loaderajax").show();
            e.preventDefault();
            var formData = new FormData($fmcg('#divcosellers')[0]);
            formData.append('_token', "{{ csrf_token() }}"); 

                $fmcg.ajax({
                type: "post",
                url: "{{route('addNewEmployees')}}",
                data: formData,
                enctype : 'multipart/form-data',
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                   // $fmcg(".loaderajax").hide(); 
                    swal(data, "", "success");
                    //setTimeout(window.location.reload(true),300);
                    
                    var url = new URL(window.location.href);
                    url.searchParams.set('tab','employees');
                    window.location.href = url.href;
                },
                error: function (xhr) {
                   //$fmcg(".loaderajax").hide(); 
                    var errors = JSON.parse(xhr.responseText);
                         
                    if(errors.errors.name)
                    $fmcg("#txtname_employee").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.name[0]+"</p>");
                    else
                      $fmcg("#txtname_employee").empty();
                    if(errors.errors.email)
                    $fmcg("#txtemail_employee").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.email[0]+"</p>");
                    else
                      $fmcg("#txtemail_employee").empty();
                    if(errors.errors.username)
                    $fmcg("#txtusername_employee").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.username[0]+"</p>");
                    else
                      $fmcg("#txtusername_employee").empty();
                    if(errors.errors.phone){ 
                    $fmcg("#txtphone_employee").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.phone[0]+"</p>"); }
                    else
                      $fmcg("#txtphone_employee").empty();
                    /*if(errors.errors.password)
                    $fmcg("#txtpassword_employee").empty().append("<p style='color:red'>"+errors.errors.password[0]+"</p>");
                    else
                      $fmcg("#txtpassword_employee").empty();
                    if(errors.errors.password_confirmation)
                    $fmcg("#txtpassword_employee_confirmation").empty().append("<p style='color:red'>"+errors.errors.password_confirmation[0]+"</p>");
                    else
                      $fmcg("#txtpassword_employee_confirmation").empty();*/
                       
                               
                }
            });
          }); 
});









/*

var input = window.intlTelInput(document.querySelector("#phone"), {
  separateDialCode: true,
  preferredCountries:["nl"],
  hiddenInput: "phone",
  utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
});*/


$fmcg("#form_about").on('submit', function(e) {
             
            e.preventDefault();
            var formData = new FormData($fmcg('#form_about')[0]);
            formData.append('_token', "{{ csrf_token() }}");
               var about_company = tinymce.activeEditor.getContent(); 
 formData.append('about_company', about_company);
                $fmcg.ajax({
                type: "post",
                url: "{{route('updateCompAbout')}}",
                data: formData,
                enctype : 'multipart/form-data',
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                   // $fmcg(".loaderajax").hide();
                   $fmcg("#submitmessage").show();
                  $fmcg("#submitmessage").empty().append('<div class="alert alert-success">'+data+'</div>'); 
                  $fmcg("#submitmessage").delay(1000).fadeOut(500);
                   $fmcg(".edit_tab1").css("display", "none");
                   $fmcg(".view_tab1").show();
                   $fmcg(".edit_tab1").hide();
                   
                   //setTimeout(window.location.reload(),10);
                   var url = new URL(window.location.href);
                    url.searchParams.set('tab','about');
                    window.location.href = url.href;
                },
                error: function (xhr) {
                   //$fmcg(".loaderajax").hide();
                    var errors = JSON.parse(xhr.responseText);
                      
                    if(errors.errors.about_company)
                    $fmcg("#txtabt").empty().append("<p  class='txt_err' style='color:red'> About is required</p>");
                    else
                      $fmcg("#txtabt").empty();
                    
                    $fmcg("#submitmessage").show();
                    $fmcg("#submitmessage").empty().append('<div class="alert alert-warning">Update Failed!!</div>');
                    $fmcg("#submitmessage").delay(1000).fadeOut(500);
                    $fmcg(window).scrollTo(0, document.body.scrollHeight);
                               
                }
            });
          });  

$fmcg("#region-form").on('submit', function(e) {
             
            e.preventDefault();
            var formData = new FormData($fmcg('#region-form')[0]);
            formData.append('_token', "{{ csrf_token() }}");
                

                $fmcg.ajax({
                type: "post",
                url: "{{route('updateCompanyRegions')}}",
                data: formData,
                enctype : 'multipart/form-data',
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                   // $fmcg(".loaderajax").hide();
                   $fmcg("#submitmessage").show();
                   $fmcg("#submitmessage").empty().append('<div class="alert alert-success">'+data+'</div>'); 
                   $fmcg("#submitmessage").delay(1000).fadeOut(500);
                   $fmcg(".edit_tab1").css("display", "none");
                   $fmcg(".view_tab1").show();
                   $fmcg(".edit_tab1").hide();
               <?php Session::put("tab", "myRegions"); ?>
                   setTimeout(window.location.reload(),10);
                   //var url = new URL(window.location.href);
                  //  url.searchParams.set('tab','regions');
                   // window.location.href = url.href;
                },
                error: function (xhr) {
                   //$fmcg(".loaderajax").hide();
                    var errors = JSON.parse(xhr.responseText);
                    $fmcg("#submitmessage").show();
                    $fmcg("#submitmessage").empty().append('<div class="alert alert-warning">Update Failed!!</div>');
                    $fmcg("#submitmessage").delay(1000).fadeOut(500);
                    
                    $fmcg(window).scrollTo(0, document.body.scrollHeight);
                               
                }
            });
          });  

$fmcg("#compny_profile").on('submit', function(e) { 
             // $fmcg(".loaderajax").show();
             
            e.preventDefault();
             
            var formData = new FormData($fmcg('#compny_profile')[0]);
            formData.append('_token', "{{ csrf_token() }}"); 
           
                

                $fmcg.ajax({
                type: "post",
                url: "{{route('updateCompProf')}}",
                data: formData,
                enctype : 'multipart/form-data',
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                   // $fmcg(".loaderajax").hide();
                  $fmcg("#submitmessage").empty().append('<div class="alert alert-success">'+data+'</div>');
                    
                    setTimeout(window.location.reload(),300);
                    $fmcg(window).scrollTo(0, document.body.scrollHeight);
                },
                error: function (xhr) {
                   //$fmcg(".loaderajax").hide();
                    var errors = JSON.parse(xhr.responseText);
                    
                      
                    if(errors.errors.image)
                    $fmcg("#txtimgpicture").empty().append("<p  class='txt_err' style='color:red'>Company logo is required</p>");
                    else
                      $fmcg("#txtimgpicture").empty();
                      
                      if(errors.errors.company_email)
                    $fmcg("#txtemail").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.company_email[0]+"</p>");
                    else
                      $fmcg("#txtemail").empty();
                    
                    if(errors.errors.company_phone)
                    $fmcg("#txtphone").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.company_phone[0]+"</p>");
                    else
                      $fmcg("#txtphone").empty();
                      
                     
                      
                    if(errors.errors.company_name)
                    $fmcg("#txtcompany").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.company_name[0]+"</p>");
                    else
                      $fmcg("#txtcompany").empty();
                    if(errors.errors.company_type)
                    $fmcg("#txtcompanytype").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.company_type[0]+"</p>");
                    else
                      $fmcg("#txtcompanytype").empty();
                    if(errors.errors.company_location)
                    $fmcg("#txtcompanylocation").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.company_location[0]+"</p>");
                    else
                      $fmcg("#txtcompanylocation").empty();
                    if(errors.errors.company_street)
                    $fmcg("#txtcompanystreet").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.company_street[0]+"</p>");
                    else
                      $fmcg("#txtcompanystreet").empty();
                    if(errors.errors.company_zip)
                    $fmcg("#txtcompanyzipcode").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.company_zip[0]+"</p>");
                    else
                      $fmcg("#txtcompanyzipcode").empty();
                    if(errors.errors.country_id)
                    $fmcg("#txtcnryid").empty().append("<p  class='txt_err' style='color:red'>Country field is required</p>");
                    else
                      $fmcg("#txtcnryid").empty();
                     
                    if(errors.errors.offline_categories)
                   { $fmcg("#offline_categories1").empty().append("<p  class='txt_err' style='color:red'>Select the categories your company is active in</p>");
                   }
                    else
                      $fmcg("#offline_categories1").empty();
                     /* if(errors.errors.offline_categories)
                   { $fmcg("#company_types1").empty().append("<p style='color:red'>Select your company type</p>");
                   }
                    else
                      $fmcg("#company_types1").empty();*/
                    $fmcg("#submitmessage").empty().append('<div class="alert alert-warning">Profile Update Failed!!</div>');
                    $fmcg("#submitmessage").delay(1000).fadeOut(500);
                    $fmcg(window).scrollTo(0, document.body.scrollHeight);
                               
                }
            });
          });  




var route = "{{route('offline.categories')}}";
   $fmcg('#offline_categories').select2({
     placeholder: 'Select Product Categories',

    
    ajax: {
      url: route,
      dataType: 'json',
      delay: 250,
      processResults: function(data) {
        return {
          results: $fmcg.map(data, function(item) {
            return {
              html:"<span>"+item.name+"</span>",
              text: item.name,
              id: item.id
            }
          })
        };
      },
      cache: true,

    }
  });
var route1 = "{{route('company.types')}}";
   $fmcg('#company_type').select2({
     placeholder: 'Select Company Types',
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



$fmcg(document).ready( function () {
            $fmcg(".pr-password").passwordRequirements({

});
        });
function editfrm(){
 $fmcg(".edit_top").css("display", "block");
 $fmcg(".cover-c.edit_form").css("display", "block");
 $fmcg(".profile_top").hide();
 $fmcg(".edit_form").show();
}

function edittab1(){
 $fmcg(".edit_tab1").css("display", "block");
 $fmcg(".view_tab1").hide();
 $fmcg(".edit_tab1").show();
}
function editmap(){
 $fmcg(".map-descrip_view").hide();
 $fmcg(".map-descrip_edit").show();
}
function HideEditRegions(){ 
   $fmcg(".map-descrip_edit").css("display", "none");
   $fmcg(".map-descrip_view").css("display", "block");
   $fmcg(window).scrollTo(0, document.body.scrollHeight);
  }
function HideEditEmployees(){ 
   $fmcg("#edit_active").val('no');
   $fmcg(".edit_emp_icon").css("display", "none");
   $fmcg(".parentYes").css("display", "block");
   $fmcg(window).scrollTo(0, document.body.scrollHeight);
  }   
function edittabEployees(){
 
 $fmcg("#edit_active").val('yes');
 $fmcg(".edit_emp_icon").css("display", "block");
 $fmcg(".parentYes").css("display", "none");
}	


$fmcg('#upload_abtimg2').click(function(){  
$fmcg('#imgupload_abtimg2').trigger('click'); 
});
 
 
$fmcg(".about_image2").change(function(e) {  
var data = new FormData();
data.append('about_image2', this.files[0]);
data.append('_token', "{{ csrf_token() }}"); 
$fmcg.ajax({
        url:'{{route('updateAbtimg2')}}',
        type: 'POST',
        data : data,
        enctype : 'multipart/form-data',
        contentType: false,
        processData: false,
        success: function( data ) { 
            var baseUrl = "{{asset('')}}";
            var imageUrl = baseUrl + data.image_path;
            $fmcg('.abt2_img').attr('src', imageUrl);
            $fmcg(".abt2_remove").show()
          //  $fmcg('#changeimage').html('<img src="'+ imageUrl +'" height="120px" width="150px">');
        },
        error: function(xhr) {
          var errors = JSON.parse(xhr.responseText); 
         if(errors.message)
            $fmcg("#about_img2_error").empty().append("<p  class='txt_err' style='color:red'>"+errors.message+"</p>");
          else
            $fmcg("#about_img2_error").empty();
                      
        }
       });   
    });

$fmcg('#upload_abtimg1').click(function(){  
$fmcg('#imgupload_abtimg1').trigger('click'); 
});
 
 
 $fmcg(".about_image1").change(function(e) {  
     
var data = new FormData();
data.append('about_image1', this.files[0]);
data.append('_token', "{{ csrf_token() }}"); 
$fmcg.ajax({
        url:'{{route('updateAbtimg1')}}',
        type: 'POST',
        data : data,
        enctype : 'multipart/form-data',
        contentType: false,
        processData: false,
        success: function( data ) { 
            var baseUrl = "{{asset('')}}";
            var imageUrl = baseUrl + data.image_path;
            $fmcg('.abt1_img').attr('src', imageUrl);
          //  $fmcg(".abt1_remove").show();
           
            $fmcg("a.btn.abt1_remove").show();
            $fmcg("a.btn.abt1_remove").css("display", "block");
            $fmcg(".abt1_remove").css("display", "block");
          //  $fmcg('#changeimage').html('<img src="'+ imageUrl +'" height="120px" width="150px">');
        },
        error: function(xhr) {
          var errors = JSON.parse(xhr.responseText); 
         if(errors.message)
            $fmcg("#about_img1_error").empty().append("<p  class='txt_err' style='color:red'>"+errors.message+"</p>");
          else
            $fmcg("#about_img1_error").empty();
                      
        }
       });   
    });




$fmcg('#upload_image').click(function(){  
$fmcg('#imgupload').trigger('click'); 

 });
//$fmcg(".image").change(function(e) {  
$fmcg(".company_image").change(function(e) {       
var data = new FormData();
//data.append('image', $fmcg('input[type=file]')[0].files[0]);
data.append('company_image', this.files[0]);
//data.append('image', this.files[0]);
data.append('_token', "{{ csrf_token() }}"); 
$fmcg.ajax({
        url:'{{route('updateCompimage')}}',
        type: 'POST',
        data : data,
        enctype : 'multipart/form-data',
        contentType: false,
        processData: false,
        success: function( data ) { 
            var baseUrl = "{{asset('')}}";
            var imageUrl = baseUrl + data.image_path;
            $fmcg('.prof_img').attr('src', imageUrl);
          //  $fmcg('#changeimage').html('<img src="'+ imageUrl +'" height="120px" width="150px">');
        },
        error: function(xhr) {
          var errors = JSON.parse(xhr.responseText); 
         if(errors.message)
            $fmcg("#company_logo_error").empty().append("<p  class='txt_err' style='color:red'>"+errors.message+"</p>");
          else
            $fmcg("#company_logo_error").empty();
                      
        }
       });   
    });
$fmcg('#upload_cmpBanner').click(function(){  
$fmcg('#imgupload_banner').trigger('click'); 
});
 
 
 $fmcg(".image_banner").change(function(e) {  
     
var data = new FormData();
data.append('image_banner', $fmcg('input[type=file]')[0].files[0]);
data.append('_token', "{{ csrf_token() }}"); 
$fmcg.ajax({
        url:'{{route('updateCompbanner')}}',
        type: 'POST',
        data : data,
        enctype : 'multipart/form-data',
        contentType: false,
        processData: false,
        success: function( data ) { 
            var baseUrl = "{{asset('')}}";
            var imageUrl = baseUrl + data.image_path;
            $fmcg('.banner_img').attr('src', imageUrl);
          //  $fmcg('#changeimage').html('<img src="'+ imageUrl +'" height="120px" width="150px">');
        },
        error: function(xhr) {
            //alert(errors.message);
          var errors = JSON.parse(xhr.responseText); 
         if(errors.message)
            $fmcg("#bnner_image_error").empty().append("<p  class='txt_err' style='color:red'>"+errors.message+"</p>");
          else
            $fmcg("#bnner_image_error").empty();
                      
        }
        
        
       });   
    });




    $fmcg(document).ready(function() {
        $fmcg('#cf-form').submit(function(e) { 
            e.preventDefault();

            // Serialize the form data
           //const formData = new FormData(form);
           var formData = new FormData($fmcg('#cf-form')[0]); 
            formData.append('_token', "{{ csrf_token() }}"); 
            // Send an AJAX request
             $fmcg.ajax({
                type: "post",
                url: "{{ route('UserResetPassword') }}",
                data: formData,
                enctype : 'multipart/form-data',
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                    //$fmcg(".loaderajax").hide();
                    
                    //data.message
                    if(data.msg_old)
                       { $fmcg("#new_pw").empty();
                           $fmcg("#old_pw").empty().append("<p  class='txt_err' style='color:red'>"+data.msg_old+"</p>");}
                      else
                        $fmcg("#old_pw").empty(); 
                        if(data.message) {
                            $fmcg("#old_pw").empty(); 
                            $fmcg("#new_pw").empty(); 
                            $fmcg('#cntpw').val('');
                            $fmcg('#password').val('');
                            $fmcg('#password-confirm').val('');
                        $fmcg("#pw_updated").empty().append("<p style='color:green'>"+data.message+"</p>");
                        }
                      else
                        $fmcg("#pw_updated").empty();
                        
                },
                error: function (xhr) {
                   // $fmcg(".loaderajax").hide();
                    //$fmcg("#btnsubmit").prop('disabled', false);
                    $fmcg("#loading-image").hide(); 

                    var errors = JSON.parse(xhr.responseText);  
                   
                    
                    if(errors.errors.oldPassword)
                    { 
                    $fmcg("#new_pw").empty();    
                    $fmcg("#old_pw").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.oldPassword[0]+"</p>");
                    
                    }
                    else
                      $fmcg("#old_pw").empty();
                      
                    if(errors.errors.password)
                        $fmcg("#new_pw").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.password[0]+"</p>");
                      else
                        $fmcg("#new_pw").empty();
                        
                     if(errors.errors.password_confirmation)
                        $fmcg("#confirm_pw").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.password_confirmation[0]+"</p>");
                      else
                        $fmcg("#confirm_pw").empty();  
                        if(errors.errors.password_confirmation)
                        
                  $fmcg(window).scrollTo(0, document.body.scrollHeight);
                   // $fmcg(window).scrollTop(0);
                               
                }
            });

        });
    });
    
   function empSubmit(id) {
  
      
        $fmcg('#pw_reset'+id).submit(function(e) { 
            e.preventDefault();

            // Serialize the form data
           //const formData = new FormData(form);
          // var formData = new FormData($fmcg('#pw_reset')+id+[0]); 
          var email=  $fmcg('#EmpEmail'+id).val() ;
            var formData = new FormData($fmcg('#pw_reset'+id)[0]);
            formData.append('_token', "{{ csrf_token() }}"); 
            // Send an AJAX request
             $fmcg.ajax({
                type: "post",
                //url: "{{ route('employeesPassword.reset') }}",
                url: "{{ route('employeesPassword.reset') }}",
                data: formData,
                enctype : 'multipart/form-data',
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                    //$fmcg(".loaderajax").hide();
                    swal('We have e-mailed your password reset link!'); 
                    //data.message
                   /* if(data)
                        $fmcg("#mail_send_success").empty().append("<p style='color:red'>"+data+"</p>");
                      else
                        $fmcg("#mail_send_success").empty();*/ 
                       
                        
                },
                error: function (xhr) {
                 
                   
                  $fmcg(window).scrollTo(0, document.body.scrollHeight);
                   // $fmcg(window).scrollTop(0);
                               
                }
            });

        });
 
   } 
    
</script>
<script type="text/javascript">

var range_value="0-"+'<?=$max_product_price;?>'; 
var $range = $fmcg(".js-range-slider"),
    range,
    from,
    to;

var priceOnRequest=0;
function range_selfupdate()
{
    var val1 =parseInt($fmcg(".price_from").val());
    var val2 = parseInt($fmcg(".price_to").val());
    if(val1<=val2)
    {
        var max='<?=$max_product_price;?>';
        if(val2>max)
        {
            val1=0;
            val2=max;
            $fmcg(".price_from").val('');
            $fmcg(".price_to").val('');
        } 
        range_value=Math.trunc(val1)+"-"+Math.trunc(val2) ; 
        updateRange(val1,val2);
        $fmcg('#start_from').val(0);
        $fmcg("#product-listing").empty();
        loadproductss(); 
                  
    }
    else if(val1>val2)
    {
     var val2='<?=$max_product_price;?>';
     $fmcg(".price_from").val('');
     $fmcg(".price_to").val('');
      updateRange(0,val2);
    }

}
var updateRange = function (val1,val2) {
    range.update({
        from: val1,
        to: val2
    });
} 


   
var $radios = $fmcg('input[name="priceOnRequest"]');
$radios.click(function () {
    $fmcg('#start_from').val(0);
    $fmcg("#product-listing").empty(); 
  var $this = $fmcg(this);
  if ($this.data('checked')) {
    
    $fmcg(".price-fi-out").css('display','block');
    $fmcg(".grey_slide").css('display','none');
    $fmcg("#p-end"). attr("readonly", false);
    $fmcg("#p-start"). attr("readonly", false);
    $fmcg("#product-listing").empty();
    priceOnRequest=0; 
    loadproductss();
    this.checked = false;
  }
  else
  {
  if($fmcg('#p-req-both'). prop('checked') ){ 
      $fmcg(".price-fi-out").css('display','block');
      $fmcg(".grey_slide").css('display','none');
      $fmcg("#p-end"). attr("readonly", false);
      $fmcg("#p-start"). attr("readonly", false);
  }
  else{ 
      $fmcg(".price-fi-out").css('display','none');
      $fmcg(".grey_slide").css('display','block');
      $fmcg("#p-end"). attr("readonly", true);
      $fmcg("#p-start"). attr("readonly", true);
  }
  $fmcg("#product-listing").empty();
  priceOnRequest=$fmcg('input[name="priceOnRequest"]:checked').val(); 
  loadproductss();
  this.checked = true;
  }
  var $otherRadios = $radios.not($this).filter('[name="'
                                               + $this.attr('name') + '"]');
  $otherRadios.prop('checked', false).data('checked', false);
  $this.data('checked', this.checked);
});
 

 
 

    
  var updateValues = function () {
    $from.prop("value", from);
    $to.prop("value", to);
};

$range.ionRangeSlider({
    onFinish: function (data) {

      range_value=Math.trunc(data.from)+"-"+Math.trunc(data.to) ; 
      $fmcg(".price_from").val(data.from);
      $fmcg(".price_to").val(data.to);
      $fmcg('#start_from').val(0);
      $fmcg("#product-listing").empty();
      fnbtnsearchproduct();   
  }
});
 range = $range.data("ionRangeSlider"); 
   
   
     
     //var $fmcg = $.noConflict();
        $fmcg(document).ready( function () {
            $fmcg('#search_by_category').select2();
            $fmcg('#search_by_brand').select2();
            $fmcg('#search_by_location').select2();
            
            $fmcg("#search_by_name").keydown(function (event) { 
                 if (event.which == 13) { 
                     event.preventDefault();
                     fnbtnsearchproduct();
                 }
            });
            $fmcg("#search_bbd").keydown(function (event) { 
                 if (event.which == 13) { 
                     event.preventDefault();
                     fnbtnsearchproduct();
                 }
            });
           loadproductss();
        });

function fnbtnsearchproduct(){
    $fmcg('#start_from').val(0);
    $fmcg("#product-listing").empty();
    loadproductss();
}
$fmcg(".search_keyword_icon").click(function(e){
                $fmcg('#start_from').val(0);
				$fmcg("#product-listing").empty();
				loadproductss();
            });
function loadproductss(){
//$fmcg(".loaderajax").show();
  <?php if(!empty(request()->route('profId'))) 
	   $user_id= request()->route('profId') ; 
  else $user_id= Auth::guard('user')->user()->id; 
  
  ?>


var user_id = <?php echo $user_id; ?>; 
$fmcg.ajax({ 
                            type : 'post',
                            url:"{{route('loadproductsCompProf')}}",
                            data:{
                              _token:'{{ csrf_token() }}',
                              'user_id':user_id,
                              'category_id': $fmcg('#search_by_category').val(),
                              'brand_id': $fmcg('#search_by_brand').val(),
                              'search_bykeyword':$fmcg('#search_by_name').val(),
                              'search_bbd':$fmcg('#search_bbd').val(),
                              'search_by_location':$fmcg('#search_by_location').val(),
                              'price_range':range_value,
                              'priceOnRequest':priceOnRequest,                              
                              'search':$fmcg('#search_keyword').val(),
                              'start_from':$fmcg('#start_from').val(),
                              'per_page':9
                            },
                           

                            success:function(data)
                            {
                                  
                                   let dataItems = JSON.parse(data);
                                   console.log();
                                   var initial=0;
                                   var string ='';
                                   dataItems.loadProducts.map((item) => {
                                   initial++;
                                   var app_path="<?php echo url('user-product-detail/')?>";
                                string+='<div class="col-lg-4 col-12">';
                                string+='<a  href='+app_path+'/'+item.prd_id+' >';
                                string+='<div class="product-thumbnail hovereffect">';
                                
                                string+='<div class="pro-img"><img src="'+item.prd_img+'"></div>';
                                string+='<div class="product-title">';
                                if (item.name.length > 17) 
                                        var prd_name = item.name.slice(0, 17) + "...";
                                   else
                                        var prd_name = item.name;
                                 string+='<h3>'+prd_name+'</h3>';
								 string+='<h4>'+item.price+'</h4>';
								 if(item.available_countries!="")
								 {
								     if (item.available_countries.length > 17) 
                                        var cntry_name = item.available_countries.slice(0, 17) + "...";
                                     else
                                        var cntry_name = item.available_countries;
								 string+='<div class="pro-no-loc"> <h5> <i class="fa fa-map-marker" aria-hidden="true"></i>'+cntry_name+'</h5></div>';
								 }
								 string+='</div>';
								 <?php //if($user->id != Auth::guard('user')->user()->id && $user->id != Auth::guard('user')->user()->parent_id)
								 if((request()->route('profId')!=null))
								 { ?>
                                string+='<div id="outer_wish'+item.prd_id+'">';
                                if(item.wish_listed == "Yes")
                                string+='<a href="javascript:void(0)" onclick="RemoveWishlist('+item.prd_id+')" class="prd-cls"><i class="fa fa-heart" aria-hidden="true"></i></a>';
                                else
                                string+='<a href="javascript:void(0)" onclick="addToWishlist('+item.prd_id+')" class="prd-cls"><i class="fa fa-heart-o" aria-hidden="true"></i></a>';
                                string+='</div>';
                                string+='<span id="active_wish'+item.prd_id+'" style="display:none;"><a href="javascript:void(0)" onclick="RemoveWishlist('+item.prd_id+')"  class="prd-cls"><i class="fa fa-heart" aria-hidden="true" ></i></a></span>';
                                string+='<span id="inactive_wish'+item.prd_id+'"  style="display:none;"><a  href="javascript:void(0)" onclick="addToWishlist('+item.prd_id+')"   class="prd-cls"> <i class="fa fa-heart-o" aria-hidden="true"></i></a></span> ';
                                <?php } ?>
								 
								 
								 
								 string+='</div></a></div>';
                                })
                                $fmcg("#product-listing").append(string);
                               // $fmcg(".loaderajax").hide();
                                   var skipcount=parseInt($fmcg("#start_from").val())+ initial ;
                                   if(dataItems.count!=skipcount)
                                      $fmcg("#product-listing").append('<div class="row"><div class="default-btn" style="margin:15px auto;" id="loadmore" onclick="loadmore()">Load More</div></div>');
                                 var img_path="<?php echo asset('/uploads/defaultImages/no-image.jpg')?>";  
								 var content_len=$fmcg("#product-listing  div").length; 
                                 if(content_len==0)
                                      $fmcg("#product-listing").append('<img class="no-result11" style="display:table;" src="'+img_path+'"/>');
                               
                                  $fmcg("#start_from").val(skipcount);
         
                                   
                            },
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
                 //$fmcg(".loaderajax").hide();
               swal(errorThrown, "", "error");
             }


                      });

}


editemployees();
function editemployees(){ 
  var profId = null;
  <?php if((request()->route('profId')!=null)) { ?>
        profId = {{request()->route('profId')}}; 
  <?php } ?>
  var user_id = {{Auth::guard('user')->user()->id}}; 
  $fmcg.ajax({ 
                            type : 'post',
                            url:"{{route('loadEmployeesCompProf')}}",
                            data:{
                              _token:'{{ csrf_token() }}',
                              'user_id':user_id,
                              'profId':profId,
                              'start_from':$fmcg('#start_from_empEdit').val(),
                              'per_page':9
                            },
                            success:function(data)
                            {
                                   let dataItems = JSON.parse(data);
                                   console.log();
                                   var initial=0;
                                   var string ='';
                                   var string1 ='';
                                    
                                   dataItems.loadEmployees.map((item) => {
                                   initial++;
                                   
                                   string += '<div class="col-lg-4 col-12 edt-emp' + item.id + ' parent' + item.parent + '">';
                                   string += '<div class="prf-inner">';
                                   string += '<div class=" prf-inner edt-emp' + item.id + '" id="edt-emp' + item.id + '">';
                                   string += '<div class="tab-out-prof12">';
                                   string += '<div class="tab-prf-image"><img src="' + item.prof_img + '">';
                                   string += '</div>';
                                   string += '<a class="edit-btn-prf employee-pen" id="employee_edit_options' + item.id + '" onclick="empEdit(' + item.id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>';
                                   string += '<div class="dropdown edit-prf-new">';
                                   if($fmcg('#edit_active').val()=='no') {
                                   string += '<button style="display:none;" class="btn btn-secondary dropdown-toggle edit_emp_icon" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">';
                                   string += '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>';
                                   string += '</button>';
                                   } else { 
                                   string += '<button  class="btn btn-secondary dropdown-toggle edit_emp_icon" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">';
                                   string += '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>';
                                   string += '</button>';
                                   }
                                   string += '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">';
                                   string += '<li>';
                                   string += '<form id="pw_reset' + item.id + '" >';
                                   string += '<input type="hidden" name="email" id="EmpEmail' + item.id + '" value="' + item.email + '" >';
                                   string += '<button class="dropdown-item" type="submit" onclick="empSubmit(' + item.id + ')">Send password reset</button>';
                                   string += '</form>';
                                   string += '</li>';
                                   string += '<li>';
                                   string += '<form  id="delete_emp' + item.id + '">';
                                   string += '<input type="hidden" name="empId" value="' + item.id + '">';
                                   string += '<button class="dropdown-item" type="submit"   onclick="deleteconfirm(' + item.id + ')">Remove User</button>';
                                   string += ' </form> </li> </ul> </div> </div>';
                                   string += '<ul class="bsc-inf">';
                                   string+='<li class="us-nam">'+item.name+' '+item.surname+'</li>';
								   if (item.position != null)
								   { string+='<li class="des">'+item.position+'</li>'; }
								   string += '<li class="tl"><a href="tel:' + item.phone + '">' + item.phone + '</a></li>';
                                   string += '<li class="inf"><a href="mailto:' + item.email + '">' + item.email + '</a></li>';
                                   string += '</ul> </div> </div> </div></div>';                                
								    
								
                                })
                                $fmcg("#employee-listing-edit").append(string);
                               // $fmcg(".loaderajax").hide();
                                   var skipcount1=parseInt($fmcg("#start_from_empEdit").val())+ initial ; 
                                   if(dataItems.count!=skipcount1)
                                      $fmcg("#employee-listing-edit").append('<div class="row"><div class="default-btn" style="margin:15px auto;" id="loadmore_empEdit" onclick="loadmore_empEdit()">Load More</div></div>');
                                
                               
                                  $fmcg("#start_from_empEdit").val(skipcount1);
         
                                   
                            },
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
                 //$fmcg(".loaderajax").hide();
               swal(errorThrown, "", "error");
             }


                      });

}

function loadmore(){
  $fmcg("#loadmore").remove();
  loadproductss();
}
/*function loadmore_emp(){
  $fmcg("#loadmore_emp").remove();
  loademployees();
}*/
function loadmore_empEdit(){
  $fmcg("#loadmore_empEdit").remove();
  editemployees();
}

$fmcg(document).ready(function(){
 $fmcg(".nav-link").click(function(){ 
    $fmcg(".pro-lft-widget").hide();
  });
  $fmcg("#profile-tab").click(function(){ 
    $fmcg(".pro-lft-widget").show(300);
  });
});




var wish_count = <?=$view_composer_wishCount?>;
        function addToWishlist(id = null){ 
            
                if(id != null){
                    $fmcg.ajax({
                        type:'GET',
                        url:'{{ route("addToWishlist") }}',
                        data:{id: id, '_token':'{{csrf_token()}}'},
                        success:function(response){
                         $fmcg('#active_wish'+id).show();
                         $fmcg('#inactive_wish'+id).hide();
                         wish_count = wish_count+1;
                         $fmcg('.wish-count').html(wish_count);
                         var res = $fmcg('.wish-count').html();
                         if( res == 0)
                            {  $fmcg('.wishlist_count').hide(); }
                         else {  $fmcg('.wishlist_count').show();  }
                            $fmcg('#outer_wish'+id).hide();
                            if(response.result){
                              
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                } else {
                    alert('Wishlist Failed');
                }
            
        }
    
	



function RemoveWishlist(id = null){  
            
                if(id != null){
                    $fmcg.ajax({
                        type:'GET',
                        url:'{{ route("RemoveWishlist") }}',
                        data:{id: id, '_token':'{{csrf_token()}}'},
                        success:function(response){
                         // location.reload();
                            $fmcg('#inactive_wish'+id).show();
                            $fmcg('#active_wish'+id).hide();
                            $fmcg('#outer_wish'+id).hide();
                            wish_count = wish_count-1;
                            $fmcg('.wish-count').html(wish_count);
                            var res = $fmcg('.wish-count').html();
                            if( res == 0)
                            {  $fmcg('.wishlist_count').hide(); }
                            else {  $fmcg('.wishlist_count').show();  }
                            if(response.result){
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                } else {
                    alert('Wishlist Failed');
                }
            
        }



</script>
<script src="//cdn.amcharts.com/lib/5/index.js"></script>
<script src="//cdn.amcharts.com/lib/5/map.js"></script>
<script src="//cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="//cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script>


var root = am5.Root.new("chartdiv"); 

// Set themes


root.setThemes([
  am5themes_Animated.new(root)
]);

var chart = root.container.children.push(
  am5map.MapChart.new(root, {
    panX: "rotateX",
    projection: am5map.geoNaturalEarth1()
  })
);

// Create polygon series
var polygonSeries = chart.series.push(
  am5map.MapPolygonSeries.new(root, {
    geoJSON: am5geodata_worldLow,
    exclude: ["AQ"]
  })
);
polygonSeries.mapPolygons.template.setAll({
  //tooltipText: "{name}",
  tooltipText: "Country",
  templateField: "polygonSettings"
});

polygonSeries.mapPolygons.template.states.create("hover", {
  fill: am5.color(0x677935)
});

polygonSeries.data.setAll([
    @foreach($active_reg_list as $row){ 

  id: "{{$row['iso_codes']??''}}",
  name: "{{$row['name']}}",
  polygonSettings: {
    fill: am5.color(0x00b7ff),
    tooltipText: "{{$row['name']}}"
    //tooltipText: "{name}"
    
    
  }
},
@endforeach
   @foreach($expand_reg_list  as $row1){ 

  id: "{{$row1['iso_codes']}}",
  name: "{{$row1['name']}}",
  polygonSettings: {
    fill: am5.color(0xe09d50),
    tooltipText: "{{$row['name']}}"
  }
},
@endforeach

])
var zoomControl = chart.set("zoomControl", am5map.ZoomControl.new(root, {}));
var homeButton = zoomControl.children.moveValue(am5.Button.new(root, {
  paddingTop: 10,
  paddingBottom: 10,
  icon:
    am5.Graphics.new(root, {
      svgPath: "M16,8 L14,8 L14,16 L10,16 L10,10 L6,10 L6,16 L2,16 L2,8 L0,8 L8,0 L16,8 Z M16,8",
      fill: am5.color(000000)
    })
}), 0)

homeButton.events.on("click", function() {
  chart.goHome();
});
 $fmcg("#contact").hide();
$fmcg(".nav-link").on('click', function(e) { 
    if($fmcg(this).attr('id') == 'myRegions'){
        $fmcg("#contact").show();
    }else{
         $fmcg("#contact").hide();
    }
});
</script>
<script>
$fmcg(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
	    //if($fmcg(".parent-check-active").prop('checked') == false){
		var $el = e.data.el;
			$this = $fmcg(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
		};
	   // }
	}	

	var accordion = new Accordion($fmcg('.accordion1'), false);
});
</script>
<script>
$fmcg(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = $fmcg(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
		};
	}	

	var accordion = new Accordion($fmcg('.accordion2'), false);
});
</script>

<script>
$fmcg(document).ready(function(){
  $fmcg(".menu-button2").click(function(){
    $fmcg(".sidenav-ns ").toggle(300);
  });
});
</script>


@endsection
