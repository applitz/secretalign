var Scan = function() {
    var meditScan = function() {
        // $("#select-from-medit-link").on('click', function () {
        //     $("#medit-link-section").removeClass('d-none')
        //     $("#3shape-section").addClass('d-none')
        //     $("#patient-wizard").addClass('d-none')
        // })
        $("#select-from-medit-link").on('click', function () {
            $("#medit-link-Modal").modal("show");
        })

        $("#cancel-medit-link-select").on('click', function () {
            $("#3shape-section").addClass('d-none');
            $("#medit-link-section").addClass('d-none')
            $("#patient-wizard").removeClass('d-none');
        })
    }
    var addScan = function() {
        // $("#select-from-3shape").on('click', function () {
        //     $("#3shape-section").removeClass('d-none');
        //     $("#medit-link-section").addClass('d-none');
        //     $("#patient-wizard").addClass('d-none');
        // });

        $("#select-from-3shape").on('click', function (e) {
            e.preventDefault();
            $("#_three_shape_case_id").val("");
            $("#_three_shape_search_for_case").val("");
            $("#3shape-search-result").empty();
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

        // $("#3shape-search").on('submit', function (e) {
        //     e.preventDefault();
        //     e.stopImmediatePropagation();
        //     const case_id = $("#3shape-search input[name=_case_id]").val(),
        //     patient_id = $("#3shape-search input[name=_patient_id]").val(),
        //     three_shape_case_id = $("#3shape-search input[name=_three_shape_case_id]").val(),
        //     three_shape_search_for_case = $("#3shape-search input[name=_three_shape_search_for_case]").val();
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ url('/integrations/3shape-search-cases') }}",
        //         data: {
        //             "_token" : "{{ csrf_token() }}",
        //             "case_id" : case_id,
        //             "patient_id" : patient_id,
        //             "three_shape_case_id" : three_shape_case_id,
        //             "three_shape_search_for_patient" : three_shape_search_for_case,
        //         },
        //         beforeSend: function () {
        //             showLoader();
        //         }
        //     }).done(function (response) {
        //         $("#3shape-search-result").html(response);
        //         hideLoader();
        //     });
        // });

         $(document).on('click', '#3shape-search', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            const modal = $("#3shape-section-Modal");
            const case_id = modal.find('input[name="_case_id"]').val();
            const patient_id = modal.find('input[name="_patient_id"]').val();
            const three_shape_case_id = modal.find('input[name="_three_shape_case_id"]').val();
            const three_shape_search_for_case = modal.find('input[name="_three_shape_search_for_case"]').val();

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseUrl + "/integrations/3shape-search-cases",
                data: {
                    case_id: case_id,
                    patient_id: patient_id,
                    three_shape_case_id: three_shape_case_id,
                    three_shape_search_for_patient: three_shape_search_for_case,
                },
                beforeSend: function () {
                    showLoader();
                },
                success: function (response) {
                    $("#3shape-search-result").html(response);
                },
                complete: function () {
                    hideLoader();
                }
            });

        });
    }

    return {
        init: function(){
            addScan();
            meditScan();
        },
    }
}();
