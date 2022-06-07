<script type="text/javascript">
    var mngUserTable = function() {
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
                    url: "{{ url('admin/manage-user/dt') }}",
                },
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'name' },
                    { data: 'username'},
                    { data: 'email'},
                    // { data: 'unit',"searchable": false },
                    // { data: 'status' },
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

                            <a href="{{ url('/admin/manage-user') }}/${data}" title="Edit" class="btn btn-light btn-edit btn-sm btn-clean btn-icon" data-toggle="tooltip">
                                <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4bbf41" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                    </span>
                            </a>

                                    <a href="{{ url('admin/manage-user') }}/${data}" title="Delete" class="btn btn-light btn-delete btn-sm btn-clean btn-icon" data-toggle="tooltip"  title="Delete">
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
