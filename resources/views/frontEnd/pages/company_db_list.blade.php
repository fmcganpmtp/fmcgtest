@if($view_composer_profile_menu_visible_criteria['network_expand'] != 1)
<div class="col-lg-12 col-12 ">
              <div class="err-shw" style="display:none; margin-top:20px;">
                        <div class="alert alert-danger alert-dismissible">
                         Expand Your Network option is disabled as per the current package. Would you like to upgrade package? <a href="{{route('package.listing')}}">Upgrade</a>
                       </div>
                    </div>
              
              </div>
@else


<?php  
$clas="";
if(count($user_data)>0){
    $count=1;
foreach ($user_data as $data)  { 


$class_verified = '';
			if($data['varification_status']=='varified')
			$class_verified = 'active-border';            
			$company_image =    $data['company_image'];
			if(($company_image!=''))
$img_path = asset('uploads/BuyerCompany/').'/'.$company_image;
elseif(!empty($data['profile_pic']))
$img_path = asset('/uploads/userImages/').'/'.$data['profile_pic'];
else  
$img_path = asset('uploads/defaultImages/default_avatar.png');        
$network_exist=false;

$c_types = $c_types_names =[]; 
		if($data['cmp_type']) { 
				  
				   foreach ($company_types as $company_type)
				   {
							  $c_types = explode(",",$data['cmp_type']);
							   if(in_array($company_type->id, $c_types))
							 $c_types_names[] = $company_type->company_type ;
				  } 
		}
				  $c_types_names =  implode( ', ', $c_types_names );

if($count>1 &&  $view_composer_profile_menu_visible_criteria['network_chat'] != 1)
$clas = "filter-blur";
?>





<div class="col-lg-4 col-12 {{$clas}}"> 
                    <div class="nt-wrk-gray-bx">
                      <div class="row">
                        <div class="col-lg-4 col-12">
                          <div class="nt-wrk-gr-img">
					 <img src="{{$img_path}}" onclick="fnmovetoprofile({{$data['main_id']}})" style="cursor: pointer;">
					 </div>
                        </div>
                        <div class="col-lg-8 col-12">
                            <h2  onclick="fnmovetoprofile( {{$data['main_id']}})" style="cursor: pointer;" >{{$data['company_name']?$data['company_name']:$data['user_name']}}</h2>
                             @if($data['cmp_type'])
                    	<h3>  {{$c_types_names}}</h3>
                      @endif
                          
                           @if($data['country_name'])
					  
						<h4>  {{$data['country_name']}} </h4>
					   
					  
                      @endif
                          @if(!empty($data['categorylists']))
                          <?php $catArray = []; ?>
                          
                    @foreach($data['categorylists'] as $categorylist)
                    <?php  $catArray[] = ucfirst($categorylist); ?>
                    
                    @endforeach
                    <h5>{{implode( ', ', $catArray )}}</h5>
                    @else
                    <h5 style="color:#ff0000;">No Categories</h5>
                    @endif
                         
                        </div>
                      </div>
                      <div class="nw-fray-decrip">
                        <p>{{$data['about_company']}} </p>
                      </div>
                      <div class="bottm-img-listing">
                         
                   
                          <ul>
                    <?php $featrd_cnt=count($data['prod_data']); ?>
                    @if($featrd_cnt>0)
                     @foreach($data['prod_data'] as  $key => $prod)
                     <li>  <div class="gr-img-bx"><a target="_blank" href="{{ route('view.Sproduct',$prod['product_id'])}} ">
                            @if($prod['thumbImg'])
                            <img src="{{URL::asset('/uploads/productImages/'.'/'.$prod['thumbImg'])}}">
                            @else
                            <img src="{{URL::asset('images/no-image.jpg')}}">
                            @endif
                            </a></div>
                      </li>
                      
                    
                    @endforeach
                    @endif 
                   <?php if($featrd_cnt<4) {
                       for($i=0;($i<(4-$featrd_cnt));$i++) { ?>
                      <li>
                            <div class="gr-img-bx"><img src="{{URL::asset('images/LOGO_ICON_FMCG_LAND.gif')}}"></div>
                      </li>
                      
                 <?php }
                    }?>
                     </ul> 
                          
                          
                        
                      </div>
                    
                       @if( $view_composer_profile_menu_visible_criteria['network_chat'] == 1)
                     <a href="javascript:void(0)" class="green-button clsa{{$data['main_id']}}" onclick="addtonetwork( {{$data['main_id']}})" >Add to Network</a>
                     @else
                    <a onclick="showerror()" href="JavaScript:void(0);" class="green-button">Add to Network</a>
					  @endif
                       <div class="filter-layer"></div>
                      </div>
                  </div>






<?php $count++; } } ?>
 <div class="seller-pagi {{$clas}}">
  
{{ $user_qry->links() }} 

@if($last_page>1)
<input type="text" name="page_number" id="pg_number" onchange="my_sellers_search()" max="{{$last_page}}">
of {{$last_page}} items.
@endif
<div class="filter-layer"></div>
</div>
@endif
<script>
const el = document.createElement('div')
el.innerHTML = "Chat option is disabled as per the current package.Would you like to upgrade package? <a href='{{route('package.listing')}}'>Upgrade</a>"
    function showerror(){
  swal({
  icon: "error",
  content: el,
});
}
</script>  