<link rel="stylesheet" href="{{ asset('/css/select2.min.css')}}">
@extends('layouts.template')
@section('title', 'My Network')
@section('content')



<sectiion class="seller-page no-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="pr-bottom">


     <div class="card srch-seller serch-seller-sec3 networks-search ">
           <h3>Expand Your Networks </h3>
            <div class="row">
              <div class="col-lg-4 col-12">
                
        <div class="form-group">
                    <select id="search_by_category" class="list-menu" onchange="fnbtnsearchseller()">
                                        <option value="0">Select Category</option>
                                        @if($allcategorylists)
                                            @foreach($allcategorylists as $item)
                                             <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        @endif
                    </select>
                  </div>
        
        </div>
        
        <div class="col-lg-4 col-12">
                
        <div class="form-group">
                    <select id="search_by_company_type" class="list-menu" onchange="fnbtnsearchseller()">
                                        <option value="0">Select Company Type</option>
                                        
                                            @foreach($CompanyType as $item)
                                             <option value="{{$item->id}}">{{$item->company_type}}</option>
                                            @endforeach
                                       
                    </select>
                  </div>
        
        </div>
        
        <div class="col-lg-4 col-12">
                <div class="form-group srch-frm7">
                  <input type="text" class="form-control" id="search_by_name" placeholder="Search by Name or Company"> 
                    <input type="hidden" id="start_from" value="0"> 
                   <button type="button" onclick="fnbtnsearchseller()"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
                
              </div>
        </div>
            <div class="row seller-result">
              <div class="col-lg-12 col-12">
                <div class="row" id="sellers_list"  ></div>
                <div class="default-btn load-btn" style="display: none;" id="loadmore" onclick="loadmore()">Load More...</div> 
              </div>
            </div>
          </div>      




     <div class="card m-cts1">
           <h3>My Contacts</h3>
           <div class="row">
          <div class="col-lg-4 col-12">
                
        <div class="form-group">
                    <select id="search_by_category1" class="list-menu" onchange="fnbtnsearchnetwork()">
                                        <option value="0">Select Category</option>
                                        @if($allcategorylists)
                                            @foreach($allcategorylists as $item)
                                             <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        @endif
                    </select>
                  </div>
        
        </div>   
        
        <div class="col-lg-4 col-12">
                
        <div class="form-group">
                    <select id="search_by_company_type1" class="list-menu" onchange="fnbtnsearchnetwork()">
                                        <option value="0">Select Company Type</option>
                                        
                                            @foreach($CompanyType as $item)
                                             <option value="{{$item->id}}">{{$item->company_type}}</option>
                                            @endforeach
                                       
                    </select>
                  </div>
        
        </div>
        
        <div class="col-lg-4 col-12">
                <div class="form-group srch-frm7">
                  <input type="text" class="form-control" id="search_by_name1" placeholder="Search by Name or Company"> 
                    <input type="hidden" id="start_from1" value="0"> 
                   <button type="button" onclick="fnbtnsearchnetwork()"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
                
              </div>
        </div>
           <div class="row" id="network_list"></div>
            <div class="default-btn load-btn" style="display: none;width:16%" id="loadmore1" onclick="loadmore1()">Load More...</div>
        </div>


    
    
        </div>
      </div>
    </div>
  </div>
  
  

</sectiion>
<script src="{{asset('/admin1/js/sweetalert.js')}}"></script>
<script src="{{asset('/admin1/js/jquery.min.js')}}"></script>
<!--<link rel="stylesheet" href="{{ asset('/css/select2.min.css')}}">-->
<script src="{{ asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
//fnbtnsearchseller();
getnetworkList();
 $('#search_by_category,#search_by_company_type,#search_by_category1,#search_by_company_type1').select2();
