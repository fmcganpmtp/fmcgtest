@php $authUser = authUser(); @endphp
<div class="row row-cards widget">
    <div class="col-12 mt-0 mb-1">
        <div class="card card-sm" style="background: #ffffff8c;">
        <div class="card-body">
            <div class="row align-items-center">
            <div class="col-auto">
                <span class="bg-primary text-white avatar">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M40.9706 31.0294C38.3566 28.4154 35.2452 26.4803 31.8505 25.3089C35.4863 22.8048 37.875 18.6139 37.875 13.875C37.875 6.22434 31.6507 0 24 0C16.3493 0 10.125 6.22434 10.125 13.875C10.125 18.6139 12.5137 22.8048 16.1496 25.3089C12.7549 26.4803 9.6435 28.4154 7.02947 31.0294C2.49647 35.5625 0 41.5894 0 48H3.75C3.75 36.8341 12.8341 27.75 24 27.75C35.1659 27.75 44.25 36.8341 44.25 48H48C48 41.5894 45.5035 35.5625 40.9706 31.0294ZM24 24C18.4171 24 13.875 19.458 13.875 13.875C13.875 8.292 18.4171 3.75 24 3.75C29.5829 3.75 34.125 8.292 34.125 13.875C34.125 19.458 29.5829 24 24 24Z" fill="#FFFBFB"></path>
                        <path d="M44.9167 42H21.0833C20.4853 42 20 41.104 20 40C20 38.896 20.4853 38 21.0833 38H44.9167C45.5147 38 46 38.896 46 40C46 41.104 45.5147 42 44.9167 42Z" fill="white"></path>
                        <path d="M44.4167 48H9.58333C8.70933 48 8 47.104 8 46C8 44.896 8.70933 44 9.58333 44H44.4167C45.2907 44 46 44.896 46 46C46 47.104 45.2907 48 44.4167 48Z" fill="white"></path>
                    </svg>
                </span>
            </div>
            <div class="col">
                <div class="font-weight-medium">
                    {{ $authUser->name }}
                </div>
                <div class="text-muted">
                    {{ $authUser->role->name ?? __('None') }}
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>




<div class="row row-cards widget">
   <div class="card-header mt-1">
      <h3 class="card-title mb-0">Expired orders</h3>
   </div>
   <div class="card-body mt-0 p-3 pt-0">
      <div class="row g-3">
        @foreach($expired_orders as $row)

         <div class="col-12">
            <div class="row g-3 align-items-center">
               <a href="#" class="col-auto">
               <span class="avatar">
                <img src="{{asset('uploads/' . $row->logo)}}" class='img-thumbnail custom-file-preview' width='100'/>
                </span>
               </a>
               <div class="col text-truncate">
                  <a href="#" class="text-body d-block text-truncate">{{$row->vendor}}</a>
                  <small class="text-muted text-truncate mt-n1">{{$row->duration}} minutes ago</small>
               </div>
            </div>
         </div>
         @endforeach





      </div>
   </div>
</div>
