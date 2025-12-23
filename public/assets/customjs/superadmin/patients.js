var Patients = function() {
    var list = function(){
        flatpickr(".pickr", {
            dateFormat: "Y-m-d",
            allowInput: false,
            closeOnSelect: true
        });

        $(document).on('click', '#saveStatus', function (e) {
            e.preventDefault();

            // Clear previous errors
            $('.error-text').text('');
            $('.form-control').removeClass('is-invalid');

            let isValid = true;

            let shippingDate = $('#modal_change_status_shipping_date').val();
            let password = $('#modal_change_status_password').val();

            // Shipping date validation
            let today = new Date();
            today.setHours(0, 0, 0, 0);

            if (!shippingDate) {
                isValid = false;
                $('#modal_change_status_shipping_date').addClass('is-invalid');
                $('.shipping_date_error').text('Shipping date is required');
            } else {
                let selectedDate = new Date(shippingDate);
                selectedDate.setHours(0, 0, 0, 0);

                if (selectedDate > today) {
                    isValid = false;
                    $('#modal_change_status_shipping_date').addClass('is-invalid');
                    $('.shipping_date_error').text('Shipping date cannot be a future date');
                }
            }

            // Password validation
            if (!password) {
                isValid = false;
                $('#modal_change_status_password').addClass('is-invalid');
                $('.password_error').text('Password is required');
            } else if (password.length < 6) {
                isValid = false;
                $('#modal_change_status_password').addClass('is-invalid');
                $('.password_error').text('Password must be at least 6 characters');
            }

            if (!isValid) return false;

            let formData = new FormData($('#changePatientStatus')[0]);

            $.ajax({
                type: "POST",
                url: $('#changePatientStatus').attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 120000,

                success: function (response) {
                    if (response.success === true) {
                        toastSuccess(response.message);
                        $('#changeStatusModal').modal('hide');
                        $('#patients-list').DataTable().ajax.reload(null, false);
                    } else {
                        toastError(response.message ?? 'Unable to change status');
                    }
                },

                error: function (xhr) {

                    // ✅ Case 1: Laravel validation errors
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        let errors = xhr.responseJSON.errors;

                        if (errors.shipping_date) {
                            $('#modal_change_status_shipping_date')
                                .addClass('is-invalid');
                            $('.shipping_date_error').text(errors.shipping_date[0]);
                        }

                        if (errors.password) {
                            $('#modal_change_status_password')
                                .addClass('is-invalid');
                            $('.password_error').text(errors.password[0]);
                        }

                    }
                    // ✅ Case 2: Custom controller error (Incorrect password)
                    else if (xhr.status === 422 && xhr.responseJSON?.message) {
                        $('#modal_change_status_password')
                            .addClass('is-invalid');
                        $('.password_error').text(xhr.responseJSON.message);
                    }
                    // ✅ Other errors
                    else {
                        toastError('Something went wrong!');
                    }
                }
            });
        });


        $(document).on('click', '#saveExpiryDate', function (e) {
            e.preventDefault();

            // ✅ Clear old errors
            $('.expiry_date_error').text('');
            $('.change_expiry_date_password_error').text('');
            $('#modal_expiry_date, #modal_change_expiry_date_password')
                .removeClass('is-invalid');

            let isValid = true;

            let expiryDate = $('#modal_expiry_date').val();
            let password = $('#modal_change_expiry_date_password').val();

            // ✅ Expiry date required
            if (!expiryDate) {
                isValid = false;
                $('.expiry_date_error').text('Please select expiry date');
                $('#modal_expiry_date').addClass('is-invalid');
            }

            // ✅ Password validation
            if (!password) {
                isValid = false;
                $('#modal_change_expiry_date_password').addClass('is-invalid');
                $('.change_expiry_date_password_error').text('Password is required');
            } else if (password.length < 6) {
                isValid = false;
                $('#modal_change_expiry_date_password').addClass('is-invalid');
                $('.change_expiry_date_password_error')
                    .text('Password must be at least 6 characters');
            }

            // ✅ Date must be future
            if (expiryDate) {
                let today = new Date();
                today.setHours(0, 0, 0, 0);

                let selectedDate = new Date(expiryDate);
                selectedDate.setHours(0, 0, 0, 0);

                if (selectedDate <= today) {
                    isValid = false;
                    $('.expiry_date_error')
                        .text('Expiry date must be a future date');
                    $('#modal_expiry_date').addClass('is-invalid');
                }
            }

            // ❌ Stop if validation fails
            if (!isValid) return false;

            // ✅ FormData
            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());
            formData.append('patient_id', $('#modal_patient_id').val());
            formData.append('expiry_date', expiryDate);
            formData.append('password', password); // ✅ IMPORTANT

            $.ajax({
                type: "POST",
                url: baseUrl + '/superadmin/patients/change-expiry-date',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 120000,

                success: function (response) {
                    if (response.success === true) {
                        toastSuccess(response.message);
                        $('#changeExpiryDateModal').modal('hide');
                        $('#patients-list').DataTable().ajax.reload(null, false);
                    } else {
                        toastError(response.message ?? 'Unable to update expiry date!');
                    }
                },

                error: function (xhr) {

                    // ✅ Laravel validation errors
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        let errors = xhr.responseJSON.errors;

                        if (errors.expiry_date) {
                            $('#modal_expiry_date').addClass('is-invalid');
                            $('.expiry_date_error').text(errors.expiry_date[0]);
                        }

                        if (errors.password) {
                            $('#modal_change_expiry_date_password')
                                .addClass('is-invalid');
                            $('.change_expiry_date_password_error')
                                .text(errors.password[0]);
                        }
                    }
                    // ✅ Custom password error (Incorrect password)
                    else if (xhr.status === 422 && xhr.responseJSON?.message) {
                        $('#modal_change_expiry_date_password')
                            .addClass('is-invalid');
                        $('.change_expiry_date_password_error')
                            .text(xhr.responseJSON.message);
                    }
                    else {
                        toastError('Unable to update expiry date!');
                    }
                }
            });
        });


        // $(document).on('click', '#saveExpiryDate', function (e) {
        //     e.preventDefault();

        //     // Clear old errors
        //     $('.expiry_date_error').text('');
        //     $('#modal_expiry_date').removeClass('is-invalid');
        //     let password = $('#modal_change_expiry_date_password').val();

        //     let expiryDate = $('#modal_expiry_date').val();

        //     // Required check
        //     if (!expiryDate) {
        //         $('.expiry_date_error').text('Please select expiry date');
        //         $('#modal_expiry_date').addClass('is-invalid');
        //         return false;
        //     }

        //     // Password validation
        //     if (!password) {
        //         isValid = false;
        //         $('#modal_change_expiry_date_password').addClass('is-invalid');
        //         $('.change_expiry_date_password_error').text('Password is required');
        //     } else if (password.length < 6) {
        //         isValid = false;
        //         $('#modal_change_expiry_date_password').addClass('is-invalid');
        //         $('.change_expiry_date_password_error').text('Password must be at least 6 characters');
        //     }


        //     // Today (00:00)
        //     let today = new Date();
        //     today.setHours(0, 0, 0, 0);

        //     // Selected date
        //     let selectedDate = new Date(expiryDate);
        //     selectedDate.setHours(0, 0, 0, 0);

        //     // Future date validation
        //     if (selectedDate <= today) {
        //         $('.expiry_date_error').text('Expiry date must be a future date');
        //         $('#modal_expiry_date').addClass('is-invalid');
        //         return false;
        //     }

        //     var formData = new FormData();
        //     formData.append('_token', $('input[name="_token"]').val());
        //     formData.append('patient_id', $('#modal_patient_id').val());
        //     formData.append('expiry_date', expiryDate);


        //     $.ajax({
        //         type: "POST",
        //         url: baseUrl + '/superadmin/patients/change-expiry-date',
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         cache: false,
        //         timeout: 120000, // 120 seconds
        //         success: function(response, textStatus, xhr) {
        //             if (response.success === true) {
        //                     toastSuccess(response.message);
        //                     $('#changeExpiryDateModal').modal('hide');
        //                     $('#patients-list').DataTable().ajax.reload(null, false);
        //             } else {
        //                 toastError(response.message ?? "Unable to update expiry date!");
        //             }
        //         },
        //         error: function(xhr) {
        //             // ❌ Laravel validation error (422)
        //             if (xhr.status === 422) {
        //                 let errors = xhr.responseJSON.errors;
        //                 if (errors.expiry_date) {
        //                     $('.expiry_date_error').text(errors.expiry_date[0]);
        //                     $('#modal_expiry_date').addClass('is-invalid');
        //                 }
        //             } else {
        //                 toastError("Unable to update expiry date!");
        //             }
        //         }
        //     });

        // });

        $("#patients-list").dataTable({
            "pageLength": 20,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                url: baseUrl + "/superadmin/patients",
                type: 'GET',
                data: function(d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.ft_doctor = $('#ft_doctor').val(); // Match: input id="ft_doctor"
                    d.ft_search = $('#ft_search').val(); // Match: input id="ft_search"
                    d.status = $('#statuChooser').val(); // Match: select id="statuChooser"
                    d.date = $('#CRMDateRange').val(); // Match: input id="CRMDateRange"
                    d.case_holder = $('#ft_case_holder').val(); // Match: input id="ft_case_holder"
                },

            },
            "columns": [
                { 'title': 'ID', "data": "patientId", orderable: true, searchable: false },
                { 'title': 'Doctor', "data": "doctor", orderable: true, searchable: false },
                { 'title': 'Last Name', "data": "last_name", orderable: false, searchable: true },
                { 'title': 'First Name', "data": "first_name", orderable: false, searchable: true },
                { 'title': 'Birth Date', "data": "dob", orderable: false, searchable: true },
                { 'title': 'Treatment Type', "data": "treatment_type", orderable: false, searchable: false },
                { 'title': 'Package', "data": "package", orderable: false, searchable: false },
                { 'title': 'Status', "data": "status", orderable: false, searchable: false },
                { 'title': 'Case Holder', "data": "case_holder", orderable: false, searchable: false },
                { 'title': 'Due Date', "data": "due_date", orderable: false, searchable: false },
                { 'title': 'Setup Approval Date', "data": "setup_approval_date", orderable: false, searchable: false },
                { 'title': 'Advisor', "data": "advisor", orderable: false, searchable: false },
                { 'title': '', "data": "case_overview", orderable: false, searchable: false },
                { 'title': 'Action', "data": "action", orderable: false, searchable: false },
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
            $('#patients-list').DataTable().ajax.reload();
        });

        $('#clear-filters').on('click', function (e) {
            e.preventDefault();

            // Clear input values
            $('#CRMDateRange').val('');
            $('#statuChooser').val('').trigger('change'); // If using a plugin like Select2 or Choices.js
            $('#ft_case_holder').val('').trigger('change'); // If using a plugin like Select2 or Choices.js
            $('#ft_doctor').val('').trigger('change'); // If using a plugin like Select2 or Choices.js
            $('#ft_search').val('');

            // Reload the DataTable
            $('#patients-list').DataTable().ajax.reload();
        });



        $(document).on('click', '.continue-treatment', function(e) {
            e.preventDefault();
            var firstName = $(this).data('first_name');
            var lastName = $(this).data('last_name');
            var loopIndex = $(this).data('loop_index');

            // Trigger the continue treatment action
            handleTreatment(loopIndex, firstName + ' ' + lastName);
        });

        function handleTreatment(loopIteration, name) {

            $('#confirmTreatmentMessage').text(`Do you really want to continue the treatment for ${name}?`);
            $('#confirmLoopIteration').val(loopIteration);
            $('#confirmTreatmentModal').modal('show');
        }

        // On confirm → open aligner input modal
        $('#proceedToInputBtn').on('click', function () {
            $('#confirmTreatmentModal').modal('hide');

            setTimeout(function () {
                $('#alignerInput').val('');
                $('#alignerInputModal').modal('show');
            }, 300);
        });

        // On submit → add hidden input and submit form
        $('#submitTreatmentBtn').on('click', function () {
            const alignerValue = $('#alignerInput').val().trim();
            const loopIteration = $('#confirmLoopIteration').val();

            if (alignerValue !== '') {
                const $form = $(`#continue-plan-${loopIteration}`);

                $('<input>').attr({
                    type: 'hidden',
                    name: 'comment',
                    value: alignerValue
                }).appendTo($form);

                $form.submit();
                $('#alignerInputModal').modal('hide');
            } else {
                alert('Please enter the aligners.');
            }
        });

        // Step 1: Trigger from button
        $(document).on('click', '.request-new-plan', function (e) {
            e.preventDefault();

            const firstName = $(this).data('first_name');
            const lastName = $(this).data('last_name');
            const loopIndex = $(this).data('loop_index');
            const fullName = `${firstName} ${lastName}`;

            $('#confirmName').text(fullName);
            $('#newTreatmentLoop').val(loopIndex);
            $('#newTreatmentConfirmModal').modal('show');
        });

        // Step 2: After confirmation
        $('#confirmNewTreatmentBtn').on('click', function () {
            $('#newTreatmentConfirmModal').modal('hide');

            setTimeout(() => {
                $('#alignerTrackInput').val('');
                $('#alignerTrackModal').modal('show');
            }, 300);
        });

        // Step 3: On input submit
        $('#submitNewTreatmentBtn').on('click', function () {
            const input = $('#alignerTrackInput').val().trim();
            const loopIteration = $('#newTreatmentLoop').val();

            if (!input) {
                alert('Please enter the aligner number.');
                return;
            }

            const form = document.getElementById(`request-plan-${loopIteration}`);
            const formData = new FormData(form);
            formData.append('comment', input);

            fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastSuccess("Treatment plan submitted successfully!");
                        if (data.redirect_url) {
                            window.location.href = data.redirect_url;
                        }
                    } else {
                        toastError(data.message || "Unable to send case to staff!");
                    }
                })
                .catch(error => {
                    console.error("Error submitting treatment plan:", error);
                    toastError("Unable to send case to staff!");
                });

            $('#alignerTrackModal').modal('hide');
        });

       $(document).on('click', '.delete', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');

            // Set modal message
            $('#confirm-delete-modal-message').text(`Are you sure you want to delete "${name}"?`);

            // Set form action dynamically
            var url = baseUrl + "/patient/delete/" + id;
            $('#delete-patient-form').attr('action', url);

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('confirm-delete-modal'));
            modal.show();
        });

    }

    return {
        init: function(){
            list();
        },
    }
}();
