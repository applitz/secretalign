var Scan = function() {
    var addScan = function() {
        // $("#select-from-3shape").on('click', function () {
        //     $("#3shape-section").removeClass('d-none');
        //     $("#medit-link-section").addClass('d-none');
        //     $("#patient-wizard").addClass('d-none');
        // });

        $("#select-from-3shape").on('click', function (e) {
            e.preventDefault();
            $("#3shape-section-Modal").modal("show");
        });

        // $("#cancel-3shape-select").on('click', function () {
        //     $("#3shape-section").addClass('d-none');
        //     $("#medit-link-section").addClass('d-none')
        //     $("#patient-wizard").removeClass('d-none');
        // });

        $("#cancel-3shape-select").on('click', function () {
            $("#3shape-section-Modal").modal("hide");
        });
    }

    return {
        init: function(){
            addScan();
        },
    }
}();
