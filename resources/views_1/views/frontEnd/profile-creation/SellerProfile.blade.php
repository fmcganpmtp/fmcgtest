<link rel="stylesheet" href="{{ asset('/css/select2.min.css')}}">
@extends('layouts.template')
@section('title', 'Seller Profile')
@section('content')



<sectiion class="seller-page no-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="pr-bottom">
          <div class="card">
            <div class="slr-details">
              <?php
                   $company_image =  $user->BuyerCompany->company_image ?? '';
                   if(($company_image!="")) 
					$img_path = asset('uploads/BuyerCompany/').'/'.$company_image;
					elseif(!empty($user->profile_pic)) 
                    $img_path = asset('/uploads/userImages/').'/'.$user->profile_pic;
                    else  $img_path = asset('uploads/defaultImages/default_avatar.png');
             if($user->varification_status=="varified") $active_class= " active-border";
             //if($user->email_status=="Yes") $active_class= " active-border";
             
             else $active_class= "";
              ?>
              <div class="pro-logo-out">
              <div class="pr-logo  {{$user->varification_status=='varified' ? 'active-border' : ''}} "><img src="{{$img_path}}">
              
              </div>
			   @if($user->varification_status=="varified")  <div class="active-tick"><i class="fa fa-check" aria-hidden="true"></i></div> @endif
			  </div>
              <div class="row"><div class="col-lg-9">
              
</div></div>
<h2>{{ $user->BuyerCompany->company_name ?? '' }}</h2>
              <div class="sl-tp01"> </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="seller-basic-top">
                    <ul>
                      <li><i class="fa fa-user" aria-hidden="true"></i>{{ $user->name ?? '' }}</li>
                      <li><i class="fa fa-envelope-o" aria-hidden="true"></i>{{ $user->email ?? '' }}</li>
                      <li><i class="fa fa-phone" aria-hidden="true"></i>{{ $user->phone ?? '' }}</li>
                      <li><i class="fa fa-suitcase" aria-hidden="true"></i>{{ $user->position ?? '' }}</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-4 col-12">
                  <h3>Categories</h3>
                  <ul class="cat-list">
                    @if(!empty($categorylists))
                    @foreach($categorylists as $categorylist)
                    <li>{{$categorylist}}</li>
                    @endforeach
                    @else
                    <p style="color:#ff0000;">No Categories</p>
                    @endif
                    
                  </ul>
                </div>
                <div class="col-lg-4 col-12">
                  <h3>Details</h3>
                 <p>  {{ $user->BuyerCompany->about_company ?? '' }}</p>
                </div>
                <div class="col-lg-4 col-12">
                  <h3>Address</h3>
                  <ul>
                    <li>{{ $user->address ?? '' }}</li>
                    <li> {{ $user->BuyerCompany->company_street ?? '' }} </li>
					<li> {{ $user->BuyerCompany->company_location ?? '' }} </li>
                    <li> {{ $user->BuyerCompany->company_zip ?? '' }} </li>
                  </ul>
                </div>
              </div>
            </div>
            <?php
             if(Auth::guard('user')->check())
            {?>
            <div class="row">
            @if($network==true)
              <div class="col-lg-12"> <a href="javascript:void(0)" onclick="addtonetwork({{$user->id}})" class="default-btn ctr mr-pro">Add To Networks</a> </div>
            @endif
            </div> 
            <?php }?>
          </div>
           
         
		 
		 
		 
		 <div class="card counting-out">
            <div class="row">
                <!--
                @foreach($category_product_count as $row)
                @if(!is_null($row['category']))
              <div class="col-lg-4 col-12">
                <div class="slr-counting">
                  <div class="row">
                    <div class="col-lg-3 col-4">
                      <div class="pro-countinf-ic">
                          
                          <?php 
            $img_url =asset('/uploads/categoryImages/'.$row['category']->category_pic); 
           if((is_null($row['category']->category_pic)))
          $img_url = asset('uploads/defaultImages/pop-ic-4.png');   
            ?><img src="{{ $img_url }}">
                          </div>
                    </div>
                    <div class="col-lg-9 col-8">
                      <h4>{{$row['product_count']}}+</h4>
                      <h5>{{$row['category']->name}}</h5>
                    </div>
                  </div>
                </div>
              </div>
              @endif
               @endforeach
               -->
              <div class="col-lg-4 col-12">
                <div class="slr-counting">
                  <div class="row">
                    <div class="col-lg-3 col-4">
                      <div class="pro-countinf-ic"><img src="{{ URL::asset('assets/images/view.png')}}"></div>
                    </div>
                    <div class="col-lg-9 col-8">
                      <h4>{{$profile_visit_count}}+</h4>
                      <h5> Profile viewers </h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-12">
                <div class="slr-counting">
                  <div class="row">
                    <div class="col-lg-3 col-4">
                      <div class="pro-countinf-ic"><img src="{{ URL::asset('assets/images/growth.png')}}"></div>
                    </div>
                    <div class="col-lg-9 col-8">
                      <h4>{{$network_count}}</h4>
                      <h5>Network Connections</h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-12">
                <div class="slr-counting">
                  <div class="row">
                    <div class="col-lg-3 col-4">
                      <div class="pro-countinf-ic"><img src="{{ URL::asset('assets/images/product-ct.png')}}"></div>
                    </div>
                    <div class="col-lg-9 col-8">
                      <h4>{{$product_count}}+</h4>
                      <h5>Products</h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  
		  
		  
		  
		  
		  
		  
		  
		  
          <div class="card">
           
            
            

          <input type="hidden" id="start_from" value="0">
            
            <div class="row">
              <div class="col-lg-12">
                <h3>Our products</h3> 
              </div>
            </div>

                 <div class="row">
              <div class="col-lg-6 col-12">
                
                <div class="form-group">
                    <select id="search_by_category" class="list-menu" onchange="fnbtnsearchproduct()">
                        <option value="0" >Select Category</option>
                        @if($parent_categorylists)
                            @foreach($parent_categorylists as $item)
                             <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        @endif 
                    </select>
                  </div>
        
                </div>
        <div class="col-lg-6 col-12">
                <div class="form-group srch-frm7 srchourproduct">
                  <input type="text" class="form-control" id="search_by_name" placeholder="Product Name" > 
                  <i class="fa fa-search" aria-hidden="true" onclick="fnbtnsearchproduct()"></i>
                </div>
                
              </div>
        </div>
        <div class="row " id="product-listing"></div>
           
         


        </div>
      </div>
    </div>
  </div>
  </div>

  <div class="modal fade" id="Mymodal" tabindex="-1" aria-labelledby="MymodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="MymodalLabel">Request for Account Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="fnclosepopup1()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
     <div class="form-group">
          <label>Reason:</label>
          <br>
          <textarea id="reason_delete" class="form-control" required></textarea> 
     </div>
          <button  type="submit"  class="bl-btn mar-10" onclick="fnsubmitdelete()">SUBMIT</button>
        
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
</sectiion>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{asset('/admin1/js/sweetalert.js')}}"></script>
<script src="{{ asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
     
     var $ = jQuery;
     (function($) {
        $(document).ready( function ($) {
            $('#search_by_category').select2();

            $("#search_by_name").keydown(function (event) { 
                 if (event.which == 13) { 
                     event.preventDefault();
                     fnbtnsearchproduct();
                 }
            });
           loadproductss();
        });
      })(jQuery);

