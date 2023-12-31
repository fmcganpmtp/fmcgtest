@extends('admin.master')
@section('title', 'List Permissions')
@section('breadcrumb') Permissions @endsection
@section('content')

<div class="body flex-grow-1 px-3">
    <div class="container-lg">
      <div class="card-out mb-4 inner-form">
      @if(Session::has('message')) <div class="alert alert-success">{{Session::get('message') }}</div> @endif
        <h2>Admin permissions</h2>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 col-12">
              <div class="card ">
                <div class="card-header">

                  <div class="row">
                    <div class="col-lg-6 col-12">
                    
                     
                     
                      <input type="search" id="search_key"  placeholder="Search...." class="form-control" value={{$search_key}}  >
                    
                     </div>
<div class="col-lg-3 col-12">
<button type="button" id="btnsearch" value="search" class="bl-btn flt-right"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
</div>
<div class="col-lg-3 col-12">
                    <a href="{{ route('create.permission')}}" class="bl-btn flt-right">Create Permission</a>
                </div>
                </div>
               
                <div class="card-body">
                  <div class="tableC">
                 
                 
                 <table id="datatable" class="table  table-bordered" data-page-length='20' cellspacing="0" width="100%">
                       <thead>
                        <tr>
                          <th></th>
                        <th>Sl No</th>
                          <th>Name</th>
                          <th>Slug</th>
                          <th>Created Date</th>
                          <th class='nosort2'> Actions</th>
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


  <script src="{{asset('/admin1/js/datatable.js')}}"></script>
  <script src="{{asset('/admin1/js/sweetalert.js')}}"></script>
<script>
var $ = jQuery;
  (function($) {
  $(document).ready( function () {

    var id = '12';
    var editurl="{{route('edit.permission', ':id')}}";


    $('#btnsearch').click(function(){
    dataTable.draw();
    });

    $("#search_key,#btnsearch").keydown(function (event) { 
     if (event.which == 13) { 
         event.preventDefault();
         dataTable.draw();
     }
    });
    var dataTable=$('#datatable').DataTable({
         processing: false,
         serverSide: true,
          "lengthChange": false,
          'searching': false,
          "order": [ 0,'desc'],
         'ajax': {
       'url':"{{ url('getpermissionslist') }}",
       'data': function(data){
         _token="{{csrf_token()}}";
         data.search_key = $("#search_key").val();
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
       "data":"id",
       "render": function(data,type,full,meta)
      {
         editurl = editurl.replace(':id', '');
         return "<div class='icon-bx'> <a href='"+editurl+data+"'><i class='icon  cil-pencil'></i></a>  <a href='JavaScript:void(0);' onclick='deleteconfirm("+data+")'><i class='icon cil-trash'></i></a> </div>";
      }
    }],
         columns: [
          { data: 'id' },
          { data: 'id' },
          { data: 'name' },
          { data: 'slug' } ,  
          { data: 'created_at' },
         
          
         ]
      });    
  });
})(jQuery);

function deleteconfirm(data){
  var deleteurl="{{route('delete.permission', ':id')}}".replace(':id', '')+data;

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
