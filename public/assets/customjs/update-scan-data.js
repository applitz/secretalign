var UpdateScanData = function() {
    var updateScan = function() {
        $(document).on('click', '#update-scan-data', function(e) {
            e.preventDefault();

            var $this = $(this);

            var fl_upper_arch = $("#fl_upper_arch").val();
            var fl_lower_arch = $("#fl_lower_arch").val();

            // Check if files are completely uploaded
            var upperArchWidth = $("#upper-arch-progress-bar").css('width');
            var lowerArchWidth = $("#lower-arch-progress-bar").css('width');

            // Check if upload is in progress
            var upperLoading = !$("#upper-jaw-box")
                .find('._dropzone_loading')
                .hasClass('_dropzone_loading_hidden');

            var lowerLoading = !$("#lower-jaw-box")
                .find('._dropzone_loading')
                .hasClass('_dropzone_loading_hidden');

            // Extract percentage
            var upperPercent = 0;
            var lowerPercent = 0;

            if (upperArchWidth) {
                upperPercent = parseInt(upperArchWidth);
            }

            if (lowerArchWidth) {
                lowerPercent = parseInt(lowerArchWidth);
            }

            // Validate upload status
            if (upperLoading || lowerLoading) {
                toastError(
                    "Required scan files are still uploading. Please wait for the upload to complete."
                );
                return false;
            }

            if (upperPercent < 100 || lowerPercent < 100) {
                toastError(
                    "Please ensure both required scan files are completely uploaded (100%)."
                );
                return false;
            }

            // Show loader
            $(".my-loader").show();
            var dataHashCode = $this.data('hash-code');
            $.ajax({
                type: "POST",

                url: baseUrl + "/patient/update-new-scan",

                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },

                data: {
                    treatment_plan_id: $this.data('treatment-plan-id'),

                    patient_id: $this.data('patient-id'),

                    comment: window.commentEditor.getData(),

                    fl_upper_arch: fl_upper_arch,

                    fl_lower_arch: fl_lower_arch
                },

                success: function(response) {

                    if (response.status) {
                        toastSuccess(
                            response.message || "New scan submitted successfully"
                        );
                        setTimeout(function() {
                            window.location.href = baseUrl + "/patient/case-overview/" + dataHashCode;
                        }, 1500); // Redirect after 1.5 seconds
                    } else {
                        toastError(
                            response.message || "Failed to process new scan"
                        );
                    }
                },

                error: function(xhr) {

                    let msg = "Something went wrong!";

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }

                    toastError(msg);
                },

                complete: function() {

                    // Hide loader always
                    $(".my-loader").hide();
                }
            });
        });

        $("#select-from-3shape").on('click', function (e) {
            e.preventDefault();
            $("#_three_shape_case_id").val("");
            $("#_three_shape_search_for_case").val("");
            $("#3shape-search-result").empty();
            $("#3shape-section-Modal").modal("show");
        });

        $(document).on('keypress', '#3shape-section-Modal input', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#3shape-search').trigger('click');
            }
        });

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

        // For #comment
        ClassicEditor
            .create(document.querySelector('#comment'))
            .then(editor => {
                editor.ui.view.editable.element.style.height = '150px';
                window.commentEditor = editor; // store reference
            })
            .catch(error => console.error(error));
        // For #reminder-note
        ClassicEditor
            .create(document.querySelector('#reminder-note'))
            .then(editor => {
                editor.ui.view.editable.element.style.height = '150px';
                window.reminderEditor = editor; // store reference
            })
            .catch(error => console.error(error));

        // For .classicEditor (if multiple, handle separately)
        document.querySelectorAll('.classicEditor').forEach((el, index) => {
            ClassicEditor
                .create(el)
                .then(editor => {
                    editor.ui.view.editable.element.style.height = '150px';
                    window['classicEditor' + index] = editor; // store reference
                })
                .catch(error => console.error(error));
        });
        for (instance in CKEDITOR.instances)
            CKEDITOR.instances[instance].updateElement();
        }
    return {
        init: function() {
            updateScan();
        }
    }
}();
