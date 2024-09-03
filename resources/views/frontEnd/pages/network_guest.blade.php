@extends('layouts.template')
@section('title', 'Company Database')
@section('content')
 
@if(!is_null($slider))
	<section class="sliderC">
		<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-pause="false">
			<?php  $count = 0;  ?>
			<div class="carousel-indicators">
				@foreach ($slider as $Slider_img)
				<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$count}}" class="@if($count==0)  active @endif" aria-current="true" aria-label="Slide {{$count}}"></button>
				<?php $count++; ?>
				@endforeach 
			</div>
			<?php  $count = 0;  ?>
			<div class="carousel-inner">
				@foreach ($slider as $Slider_img)  
				<div class="carousel-item @if($count==0)  active @endif" data-bs-interval="5000">
				    @if($Slider_img->target!='')  
											<?php 
                          $url = (!preg_match("~^(?:f|ht)tps?://~i", $Slider_img->target))?"http://" . $Slider_img->target:$Slider_img->target; 
                          ?>
										<a href="{{$url}}" target="_blank" >
										@endif 
					<img src="{{ URL::asset('/assets/uploads/sliders/'.$Slider_img->image)}}"     class="d-block w-100" alt=""></a>
					<!--<div class="carousel-caption">
						<div class="container">
							<div class="row">
								<div class="col-lg-12">
									<div class="banner-caption">
										
									
										 
									</div>
								</div>
							</div>
						
						</div>
						
					</div>-->
				</div>
				<?php $count++; ?>
				@endforeach  
			</div>
			<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="visually-hidden">Previous</span> </button>
			<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="visually-hidden">Next</span> </button>
		</div>
	</section>
	@endif
<section class="my-n-w-new">
   <!-- Modal -->
   
   <div class="container myNetWork">
      <div class="row">
         <div class="col-lg-12">
            <div class="pr-bottom">
               <div class="card">
<?php 
 $cls = "show active";
$cls_myNetw = "";  

 ?>
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                     <li class="nav-item " role="presentation">
                        <button class="nav-link {{$cls}}" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Company Database</button>
                     </li>
                     <li class="nav-item " role="presentation">
                        <a href="{{ route('user-login')}}" class="nav-link  " id="network-tab"   >My Network</a>
                     </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade show  {{$cls}}" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="top-form-row">
                           <div class="row">
                              <div class="col-lg-3 col-12">
                                 <div class="mb-3">
                                    <div class="form-group">
                                       <select id="search_by_category" class="form-control" onchange="fnbtnsearchseller()">
                                          <option value="0">Industry</option>
                                          @if($allcategorylists)
                                          @foreach($allcategorylists as $item)
                                          <option value="{{$item->id}}">{{$item->name}}</option>
                                          @endforeach
                                          @endif
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-12">
                                 <div class="mb-3">
                                    <div class="form-group fm0002">
                                       <select class="js-example-data-array form-control select2-hidden-accessible" class="form-control" multiple tabindex="-1" aria-hidden="true" placeholder="Company Type" name="company_type[]" id='company_type' >
                                       @if($CompanyType)
                                       @foreach($CompanyType as $item)
                                       <option value="{{$item->id}}">{{$item->company_type}}</option>
                                       @endforeach
                                       @endif
                                       </select>  
                                       <input type="hidden" id="selected_company_type">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-12">
                                 <div class="form-group fm0002">
                                    <select type="text" placeholder="Country" name="available_countries[]" id='available_countries' class="form-control" multiple="multiple">
                                       @if($countries_cdb)
                                       @foreach($countries_cdb as $item)
                                       <option value="{{$item->id}}">{{$item->name}}</option>
                                       @endforeach
                                       @endif
                                    </select>
                                    <input type="hidden" id="selected_country_id">
                                 </div>
                              </div>
                              <div class="col-lg-3 col-12">
                                 <div class="mb-3">
                                    <input type="text" class="form-control" id="search_by_name" placeholder="Name/Keyword"> 
                                    <!--   <button type="button" onclick="fnbtnsearchseller()"><i class="fa fa-search" aria-hidden="true"></i></button>-->
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row12">
                           <div class="row" id="company_db_list"  >
                           </div>
                           <div class="seller-pagi ">  </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</sectiion>

