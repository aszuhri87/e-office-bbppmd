<script type="text/javascript">

    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {
            $(document).on('click','#create-letter-modal', function(event){
                event.preventDefault();

                $('#form-letter-create').trigger("reset");
                $('#form-letter-create').attr('action','{{url('chief_div/letter-chief_div')}}');
                $('#form-letter-create').attr('method','POST');
                $('#form-letter-create').attr('enctype','multipart/form-data');
                $('.dropify').dropify();

                $('#modal-letter').modal('show');

            });


            $(document).on('click','#btn-print', function(event){
                event.preventDefault();

                printJS({
                    printable: 'print',
                    type: 'html',
                    style:'.col-10{right:8%;}',
                    css:[
                        '../../app-assets/css/bootstrap.css',
                        '../../css/app.css',
                        '../../css/style.css',
                        '../../app-assets/css/colors.css',
                        '../../app-assets/css/bootstrap-extended.css',
                        '../../app-assets/css/components.css'
                    ],
                    documentTitle: Date.now()+'_lembar disposisi'
                });

                document.title = Date.now()+'_lembar disposisi';

            });

            $(document).on('click', '.btn-detail', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('href');
                var dt = LetterTable.table().row($(this).parents('tr')).data();


                $('div#catatan').html("");
                $.get(url, function(data){

                    $('#form-letter-create').find('input[name="name"]').val(data.name).attr("disabled", true);
                        $('input[name="from"]').val(data.from).attr("disabled", true);
                        $('input[name="letter_number"]').val(data.letter_number).attr("disabled", true);
                        $('input[name="date"]').val(data.date).attr("disabled", true);
                        $('input[name="agenda_number"]').val(data.agenda_number).attr("disabled", true);
                        $('input[name="received_date"]').val(data.received_date).attr("disabled", true);
                        $('input[name="sifat"][value="'+data.trait+'"]').prop('checked', true).attr("disabled", true);
                        $('textarea[name="about"]').val(data.about).attr("disabled", true);

                        for(i in data.unit_letter){
                            // $('input[name="wish['+i+']"][value="'+data.unit_letter[i]?.wish_id+'"]').prop('checked', true);
                            $('#d-'+data.unit_letter[i].wish_id).val(data.unit_letter[i].wish_id).prop('checked', true).attr("disabled", true);
                            // console.log(data.unit_letter[i]?.wish_id);
                            if(data.unit_letter[i].other_wishes!=null){

                            $('.input-lain').html(`
                                        <input type="text" name="lain" value="`+data.unit_letter[i].other_wishes+`" style="outline: 0; border-width: 0 0 2px; " disabled>
                            `);
                            }
                        }

                        for(i in data.letter_user){
                            $('#d-'+data.letter_user[i].position_id).val(data.letter_user[i].position_id).prop('checked', true).attr("disabled", true);

                            if (data.letter_user[i].note != null){
                                $('div#catatan').append(`
                                    <p>`+data.letter_user[i].note+`</p>
                                `);
                            }
                        }

                        $('div#files').append(`

                            <embed class="mt-1" src="{{ asset('files/`+data.letter_file+`') }}" width="150%" height="600">
                            </embed></p>
                        `);
                                showModal('modal-document');

                });

                $(document).on('hide.bs.modal','#modal-document', function(event){
                    $('input[type="checkbox"]').prop('checked',false);
                    location.reload();
                });
            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('href');
                var dt = LetterTable.table().row($(this).parents('tr')).data();
                $('#form-letter-create').trigger("reset");
                $('#form-letter-create').attr('action', $(this).attr('href'));
                $('#form-letter-create').attr('method','PUT');

                $.get(url, function(data){

                        for(i in data.unit_letter){

                            $('#'+data.unit_letter[i]?.wish_id).val(data.unit_letter[i]?.wish_id).prop('checked', true).attr("disabled", true);

                        }

                        for(i in data.letter_user){

                            $('#'+data.letter_user[i]?.position_id).val(data.letter_user[i]?.position_id).prop('checked', true).attr("disabled", true);
                            $('#catatan'+i).html(data.letter_user[i]?.note);
                        }

                        $(document).on('click','#f9c5e916-6a13-427a-ab2c-60b021c148a4', function(event){
                                    $('.input-lain').html(`
                                        <input type="text" name="lain" style="outline: 0; border-width: 0 0 2px; border-color: blue">
                                    `);
                                });

                        $('textarea[name="notes"]').prop('disabled',false);
                        showModal('modal-letter');

                });
            });

            $(document).on('hide.bs.modal','#modal-letter', function(event){
                $('input[type="checkbox"]').prop('disabled',false);

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
                            LetterTable.table().draw(false);
                        })
                        .fail(function(res, error) {
                            toastr.error(res.responseJSON.message, 'Gagal')
                        })
                        .always(function() { });
                    }
                })
            });

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
                    onUnblock: function () {
                    $.blockUI({
                        message: '<p class="mb-0">Hampir Selesai...</p>',
                        timeout: 1000,
                        css: {
                        backgroundColor: 'transparent',
                        color: '#fff',
                        border: '0'
                        },
                        overlayCSS: {
                        opacity: 0.5
                        },
                        onUnblock: function () {
                        $.blockUI({
                            message: '<div class="p-1 bg-success">Selesai!</div>',
                            timeout: 500,
                            css: {
                            backgroundColor: 'transparent',
                            color: '#fff',
                            border: '0'
                            },
                            overlayCSS: {
                            opacity: 0.5
                            }
                        });
                        }
                    });
                    }
                });

                // setTimeout($.unblockUI, 2100);
            });
        },
        formSubmit = () => {
            $('#form-letter-create').submit(function(event){
                event.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),

                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    LetterTable.table().draw(false);
                    hideModal('modal-letter');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
