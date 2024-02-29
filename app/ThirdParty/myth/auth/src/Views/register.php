<?= $this->extend($config->viewLayout) ?>
<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>
<?= $this->section('main') ?>
<div class="card col-12 col-md-5 shadow-sm mx-auto mt-4">
    <div class="card-body">
        <h5 class="card-title mb-4 text-center"><?= lang('Auth.register') ?></h5>
        <?= view('Myth\Auth\Views\_message_block') ?>
        <form action="<?= url_to('register') ?>" method="post" autocomplete="off">
            <?= csrf_field() ?>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="fullname" placeholder="<?= lang('Auth.fullname') ?>" value="<?= old('fullname') ?>" required>
                <label for="fullname"><?= lang('Auth.fullname') ?></label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                <label for="email"><?= lang('Auth.email') ?></label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required>
                <label for="username"><?= lang('Auth.username') ?></label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" name="password" placeholder="<?= lang('Auth.password') ?>" required>
                <label for="password"><?= lang('Auth.password') ?></label>
            </div>
            <div class="form-floating mb-5">
                <input type="password" class="form-control" name="pass_confirm" placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
                <label for="pass_confirm"><?= lang('Auth.repeatPassword') ?></label>
            </div>

            <div class="d-grid col-12 col-md-8 mx-auto m-3">
                <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
            </div>

            <p class="text-center"><?= lang('Auth.alreadyRegistered') ?> <a href="<?= url_to('login') ?>"><?= lang('Auth.signIn') ?></a></p>
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
                form.find('button').html('<?php echo lang('Auth.register'); ?>');
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
                        toastr["success"]("<?= lang('Auth.registerSuccess') ?>", 'Success');
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

