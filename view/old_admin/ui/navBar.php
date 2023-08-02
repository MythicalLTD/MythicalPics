<?php $current_url = $_SERVER['REQUEST_URI'];
$isUsersPage = (strpos($current_url, "/oldadmin/users") !== false);
$isSearchPage = (strpos($current_url, "/oldadmin/users") !== false && !empty($search));

$isDomainsPage = (strpos($current_url, "/oldadmin/domains") !== false);
$isDomainsSearchPage = (strpos($current_url, "/oldadmin/domains") !== false && !empty($search));
?>

<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">BASIC ADMINISTRATION</li>
            <li class="<?php
            if ($current_url == "/oldadmin") {
                echo 'active';
            }
            ?>">
                <a href="/oldadmin">
                    <i class="fa fa-home"></i> <span>Overview</span>
                </a>
            </li>
            <li class="<?php
            if ($current_url == "/oldadmin/settings" || $current_url == "/oldadmin/settings/mail" || $current_url == "/oldadmin/settings/advanced") {
                echo 'active';
            }
            ?>">
                <a href="/oldadmin/settings">
                    <i class="fa fa-wrench"></i> <span>Settings</span>
                </a> 
            </li>
            <li class="<?php
            if ($current_url == "/oldadmin/api" || $current_url == "/oldadmin/api/new") {
                echo 'active';
            }
            ?>">
                <a href="/oldadmin/api">
                    <i class="fa fa-gamepad"></i> <span>Application API</span>
                </a>
            </li>
            <li class="header">MANAGEMENT</li>
            <li class="<?= ($isDomainsPage || $isDomainsSearchPage) ? 'active' : '' ?>">
                <a href="/admin/domains">
                    <i class="fa fa-server"></i> <span>Domains</span>
                </a>
            </li>
            <li class="<?= ($isUsersPage || $isSearchPage) ? 'active' : '' ?>">
                <a href="/oldadmin/users">
                    <i class="fa fa-users"></i> <span>Users</span>
                </a>
            </li>
        </ul>
    </section>
</aside>