function loadmore(){
     fnloadsellers();
}
function loadmore1(){
     getnetworkList();
}
 $("#search_by_name").keydown(function (event) { 
     if (event.which == 13) { 
         event.preventDefault();
         fnbtnsearchseller();
     }
    });
 $("#search_by_name1").keydown(function (event) { 
     if (event.which == 13) { 
         event.preventDefault();
         fnbtnsearchnetwork();
     }
    });   
    
 function fnmovetoprofile(userid)
{
  window.location="{{route('ViewSeller.profile', ':id')}}".replace(':id', '')+userid;
}   

 function addtonetwork(userid)
   {
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
                 swal(data, "", "success");
                 $(".clsa"+userid).remove();
                 $(".clschat"+userid).show();
                 $('#start_from1').val(0);
                 $("#network_list").empty();
                 getnetworkList();
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
               swal(errorThrown, "", "failure");
             }  
   
           })  ;
  }

function fnbtnsearchseller(){
     $('#start_from').val(0);
     $("#sellers_list").empty();
     fnloadsellers();
}

function fnbtnsearchnetwork(){
     $('#start_from1').val(0);
     $("#network_list").empty();
     getnetworkList();
}


function fnloadsellers(){


    $.ajax({
                          type:'POST',
                          url:'{{ route("getsellerslist_search") }}',
                          async:false,
                            cache: false,
                          data:{
                                '_token':'{{csrf_token()}}',
                                'seller_name':$('#search_by_name').val(),
                                'category_id':$('#search_by_category').val(),
                                'company_type':$('#search_by_company_type').val(),
                                'start_from':$('#start_from').val(),
                                'per_page':9
                          },
                          success:function(response){ 
  
  
                            let dataItems = JSON.parse(response);
                                    var initial=0;
                                     dataItems.sellers.map((item) => {
                                      initial++;


                     var string='<div class="col-lg-4 col-12"><div class=" slr-details nw-proC"><div class="row"><div class="col-lg-3"><div class="pro-logo-out"><div class="nw-prof-img '+item.class_verified+'">';
					 string+='<img src="'+item.img_path+'" onclick="fnmovetoprofile('+item.id+')" style="cursor: pointer;"></div>';
					 if(item.varification_status=='varified')
					  {
                      string+='<div class="active-tick"><i class="fa fa-check" aria-hidden="true"></i></div> ';							  
					  }
					  string+='</div></div><div class="col-lg-9 col-12"><ul><li onclick="fnmovetoprofile('+item.id+')" style="cursor: pointer;" class="nm"><b>'+item.name+'</b></li><li class="comp-nm">'+item.company_name+'</li><li class="loca">'+item.company_street+'</li><li>'+item.company_location+'</li></ul>';

                          if(item.network_exist==false)
                            string+='<a href="javascript:void(0)" onclick="addtonetwork('+item.id+')" class="cht-ico add-nt clsa'+item.id+'"><i class="fa fa-plus-square-o" aria-hidden="true"></i>Add to network</a>';
                          
                          else
                             string+='<a href="javascript:void(0)"  id="expandnetwork'+item.id+'" onclick="removefromnetwork('+item.id+')" class="cht-ico add-nt rmv"><i class="fa fa-trash-o" aria-hidden="true"></i>Remove from network</a>';
                           
                    
                     string+='<a href="javascript:void(0)" class="cht-ico" onclick="EnableChatRequest('+item.id+')" ><i class="fa fa-comments" aria-hidden="true"></i>Start chat</a>';
                    string+='</div></div></div></div></div>';
                    $("#sellers_list").append(string);


                                  })
                                 
  
                                  var skipcount=parseInt($("#start_from").val())+ initial ;
                                  if(dataItems.count!=skipcount)
                                        $("#loadmore").show();
                                  else
                                        $("#loadmore").hide();
  
                                 if ($("#sellers_list").find('div').length == 0)  
                                       $("#sellers_list").append("<p style='text-align:center;font-size:16px;margin-top:40px;margin-bottom:40px;'><b>No Profile's Found</b></p>"); 
  
                                  if(dataItems.sellers.length==0)
                                        $("#loadmore").hide();
  
                                  $("#start_from").val(skipcount);
  
                          }
                      });
  
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


function getnetworkList(){
  $.ajax({
            url: "{{ url('getnetwork_users_list') }}",
               type: "Post",
               async:true,
               cache: false,
               data:{
                                '_token':'{{csrf_token()}}',
                                'seller_name':$('#search_by_name1').val(),
                                'category_id':$('#search_by_category1').val(),
                                'company_type':$('#search_by_company_type1').val(),
                                'start_from':$('#start_from1').val(),
                                'per_page':9
                          },
               dataType: 'json',
               success: function(response){
                   
                  

                                    var initial=0;
                  response.mynetwork_list.map((item) => {
                                    initial++;
                      var string='<div class="col-lg-4 col-12" id="div_mynetwork'+item.id+'"><div class=" slr-details nw-proC " id ="'+item.id+'"><div class="row"><div class="col-lg-3"><div class="pro-logo-out"><div class="nw-prof-img '+item.class_verified+'">';
					  string+='<img src="'+item.img_path+'" onclick="fnmovetoprofile('+item.id+')" style="cursor: pointer;"></div>';
                      if(item.varification_status=='varified')
					       string+='<div class="active-tick"><i class="fa fa-check" aria-hidden="true"></i></div> ';							  
					  string+='</div></div><div class="col-lg-9"><ul><li onclick="fnmovetoprofile('+item.id+')" style="cursor: pointer;" class="nm">'+item.name+'</li><li  class="comp-nm"> <b>'+item.company_name+'</b> </li><li  class="loca">'+item.company_street+'<br>'+item.company_location+'</li> </ul><a href="javascript:void(0)" onclick="removefromnetwork('+item.id+')" class="rmv"><i class="fa fa-trash-o" aria-hidden="true"></i>Remove from network</a><a href="javascript:void(0)" class="cht-ico" onclick="EnableChatRequest('+item.id+')" ><i class="fa fa-comments" aria-hidden="true"></i>Start chat</a></div></div></div></div> ';
                      $("#network_list").append(string);
                  });   

                   var skipcount=parseInt($("#start_from1").val())+ initial ;
                                  if(response.count!=skipcount)
                                        $("#loadmore1").show();
                                  else
                                        $("#loadmore1").hide();
  
                                 if ($("#network_list").find('div').length == 0)  
                                       $("#network_list").append("<p style='text-align:center;font-size:16px;margin-top:40px;margin-bottom:40px;'><b>No Contact's Found</b></p>"); 
  
                                  if(response.mynetwork_list.length==0)
                                        $("#loadmore1").hide();
  
                                  $("#start_from1").val(skipcount);               
                    
                               
             } ,

             error: function(XMLHttpRequest, textStatus, errorThrown) { 
               swal(errorThrown, "", "failure");
             }  
   
           })  ;
}

  function removefromnetwork(userid)
   {
    $.ajax({
            url: "{{ url('revokeFrom_network') }}",
               type: "get",
               data:{ 
                   user_id: userid,
               },
               async:true,
               cache: false,
               dataType: 'json',
               success: function(data){
                 swal(data, "", "success");
                 $("#div_mynetwork"+userid).remove(); 
                 $("#expandnetwork"+userid).remove(); 
                 $("#home"+userid).remove();
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
               swal(errorThrown, "", "failure");
             }  
   
           })  ;
  }
</script>


  <style>
 
.add-nt{margin-right:4px;}
    .srch-seller .slr-details{ margin-top:0px;}
    .add-nt{ float:right;}
          
         .serch-seller-sec3 .nw-proC{ border-bottom:2px solid #edeaea;}
         .serch-seller-sec3 .nw-prof-img {
                overflow: hidden;
                border-radius: 50%;
                border: 2px solid #fff;
            }
          .serch-seller-sec3 .add-ntw{  padding:5px 10px; text-transform:uppercase; float:left; color:#fff; border-radius:4px; background:#0d6efd; border-bottom:2px solid #0561e9;}
          .add-ntw:hover{ background:#333; color:#FFFFFF;border-bottom:2px solid #333;}
          .chat-btn9{ color:#0d6efd; margin-left:10px; font-size:25px; margin-top:-4px; float:left;}
          .net-wrk-btn{ margin-top:17px; float:right;}
          .sr-listing8{ margin-bottom:10px;}
          
          .chat-btn9:hover{ color:#333;}
          
          .srch-frm7{ position:relative;}
          .srch-frm7 button{ background:none!important; padding:10px; position:absolute; right:10px; color:#000000; top:0; margin:0px 0px;}
          .seller-result{ margin-top:20px;}
          
          </style>


@endsection
