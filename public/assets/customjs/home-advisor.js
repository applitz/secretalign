var Home = function() {
    var list = function() {
        const fp = flatpickr($(".pickr"), {
           "mode": "range"
        });
        $("#tasks-list").dataTable({
            "pageLength": 20,
            "processing": true,
            "searching": false,
            "serverSide": true,
            "scrollX": true,
            "responsive": false,
            "autoWidth": false,
            "ajax": {
                url: baseUrl + "/home",
                type: 'GET',
                data: function(d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.ft_search = $('#ft_search').val(); // Match: input id="search"
                    d.status = $('#statuChooser').val(); // Match: select id="statuChooser"
                    d.statuDoctor = $('#statuDoctor').val(); // Match: select id="statuDoctor"
                    d.date = $('#CRMDateRange').val(); // Match: input id="CRMDateRange"
                },

            },
            "columns": [
                { 'title': 'Doctor', "data": "user_full_name", orderable: false, searchable: false },
                { 'title': 'Patient', "data": "patient_full_name", orderable: false, searchable: false },
                { 'title': 'Task', "data": "task_name", orderable: false, searchable: false },
                { 'title': 'Setup Type', "data": "setup_type", orderable: false, searchable: false },
                { 'title': 'Task Date', "data": "created_at", orderable: false, searchable: false },
                { 'title': '', "data": "case_overview", orderable: false, searchable: false },
            ],
            "order": [[1, 'DESC']],
            "lengthMenu": [10, 20, 50, 100],
        });

        $('.submit-filter-form').on('click', function(e) {
            e.preventDefault();
            $('#tasks-list').DataTable().ajax.reload();
        });

        $('#clear-filters').on('click', function (e) {
            e.preventDefault();

            // Clear input values
            $('#CRMDateRange').val('');
            $('#statuChooser').val('').trigger('change'); // If using a plugin like Select2 or Choices.js
            $('#statuDoctor').val('').trigger('change'); // If using a plugin like Select2 or Choices.js
            $('#ft_search').val('');

            // Reload the DataTable
            $('#tasks-list').DataTable().ajax.reload();
        });

    }
        return{
            init: function() {
                list();
            }
        }
}();
