<?= $this->extend('admin/layouts/app') ?>
<?= $this->section('title') ?>Menu<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?= $this->setData(compact('breadcrumb'))->include('admin/layouts/breadcumb') ?>
<style>.fade.in{opacity: 1;}</style>
<div class="container-fluid">
  <?= view('admin\layouts\_message_block') ?>
  <div class="row">
    <div class="col-lg-6">
      <div class="card mb-4">
      <form id="createMenu" action="<?= route_to('menu.store') ?>" method="post">
        <div class="card-header">
          <h5 class="mb-0">Menu</h5>
        </div>
        <div class="card-body">
          <div class="form-group row">
            <label for="email" class="col-md-3 mt-3">Icon</label>
            <div class="col-sm-9">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text h-100"><i class="fab fa-font-awesome-flag"></i></span>
                </div>
                <input type="text" name="icon" class="icon-picker form-control" value="" placeholder="Icon from fontawesome" autocomplete="off">
              </div>
              <span class="help-block">
                  <i class="fa fa-info-circle text-info me-2"></i>For more icons, please see <a href="http://fontawesome.io/icons" target="_blank">http://fontawesome.io/icons</a>
              </span>
            </div>
          </div>
          <div class="form-group row">
            <label for="email" class="col-md-3 mt-3">Name</label>
            <div class="col-sm-9">
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text h-100"><i class="fas fa-pencil-alt"></i></span>
                  </div>
                  <input type="text" name="title" class="form-control" placeholder="Name" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="email" class="col-md-3 mt-3">Route</label>
            <div class="col-sm-9">
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text h-100"><i class="fas fa-link"></i></span>
                  </div>
                  <input type="text" name="route" class="form-control" placeholder="Route" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="role" class="col-md-3 mt-3">Role</label>
            <div class="col-sm-9">
              <select multiple="multiple" class="form-control select2" name="groups_menu[]" data-placeholder="Role" style="width: 100%;">
                <?php foreach ($roles as $role) { ?>
                    <option <?= in_array($role->id, old('groups_menu', [])) ? 'selected' : '' ?> value="<?= $role->id ?>"><?= $role->name ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="card-footer text-end">
          <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save me-2"></i> Save Changes</button>
        </div>
      </form>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card mb-4">
        <div id="nestable-menu" class="card-header d-flex justify-content-between align-items-center">
          <div>
            <h5 class="mb-0">List Menu</h5>
          </div>
          <div>
            <div class="btn-group">
              <button class="btn btn-info btn-sm tree-tools" data-action="expand" title="Expand">
                  <i class="fas fa-chevron-down me-1"></i> Expand
              </button>
              <button class="btn btn-info btn-sm tree-tools" data-action="collapse" title="Collapse">
                  <i class="fas fa-chevron-up me-1"></i>Collapse
              </button>
            </div>
            <div class="btn-group">
                <button class="btn btn-primary btn-sm save" data-action="save" title="Save">
                  <i class="fa fa-save me-1"></i> Save Changes</span></button>
            </div>
            <div class="btn-group">
                <button class="btn btn-warning btn-sm refresh" data-action="refresh" title="Refresh">
                  <i class="fas fa-sync-alt me-1"></i>Refresh</span></button>
            </div>
          </div>
        </div>
        <div class="card-body" style="max-height: 500px; overflow-y: scroll;">
            <div class="dd" id="menu"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->include('admin/menu/menu-modal') ?>
<?= $this->endSection() ?>
<?=$this->section('pageStyles')?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/lib/select2/dist/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/lib/fontawesome-iconpicker/css/fontawesome-iconpicker.min.css') ?>">
<style>
    .dd{position:relative;display:block;margin:0;padding:0;list-style:none;font-size:13px;line-height:20px}.dd-list{display:block;position:relative;margin:0;padding:0;list-style:none}.dd-list .dd-list{padding-left:30px}.dd-empty,.dd-item,.dd-placeholder{display:block;position:relative;margin:0;padding:0;min-height:20px;font-size:13px;line-height:20px}.dd-handle{display:block;height:35px;margin:5px 0;padding:5px 10px;color:#333;text-decoration:none;font-weight:700;border:1px solid #ccc;background:#fff;border-radius:3px;box-sizing:border-box}.dd-handle:hover{color:#2ea8e5;background:#fff}.dd-item>button{position:relative;cursor:pointer;float:left;width:25px;height:20px;margin:5px 0;padding:0;text-indent:100%;white-space:nowrap;overflow:hidden;border:0;background:0 0;font-size:12px;line-height:1;text-align:center;font-weight:700}.dd-item>button:before{display:block;position:absolute;width:100%;text-align:center;text-indent:0}.dd-item>button.dd-expand:before{content:'+'}.dd-item>button.dd-collapse:before{content:'-'}.dd-expand{display:none}.dd-collapsed .dd-collapse,.dd-collapsed .dd-list{display:none}.dd-collapsed .dd-expand{display:block}.dd-empty,.dd-placeholder{margin:5px 0;padding:0;min-height:30px;background:#f2fbff;border:1px dashed #b6bcbf;box-sizing:border-box;-moz-box-sizing:border-box}.dd-empty{border:1px dashed #bbb;min-height:100px;background-color:#e5e5e5;background-size:60px 60px;background-position:0 0,30px 30px}.dd-dragel{position:absolute;pointer-events:none;z-index:9999}.dd-dragel>.dd-item .dd-handle{margin-top:0}.dd-dragel .dd-handle{box-shadow:2px 4px 6px 0 rgba(0,0,0,.1)}.dd-nochildren .dd-placeholder{display:none}
</style>
<?= $this->endSection() ?>

<?=$this->section('pageScripts')?>
<script src="<?= base_url('assets/lib/jquery-nestable/jquery.nestable.min.js') ?>"></script>
<script src="<?= base_url('assets/lib/select2/dist/js/select2.min.js') ?>"></script>
<script src="<?=base_url('assets/lib/fontawesome-iconpicker/js/fontawesome-iconpicker.min.js')?>"></script>

<script>
  $(function () {
    $('.icon-picker').iconpicker({
      placement: 'bottomRight',
      hideOnSelect: true,
      inputSearch: true,
    });
    $('.select2').select2({ placeholder: "Select Options"});

    menu();

    function menu() {
      $.get("<?= base_url('dashboard/menu') ?>", function(response) {
          $('.dd').nestable({
            maxDepth: 2,
            json: response.data,
            contentCallback: (item) => {
              return `<div class="d-flex justify-content-between"><span><i class="${item.icon} me-2"></i><strong class="me-4">${item.title}</strong><a href="<?= base_url() ?>${item.route}" class="dd-nodrag">${item.route}</a></span><span class="dd-nodrag"><button data-id="${item.id}" id="btn-edit" class="btn btn-primary btn-xs"><span class="fa fa-edit"></span></button><button data-id="${item.id}" id="btn-delete" class="btn btn-danger btn-xs"><span class="fa fa-fw fa-trash"></span></button></span></div>`;
              }
          });
      });
    }

    $('.tree-tools').on('click', function(e) {
        var action = $(this).data('action');
        if (action === 'expand') { $('.dd').nestable('expandAll'); }
        if (action === 'collapse') { $('.dd').nestable('collapseAll'); }
    });

    $('#createMenu').submit(function (e) {
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
              form.find('select').attr('disabled', true);
            },
            success: function(response){
              if(response.status == 'success'){
                toastr["success"](response.message, 'Success');
                $('.dd').nestable('destroy');
                  menu();
                  form.trigger('reset');                      
                  $(".select2").val('').trigger('change')
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
              form.find('select').attr('disabled', false);
            },
            complete: function(){
              normalizeForm(form);
              form.find('select').attr('disabled', false);
            }
        });
    });


    $(document).on('click', '#btn-edit', function(e) {
      e.preventDefault();
      $.ajax({
        url: `<?= base_url('dashboard/menu') ?>/${$(this).attr('data-id')}`,
          method: 'GET',
          dataType: 'JSON',
        }).done((response) => {        
          if(response.status == 'success') {
            res = response.messages
            $('#active').select2();
            $('#groups_menu').select2({ data: res.roles });
            var form = $('#form-edit');
            var group_id = res.data.group_id;
            var group = group_id.split('|');
            var parent_id = res.data.parent_id == 0 ? 0 : res.data.parent_id;
            form.find('select[name="active"]').val(res.data.active).change();
            form.find('select[name="parent_id"]').val(parent_id).change();
            form.find('select[name="groups_menu[]"]').val(group).change();
            form.find('input[name="icon"]').val(res.data.icon);
            form.find('input[name="icon"]').val(res.data.icon);
            form.find('input[name="title"]').val(res.data.title);
            form.find('input[name="route"]').val(res.data.route);
            $("#menu_id").val(res.data.id);
            $('#modal-update').modal('show');
          }else if(response.status == 'error'){
            toastr["error"](response.errors, 'Error');
          }
        }).fail((jqXHR, textStatus, errorThrown) => {
          toastr["error"](jqXHR.responseJSON.messages.error, 'Error');
        })
    });


    $(document).on('click', '#btn-update', function(e) {
        e.preventDefault();
        var form = $('#form-edit');
        var data = form.serialize();

        $.ajax({
            url: `<?= base_url('dashboard/menu') ?>/${ $('#menu_id').val() }`,
            method: 'POST',
            data: data,
            beforeSend: function(){
              loadingForm(form);
            },
            success: function(response){
              if(response.status =='success'){
                toastr["success"](response.message, 'Success');
                $('.dd').nestable('destroy');
                menu();
                $("#form-edit").trigger("reset");
                $("#modal-update").modal('hide');
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
        })
    });

    $(document).on('click', '#btn-delete', function(e) {
      e.preventDefault();
      swalWithBootstrapButtons.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: false,
        showCancelButton: true,
        preConfirm: () => {
            return $.ajax({
                url: '/dashboard/menu/'+$(this).data('id'),
                type: 'DELETE',
                success: function(){
                  $('.dd').nestable('destroy');
                  menu();
                  setTimeout(function(){
                    window.location.href = response.redirect;
                  }, 1000);
                }
            })
            .then(response => { return response })
                .catch(error => { Swal.showValidationMessage(error.responseJSON.message); })
        },
        allowOutsideClick: () => !Swal.isLoading(),
      }).then((result) => {
        if (result.isConfirmed) {
          swalWithBootstrapButtons.fire({
            title: "Deleted!",
            text: "Your file has been deleted.",
            icon: "success"
          });
        }
      });
    });

    $(document).on('click', '.save', function(e) { 
      e.preventDefault();
      var serialize = $('#menu').nestable('toArray');
      var form = $(this);

      $.ajax({
        url: `<?= route_to('menu.list') ?>`,
        method: 'POST',
        dataType: 'JSON',
        data: JSON.stringify(serialize),
        beforeSend: function(){
          loadingForm(form);
        },
        success: function(response){
          if(response.status =='success'){
            toastr["success"](response.message, 'Success');
            $('.dd').nestable('destroy');
            menu();
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
      }) 
    });

    $('#modal-update').on('hidden.bs.modal', function() {
        $('#form-edit').trigger('reset');
    });

    $(document).on('click', '.refresh', function(e) { 
        location.reload(true);
    });
  });
</script>

<?=$this->endSection()?>