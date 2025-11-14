var Users = function() {
    var list = function(){

        $("#users-list").dataTable({
            "pageLength": 20,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                url: baseUrl + "/partner/users",
                type: 'GET',
                data: function(d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.ft_search = $('#ft_search').val();
                },
            },
            "columns": [

                { 'title': 'Name', "data": "name", orderable: true, searchable: false },
                { 'title': 'Email', "data": "email", orderable: false, searchable: true },
                { 'title': 'Tier', "data": "tier", orderable: false, searchable: true },
            ],
            "order": [[1, 'DESC']],
            "responsive": true,
            "autoWidth": false,
            "lengthMenu": [10, 20, 50, 100],
        });

        // Form submit (works on Enter + button click)
        $('#filter-form').on('submit', function (e) {
            e.preventDefault();
            $('#patients-list').DataTable().ajax.reload();
        });

        $('.submit-filter-form').on('click', function(e) {
            e.preventDefault();
            $('#users-list').DataTable().ajax.reload();
        });

        $('#clear-filters').on('click', function (e) {
            e.preventDefault();
            $('#ft_search').val('');
            // Reload the DataTable
            $('#users-list').DataTable().ajax.reload();
        });





    }

    return {
        init: function(){
            list();
        },
    }
}();
