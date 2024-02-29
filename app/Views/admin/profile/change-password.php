<?= $this->extend('admin/layouts/app') ?>
<?= $this->section('title') ?>Change Password<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?= $this->setData(compact('breadcrumb'))->include('admin/layouts/breadcumb') ?>
<div class="container-fluid">
  <?= view('admin\layouts\_message_block') ?>
  <div class="row">
      <div class="col-lg-12">
        <div class="card mb-4">
          <form action="<?= route_to('profile.updatePassword') ?>" method="post">
            <div class="card-header">
              <h5 class="mb-0">Update Password</h5>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <label for="current_password" class="col-md-3 mt-3">Current Password</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password" required/>
                </div>
              </div>
              <div class="form-group row">
                <label for="new_password" class="col-md-3 mt-3">New Password</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required/>
                </div>
              </div>
              <div class="form-group row">
                <label for="confirm_password" class="col-md-3 mt-3">Confirm Password</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required/>
                </div>
              </div>
            </div>
            <div class="card-footer text-end">
              <div class="d-flex justify-content-between">
                <a href="<?= route_to('profile') ?>" class="btn btn-sm btn-secondary">
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
                  form[0].reset();
                },
                complete: function(){
                  normalizeForm(form);
                  form[0].reset();
                }
            });
        });
    });
</script>
<?=$this->endSection()?>