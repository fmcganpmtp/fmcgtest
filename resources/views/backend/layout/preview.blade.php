<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8"/>
    
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="app-url" content="{{ config('app.url') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    
    <meta name="theme-color" content="#070c11">
    <meta name="mobile-web-app-capable" content="yes" />
    
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name', 'Laravel') }}" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="{{ config('app.status_bar_style') }}" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicons/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ route('manifest', ['view' => 'mobile' ]) }}">
 
 
    <title>{{ config('app.name', 'Laravel') }}</title>
    @php $routeName = request()->route()->getName(); @endphp
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet"> 
    @yield('style')
    <link href="{{ asset('assets/backend/css/style.css?version=' . config('app.asset_version')) }}" rel="stylesheet"/>

  </head>
  <body class="preview">
 
        <div class="container">
          <div class="row align-items-center">
            <div class="col-12 col-lg-6 content">
              
              <h1>
              {!! getOption('pwa_webview_title') !!}
              </h1>
 
              {!! getOption('pwa_webview_content') !!}
 
              <div class="d-flex mt-4">

                <div class="app-mobile-btn me-3">
                  <a href="{{ getOption('apple_app_store_link', '#') }}" class="btn btn_apple">
                    <div class="d-flex">

                      <div class="d-flex justify-content-between">
                        <svg xmlns="http://www.w3.org/2000/svg" class="download-icon" width="38" height="38" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7c-3 0 -4 3 -4 5.5c0 3 2 7.5 4 7.5c1.088 -.046 1.679 -.5 3 -.5c1.312 0 1.5 .5 3 .5s4 -3 4 -5c-.028 -.01 -2.472 -.403 -2.5 -3c-.019 -2.17 2.416 -2.954 2.5 -3c-1.023 -1.492 -2.951 -1.963 -3.5 -2c-1.433 -.111 -2.83 1 -3.5 1c-.68 0 -1.9 -1 -3 -1z" /><path d="M12 4a2 2 0 0 0 2 -2a2 2 0 0 0 -2 2" /></svg>
                      </div>

                      <div class="txt">
                        <span>Download on the</span>
                        <p>Apple Store</p>
                      </div>
                    </div>
                  </a>
                </div>


                <div class="app-mobile-btn">
                  <a href="{{ getOption('google_play_store_link', '#') }}" class="btn btn_apple">
                    <div class="d-flex">

                      <div class="d-flex justify-content-between">
                       <svg xmlns="http://www.w3.org/2000/svg" class="download-icon" width="38" height="38" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 3.71v16.58a0.7 .7 0 0 0 1.05 .606l14.622 -8.42a0.55 .55 0 0 0 0 -.953l-14.622 -8.419a0.7 .7 0 0 0 -1.05 .607z" /><line x1="15" y1="9" x2="4.5" y2="20.5" /><line x1="4.5" y1="3.5" x2="15" y2="15" /></svg>
                      </div>

                      <div class="txt">
                        <span>Download on the</span>
                        <p>Google Play</p>
                      </div>
                    </div>
                  </a>
                </div>


              </div>
            
            </div>
            <div class="col-12 col-lg-6">
              <div class="mobile-frame">
                <iframe class="iframe" src="{{ route('mobile') }}" frameborder="0"></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
 
  </body>
</html>