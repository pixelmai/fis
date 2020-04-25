<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ (isset($page_title) ? $page_title . ' - ' : '') }} FABLAB UP Cebu</title>


  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">


  <link href="{{ asset('css/print.css') }}" rel="stylesheet">

  @stack('inpagecss')

</head>
<body>
<div id="print_page" class="wrapper">

  <!-- Page Content  -->
  <div id="content">

    @yield('content')


  </div>


</div>



<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
  
@stack('scripts')

</body>
</html>
