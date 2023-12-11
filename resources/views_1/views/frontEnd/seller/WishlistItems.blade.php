@extends('layouts.template')
@section('title')
FMCG | Wishlist Items
@endsection
@section('content')
<sectiion class="seller-page no-bg">
  <div class="container buyer-dtl55">
    <div class="row">
      <div class="col-lg-12">
        <div class="pr-bottom">
          <div class="card">
            <div class="slr-details buyer-dtl bft">
              <div class="row">
                <div class="col-lg-12 col-12">
                
                <div class="h3-titile">
                  <h4>Favourites</h4>
                  <div class="buyer-filt">
   <form method="post" action="{{ route('WishlistItemsFilter')}}" > @csrf
    <select id="inputState" class="form-select"  onchange="this.form.submit()" name="wish_filter">
	<option value="" >All</option>
      <option value="Active" @if(request()->wish_filter=="Active") selected @endif >Active</option>
      <option value="Expired" @if(request()->wish_filter=="Expired") selected @endif >Expired</option>
    </select>
  </div>
  </form>
                  
                  
                  
                  </div>
      
                  
                  <div class="row">
                  @if(is_null($products))
                  <p style="color:#ff0000;text-align:center;font-weight:bold;font-size:15px;padding-top:30px;"> Empty Wishlist</p>
  @endif                

   @if(!empty($products))
   @foreach($products as $product)               
  
                    <div class="col-lg-6 col-12">
                      <div class="favorit-C">
                        <div class="row">
                          <div class="col-lg-3 col-12">
						  <?php 
             $image=$product->sellerproductimage;
              $image_path='/images/no-image.jpg';
            foreach( $image as $data)
            {
              if($data->thumbnail=='yes')
                $image_path='/uploads/productImages/'.$data->image_path;
            }

             ?>
                            <div class="fav-pro"><img src="{{URL::asset($image_path)}}"></div>
                          </div>
                          <div class="col-lg-9 col-12">
                           <a href="{{ route('view.Sproduct',$product->id)}}" class="title"> <h2>{{ ucfirst($product->name) ?? ""}} </h2></a>
                           
							 
					@if(!empty($product->product_expiry))
                     <?php 
				      $Enddate =  $product->product_expiry;
                      $Enddate =  Carbon::createFromFormat('Y-m-d', $Enddate); ?>
                      <?php if($Enddate->isPast()) { ?> <h6 class="rd" style="display:block;clear:both;">EXPIRED!</h6> <?php } ?>
                    @endif
                            <div class="btn-blck">
							@if(Auth::guard('user')->user()->id != $product->User->id )
                              <button  href="javascript:void(0)" onclick="EnableChatRequest({{$product->User->id }})" data-bs-target="#exampleModal" type="button" class="btn btn-primary">Message</button>

@endif
                              <!-- <button type="button" class="btn btn-primary expired-btn">Expired</button> -->
 <button href="javascript:void(0)" onclick="RemoveWishlist({{ $product->id }})" type="button" id="remove_<?=$product->id?>" >Remove</button> 

<button   style="display:none;" href="javascript:void(0)"  id="add_<?=$product->id?>" onclick="addToWishlist({{ $product->id }})" type="button" >Add</button> 


                            </div>
                          </div>
                        </div>
                      </div>
                    </div>



  @endforeach
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
</sectiion>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">

function EnableChatRequest(seller_id){
        $(".message-input").css("display", "block");
        $("#frame").css("display", "block");
        $(".content").css("display", "block");
        $("#frame").css("width", "95%");
       
                 $("#selected_id").val(seller_id);
                 loadMessage();
                  $("#frame").show();
                  senter = seller_id;
           
        
}
    </script>

	<script type="text/javascript">

var wish_count = <?=$view_composer_wishCount?>;

        function addToWishlist(id = null){
            
                if(id != null){ 
                    $.ajax({
                        type:'GET',
                        url:'{{ route("addToWishlist") }}',
                        data:{id: id, '_token':'{{csrf_token()}}'},
                        success:function(response){ 
						 $('#remove_'+id).show();
						 $('#add_'+id).hide();
                         
						 wish_count = wish_count+1;
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

<script type="text/javascript">
        function RemoveWishlist(id = null){   
            
                if(id != null){
                    $.ajax({
                        type:'GET',
                        url:'{{ route("RemoveWishlist") }}',
                        data:{id: id, '_token':'{{csrf_token()}}'},
                        success:function(response){ 
						  $('#remove_'+id).hide();
						  $('#add_'+id).show();
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



@endsection
