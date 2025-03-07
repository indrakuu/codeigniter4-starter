<?= $this->extend('admin/layouts/app') ?>
<?= $this->section('title') ?>Role<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?= $this->setData(compact('breadcrumb'))->include('admin/layouts/breadcumb') ?>
<div class="container-fluid">
  <?= view('admin/layouts/_message_block') ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Role List</h4>
                </div>
                <div class="card-body">
                    <form id="search">
                        <div class="row">
                            <div class="col-lg-8">
                                <div>
                                    <label for="role" class="mt-3">Role Name</label>
                                    <input type="text" class="form-control" name="role" placeholder="Role Name Here">
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
                                <a href="<?= url_to('role.create') ?>" class="btn btn-sm btn-primary mt-3">
                                    <i class="fa fa-plus me-2"></i>
                                    Add Role
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive pb-4">
                    <table id="table" class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr class="table-secondary">
                                <th>#</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('pageStyles')?>
<link href="<?= base_url('assets/lib/datatables/dataTables.min.css') ?>" rel="stylesheet">

<?= $this->endSection()?>


<?=$this->section('pageScripts')?>
<script src="<?= base_url('assets/lib/datatables/datatables.min.js') ?>"></script>
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
                    url: '<?= route_to('role.search')?>',
                    type: 'POST',
                    data: function(d){
                        d.role = $('input[name=role]').val();
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
            $('input[name=role]').val('');
            table.ajax.reload();
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
                        url: '/dashboard/role/'+$(this).data('id')+'/delete',
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