<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
        <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
            <b class="logo-icon ps-2">
                <img  class="light-logo"  src="<?= config('app')->theme['logo']['brand']['icon'] ?>" width="<?= config('app')->theme['logo']['brand']['width'] ?>" alt="">
            </b>
            <span class="logo-text ms-2">
            <?= config('app')->theme['logo']['brand']['text'] ?>
            </span>
        </a>
        <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
            <i class="ti-menu ti-close"></i>
        </a>
        </div>
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
        <ul class="navbar-nav float-start me-auto">
            <li class="nav-item d-none d-lg-block">
                <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav float-end">
            <li class="nav-item dropdown">
                <span class="nav-link text-muted waves-effect waves-dark dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= user()->fullname ?>
                </span>
                <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?= url_to('profile') ?>">
                    <i class="fas fa-user-circle me-1 ms-1"></i> My Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= url_to('logout') ?>">
                        <i class="fa fa-power-off me-1 ms-1"></i> Logout
                    </a>
                </ul>
            </li>
        </ul>
        </div>
    </nav>
</header>