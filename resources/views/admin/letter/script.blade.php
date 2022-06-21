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
                $('#form-letter-create').attr('action','{{url('admin/letter')}}');
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
                $('div#files').html("");

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

                            $('#d-'+data.unit_letter[i].wish_id).val(data.unit_letter[i].wish_id).prop('checked', true).attr("disabled", true);

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

            });

            $(document).on('hide.bs.modal','#modal-document', function(event){
                $('input[type="radio"]').prop('checked',false).attr('disabled', false);
                $('input[type="text"]').prop('disabled', false);
                $('textarea').prop('disabled', false);
                $('input[type="date"]').prop('disabled', false);
                location.reload();
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
                        $('#form-letter-create').find('input[name="name"]').val(data.name);
                        $('#form-letter-create').find('input[name="from"]').val(data.from);
                        $('#form-letter-create').find('input[name="letter_number"]').val(data.letter_number);
                        $('#form-letter-create').find('input[name="date"]').val(data.date);
                        $('#form-letter-create').find('input[name="agenda_number"]').val(data.agenda_number);
                        $('#form-letter-create').find('input[name="received_date"]').val(data.received_date);
                        $('#form-letter-create').find('input[name="sifat"][value="'+data.trait+'"]').prop('checked', true);
                        $('#form-letter-create').find('textarea[name="about"]').val(data.about);

                        $('.dropify').dropify();

                        showModal('modal-letter');

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
                            LetterTable.table().draw(false);
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
            $('#form-letter-create').submit(function(event){
                event.preventDefault();
                var formData = new FormData(this);

                $.blockUI({ css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .5,
                    color: '#fff'
                } });

                setTimeout($.unblockUI, 2000);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    // data: $(this).serialize(),
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,

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
