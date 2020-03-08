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
            <div class="pr-1" style="height: 30px;">
              <img src="/svg/dino.svg" alt="" style="height: 30px;" class="pr-1" />
            </div>
            <div class="pl-2 pt-1">FABLAB WIS</div>
          </a>
        </div>
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

                <a href="#" class="d-inline-block d-lg-none ml-auto" data-toggle="collapse" data-target="#navbarMobileContent" aria-controls="navbarMobileContent" aria-expanded="false" aria-label="Toggle navigation">
                    <img src="{{ $user->profileImage() }}" class="rounded-circle border" style="width: 45px; height: 45px;" alt="" />
                </a>


                <div class="collapse navbar-collapse" id="navbarMobileContent">
                    <ul class="nav navbar-nav ml-auto d-md-block d-lg-none">
                      <li class="nav-item">
                        <a href="/account">
                          View Profile
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="/account/password">
                          Change Password
                        </a>
                      </li>

                      <li class="nav-item">
                          <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                          </form>
                      </li>


                      @if (Auth::user()->superadmin)
                        <li class="nav-item superadmin">
                          <strong class="nav-caption">Super Admin</strong>
                        </li>
                        <li class="nav-item superadmin">
                          <a href="/account">
                            Manage Users
                          </a>
                        </li>
                        <li class="nav-item superadmin">
                          <a href="/account">
                            App Settings
                          </a>
                        </li>

                      @endif




                    </ul>
                </div>


                <div class="collapse navbar-collapse d-none d-lg-block d-xl-block" id="navbarLarge">
                    <ul class="nav navbar-nav ml-auto">
                      @if (Auth::user()->superadmin)
                        <li class="nav-item dropdown">
                          <a id="navBarDropdownAdmin" class="nav-link superadmin-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <div class="pr-3">
                              <i class="fas fa-users-cog"></i>
                            </div>
                          </a>

                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navBarDropdownAdmin">
                            <h6 class="dropdown-header">Super Admin</h6>
                            <div class="dropdown-divider"></div>
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
                        <a id="navbarDropdown" class="nav-link user-image" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          <div class="pl-3">
                            <img src="{{ $user->profileImage() }}" class="rounded-circle border" style="width: 45px; height: 45px;" alt="" />
                            <span class="caret"></span>
                          </div>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                          <h6 class="dropdown-header">
                            {{ $user->fname }}
                          </h6>

                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="/account">
                            View Profile
                          </a>
                          <a class="dropdown-item" href="/account/password">
                            Change Password
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
<!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>
