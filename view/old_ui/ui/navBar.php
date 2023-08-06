<?php $current_url = $_SERVER['REQUEST_URI'];?>
<header class="navbar-expand-md">
      <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
          <div class="container-xl">
            <ul class="navbar-nav">
              <li class="nav-item <?php 
              if ($current_url == "/dashboard") {
                echo "active";
              }
              ?>">
                <a class="nav-link" href="/dashboard">
                  <span
                    class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo-check" width="24"
                      height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                      stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M15 8h.01"></path>
                      <path d="M11.5 21h-5.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v7"></path>
                      <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l4 4"></path>
                      <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l.5 .5"></path>
                      <path d="M15 19l2 2l4 -4"></path>
                    </svg>
                  </span>
                  <span class="nav-link-title">
                    Images
                  </span>
                </a>
              </li>
              <li class="nav-item <?php 
              if ($current_url == "/config") {
                echo "active";
              }
              else
              {
                
              }
              ?>">
                <a class="nav-link" href="/config">
                  <span
                    class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                      stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                      <path d="M12 12l8 -4.5" />
                      <path d="M12 12l0 9" />
                      <path d="M12 12l-8 -4.5" />
                      <path d="M16 5.25l-8 4.5" />
                    </svg>
                  </span>
                  <span class="nav-link-title">
                    Embed Config
                  </span>
                </a>
              </li>
              <li class="nav-item <?php
              if ($current_url == "/domains" || $current_url == "/domain/add")
              {
                echo "active";
              }
              else
              {
                echo "";
              }
              ?>">
                <a class="nav-link" href="/domains">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cloud" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path
                      d="M6.657 18c-2.572 0 -4.657 -2.007 -4.657 -4.483c0 -2.475 2.085 -4.482 4.657 -4.482c.393 -1.762 1.794 -3.2 3.675 -3.773c1.88 -.572 3.956 -.193 5.444 1c1.488 1.19 2.162 3.007 1.77 4.769h.99c1.913 0 3.464 1.56 3.464 3.486c0 1.927 -1.551 3.487 -3.465 3.487h-11.878">
                    </path>
                  </svg>
                  <span class="nav-link-title">
                    &nbsp; Custom Domain
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
</header>