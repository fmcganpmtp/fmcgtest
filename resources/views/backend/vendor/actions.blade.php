@if (hasPermission('vendor.show'))
    <a href="{{ route('vendor.show', ['vendor' => $row->id]) }}" class="btn btn-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
        </svg>
    </a>
@endif
@if (hasPermission('vendor.status.update'))
    @if ($row->status == 'pending')
        <button act-on="click" title="Activate" act-confirm="You want to Active this Vendor !" act-request="{{ route('vendor.status.update', ['vendor' => $row->id, 'status' => 'active']) }}" class="btn btn-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
                <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z" />
                <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
            </svg></button>
        <button act-on="click" title="Reject" act-confirm="You want to Reject this Vendor !" act-request="{{ route('vendor.status.update', ['vendor' => $row->id, 'status' => 'rejected']) }}" class="btn btn-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg></button>
    @endif
    @if ($row->status == 'active')
        <button act-on="click" title="Reject" act-confirm="You want to Reject this Vendor !" act-request="{{ route('vendor.status.update', ['vendor' => $row->id, 'status' => 'rejected']) }}" class="btn btn-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg></button>
    @endif

    @if ($row->status == 'rejected')
        <button act-on="click" title="Activate" act-confirm="You want to Active this Vendor !" act-request="{{ route('vendor.status.update', ['vendor' => $row->id, 'status' => 'active']) }}" class="btn btn-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
                <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z" />
                <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
            </svg></button>
    @endif
@endif

