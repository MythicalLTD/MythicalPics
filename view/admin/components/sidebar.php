<?php
function is_active_page($page_urls)
{
    foreach ($page_urls as $page_url) {
        if (strpos($_SERVER['REQUEST_URI'], $page_url) !== false) {
            return true;
        }
    }
    return false;
}
?>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="/" class="app-brand-link">
      <span class="app-brand-text demo menu-text fw-bold">
        <?= $settings['app_name'] ?>
      </span>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">BASIC ADMINISTRATION</span>
    </li>
    <li class="menu-item">
      <a href="/admin" class="menu-link">
        <i class="menu-icon tf-icons ti ti-home"></i>
        <div>Overview</div>
      </a>
    </li>
    <li class="menu-item <?php echo is_active_page(['/admin/settings']) ? 'active' : ''; ?>">
      <a href="/admin/settings" class="menu-link">
        <i class="menu-icon tf-icons ti ti-settings"></i>
        <div>Settings</div>
      </a>
    </li>
    <li class="menu-item <?php echo is_active_page(['/admin/api']) ? 'active' : ''; ?>">
      <a href="/admin/api" class="menu-link">
        <i class="menu-icon tf-icons ti ti-device-gamepad-2"></i>
        <div>Application API</div>
      </a>
    </li>
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">MANAGEMENT</span>
    </li>
    <li class="menu-item <?php echo is_active_page(['/admin/domains']) ? 'active' : ''; ?>">
      <a href="/admin/domains" class="menu-link">
        <i class="menu-icon tf-icons ti ti-server-2"></i>
        <div>Domains</div>
      </a>
    </li>
    <li class="menu-item <?php echo is_active_page(['/admin/users']) ? 'active' : ''; ?>">
      <a href="/admin/users" class="menu-link">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div>Users</div>
      </a>
    </li>
    <li class="menu-item <?php echo is_active_page(['/admin/reports']) ? 'active' : ''; ?>">
      <a href="/admin/reports" class="menu-link">
        <i class="menu-icon tf-icons ti ti-flag"></i>
        <div>Reports (SOON)</div>
      </a>
    </li>
  </ul>
</aside>