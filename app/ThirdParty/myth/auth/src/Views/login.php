<?= $this->extend($config->viewLayout) ?>
<?= $this->section('title') ?><?=lang('Auth.loginTitle')?> <?= $this->endSection() ?>
<?= $this->section('main') ?>
<div class="card col-12 col-md-5 shadow-sm mx-auto mt-4">
    <div class="card-body">
        <h5 class="card-title mb-4 text-center"><?=lang('Auth.loginTitle')?></h5>
        <?= view('Myth\Auth\Views\_message_block') ?>
        <form action="<?= url_to('login') ?>" method="post" autocomplete="off">
            <?= csrf_field() ?>
            <?php if ($config->validFields === ['email']): ?>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                    <label for="login"><?= lang('Auth.email') ?></label>
                </div>
            <?php elseif ($config->validFields === ['username']): ?>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="login" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required>
                    <label for="login"><?= lang('Auth.username') ?></label>
                </div>
            <?php else : ?>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="login" placeholder="<?=lang('Auth.emailOrUsername')?>" value="<?= old('username') ?>" required>
                    <label for="login"><?=lang('Auth.emailOrUsername')?></label>
                </div>
            <?php endif ?>
            <div class="form-floating mb-3">
                <input type="password" class="form-control"name="password" placeholder="<?= lang('Auth.password') ?>" required>
                <label for="login"><?= lang('Auth.password') ?></label>
            </div>
            <?php if ($config->allowRemembering): ?>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')): ?> checked<?php endif ?>>
                        <?= lang('Auth.rememberMe') ?>
                    </label>
                </div>
            <?php endif; ?>
            <div class="d-grid col-12 col-md-8 mx-auto m-3">
                <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.loginAction') ?></button>
            </div>
            <?php if ($config->activeResetter) : ?>
                <p class="text-center"><?= lang('Auth.forgotYourPassword') ?> <a href="<?= url_to('forgot') ?>">Reset Here</a></p>
            <?php endif ?>
            <?php if ($config->allowRegistration) : ?>
                <p class="text-center"><?= lang('Auth.needAnAccount') ?> <a href="<?= url_to('register') ?>">Register</a></p>
            <?php endif ?>
            <p class="text-center"><a href="<?= url_to('/') ?>">Back to home</a></p>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
<?=$this->section('pageScripts')?>
<script>
    $(function(){
        $('form').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();
            var _token = form.find('input[name="_token"]').val();

            function normalizeForm(){
                form.find('button').attr('disabled', false);
                form.find('input').attr('disabled', false);
                form.find('button').html('<?php echo lang('Auth.loginAction'); ?>');
                $(".preloader").fadeOut();
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                _token: _token,
                beforeSend: function(){
                    form.find('button').attr('disabled', true);
                    form.find('input').attr('disabled', true);
                    form.find('button').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                    $(".preloader").fadeIn();
                },
                success: function(response){
                    if(response.status == 'success'){
                        toastr["success"]("Login successful", 'Success');
                        setTimeout(function(){
                            window.location.href = response.redirect;
                        }, 1000);
                    }else{
                        error = response.errors;
                        if(typeof error === 'object'){
                            var errors = '<ul>';
                            $.each(error, function(key, value){
                                errors += '<li>'+value+'</li>';
                            });
                            errors += '</ul>';
                            toastr["error"](errors, 'Error');
                        }else{
                            toastr["error"](error, 'Error');
                        }
                    }
                },
                error: function(response){
                    if(response.status == 500){
                        toastr["error"]('Whoops! Something went wrong', 'Error');
                    }else{
                        toastr["error"](response.responseJSON.errors, 'Error');
                    }
                    normalizeForm();
                },
                complete: function(){
                    normalizeForm();
                }
            });
        });
    });
</script>
<?=$this->endSection()?>