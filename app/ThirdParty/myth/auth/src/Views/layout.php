<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="noindex,nofollow" />
        <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>">
        <title><?= $this->renderSection('title') .' - '.  config('app')->appName ?></title>
        <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/images/favicon.png')?>"/>
        <link href="<?= base_url('dist/css/style.min.css')?>" rel="stylesheet" />
        <style>
            body { padding-top: 5rem; }
        </style>
        <?= $this->renderSection('pageStyles') ?>
    </head>
    <body class="bg-secondary">
        <div class="preloader" style="background: rgba(0, 0, 0, 0.5);">
            <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
            </div>
        </div>
        <main role="main" class="container">
            <div class="container p-5">
                <div class="text-center">
                    <img src="<?= config('app')->theme['logo']['brand']['icon'] ?>" class="img-fluid" style="width: 100px; color: #dd4814;" alt="logo">
                </div>
                <?= $this->renderSection('main') ?>
            </div>
        </main>
        <script src="<?= base_url('assets/libs/jquery/dist/jquery.min.js')?>"></script>
        <script src="<?= base_url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')?>"></script>
        <script src="<?= base_url('assets/libs/toastr/build/toastr.min.js') ?>"></script>
        <link rel="stylesheet" href="<?= base_url('assets/libs/toastr/build/toastr.min.css') ?>">
        <script>
            $(".preloader").fadeOut();
            toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
        </script>
        <?= $this->renderSection('pageScripts') ?>
    </body>
</html>
