<?= $this->extend('admin/layouts/app') ?>
<?= $this->section('title') ?>Profile<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?= $this->setData(compact('breadcrumb'))->include('admin/layouts/breadcumb') ?>
<div class="container-fluid">
  <?= view('admin\layouts\_message_block') ?>
  <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="<?= base_url('assets/images/users/1.jpg')?>" alt="avatar" class="rounded-circle img-fluid" style="width: 100px;">
            <h5 class="my-3"><?= user()->fullname ?></h5>
            <p class="text-muted mb-4"><?= user()->username ?></p>
            <hr>
            <div class="d-flex justify-content-between">
                <p class="mb-0">Member Since</p>
                <p class="text-muted mb-0"><?= user()->created_at->format('l, d F Y') ?></p>
            </div>
            <hr>
          </div>
        </div>
        <div class="card mb-4 mb-lg-0">
          <div class="card-body p-0">
            <ul class="list-group list-group-flush rounded-3">
              <li class="list-group-item  p-3">
                <a href="<?= route_to('profile.changePassword') ?>" class="btn btn-success btn-sm w-100 text-white">
                  <i class="fas fa-key me-2"></i>
                  Change Password
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
        <form action="<?= route_to('profile.updateProfile') ?>" method="post">
          <div class="card-header">
            <h5 class="mb-0">Profile Details</h5>
          </div>
          <div class="card-body">
            <div class="form-group row">
              <label for="fullname" class="col-md-3 mt-3">Full Name</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="fullname" placeholder="Full Name" name="fullname" value="<?= user()->fullname?>"/>
              </div>
            </div>
            <div class="form-group row">
              <label for="username" class="col-md-3 mt-3">Username</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="<?= user()->username ?>" required/>
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-md-3 mt-3">Email</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?= user()->email ?>" required/>
              </div>
            </div>
          </div>
          <div class="card-footer text-end">
            <button type="submit" class="btn btn-sm btn-primary">
              <i class="fas fa-save me-2"></i>
              Save Changes
            </button>
          </div>
        </form>
        </div>
      </div>
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

        $.ajax({
          url: url,
          type: 'POST',
          data: data,
          beforeSend: function(){
            loadingForm(form);
          },
          success: function(response){
            if(response.status == 'success'){
              toastr["success"](response.message, 'Success');
              setTimeout(function(){
                  window.location.href = response.redirect;
              }, 1000);
            }else{
              error = response.errors;
              if(typeof error === 'object'){
                var errors = '<ul>';
                $.each(error, function(key, value){ errors += '<li>'+value+'</li>'; });
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
            normalizeForm(form);
          },
          complete: function(){
            normalizeForm(form);
          }
        });
      });
    });
</script>
<?=$this->endSection()?>