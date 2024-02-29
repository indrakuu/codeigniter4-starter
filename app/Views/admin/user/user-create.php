<?= $this->extend('admin/layouts/app') ?>
<?= $this->section('title') ?>Create User<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?= $this->setData(compact('breadcrumb'))->include('admin/layouts/breadcumb') ?>
<div class="container-fluid">
  <?= view('admin\layouts\_message_block') ?>
  <div class="row">
      <div class="col-lg-12">
        <div class="card mb-4">
          <form action="<?= route_to('user.store') ?>" method="post" autocomplete="off">
            <div class="card-header">
              <h5 class="mb-0">Create User</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="fullname" class="col-md-3 mt-3">Full Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-md-3 mt-3">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="username" class="col-md-3 mt-3">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-md-3 mt-3">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="role" class="col-md-3 mt-3">Permission</label>
                    <div class="col-sm-9">                        
                        <select class="form-select select2" name="permission[]" multiple="multiple" style="width: 100%;">
                            <?php foreach ($permissions as $permission) { ?>
                                <option <?= in_array($permission['id'], old('permission', [])) ? 'selected' : '' ?> value="<?= $permission['id'] ?>"><?= $permission['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="role" class="col-md-3 mt-3">Role</label>
                    <div class="col-sm-9">                        
                        <select class="form-select select2" name="role[]" multiple="multiple" style="width: 100%;">
                            <?php foreach ($roles as $role) { ?>
                                <option <?= in_array($role->id, old('role', [])) ? 'selected' : '' ?> value="<?= $role->id ?>"><?= $role->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
              <div class="d-flex justify-content-between">
                <a href="<?= route_to('user.index') ?>" class="btn btn-sm btn-secondary">
                  <i class="fas fa-arrow-left me-2"></i>
                  Back
                </a>
                <button type="submit" class="btn btn-sm btn-primary">
                  <i class="fas fa-save me-2"></i>
                  Save Changes
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
  </div>
</div>
<?= $this->endSection() ?>
<?=$this->section('pageStyles')?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/libs/select2/dist/css/select2.min.css') ?>">
<?= $this->endSection() ?>

<?=$this->section('pageScripts')?>
<script src="<?= base_url('assets/libs/select2/dist/js/select2.min.js') ?>"></script>
<script>
    $(function(){
        $('.select2').select2({
            placeholder: "Select Options",
            allowClear: true
        });
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