@if (hasPermission('vendor.commission.update'))
<a href="javascript:void(0)" class="btn btn-icon button-update-commission" data-url="{{ route('vendor.commission.update', $row->id) }}" data-percent="{{ $row->commission_percentage }}" title="Update Commision Percentage">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20" id="discount"><path fill-rule="evenodd" d="M265.751 16.17c60.021 0 108.862 48.846 108.862 108.867 0 60.016-48.849 108.853-108.862 108.853s-108.862-48.836-108.862-108.853C156.888 65.015 205.73 16.17 265.751 16.17zm4.842 147.519c0 15.122 12.322 27.42 27.424 27.42 15.15 0 27.424-12.298 27.424-27.42 0-15.117-12.274-27.424-27.424-27.424-15.102 0-27.424 12.307-27.424 27.424zm38.595 0c0-6.151-4.986-11.161-11.171-11.161-6.137 0-11.171 5.01-11.171 11.161s5.034 11.162 11.171 11.162c6.185 0 11.171-5.011 11.171-11.162zm-91.046 13.233c-2.829 3.893-1.918 9.311 1.966 12.106 3.883 2.805 9.301 1.923 12.082-1.97l81.266-113.086c2.781-3.879 1.918-9.311-1.966-12.106-3.883-2.805-9.301-1.923-12.13 1.975l-81.218 113.081zm15.342-63.129c15.102 0 27.424-12.298 27.424-27.419 0-15.117-12.322-27.424-27.424-27.424-15.103 0-27.424 12.307-27.424 27.424 0 15.122 12.322 27.419 27.424 27.419zm0-38.58c-6.137 0-11.171 5.01-11.171 11.161 0 6.146 5.034 11.157 11.171 11.157s11.171-5.01 11.171-11.157c0-6.151-5.034-11.161-11.171-11.161zM131.422 475.297c-.457 1.601-1.473 2.937-2.896 3.745l-28.253 15.987c-2.947 1.681-6.758.635-8.435-2.348L8.806 345.963c-1.677-2.973-.66-6.768 2.338-8.461l28.253-15.981a6.037 6.037 0 0 1 2.998-.788c.559 0 1.118.077 1.677.224 1.626.452 2.948 1.479 3.76 2.912l83.031 146.717a6.094 6.094 0 0 1 .559 4.711zm364.193-130.57c8.486-5.204 11.077-20.479 5.234-30.26-8.486-14.167-30.946-12.495-60.113 4.482l-79.631 46.381c-15.346 8.964-31.912 11.865-50.56 8.878a339.242 339.242 0 0 1-10.061-1.769c-.711-.051-62.756-16.179-69.87-18.095-4.624-1.23-7.368-5.955-6.098-10.544 1.22-4.604 5.946-7.327 10.519-6.098 7.266 1.946 51.272 14.421 67.787 17.633 8.435.539 18.242-1.809 21.596-14.228 2.744-10.184-3.252-20.524-13.974-24.239-30.133-5.518-59.25-16.032-82.625-24.497-8.181-2.953-15.244-5.503-21.342-7.485-19.208-6.23-37.451 1.946-54.27 11.707L76.9 340.223l50.103 88.55 20.427-11.789a8.602 8.602 0 0 1 6.555-.859l132.474 35.505c16.972 4.538 32.928 2.297 47.512-6.667l161.644-100.236zm-449.562 2.476c-.763-5.508-5.895-9.319-11.434-8.521-5.488.808-9.299 5.935-8.486 11.438.813 5.513 5.895 9.329 11.433 8.521 5.489-.807 9.3-5.924 8.487-11.438z" clip-rule="evenodd"/></svg></a>
 @endif
 @if (hasPermission('vendor.type.update'))
 @if($row->is_grofirst_vendor=='true')
 
 <a href="javascript:void(0)" class="btn btn-icon button-make-vendor" act-confirm="You want to remove this vendor from grofirst vendor list !" data-id="{{$row->id}}" data-type="{{$row->is_grofirst_vendor}}"  title="Make Grofirst Vendor">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" version="1.1" id="Capa_1" width="16" height="16" viewBox="0 0 436.38 436.381" xml:space="preserve">
        <g>
            <g>
                <path d="M218.19,232c54.735,0,99.107-51.936,99.107-116c0-88.842-44.371-116-99.107-116c-54.736,0-99.107,27.158-99.107,116    C119.083,180.064,163.455,232,218.19,232z"/>
                <path d="M432.47,408.266l-50-112.636c-1.838-4.142-5.027-7.534-9.045-9.626l-79.62-41.445c-4.809-2.504-10.423-2.947-15.564-1.231    c-5.141,1.715-9.364,5.442-11.707,10.329L232.7,324.266l4.261-38.408c0.133-1.201-0.174-2.412-0.865-3.405l-13.8-19.839    c-0.048-0.068-0.104-0.131-0.154-0.195l11.935-9.061c1.028-0.781,1.633-1.998,1.633-3.291c0-4.834-3.935-8.769-8.77-8.769h-17.498    c-4.835,0-8.769,3.935-8.769,8.769c0,1.293,0.604,2.51,1.633,3.291l11.934,9.061c-0.051,0.064-0.106,0.127-0.154,0.195    l-13.8,19.839c-0.691,0.993-0.999,2.204-0.865,3.405l4.26,38.408l-33.834-70.609c-2.342-4.887-6.566-8.614-11.707-10.329    c-5.14-1.716-10.757-1.271-15.564,1.231l-79.62,41.445c-4.018,2.092-7.207,5.484-9.045,9.626l-50,112.636    c-2.746,6.188-2.177,13.342,1.512,19.018c3.689,5.674,9.999,9.098,16.768,9.098h392c6.769,0,13.078-3.424,16.768-9.1    C434.648,421.607,435.216,414.453,432.47,408.266z"/>
            </g>
        </g>
        </svg></a>
        @else
        <a href="javascript:void(0)" class="btn btn-icon button-make-vendor" act-confirm="You want to make this vendor as grofirst vendor !" data-id="{{$row->id}}" data-type="{{$row->is_grofirst_vendor}}"  title="Make Grofirst Vendor">
        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg></a>
        @endif
    @endif
{{-- @if (hasPermission('vendor.edit'))
<a href="{{ route('vendor.edit', ['vendor' => $row->id]) }}" class="btn btn-icon">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
</a>
@endif
@if (hasPermission('vendor.destroy'))
<button act-on="click" act-confirm="You want to delete !" act-request="{{ route('vendor.destroy', ['vendor' => $row->id]) }}"  class="btn btn-icon">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="4" width="18" height="4" rx="2" /><path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" /><line x1="10" y1="12" x2="14" y2="12" /></svg>
</button>
@endif --}}
