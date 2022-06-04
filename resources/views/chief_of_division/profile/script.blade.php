<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            $('#change-profile').trigger("reset");
            $('#change-profile').attr('action','{{url('applicant/profile/update_profile')}}');
            $('#change-profile').attr('method','POST');
            $('#change-profile').attr('enctype','multipart/form-data');

            // $.get('applicant/profile/'+data.id, function(data){
            // $('#form-doc-accepted').find('textarea[name="description"]').val(data.description);
            // $('#form-doc-accepted').find('input[name="gender"][value=' + data.status + ']').prop('checked', true);
            // });

            formSubmit();
            initAction();
        });

        const initAction = () => {

            $(document).on('click', '#account-pill-password', function(event){
                event.preventDefault();

                $('#change-password').trigger("reset");
                $('#change-password').attr('action','{{url('applicant/profile/update_password')}}');
                $('#change-password').attr('method','POST');
                $('#change-password').attr('enctype','multipart/form-data');

            });

            $(document).on('click', '#account-pill-info', function(event){
                event.preventDefault();

                var data = <?php echo json_encode($data)?>;

                $('#change-info').trigger("reset");
                $('#change-info').attr('action','{{url('applicant/profile/update_info')}}');
                $('#change-info').attr('method','POST');
                $('#change-info').attr('enctype','multipart/form-data');

                $.get('/applicant/profile/'+data.id, function(data){
                    $('#change-info').find('textarea[name="address"]').val(data.address);
                    $('#change-info').find('input[name="gender"][value=' + data.gender + ']').prop('checked', true);
                });
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
                            SubUnitTable.table().draw(false);
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
            $('#change-password').submit(function(event){
                event.preventDefault();
                var formData = new FormData(this);
                    $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                    })
                    .done(function(res, xhr, meta) {
                        toastr.success(res.message, 'Success')
                        Swal.fire({
                            title: 'Berhasil!',
                            text: "Berhasil ganti password!",
                        })
                        // SubUnitTable.table().draw(false);
                        // hideModal('modal-subunit');
                    })
                    .fail(function(res, error) {
                        toastr.error(res.responseJSON.message, 'Gagal')
                        Swal.fire({
                            title: 'Gagal!',
                            text: "Gagal ganti password!",
                        })
                    })
                    .always(function() { }
                );
            });

            $('#change-profile').submit(function(event){
                event.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    Swal.fire({
                        title: 'Berhasil!',
                        text: "Berhasil ganti profile!",
                    })
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                    Swal.fire({
                        title: 'Gagal!',
                        text: "Gagal ganti profile!",
                    })
                })
                .always(function() { });
            });

            $('#change-info').submit(function(event){
                event.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    Swal.fire({
                        title: 'Berhasil!',
                        text: "Berhasil ganti profile!",
                    })
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                    Swal.fire({
                        title: 'Gagal!',
                        text: "Gagal ganti profile!",
                    })
                })
                .always(function() { });
            });
        }
    }();
</script>
