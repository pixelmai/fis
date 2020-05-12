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
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <link href="{{ asset('css/fontawesome.all.min.css') }}" rel="stylesheet">

  <!-- Styles -->

  <link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div id="app" class="wrapper">
  <!-- Sidebar  -->
  <div class="fixed-position">
    @include('layouts/sidenav')
  </div>

    
  <!-- Page Content  -->
  <div id="content">
    @include('layouts/navbar')


    <main>

      <div class="content-area">
        @yield('content')
      </div>
    </main>
  </div>

  @if(session('status'))
    <div class="alert alert-{{ session('status') }}  alert-dismissible fade show" role="alert">
      <span>{{ session('message') }}</span>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <?php session()->forget('status'); ?>

  @endif

</div>





@stack('modals')

<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

<script src="{{ asset('js/app.js') }}" defer></script>
  
@stack('scripts')

</body>
</html>
