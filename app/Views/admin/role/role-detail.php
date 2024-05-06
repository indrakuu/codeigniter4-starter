<?= $this->extend('admin/layouts/app') ?>
<?= $this->section('title') ?>Detail Role<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?= $this->setData(compact('breadcrumb'))->include('admin/layouts/breadcumb') ?>
<div class="container-fluid">
  <?= view('admin\layouts\_message_block') ?>
  <div class="row">
      <div class="col-lg-12">
        <div class="card mb-4">
          <form action="<?= route_to('role.update', $data->id) ?>" method="post" autocomplete="off">
            <div class="card-header">
              <h5 class="mb-0">Detail Role</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-md-3 mt-3">Role Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Role Name" value="<?= $data->name ?>" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-md-3 mt-3">Description</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="description" id="description" cols="30" rows="5" required><?= $data->description ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-md-3 mt-3">Permission</label>
                    <div class="col-sm-9">
                        <select multiple="multiple" size="10" name="permission[]" title="permission[]">
                            <?php foreach ($permissions as $value) { ?>
                                <?php if (array_key_exists($value['id'], $permission)) { ?>
                                    <option value="<?= $value['id'] ?>" selected><?= $value['name'] ?></option>
                                <?php } else { ?>
                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>                
            </div>
            <div class="card-footer text-end">
              <div class="d-flex justify-content-between">
                <a href="<?= route_to('role.index') ?>" class="btn btn-sm btn-secondary">
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
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/lib/bootstrap-duallistbox/bootstrap-duallistbox.css') ?>">
<?= $this->endSection() ?>

<?=$this->section('pageScripts')?>
<script src="<?= base_url('assets/lib/bootstrap-duallistbox/jquery.bootstrap-duallistbox.js')?>"></script>
<script>
    $(function(){
        $('select[name="permission[]"]').bootstrapDualListbox();
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