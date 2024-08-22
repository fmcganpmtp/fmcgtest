<div class="card ">
    <div class="card-body p-0 pb-1 pt-3">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <span class="avatar avatar-md fill-bg" style="background-color: #115854 !important;">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M40.9706 31.0294C38.3566 28.4154 35.2452 26.4803 31.8505 25.3089C35.4863 22.8048 37.875 18.6139 37.875 13.875C37.875 6.22434 31.6507 0 24 0C16.3493 0 10.125 6.22434 10.125 13.875C10.125 18.6139 12.5137 22.8048 16.1496 25.3089C12.7549 26.4803 9.6435 28.4154 7.02947 31.0294C2.49647 35.5625 0 41.5894 0 48H3.75C3.75 36.8341 12.8341 27.75 24 27.75C35.1659 27.75 44.25 36.8341 44.25 48H48C48 41.5894 45.5035 35.5625 40.9706 31.0294ZM24 24C18.4171 24 13.875 19.458 13.875 13.875C13.875 8.292 18.4171 3.75 24 3.75C29.5829 3.75 34.125 8.292 34.125 13.875C34.125 19.458 29.5829 24 24 24Z" fill="#FFFBFB"/>
                        <path d="M44.9167 42H21.0833C20.4853 42 20 41.104 20 40C20 38.896 20.4853 38 21.0833 38H44.9167C45.5147 38 46 38.896 46 40C46 41.104 45.5147 42 44.9167 42Z" fill="white"/>
                        <path d="M44.4167 48H9.58333C8.70933 48 8 47.104 8 46C8 44.896 8.70933 44 9.58333 44H44.4167C45.2907 44 46 44.896 46 46C46 47.104 45.2907 48 44.4167 48Z" fill="white"/>
                    </svg>
                </span>
             </div>
            <div class="col ms-2">
            <h4 class="card-title m-0">
               {{ authUser()->name }}
            </h4>
            <div class="small mt-1">
                <span class="badge bg-green"></span> Online
            </div>

            </div>
        </div>
    </div>
</div>



