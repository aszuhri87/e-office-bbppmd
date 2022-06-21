<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();


            $('#select-letter').select2({
                    placeholder: "Pilih lembar/surat...",
                    minimumInputLength: 2,
                    language: { inputTooShort: function () { return 'Ketik minimal 2 karakter'; } },
                    ajax: {
                        url: '/admin/verification/find',
                        dataType: 'json',
                        data: function (params) {
                            return {
                                q: $.trim(params.term)
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });
        });

        const initAction = () => {
            $('#select-letter').on('select2:select', function (e) {
                e.preventDefault();
                var dt = e.params.data.id;
                // var id = dt.id;
                var url =  $('#form-verif').attr('action','{{url('admin/verification/show')}}');

                $.get('/admin/verification/show/'+dt, function(data){

                     $('#timeline_data_create').html(`
                    <span class="timeline-point">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0019ff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M20 11.08V8l-6-6H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h6"/><path d="M14 3v5h5M18 21v-6M15 18h6"/></svg>
                    </span>

                    <div class="timeline-event">
                        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                            <h6>Lembar Dibuat</h6>
                            </div>
                            <p>Lembar disposisi dibuat oleh `+data.created+`</p>

                        </div>
                    `);
                    $('div#tim').html("");
                    for (let i in data.letter_user){

                        $('div#tim').append(`
                        <li class="timeline-item tim">
                        <span class="timeline-point timeline-point-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#cd0000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                        </span>

                        <div class="timeline-event">
                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                <h6>Lembar Diproses </h6>
                                </div>
                                <p>Lembar disposisi diproses oleh `+data.letter_user[i].p_level+`</p>

                            </div>
                        </li>
                        `);
                }

                if(data.status == 'Disetujui'){

                $('#timeline_done').html(`
                    <span class="timeline-point timeline-point-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#cd0000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </span>

                    <div class="timeline-event">
                        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                            <h6>Lembar Selesai</h6>
                            </div>
                            <p>Lembar disposisi telah disetujui</p>

                        </div>
                    `);
                } else if (data.status == 'Ditolak'){
                    $('#timeline_done').html(`
                    <span class="timeline-point timeline-point-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#cd0000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    </span>

                    <div class="timeline-event">
                        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                            <h6>Lembar Selesai</h6>
                            </div>
                            <p>Lembar disposisi telah ditolak</p>

                        </div>
                    `);
                }
                });

            $('.collapse').collapse();

            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('href');
                var dt = mngUserTable.table().row($(this).parents('tr')).data();
                $('#form-manage-user').trigger("reset");
                $('#form-manage-user').attr('action', $(this).attr('href'));
                $('#form-manage-user').attr('method','PUT');

                $.get(url, function(data){
                    $('#form-manage-user').find('input[name="name"]').val(data.name);
                    $('#form-manage-user').find('input[name="username"]').val(data.username);
                    $('#form-manage-user').find('input[name="email"]').val(data.email);
                    // $('#form-manage-user').find('input[name="password"]').val(data.password);
                    $('#form-sub-unit').find('select[name="select_unit"]').val(data.select_unit);
                    showModal('modal-mng-user');
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
                            mngUserTable.table().draw(false);
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
            $('#form-manage-user').submit(function(event){
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    mngUserTable.table().draw(false);
                    hideModal('modal-mng-user');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
