<nav id="sidebar">
  <div class="sidebar-header">
    <a class="navbar-brand d-flex justify-content-center" href="{{ url('/') }}">
      <div class="pr-1" style="height: 30px;">
        <img src="/svg/dino.svg" alt="" height="30" width="56" class="pr-1" />
      </div>
      <div class="pl-2 pt-1">FABLAB WIS</div>
    </a>
  </div>
  <ul class="list-unstyled components">
      <li @if(!empty($page_settings['seltab']) && ($page_settings['seltab'] == 'dashboard')) class="active" @endif>
          <a href="/">Dashboard</a>
      </li>
      <li @if(!empty($page_settings['seltab']) && ($page_settings['seltab'] == 'customers')) class="active" @endif>
          <a href="#submenuClients" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Customers</a>
          <ul class="@if(!empty($page_settings['seltab']) && ($page_settings['seltab'] == 'customers')) active @else collapse @endif list-unstyled" id="submenuClients">
              <li @if(!empty($page_settings['seltab2']) && ($page_settings['seltab2'] == 'clients')) class="active" @endif>
                  <a href="/clients">Clients</a>
              </li>
              <li @if(!empty($page_settings['seltab2']) && ($page_settings['seltab2'] == 'companies')) class="active" @endif>
                  <a href="/companies">Companies</a>
              </li>
              <li @if(!empty($page_settings['seltab2']) && ($page_settings['seltab2'] == 'projects')) class="active" @endif>
                  <a href="/projects">Projects</a>
              </li>
          </ul>
      </li>
      <li @if(!empty($page_settings['seltab']) && ($page_settings['seltab'] == 'transactions')) class="active" @endif>
          <a href="#submenuTransactions" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Transactions</a>
          <ul class="@if(!empty($page_settings['seltab']) && ($page_settings['seltab'] == 'transactions')) active @else collapse @endif list-unstyled" id="submenuTransactions">
              <li @if(!empty($page_settings['seltab2']) && ($page_settings['seltab2'] == 'invoices')) class="active" @endif>
                  <a href="/invoices">Invoices</a>
              </li>
              <li @if(!empty($page_settings['seltab2']) && ($page_settings['seltab2'] == 'official')) class="active" @endif>
                  <a href="/bills">Official Billing</a>
              </li>
              <li @if(!empty($page_settings['seltab2']) && ($page_settings['seltab2'] == 'services')) class="active" @endif>
                  <a href="/services">Services</a>
              </li>
          </ul>
      </li>
      <li @if(!empty($page_settings['seltab']) && ($page_settings['seltab'] == 'equipment')) class="active" @endif>

          <a href="#submenuEquipment" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Equipment</a>

          <ul class="@if(!empty($page_settings['seltab']) && ($page_settings['seltab'] == 'equipment')) active @else collapse @endif list-unstyled" id="submenuEquipment">
              <!-- li @if(!empty($page_settings['seltab2']) && ($page_settings['seltab2'] == 'consumables')) class="active" @endif>
                  <a href="#">Consumables</a>
              </li -->
              <li @if(!empty($page_settings['seltab2']) && ($page_settings['seltab2'] == 'machines')) class="active" @endif>
                  <a href="/machines">Machines</a>
              </li>
              <li @if(!empty($page_settings['seltab2']) && ($page_settings['seltab2'] == 'tools')) class="active" @endif>
                  <a href="/tools">Tools</a>
              </li>
              <li @if(!empty($page_settings['seltab2']) && ($page_settings['seltab2'] == 'suppliers')) class="active" @endif>
                  <a href="/suppliers">Suppliers</a>
              </li>
          </ul>
      </li>
      <li @if(!empty($page_settings['seltab']) && ($page_settings['seltab'] == 'reports')) class="active" @endif>
          <a href="#submenuReports" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Reports</a>

          <ul class="@if(!empty($page_settings['seltab']) && ($page_settings['seltab'] == 'reports')) active @else collapse @endif list-unstyled" id="submenuReports">
              <li @if(!empty($page_settings['seltab2']) && ($page_settings['seltab2'] == 'monthly')) class="active" @endif>
                  <a href="/reports/monthly">Monthly</a>
              </li>
              <li @if(!empty($page_settings['seltab2']) && ($page_settings['seltab2'] == 'yearly')) class="active" @endif>
                  <a href="/reports/yearly">Yearly</a>
              </li>
          </ul>

      </li>
  </ul>
</nav>
