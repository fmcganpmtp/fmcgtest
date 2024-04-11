@extends('admin.master')
@section('title', 'User View')
@section('breadcrumb') User View bbbbbb @endsection
@section('content')





<?php               
                                if(!empty($user->profile_pic)) 
                                $img_path = asset('/uploads/userImages/').'/'.$user->profile_pic;
                                else  
                                $img_path = asset('uploads/defaultImages/default_avatar.png');
                                $u_name = $user->name;
                                $u_position = $user->position??"";
                                $u_email = $user->email;
                                $u_phone = $user->phone;
                     
                      
                      
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
                     <input type="file" id="imgupload" class="image" name="image" style="display:none" accept="image/*" />
                      <span id="txtimgpicture"></span> 
                  </div>
                  <div class="col-lg-8 col-12"><!-- <a href="javascript: void(0)" class="greenButton btn-save">Save</a> --></div>
                </div>
              </div>
            </div>
            
              
            
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
			  


















 @if(Session::has('message')) <div class="alert alert-success">{{Session::get('message') }}</div> @endif
  <div class="body flex-grow-1 px-3">
    <div class="container-lg">
      <div class="card-out mb-4 inner-form">
        <h2>User View</h2>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 col-12">
              <div class="card ">
                <div class="card-header">Profile details</div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-5 col-12">
                      <div class="subscrip-detail-top">
                        <div class="table-prof"><img src="{{$seller->profile_pic==''?asset('/uploads/defaultImages/default_avatar.png'):asset('/uploads/userImages/').'/'.$seller->profile_pic}}"></div>
                        <label><b>Name</b> : <span class="ad-rol-name">{{$seller->name}}</span></label>
                        <label><b>Email</b> : <span class="ad-rol-name">{{$seller->email}}</span></label>
                        <label><b>Phone </b>: <span class="ad-rol-name">{{$seller->phone}}</span></label>
                        <label><b>Address </b>: <span class="ad-rol-name">{{$seller->address}}</span></label>
                     </div>
                                  
                    </div>
                    <div class="col-lg-7 col-12">

                    <div class="subscrip-detail-top subscrip-detail-right ">
                    <h6>Compnay details</h6>

                      
                    <label><b>Street</b> : <span class="ad-rol-name">{{$seller->BuyerCompany->company_street?? ""}}</span></label>
                    <label><b>Company Type</b> : <span class="ad-rol-name">
                    <?php $c_types = $c_types_names =[]; ?>
                  @if(!empty($seller->BuyerCompany->company_type))
                   @foreach ($company_types as $company_type)
                               <?php $c_types = explode(",",$seller->BuyerCompany->company_type);?>
                               @if(in_array($company_type->id, $c_types))
                               
                      <?php $c_types_names[] = $company_type->company_type ; ?>
                       @endif 
                   @endforeach 
                  @endif
                  <?php echo implode( ', ', $c_types_names ); ?>
                    </span></label>
                    <label><b>Zip Code </b> : <span class="ad-rol-name">{{$seller->BuyerCompany->company_zip ?? ""}}</span></label>

                    <label><b>Location </b>: <span class="ad-rol-name">{{$seller->BuyerCompany->company_location ?? ""}}</span></label>
                    <label><b>Land</b>: <span class="ad-rol-name">{{$seller->BuyerCompany->company_land ?? ""}}</span></label>
                    
                      <label><b>Opening hours</b> : <table class="table table-bordered table-2">
                          @foreach ($seller->SellerOpeningTime as $Spening)
                                <tr style="line-height: 10px;">
                                    <td>{!! $Spening->day !!}</td>
                                    @if($Spening->closed=='No')
                                    <td style="text-align:center;">{!! $Spening->opening_time !!}  {!! $Spening->Open_am_pm !!}</td>
                                    <td style="text-align:center;">{!! $Spening->closing_time	 !!}  {!! $Spening->Close_am_pm !!}</td>
                                    @else
                                    <td colspan="2" style="text-align:center;">Closed</td>
                                    @endif
                                </tr>
                            @endforeach
                        </table></label>
                    <label><b>Picture upload</b>: <span class="ad-rol-name up-im"><div class="up-pic"><img src="{{!empty($seller->BuyerCompany) ?($seller->BuyerCompany->company_image?asset('/uploads/BuyerCompany/').'/'.$seller->BuyerCompany->company_image:asset('uploads/defaultImages/seller.jpg')):asset('uploads/defaultImages/seller.jpg')}}"></div></span></label>


                    <label><b> Accepted payments for its products </b> : <span class="ad-rol-name">{{$seller->BuyerCompany->accepted_payments ?? ""}}</span></label>





                    <label><b>Delivery options </b>: <span class="ad-rol-name">{{$seller->BuyerCompany->deliver_options ?? ""}}</span></label>
                    <label><b>The languages that he/she speaks for communication purposes</b>: <span class="ad-rol-name">{{$seller->BuyerCompany->languages_speak ?? ""}}</span></label>
                     <br><label class="ad-flex-prp"><b>The categories your company is active in </b>: <span class="ad-rol-name">
                     <?php $off_cats = $off_cats_names =[]; ?>
                  @if(!empty($seller_OflnCats->category_id))
                   @foreach ($categories as $category)
                               <?php $off_cats = explode(",",$seller_OflnCats->category_id);?>
                               @if(in_array($category->id, $off_cats))
                               
                      <?php $off_cats_names[] = $category->name ; ?>
                       @endif 
                   @endforeach 
                  @endif
                  <?php echo implode( ', ', $off_cats_names ); ?>
                     </span></label> 
                      
                    </div>
                  </div>
                  </div>
                </div>
              </div>                                   
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
  <textarea class="form-control" placeholder="" id="txtreason"> </textarea>                    </div>
  
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
@endsection