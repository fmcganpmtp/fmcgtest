@extends('layouts.template')
<?php  $usertype = Auth::guard('user')->user()->usertype;  ?>
@if($usertype=='seller')
@section('title', 'List Co-Sellers')
@else
@section('title', 'List Co-Buyers')
@endif
@section('content')

<sectiion class="seller-page1 seller-page-2 cc-sel">
  <div class="pr-banner">
    <!--<img src="assets/images/pr-banner.jpg">-->
  </div>
  
  

<!-- Modal -->
<div class="modal fade" id="exampleModa5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
        <?php if($usertype=="buyer") echo "Create co-buyer profile";
            else   echo "Create co-seller profile"; ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body ">
      
      
      
<div class="card seller-page co-seller-pop">
       
            <div class="row">
             
              <div class="col-lg-3 col-12">
                <div class="pr-logo"><img src="{{asset('/uploads/defaultImages/images_not_avaailable.png')}}" class="prof_img" > <a href="javascript: void(0)" id="upload_image" class="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> </div>

              </div>
              
              <div class="col-lg-9 col-12"> 
               <form action="{{route('add.addCoSeller')}}" method="Post" enctype="multipart/form-data"> 
               @csrf           
                <div class="row">
                   <input type="file" id="imgupload" class="image" name="imgupload" accept=".jfif,.jpg,.jpeg,.png,.gif" style="display:none"/> 
                  <div class="col-lg-4 col-12">
                    <div class="form-group">
                      <label> Name</label>
                      <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" required value="{{ old('name') }}" >
                       @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                    </div>
                  </div>
                  <div class="col-lg-4 col-12">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required value="{{ old('email') }}">
                       @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                    </div>
                  </div>
                  <div class="col-lg-4 col-12">
                    <div class="form-group">
                      <label>Phone</label>
                      <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="full"  required maxlength="15" value="{{ old('phone') }}">

                        <span  role="alert">
                                 @if($errors->has('phone'))
                                   <div class="error" style="font-size: .875em; color: #dc3545;">{{ $errors->first('phone') }}</div>
                                   @endif
                        </span>
                     
                    </div>
                  </div>
                  <div class="col-lg-4 col-12">
                    <div class="form-group">
                      <label>User name</label>
                      <input type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" required value="{{ old('username') }}">
                       @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                    </div>
                  </div>
                  <div class="col-lg-4 col-12">
                    <div class="form-group">
                      <label>Password</label>
                     
                      <input  autocomplete="off" id="password_c"  type="password" class="pr-password  form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required value="{{ old('password') }}">
                       @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                       @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                    </div>
                  </div>

                  <div class="col-lg-4 col-12">
                    <div class="form-group">
                      <label> Confirm Password</label>
                      <input  autocomplete="off" type="password" id="password-confirm" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation"  value="{{ old('password_confirmation') }}">
                       @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn-right">submit</button>   
                </form>  
              </div>
             
            </div>
           
          </div>      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

  
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="pr-bottom">
          <div class="card">
            
            @if($usertype=="buyer") 
                    <h3>Manage Co-buyers</h3>
            @else  
                    <h3>Manage Co-sellers </h3>
            @endif

             <div class="co-sell-right"><span>Profiles Available :{{$noofacnt}}</span> <span>Profiles Remaining : {{($noofacnt-count($user))}}</span> </div>
            
           <?php  

            
           if(($view_composer_co_users_criteria == true) && $view_composer_co_users_criteria['no_of_package']>count($user) && Auth::guard('user')->user()->seller_type=='Master'){?> 
            <div class="row">
            <div class="col-lg-12">
            <a  class="btn btn-outline-info ad-n-co" data-bs-toggle="modal" data-bs-target="#exampleModa5"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
           <?php if($usertype=="buyer") echo "Add new co-buyer";
            else   echo "Add new co-seller"; ?>
            </a>
            </div></div>
          <?php }?>
            <div class="tableC subcrib-dt co-sell-table  ">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th>Username</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($user as $data)
                  <tr>
                    <td><div class="co-sl st"><img src="{{$data->profile_pic ? asset('uploads/userImages/').'/'.$data->profile_pic : asset('/uploads/defaultImages/images_not_avaailable.png')}}"></div><h5>{{$data->name}}</h5></td>
                    <td>{{$data->email}} </td>
                    <td>{{$data->phone}}</td>
                    <td>{{$data->username}}</td>
                    <td>
                    @if(Auth::guard('user')->user()->seller_type=='Master')
                    <div class="float-end">
                    @if($data->status!="Active")  
                    <button type="button" title="Activate This Profile" onclick="fnstatusupdator({{$data->id}},'Active')" class="btn btn-outline-success"> <i class="fa fa-check" aria-hidden="true"></i>Active</button>
                    @endif
                    @if($data->status!="Blocked") 
                    <button type="button" title="Block This Profile" onclick="fnstatusupdator({{$data->id}},'Blocked')" class="btn btn-outline-warning"><i class="fa fa-ban" aria-hidden="true"></i>Block</button>
                    @endif
                    <form action="JavaScript:void(0);" onclick="deleteconfirm({{$data->id}})" method="get" style="display:inline;">
                    <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash-o" aria-hidden="true"></i>Remove</button>
                    </form></div>
                    @endif
                    </td>
                    
                  </tr>
                  
                  @endforeach
                </tbody>
              </table>
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
<script src="{{asset('/admin1/js/sweetalert.js')}}"></script>
<link rel="stylesheet" href="{{ asset('/css/intlTelInput.css')}}">
<script src="{{ asset('js/intlTelInput.min.js')}}"></script>               
<link rel="stylesheet" href="{{ asset('/css/jquery.passwordRequirements.css')}}">
<script src="{{ asset('js/jquery.passwordRequirements.js')}}"></script>
<script src="{{ asset('js/jquery.passwordRequirements.min.js')}}"></script>
<script>
        /* trigger when page is ready */
        var $ = jQuery;
                (function($) {
                    
                 $( "#password_c" ).focus(function() {
                      $(".pr-password").passwordRequirements({

});
 
});   
                    
                    
                    
                    
        
      })(jQuery);


        
    </script>