function fnbtnsearchproduct(){
    $('#start_from').val(0);
    $("#product-listing").empty();
    loadproductss();
}

function loadproductss(){

  <?php if(!empty(request()->route('profId'))) 
	   $user_id= request()->route('profId') ; 
  else $user_id= Auth::guard('user')->user()->id; 
  
  ?>


var user_id = <?php echo $user_id; ?>; 
jQuery.ajax({ 
                            type : 'post',
                            url:"{{route('loadproducts')}}",
                            data:{
                              _token:'{{ csrf_token() }}',
                              'user_id':user_id,
                              'category_id': $('#search_by_category').val(),
                              'search_bykeyword':$('#search_by_name').val(),
                              'start_from':$('#start_from').val(),
                              'per_page':12
                            },
                           

                            success:function(data)
                            {
                                  
                                   let dataItems = JSON.parse(data);
                                   console.log();
                                   var initial=0;
                                   var string ='';
                                   dataItems.loadProducts.map((item) => {
                                    initial++;
                                    var app_path="<?php echo url('seller-product-detail/')?>";
                                string+='<div class="col-lg-3 col-12 wow fadeInUp">';
                                string+='<a  href='+app_path+'/'+item.prd_id+' >';
                                string+='<div class="product-thumbnail hovereffect">';
                                string+='<div class="pro-img"><img src="'+item.prd_img+'"></div>';
                                string+='<div class="product-title">';
                                string+='<h3>'+item.name+'</h3></div></div></a></div>';
								                
                                })
                                $("#product-listing").append(string);
                                   var skipcount=parseInt($("#start_from").val())+ initial ;
                                   if(dataItems.count!=skipcount)
                                      $("#product-listing").append('<div class="row"><div class="default-btn" style="width:15%;margin:15px auto;" id="loadmore" onclick="loadmore()">Load More</div></div>');

                               
                                  $("#start_from").val(skipcount);
         
                                   
                            }


                      });

}


function loadmore(){
  $("#loadmore").remove();
  loadproductss();
}


function fnclosepopup1(){
    $("#Mymodal").modal('hide');
}

function fnsubmitdelete(){

  $.ajax({
            url: "{{ url('profile_account_delete') }}",
               type: "get",
               data:{ 
                   _token:'{{ csrf_token() }}',
                   user_id: '<?=$user->id?>',
                   reason:$("#reason_delete").val() ,
               },
               async:true,
               cache: false,
               dataType: 'json',
               success: function(){ 
                $("#Mymodal").modal('hide');
                 swal("Request for removing your account successfully placed. Our admin will remove it very soon", "", "success");
                 //location.reload();
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
               swal(errorThrown, "", "failure");
             }  
   
           })  ;

}
function deleteProfileaccount(userid){

  $("#reason_delete").val('');
  swal({
    title:"Do you really want to delete? " ,
    text: "",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      
         $('#Mymodal').modal('show');

    } 
    else {
          
        }
    });  
}


  function addtonetwork(userid)
   {
    $.ajax({
            url: "{{ url('profile_to_network') }}",
               type: "get",
               data:{ 
                   user_id: userid,
               },
               async:true,
               cache: false,
               dataType: 'json',
               success: function(data){ 
                 swal(data, "", "success");
                 location.reload();
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
               swal(errorThrown, "", "failure");
             }  
   
           })  ;
  }
</script>


@endsection
@section('footer_script')


@endsection