var AdditionalScan = function() {
    var add = function() {
         $("#toggleAdditionalScans").click(function () {

            $("#additional-scans-optional").toggleClass("d-none");
            // Button text change
            if ($("#additional-scans-optional").hasClass("d-none")) {
                $(this).text("+ Add Additional Scans");
            } else {
                $(this).text("- Hide Additional Scans");
            }
        });

        // optional-select-from-3shape
        $("#optional-select-from-3shape").on("click", function (e) {
            e.preventDefault();
            $("#additional_three_shape_case_id").val("");
            $("#additional_three_shape_search_for_case").val("");
            $("#3shape-search-result-additional").empty();
            $("#optional-3shape-section-Modal").modal("show");
        });

        // Cancel button
        $("#optional-cancel-3shape-select").on("click", function () {
            $("#optional-3shape-section-Modal").modal("hide");
        });

        $(document).on('click', '#additional-3shape-search', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            const modal = $("#optional-3shape-section-Modal");
            const case_id = modal.find('input[name="additional_case_id"]').val();
            const patient_id = modal.find('input[name="additional_patient_id"]').val();
            const three_shape_case_id = modal.find('input[name="additional_three_shape_case_id"]').val();
            const three_shape_search_for_case = modal.find('input[name="additional_three_shape_search_for_case"]').val();

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseUrl + "/integrations/3shape-search-cases-additional",
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
                    console.log(response);
                    $("#3shape-search-result-additional").html(response);
                },
                complete: function () {
                    hideLoader();
                }
            });

        });


    }

    var meditScan = function() {
        $("#select-from-medit-link-additional").on('click', function () {
            $("#medit-link-additional-Modal").modal("show");
        });

        $("#cancel-medit-link-additional-select").on('click', function () {
            // $("#3shape-section").addClass('d-none');
            // $("#medit-link-section").addClass('d-none')
            // $("#patient-wizard").removeClass('d-none');
            $("#medit-link-additional-Modal").modal("hide");
        });
    }
    return {
        init: function(){
            add();
            meditScan();
        },
    }
}();
