@if(hasPermission('product.edit'))
<a href="{{ route('product.edit', ['product' => $row->id]) }}" class="btn btn-icon">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
</a>
@endif
@if(hasPermission('product.destroy'))
<button act-on="click" act-confirm="You want to delete !" act-request="{{ route('product.destroy', ['product' => $row->id]) }}"  class="btn btn-icon">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="4" width="18" height="4" rx="2" /><path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" /><line x1="10" y1="12" x2="14" y2="12" /></svg>
</button>
@endif
@if(hasPermission('product.duplicate'))
    <a href="{{ route('product.duplicate', ['product' => $row->id]) }}" class="btn btn-icon">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="20" width="18" version="1.1" id="Capa_1" viewBox="0 0 54 54" xml:space="preserve">
        <g>
            <g>
                <path d="M18.88,0.289C18.692,0.104,18.44,0,18.177,0H2C1.447,0,1,0.447,1,1v30c0,0.553,0.447,1,1,1h22c0.553,0,1-0.447,1-1V6.755    c0-0.268-0.107-0.523-0.297-0.711L18.88,0.289z M21.567,5.883h-2.514V3.397L21.567,5.883z M3,30V2h14.054v4.883    c0,0.553,0.447,1,1,1H23V30H3z"/>
                <path d="M52.703,28.044l-5.823-5.755C46.692,22.104,46.439,22,46.177,22H30c-0.553,0-1,0.447-1,1v30c0,0.553,0.447,1,1,1h22    c0.553,0,1-0.447,1-1V28.755C53,28.487,52.893,28.231,52.703,28.044z M49.567,27.883h-2.514v-2.486L49.567,27.883z M31,52V24    h14.054v4.883c0,0.553,0.447,1,1,1H51V52H31z"/>
            </g>
        </g>
        </svg>
    </a>
@endif
