<?= $this->extend('admin/layouts/app') ?>
<?= $this->section('title') ?>Permission<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?= $this->setData(compact('breadcrumb'))->include('admin/layouts/breadcumb') ?>
<div class="container-fluid">
  <?= view('admin\layouts\_message_block') ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Permission List</h4>
                </div>
                <div class="card-body">
                    <form id="search">
                        <div class="row">
                            <div class="col-lg-8">
                                <div>
                                    <label for="permission" class="mt-3">Permission Name</label>
                                    <input type="text" class="form-control" name="permission" placeholder="Permission Name Here">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label class="mt-3">Action</label>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-search me-2"></i>
                                        Search
                                    </button>
                                    <button id="reset" class="btn btn-sm btn-warning">
                                        <i class="fas fa-redo me-2"></i>
                                        Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-end">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#openModal" class="btn btn-sm btn-primary mt-3">
                                    <i class="fa fa-plus me-2"></i>
                                    Add Permissions
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive pb-4">
                    <table id="table" class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr class="table-secondary">
                                <th>#</th>
                                <th>Permission</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('admin/permission/permission-modal') ?>
<?= $this->endSection() ?>

<?= $this->section('pageStyles')?>
<link href="<?= base_url('assets/lib/datatables/dataTables.min.css') ?>" rel="stylesheet">
<?= $this->endSection()?>


<?=$this->section('pageScripts')?>
<script src="<?= base_url('assets/lib/dataTables/datatables.min.js') ?>"></script>
<script>
    $(document).ready(function(){
        table = $('#table').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "searching": false,
                "stateSave": true,
                "bDestroy": true,
                "order": [],
                "columnDefs": [ { targets: 0, orderable: false } ],
                "ajax": {
                    url: '<?= route_to('permission.search')?>',
                    type: 'POST',
                    data: function(d){
                        d.permission = $('input[name=permission]').val();
                    },
                },
                columns: [
                    {data: 'id', render: function(data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }, width: '5%'},
                    {data: 'name'},
                    {data: 'action', orderable: false, searchable: false, width: '10%'}
                ]
            });

        $('#search').submit(function(e){
            e.preventDefault();
            table.ajax.reload();
        });

        $('#reset').click(function(){
            $('input[name=permission]').val('');
            table.ajax.reload();
        });

        $('#saveForm').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var data = {
                id: form.find('input[name=id]').val(),
                name: slugify(form.find('input[name=name]').val()),
                description: form.find('textarea[name=description]').val(),
            };

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
                        table.ajax.reload();
                        
                        form[0].reset();
                        $('#openModal').find('input[name=id]').val('');  
                        $('#openModal').modal('hide');
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
 
        $(document).on('click', '#edit', function(e){
            var form = $('#openModal');
            form.modal('show');
            form.find('.modal-title').text('Edit Permission');
            $.ajax({
                url: '/dashboard/permission/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    var data = response.message;
                    form.find('input[name=id]').val(data.id);
                    form.find('input[name=name]').val(data.name);
                    form.find('textarea[name=description]').val(data.description);
                }
            });
        });

        $(document).on('click', '#close', function(e){
            e.preventDefault();
            var form = $('#openModal');
            form.modal('hide');
            form.find('.modal-title').text('Create Permission');
            form.find('input[name=id]').val('');  
            $('#saveForm').trigger('reset');

        });

        $(document).on('click', '#delete', function(e){
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
                        url: '/dashboard/permission/'+$(this).data('id')+'/delete',
                        type: 'DELETE',
                        success: function(){
                            table.ajax.reload();
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
    });
</script>
<?=$this->endSection()?>