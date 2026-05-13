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

        $(document).on('click', '.download-3shape-stl-files-additional',function () {
            const hash_upper = $(this).attr('hash-upper'),
            hash_lower = $(this).attr('hash-lower'),
            case_id = $(this).attr('case-id');
            download3ShapeStlFilesAdditional(case_id, hash_upper, hash_lower);
        });

        function download3ShapeStlFilesAdditional(case_id, hash_upper, hash_lower)
        {
            const modal = $("#optional-3shape-section-Modal");
            const patient_id = modal.find('input[name="additional_case_id"]').val();
            const treatment_plan_id = modal.find('input[name="additional_patient_id"]').val();
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: baseUrl + "/patient/file/download-3shape-additional",

                data: {
                    "_token" : $('meta[name="csrf-token"]').attr('content'),
                    "patient_id": patient_id,
                    "treatment_plan_id": treatment_plan_id,
                    "case_id": case_id,
                    "hash_upper": hash_upper,
                    "hash_lower": hash_lower,
                },

                beforeSend: function () {
                    showLoader();
                },

                success: function (response) {
                    console.log(response);
                    if(response.upper || response.lower) {

                        if(response.upper) {
                            $('#key18').attr('file', response.upper);
                            window.dropzone_active_state('1', response.upper);
                            previewUpperStlFile(response.upper);
                        }

                        if(response.lower) {
                            $('#key19').attr('file', response.lower);
                            window.dropzone_active_state('2', response.lower);
                            previewLowerStlFile(response.lower);
                        }

                        $("#optional-3shape-section-Modal").modal("hide");

                    } else {
                        toastError("Error while downloading files.");
                    }
                },

                error: function(xhr) {
                    toastError(xhr.responseJSON?.message || "Something went wrong.");
                },

                complete: function () {
                    hideLoader();
                }
            });
        }
    }

    return {
        init: function(){
            add();
        },
    }
}();
