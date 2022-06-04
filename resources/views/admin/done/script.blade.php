<script type="text/javascript">

    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {

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
                        }

                        for(i in data.letter_user){
                            $('#d-'+data.letter_user[i].position_id).val(data.letter_user[i].position_id).prop('checked', true).attr("disabled", true);


                        $('div#catatan').append(`
                                    <p>`+data.letter_user[i].note+`</p>
                            `);
                        }

                        showModal('modal-document');

                });

                $(document).on('hide.bs.modal','#modal-document', function(event){
                    $('input[type="checkbox"]').prop('checked',false);
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
