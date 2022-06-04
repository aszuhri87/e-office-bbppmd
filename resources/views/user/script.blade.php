<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {
            $(document).on('click', '#add_button', function(event){
                event.preventDefault();

                $('#form_user').trigger("reset");
                $('#form_user').attr('action','{{url('user')}}');
                $('#form_user').attr('method','POST');

                showModal('modal_user');
            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();

                var user = UserTable.table().row($(this).parents('tr')).data();

                $('#form_user').trigger("reset");
                $('#form_user').attr('action', $(this).attr('href'));
                $('#form_user').attr('method','PUT');

                $('#form_user').find('input[name="name"]').val(user.name);
                $('#form_user').find('input[name="email"]').val(user.email);

                showModal('modal_user');
            });

            $(document).on('click', '.btn-delete', function(event){
                event.preventDefault();
                var url = $(this).attr('href');

                Swal.fire({
                    title: 'Hapus Pengguna?',
                    text: "Pengguna yang akan anda Hapus akan hilang permanen!",
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
                            UserTable.table().draw(false);
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
            $('#form_user').submit(function(event){
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    UserTable.table().draw(false);
                    hideModal('modal_user');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
