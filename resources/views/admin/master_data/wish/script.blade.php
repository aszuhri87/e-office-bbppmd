<script type="text/javascript">

    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {

            $('#btn-save').click(function() {
                $.blockUI({
                    message:
                    '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Mohon Tunggu...</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                    css: {
                    backgroundColor: 'transparent',
                    color: '#fff',
                    border: '0'
                    },
                    overlayCSS: {
                    opacity: 0.5
                    },
                    timeout: 1000,
                });

                // setTimeout($.unblockUI, 2100);
            });

            $(document).on('click','#create-wish-modal', function(event){
                event.preventDefault();
                $('#form-wish').trigger("reset");
                $('#form-wish').attr('action','{{url('admin/wish')}}');
                $('#form-wish').attr('method','POST');
                $('#modal-wish').modal('show');

            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();

                var data = WishTable.table().row($(this).parents('tr')).data();

                $('#form-wish').trigger("reset");
                $('#form-wish').attr('action', $(this).attr('href'));
                $('#form-wish').attr('method','PUT');
                $('#form-wish').find('input[name="name"]').val(data.name);
                $('#form-wish').find('textarea[name="description"]').val(data.description);

                showModal('modal-wish');
            });

            $(document).on('click', '.btn-delete', function(event){
                event.preventDefault();
                var url = $(this).attr('href');

                Swal.fire({
                    title: 'Hapus data?',
                    text: "Data yang akan anda Hapus akan hilang permanen!",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal!"
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            dataType: 'json',
                        })
                        .done(function(res, xhr, meta) {
                            toastr.success(res.message, 'Success')
                            WishTable.table().draw(false);
                        })
                        .fail(function(res, error) {
                            toastr.error(res.responseJSON.message, 'Gagal')
                        })
                        .always(function() { });
                    }
                })
            });
        },
        formSubmit = () => {
            $('#form-wish').submit(function(event){
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    WishTable.table().draw(false);
                    hideModal('modal-wish');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
