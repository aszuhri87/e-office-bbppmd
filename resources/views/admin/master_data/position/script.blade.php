<script type="text/javascript">

    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {
            $(document).on('click','#create-position-modal', function(event){
                event.preventDefault();
                $('#form-position').trigger("reset");
                $('#form-position').attr('action','{{url('admin/position')}}');
                $('#form-position').attr('method','POST');
                $('#modal-position').modal('show');

            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();

                var data = PositionTable.table().row($(this).parents('tr')).data();

                $('#form-position').trigger("reset");
                $('#form-position').attr('action', $(this).attr('href'));
                $('#form-position').attr('method','PUT');
                $('#form-position').find('input[name="name"]').val(data.name);
                $('#form-position').find('input[name="level"]').val(data.level);

                showModal('modal-position');
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
                            PositionTable.table().draw(false);
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
            $('#form-position').submit(function(event){
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    PositionTable.table().draw(false);
                    hideModal('modal-position');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
