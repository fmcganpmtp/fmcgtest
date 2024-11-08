@extends('admin.master')
@section('title', 'Users List')
@section('breadcrumb') Users List @endsection
@section('content')
<div class="body flex-grow-1 px-3">
   <div class="container-lg">
      <div class="card-out mb-4 inner-form">
         @if(Session::has('message')) 
         <div class="alert alert-success">{{Session::get('message') }}</div>
         @endif
         <h2>Users List</h2>
         <div class="card-body">
            <div class="row">
               <div class="col-lg-12 col-12">
                  <div class="card ">
                     <div class="card-header">
                        <form action="{{route('admin.sellerslist')}}" method="GET" name="users_list" id="usr_lists">
                           <div class="row">
                              <div class="col-lg-3 col-12">
                                 <div class="form-group">
                                    <select id="search_by_category" class="list-menu" onchange="fnbtnsearchseller()" name="category_id" >
                                       <option value="0">Select Category</option>
                                       @if($allcategorylists)
                                       @foreach($allcategorylists as $item)
                                       <option value="{{$item->id}}">{{$item->name}}</option>
                                       @endforeach
                                       @endif
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-2 col-12">
                                 <div class="form-group">
<select  type="text"  placeholder="Select Company Type" name="company_type[]" id='company_type' class="form-control" multiple  >
                                       @if($CompanyType)
                                       @foreach($CompanyType as $item)
                                       <option value="{{$item->id}}">{{$item->company_type}}</option>
                                       @endforeach
                                       @endif
                                    </select>
                                    <input type="hidden" id="selected_company_type">
                                 </div>
                              </div>
                              <div class="col-lg-3 col-12">
   <div class="form-group">
      <select type="text" placeholder="Available Countries" name="selected_country_id[]" id='available_countries' class="form-control" multiple="multiple">
         @if($countries)
         @foreach($countries as $item)
         <option value="{{$item->id}}">{{$item->name}}</option>
         @endforeach
         @endif
      </select>
      <input type="hidden" id="selected_country_id">
   </div>
</div>
                              <div class="col-lg-4 col-12">
                                 <div class="search-area wth-btn width_100">
                                    <div class="form-group">
                                       <input type="search" name="search_key" id="search_key"  placeholder="Search for keyword, Name, or Company" class="form-control">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-lg-2 col-12">
                                 <div class="form-group">
                                    <select name="sub_end_month" id="sub_end_month" class="form-control" >
                                       <option value="">Sub.End Month</option>
                                       <option value=1>Jan.</option>
                                       <option value=2>Feb.</option>
                                       <option value=3>Mar.</option>
                                       <option value=4>Apr.</option>
                                       <option value=5>May</option>
                                       <option value=6>June</option>
                                       <option value=7>July</option>
                                       <option value=8>Aug.</option>
                                       <option value=9>Sep.</option>
                                       <option value=10>Oct.</option>
                                       <option value=11>Nov.</option>
                                       <option value=12>Dec.</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-2 col-12">
                                 <div class="form-group">
                                    <select name="sub_type" id="sub_type" class="form-control" >
                                       <option value="">Sub.Type</option>
                                       <option value='free'>Free</option>
                                       <option value='paid'>Paid</option>
                                       <option value='both'>Both</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-2 col-12">
                                 <div class="form-group">
                                    <select name="status" id="status" class="form-control">
                                       <option value="">All</option>
                                       <option value="Blocked">Blocked</option>
                                       <option value="Active">Active</option>
                                       <option value="Pending">Pending</option>
                                       <option value="Rejected">Rejected</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-6 col-12">
                                 <button type="button" class="bl-btn pd01 " id="btnsearch"><i class="fa fa-search" aria-hidden="true"></i> Search</button> 
                                 <div class="flt-right">
                                    <button type="submit" name="filter" value="Excel" class="bl-btn flt-right1 pd01"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel export</button> 
                                    <a href="{{route('sellerprofile.create')}}" class="bl-btn flt-right1  left-10 pd01"> <i class="fa fa-pencil" aria-hidden="true"></i> Create</a>
                                 </div>
                              </div>
                           </div>
                     </div>
                     </form>
                     <div class="card-body">
                        <div class="tableC ad-rl-list">
                           <table id="datatable" class="table  table-bordered" data-page-length='20' cellspacing="0" width="100%">
                              <thead>
                                 <tr>
                                    <th></th>
                                    <th>Sl no</th>
                                    <th>Company name</th>
                                    <th>Company Types</th>
                                    <th>Name</th>
                                    <th>Last Name</th>
                                    <th>Job Title</th>
                                    <th>Mail Address Employee</th>
                                    <th>Phone</th>
                                    <th>Company Email</th>
                                    <th>Country</th>
                                    <th>Location(City)</th>
                                    <th>Active Product Categories</th>
                                    <th>Package</th> 
                                    <th>Subscription Start</th>
                                    <th>Subscription End</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="Mymodal" tabindex="-1" aria-labelledby="MymodalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="MymodalLabel">Assign Package</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="fnclosepopup1()">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <input type="hidden" id="hdnuser_id">
               <label>Package Name:</label>
               <br>
               <select class="form-control" id="package_list">
                  <option></option>
               </select>
               <div id="package_details"></div>
               <div id="package_sub_item">
                  <label>Choose No of Profiles: </label>
                  <select class="form-control" id="subitem" required="">
                     <option></option>
                  </select>
               </div>
            </div>
            <button  type="submit" onclick="adminassignpackage()" class="bl-btn mar-10">SUBMIT</button>
         </div>
         <div class="modal-footer">
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="Mymodal1" tabindex="-1" aria-labelledby="MymodalLabel1" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="MymodalLabel1">Reset Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="fnclosepopup2()">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <input type="hidden" id="hdnuser_id">
               <label>  Password:</label>
               <br>
               <input type="password" class="form-control" minlength="8" id="Password">
               <span style="color:red;font-size:10px;">**Minimun 8 Charcters</span> 
               <div id="package_details"></div>
               <div id="package_sub_item">
                  <label> Confirm Password : </label>
                  <input type="password" class="form-control" minlength="8" id="confirm_Password">
                  <span style="color:red;font-size:10px;display:none" id="spanmismatch">Password Mismatch!!</span>
               </div>
            </div>
            <button  type="submit" onclick="fnassignnewpassword()" class="bl-btn mar-10">SUBMIT</button>
         </div>
         <div class="modal-footer">
         </div>
      </div>
   </div>
