<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // GLobal functions
    function showModal(selector) {
        $('#'+selector).modal('show')
    }

    function hideModal(selector) {
        $('#'+selector).modal('hide')
    }

    $(window).on('load', function() {

            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });



</script>

