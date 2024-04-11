
@if(hasPermission('deliverypartner.show'))
<a href="{{ route('deliverypartner.show', ['deliverypartner' => $row->id]) }}" class="btn btn-icon">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16"> <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/> <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/> </svg>
</a>
@endif

@if (hasPermission('deliverypartner.edit'))
    <a href="{{ route('deliverypartner.edit', ['deliverypartner' => $row->id]) }}" class="btn btn-icon">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
            <line x1="16" y1="5" x2="19" y2="8" />
        </svg>
    </a>
@endif
@if (hasPermission('deliverypartner.destroy'))
    <button act-on="click" act-confirm="You want to delete !" act-request="{{ route('deliverypartner.destroy', ['deliverypartner' => $row->id]) }}" class="btn btn-icon">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <rect x="3" y="4" width="18" height="4" rx="2" />
            <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" />
            <line x1="10" y1="12" x2="14" y2="12" />
        </svg>
    </button>
@endif
@if (hasPermission('deliverypartner.update.online.status'))

    @if ($row->online == 1)
        <button act-on="click" act-confirm="You want to make Offline this Delivery Partner !" act-request="{{ route('deliverypartner.changeonlinestatus', ['deliverypartner' => $row->id, 'status' => 0]) }}" class="btn btn-icon" alt="Offline User" title="Make offline">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" fill="#FF4136" />
                <path d="M16 8.59l-1.41-1.41-2.58 2.59-2.59-2.59-1.41 1.41 2.59 2.58-2.59 2.59 1.41 1.41 2.58-2.59 2.59 2.59 1.41-1.41-2.59-2.58z" fill="#FFF" />
              </svg>
        </button>
    @elseif($row->online == 0)
        <button act-on="click" act-confirm="You want to make online this Delivery Partner !" act-request="{{ route('deliverypartner.changeonlinestatus', ['deliverypartner' => $row->id, 'status' => 1]) }}" class="btn btn-icon" alt="Online User" title="Make Online">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" fill="#00A65A" />
              </svg>
        </button>
    @endif
@endif
@if (hasPermission('deliverypartner.update.active.status'))
    @if ($row->status == 'active')
        <button act-on="click" act-confirm="You want to Block this Delivery Partner !" act-request="{{ route('deliverypartner.changeactivestatus', ['deliverypartner' => $row->id, 'status' => 'block']) }}" class="btn btn-icon" alt="Block User" title="Block User">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path fill="currentColor" d="M358.63 153.37c-7.81-7.81-20.47-7.81-28.28 0L256 227.313l-74.34-74.34c-7.81-7.81-20.47-7.81-28.28 0-7.81 7.81-7.81 20.47 0 28.28L227.313 256l-74.34 74.34c-7.81 7.81-7.81 20.47 0 28.28 7.81 7.81 20.47 7.81 28.28 0L256 284.687l74.34 74.34c7.81 7.81 20.47 7.81 28.28 0 7.81-7.81 7.81-20.47 0-28.28L284.687 256l74.34-74.34c7.81-7.81 7.81-20.47 0-28.28z"></path>
            </svg>



        </button>
    @elseif($row->status == 'block')
        <button act-on="click" act-confirm="You want to Activate this Delivery Partner !" act-request="{{ route('deliverypartner.changeactivestatus', ['deliverypartner' => $row->id, 'status' => 'active']) }}" class="btn btn-icon" alt="Activate User" title="Activate User">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24">
                <path fill="currentColor" d="M256 0C114.616 0 0 114.615 0 256s114.616 256 256 256 256-114.615 256-256S397.384 0 256 0zm80.51 172.697c8.098-8.197 21.172-8.225 29.291-.05l9.941 9.931c8.173 8.194 8.204 21.268.05 29.291l-103.953 104.33c-8.163 8.181-21.3 8.188-29.485.025l-52.544-52.568c-8.197-8.097-8.225-21.171-.05-29.29l9.93-9.941c8.173-8.195 21.248-8.223 29.291-.05l38.594 38.6 73.225-73.466z"></path>
            </svg>

        </button>
    @endif
@endif

