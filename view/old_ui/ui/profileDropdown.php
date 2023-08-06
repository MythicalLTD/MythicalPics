<div class="navbar-nav flex-row order-md-last">
    <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
            <span class="avatar avatar-sm" style="background-image: url('<?= $userdb['avatar'] ?>')"></span>
            <div class="d-none d-xl-block ps-2">
                <div>
                    <?php echo $usrname ?>
                </div>

            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <?php 
                if ($userdb['admin'] == "true")
                {
                    echo '<a href="/admin" class="dropdown-item">Admin</a>';
                }
                ?>
                <a href="/auth/logout" class="dropdown-item">Logout</a>
        </div>
    </div>
</div>