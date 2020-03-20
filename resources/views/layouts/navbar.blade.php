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
        </li>


        
          <li class="nav-item superadmin">
            @if (Auth::user()->superadmin)
              <strong class="nav-caption">Admin</strong>
            @endif
          </li>
          <li class="nav-item superadmin">
            <a href="/team">
               @if (Auth::user()->superadmin)
                Manage Team 
              @else
                Team Members 
              @endif
            </a>
          </li>
          <li class="nav-item superadmin">
            <a href="/appsettings">
                @if (Auth::user()->superadmin)
                  App Settings
                @else
                  App Information
                @endif
            </a>
          </li>
          @if (Auth::user()->superadmin)
            <li class="nav-item superadmin">
              <a href="/categories">
                Data Categories
              </a>
            </li>
          @endif
      </ul>
    </div>


    <div class="collapse navbar-collapse d-none d-lg-block d-xl-block" id="navbarLarge">
      <ul class="nav navbar-nav ml-auto">
        
          <li class="nav-item dropdown">
            <a id="navBarDropdownAdmin" class="nav-link superadmin-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              <div class="pr-3">
                @if (Auth::user()->superadmin)
                  <i class="fas fa-users-cog"></i>
                @else
                  <i class="fas fa-info-circle"></i>
                @endif

              </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navBarDropdownAdmin">
              @if (Auth::user()->superadmin)
                <h6 class="dropdown-header">Administrator</h6>
                <div class="dropdown-divider"></div>
              @endif

              <a class="dropdown-item" href="/team">
                 @if (Auth::user()->superadmin)
                  Manage Team 
                @else
                  Team Members 
                @endif
              </a>

              <a class="dropdown-item" href="/appsettings">
                @if (Auth::user()->superadmin)
                  App Settings
                @else
                  App Information
                @endif

              </a>

              @if (Auth::user()->superadmin)
                <a class="dropdown-item" href="/categories">
                    Data Categories
                </a>
              @endif

            </div>
          </li>
       
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link user-image" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <div class="pl-3">
              <img src="{{ $user->profileImage() }}" class="rounded-circle border" style="width: 45px; height: 45px;" alt="" />
              <span class="caret"></span>
            </div>
          </a>

          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <h6 class="dropdown-header">
              Hi, {{ $user->fname }}!
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