</div>

<script src="{{asset('/admin1/js/datatable.js')}}"></script>
<script src="{{asset('/admin1/js/sweetalert.js')}}"></script>
<link rel="stylesheet" href="{{ asset('/css/select2.min.css')}}">
<script src="{{ asset('js/select2.min.js')}}"></script>
<script>
   var $ = jQuery;
     (function($) {
     $(document).ready( function () {
   //alert($("#company_type").val());
       $("#package_sub_item").hide();
       $("#package_list").change(function(){
        $(".loaderajax").show();
         $.ajax({
            url: "{{ url('getpackageselected_details') }}",
               type: "post",
               data:{ _token:'{{ csrf_token() }}',id:$(this).val() },
               async:false,
               cache: false,
               dataType: 'json',
               success: function(data){
                    $(".loaderajax").hide();
                       var string="";
                       $("#package_sub_item").hide();
                       $("#package_details").empty();
                       if(data.details!=null)
                       { 
                         string+="<br>Basic Price: $"+data.details.package_basic_price +" <br> Offer Price: $"+ data.details.package_offer_price +" <br>Description: "+data.details.package_description+" <br>Validity: "+data.details.package_validity +" <br><br>";
                         $("#package_details").empty().append(string);
                      
                         var extendpack="";
                         var discount=0;
                                        
                         data.PackageAccount.map((item) => {
                               $("#package_sub_item").show();
                               discount=parseInt(((item.cost_per_account - item.per_account_offer_price)/item.cost_per_account)*100);
                               extendpack+='<option value='+item.id+'>'+item.no_of_accounts+' Profiles, '+discount+' % off $'+item.per_account_offer_price+'/ Account</option>';
                                          });
                         $("#subitem").empty().append(extendpack);}
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
                  $(".loaderajax").hide();
               swal(errorThrown, "", "error");
             }  
   
           })  ;
   
       })
      
       var id = '12';
   	   var viewurl="{{route('seller.profileview', ':id')}}";
       var editurl="{{route('seller.profileview', ':id')}}";
       var deleteurl="{{route('seller.profileview', ':id')}}";
       var sellerproductcreateurl="{{route('admin.sellerproduct_create', ':id')}}";
      
       var Blocked="'Blocked'";
       var Active="'Active'";
       var str='';
       $('#btnsearch').click(function(){
       dataTable.draw();
       });
          $("#company_type").select2({
      placeholder: 'Select Company Type',}
      ).on("change", function (e) {
    
            dataTable.draw();
    });

    $('#available_countries').select2({
     placeholder: 'Select Available Countries',}
     ).on("change", function (e) {
     dataTable.draw();
  });

 $('#sub_type').on("change", function (e) {
     dataTable.draw();
  }); 
  
   $('#status').on("change", function (e) {
     dataTable.draw();
  });
 $('#sub_end_month').on("change", function (e) {
     dataTable.draw();
  });
   $('#search_by_category').select2().on("change", function (e) {
     dataTable.draw();
  });
       $("#search_key").keydown(function (event) { 
        if (event.which == 13) { 
            event.preventDefault();
            dataTable.draw();
        }
       });
       var dataTable=$('#datatable').DataTable({
           "processing": true,
           "language": {
           processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
           serverSide: true,
           'searching': false,
           "lengthChange": false, 
           'ajax': {
           'url':"{{ url('getsellerslist') }}",
           'data': function(data){
             _token="{{csrf_token()}}";
             data.search_key= $("#search_key").val();
             data.company_type= $("#company_type").val();
             data.category_id= $("#search_by_category").val();
             data.selected_country_id= $("#available_countries").val();
             data.sub_end_month= $("#sub_end_month").val();
             data.sub_type= $("#sub_type").val();
             data.status= $("#status").val();
          },
         
       },"columnDefs":[
       {
          "targets":0, 
          "orderable": true,
          "visible":false
         },
         {
          "targets":10, 
          "orderable": false,
          },
          {
          "targets":11, 
          "orderable": false,
          },
          {
          "targets":12, 
          "orderable": false,
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
          "targets":16, 
          "orderable": false,
          "render": function(data,type,full,meta)
         {
           viewurl = viewurl.replace(':id', '');
           editurl = editurl.replace(':id', '');
           deleteurl = deleteurl.replace(':id', '');
           sellerproductcreateurl = sellerproductcreateurl.replace(':id', '');
           
            str='<div class="icon-bx"><button type="button" title="Assign Package" onclick="fnassignpackage('+full.id+')" style="border: 0 none;"><i class="fa fa-usd" aria-hidden="true"></i></button><button type="button" title="Reset Password" onclick="fnresetpassword('+full.id+')" style="border: 0 none;"><i class="fa fa-key" aria-hidden="true"></i></button>'; 
            if(full.prdts_to_uplod=="Unlimited" || full.prdts_to_uplod>0)	
            str+='<a href="'+sellerproductcreateurl+full.id+'" title="Add Seller Products"><i class="fa fa-plus-square-o" aria-hidden="true"></i></a>';
            str+=' <a href="'+editurl+full.id+'"><i class="icon  cil-pencil"></i></a><a href="JavaScript:void(0);" onclick="deleteconfirm('+full.id+')"><i class="icon cil-trash"></i></a><a href="'+viewurl+full.id+'"><i class="fa fa-eye" aria-hidden="true"></i></a>';
           if(full.status!='Blocked')
           str+='<button type="button" title="Block This User" onclick="fnstatusupdator('+full.id+','+Blocked+')" style="border: 0 none;"><i class="fa fa-ban" aria-hidden="true"></i></button>';
           if(full.status!='Active')
           str+='<button type="button" title="Active This User" onclick="fnstatusupdator('+full.id+','+Active+')" style="border: 0 none;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></button>';
           str+='</div>';
            
           return str;
         }
       }
     ],
            columns: [
             { data: 'id' },
             { data: 'id' },
             { data: 'company_name' } ,
             { data: 'c_types' }, 
             { data: 'name' },
             { data: 'surname' },  
             { data: 'position' },
             { data: 'email' } ,
             { data: 'phone' } ,
             { data: 'company_email' } ,
             { data: 'country_name' },
             { data: 'address' }, 
             { data: 'categories' },
             { data: 'pkg_name' }, 
             { data: 'subscription_start' },  
             { data: 'subscription' },             
             
             
             
            ]
         });
   
     
        
     });
   })(jQuery);
   
   function fnassignnewpassword(){
     var confirm_Password=$("#confirm_Password").val();
     var Password=$("#Password").val();
     if(confirm_Password!=Password && Password!='')
       $("#spanmismatch").show();
     else
       $("#spanmismatch").hide();
     if(confirm_Password==Password && Password!='' && Password.length>=8){
   
          swal({
           title: "Are you Sure, you want to Reset Password to this profile?",
           text: "",
           icon: "warning",
           buttons: true,
           dangerMode: true,
         })
         .then((willDelete) => {
           if (willDelete) {
                $(".loaderajax").show();
             $.ajax({
              url: "{{ url('adminresetpassword') }}",
               type: "post",
               data:{ 
                   _token:'{{ csrf_token() }}',
                     hdnuser_id: $("#hdnuser_id").val(),
                     Password: $("#Password").val(),
                    },
               async:true,
               cache: false,
               dataType: 'json',
               success: function(data){
                    $(".loaderajax").hide();
                 swal(data, "", "success");
                 $('#Mymodal1').modal('hide');
                  $("#confirm_Password").val('');
               $("#Password").val('');
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
                  $(".loaderajax").hide();
                   swal("Error", "", "error");
                    $("#confirm_Password").val('');
                   $("#Password").val('');
             }  
   
           })  ;
           } else {
             
           }
         });  
   
     }
    }
   
   function fnresetpassword(user_id){
     $("#confirm_Password").val('');
     $("#Password").val('');
     $('#Mymodal1').modal('show');
     $("#hdnuser_id").val(user_id);
    }
   
    function fnclosepopup2(){
       $("#confirm_Password").val('');
       $("#Password").val('');
       $("#Mymodal1").modal('hide');
   }
   function adminassignpackage(){
     var package_list=$("#package_list").val();
     if(package_list!=""){
   
          swal({
           title: "Are you Sure, you want to assign Package to this profile?",
           text: "",
           icon: "warning",
           buttons: true,
           dangerMode: true,
         })
         .then((willDelete) => {
           if (willDelete) {
                $(".loaderajax").show();
             $.ajax({
              url: "{{ url('adminassignpackagetoadmin') }}",
               type: "post",
               data:{ 
                   _token:'{{ csrf_token() }}',
                     hdnuser_id: $("#hdnuser_id").val(),
                     package_id: $("#package_list").val(),
                     subitem: $("#subitem").val()
               },
               async:true,
               cache: false,
               dataType: 'json',
               success: function(data){
                    $(".loaderajax").hide();
                 swal(data, "", "success");
                 $('#Mymodal').modal('hide');
                  location.reload();
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
                  $(".loaderajax").hide();
               swal(errorThrown, "", "error");
             }  
   
           })  ;
           } else {
             
           }
         });  
   
     }
    }
   
   function fnassignpackage(user_id){
   
     var activeplan=0;
   
      $.ajax({
            url: "{{ url('fetchUserhaveactiveplan') }}",
               type: "get",
               data:{ 
                   _token:'{{ csrf_token() }}',
                    user_id:user_id
                   },
               async:false,
               cache: false,
               dataType: 'json',
               success: function(data){
                   activeplan=data;
               } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
              
             }  
   
           })  ;
   
       if(activeplan!=0)
        {
   
          swal({
           title: "You Have Active Plan.Do you want to change Active plan to In Active!",
           text: "",
           icon: "warning",
           buttons: true,
           dangerMode: true,
         })
         .then((willDelete) => {
           if (willDelete) {
             fninsertorderdetails(user_id);
           } else {
             
           }
         }); 
         
       }
       else
         fninsertorderdetails(user_id);
   
       
    }
   function fninsertorderdetails(user_id){
   
     $("#package_sub_item").hide();
      $(".loaderajax").show();
             $.ajax({
                 url: "{{ url('getpackagenamelist') }}",
                    type: "get",
                    data:{ 
                        _token:'{{ csrf_token() }}',
                         user_type:'Seller'
                        },
                    async:false,
                    cache: false,
                    dataType: 'json',
                    success: function(data){
                        $(".loaderajax").hide();
                     var option="<option></option>";
                      data.map((item) => {
                       option+='<option value='+item.id+'>'+item.name+'</option>';
                      });
                      $("#package_list").empty().append(option);
                  } ,
                  error: function(XMLHttpRequest, textStatus, errorThrown) { 
                       $(".loaderajax").hide();
                    swal(errorThrown, "", "error");
                  }  
        
                })  ;
        
           $("#subitem").empty();
           $("#package_details").empty();
           $('#Mymodal').modal('show');
           $("#hdnuser_id").val(user_id);
   
   }
   
   function fnclosepopup1(){
       $("#Mymodal").modal('hide');
   }
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
                $(".loaderajax").show();
             $.ajax({
            url: "{{ url('sellersstatusupdates') }}",
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
                    $(".loaderajax").hide();
                 swal(data, "", "success");
                 location.reload();
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
                  $(".loaderajax").hide();
               swal(errorThrown, "", "error");
             }  
   
           })  ;
           } else {
             
           }
         });  
   
     
   }
   
   
   function deleteconfirm(data){
     var deleteurl="{{route('delete.selleruser', ':id')}}".replace(':id', '')+data;
   
     swal({
       title:"Do you really want to delete? " ,
       text: "",
       icon: "warning",
       buttons: true,
       dangerMode: true,
     })
     .then((willDelete) => {
       if (willDelete) {
          $.ajax({
            url: deleteurl,
               type: "get",
               async:true,
               cache: false,
               dataType: 'json',
               success: function(data){
                 if(data==true)
                 {   swal('Deleted Successfully','','success');
                       location.reload();
                 }
                 else
                     swal('Deletion Failed','','error');
                 
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
               swal("Error: " + errorThrown,'','error'); 
             }  
   
           })  ;
       } 
       else {
             
           }
       });  
   
   }
   

   
</script>
@endsection