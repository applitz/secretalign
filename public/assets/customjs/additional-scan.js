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
            $("#optional-3shape-section-Modal").modal("show");
        });

        // Cancel button
        $("#optional-cancel-3shape-select").on("click", function () {
            $("#optional-3shape-section-Modal").modal("hide");
        });


        $("#3shape-search-additional").on('submit', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            const case_id = $("#3shape-search-additional input[name=additional_case_id]").val(),
            patient_id = $("#3shape-search-additional input[name=additional_patient_id]").val(),

            three_shape_case_id = $("#3shape-search-additional input[name=additional_three_shape_case_id]").val(),
            three_shape_search_for_case = $("#3shape-search-additional input[name=additional_three_shape_search_for_case]").val();
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseUrl  + "/integrations/3shape-search-cases-additional",
                data: {
                    "_token" : $('meta[name="csrf-token"]').attr('content'),
                    "case_id" : case_id,
                    "patient_id" : patient_id,
                    "three_shape_case_id" : three_shape_case_id,
                    "three_shape_search_for_patient" : three_shape_search_for_case,
                },
                beforeSend: function () {
                    showLoader();
                }
            }).done(function (response) {
                $("#3shape-search-result-additional").html(response);
                hideLoader();
            });
        });
    }

    return {
        init: function(){
            add();
        },
    }
}();
