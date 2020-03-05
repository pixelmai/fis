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

  <!-- Font Awesome JS -->
  <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>


  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="wrapper">
  <!-- Sidebar  -->
  <div class="fixed-position">
    <nav id="sidebar">
        <div class="sidebar-header">
          <a class="navbar-brand d-flex justify-content-center" href="{{ url('/') }}">
            <div><img src="/svg/dino.svg" alt="" style="height: 30px;" class="pr-1" /></div><div class="pl-2 pt-1">FABLAB</div>
          </a>
        </div>

        @if (Auth::user())
          <ul class="list-unstyled components">
              <li class="active">
                  <a href="#">Dashboard</a>
              </li>
              <li>
                  <a href="#submenuClients" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Customers</a>
                  <ul class="collapse list-unstyled" id="submenuClients">
                      <li>
                          <a href="#">Clients</a>
                      </li>
                      <li>
                          <a href="#">Companies</a>
                      </li>
                      <li>
                          <a href="#">Projects</a>
                      </li>
                  </ul>
              </li>
              <li>
                  <a href="#submenuTransactions" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Transactions</a>
                  <ul class="collapse list-unstyled" id="submenuTransactions">
                      <li>
                          <a href="#">Invoices</a>
                      </li>
                      <li>
                          <a href="#">Official Billing</a>
                      </li>
                      <li>
                          <a href="#">Services</a>
                      </li>
                  </ul>
              </li>
              <li>
                  <a href="#submenuInventory" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Inventory</a>
                  <ul class="collapse list-unstyled" id="submenuInventory">
                      <li>
                          <a href="#">Consumables</a>
                      </li>
                      <li>
                          <a href="#">Tools</a>
                      </li>
                      <li>
                          <a href="#">Machines</a>
                      </li>
                  </ul>
              </li>
              <li>
                  <a href="#">Reports</a>
              </li>

          </ul>
        @endif
      </nav>
    </div>

    
        

    <!-- Page Content  -->
    <div id="content">

        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                    <!-- span>Toggle Sidebar</span -->
                </button>

                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>


                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                         @if (Auth::user()->superadmin)
                        <li class="nav-item dropdown">
                          <a id="navBarDropdownAdmin" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Superadmin</a>

                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navBarDropdownAdmin">
                            <a class="dropdown-item" href="/account">
                              Manage Users
                            </a>

                            <a class="dropdown-item" href="/account">
                              App Settings
                            </a>
                          </div>
                        </li>
                      @endif




                      <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->fname }} <span class="caret"></span>
                        </a>



                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="/account">
                            Account Profile
                          </a>


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
                    </ul>
                </div>
            </div>
        </nav>



        <main>
          @if(session('status'))
            <div class="status">{{ session('status') }}</div>
          @endif
          <div class="content-area">
            @yield('content')
          </div>
        </main>
    </div>
</div>
<!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>
