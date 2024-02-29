<script src="<?= base_url('assets/libs/jquery/dist/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')?>"></script>
<script src="<?= base_url('/dist/js/sidebarmenu.js') ?>"></script>
<script src="<?= base_url('dist/js/custom.min.js')?>"></script>
<script src="<?= base_url('assets/libs/toastr/build/toastr.min.js') ?>"></script>
<script src="<?= base_url('assets/libs/sweetalert2/sweetalert2.js') ?>"></script>
<script>
        $(".preloader").fadeOut();
        toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
        }
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
                confirmButton: "btn btn-success me-3 text-white",
                cancelButton: "btn btn-danger"
        },
        buttonsStyling: false,
        allowOutsideClick: () => !Swal.isLoading()
        });

        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-') 
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
        }

        function loadingForm(form){
                form.find('button').attr('disabled', true);
                form.find('input').attr('disabled', true);
                form.find('button').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                $(".preloader").fadeIn();
        }

        function normalizeForm(form){
                form.find('button').attr('disabled', false);
                form.find('input').attr('disabled', false);
                form.find('button').html('<i class="fas fa-save me-2"></i> Save Changes');
                $(".preloader").fadeOut();
        }
</script>