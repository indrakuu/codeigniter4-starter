<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?= $this->renderSection('title') .' - '.  config('app')->appName ?></title>
    <meta name="robots" content="noindex,nofollow" />
    <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>">
    <?= $this->renderSection('pageStyles') ?>
    <?= $this->include('admin/layouts/style') ?>
    
  </head>
  <body>
    <div class="preloader" style="background: rgba(0, 0, 0, 0.5);">
        <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
      <?= $this->include('admin/layouts/navbar') ?>
      <?= $this->include('admin/layouts/sidebar') ?> 
      <div class="page-wrapper">
        <?= $this->renderSection('main') ?>
        <footer class="footer text-center">
        <i class="far fa-copyright"></i>
        <?= date('Y')?> <b><a href="<?= config('app')->theme['footer']['vendorlink'] ?>"><?= config('app')->theme['footer']['vendorname'] ?></a></b>. All Rights Reserved 
        </footer>
      </div>
    </div>
    <?= $this->include('admin/layouts/script') ?>
    <?= $this->renderSection('pageScripts') ?>
  </body>
</html>