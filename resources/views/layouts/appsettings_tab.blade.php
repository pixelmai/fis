  <div class="row settings_tab justify-content-center">
    <div class="col-lg-8">
      <div class="d-lg-flex justify-content-between">
        <div class="sh">Categories</div>
        <div>
          <ul class="nav nav-tabs">
            <li class="nav-item ml-2">
              <a class="nav-link @if(!empty($cat_settings['seltab']) && ($cat_settings['seltab'] == 'info')) active @endif" href="/categories">Info</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(!empty($cat_settings['seltab']) && ($cat_settings['seltab'] == 'sectors')) active @endif" href="/categories/sectors">Sectors</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(!empty($cat_settings['seltab']) && ($cat_settings['seltab'] == 'registrations')) active @endif" href="/categories/registrations">Registration</a> <!-- REGISTERED, UN, POTENTIAL -->
            </li>
            <li class="nav-item">
              <a class="nav-link @if(!empty($cat_settings['seltab']) && ($cat_settings['seltab'] == 'partners')) active @endif" href="/categories/partners">Partners</a> <!-- NGO, GOV, COM -->
            </li>
            <li class="nav-item mr-2">
              <a class="nav-link @if(!empty($cat_settings['seltab']) && ($cat_settings['seltab'] == 'services')) active @endif" href="/categories/services">Services</a>
            </li>
          </ul>

        </div>
      </div>
    </div>
  </div>



