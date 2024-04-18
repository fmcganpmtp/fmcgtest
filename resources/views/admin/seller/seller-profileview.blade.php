@extends('admin.master')
@section('title', 'User View')
@section('breadcrumb') User View @endsection
@section('content')
<?php               
   if(!empty($seller->profile_pic)) 
   $img_path = asset('/uploads/userImages/').'/'.$seller->profile_pic;
   else  
   $img_path = asset('uploads/defaultImages/default_avatar.png');
   $seller_id = $seller->id;
   $u_name = $seller->name;
   $u_position = $seller->position??"";
   $u_email = $seller->email;
   $u_phone = $seller->phone;
   ?>
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
      <div class="card-out mb-4 inner-form">
          
          <div class="card">
          <div class="card-body"><section class="my-prof-new">
<div class="container">
   <div class="row">
      <div class="col-lg-12">
         <div class="prf-out-c11">
            <div class="profile-Container">
               <?php
                  $company_image =  $seller->BuyerCompany->company_image ?? ''; 
                  if(($company_image!=""))
                  $cmp_img = asset('uploads/BuyerCompany/').'/'.$seller->BuyerCompany->company_image;
                  else $cmp_img = asset('uploads/defaultImages/seller.jpg');
                  
                  
                  $edit_co = $edit="Yes";
                  
                  
                  
                  /*if($seller->id == $seller->id &&  $seller->seller_type=='Master' && $active_package == "Yes") 
                  $edit_co="Yes";*/
                  ?>
               <div class="cover-c profile_top">
                  <div class="cover-image"><img src="{{$seller->BuyerCompany->campany_banner==''?asset('assets/images/cover-image.jpg'):asset('/uploads/BuyerCompanyBanner/').'/'.$seller->BuyerCompany->campany_banner}}"></div>
                  <div class="pro-img-row">
                     <div class="row">
                        <div class="col-lg-4 col-12">
                           <div class="prof-imgg"><img src="{{$cmp_img}}"></div>
                        </div>
                        <div class="col-lg-8 col-12">
                           @if($edit=="Yes") <a  href="javascript:void(0)" onclick="editfrm()"  class="greenButton">Edit</a>
                            
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
               <div class="cover-c edit_form" style="display:none;">
                  <div class="cover-image"><img src="{{$seller->BuyerCompany->campany_banner==''?asset('assets/images/cover-image.jpg'):asset('/uploads/BuyerCompanyBanner/').'/'.$seller->BuyerCompany->campany_banner}}
                     "  class="banner_img"> <a href="javascript: void(0)"  id="upload_cmpBanner" class="edit-btn-prf"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a> </div>
                  <input type="file" id="imgupload_banner" class="image_banner" name="image_banner" style="display:none" accept="image/*" />
                  <div class="pro-img-row">
                     <div class="row">
                        <div class="col-lg-4 col-12">
                           <div class="prof-imgg"><img src="{{$cmp_img}}" class="prof_img"> <a href="javascript: void(0)"  id="upload_image" class="edit-btn-prf"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a> </div>
                           <input type="file" id="imgupload" class="company_image" name="company_image" style="display:none" accept="image/*">
                           <span id="txtimgpicture"></span> 

                        </div>
                        <div class="col-lg-8 col-12">
                           <!-- <a href="javascript: void(0)" class="greenButton btn-save">Save</a> -->
                        </div>
                     </div>
                  </div>
               </div>
               <div class="prof-inner-C">
                  <div class="profile_top">
                     <div class="pro-basic-info">
                        <h2>{{$seller->BuyerCompany->company_name ?$seller->BuyerCompany->company_name:$seller->name }}
                           @if($seller->varification_status=="varified") 
                           <img src="{{ asset('assets/images/grenn-varified.png')}}" class="varified-ic">
                           @endif
                        </h2>
                        <?php   $c_types = $c_types_names =[]; 
                           if($seller->BuyerCompany->company_type) { 
                           
                           foreach ($company_types as $company_type)
                           {
                           $c_types = explode(",",$seller->BuyerCompany->company_type);
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
                                 @if($seller->BuyerCompany?->company_email)
                                 <li class="inf"><a href="mailto:{{$seller->BuyerCompany?->company_email}}">{{$seller->BuyerCompany?->company_email}}</a></li>
                                 @endif
                                 @if($seller->BuyerCompany?->company_phone)
                                 <li class="tl"><a href="tel:{{ $seller->phone}}">{{ $seller->BuyerCompany?->company_phone ?? '' }}</a></li>
                                 @endif
                                 @if($seller->BuyerCompany?->company_website)
                                 <?php $web = (strlen($seller->BuyerCompany->company_website) > 17) ? substr($seller->BuyerCompany->company_website,0,17).'...' : $seller->BuyerCompany->company_website; ?>
                                 <li class="wb">
                                    <?php 
                                       $url = (!preg_match("~^(?:f|ht)tps?://~i", $seller->BuyerCompany->company_website))?"http://" . $seller->BuyerCompany->company_website:$seller->BuyerCompany->company_website;
                                       ?>
                                    <a href="{{$url}}" target="_blank">{{ $seller->BuyerCompany?->company_website }}</a>
                                 </li>
                                 @endif
                              </ul>
                           </div>
                           <div class="col-lg-4 col-12">
                              @if($seller->Country?->name)
                              <ul class="prf-adr">
                                 @if($seller->BuyerCompany->company_street)
                                 <li>{{ $seller->BuyerCompany->company_street ?? '' }}</li>
                                 @endif
                                 @if($seller->BuyerCompany->company_location)
                                 <li>{{(strlen($seller->BuyerCompany->company_location) > 10) ? substr($seller->BuyerCompany->company_location,0,10).'...' : $seller->BuyerCompany->company_location  }}, {{ $seller->BuyerCompany->company_zip ?? '' }}</li>
                                 @endif
                                 <li>{{(strlen($seller->Country->name) > 17) ? substr($seller->Country->name,0,17).'...' : $seller->Country->name  }}</li>
                              </ul>
                              @endif
                           </div>
                           <div class="col-lg-4 col-12">
                              <div class="prf-count">
                                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                       <td>
                                          <h5>{{$profile_visit_count}}+</h5>
                                       </td>
                                       <td>
                                          <h6>Profile Views</h6>
                                          </li>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <h5>{{$network_count}}</h5>
                                       </td>
                                       <td>
                                          <h6>Network Connections</h6>
                                          </li>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <h5>{{$product_count}}+</h5>
                                       </td>
                                       <td>
                                          <h6>Products</h6>
                                          </li>
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
                              <input placeholder="Company Name" type="text" class="form-control  {{ $errors->has('company_name') ? ' is-invalid' : '' }}"  name="company_name" value="{{ old('company_name', $seller->BuyerCompany->company_name ?? '')  }}" >
                              </h2>
                              <span id="txtcompany"></span>
                              <h3>
                                 <div class="dropdown">
                                    <div class="autocomplete form-group cmp-type" >
                                       <select type="text" multiple placeholder="Select Company Types" name="company_type[]" id='company_type' class="form-control{{ $errors->has('product_dimension') ? ' is-invalid' : '' }}" multiple="multiple">
                                          <?php $ctypes =[]; ?>
                                          @foreach ($company_types as $company_type)
                                          @if(!empty($seller->BuyerCompany->company_type))
                                          <?php $ctypes = explode(",",$seller->BuyerCompany->company_type);?>
                                          @endif
                                          @if(in_array($company_type->id, $ctypes))
                                          <option value="{{ $company_type->id }}" selected="true" />{{ $company_type->company_type }}</option>
                                          @else
                                          <option value="{{ $company_type->id }}">{{ $company_type->company_type }}</option>
                                          @endif 
                                          @endforeach 
                                       </select>
                                    </div>
                                      
                                 </div>
                              </h3>
                              <span id="txtcompanytype"></span>
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
                                         
                                 </div>
                              </h4>
                              <span id="offline_categories1"></span>
                           </div>
                           <div class="pr-adrrs-blk">
                              <div class="row">
                                 <div class="col-lg-4 col-12">
                                    <ul class="bsc-inf">
                                       <li class="inf">
                                          <input placeholder="Company Email" type="text" class="form-control  {{ $errors->has('company_email') ? ' is-invalid' : '' }}" name="company_email" value="{{ old('company_email', $seller->BuyerCompany?->company_email)  }}" >
                                          <span id="txtemail"></span>
                                       </li>
                                       <li class="tl">
                                          <input placeholder="Company Phone" name="full" type="text" value="{{ old('company_phone') ? old('company_phone') : $seller->BuyerCompany?->company_phone ?? '' }}" id="phone" class="form-control pno05 {{ $errors->has('company_phone') ? ' is-invalid' : '' }} " maxlength="15"/>
                                          <span id="txtphone"></span>
                                       </li>
                                       <li class="wb">
                                          <input placeholder="Company Website" name="company_website" type="text" value="{{ old('company_website') ? old('company_website') : $seller->BuyerCompany->company_website ?? '' }}" id="company_website" class="form-control pno05 {{ $errors->has('company_website') ? ' is-invalid' : '' }} " />
                                          <span id="txtwebsite"></span>
                                       </li>
                                    </ul>
                                 </div>
                                 <div class="col-lg-4 col-12">
                                    <ul class="prf-adr">
                                       <li>
                                          <input placeholder="Street" type="text" class="form-control  {{ $errors->has('company_street') ? ' is-invalid' : '' }}"  name="company_street" value="{{ old('company_street', $seller->BuyerCompany->company_street ?? '')  }}" >
                                          <span id="txtcompanystreet"></span>
                                       </li>
                                       <li>
                                          <input placeholder="City" type="text" class="form-control  {{ $errors->has('company_location') ? ' is-invalid' : '' }}"  name="company_location" value="{{ old('company_location', $seller->BuyerCompany->company_location ?? '')  }}" >
                                          <span id="txtcompanylocation"></span>
                                       </li>
                                       <li><input placeholder="Zipcode"  type="text" class="form-control  {{ $errors->has('company_zip') ? ' is-invalid' : '' }}"  name="company_zip" value="{{ old('company_zip', $seller->BuyerCompany->company_zip ?? '')  }}" >
                                          <span id="txtcompanyzipcode">
                                       </li>
                                       <li>
                                          <select name="country_id" id="country_id" class="form-control  {{ $errors->has('country_id') ? ' is-invalid' : '' }}" aria-label="Default select example"  >
                                             <option value="">Country Name</option>
                                             @foreach ($countries as $country)
                                             <option {{old('country_id',$seller->country_id) == $country->id ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
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
                                             <td>
                                                <h5>{{$profile_visit_count}}+</h5>
                                             </td>
                                             <td>
                                                <h6>Profile Views</h6>
                                                </li>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                <h5>{{$network_count}}</h5>
                                             </td>
                                             <td>
                                                <h6>Network Connections</h6>
                                                </li>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                <h5>{{$product_count}}+</h5>
                                             </td>
                                             <td>
                                                <h6>Products</h6>
                                                </li>
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
                  </div>
                  <!--relative-->	
                  <div id="submitmessage"></div>
                  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
                  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
                  
                  <div class="container1">
               
                     <ul class="nav nav-tabs" id="myTab" role="tablist" >
                        <li class="nav-item {{ (Request::get('tab')=="about"  || !(isset($_GET['tab'])))? 'active':"" }}"><a data-toggle="tab" href="#home"  id="home-tab" role="tab" aria-controls="home" aria-selected="{{ (Request::get('tab')=="about" || !(isset($_GET['tab']))) ? 'true':"false" }}">About</a></li>
                        <li class="nav-item {{ Request::get('tab')=="regions"? 'active':"" }}"><a data-toggle="tab" href="#menu1" role="tab" aria-controls="menu1" id="menu1-tab" aria-selected="false">Regions</a></li>
                        <li class="nav-item {{ Request::get('tab')=="employees"? 'active':"" }}"><a data-toggle="tab" href="#menu2" role="tab" aria-controls="menu2" id="menu2-tab" aria-selected="{{ Request::get('tab')=="employees"? 'true':"false" }} ">Employees</a></li>
                      </ul>
                     <div class="tab-content">
                        <div id="home" class="tab-pane fade show {{ (Request::get('tab')=="about" || !(isset($_GET['tab'])))? 'active':"" }}"  role="tabpanel" aria-labelledby="home-tab" style="position:relative;">
                        <div class="row pr-row view_tab1">
                           @if($edit=="Yes") <a  href="javascript:void(0)" onclick="edittab1()"  class="greenButton">Edit</a>@endif
                           <div class="col-lg-6 col-12">
                              <div class="prf-abt-txt">
                                 <p> <?php echo $seller->BuyerCompany->about_company; ?></p>
                              </div>
                           </div>
                           <div class="col-lg-6 col-12">
                              @if($seller->BuyerCompany->comp_about_img1)
                              <div class="cmpny-prof"><img src="{{$seller->BuyerCompany->comp_about_img1==''?asset('assets/images/cover-image.jpg'):asset('/uploads/BuyerCompanyBanner/').'/'.$seller->BuyerCompany->comp_about_img1}}"></div>
                              @endif
                              @if($seller->BuyerCompany->comp_about_img2)
                              <div class="cmpny-prof"><img src="{{$seller->BuyerCompany->comp_about_img2==''?asset('assets/images/cover-image.jpg'):asset('/uploads/BuyerCompanyBanner/').'/'.$seller->BuyerCompany->comp_about_img2}}"></div>
                              @endif
                           </div>
                        </div>
                        <div class="edit_tab1" style="display:none;">
                           <form id="form_about">
                              <div class="row pr-row ">
                                  <div class="col-12">
                                      <a   href="javascript:void(0)" onclick="HideEditAbout()"   class="greenButton  btn-cancel_2 prof-save-btn" >Cancel</a>
                                       <button type="submit" class="greenButton btn-save">Save</button>
                                  </div>    
                                 <div class="col-lg-6 col-12">
                                    <div class="prf-abt-txt">
                                       <textarea name="about_company" id="mytextarea" style="height:300px !important;" class="form-control{{ $errors->has('about_company') ? ' is-invalid' : '' }}" >{{  $seller->BuyerCompany->about_company ?? ''  }}</textarea>
                                       <span id="txtabt"></span>
                                       
                                    </div>
                                 </div>
                                 <div class="col-lg-6 col-12">
                                    <div class="cmpny-prof"><img class="abt1_img" src="{{$seller->BuyerCompany->comp_about_img1==''?asset('assets/images/no_img.jpg'):asset('/uploads/BuyerCompanyBanner/').'/'.$seller->BuyerCompany->comp_about_img1}}"><a href="javascript: void(0)"  id="upload_abtimg1" class="edit-btn-prf"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>
                                       @if($seller->BuyerCompany->comp_about_img1)
                                       <a href="javascript:void(0)" onclick="removeImageabt1({{ $seller->BuyerCompany->id }})" class="btn abt1_remove"><span class="red_round remove-input-field"><i class="fa fa-minus-circle" aria-hidden="true"></i></span></a>
                                       @endif
                                    </div>
                                    <input type="file" id="imgupload_abtimg1" class="about_image1" name="about_image1" style="display:none" accept="image/*" />
                                    <div id="about_img1_error"></div>
                                    <div class="cmpny-prof"><img class="abt2_img" src="{{$seller->BuyerCompany->comp_about_img2==''?asset('assets/images/no_img.jpg'):asset('/uploads/BuyerCompanyBanner/').'/'.$seller->BuyerCompany->comp_about_img2}}"><a href="javascript: void(0)"  id="upload_abtimg2" class="edit-btn-prf"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>
                                       @if($seller->BuyerCompany->comp_about_img2)
                                       <a href="javascript:void(0)" onclick="removeImageabt2({{ $seller->BuyerCompany->id }})" class="btn abt2_remove"><span class="red_round remove-input-field"><i class="fa fa-minus-circle" aria-hidden="true"></i></span></a>
                                       @endif
                                    </div>
                                    <input type="file" id="imgupload_abtimg2" class="about_image2" name="about_image2" style="display:none" accept="image/*" />
                                    <div id="about_img2_error"></div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                        <div id="menu1" class="tab-pane   {{ Request::get('tab')=="regions"? 'active':"" }}"  role="tabpanel" aria-labelledby="menu1-tab" style="position:relative;">
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
                                          @if($row['continent']==$val)
                                          <li>{{$row['name']}}</li>
                                          @endif
                                          @endforeach
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              @endforeach	 
                              @endif
                           </div>
                           <?php
                              $expand_reg = explode(',',$seller->CompanyRegion->expand_countries);
                              $active_reg = explode(',',$seller->CompanyRegion->active_countries); 
                              ?>
                           <div class="col-lg-6 col-12">
                              <h3><b class="exp"></b>Regions we would like to expand to</h3>
                              @if (count($expand_continents)>0)
                              @foreach($expand_continents as $val)
                              <div class="country-list">
                                 <div class="row">
                                    <div class="col-lg-5 col-12">
                                       <?php foreach($expand_reg_list as $row) {
                                          if($row['continent']==$val) { ?>	
                                       <h4>{{$val}}</h4>
                                       <?php   break; } } ?>
                                    </div>
                                    <div class="col-lg-7 col-12">
                                       <ul>
                                          @foreach($expand_reg_list as $row)
                                          @if(!in_array($row['id'],$active_reg))
                                          @if($row['continent']==$val)
                                          <li>{{$row['name']}}</li>
                                          @endif
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
                        
                     </div>
                     <style>
                        .accordion .card-header:after {
                        font-family: 'FontAwesome';  
                        content: "\f068";
                        float: right; 
                        }
                        .accordion .card-header.collapsed:after {
                        /* symbol for "collapsed" panels */
                        content: "\f067"; 
                        }
                     </style>
                     <div class="map-descrip map-descrip_edit" style="display:none;">   
                        <form id="region-form">
                           <div class="row">
                              <div class="col-lg-6 col-12">
                                 <h4>Select active regions</h4>
                                 <!-- <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Select active regions</button>
                                    </h2> -->
                                 <div id="accordion" class="accordion">
                                    <?php
                                       $expand_reg = explode(',',$seller->CompanyRegion->expand_countries);
                                       $active_reg = explode(',',$seller->CompanyRegion->active_countries); 
                                       ?>
                                    <div class="card mb-0">
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
                                       <div class="crd-ot1">
                                        <input  type="checkbox"  {{($all_count === $selected_count)?'checked':''}} class="parent_cont{{$val_clas}}" onclick="SelctAllSub('{{$val_clas}}')">
                                       <div class="card-header collapsed" data-toggle="collapse" href="#collapse{{$val_clas}}">
                                          <span class="card-title"> {{$val}} </span>
                                       </div>
                                       </div>
                                       <div id="collapse{{$val_clas}}" class="card-body collapse" data-parent="#accordion" >
                                          <ul class="submenu">
                                             @foreach($countries as $row)
                                             @if($row['continent']==$val)
                                             <li> 
                                                <input class="sub_countries_cont{{$val_clas}}" id="cntry_id{{$row['id']}}" name="active_country[]" type="checkbox" value="{{$row['id']}}" {{in_array($row['id'],$active_reg)?'checked':''}}> <label for="cntry_id{{$row['id']}}">{{$row['name']}}</label>
                                             </li>
                                             @endif
                                             @endforeach
                                          </ul>
                                       </div>
                                       @endforeach
                                    </div>
                                 </div>
                              </div>
                              <div class="col-lg-6 col-12">
                                 <h4>Select Regions of Interest</h4>
                                 <!--<h2 class="accordion-header" id="headingOne2">
                                    <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne"> Select Regions of Interest </button>
                                    </h2>  -->
                                 <div id="accordion1" class="accordion">
                                    <div class="card mb-0">
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
                                       <div class="crd-ot1">
                                       <input  type="checkbox" {{($all_count === $selected_count)?'checked':''}} class="parent_contExpnd{{$val_clas}}" onclick="SelctAllSubExpnd('{{$val_clas}}')">
                                       <div class="card-header collapsed" data-toggle="collapse" href="#collapse1{{$val_clas}}">
                                           
                                          <span class="card-title">
                                          {{$val}}
                                          </span>
                                       </div>
                                       </div>
                                       <div id="collapse1{{$val_clas}}" class="card-body collapse" data-parent="#accordion1" >
                                          <ul class="submenu">
                                             @foreach($remainining_toexpand as $row)
                                             @if(!in_array($row['id'],$active_reg))
                                             @if($row['continent']==$val)
                                             <li> <input class="sub_countries_Subcont{{$val_clas}} cntry{{$row['id']}}" id="cuntry_id{{$row['id']}}"  name="expand_country[]" type="checkbox" value="{{$row['id']}}"  {{in_array($row['id'],$expand_reg)?'checked':''}}> <label for="cuntry_id{{$row['id']}}">{{$row['name']}}</label></li>
                                             @endif
                                             @endif
                                             @endforeach
                                          </ul>
                                       </div>
                                       @endforeach 
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <a   href="javascript:void(0)" onclick="HideEditRegions()"   class="greenButton  btn-cancel_2 prof-save-btn" >Cancel</a>
                           <button type="submit" class="greenButton btn-save" value="Save">Save</button>
                        </form>
                     </div>
                  </div>
                        <div id="menu2" class="tab-pane  {{ Request::get('tab')=="employees"? 'active':"" }}"  role="tabpanel" aria-labelledby="menu2-tab" style="position:relative;">
                  @if($edit=="Yes")  <a href="javascript:void(0)" onclick="edittabEployees()" class="greenButton">Edit</a> @endif
                  <input type="hidden" id="start_from_empEdit" value="0">
                  <input type="hidden" id="edit_active" value="no">
                  <div class="row edit_employees" id="employee-listing-edit" >
                     <a   href="javascript:void(0)" onclick="HideEditEmployees()"   class="greenButton  btn-cancel_2 prof-save-btn edit_emp_icon" style="display:none;">Cancel</a>  
                     <div class="col-lg-4 col-12 edit_emp_icon" style="display:none;">
                        <div class="prf-inner add-user-sect  ">
                           <div class="tab-prf-image add-us-img"><img src="assets/images/add-user.png"></div>
                           <a href="javascript:void(0)" class="invite-us-btn"  data-toggle="modal" data-target="#exampleModa5">Invite</a> 
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
<!--
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
-->
<div class="modal fade" id="exampleModa5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Invite</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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


@if(Session::has('message')) 
<div class="alert alert-success">{{Session::get('message') }}</div>
@endif

</section></div>
          </div>
    </div>  </div>
  </div>



<div class="body flex-grow-1 px-3">
   <div class="container-lg">
      <div class="card-out mb-4 inner-form">
         <h2>User View</h2>
         <div class="card-body">
            <div class="row">
               <div class="col-lg-12 col-12">
                  <div class="card mar-10">
                     <div class="card-header">Kyc Uploads</div>
                     <div class="card-header">
                        <div class="row">
                           <div class="col-lg-6 col-12">
                              <div class="search-area width-100-p">
                                 <div class="form-group">
                                    <input id="search_key" type="text" class="form-control" placeholder="Search Docs..">
                                    <i class="fa fa-times clearsearch clearkyc" aria-hidden="true"></i>
                                    <button id="search_button"><i class="icon cil-search"></i></button>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 col-12">
                              @if($varification_status!='varified')
                              <button id="new_kyc" onclick="showkycmodel({{$id}})"  class="bl-btn flt-right">New Kyc Docs</button>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="card-body">
                        <div class="tableC">
                           <table id="datatable" data-page-length='20' class="table table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                 <tr>
                                    <th></th>
                                    <th>Sl No</th>
                                    <th>Document name</th>
                                    <th>Document type</th>
                                    <th>Reason</th>
                                    <th> Actions</th>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                     </div>
                  </div>
                  <!-- Modal -->
                  <div class="modal fade" id="Mymodal" tabindex="-1" aria-labelledby="MymodalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="MymodalLabel">Enter reason</h5>
                              <button type="button" class="close" onclick="fnclosepopup1()" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              <div class="form-group">
                                 <input type="hidden" id="hdnkycid">
                                 <textarea class="form-control" placeholder="" id="txtreason"> </textarea>                    
                              </div>
                              <button type="submit" onclick="rejectdocs()" class="bl-btn">SUBMIT</button>
                           </div>
                           <div class="modal-footer">
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Modal -->
                  <div class="modal fade" id="kycMymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Upload Kyc Docs</h5>
                              <button type="button" class="close" onclick="fnclosepopup11()" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <form  method="POST" action="{{route('userkycupload')}}" enctype="multipart/form-data">
                              @csrf
                              <div class="modal-body ch-dt">
                                 <div class="form-group">
                                    <input type="hidden" name="hdnuserid" id="hdnuserid">
                                    <input type="hidden" name="frompage" value="sellerside">
                                    <label>Doc Type:</label>
                                    <select name="file_type" class="form-control" required>
                                       <option value="">Select Type</option>
                                       <option value="Chamber of commerce">  Chamber of commerce</option>
                                       <option value="VAT number">VAT number </option>
                                       <option value="Identification">Identification (Driving license/ passport/ ID) </option>
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label>File:</label>
                                    <input type="file" name="file_docupload" class="form-control" required>
                                 </div>
                                 <button type="submit"  class="bl-btn">Upload</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div class="card mar-10">
                     <div class="card-header">Products list</div>
                     <div class="card-header">
                        <div class="search-area wth-btn">
                           <div class="form-group">
                              <input id="product_search_key" type="text" class="form-control" placeholder="Search..">
                              <i class="fa fa-times clearsearch clearproduct" aria-hidden="true"></i>
                              <button id="product_search_button"><i class="icon cil-search"></i></button>
                           </div>
                        </div>
                     </div>
                     <div class="card-body">
                        <div class="tableC">
                           <table id="productTable" data-page-length='20' class="table table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                 <tr>
                                    <th>Hidden</th>
                                    <th>Sl no</th>
                                    <th>Product Description</th>
                                    <th>Image</th>
                                    <th>Visibility</th>
                                    <th> Actions</th>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                     </div>
                  </div>
                  <?php 
                     $package_data = DB::table('subscriptions')
                        ->leftJoin('order_details', 'subscriptions.order_id', '=', 'order_details.id')
                        ->leftJoin('packages', 'packages.id', '=', 'order_details.package_id')
                        ->where('subscriptions.user_id', '=',$id)
                        ->where('subscriptions.status','active')
                        ->orderBy('subscriptions.id','DESC')
                        ->first();
                     
                     
                     if(!empty($package_data)){  $package_status="";        
                     if( $package_data->subscription_type=='Extended'){
                     if($package_data->expairy_date<date('Y-m-d'))
                        $package_status="Expired ";?> 
                  <div class="card mar-10">
                     <div class="card-header"><b style="color: red;">{{$package_status}}</b> Co- Sellers List</div>
                     <div class="card-header">
                        <div class="search-area">
                           <div class="form-group">
                              <input id="search_coseller" type="text" class="form-control" placeholder="Search Co-Sellers..">
                              <i class="fa fa-times clearsearch clearcouser" aria-hidden="true"></i>
                              <button id="search_coseller_button"><i class="icon cil-search"></i></button>
                           </div>
                        </div>
                     </div>
                     <div class="card-body">
                        <div class="tableC">
                           <table id="cosellers" data-page-length='20' class="table table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                 <tr>
                                    <th></th>
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>User Name</th>
                                    <th> Actions</th>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                     </div>
                  </div>
                  <?php }}?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="{{asset('/admin1/js/datatable.js')}}"></script>
<script src="{{asset('/admin1/js/sweetalert.js')}}"></script>
<style>
   .clearsearch{    right: 38px;
   position: absolute;
   top: 13px;
   font-size: 12px;
   cursor:pointer;
   }
   .greenButton{
       margin-top:-40px;
   }
</style>
<script>
   var $ = jQuery;
     (function($) {
     $(document).ready( function () {
       var user_id='<?php echo $id?>';
       
       var id = '12';
       var str="";
       var Active='"Active"';
       var Rejected="'Rejected'";
       var Blocked='"Blocked"';
       var viewurl="{{route('view.Sellerproduct', ':id')}}";
       var editurl="{{route('seller.edit.product', ':id')}}";
       var deleteurl="{{route('seller.delete.product', ':id')}}";
       
       $("#search_key,#search_button").keydown(function (event) { 
        if (event.which == 13) { 
            event.preventDefault();
            dataTable.draw();
        }
       });
       $("#search_button").click(function (event) { 
           event.preventDefault();
            dataTable.draw();
       });
       $("#product_search_key").keydown(function (event) { 
        if (event.which == 13) { 
            event.preventDefault();
            productTable.draw();
        }
       });
   
       $("#product_search_button").click(function (event) { 
             event.preventDefault();
            productTable.draw();
        });
        
        $(".clearkyc").click(function (event) { 
             event.preventDefault();
             $("#search_key").val('');
            dataTable.draw();
        });
        $(".clearcouser").click(function (event) { 
             event.preventDefault();
             $("#search_coseller").val('');
            cosellersTable.draw();
        });
        $(".clearproduct").click(function (event) { 
             event.preventDefault();
             $("#product_search_key").val('');
            productTable.draw();
        });
        
   
   
       $("#search_coseller").keydown(function (event) { 
        if (event.which == 13) { 
            event.preventDefault();
            cosellersTable.draw();
        }
       });
   
       $("#search_coseller_button").click(function (event) { 
            event.preventDefault();
            cosellersTable.draw();
        });
       
       var dataTable=$('#datatable').DataTable({
            "processing": true,
           "language": {
               processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
            serverSide: true,
           'searching': false,
            "lengthChange": false,
             "order": [ 0,'desc'],
            'ajax': {
          'url':"{{ url('getsellerdocslist') }}",
          'data': function(data){
             _token="{{csrf_token()}}";
             data.search_key = $("#search_key").val();
             data.user_id= user_id;
          },
         
       }, 
      
       "columnDefs":[
       {
          "targets":0, 
          "orderable": true,
          "visible":false
         },
         {
          "targets":1, 
          "orderable": false,
          "render": function(data,type,full,meta)
         {
           return meta.row + meta.settings._iDisplayStart + 1;
   
         }
       },
        
         {
          "targets":5, 
          "orderable": false,
          "render": function(data,type,full,meta)
         {
           
          str='<div class="icon-bx">';
          if(full.status1!='Rejected')
          {   
           if(full.status1!='Active')
           str+="<button type='button' title='Approve Docs' onclick='fnapprove("+full.id+")' style='border: 0 none;'><i class='fa fa-check-square' aria-hidden='true'></i></button> <button type='button' title='Reject Docs' onclick='fnopenpopup1("+full.id+")' style='border: 0 none;'><i class='fa fa-window-close-o' aria-hidden='true'></i></button>";
           if(full.status1!='In-Active')
             str+=" <button type='button' title='Reject Docs' onclick='fnopenpopup1("+full.id+")' style='border: 0 none;'><i class='fa fa-window-close-o' aria-hidden='true'></i></button>";
          }
            str+='</div>';
            
           return str;
         
      }
       }
     ],
            columns: [
            { data: 'id' },
             { data: 'id' },
             { data: 'file_type' },
             { data: 'file_path' } ,  
             { data: 'reason' } ,  
            ]
         });
   
   
   
       var cosellersTable=$('#cosellers').DataTable({
            "processing": true,
           "language": {
               processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
            serverSide: true,
           'searching': false,
            "lengthChange": false,
             "order": [ 0,'desc'],
            'ajax': {
          'url':"{{ url('getcosellerslist') }}",
          'data': function(data){
             _token="{{csrf_token()}}";
             data.search_key = $("#search_coseller").val();
             data.user_id={{$id}};
          },
         
       }, 
      
       "columnDefs":[
       {
          "targets":0, 
          "orderable": true,
          "visible":false
         },
         {
          "targets":1, 
          "orderable": false,
          "render": function(data,type,full,meta)
         {
           return meta.row + meta.settings._iDisplayStart + 1;
   
         }
       },
        
         {
          "targets":6, 
          "orderable": false,
          "render": function(data,type,full,meta)
         {
           
          str='<div class="icon-bx">';
   
           
           if(full.status=='Pending')
           str+="<button type='button' title='Activate This Profile' onclick='fnprofileaction("+full.id+","+Active+")' style='border: 0 none;'><i class='fa fa-check-square' aria-hidden='true'></i></button> <button type='button' title='Block This Profile' onclick='fnprofileaction("+full.id+","+Blocked+")' style='border: 0 none;'><i class='fa fa-window-close-o' aria-hidden='true'></i></button>";
           if(full.status=='Blocked')
             str+=" <button type='button' title='Activate This Profile' onclick='fnprofileaction("+full.id+","+Active+")' style='border: 0 none;'><i class='fa fa-check-square' aria-hidden='true'></i></button>";
   
           if(full.status=='Active')
             str+=" <button type='button' title='Block This Profile' onclick='fnprofileaction("+full.id+","+Blocked+")' style='border: 0 none;'><i class='fa fa-window-close-o' aria-hidden='true'></i></button>";
          
            str+='<a href="JavaScript:void(0);" onclick="fnprofileaction('+full.id+',' + Rejected+')"><i class="icon cil-trash"></i></a></div>';
            
           return str;
         
      } 
       }
     ],
            columns: [
            { data: 'id' },
            { data: 'id' },
             { data: 'name' },
             { data: 'email' },
             { data: 'phone' } ,  
             { data: 'username' } , 
             { data: 'status' } ,  
            ]
         });
   
        var productTable=$('#productTable').DataTable({
            "processing": true,
           "language": {
               processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
            serverSide: true,
           'searching': false,
           "lengthChange": false,
           "order": [ 0,'desc'],
           'ajax': {
           'url':"{{ url('getsellerproductslist') }}",
           'data': function(data){
             _token="{{csrf_token()}}";
             data.search_key = $("#product_search_key").val();
             data.user_id= user_id;
          },
         
       }, 
      
       "columnDefs":[
       {
          "targets":0, 
          "orderable": true,
          "visible":false
         },
         {
          "targets":1, 
          "orderable": false,
          "render": function(data,type,full,meta)
         {
           return meta.row + meta.settings._iDisplayStart + 1;
   
         }
       },
       {
          "targets":3, 
          "orderable": false,
          "render": function(data,type,full,meta)
         {
           return data;
   
         }
       },
        {
          "targets":4, 
          "render": function(data,type,full,meta)
         {
   
           if(full.product_visibility=="Yes")
             checked="checked";
           else
             checked="";
   
           if(full.product_visibility=="No")
             unchecked="checked";
           else
             unchecked="";
            return  '<div class="switch-field"><input type="radio" id="radio_visi-'+full.id+'" name="switch_visi-'+full.id+'" value="Yes" '+checked+' onchange="fnproduct_visbility('+full.id+')" /><label for="radio_visi-'+full.id+'">On</label><input type="radio" id="radio_visi-1'+full.id+'" name="switch_visi-'+full.id+'"  value="No" '+unchecked+' onchange="fnproduct_visbility('+full.id+')"/> <label for="radio_visi-1'+full.id+'">Off</label></div>';
         }
       },
         {
          "targets":5, 
          "orderable": false,
          "render": function(data,type,full,meta)
         {
           viewurl = viewurl.replace(':id', '');
           editurl = editurl.replace(':id', '');
          return '<div class="icon-bx"><a href="'+viewurl+full.id+'"><i class="fa fa-eye" aria-hidden="true"></i></a><a href="'+editurl+full.id+'"><i class="icon  cil-pencil"></i></a> <a href="JavaScript:void(0);" onclick="deleteconfirm('+full.id+')"><i class="icon cil-trash"></i></a> </div>';
      }
       }
     ],
            columns: [
            { data: 'id' },
             { data: 'id' },
             { data: 'name' },
             { data: 'file_path' } ,  
             { data: 'product_visibility' } ,
            ]
         });
   
   
     
        
     });
   })(jQuery);
   
   function fnviewdocs(path){
      window.open(path, "_blank");
   }
   
   
   
   function fnprofileaction(id,action){
   
     if(action=='Active')
         var msg="Are you Sure you want to Activate this Profile?";
     else if(action=='Blocked')
         var msg="Are you Sure you want to Block this Profile?";
     else if(action=='Rejected')
         var msg="Are you Sure you want to Delete this Profile?"
     swal({
           title:msg ,
           text: "",
           icon: "warning",
           buttons: true,
           dangerMode: true,
         })
         .then((willDelete) => {
           if (willDelete) {
           $.ajax({
            url: "{{ url('adminusersellersstatusupdates') }}",
               type: "post",
               data:{ 
                   _token:'{{ csrf_token() }}',
                     id: id,
                     status:action
               },
               async:true,
               cache: false,
               dataType: 'json',
               success: function(data){
                 
                   swal('Successfully Updated','','success'); 
                   location.reload(); 
                
             }  
           })  ;
   
         } else {
             
           }
         });  
   
   }
   
   
   
   function fnapprove(id){
     swal({
           title: "Are you Sure you want to Approve this docs?",
           text: "",
           icon: "warning",
           buttons: true,
           dangerMode: true,
         })
         .then((willDelete) => {
           if (willDelete) {
           $.ajax({
            url: "{{ url('approveuserdocs') }}",
               type: "post",
               data:{ 
                   _token:'{{ csrf_token() }}',
                     id: id,
               },
               async:true,
               cache: false,
               dataType: 'json',
               success: function(data){
                 
                if(data==1)
                 {
                   swal('Successfully Updated','','success'); 
                   location.reload(); 
                 }
                else 
                 swal('Updation Failed','','error');
             }  
           })  ;
   
         } else {
             
           }
         });  
   
      
   }
   
   
    function rejectdocs(id){
   
           $.ajax({
            url: "{{ url('rejectdocs') }}",
               type: "post",
               data:{ 
                   _token:'{{ csrf_token() }}',
                     reason: $("#txtreason").val(),
                     id: $("#hdnkycid").val(),
               },
               async:true,
               cache: false,
               dataType: 'json',
               success: function(data){
                 
                if(data==1)
                 {
                   swal('Status Updated','','success');
                   $("#txtreason").val('');
                   $("#Mymodal").modal('hide');
                    location.reload(); 
                 }
                else 
                 swal('Updation Failed','','error');
             }  
           })  ;
       };
   
   
   
   
   function fnopenpopup1(id){
     swal({
           title: "Are you Sure you want to Reject this docs?",
           text: "",
           icon: "warning",
           buttons: true,
           dangerMode: true,
         })
         .then((willDelete) => {
           if (willDelete) {
               $('#Mymodal').modal('show');
               $("#hdnkycid").val(id);
         } else {
             
           }
         });  
   }
   function fnclosepopup1(){
       $("#Mymodal").modal('hide');
   }
   function fnclosepopup11(){
       $("#kycMymodal").modal('hide');
   }
   
   
   function showkycmodel(user_id){
      $('#kycMymodal').modal('show');
      $("#hdnuserid").val(user_id);
   
   }
   function deleteconfirm(data){
     var id=data;
     var deleteurl="{{route('seller.delete.product', ':id')}}".replace(':id', '')+data;
   
     swal({
       title:"Do you really want to delete? " ,
       text: "",
       icon: "warning",
       buttons: true,
       dangerMode: true,
     })
     .then((willDelete) => {
       if (willDelete) {
         window.location=deleteurl;
       } 
       else {
             
           }
       });  
   
   }
     function fnproduct_visbility(id){
   
       var status=$("input[name='switch_visi-"+id+"']:checked").val();
       swal({
       title:"Do you want to continue ? " ,
       text: "",
       icon: "warning",
       buttons: true,
       dangerMode: true,
     })
     .then((willDelete) => {
       if (willDelete) {
          $(".loaderajax").show();
         $.ajax({
            url: "{{url('updateselerproductvisibility')}}",
               type: "post",
               data:{ 
                   _token:'{{ csrf_token() }}',
                     id: id,
                     status: status,
               },
               async:true,
               cache: false,
               dataType: 'json',
               success: function(data){
                    $(".loaderajax").hide();
                 if(data)
                     swal("Product Visibility Changed", "", "success");
                 else
                     swal("Error On Submission", "", "error");
                   
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
                  $(".loaderajax").hide();
               swal(errorThrown, "", "error");
             }  
   
           })
       } 
       else {
           
              var cur_status=$("input[name='switch_visi-"+id+"']:checked").val();
              if(cur_status=='Yes')
                 {
                   $("#radio_visi-"+id).prop('checked',false);
                   $("#radio_visi-1"+id).prop('checked',true);
                 }
              else
                 {
                   $("#radio_visi-"+id).prop('checked',true);
                   $("#radio_visi-1"+id).prop('checked',false);
                 }
             
           }
       });  
   
     }
   
       
</script>
<style type="text/css">
   .ad-flex-prp{  display: flex!important;}
   .switch-field {
   display: flex;
   overflow: hidden;
   }
   .switch-field input {
   position: absolute !important;
   clip: rect(0, 0, 0, 0);
   height: 1px;
   width: 1px;
   border: 0;
   overflow: hidden;
   }
   .switch-field label {
   background-color: #e4e4e4;
   color: rgba(0, 0, 0, 0.6);
   font-size: 14px;
   line-height: 1;
   text-align: center;
   padding: 8px 16px;
   margin-right: -1px;
   border: 1px solid rgba(0, 0, 0, 0.2);
   box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
   transition: all 0.1s ease-in-out;
   }
   .switch-field label:hover {
   cursor: pointer;
   }
   .switch-field input:checked + label {
   background-color: #0b6eb1; color:#fff;
   box-shadow: none;
   }
   .switch-field label{box-shadow:none;background-color: #fff;}
   .switch-field label:first-of-type {
   border-radius: 4px 0 0 4px;
   }
   .switch-field label:last-of-type {
   border-radius: 0 4px 4px 0;
   }
</style>
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
<script src="{{asset('/admin1/js/select2.min.js')}}"></script>  
<link rel="stylesheet" href="{{ asset('/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('/css/jquery.passwordRequirements.css')}}">
<script src="{{ asset('js/jquery.passwordRequirements.js')}}"></script>
<script src="{{ asset('js/jquery.passwordRequirements.min.js')}}"></script>
<link rel="stylesheet" href="{{ asset('/admin1/css/intlTelInput.css')}}">
<script src="{{ asset('/admin1/js/intlTelInput.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.2.2/tinymce.min.js"></script> 
<script type="text/javascript">
   function fnclosepopup1(){
        $("#Mymodal").modal('hide');
   }
   
   
      function addtonetwork(userid)
      {
         // $(".loaderajax").show();
       $.ajax({
               url: "{{ url('profile_to_network') }}",
                  type: "get",
                  data:{ 
                      user_id: userid,
                  },
                  async:false,
                  cache: false,
                  dataType: 'json',
                  success: function(data){ 
                      //$(".loaderajax").hide();
                    swal(data, "", "success");
                    $(".clsa"+userid).remove();
                    $(".clschat"+userid).show();
                   
                    $("#network_list").empty();
                    getnetworkList();
                } ,
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                   // $(".loaderajax").hide();
                  swal(errorThrown, "", "error");
                }  
      
              })  ;
     }
       function EnableChatRequest(seller_id){
             $(".message-input").css("display", "block");
             $("#frame").css("display", "block");
             $(".content").css("display", "block");
             $("#frame").css("width", "95%");
           
            
             $("#selected_id").val(seller_id);
             loadMessage();
             $("#frame").show();
             senter = seller_id;
             $("#txt_message").focus();      
              
           
   }
   
   
           function removeImageabt1(id = null){ 
               if(confirm('Do you want to remove image?')){
                   if(id != null){
                       $.ajax({
                           type:'GET',
                           url:'{{ route("abt1.removeImage") }}',
                           data:{id: id, '_token':'{{csrf_token()}}'},
                           success:function(response){
                               if(response.result){
                                  
                                   $(".abt1_img").attr("src", "{{asset('assets/images/no_img.jpg')}}");
                                   $(".abt1_remove").hide();
                                   
                                  
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
                       $.ajax({
                           type:'GET',
                           url:'{{ route("abt2.removeImage") }}',
                           data:{id: id, '_token':'{{csrf_token()}}'},
                           success:function(response){
                               if(response.result){
                                  
                                   $(".abt2_img").attr("src", "{{asset('assets/images/no_img.jpg')}}");
                                   $(".abt2_remove").hide();
                                  
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
           
   
   
   
   
   
    //var $ = $.noConflict();
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
      
       if ($(".parent_cont"+continent).is(':checked')) 
       {
       $('#collapse'+continent).addClass('show');
       $( ".sub_countries_cont"+continent ).prop( "checked", true );
       }
       else
       $( ".sub_countries_cont"+continent ).prop( "checked", false );
       
   }
    function SelctAllSubExpnd(continent){
      
       if ($(".parent_contExpnd"+continent).is(':checked')) 
       {
       $('#collapse1'+continent).addClass('show');
       $( ".sub_countries_Subcont"+continent ).prop( "checked", true );
       }
       else
       $( ".sub_countries_Subcont"+continent ).prop( "checked", false );
       
   }
   $('#upload_image_original').click(function(){  
   $('#imgupload_original').trigger('click'); 
   
   });
   $(".image_original").change(function(e) {  
       
   var data = new FormData();
   data.append('image_original', this.files[0]);
   data.append('_token', "{{ csrf_token() }}"); 
   $.ajax({
          url:'{{route('updateAdmProfimage')}}',
          type: 'POST',
          data : data,
          enctype : 'multipart/form-data',
          contentType: false,
          processData: false,
          success: function( data ) { 
              var baseUrl = "{{asset('')}}";
              var imageUrl = baseUrl + data.image_path;
              $('.prof_img_original').attr('src', imageUrl);
            //  $('#changeimage').html('<img src="'+ imageUrl +'" height="120px" width="150px">');
          },
          error: function() {
            //  alert('Upload Failed');
          }
         });   
      });		
   
    function editMyProfile(){
   
   $(".my-prfile-edit").show();
   $(".my-prfile-view").hide();
    }
    
   function HideEdit(){ //alert('test');
   $(".edit_top").css("display", "none");
   $(".profile_top").css("display", "block");
   $(".profile_top").show();
   $(".edit_form").hide();
   $(window).scrollTo(0, document.body.scrollHeight);
    }
    function HideEditAbout(){ 
     $(".edit_tab1").css("display", "none");
     $(".view_tab1").css("display", "flex");
     $(window).scrollTo(0, document.body.scrollHeight);
    }
    function HideEditprof(){ 
    $(".my-prfile-view").show();
    $(".my-prfile-edit").hide();
   $("#submitmessage_prof").css("display", "none");
    }
   
      
   
   
   function deleteconfirmUser(id){
        $('#delete_emp'+id).submit(function(e) { 
            e.preventDefault();
              var formData = new FormData($('#delete_emp'+id)[0]);
              formData.append('_token', "{{ csrf_token() }}"); 
              // Send an AJAX request
               $.ajax({
                  type: "post",
                  url: "{{ route('deleteAdmnCoEmployee') }}",
                  data: formData,
                  enctype : 'multipart/form-data',
                  dataType: "json",
                  processData: false,
                  contentType: false,
                  success: function(data) {
                      swal('Employee Deleted!');
                      console.log(data.new_master);
                      if(data.new_master=='')
                      {
                      $('.edt-emp'+id).hide();
                      if(data.master_deleted=='yes')
                      location.reload();
                      
                      }
                      else{
                       var redirecturl="{{route('seller.profileview', ':sellerid')}}".replace(':sellerid', '')+data.new_master;   
                       window.location=redirecturl;
                      
                      }
                      
                      //data.message
                     /* if(data)
                          $("#mail_send_success").empty().append("<p style='color:red'>"+data+"</p>");
                        else
                          $("#mail_send_success").empty();*/ 
                         
                          
                  },
                  error: function (xhr) {
                   
                     
                    $(window).scrollTo(0, document.body.scrollHeight);
                     // $(window).scrollTop(0);
                                 
                  }
              });
   
          });
           
           
              
   
          
        
       
    
       
   
   }
  /* var input = window.intlTelInput(document.querySelector("#phone_prof_emp"), {
    separateDialCode: true,
    preferredCountries:["nl"],
    hiddenInput: "phone",
    utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
   });*/
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
   $(document).ready(function() {
           $('#my-prof-edit').submit(function(e) { 
               e.preventDefault();
   
               // Serialize the form data
              //const formData = new FormData(form);
              var formData = new FormData($('#my-prof-edit')[0]); 
              formData.append('user_id', {{$seller->id}});
               formData.append('_token', "{{ csrf_token() }}"); 
               // Send an AJAX request
                $.ajax({
                   type: "post",
                   url: "{{ route('updateAdmSellerEmployee') }}",
                   data: formData,
                   enctype : 'multipart/form-data',
                   dataType: "json",
                   processData: false,
                   contentType: false,
                   success: function(data) {
                       if(data.message){
                     $("#submitmessage_prof").show();
                     $("#submitmessage_prof").empty().append('<div class="alert alert-success">'+data.message+'</div>'); 
                     $("#submitmessage_prof").delay(1000).fadeOut(1000);
                       }
                      // setTimeout(window.location.reload(),10);
                       var url = new URL(window.location.href);
                       url.searchParams.set('tab','myprofile');
                       window.location.href = url.href;
                    /*   
                     $(".my-prfile-edit").css("display", "none");
                      $(".my-prfile-view").show();
                      $(".my-prfile-edit").hide();
                       */
                           
                   },
                   error: function (xhr) {
                      // $(".loaderajax").hide();
                       //$("#btnsubmit").prop('disabled', false);
                   
   
                       var errors = JSON.parse(xhr.responseText);  
                      
                       
                      if(errors.errors.name)
                       $("#txtusername_prof_emp").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.name[0]+"</p>");
                       else
                         $("#txtusername_prof_emp").empty();
                         
                       if(errors.errors.email) {
                       $("#txtemail_prof_emp").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.email[0]+"</p>"); }
                       else
                         $("#txtemail_prof_emp").empty();
                       if(errors.errors.surname)
                       $("#txtsurname_prof_emp").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.surname[0]+"</p>");
                       else
                         $("#txtsurname_prof_emp").empty();
                       if(errors.errors.phone)
                       $("#txtphone_prof").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.phone[0]+"</p>");
                       else
                         $("#txtphone_prof").empty();
   				    if(errors.errors.position)
                       $("#txtposition_prof_emp").empty().append("<p style='color:red'>"+errors.errors.position[0]+"</p>");
                       else
                         $("#txtposition_prof_emp").empty();
                           
                     $(window).scrollTo(0, document.body.scrollHeight);
                      // $(window).scrollTop(0);
                                  
                   }
               });
   
           });
       });
   	
   	
   
   
   $('document').ready(function() {
        // var errorcount='<?php echo count($errors);?>';
       // if(errorcount>0)
      // $('#exampleModa5').modal('show');
       $("#divcosellers").on('submit', function(e) {
               //$(".loaderajax").show();
               e.preventDefault();
               var formData = new FormData($('#divcosellers')[0]);
               formData.append('user_id', {{$seller->id}});
               formData.append('_token', "{{ csrf_token() }}"); 
   
                   $.ajax({
                   type: "post",
                   url: "{{route('addNewCoEmpAdmn')}}",
                   data: formData,
                   enctype : 'multipart/form-data',
                   dataType: "json",
                   processData: false,
                   contentType: false,
                   success: function(data) {
                      // $(".loaderajax").hide(); 
                       swal(data, "", "success");
                       //setTimeout(window.location.reload(true),300);
                       
                       var url = new URL(window.location.href);
                       url.searchParams.set('tab','employees');
                       window.location.href = url.href;
                   },
                   error: function (xhr) {
                      //$(".loaderajax").hide(); 
                       var errors = JSON.parse(xhr.responseText);
                            
                       if(errors.errors.name)
                       $("#txtname_employee").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.name[0]+"</p>");
                       else
                         $("#txtname_employee").empty();
                       if(errors.errors.email)
                       $("#txtemail_employee").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.email[0]+"</p>");
                       else
                         $("#txtemail_employee").empty();
                       if(errors.errors.username)
                       $("#txtusername_employee").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.username[0]+"</p>");
                       else
                         $("#txtusername_employee").empty();
                       if(errors.errors.phone){ 
                       $("#txtphone_employee").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.phone[0]+"</p>"); }
                       else
                         $("#txtphone_employee").empty();
                       /*if(errors.errors.password)
                       $("#txtpassword_employee").empty().append("<p style='color:red'>"+errors.errors.password[0]+"</p>");
                       else
                         $("#txtpassword_employee").empty();
                       if(errors.errors.password_confirmation)
                       $("#txtpassword_employee_confirmation").empty().append("<p style='color:red'>"+errors.errors.password_confirmation[0]+"</p>");
                       else
                         $("#txtpassword_employee_confirmation").empty();*/
                          
                                  
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
   
   
   $("#form_about").on('submit', function(e) {
                
               e.preventDefault();
               var formData = new FormData($('#form_about')[0]);
               formData.append('_token', "{{ csrf_token() }}");
                  var about_company = tinymce.activeEditor.getContent(); 
                   formData.append('about_company', about_company);
                   formData.append('user_id', {{$seller->id}});
                   $.ajax({
                   type: "post",
                   url: "{{route('updateAdmCompAbout')}}",
                   data: formData,
                   enctype : 'multipart/form-data',
                   dataType: "json",
                   processData: false,
                   contentType: false,
                   success: function(data) {
                      // $(".loaderajax").hide();
                      $("#submitmessage").show();
                     $("#submitmessage").empty().append('<div class="alert alert-success">'+data+'</div>'); 
                     $("#submitmessage").delay(1000).fadeOut(500);
                      $(".edit_tab1").css("display", "none");
                      $(".view_tab1").show();
                      $(".edit_tab1").hide();
                      
                      //setTimeout(window.location.reload(),10);
                      var url = new URL(window.location.href);
                       url.searchParams.set('tab','about');
                       window.location.href = url.href;
                   },
                   error: function (xhr) {
                      //$(".loaderajax").hide();
                       var errors = JSON.parse(xhr.responseText);
                         
                       if(errors.errors.about_company)
                       $("#txtabt").empty().append("<p  class='txt_err' style='color:red'> About is required</p>");
                       else
                         $("#txtabt").empty();
                       
                       $("#submitmessage").show();
                       $("#submitmessage").empty().append('<div class="alert alert-warning">Update Failed!!</div>');
                       $("#submitmessage").delay(1000).fadeOut(500);
                       $(window).scrollTo(0, document.body.scrollHeight);
                                  
                   }
               });
             });  
   
   $("#region-form").on('submit', function(e) {
                
               e.preventDefault();
               var formData = new FormData($('#region-form')[0]); 
                formData.append('user_id', {{$seller->id}});
               formData.append('_token', "{{ csrf_token() }}");
                   
   
                   $.ajax({
                   type: "post",
                   url: "{{route('updateCompanyAbtRegions')}}",
                   data: formData,
                   enctype : 'multipart/form-data',
                   dataType: "json",
                   processData: false,
                   contentType: false,
                   success: function(data) {
                      // $(".loaderajax").hide();
                      $("#submitmessage").show();
                      $("#submitmessage").empty().append('<div class="alert alert-success">'+data+'</div>'); 
                      $("#submitmessage").delay(1000).fadeOut(500);
                      $(".edit_tab1").css("display", "none");
                      $(".view_tab1").show();
                      $(".edit_tab1").hide();
                  <?php Session::put("tab", "myRegions"); ?>
                      setTimeout(window.location.reload(),10);
                      //var url = new URL(window.location.href);
                     //  url.searchParams.set('tab','regions');
                      // window.location.href = url.href;
                   },
                   error: function (xhr) {
                      //$(".loaderajax").hide();
                       var errors = JSON.parse(xhr.responseText);
                       $("#submitmessage").show();
                       $("#submitmessage").empty().append('<div class="alert alert-warning">Update Failed!!</div>');
                       $("#submitmessage").delay(1000).fadeOut(500);
                       
                       $(window).scrollTo(0, document.body.scrollHeight);
                                  
                   }
               });
             });  
   
   $("#compny_profile").on('submit', function(e) { 
                // $(".loaderajax").show();
                
               e.preventDefault();
                
               var formData = new FormData($('#compny_profile')[0]);
               formData.append('user_id', {{$seller->id}});
               formData.append('_token', "{{ csrf_token() }}"); 
              
                   
   
                   $.ajax({
                   type: "post",
                   url: "{{route('updateAdmCompProf')}}",
                   data: formData,
                   enctype : 'multipart/form-data',
                   dataType: "json",
                   processData: false,
                   contentType: false,
                   success: function(data) {
                      // $(".loaderajax").hide();
                     $("#submitmessage").empty().append('<div class="alert alert-success">'+data+'</div>');
                       
                       setTimeout(window.location.reload(),300);
                       $(window).scrollTo(0, document.body.scrollHeight);
                   },
                   error: function (xhr) {
                      //$(".loaderajax").hide();
                       var errors = JSON.parse(xhr.responseText);
                       
                         
                       if(errors.errors.image)
                       $("#txtimgpicture").empty().append("<p  class='txt_err' style='color:red'>Company logo is required</p>");
                       else
                         $("#txtimgpicture").empty();
                         
                         if(errors.errors.company_email)
                       $("#txtemail").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.company_email[0]+"</p>");
                       else
                         $("#txtemail").empty();
                       
                       if(errors.errors.company_phone)
                       $("#txtphone").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.company_phone[0]+"</p>");
                       else
                         $("#txtphone").empty();
                         
                        
                         
                       if(errors.errors.company_name)
                       $("#txtcompany").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.company_name[0]+"</p>");
                       else
                         $("#txtcompany").empty();
                       if(errors.errors.company_type)
                       $("#txtcompanytype").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.company_type[0]+"</p>");
                       else
                         $("#txtcompanytype").empty();
                       if(errors.errors.company_location)
                       $("#txtcompanylocation").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.company_location[0]+"</p>");
                       else
                         $("#txtcompanylocation").empty();
                       if(errors.errors.company_street)
                       $("#txtcompanystreet").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.company_street[0]+"</p>");
                       else
                         $("#txtcompanystreet").empty();
                       if(errors.errors.company_zip)
                       $("#txtcompanyzipcode").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.company_zip[0]+"</p>");
                       else
                         $("#txtcompanyzipcode").empty();
                       if(errors.errors.country_id)
                       $("#txtcnryid").empty().append("<p  class='txt_err' style='color:red'>Country field is required</p>");
                       else
                         $("#txtcnryid").empty();
                        
                       if(errors.errors.offline_categories)
                      { $("#offline_categories1").empty().append("<p  class='txt_err' style='color:red'>Select the categories your company is active in</p>");
                      }
                       else
                         $("#offline_categories1").empty();
                        /* if(errors.errors.offline_categories)
                      { $("#company_types1").empty().append("<p style='color:red'>Select your company type</p>");
                      }
                       else
                         $("#company_types1").empty();*/
                       $("#submitmessage").empty().append('<div class="alert alert-warning">Profile Update Failed!!</div>');
                       $("#submitmessage").delay(1000).fadeOut(500);
                       $(window).scrollTo(0, document.body.scrollHeight);
                                  
                   }
               });
             });  
   
   
   
   
   var route = "{{route('offlineAdmcategories')}}";
      $('#offline_categories').select2({
        placeholder: 'Select Product Categories',
   
       
       ajax: {
         url: route,
         dataType: 'json',
         delay: 250,
         <?php if($seller->id!="")  { ?>
    data: {
       user_id: {{$seller->id}}
   },
   <?php } ?>
         processResults: function(data) {
           return {
             results: $.map(data, function(item) {
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
      $('#company_type').select2({
        placeholder: 'Select Company Types',
        ajax: {
         url: route1,
         dataType: 'json',
         delay: 250,
         processResults: function(data) {
           return {
             results: $.map(data, function(item) {
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
   
   
   /*
   $(document).ready( function () {
               $(".pr-password").passwordRequirements({
   
   });
           });*/
   function editfrm(){
    $(".edit_top").css("display", "block");
    $(".cover-c.edit_form").css("display", "block");
    $(".profile_top").hide();
    $(".edit_form").show();
   }
   
   function edittab1(){
    $(".edit_tab1").css("display", "block");
    $(".view_tab1").hide();
    $(".edit_tab1").show();
   }
   function editmap(){
    $(".map-descrip_view").hide();
    $(".map-descrip_edit").show();
   }
   function HideEditRegions(){ 
      $(".map-descrip_edit").css("display", "none");
      $(".map-descrip_view").css("display", "block");
      $(window).scrollTo(0, document.body.scrollHeight);
     }
   function HideEditEmployees(){ 
      $("#edit_active").val('no');
      $(".edit_emp_icon").css("display", "none");
      $(".parentYes").css("display", "block");
      $(window).scrollTo(0, document.body.scrollHeight);
     }   
   function edittabEployees(){
    
    $("#edit_active").val('yes');
    $(".edit_emp_icon").css("display", "block");
   // $(".parentYes").css("display", "none");
   }	
   
   
   $('#upload_abtimg2').click(function(){  
   $('#imgupload_abtimg2').trigger('click'); 
   });
    
    
   $(".about_image2").change(function(e) {  
   var data = new FormData();
   data.append('about_image2', this.files[0]);
   data.append('user_id', {{$seller->id}});
   data.append('_token', "{{ csrf_token() }}"); 
   $.ajax({
           url:'{{route('updateAdmAbtimg2')}}',
           type: 'POST',
           data : data,
           enctype : 'multipart/form-data',
           contentType: false,
           processData: false,
           success: function( data ) { 
               var baseUrl = "{{asset('')}}";
               var imageUrl = baseUrl + data.image_path;
               $('.abt2_img').attr('src', imageUrl);
               $(".abt2_remove").show()
             //  $('#changeimage').html('<img src="'+ imageUrl +'" height="120px" width="150px">');
           },
           error: function(xhr) {
             var errors = JSON.parse(xhr.responseText); 
            if(errors.message)
               $("#about_img2_error").empty().append("<p  class='txt_err' style='color:red'>"+errors.message+"</p>");
             else
               $("#about_img2_error").empty();
                         
           }
          });   
       });
   
   $('#upload_abtimg1').click(function(){  
   $('#imgupload_abtimg1').trigger('click'); 
   });
    
    
    $(".about_image1").change(function(e) {  
        
   var data = new FormData();
   data.append('about_image1', this.files[0]);
   data.append('user_id', {{$seller->id}});
   data.append('_token', "{{ csrf_token() }}"); 
   $.ajax({
           url:'{{route('updateAdmAbtimg1')}}',
           type: 'POST',
           data : data,
           enctype : 'multipart/form-data',
           contentType: false,
           processData: false,
           success: function( data ) { 
               var baseUrl = "{{asset('')}}";
               var imageUrl = baseUrl + data.image_path;
               $('.abt1_img').attr('src', imageUrl);
             //  $(".abt1_remove").show();
              
               $("a.btn.abt1_remove").show();
               $("a.btn.abt1_remove").css("display", "block");
               $(".abt1_remove").css("display", "block");
             //  $('#changeimage').html('<img src="'+ imageUrl +'" height="120px" width="150px">');
           },
           error: function(xhr) {
             var errors = JSON.parse(xhr.responseText); 
            if(errors.message)
               $("#about_img1_error").empty().append("<p  class='txt_err' style='color:red'>"+errors.message+"</p>");
             else
               $("#about_img1_error").empty();
                         
           }
          });   
       });
   
   
   
   
   $('#upload_image').click(function(){  
   $('#imgupload').trigger('click'); 
   
    });
   //$(".image").change(function(e) {  
   $(".company_image").change(function(e) {       
   var data = new FormData();
   data.append('company_image', this.files[0]);
   data.append('user_id', {{$seller->id}});
   data.append('_token', "{{ csrf_token() }}"); 
   $.ajax({
           url:'{{route('updateAdmCompimage')}}',
           type: 'POST',
           data : data,
           enctype : 'multipart/form-data',
           contentType: false,
           processData: false,
           success: function( data ) { 
               var baseUrl = "{{asset('')}}";
               var imageUrl = baseUrl + data.image_path;
               $('.prof_img').attr('src', imageUrl);
             //  $('#changeimage').html('<img src="'+ imageUrl +'" height="120px" width="150px">');
           },
           error: function(xhr) {
             var errors = JSON.parse(xhr.responseText); 
            if(errors.message)
               $("#company_logo_error").empty().append("<p  class='txt_err' style='color:red'>"+errors.message+"</p>");
             else
               $("#company_logo_error").empty();
                         
           }
          });   
       });
   $('#upload_cmpBanner').click(function(){  
   $('#imgupload_banner').trigger('click'); 
   });
    
    
    $(".image_banner").change(function(e) {  
        
   var data = new FormData();
   data.append('image_banner', $('input[type=file]')[0].files[0]);
   data.append('_token', "{{ csrf_token() }}");
   data.append('user_id', {{$seller->id}});
   $.ajax({
           url:'{{route('updateAdmCompbanner')}}',
           type: 'POST',
           data : data,
           enctype : 'multipart/form-data',
           contentType: false,
           processData: false,
           success: function( data ) { 
               var baseUrl = "{{asset('')}}";
               var imageUrl = baseUrl + data.image_path;
               $('.banner_img').attr('src', imageUrl);
             //  $('#changeimage').html('<img src="'+ imageUrl +'" height="120px" width="150px">');
           },
           error: function(xhr) {
               //alert(errors.message);
             var errors = JSON.parse(xhr.responseText); 
            if(errors.message)
               $("#bnner_image_error").empty().append("<p  class='txt_err' style='color:red'>"+errors.message+"</p>");
             else
               $("#bnner_image_error").empty();
                         
           }
           
           
          });   
       });
   
   
   
   
       $(document).ready(function() {
           $('#cf-form').submit(function(e) { 
               e.preventDefault();
   
               // Serialize the form data
              //const formData = new FormData(form);
              var formData = new FormData($('#cf-form')[0]); 
              formData.append('user_id', {{$seller->id}});
               formData.append('_token', "{{ csrf_token() }}"); 
               // Send an AJAX request
                $.ajax({
                   type: "post",
                   url: "{{ route('resetAdmpassword') }}",
                   data: formData,
                   enctype : 'multipart/form-data',
                   dataType: "json",
                   processData: false,
                   contentType: false,
                   success: function(data) {
                       //$(".loaderajax").hide();
                       
                       //data.message
                       
                           if(data.message) {
                               $("#new_pw").empty(); 
                               $('#cntpw').val('');
                               $('#password').val('');
                               $('#password-confirm').val('');
                           $("#pw_updated").empty().append("<p style='color:green'>"+data.message+"</p>");
                           }
                         else
                           $("#pw_updated").empty();
                           
                   },
                   error: function (xhr) {
                      // $(".loaderajax").hide();
                       //$("#btnsubmit").prop('disabled', false);
                       $("#loading-image").hide(); 
   
                       var errors = JSON.parse(xhr.responseText);  
                      
                       
                       
                         
                       if(errors.errors.password)
                           $("#new_pw").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.password[0]+"</p>");
                         else
                           $("#new_pw").empty();
                           
                        if(errors.errors.password_confirmation)
                           $("#confirm_pw").empty().append("<p  class='txt_err' style='color:red'>"+errors.errors.password_confirmation[0]+"</p>");
                         else
                           $("#confirm_pw").empty();  
                           if(errors.errors.password_confirmation)
                           
                     $(window).scrollTo(0, document.body.scrollHeight);
                      // $(window).scrollTop(0);
                                  
                   }
               });
   
           });
       });
       
      function empSubmit(id) {
     
         
           $('#pw_reset'+id).submit(function(e) { 
               e.preventDefault();
   
               // Serialize the form data
              //const formData = new FormData(form);
             // var formData = new FormData($('#pw_reset')+id+[0]); 
             var email=  $('#EmpEmail'+id).val() ;
               var formData = new FormData($('#pw_reset'+id)[0]);
               formData.append('_token', "{{ csrf_token() }}"); 
               // Send an AJAX request
                $.ajax({
                   type: "post",
                   //url: "{{ route('employeesPassword.reset') }}",
                   url: "{{ route('employeesPassword.reset') }}",
                   data: formData,
                   enctype : 'multipart/form-data',
                   dataType: "json",
                   processData: false,
                   contentType: false,
                   success: function(data) {
                       //$(".loaderajax").hide();
                       swal('We have e-mailed your password reset link!'); 
                       //data.message
                      /* if(data)
                           $("#mail_send_success").empty().append("<p style='color:red'>"+data+"</p>");
                         else
                           $("#mail_send_success").empty();*/ 
                          
                           
                   },
                   error: function (xhr) {
                    
                      
                     $(window).scrollTo(0, document.body.scrollHeight);
                      // $(window).scrollTop(0);
                                  
                   }
               });
   
           });
    
      } 
       
</script>
<script type="text/javascript">
   editemployees();
   function editemployees(){ 
     var profId = null;
     <?php if((request()->route('profId')!=null)) { ?>
           profId = {{request()->route('profId')}}; 
     <?php } ?>
     var user_id = {{$seller_id}}; 
     $.ajax({ 
                               type : 'post',
                               url:"{{route('loadEmployeesCompProf')}}",
                               data:{
                                 _token:'{{ csrf_token() }}',
                                 'user_id':user_id,
                                 'profId':profId,
                                 'start_from':$('#start_from_empEdit').val(),
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
                                      //string += '<a class="edit-btn-prf employee-pen" id="employee_edit_options' + item.id + '" onclick="empEdit(' + item.id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>';
                                      string += '<div class="dropdown edit-prf-new">';
                                      if($('#edit_active').val()=='no') {
                                      string += '<button style="display:none;" class="btn btn-secondary dropdown-toggle edit_emp_icon" type="button" id="dropdownMenuButton1" data-toggle="dropdown" e="dropdown" aria-expanded="false">';
                                      string += '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>';
                                      string += '</button>';
                                      } else { 
                                      string += '<button  class="btn btn-secondary dropdown-toggle edit_emp_icon" type="button" id="dropdownMenuButton1" data-toggle="dropdown" ="dropdown" aria-expanded="false">';
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
                                      string += '<button class="dropdown-item" type="submit"   onclick="deleteconfirmUser(' + item.id + ')">Remove User</button>';
                                      string += ' </form> </li> </ul> </div> </div>';
                                      string += '<ul class="bsc-inf">';
                                      string+='<li class="us-nam">'+item.name+' '+item.surname+'</li>';
   								   if (item.position != null)
   								   { string+='<li class="des">'+item.position+'</li>'; }
   								   string += '<li class="tl"><a href="tel:' + item.phone + '">' + item.phone + '</a></li>';
                                      string += '<li class="inf"><a href="mailto:' + item.email + '">' + item.email + '</a></li>';
                                      string += '</ul> </div> </div> </div></div>';                                
   								    
   								
                                   })
                                   $("#employee-listing-edit").append(string);
                                  // $(".loaderajax").hide();
                                      var skipcount1=parseInt($("#start_from_empEdit").val())+ initial ; 
                                      if(dataItems.count!=skipcount1)
                                         $("#employee-listing-edit").append('<div class="row"><div class="default-btn ld-mo" style="margin:15px auto;" id="loadmore_empEdit" onclick="loadmore_empEdit()">Load More</div></div>');
                                   
                                  
                                     $("#start_from_empEdit").val(skipcount1);
            
                                      
                               },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    //$(".loaderajax").hide();
                  swal(errorThrown, "", "error");
                }
   
   
                         });
   
   }
   
   function loadmore(){
     $("#loadmore").remove();
     loadproductss();
   }
   /*function loadmore_emp(){
     $("#loadmore_emp").remove();
     loademployees();
   }*/
   function loadmore_empEdit(){
     $("#loadmore_empEdit").remove();
     editemployees();
   }
   
   $(document).ready(function(){
    $(".nav-link").click(function(){ 
       $(".pro-lft-widget").hide();
     });
     $("#profile-tab").click(function(){ 
       $(".pro-lft-widget").show(300);
     });
   });
   
   
   
   
   var wish_count = <?=$view_composer_wishCount?>;
           function addToWishlist(id = null){ 
               
                   if(id != null){
                       $.ajax({
                           type:'GET',
                           url:'{{ route("addToWishlist") }}',
                           data:{id: id, '_token':'{{csrf_token()}}'},
                           success:function(response){
                            $('#active_wish'+id).show();
                            $('#inactive_wish'+id).hide();
                            wish_count = wish_count+1;
                            $('.wish-count').html(wish_count);
                            var res = $('.wish-count').html();
                            if( res == 0)
                               {  $('.wishlist_count').hide(); }
                            else {  $('.wishlist_count').show();  }
                               $('#outer_wish'+id).hide();
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
                       $.ajax({
                           type:'GET',
                           url:'{{ route("RemoveWishlist") }}',
                           data:{id: id, '_token':'{{csrf_token()}}'},
                           success:function(response){
                            // location.reload();
                               $('#inactive_wish'+id).show();
                               $('#active_wish'+id).hide();
                               $('#outer_wish'+id).hide();
                               wish_count = wish_count-1;
                               $('.wish-count').html(wish_count);
                               var res = $('.wish-count').html();
                               if( res == 0)
                               {  $('.wishlist_count').hide(); }
                               else {  $('.wishlist_count').show();  }
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
    $("#contact").hide();
   $(".nav-link").on('click', function(e) { 
       if($(this).attr('id') == 'myRegions'){
           $("#contact").show();
       }else{
            $("#contact").hide();
       }
   });
</script>
<script>
   /*$(function() {
   	var Accordion = function(el, multiple) {
   		this.el = el || {};
   		this.multiple = multiple || false;
   
   		// Variables privadas
   		var links = this.el.find('.link');
   		// Evento
   		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
   	}
   
   	Accordion.prototype.dropdown = function(e) {
   	    //if($(".parent-check-active").prop('checked') == false){
   		var $el = e.data.el;
   			$this = $(this),
   			$next = $this.next();
   
   		$next.slideToggle();
   		$this.parent().toggleClass('open');
   
   		if (!e.data.multiple) {
   			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
   		};
   	   // }
   	}	
   
   	var accordion = new Accordion($('.accordion1'), false);
   });*/
</script>
<script>
   /*$(function() {
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
   			$this = $(this),
   			$next = $this.next();
   
   		$next.slideToggle();
   		$this.parent().toggleClass('open');
   
   		if (!e.data.multiple) {
   			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
   		};
   	}	
   
   	var accordion = new Accordion($('.accordion2'), false);
   });*/
</script>
@endsection