<link rel="stylesheet" href="{{ asset('/css/select2.min.css')}}">
<script>
   const el = document.createElement('div')
   el.innerHTML = "Add to network option is disabled as per the current package.Would you like to upgrade package? <a href='{{route('package.listing')}}'>Upgrade</a>"
function showerror(){
   window.location.href="{{ route('user-login')}}";
   }
const el1 = document.createElement('div')
   el1.innerHTML = "Add to network option is disabled"  
   function showerrorCoSeller(){
     swal({
     icon: "error",
     content: el1,
   });
   }
   
</script> 
<script type="text/javascript">
   var responseData ='';var eachProduct ='No products found';var pgntion ='';
   var network_expand ="";
   var user_type ="";

   if(network_expand!=1 )
   {
      // $fmcg(".seller-pagi").addClass("filter-blur");
       $fmcg(".ntwrk-pagi").addClass("filter-blur");
   }
   var urlP= "{{ route('view.Sproduct',0) }}";
   var urlI= "{{URL::asset('/uploads/productImages/')}}";
   var urlN= "{{URL::asset('images/no-image.jpg')}}";
   var urlD="{{URL::asset('images/LOGO_ICON_FMCG_LAND.gif')}}";
   function my_net_contact(){
     
      //$fmcg('li').removeClass('active');
         $fmcg(this).parent('li').addClass('active');
         var page= $fmcg('#pg_number1').val(); 
         getnetworkList(page);
   }
   
   function my_sellers_search(){
     
      //$fmcg('li').removeClass('active');
         $fmcg(this).parent('li').addClass('active');
         var page= $fmcg('#pg_number').val(); 
         fnloadsellers(page);
   }
 
   
   
   $fmcg(".js-example-data-array").select2({
       placeholder: 'Company Type',}
       ).on("change", function (e) {
         fnbtnsearchseller();
     });
   
     $fmcg('#available_countries').select2({
      placeholder: 'Country',}
      ).on("change", function (e) {
      fnbtnsearchseller();
   });
   
     $fmcg('#available_countries2').select2({
       placeholder: 'Country',
       }).on("change", function (e) {
       fnbtnsearchnetwork();
     });
   
     $fmcg('#company_type1').select2({
      placeholder: 'Company Type',
     }).on("change", function (e) {
      fnbtnsearchnetwork();
     });
   
     
   
  // getnetworkList(1); //bottom already added list
   fnloadsellers(1); //top search
   $fmcg('#search_by_category,#search_by_category1').select2();
   
   $fmcg(document).on("click", ".hd_srch_btn", function(e) { 
		$fmcg("#search_by_name").val($fmcg('.hd_srch').val());
      $fmcg("#company_db_list").empty();
      fnloadsellers();
	});
   $fmcg(document).on("click", ".hd_srch", function(event) { 
     // alert(1);
      $fmcg('.search-box').submit(false);
             event.preventDefault();
             $fmcg("#company_db_list").empty();
             fnloadsellers();
          
	});
   $fmcg("#search_by_name").keydown(function (event) { 
         if (event.which == 13) { 
            $fmcg('.search-box').submit(false);
             event.preventDefault();
             $fmcg("#company_db_list").empty();
             fnloadsellers();
         }
   });    
 
     
   function fnmovetoprofile1(userid)
   { //alert(userid);
   // window.location="{{route('CompanyProfile', ':id')}}".replace(':id', '')+userid;
   window.location.href="{{route('CompanyProfile', ':id')}}".replace(':id', '')+userid;
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
                  $fmcg(".my-cdb-out"+userid).remove();
                 
                  $fmcg("#network_list").empty();
                 // getnetworkList();
                  //fnloadsellers();
                  setTimeout(window.location.reload(),10);
              } ,
              error: function(XMLHttpRequest, textStatus, errorThrown) { 
                 // $fmcg(".loaderajax").hide();
                swal(errorThrown, "", "error");
              }  
    
            })  ;
   }
   
   function fnbtnsearchseller(){
     
    
      $fmcg("#company_db_list").empty();
      fnloadsellers();
      @if($view_composer_profile_menu_visible_criteria['network_expand'] != 1 )
      $fmcg('.err-shw').css('display','block');
      @else
      $fmcg('.err-shw').css('display','none');
      @endif
   }
   
   function fnbtnsearchnetwork(){
    
      $fmcg("#network_list").empty();
      getnetworkList();
   }
   
   
    function fnloadsellers(page){  
        $fmcg(".seller-pagi").empty(); 
        $fmcg('#company_db_list').empty();
        $fmcg.ajax({
            type:'POST',
            async:true,
             cache: false,
            data:{
                 '_token':'{{csrf_token()}}',
                 'seller_name':$fmcg('#search_by_name').val(),
                 'category_id':$fmcg('#search_by_category').val(),
                 'company_type':$fmcg('#company_type').val(),
                 'selected_country_id':$fmcg('#available_countries').val(),
                 'per_page':9
           },
            url: "{{ route('company-dbs-guest') }}" + "?page=" + page,
           success:function(data) {
              // console.log(data)
             reWriteSellerProducts(data);
           },
           error: function(XMLHttpRequest, textStatus, errorThrown) { 
                  //$fmcg(".loaderajax").hide();
                swal(errorThrown, "", "error");
              } 
        });
   
   }
   
   function reWriteSellerProducts(data){
   
   responseData = $fmcg.parseJSON(data);
   var pgntion='';
   
    console.log(responseData.user_qry.links); 
   if(responseData.user_data.length==0){
     $fmcg('#company_db_list').empty().html('No records!');
     var pgntion='';
   }
   else
   {
     $fmcg('#company_db_list').empty();
     var counter =1;
     $fmcg.each( responseData.user_data, function( key, product ) {
       var cssClass=(counter>1 && (network_expand!=1)) ? 'filter-blur':'';
   
       eachProduct='<div class="col-lg-4 col-12 my-cdb-out'+product.main_id+' ">';
	   eachProduct=eachProduct+'<div class="gray-bor-box">';
       eachProduct=eachProduct+'<div class="nt-wrk-gray-bx '+cssClass+'"><div class="row"><div class="col-lg-4 col-12"><div class="nt-wrk-gr-img">';
       if(network_expand==1 )
       eachProduct=eachProduct+'<img src="'+product.company_image+'" onclick="fnmovetoprofile1('+product.main_id+')" style="cursor: pointer;">';
       else
       eachProduct=eachProduct+'<img src="'+product.company_image+'"  >';
       eachProduct=eachProduct+'</div></div><div class="col-lg-8 col-12">';
       if(network_expand==1)
       eachProduct=eachProduct+'<h2  onclick="fnmovetoprofile1('+product.main_id+')" style="cursor: pointer;" >';
       else
       eachProduct=eachProduct+'<h2>';
       if(product.company_name!=null)
       {  var cmp_name= (product.company_name.length > 17) ? product.company_name.slice(0, 17)+ "..." : product.company_name;
         eachProduct=eachProduct+ cmp_name +'</h2>';
       }
       else
       { var usr_name= (product.user_name.length > 17) ? product.user_name.slice(0, 17)+ "..." : product.user_name;
         eachProduct=eachProduct+ usr_name +'</h2>';
       }
   
       if(product.cmp_type!=null)
       { cmp_type= (product.cmp_type.length > 17) ? product.cmp_type.slice(0, 17)+ "..." : product.cmp_type;
         eachProduct=eachProduct+'<h3>'+cmp_type+'</h3>';
       }
       eachProduct=eachProduct+'<div class="cdb-cuntry">';
       if(product.country_name!=null)
       {
         eachProduct=eachProduct+'<h4>'+product.country_name+'</h4>';
       }
       eachProduct=eachProduct+'</div>';
       eachProduct=eachProduct+'<h5>'+product.categories+'</h5>';
       /*if(product.categorylists.length>0)
       {
         eachProduct=eachProduct+'<h5>'+product.categorylists.toString()+'</h5>';
       }
       else
       {
          eachProduct=eachProduct+'<h5 style="color:#ff0000;">No Categories</h5>';
       }*/
       eachProduct=eachProduct+'</div></div>';
       eachProduct=eachProduct+'<div class="nw-fray-decrip"><p>';
       if(product.about_company!=null)
       {
           if (product.about_company.length > 250)
               var abt_company = product.about_company.slice(0, 250) + "...";
            else
                var abt_company = product.about_company;
         eachProduct=eachProduct+abt_company;
       }
       eachProduct=eachProduct+'</p></div>';
       
       eachProduct=eachProduct+'<div class="bottm-img-listing"><ul>';
       
       if(product.prod_data.length>0)
       {
         $fmcg.each(product.prod_data, function(key1, prod_data){
           
           eachProduct=eachProduct+'<li><div class="gr-img-bx">';
           if(network_expand==1)
           eachProduct=eachProduct+'<a href="'+urlP.slice(0,-1)+prod_data.id+'">';
           if(prod_data.image_path!='')
           {
             eachProduct=eachProduct+'<img src="'+urlI+'/'+prod_data.image_path+'">';
           }
           else
           {
              eachProduct=eachProduct+'<img src="'+urlN+'">';
           }
           if(network_expand==1 )
           eachProduct=eachProduct+'</a>';
           eachProduct=eachProduct+'</div></li>';
   
         });
       }
       if(product.prod_data.length<4)
       {
           
           for (let i = 0; i < (4-product.prod_data.length); i++)
           {
               eachProduct=eachProduct+'<li><div class="gr-img-bx"><img src="'+urlD+'"></div></li>';
           }
       }
       eachProduct=eachProduct+'</ul></div>';      
        if(network_expand==1 ){
         eachProduct=eachProduct+'<a href="javascript:void(0)" class="green-button clsa'+product.main_id+'" onclick="addtonetwork('+product.main_id+')" >Connect</a>';
         }
         
         
         else{
         eachProduct=eachProduct+'<a onclick="showerror()" href="JavaScript:void(0);" class="green-button">Add to Network</a>';
         }
       counter++;
       eachProduct=eachProduct+'<div class="filter-layer"></div>';
	   eachProduct=eachProduct+'</div>';
       $fmcg('#company_db_list').append(eachProduct);
   
     });
   
   
   
   if(responseData.user_qry.links.length>3 && responseData.user_data.length>0){
   pgntion='<nav><ul class="pagination">';
       if(responseData.user_qry.links.length>0)
       {
         $fmcg.each(responseData.user_qry.links, function(key2, link_data){
             var pgntion_label = link_data.label;
             if(link_data.label === "&laquo; Previous")
             var pgntion_label = "<";
             if(link_data.label == "Next &raquo;")
             var pgntion_label = ">";
             
             if(link_data.active==true)
             pgntion=pgntion+'<li class="page-item active"><span class="page-link">'+pgntion_label+'</span>';
             else
              if(network_expand==1 )
                 pgntion=pgntion+'<li class="page-item"><a class="page-link" href="'+link_data.url+'">'+pgntion_label+'</a></li>';
              else
                 pgntion=pgntion+'<li class="page-item"><span class="page-link"  style="cursor: context-menu;">'+pgntion_label+'</span></li>';
   });
       }
   pgntion=pgntion+'</nav></ul>';	  
   if(responseData.user_qry.links.length>2){
     var tot = responseData.user_qry.links.length-2;
   if(network_expand==1 )  
   pgntion=pgntion+'<input type="text" name="page_number" id="pg_number" onchange="my_sellers_search()" max="'+responseData.user_qry.links.length+'">of '+responseData.last_page+' items.';
   pgntion=pgntion+'<div class="filter-layer"></div>';
   }
   }   
   
   }
   $fmcg(".seller-pagi").empty().html(pgntion);
   return true;
   }
   
   function reWriteNetworkProducts(data){
   
   responseData = $fmcg.parseJSON(data);
   
    //console.log(responseData); 
   var pgntion1='';
   if(responseData.user_qry.links.length>3 && responseData.user_data.length>0){
   pgntion1='<nav><ul class="pagination">';
       
         $fmcg.each(responseData.user_qry.links, function(key2, link_data){
             var pgntion_label = link_data.label;
             if(link_data.label === "&laquo; Previous")
             var pgntion_label = "<";
             if(link_data.label == "Next &raquo;")
             var pgntion_label = ">";
             if(link_data.active==true)
             pgntion1=pgntion1+'<li class="page-item active"><span class="page-link">'+pgntion_label+'</span>';
             else
              if(network_expand==1)
                 pgntion1=pgntion1+'<li class="page-item"><a class="page-link" href="'+link_data.url+'">'+pgntion_label+'</a></li>';
              else
                 pgntion1=pgntion1+'<li class="page-item"><span class="page-link"  style="cursor: context-menu;">'+pgntion_label+'</span></li>';
   });
      
   pgntion1=pgntion1+'</nav></ul>';	  
   var tot = responseData.user_qry.links.length-2;
   if(network_expand==1 )
   pgntion1=pgntion1+'<input type="text" name="page_number" id="pg_number1" onchange="my_net_contact()" max="'+responseData.user_qry.links.length+'">of '+responseData.last_page+' items.';
   pgntion1=pgntion1+'<div class="filter-layer"></div>';
   }
   $fmcg(".ntwrk-pagi").empty().html(pgntion1);
   
   
   
   if(responseData.user_data.length==0)
     $fmcg('#network_list').empty().html('No records!');
   else
   {
     $fmcg('#network_list').empty();
     var counter =1;
     $fmcg.each( responseData.user_data, function( key, product ) {
       var cssClass=(counter>1 && network_expand!=1) ? 'filter-blur':'';
   
       eachProduct='<div class="col-lg-4 col-12 my-nw-out'+product.main_id+' ">';
	   eachProduct=eachProduct+'<div class="gray-bor-box">';
       eachProduct=eachProduct+'<div class="nt-wrk-gray-bx '+cssClass+'"><div class="row"><div class="col-lg-4 col-12"><div class="nt-wrk-gr-img">';
       if(network_expand==1 )
       eachProduct=eachProduct+'<img src="'+product.company_image+'" onclick="fnmovetoprofile1('+product.main_id+')" style="cursor: pointer;">';
       else
       eachProduct=eachProduct+'<img src="'+product.company_image+'"  >';
       eachProduct=eachProduct+'</div></div><div class="col-lg-8 col-12">';
       if(network_expand==1 )
       eachProduct=eachProduct+'<h2  onclick="fnmovetoprofile1('+product.main_id+')" style="cursor: pointer;" >';
       else
       eachProduct=eachProduct+'<h2    >';
       if(product.company_name!=null)
       {  var cmp_name= (product.company_name.length > 17) ? product.company_name.slice(0, 17)+ "..." : product.company_name;
         eachProduct=eachProduct+ cmp_name +'</h2>';
       }
       else
       { var usr_name= (product.user_name.length > 17) ? product.user_name.slice(0, 17)+ "..." : product.user_name;
         eachProduct=eachProduct+ usr_name +'</h2>';
       }
   
       if(product.cmp_type!=null)
       { cmp_type= (product.cmp_type.length > 17) ? product.cmp_type.slice(0, 17)+ "..." : product.cmp_type;
         eachProduct=eachProduct+'<h3>'+cmp_type+'</h3>';
       }
       eachProduct=eachProduct+'<div class="cdb-cuntry">';
       if(product.country_name!=null)
       {
         eachProduct=eachProduct+'<h4>'+product.country_name+'</h4>';
       }
       eachProduct=eachProduct+'</div>';
       eachProduct=eachProduct+'<h5>'+product.categories+'</h5>';
       /*if(product.categorylists.length>0)
       {
         eachProduct=eachProduct+'<h5>'+product.categorylists.toString()+'</h5>';
       }
       else
       {
          eachProduct=eachProduct+'<h5 style="color:#ff0000;">No Categories</h5>';
       }*/
       eachProduct=eachProduct+'</div></div>';
        eachProduct=eachProduct+'<div class="nw-fray-decrip"><p>';
       if(product.about_company!=null)
       { if (product.about_company.length > 250)
               var abt_company = product.about_company.slice(0, 250 )+ "...";
            else
                var abt_company = product.about_company;
         eachProduct=eachProduct+abt_company;
       }
        eachProduct=eachProduct+'</p></div>';
       
       eachProduct=eachProduct+'<div class="bottm-img-listing"><ul>';
       
       if(product.prod_data.length>0)
       {
         $fmcg.each(product.prod_data, function(key1, prod_data){
           
           eachProduct=eachProduct+'<li><div class="gr-img-bx">';
           if(network_expand==1)
           eachProduct=eachProduct+'<a href="'+urlP.slice(0,-1)+prod_data.id+'">';
           if(prod_data.image_path!='')
           {
             eachProduct=eachProduct+'<img src="'+urlI+'/'+prod_data.image_path+'">';
           }
           else
           {
              eachProduct=eachProduct+'<img src="'+urlN+'">';
           }
           if(network_expand==1)
           eachProduct=eachProduct+'</a>';
           eachProduct=eachProduct+'</div></li>';
   
         });
       }
       if(product.prod_data.length<4)
       {
           
           for (let i = 0; i < (4-product.prod_data.length); i++)
           {
               eachProduct=eachProduct+'<li><div class="gr-img-bx"><img src="'+urlD+'"></div></li>';
           }
       }
       eachProduct=eachProduct+'</ul><div class="filter-layer"></div></div>';  
       if(network_expand==1 )
        eachProduct=eachProduct+'<a href="javascript:void(0)" id="expandnetwork'+product.main_id+'" onclick="removefromnetwork('+product.main_id+')" class="btn abt1_remove"><span class="red_round red_round_network remove-input-field"><i class="fa fa-minus-circle" aria-hidden="true"></i></span></a>';
      else
        eachProduct=eachProduct+'<a href="javascript:void(0)" id="expandnetwork"  class="btn abt1_remove"><span class="red_round red_round_network remove-input-field"><i class="fa fa-minus-circle" aria-hidden="true"></i></span></a>';
       counter++;
	   eachProduct=eachProduct+'</div>';  
       $fmcg('#network_list').append(eachProduct);
       
      
       
     });
    
     
   }
   return true;
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
   
   
   function getnetworkList(page){ 
    // $fmcg(".loaderajax").show();
   $fmcg.ajax({
             
               type: "Post",
                async:false,
                cache: false,
                data:{
                                 '_token':'{{csrf_token()}}',
                                 'seller_name':$fmcg('#search_by_name1').val(),
                                 'category_id':$fmcg('#search_by_category1').val(),
                                 'company_type':$fmcg('#company_type1').val(),
                                 'selected_country_id':$fmcg('#available_countries2').val(),
                                 //'company_type':$fmcg('#selected_company_type1').val(),
                                 
                                // 'selected_country_id':$fmcg('#selected_country_id2').val(),
                                 
                           },
                url: "{{ route('my-nw-lists') }}" + "?page=" + page,
                           success:function(data) {
                           reWriteNetworkProducts(data);
                           
                           },
   
              error: function(XMLHttpRequest, textStatus, errorThrown) { 
                 // $fmcg(".loaderajax").hide();
                swal(errorThrown, "", "error");
              }  
    
            })  ;
   }
   
   function removefromnetwork(userid)
    {
       // $fmcg(".loaderajax").show();
     $fmcg.ajax({
             url: "{{ url('revokeFrom_network') }}",
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
                  $fmcg("#div_mynetwork"+userid).remove();
                  $fmcg(".my-nw-out"+userid).remove(); 
                  $fmcg("#expandnetwork"+userid).remove(); 
                  $fmcg("#home"+userid).remove();
                  $fmcg("#company_db_list").empty();
                  //fnloadsellers();
                  //getnetworkList();
                  setTimeout(window.location.reload(),10);
              } ,
              error: function(XMLHttpRequest, textStatus, errorThrown) { 
                 // $fmcg(".loaderajax").hide();
                swal(errorThrown, "", "error");
              }  
    
            })  ;
   }
   
   
   
</script>
<script>
   $fmcg(document).ready(function()
   {
   $fmcg(document).on('click', '.seller-pagi .pagination a',function(event)
   { 
   event.preventDefault();
   $fmcg('li').removeClass('active');
   $fmcg(this).parent('li').addClass('active');
   
   var page=$fmcg(this).attr('href').split('page=')[1]; 
   fnloadsellers(page);
   });
   
   
   $fmcg(document).on('click', '.ntwrk-pagi .pagination a',function(event)
   { 
   event.preventDefault();
   $fmcg('li').removeClass('active');
   $fmcg(this).parent('li').addClass('active');
   
   var page=$fmcg(this).attr('href').split('page=')[1]; 
   getnetworkList(page);
   });
   
   
   
   });
   
   $fmcg(document).ready(function(){
   
      
       
   $fmcg(document).on('click', '.pagination_outer .pagination a',function(event)
   { 
   event.preventDefault();
   $fmcg('li').removeClass('active');
   $fmcg(this).parent('li').addClass('active');
   
   var page=$fmcg(this).attr('href').split('page=')[1]; 
   getnetworkList(page);
   });
   });
   
</script>
@endsection