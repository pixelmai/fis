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
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
      <div class="container">
        <a class="navbar-brand d-flex" href="{{ url('/') }}">
          <div><img src="/svg/dino.svg" alt="" style="height: 30px;" class="pr-1" /></div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          @if (Auth::user())
            <ul class="navbar-nav mr-auto">
              <li class="nav-item dropdown">
                <a id="navBarDropdownClients" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Customers</a>

                <div class="dropdown-menu" aria-labelledby="navBarDropdownClients">
                  <a class="dropdown-item" href="/account">
                    Clients
                  </a>
                  <a class="dropdown-item" href="/account">
                    Companies
                  </a>
                  <a class="dropdown-item" href="/account">
                    Project
                  </a>
                </div>

              </li>
              <li class="nav-item dropdown">
                <a id="navBarDropdownTransactions" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Transactions</a>

                <div class="dropdown-menu" aria-labelledby="navBarDropdownTransactions">
                  <a class="dropdown-item" href="/account">
                    Invoices
                  </a>
                  <a class="dropdown-item" href="/account">
                    Official Billing
                  </a>
                  <a class="dropdown-item" href="/account">
                    Services
                  </a>
                </div>
              </li>

              <li class="nav-item dropdown">
                <a id="navBarDropdownInventory" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Inventory</a>

                <div class="dropdown-menu" aria-labelledby="navBarDropdownTransactions">
                  <a class="dropdown-item" href="/account">
                    Consumables
                  </a>
                  <a class="dropdown-item" href="/account">
                    Tools
                  </a>
                  <a class="dropdown-item" href="/account">
                    Machines
                  </a>
                </div>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="#">Reports</a>
              </li>

            </ul>
            @endif

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
              <li class="nav-item dropdown-menu">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
              </li>
              @if (Route::has('register'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
              @endif
            @else
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->fname }} <span class="caret"></span>
                </a>



                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/account">
                    Account Profile
                  </a>

                  @if (Auth::user()->superadmin)
                    <a class="dropdown-item" href="/account">
                      Manage Users
                    </a>

                    <a class="dropdown-item" href="/account">
                      App Settings
                    </a>

                  @endif

                  <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div>
              </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>

    <main class="py-4">
      @yield('content')
    </main>
  </div>
</body>
</html>
