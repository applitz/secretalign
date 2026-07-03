var PatientsCaseHistory = function() {
    var list = function() {
        $(document).on('click', '.viewCaseHistory', function() {
            var caseHistoryId = $(this).data('id');
            var data = { caseHistoryId: caseHistoryId, _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseUrl + "/superadmin/patients/caseHistory/viewdata",
                data: { 'action': 'viewdata', 'data': data },
                success: function(data) {
                    $("#view-case-history-modal-body").html(data);
                    $('#viewCaseHistoryModal').modal('show');
                }
            });
        });
    }

    return {
        init: function() {
            list();
        }
    };
}();
