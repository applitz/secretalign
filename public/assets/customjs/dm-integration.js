var DmIntegration = function() {
    var add = function(){

        $(document).on('click', '.cancel-order-from-dental-monitoring-btn', function(){
            const p_treatment_plans_id = $(this).attr("data-patient-treatment-plans-id");
            const patient_id = $(this).attr("data-patient-id");
            $("#cancel-order-from-dental-sure").attr("data-patient-treatment-plans-id", p_treatment_plans_id);
            $("#cancel-order-from-dental-sure").attr("data-patient-id", patient_id);
        });

        $(document).on('click', '#cancel-order-from-dental-sure', function(e) {
            e.preventDefault();
            $(".my-loader").show();
            $("#cancel-order-from-dental-sure").prop("disabled", true);
            const p_treatment_plans_id = $(this).attr("data-patient-treatment-plans-id");
            const patient_id = $(this).attr("data-patient-id");
            var formData = new FormData();
            formData.append('patient_id', patient_id)
            formData.append('p_treatment_plans_id', p_treatment_plans_id)
            formData.append('_token',  $('input[name="_token"]').val())
            $("#cancel-order-from-dental-sure").text("Please wait");
            $.ajax({
                type: "POST",
                url: baseUrl + '/cancel-order-from-dental-monitoring',
                data: formData,
                timeout: 120000, // 120 seconds
                processData: false, // Required for FormData
                contentType: false, // Required for FormData
                cache: false,
            }).done(function(response) {
                $("#cancel-order-from-dental-sure").prop("disabled", false);
                $("#cancel-order-from-dental-sure").text("Yes, Cancel Order");
                const modalEl2 = document.getElementById('cancel-order-from-dental-monitoring-modal');
                const modal2 = bootstrap.Modal.getOrCreateInstance(modalEl2);
                modal2.hide();
                $(".my-loader").hide();
                toastSuccess(response.message);
                setTimeout(() => {
                    location.reload();
                }, 2000);

            }).fail(function(response) {
                $("#cancel-order-from-dental-sure").prop("disabled", false);
                 $("#cancel-order-from-dental-sure").text("Yes, Cancel Order");
                const modalEl2 = document.getElementById('cancel-order-from-dental-monitoring-modal');
                const modal2 = bootstrap.Modal.getOrCreateInstance(modalEl2);
                modal2.hide();
                $(".my-loader").hide();
                toastError(response.responseJSON.message);

            });
        });

        $(document).on('click', '.order-from-dental-monitoring-btn', function(){
            $("#dental_patient_id").val('');
            $("#p_treatment_plans_id_input").val('');
            $("#patient_id_input").val('');
            $("#keep_attachments_stl").prop('checked', false);
            $("#confirm-order-from-dental-monitoring").text('Order Now');
            $("#confirm-order-from-dental-monitoring").prop("disabled", false);
            const p_treatment_plans_id = $(this).attr("data-patient-treatment-plans-id");
            const patient_id = $(this).attr("data-patient-id");
            $("#p_treatment_plans_id_input").val(p_treatment_plans_id);
            $("#patient_id_input").val(patient_id);
        });


        $(document).on('click', '#confirm-order-from-dental-monitoring', function(e) {
            e.preventDefault();
            $(".my-loader").show();
            $(this).prop("disabled", true);
            const dental_patient_id = $("#dental_patient_id").val();
            const p_treatment_plans_id = $("#p_treatment_plans_id_input").val();
            const patient_id = $("#patient_id_input").val();
            const manullay_upload = $("#manullay_upload").val();
            const keep_attachments_stl = $(".attachments:checked").val();

            // Basic validation
            if (dental_patient_id === '') {
                toastError("Please enter Dental Monitoring Patient ID");
                $(".my-loader").hide();
                $(this).prop("disabled", false);
                return;
            }

            // Create form data
            var formData = new FormData();
            formData.append('dental_patient_id', dental_patient_id);
            formData.append('p_treatment_plans_id', p_treatment_plans_id);
            formData.append('patient_id', patient_id);
            formData.append('keep_attachments_stl', keep_attachments_stl);
            formData.append('manullay_upload', manullay_upload);
            formData.append('_token', $('input[name="_token"]').val());

            if (manullay_upload === 'yes') {
                const upperArch = $('#upper_arch_scan')[0].files[0];
                const lowerArch = $('#lower_arch_scan')[0].files[0];

                // Validate both files
                if (!upperArch || !lowerArch) {
                    toastError("Please upload both Upper and Lower Arch STL files.");
                    $(".my-loader").hide();
                    $(this).prop("disabled", false);
                    return;
                }

                // Optionally check file extension
                const validExt = ['stl'];
                const upperExt = upperArch.name.split('.').pop().toLowerCase();
                const lowerExt = lowerArch.name.split('.').pop().toLowerCase();

                if (!validExt.includes(upperExt) || !validExt.includes(lowerExt)) {
                    toastError("Upper and Lower Arch files must be STL format only.");
                    $(".my-loader").hide();
                    $(this).prop("disabled", false);
                    return;
                }

                formData.append('upper_arch_scan', upperArch);
                formData.append('lower_arch_scan', lowerArch);
            }

            // Proceed with AJAX
            $(this).text("Please wait...");
            $("#dental-monitoring-alert").removeClass("d-none");

            $.ajax({
                type: "POST",
                url: baseUrl + '/order-from-dental-monitoring',
                data: formData,
                timeout: 120000, // 120 seconds
                processData: false,
                contentType: false,
                cache: false,
            })
            .done(function(response) {
                $("#confirm-order-from-dental-monitoring").prop("disabled", true);
                $("#dental-monitoring-alert").addClass("d-none");
                const modalEl = document.getElementById('order-from-dental-monitoring-modal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.hide();
                $(".my-loader").hide();
                toastSuccess(response.message);
                setTimeout(() => {
                    location.reload();
                }, 2000);
            })
            .fail(function(response) {
                $("#confirm-order-from-dental-monitoring")
                    .prop("disabled", false)
                    .text("Order Now");
                $("#dental-monitoring-alert").addClass("d-none");
                $(".my-loader").hide();

                let msg = response.responseJSON?.message ?? "Something went wrong!";
                toastError(msg);
            });
        });

        $(document).on('click', '#update-order-from-dental-monitoring', function(e) {
            e.preventDefault();
            $(".my-loader").show();
            const button = $(this);
            const dmOrderStatus = button.data('dm-order-status');
            const dmOrderId = button.data('dm-order-id');

            // clear old error messages
            $('.text-danger').text('');

            let iosStatuses = [
                'OrderStatusChangedToWaitingForNewFilesIOSIncorrect',
                'OrderStatusChangedToWaitingForNewFilesIOSCorrupted',
                'OrderStatusChangedToWaitingForNewFilesIOSUnusable',
                'OrderStatusChangedToOrderRejectedAnatomicalChanges',
                'OrderStatusChangedToOrderRejectedAdditionalTeeth'
            ];

            let stageStatuses = [
                'OrderStatusChangedToWaitingForNewFilesStageFileIncorrect',
                'OrderStatusChangedToWaitingForNewFilesStageFileCorrupted',
                'OrderStatusChangedToWaitingForNewFilesStageFileUnusable',
                'OrderStatusChangedToWaitingForNewFilesAlignerNumberIncorrect'
            ];

            let valid = true;
            let errorMsg = '';

            // Validation for IOS files
            // IOS file validation
            if (iosStatuses.includes(dmOrderStatus)) {
                const upperFiles = $('#update_upper_arch_scan')[0].files;
                const lowerFiles = $('#update_lower_arch_scan')[0].files;
                console.log(upperFiles.length);
                if (!upperFiles.length) {
                    $(".my-loader").hide();
                    $('.upper_arch_scan_error').text('Please upload the Upper IOS file.');
                    valid = false;
                }

                if (!lowerFiles.length) {
                    $(".my-loader").hide();
                    $('.lower_arch_scan_error').text('Please upload the Lower IOS file.');
                    valid = false;
                }
            }

            // Stage file validation
            else if (stageStatuses.includes(dmOrderStatus)) {
                const upperStageFiles = $('#update_upper_arch_stage_file')[0].files;
                const lowerStageFiles = $('#update_lower_arch_stage_file')[0].files;

                if (!upperStageFiles.length) {
                    $(".my-loader").hide();
                    $('.upper_arch_stage_file_error').text('Please upload the Stage Upper file.');
                    valid = false;
                }

                if (!lowerStageFiles.length) {
                    $(".my-loader").hide();
                    $('.lower_arch_stage_file_error').text('Please upload the Stage Lower file.');
                    valid = false;
                }
            }

            // Invalid / unexpected status
            else {
                $(".my-loader").hide();
                const modalEl = document.getElementById('reupload-from-dental-monitoring-modal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.hide();
                toastError('Invalid or unsupported Dental Monitoring status.');
                return false;
            }

             // Stop if invalid
            if (!valid) {
                $(".my-loader").hide();
                return;
            }


            const keep_attachments_stl = $("#keep_attachments_stl").is(":checked") ? 'yes' : 'no';
                button.prop('disabled', true).text('Processing...');
                var formData = new FormData();

                formData.append('dmOrderId', dmOrderId);
                formData.append('keep_attachments_stl', keep_attachments_stl);
                formData.append('dmOrderStatus', dmOrderStatus);
                // Append files based on status
                if (iosStatuses.includes(dmOrderStatus)) {
                    formData.append('upper_arch_scan', $('#update_upper_arch_scan')[0].files[0]);
                    formData.append('lower_arch_scan', $('#update_lower_arch_scan')[0].files[0]);
                } else if (stageStatuses.includes(dmOrderStatus)) {
                    formData.append('upper_arch_stage_file', $('#update_upper_arch_stage_file')[0].files[0]);
                    formData.append('lower_arch_stage_file', $('#update_lower_arch_stage_file')[0].files[0]);
                }
                formData.append('_token', $('input[name="_token"]').val());

                $.ajax({
                    type: "POST",
                    url: baseUrl + '/update-order-from-dental-monitoring',
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 120000, // 120 seconds
                    success: function(response, textStatus, xhr) {
                        // HTTP status code returned by Laravel
                        const statusCode = xhr.status;
                        if (statusCode >= 200 && statusCode < 300) {
                            // Success from DM API
                            $("#reupload-from-dental-monitoring-modal").prop("disabled", true);
                            const modalEl = document.getElementById('reupload-from-dental-monitoring-modal');
                            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                            modal.hide();
                            $(".my-loader").hide();
                            toastSuccess(response.message ?? "Order updated successfully!");
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            // Non-2xx returned but still enters success due to jQuery AJAX
                            $("#reupload-from-dental-monitoring-modal").prop("disabled", false).text("Order Now");
                            const modalEl = document.getElementById('reupload-from-dental-monitoring-modal');
                            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                            modal.hide();
                            $(".my-loader").hide();
                            let msg = response.details?.message ?? response.message ?? "Something went wrong!";
                            toastError(msg);
                        }
                    },
                    error: function(xhr) {
                        $("#reupload-from-dental-monitoring-modal").prop("disabled", false).text("Order Now");
                        const modalEl = document.getElementById('reupload-from-dental-monitoring-modal');
                        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modal.hide();
                        $(".my-loader").hide();
                        let msg;
                        if (xhr.responseJSON) {
                            msg = xhr.responseJSON.details?.message ?? xhr.responseJSON.message ?? "Something went wrong!";
                        } else {
                            msg = "Something went wrong! Please try again.";
                        }
                        toastError(msg);
                    }
                });


        });

        $(document).on('click', '.add-stage', function() {
            var html = '';
            html += `<div class="remove-stage-box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" >Stage Number<span class="text-danger">*</span></label>
                                        <input class="form-control relapse_intra_oral_scan_stage_number"  type="number" placeholder="Enter Stage Number" name="relapse_intra_oral_scan_stage_number[]" value="">
                                        <span class="text-danger relapse_intra_oral_scan_stage_number_error"></span>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label class="form-label">&nbsp;</label><br>
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-primary add-stage">+</button>
                                        <button type="button" class="btn btn-danger remove-stage">-</button>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" >Upper Arch File Name<span class="text-danger">*</span></label>
                                        <input class="form-control relapse_intra_oral_scan_upper" type="text" placeholder="Enter Upper Arch File Name" name="relapse_intra_oral_scan_upper[]" value="">
                                        <span class="text-danger relapse_intra_oral_scan_upper_error"></span>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Upper Arch File<span class="text-danger">*</span></label>
                                        <input class="form-control relapse_intra_oral_scan_upper_file" type="file" placeholder="Enter Upper Arch File" name="relapse_intra_oral_scan_upper_file[]" value="">
                                        <span class="text-danger relapse_intra_oral_scan_upper_file_error"></span>
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" >Lower Arch File Name<span class="text-danger">*</span></label>
                                        <input class="form-control relapse_intra_oral_scan_lower" type="text" placeholder="Enter Lower Arch File Name" name="relapse_intra_oral_scan_lower[]" value="">
                                        <span class="text-danger relapse_intra_oral_scan_lower_error"></span>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Lower Arch File<span class="text-danger">*</span></label>
                                        <input class="form-control relapse_intra_oral_scan_lower_file" type="file" placeholder="Enter Lower Arch File" name="relapse_intra_oral_scan_lower_file[]" value="">
                                        <span class="text-danger relapse_intra_oral_scan_lower_file_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
            $("#add-stage-section").append(html);
        });

        $(document).on('click', '.remove-stage', function() {
            $(this).closest('.remove-stage-box').remove();
        });
        var customValid = true;
        $("#order-from-dental-monitoring-form").validate({
            ignore: [],
            rules: {
                doctor_id: {
                    required: true,
                    maxlength: 50
                },
                patient_id: {
                    required: true,
                    maxlength: 50
                },
                total_stage: {
                    required: true,
                    digits: true
                },
                current_stage: {
                    required: true,
                    digits: true
                },
                initial_intra_oral_scan: {
                    required: true,
                    maxlength: 100
                },
                initial_intra_oral_scan_file_upper: {
                    required: true,
                    extension: "stl|obj|zip" // example extensions, adjust as needed
                },
                initial_intra_oral_scan_lower: {
                    required: true,
                    maxlength: 100
                },
                initial_intra_oral_scan_file_lower: {
                    required: true,
                    extension: "stl|obj|zip"
                },
            },
            messages: {
                doctor_id: {
                    required: "Doctor ID is required.",
                    maxlength: "Doctor ID cannot exceed 50 characters."
                },
                patient_id: {
                    required: "Patient ID is required.",
                    maxlength: "Patient ID cannot exceed 50 characters."
                },
                total_stage: {
                    required: "Total stage is required.",
                    digits: "Please enter a valid number."
                },
                current_stage: {
                    required: "Current stage is required.",
                    digits: "Please enter a valid number."
                },
                initial_intra_oral_scan: {
                    required: "Upper arch file name is required."
                },
                initial_intra_oral_scan_file_upper: {
                    required: "Upper arch file is required.",
                    extension: "Only .stl, .obj, or .zip files allowed."
                },
                initial_intra_oral_scan_lower: {
                    required: "Lower arch file name is required."
                },
                initial_intra_oral_scan_file_lower: {
                    required: "Lower arch file is required.",
                    extension: "Only .stl, .obj, or .zip files allowed."
                },
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            invalidHandler: function (event, validator) {
                customValid = customerInfoValid();
            },
            highlight: function (element) {
                // $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function (element) {
                // $(element).addClass('is-valid').removeClass('is-invalid');
            },
            errorPlacement: function (error, element) {
                customValid = customerInfoValid();
                if (element.closest(".input-group").length) {
                    error.insertAfter(element.closest(".input-group"));
                } else if (element.attr("type") === "file") {
                    error.insertAfter(element.closest(".mb-3")); // better for file inputs
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                customValid = customerInfoValid();
                if (customValid)
                {
                    form.submit();
                }
            }
        });
        function customerInfoValid() {
            var customValid = true;
            $('.relapse_intra_oral_scan_stage_number').each(function () {
                var elem = $(this);
                if ($(this).is(':visible')) {
                    if ($(this).val() == '' || $(this).val() == null) {
                        $(this).parent().find('.relapse_intra_oral_scan_stage_number_error').text('Please add stage number');
                        // elem.addClass('is-invalid').removeClass('is-valid');
                        customValid = false;
                    } else {
                        $(this).parent().find('.relapse_intra_oral_scan_stage_number_error').text('');
                        // elem.addClass('is-valid').removeClass('is-invalid');
                    }
                }
            });

            $('.relapse_intra_oral_scan_upper').each(function () {
                var elem = $(this);
                if ($(this).is(':visible')) {
                    if ($(this).val() == '' || $(this).val() == null) {
                        $(this).parent().find('.relapse_intra_oral_scan_upper_error').text('Please add upper arch file name');
                        // $(this).addClass('is-invalid').removeClass('is-valid');
                        customValid = false;
                    } else {
                        $(this).parent().find('.relapse_intra_oral_scan_upper_error').text('');
                        // $(this).addClass('is-valid').removeClass('is-invalid');
                    }
                }
            });
            $('.relapse_intra_oral_scan_upper_file').each(function () {
                var elem = $(this);
                if ($(this).is(':visible')) {
                    if ($(this).val() == '' || $(this).val() == null) {
                        $(this).parent().find('.relapse_intra_oral_scan_upper_file_error').text('Please upload upper arch file');
                        // elem.addClass('is-invalid').removeClass('is-valid');
                        customValid = false;
                    } else {
                        $(this).parent().find('.relapse_intra_oral_scan_upper_file_error').text('');
                        // elem.addClass('is-valid').removeClass('is-invalid');
                    }
                }
            });

            $('.relapse_intra_oral_scan_lower').each(function () {
                var elem = $(this);
                if ($(this).is(':visible')) {
                    if ($(this).val() == '' || $(this).val() == null) {
                        $(this).parent().find('.relapse_intra_oral_scan_lower_error').text('Please add lower arch file name');
                        // $(this).addClass('is-invalid').removeClass('is-valid');
                        customValid = false;
                    } else {
                        $(this).parent().find('.relapse_intra_oral_scan_lower_error').text('');
                        // $(this).addClass('is-valid').removeClass('is-invalid');
                    }
                }
            });

            $('.relapse_intra_oral_scan_lower_file').each(function () {
                var elem = $(this);
                if ($(this).is(':visible')) {
                    if ($(this).val() == '' || $(this).val() == null) {
                        $(this).parent().find('.relapse_intra_oral_scan_lower_file_error').text('Please upload lower arch file');
                        // $(this).addClass('is-invalid').removeClass('is-valid');
                        customValid = false;
                    } else {
                        $(this).parent().find('.relapse_intra_oral_scan_lower_file_error').text('');
                        // $(this).addClass('is-valid').removeClass('is-invalid');
                    }
                }
            });
            return customValid;
        }

        $(document).on("change", "#initial_intra_oral_scan_file_upper", function () {
            let fileName = this.files[0] ? this.files[0].name : "";
            $("#initial_intra_oral_scan").val(fileName);
        });

        $(document).on("change", "#initial_intra_oral_scan_file_lower", function () {
            let fileName = this.files[0] ? this.files[0].name : "";
            $("#initial_intra_oral_scan_lower").val(fileName);
        });

        $(document).on("change", ".relapse_intra_oral_scan_upper_file", function () {
            let fileName = this.files[0] ? this.files[0].name : "";
            $(this).closest(".row").find(".relapse_intra_oral_scan_upper").val(fileName);
        });

        // Lower Arch File → Lower Arch File Name
        $(document).on("change", ".relapse_intra_oral_scan_lower_file", function () {
            let fileName = this.files[0] ? this.files[0].name : "";
            $(this).closest(".row").find(".relapse_intra_oral_scan_lower").val(fileName);
        });
    };
    return {
        init: function(){
            add();
        },
    }
}();
