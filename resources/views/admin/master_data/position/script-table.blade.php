<script type="text/javascript">
    var PositionTable = function() {
        var init_table;

        $(document).ready(function() {
            initTable();
            actionTable();
        });

        const initTable = () => {
            init_table = $('#init-table').DataTable({
                destroy: true,
                processing: true,
                responsive: true,
                serverSide: true,
                sScrollY: ($(window).height() < 700) ? $(window).height() - 200 : $(window).height() - 400,
                ajax: {
                    type: 'POST',
                    url: "{{ url('admin/position/dt') }}",
                },
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'name' },
                    { data: 'level',},
                    { defaultContent: '' }
                    ],
                columnDefs: [
                    {
                        targets: 0,
                        searchable: false,
                        orderable: false,
                        className: "text-center"
                    },
                    {
                        targets: -1,
                        searchable: false,
                        orderable: false,
                        className: "text-center",
                        data: "id",
                        render : function(data, type, full, meta) {
                            return `
                            <div class="btn-group" role="group" aria-label="Basic example">

                                <a href="{{ url('/admin/position') }}/${data}" title="Detail" class="btn btn-light btn-edit btn-sm btn-clean btn-icon" data-toggle="tooltip" style="border-radius: 30px 0px 0px 30px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#47d147" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                        <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                                    </svg>
                                </a>

                                <a href="{{ url('admin/position') }}/${data}" title="Delete" class="btn btn-light btn-delete btn-sm btn-clean btn-icon" data-toggle="tooltip"  title="Delete" style="border-radius: 0px 30px 30px 0px;">
                                    <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff2d2d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                    </span>
                                </a>
                            </div>
                            `
                        },

                    },
                ],
                order: [[1, 'asc']],
                searching: true,
                paging:true,
                lengthChange:false,
                bInfo:true,
                dom: '<"datatable-header"><tr><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    searchPlaceholder: 'Search.',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    processing: '<div class="text-center"> <div class="spinner-border text-primary" role="status"> <span class="sr-only">Loading...</span> </div> </div>',
                },
                rowCallback: function(row, data, index){
                            if (data.status=='Diproses') {
                                $(row).find('td:eq(4)').html('<span class="badge badge-pill badge-light-warning mr-1">'+data.status+'</span>');
                            }else if (data.status=='Ditolak') {
                                $(row).find('td:eq(4)').html('<span class="badge badge-pill badge-light-danger mr-1">'+data.status+'</span>');
                            }else{
                                $(row).find('td:eq(4)').html('<span class="badge badge-pill badge-light-secondary mr-1">'+data.status+'</span>');
                            }
                        },

            });
        },
        actionTable = () => {
            $('#search').on('keyup', function () {
                init_table.search(this.value).draw();
            });

            $('#pageLength').on('change', function () {
                init_table.page.len(this.value).draw();
            });
        }

        return {
            table : function(){
                return init_table;
            },
        }
    }();
</script>
