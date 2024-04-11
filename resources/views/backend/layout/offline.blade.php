<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8"/>
    
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="app-url" content="{{ config('app.url') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    
    <meta name="theme-color" content="{{ config('app.theme_primary', '#663259') }}">
    <meta name="mobile-web-app-capable" content="yes" />
 

    <title>{{ config('app.name', 'Laravel') }} | Admin</title>

  </head>
  <body style="background:{{ config('app.theme_primary', '#663259') }}">
    <div class="parent" style="height: 100vh; display: flex; align-items: center; justify-content: center;">
      <div class="child" style="display: block;text-align: center; color: #dbdbdb;">
          <div>
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="100" height="100" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="18" x2="12.01" y2="18" /><path d="M9.172 15.172a4 4 0 0 1 5.656 0" /><path d="M6.343 12.343a7.963 7.963 0 0 1 3.864 -2.14m4.163 .155a7.965 7.965 0 0 1 3.287 2" /><path d="M3.515 9.515a12 12 0 0 1 3.544 -2.455m3.101 -.92a12 12 0 0 1 10.325 3.374" /><line x1="3" y1="3" x2="21" y2="21" /></svg>
          </div>
      </div>
    </div>
  </body>
</html>