<div class="side-nav">


    <ul class="side-nav-group">
        <li class="nav-item-title">User</li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 8.71l-5.333 -4.148a2.666 2.666 0 0 0 -3.274 0l-5.334 4.148a2.665 2.665 0 0 0 -1.029 2.105v7.2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-7.2c0 -.823 -.38 -1.6 -1.03 -2.105" /><path d="M16 15c-2.21 1.333 -5.792 1.333 -8 0" /></svg>
                </span>
                <span class="nav-link-title">
                    {{ __('Dashboard') }}
                </span>
            </a>
        </li>



        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.update.profile') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 11l2 2l4 -4" /></svg>
                </span>
                <span class="nav-link-title">
                    {{ __('Manage Profile') }}
                </span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.change.password') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="5" y="11" width="14" height="10" rx="2" /><circle cx="12" cy="16" r="1" /><path d="M8 11v-4a4 4 0 0 1 8 0v4" /></svg>
                </span>
                <span class="nav-link-title">
                    {{ __('Change Password') }}
                </span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('signout') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path><line x1="12" y1="2" x2="12" y2="12"></line></svg>
                </span>
                <span class="nav-link-title">
                    {{ __('Sign Out') }}
                </span>
            </a>
        </li>



        <li class="nav-item-title">{{ __('E-commerce') }}</li>

        @if(hasPermission('home.banner'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home.banner') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="4" y1="4" x2="20" y2="4"></line><line x1="4" y1="20" x2="20" y2="20"></line><rect x="6" y="9" width="12" height="6" rx="2"></rect></svg>
                </span>
                <span class="nav-link-title">
                    {{ __('Home Banner') }}
                </span>
            </a>
        </li>
        @endif

        @if(hasPermission('slider'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('slider') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="4" y1="4" x2="20" y2="4"></line><line x1="4" y1="20" x2="20" y2="20"></line><rect x="6" y="9" width="12" height="6" rx="2"></rect></svg>
                </span>
                <span class="nav-link-title">
                    {{ __('Slider') }}
                </span>
            </a>
        </li>
        @endif

        @if(hasPermission('coupon'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('coupon') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><path d="M9 16v-8h4a2 2 0 0 1 0 4h-4m3 0l3 4" /></svg>
                </span>
                <span class="nav-link-title">
                    {{ __('Coupon') }}
                </span>
            </a>
        </li>
        @endif

        @if(hasPermission('order'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('order') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><rect x="9" y="3" width="6" height="4" rx="2" /><line x1="9" y1="12" x2="9.01" y2="12" /><line x1="13" y1="12" x2="15" y2="12" /><line x1="9" y1="16" x2="9.01" y2="16" /><line x1="13" y1="16" x2="15" y2="16" /></svg>
                </span>
                <span class="nav-link-title">
                    {{ __('Orders') }}
                </span>
            </a>
        </li>
        @endif

        @if(hasPermission('product'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('product') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3" /><line x1="12" y1="12" x2="20" y2="7.5" /><line x1="12" y1="12" x2="12" y2="21" /><line x1="12" y1="12" x2="4" y2="7.5" /><line x1="16" y1="5.25" x2="8" y2="9.75" /></svg>
                </span>
                <span class="nav-link-title">
                    {{ __('Products') }}
                </span>
            </a>
        </li>
        @endif



        @if(hasPermission('vendor'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('vendor') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="3" y1="21" x2="21" y2="21" /><path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" /><line x1="5" y1="21" x2="5" y2="10.85" /><line x1="19" y1="21" x2="19" y2="10.85" /><path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" /></svg>
                </span>
                <span class="nav-link-title">
                    {{ __('Vendor') }}
                </span>
            </a>
        </li>
        @endif


        @if(hasPermission('brand'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('brand') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><path d="M9 16v-8h4a2 2 0 0 1 0 4h-4m3 0l3 4" /></svg>
                </span>
                <span class="nav-link-title">
                    {{ __('Brands') }}
                </span>
            </a>
        </li>
        @endif


        @if(hasPermission('submenu'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('submenu') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="6" x2="20" y2="6" /><line x1="4" y1="12" x2="20" y2="12" /><line x1="4" y1="18" x2="16" y2="18" /></svg>
                </span>
                <span class="nav-link-title">
                    {{ __('Submenu') }}
                </span>
            </a>
        </li>
        @endif

        @if(hasPermission('menu'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('menu') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="6" x2="20" y2="6" /><line x1="4" y1="12" x2="20" y2="12" /><line x1="4" y1="18" x2="20" y2="18" /></svg>
                </span>
                <span class="nav-link-title">
                    {{ __('Menu') }}
                </span>
            </a>
        </li>
        @endif


        @if(hasPermission('business.category'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('business.category') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path></svg>
                </span>
                <span class="nav-link-title">
                    {{ __('Category') }}
                </span>
            </a>
        </li>
        @endif
        @if(hasPermission('deliveryslot'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('deliveryslot') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><rect x="9" y="3" width="6" height="4" rx="2" /><line x1="9" y1="12" x2="9.01" y2="12" /><line x1="13" y1="12" x2="15" y2="12" /><line x1="9" y1="16" x2="9.01" y2="16" /><line x1="13" y1="16" x2="15" y2="16" /></svg>
                    </span>
                <span class="nav-link-title">
                    {{ __('Delivery Slot') }}
                </span>
            </a>
        </li>
        @endif

        @if(hasPermission('customer'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('customer') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">

                    <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 13.5C16.6193 13.5 15.5 12.3807 15.5 11C15.5 9.61929 16.6193 8.5 18 8.5C19.3807 8.5 20.5 9.61929 20.5 11C20.5 12.3807 19.3807 13.5 18 13.5ZM9 10.5C7.067 10.5 5.5 8.933 5.5 7C5.5 5.067 7.067 3.5 9 3.5C10.933 3.5 12.5 5.067 12.5 7C12.5 8.933 10.933 10.5 9 10.5Z" stroke="currentColor"/>
                        <path d="M20.0883 20.5C20.0038 18.6991 19.4654 17.0162 18.585 15.5639C19.8015 15.7101 20.87 16.1063 21.6923 16.7444C22.7182 17.5403 23.4024 18.7434 23.4993 20.4287C23.5004 20.4467 23.5005 20.4696 23.4976 20.4921C23.4974 20.4941 23.4971 20.4961 23.4968 20.4979C23.4865 20.4991 23.4731 20.5 23.4559 20.5H20.0883ZM23.5243 20.4922C23.5243 20.4922 23.524 20.4924 23.5232 20.4927L23.5243 20.4922ZM0.509074 20.1947C0.507031 20.191 0.505237 20.1876 0.503669 20.1845C0.697832 17.9658 1.68882 16.3164 3.16648 15.2101C4.66744 14.0863 6.70331 13.5 8.98334 13.5C11.3043 13.5 13.3713 14.0566 14.8806 15.1632C16.3749 16.2588 17.3608 17.9197 17.4988 20.2298C17.5006 20.2593 17.501 20.2996 17.4955 20.3416C17.4897 20.3846 17.4795 20.4154 17.469 20.4347C17.461 20.4494 17.4532 20.4579 17.4382 20.4663C17.4208 20.4761 17.3672 20.5 17.2467 20.5H17.225H17.2032H17.1814H17.1595H17.1376H17.1157H17.0937H17.0717H17.0496H17.0275H17.0054H16.9832H16.961H16.9387H16.9164H16.894H16.8716H16.8492H16.8267H16.8042H16.7817H16.7591H16.7364H16.7137H16.691H16.6682H16.6454H16.6226H16.5997H16.5768H16.5538H16.5308H16.5077H16.4847H16.4615H16.4383H16.4151H16.3919H16.3686H16.3452H16.3218H16.2984H16.275H16.2515H16.2279H16.2043H16.1807H16.157H16.1333H16.1096H16.0858H16.0619H16.0381H16.0141H15.9902H15.9662H15.9421H15.9181H15.8939H15.8698H15.8456H15.8213H15.797H15.7727H15.7483H15.7239H15.6995H15.675H15.6504H15.6259H15.6012H15.5766H15.5519H15.5271H15.5023H15.4775H15.4527H15.4278H15.4028H15.3778H15.3528H15.3277H15.3026H15.2774H15.2523H15.227H15.2017H15.1764H15.1511H15.1257H15.1002H15.0747H15.0492H15.0236H14.998H14.9724H14.9467H14.921H14.8952H14.8694H14.8435H14.8176H14.7917H14.7657H14.7397H14.7136H14.6875H14.6614H14.6352H14.609H14.5827H14.5564H14.5301H14.5037H14.4772H14.4508H14.4242H14.3977H14.3711H14.3445H14.3178H14.2911H14.2643H14.2375H14.2106H14.1838H14.1568H14.1299H14.1029H14.0758H14.0487H14.0216H13.9944H13.9672H13.9399H13.9126H13.8853H13.8579H13.8305H13.803H13.7755H13.748H13.7204H13.6928H13.6651H13.6374H13.6096H13.5819H13.554H13.5261H13.4982H13.4703H13.4423H13.4142H13.3862H13.358H13.3299H13.3017H13.2734H13.2451H13.2168H13.1884H13.16H13.1316H13.1031H13.0746H13.046H13.0174H12.9887H12.96H12.9313H12.9025H12.8737H12.8448H12.8159H12.7869H12.758H12.7289H12.6999H12.6708H12.6416H12.6124H12.5832H12.5539H12.5246H12.4952H12.4658H12.4364H12.4069H12.3774H12.3478H12.3182H12.2886H12.2589H12.2291H12.1994H12.1696H12.1397H12.1098H12.0799H12.0499H12.0199H11.9898H11.9597H11.9296H11.8994H11.8692H11.8389H11.8086H11.7783H11.7479H11.7174H11.687H11.6565H11.6259H11.5953H11.5647H11.534H11.5033H11.4725H11.4417H11.4109H11.38H11.3491H11.3181H11.2871H11.256H11.225H11.1938H11.1627H11.1314H11.1002H11.0689H11.0376H11.0062H10.9748H10.9433H10.9118H10.8803H10.8487H10.817H10.7854H10.7537H10.7219H10.6901H10.6583H10.6264H10.5945H10.5626H10.5306H10.4985H10.4664H10.4343H10.4022H10.37H10.3377H10.3054H10.2731H10.2407H10.2083H10.1759H10.1434H10.1109H10.0783H10.0457H10.013H9.98032H9.94758H9.9148H9.88198H9.84912H9.81622H9.78327H9.75029H9.71726H9.68419H9.65108H9.61794H9.58474H9.55151H9.51824H9.48492H9.45156H9.41817H9.38473H9.35125H9.31773H9.28417H9.25056H9.21692H9.18323H9.1495H9.11574H9.08193H9.04807H9.01418H8.98025H8.94627H8.91226H8.8782H8.8441H8.80996H8.77578H8.74156H8.7073H8.67299H8.63865H8.60426H8.56983H8.53536H8.50085H8.4663H8.43171H8.39708H8.3624H8.32768H8.29293H8.25813H8.22329H8.18841H8.15348H8.11852H8.08351H8.04847H8.01338H7.97825H7.94308H7.90787H7.87262H7.83732H7.80199H7.76661H7.7312H7.69574H7.66024H7.6247H7.58912H7.55349H7.51783H7.48212H7.44638H7.41059H7.37476H7.33889H7.30298H7.26702H7.23103H7.19499H7.15892H7.1228H7.08664H7.05044H7.0142H6.97791H6.94159H6.90522H6.86882H6.83237H6.79588H6.75935H6.72278H6.68617H6.64951H6.61282H6.57608H6.53931H6.50249H6.46563H6.42873H6.39178H6.3548H6.31778H6.28071H6.2436H6.20645H6.16927H6.13203H6.09476H6.05745H6.02009H5.9827H5.94526H5.90778H5.87026H5.8327H5.7951H5.75746H5.71978H5.68205H5.64428H5.60648H5.56863H5.53074H5.49281H5.45483H5.41682H5.37876H5.34067H5.30253H5.26435H5.22613H5.18787H5.14957H5.11122H5.07284H5.03441H4.99594H4.95744H4.91889H4.8803H4.84166H4.80299H4.76428H4.72552H4.68672H4.64788H4.609H4.57008H4.53112H4.49212H4.45307H4.41399H4.37486H4.33569H4.29648H4.25723H4.21794H4.17861H4.13924H4.09982H4.06036H4.02087H3.98133H3.94175H3.90213H3.86246H3.82276H3.78301H3.74323H3.7034H3.66353H3.62362H3.58367H3.54368H3.50365H3.46357H3.42345H3.3833H3.3431H3.30286H3.26258H3.22226H3.18189H3.14149H3.10104H3.06056H3.02003H2.97946H2.93885H2.8982H2.8575H2.81677H2.77599H2.73518H2.69432H2.65342H2.61248H2.5715H2.53047H2.48941H2.4483H2.40716H2.36597H2.32474H2.28347H2.24216H2.20081H2.15941H2.11798H2.0765H2.03499H1.99343H1.95183H1.91019H1.8685H1.82678H1.78502H1.74321H1.70136H1.65947H1.61754H1.57557H1.53356H1.49151H1.44941H1.40728H1.3651H1.32288H1.28062H1.23832H1.19598H1.1536H1.11117H1.06871H1.0262H0.983655H0.941066H0.898436H0.855764H0.813051H0.789446C0.787701 20.4989 0.785857 20.4977 0.783915 20.4963C0.742317 20.4684 0.687086 20.421 0.631483 20.3601C0.575901 20.2992 0.533504 20.2395 0.509074 20.1947Z" stroke="currentColor"/>
                    </svg>

                </span>
                <span class="nav-link-title">
                        {{ __('Customer') }}
                </span>
            </a>
        </li>
        @endif
        @if(hasPermission('deliverypartner'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('deliverypartner') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 640 512"  fill="currentColor"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H112C85.5 0 64 21.5 64 48v48H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h272c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H40c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H64v128c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z"/></svg>

                </span>
                <span class="nav-link-title">
                        {{ __('Delivery Partner') }}
                </span>
            </a>
        </li>
        @endif


        @if( hasPermission('user') || hasPermission('role') || hasPermission('permission'))
        <li class="nav-item-title">{{ __('Manage Access') }}</li>
        @endif

        @if(hasPermission('user'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">

                    <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 13.5C16.6193 13.5 15.5 12.3807 15.5 11C15.5 9.61929 16.6193 8.5 18 8.5C19.3807 8.5 20.5 9.61929 20.5 11C20.5 12.3807 19.3807 13.5 18 13.5ZM9 10.5C7.067 10.5 5.5 8.933 5.5 7C5.5 5.067 7.067 3.5 9 3.5C10.933 3.5 12.5 5.067 12.5 7C12.5 8.933 10.933 10.5 9 10.5Z" stroke="currentColor"/>
                        <path d="M20.0883 20.5C20.0038 18.6991 19.4654 17.0162 18.585 15.5639C19.8015 15.7101 20.87 16.1063 21.6923 16.7444C22.7182 17.5403 23.4024 18.7434 23.4993 20.4287C23.5004 20.4467 23.5005 20.4696 23.4976 20.4921C23.4974 20.4941 23.4971 20.4961 23.4968 20.4979C23.4865 20.4991 23.4731 20.5 23.4559 20.5H20.0883ZM23.5243 20.4922C23.5243 20.4922 23.524 20.4924 23.5232 20.4927L23.5243 20.4922ZM0.509074 20.1947C0.507031 20.191 0.505237 20.1876 0.503669 20.1845C0.697832 17.9658 1.68882 16.3164 3.16648 15.2101C4.66744 14.0863 6.70331 13.5 8.98334 13.5C11.3043 13.5 13.3713 14.0566 14.8806 15.1632C16.3749 16.2588 17.3608 17.9197 17.4988 20.2298C17.5006 20.2593 17.501 20.2996 17.4955 20.3416C17.4897 20.3846 17.4795 20.4154 17.469 20.4347C17.461 20.4494 17.4532 20.4579 17.4382 20.4663C17.4208 20.4761 17.3672 20.5 17.2467 20.5H17.225H17.2032H17.1814H17.1595H17.1376H17.1157H17.0937H17.0717H17.0496H17.0275H17.0054H16.9832H16.961H16.9387H16.9164H16.894H16.8716H16.8492H16.8267H16.8042H16.7817H16.7591H16.7364H16.7137H16.691H16.6682H16.6454H16.6226H16.5997H16.5768H16.5538H16.5308H16.5077H16.4847H16.4615H16.4383H16.4151H16.3919H16.3686H16.3452H16.3218H16.2984H16.275H16.2515H16.2279H16.2043H16.1807H16.157H16.1333H16.1096H16.0858H16.0619H16.0381H16.0141H15.9902H15.9662H15.9421H15.9181H15.8939H15.8698H15.8456H15.8213H15.797H15.7727H15.7483H15.7239H15.6995H15.675H15.6504H15.6259H15.6012H15.5766H15.5519H15.5271H15.5023H15.4775H15.4527H15.4278H15.4028H15.3778H15.3528H15.3277H15.3026H15.2774H15.2523H15.227H15.2017H15.1764H15.1511H15.1257H15.1002H15.0747H15.0492H15.0236H14.998H14.9724H14.9467H14.921H14.8952H14.8694H14.8435H14.8176H14.7917H14.7657H14.7397H14.7136H14.6875H14.6614H14.6352H14.609H14.5827H14.5564H14.5301H14.5037H14.4772H14.4508H14.4242H14.3977H14.3711H14.3445H14.3178H14.2911H14.2643H14.2375H14.2106H14.1838H14.1568H14.1299H14.1029H14.0758H14.0487H14.0216H13.9944H13.9672H13.9399H13.9126H13.8853H13.8579H13.8305H13.803H13.7755H13.748H13.7204H13.6928H13.6651H13.6374H13.6096H13.5819H13.554H13.5261H13.4982H13.4703H13.4423H13.4142H13.3862H13.358H13.3299H13.3017H13.2734H13.2451H13.2168H13.1884H13.16H13.1316H13.1031H13.0746H13.046H13.0174H12.9887H12.96H12.9313H12.9025H12.8737H12.8448H12.8159H12.7869H12.758H12.7289H12.6999H12.6708H12.6416H12.6124H12.5832H12.5539H12.5246H12.4952H12.4658H12.4364H12.4069H12.3774H12.3478H12.3182H12.2886H12.2589H12.2291H12.1994H12.1696H12.1397H12.1098H12.0799H12.0499H12.0199H11.9898H11.9597H11.9296H11.8994H11.8692H11.8389H11.8086H11.7783H11.7479H11.7174H11.687H11.6565H11.6259H11.5953H11.5647H11.534H11.5033H11.4725H11.4417H11.4109H11.38H11.3491H11.3181H11.2871H11.256H11.225H11.1938H11.1627H11.1314H11.1002H11.0689H11.0376H11.0062H10.9748H10.9433H10.9118H10.8803H10.8487H10.817H10.7854H10.7537H10.7219H10.6901H10.6583H10.6264H10.5945H10.5626H10.5306H10.4985H10.4664H10.4343H10.4022H10.37H10.3377H10.3054H10.2731H10.2407H10.2083H10.1759H10.1434H10.1109H10.0783H10.0457H10.013H9.98032H9.94758H9.9148H9.88198H9.84912H9.81622H9.78327H9.75029H9.71726H9.68419H9.65108H9.61794H9.58474H9.55151H9.51824H9.48492H9.45156H9.41817H9.38473H9.35125H9.31773H9.28417H9.25056H9.21692H9.18323H9.1495H9.11574H9.08193H9.04807H9.01418H8.98025H8.94627H8.91226H8.8782H8.8441H8.80996H8.77578H8.74156H8.7073H8.67299H8.63865H8.60426H8.56983H8.53536H8.50085H8.4663H8.43171H8.39708H8.3624H8.32768H8.29293H8.25813H8.22329H8.18841H8.15348H8.11852H8.08351H8.04847H8.01338H7.97825H7.94308H7.90787H7.87262H7.83732H7.80199H7.76661H7.7312H7.69574H7.66024H7.6247H7.58912H7.55349H7.51783H7.48212H7.44638H7.41059H7.37476H7.33889H7.30298H7.26702H7.23103H7.19499H7.15892H7.1228H7.08664H7.05044H7.0142H6.97791H6.94159H6.90522H6.86882H6.83237H6.79588H6.75935H6.72278H6.68617H6.64951H6.61282H6.57608H6.53931H6.50249H6.46563H6.42873H6.39178H6.3548H6.31778H6.28071H6.2436H6.20645H6.16927H6.13203H6.09476H6.05745H6.02009H5.9827H5.94526H5.90778H5.87026H5.8327H5.7951H5.75746H5.71978H5.68205H5.64428H5.60648H5.56863H5.53074H5.49281H5.45483H5.41682H5.37876H5.34067H5.30253H5.26435H5.22613H5.18787H5.14957H5.11122H5.07284H5.03441H4.99594H4.95744H4.91889H4.8803H4.84166H4.80299H4.76428H4.72552H4.68672H4.64788H4.609H4.57008H4.53112H4.49212H4.45307H4.41399H4.37486H4.33569H4.29648H4.25723H4.21794H4.17861H4.13924H4.09982H4.06036H4.02087H3.98133H3.94175H3.90213H3.86246H3.82276H3.78301H3.74323H3.7034H3.66353H3.62362H3.58367H3.54368H3.50365H3.46357H3.42345H3.3833H3.3431H3.30286H3.26258H3.22226H3.18189H3.14149H3.10104H3.06056H3.02003H2.97946H2.93885H2.8982H2.8575H2.81677H2.77599H2.73518H2.69432H2.65342H2.61248H2.5715H2.53047H2.48941H2.4483H2.40716H2.36597H2.32474H2.28347H2.24216H2.20081H2.15941H2.11798H2.0765H2.03499H1.99343H1.95183H1.91019H1.8685H1.82678H1.78502H1.74321H1.70136H1.65947H1.61754H1.57557H1.53356H1.49151H1.44941H1.40728H1.3651H1.32288H1.28062H1.23832H1.19598H1.1536H1.11117H1.06871H1.0262H0.983655H0.941066H0.898436H0.855764H0.813051H0.789446C0.787701 20.4989 0.785857 20.4977 0.783915 20.4963C0.742317 20.4684 0.687086 20.421 0.631483 20.3601C0.575901 20.2992 0.533504 20.2395 0.509074 20.1947Z" stroke="currentColor"/>
                    </svg>

                </span>
                <span class="nav-link-title">
                        {{ __('Users') }}
                </span>
            </a>
        </li>
        @endif

        @if(hasPermission('permission'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('permission') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 12l2 2l4 -4" /><path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" /></svg>
                </span>
                <span class="nav-link-title">
                        {{ __('Permission') }}
                </span>
            </a>
        </li>
        @endif

        @if(hasPermission('role'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('role') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" /><circle cx="12" cy="11" r="1" /><line x1="12" y1="12" x2="12" y2="14.5" /></svg>
                </span>
                <span class="nav-link-title">
                        {{ __('Role') }}
                </span>
            </a>
        </li>
        @endif



    </ul>

</div>
