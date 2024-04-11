@if(hasPermission('order.show'))
<a href="{{ route('order.show', ['order' => $row->id]) }}" class="btn btn-icon">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16"> <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/> <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/> </svg>
</a>
@endif
@if(hasPermission('order.edit'))
<a href="{{ route('order.edit', ['order' => $row->id]) }}" class="btn btn-icon">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
</a>


<a href="javascript:void(0)" class="btn btn-icon button-change-status" data-url="{{ route('order.changestatus', $row->id) }}" data-status="{{ $row->status }}" title="Change Status">
    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="24" height="24"><path d="M19,3h-6.528c-.154,0-.31-.036-.447-.105l-3.153-1.576c-.415-.208-.879-.318-1.344-.318h-2.528C2.243,1,0,3.243,0,6v12c0,2.757,2.243,5,5,5h3c.552,0,1-.447,1-1s-.448-1-1-1h-3c-1.654,0-3-1.346-3-3V9H22v9c0,1.654-1.346,3-3,3h-3c-.552,0-1,.447-1,1s.448,1,1,1h3c2.757,0,5-2.243,5-5V8c0-2.757-2.243-5-5-5ZM2,6c0-1.654,1.346-3,3-3h2.528c.154,0,.308,.036,.447,.106l3.156,1.577c.415,.207,.878,.316,1.341,.316h6.528c1.302,0,2.402,.839,2.816,2H2v-1ZM14.293,15.896l-1.293-1.293v7.397c0,.553-.448,1-1,1s-1-.447-1-1v-7.397l-1.293,1.293c-.195,.195-.451,.293-.707,.293s-.512-.098-.707-.293c-.391-.391-.391-1.023,0-1.414l1.613-1.613c1.118-1.119,3.069-1.119,4.188,0l1.613,1.613c.391,.391,.391,1.023,0,1.414s-1.023,.391-1.414,0Z"/></svg>
</a>
@endif
{{-- @if(hasPermission('order.destroy'))
<button act-on="click" act-confirm="You want to delete !" act-request="{{ route('order.destroy', ['order' => $row->id]) }}"  class="btn btn-icon">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="4" width="18" height="4" rx="2" /><path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" /><line x1="10" y1="12" x2="14" y2="12" /></svg>
</button>
@endif --}}
