<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>FABLAB UP Cebu</title>



  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>


  <script src="{{ asset('js/app.js') }}"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Font Awesome JS -->
  <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>


  <!-- Styles -->

  <link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
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
      @if(session('status'))
        <div class="alert alert-{{ session('status') }}  alert-dismissible fade show" role="alert">
          <span>{{ session('message') }}</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      

      <div class="content-area">
        @yield('content')
      </div>
    </main>
  </div>
</div>

@stack('scripts')

</body>
</html>