<script>
  var input = window.intlTelInput(document.querySelector("#phone"), {
  separateDialCode: true,
  preferredCountries:["nl"],
  hiddenInput: "phone",
  utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
});

$('document').ready(function() {
  var errorcount='<?php echo count($errors);?>';
    if(errorcount>0)
    $('#exampleModa5').modal('show');
});
   

(function(jQuery) {
    jQuery(document).ready( function () {

      jQuery('#upload_image').click(function(){  
            jQuery('#imgupload').trigger('click'); 
      });
      
      
jQuery('#register').on( "click", function() {
var full_number = input.getNumber(intlTelInputUtils.numberFormat.E164);
$("input[name='phone[full]'").val(full_number);

});


$(".image").change(function(e) {  
var data = new FormData();
data.append('image', $('input[type=file]')[0].files[0]);
data.append('_token', "{{ csrf_token() }}"); 
$.ajax({
        url:'{{route('update-image')}}',
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
        error: function() {
          //  alert('Upload Failed');
        }
       });   
    });


});
})(jQuery);

function fnstatusupdator(id,type){
  var msg="";
  if(type=="Blocked")
    msg="Are you Sure you want to Block this profile?";
  else
    msg="Are you Sure you want to Activate this profile?";

    swal({
        title: msg,
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
         url: "{{ url('usersellersstatusupdates') }}",
            type: "post",
            data:{ 
                _token:'{{ csrf_token() }}',
                  id: id,
                  status: type,
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
        } else {
          
        }
      });  

  
}

function deleteconfirm(data){
  var id=data;
  var deleteurl="{{route('delete-coceller.user',':id')}}".replace(':id', '')+data;

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
</script>
@endsection

