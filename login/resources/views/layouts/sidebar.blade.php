      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="/dashboard">
              <i class="ti-shield menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/users">
              <i class="ti-user menu-icon"></i>
              <span class="menu-title">Users Management</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/roles">
              <i class="ti-layout-list-post menu-icon"></i>
              <span class="menu-title">Roles Management</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/application_portals">
              <i class="ti-layers menu-icon"></i>
              <span class="menu-title">Application Portal</span>
            </a>
          </li>
          @if(env('CLOUD_APP_ID',0))
          <li class="nav-item">
            <a class="nav-link" href="/cloud_setting">
              <i class="ti-cloud menu-icon"></i>
              <span class="menu-title">Cloud Setting</span>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a class="nav-link" href="javascript:doLogout()">
              <i class="ti-power-off menu-icon"></i>
              <span class="menu-title">Log Out</span>
            </a>
          </li>
        </ul>
      </nav>