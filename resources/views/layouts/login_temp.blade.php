<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>FABLAB UP Cebu</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
  <div id="login_page">
    <main class="py-4">
    <div class="container pt-3">
      <div class="row justify-content-center py-5">
        <div id="logo"></div>
      </div>

        @yield('content')
      </div>
    </main>
  </div>
</body>
</html>
