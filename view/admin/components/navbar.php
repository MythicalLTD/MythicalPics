<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
  id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="ti ti-menu-2 ti-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <li class="nav-item me-2 me-xl-0">
        <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
          <i class="ti ti-md"></i>
        </a>
      </li>
      <!-- User -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <img src="<?=$userdb['avatar']?>" alt class="h-auto rounded-circle" />
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="pages-account-settings-account.html">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar avatar-online">
                    <img src="<?=$userdb['avatar']?>" alt class="h-auto rounded-circle" />
                  </div>
                </div>
                <div class="flex-grow-1">
                  <span class="fw-semibold d-block"><?= $userdb['username'] ?></span>
                  <small class="text-muted"><?= $userdb['email']?></small>
                </div>
              </div>
            </a>
          </li>
          <!--<li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="/user/profile">
              <i class="ti ti-user-check me-2 ti-sm"></i>
              <span class="align-middle">My Profile</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="/user/api">
              <i class="ti ti-key me-2 ti-sm"></i>
              <span class="align-middle">API Keys</span>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="/help-center/">
              <i class="ti ti-lifebuoy me-2 ti-sm"></i>
              <span class="align-middle">Help</span>
            </a>
          </li>-->
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="/dashboard">
              <i class="ti ti-arrow-back-up me-2 ti-sm"></i>
              <span class="align-middle">Exit</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="/auth/logout">
              <i class="ti ti-logout me-2 ti-sm"></i>
              <span class="align-middle">Log Out</span>
            </a>
          </li>
        </ul>
      </li>
      <!--/ User -->
    </ul>
  </div>
</nav>