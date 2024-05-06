<?= $this->extend('admin/layouts/app') ?>
<?= $this->section('title') ?>User<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?= $this->setData(compact('breadcrumb'))->include('admin/layouts/breadcumb') ?>
<div class="container-fluid">
  <?= view('admin\layouts\_message_block') ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User List</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-lg-4">
                                <div>
                                    <label for="fullname" class="mt-3">Full Name</label>
                                    <input type="text" class="form-control" name="fullname" placeholder="Full Name Here">
                                </div>
                                <div>
                                    <label for="username" class="mt-3">Username</label>
                                    <input type="text" class="form-control" name="username" placeholder="Username Here">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label for="email" class="mt-3">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email Here">
                                </div>
                                <div>  
                                    <label class="mt-3">Member Since</label>
                                    <input type="text" class="form-control" id="datepicker-autoclose" placeholder="mm/dd/yyyy" name="created_at">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label class="mt-3">Action</label>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-search me-2"></i>
                                        Cari
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
                                <a href="<?= route_to('user.create') ?>" class="btn btn-sm btn-primary mt-3">
                                    <i class="fa fa-plus me-2"></i>
                                    Add User
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive pb-4">
                    <table id="user" class="table table-hover table-bordered " style="width:100%">
                        <thead>
                            <tr class="table-secondary">
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Member Since</th>
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
        table = $('#user').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "searching": false,
                "stateSave": true,
                "bDestroy": true,
                "order": [],
                "columnDefs": [ { targets: 0, orderable: false } ],
                "ajax": {
                    url: '<?= route_to('user.search')?>',
                    type: 'POST',
                    data: function(d){
                        d.username = $('input[name=username]').val();
                        d.fullname = $('input[name=fullname]').val();
                        d.email = $('input[name=email]').val();
                        d.created_at = $('input[name=created_at]').val();
                    },
                },
                columns: [
                    {data: 'id', render: function(data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }},
                    {data: 'fullname'},
                    {data: 'username'},
                    {data: 'email'},
                    {data: 'created_at'},
                    {data: 'action', orderable: false, searchable: false, width: '10%'}
                ]
            });
        
        $('form').submit(function(e){
            e.preventDefault();
            table.ajax.reload();
        });

        $('#reset').click(function(){
            $('input[name=username]').val('');
            $('input[name=email]').val('');
            $('input[name=fullname]').val('');
            $('#datepicker-autoclose').val('');
            $('#user').DataTable().ajax.reload();
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
                        url: '/dashboard/user/'+$(this).data('id')+'/delete',
                        type: 'DELETE',
                        success: function(){
                            $('#user').DataTable().ajax.reload();
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