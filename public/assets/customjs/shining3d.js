var Shining3d = function() {
    var add = function(){

        function parseValidDate(dateStr) {
            if (!dateStr) return null;

            dateStr = dateStr.trim();

            const parts = dateStr.split('-');
            if (parts.length !== 3) return null;
            const day   = Number(parts[0]);
            const month = Number(parts[1]) - 1; // 0-based
            const year  = Number(parts[2]);
            const date = new Date(year, month, day);
            date.setHours(0, 0, 0, 0); // normalize time

            // Logical validation
            if (
                date.getFullYear() !== year ||
                date.getMonth() !== month ||
                date.getDate() !== day
            ) {
                return null;
            }
            return date; // ✅ Date object
        }

         $("#order-from-shining3d-form-modal").validate({
            ignore: [],
            rules: {
                scanRegion: {
                    required: true
                },
                startDate: {
                    required: true
                },
                endDate: {
                    required: true
                },
            },
            messages: {

            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            debug: false,
            highlight: function (element) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function (element) {
                $(element).addClass('is-valid').removeClass('is-invalid');
            },
            errorPlacement: function (error, element) {
                    error.insertAfter(element);
            },
            submitHandler: function(form) {
                 $(".my-loader").show();
                const btn   = $('#order-from-shining3d');
                const error = $('#shining3d-error');

                const region = $('#scanRegion').val();
                const start  = $('#startDate').val();
                const end    = $('#endDate').val();

                const authToken = $("#order-from-shining3d-label-model-shining3d-auth-token").val();
                const orgCode = $("#order-from-shining3d-label-model-shining3d-org-code").val();
                const doctorId = $("#order-from-shining3d-label-model-shining3d-doctor-id").val();
                const orgType = $("#order-from-shining3d-label-model-shining3d-org-type").val();
                // Reset message
                error.hide().removeClass('alert-success alert-danger').text('');

                // -------------------------------
                // VALIDATION
                // -------------------------------
                if (!region) return showError('Please select a region.');
                if (!start)  return showError('Please select Start Date.');
                if (!end)    return showError('Please select End Date.');

                const startDate = parseValidDate(start);
                const endDate   = parseValidDate(end);

                if (!startDate || !endDate) {
                    return showError('Invalid date format11.');
                }

                if (endDate < startDate) {
                    return showError('End Date cannot be earlier than Start Date.');
                }


                // Shining3D rule: minimum 3 days
                const diffDays = Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24));

                if (diffDays < 3) {
                    return showError('Date range must be at least 3 days (Shining3D requirement).');
                }

                // -------------------------------
                // AJAX CALL
                // -------------------------------
                $.ajax({
                    url: baseUrl + '/get-shining3d-order-list',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        start_date: start,
                        end_date: end,
                        region : region,
                        authToken : authToken,
                        orgCode : orgCode,
                        doctorId : doctorId,
                        orgType : orgType,
                        _token: $('input[name="_token"]').val()
                    },

                    beforeSend: function () {
                        btn.prop('disabled', true).text('Loading...');
                    },

                    success: function (response) {
                        $(".my-loader").hide();
                        if (response.status === 'success') {

                            showSuccess('Orders fetched successfully from Shining3D.');

                            let tbody = $('#shining3dOrderTable');
                            tbody.empty();

                            if (!response.result || response.result.length === 0) {
                                tbody.append(`
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            No orders found for selected date range.
                                        </td>
                                    </tr>
                                `);
                            } else {

                                response.result.forEach(function (order) {

                                    let patientName = order.patient?.name ?? '-';
                                    let phone = order.patient?.phone
                                        ? `+${order.patient.phoneArea} ${order.patient.phone}`
                                        : '-';

                                    let sex = order.patient?.sex ?? '-';
                                    let labName = order.lab?.name ?? '-';

                                    let createdAt = order.createOn
                                        ? new Date(order.createOn).toLocaleDateString()
                                        : '-';

                                    // -------------------------
                                    // STATUS MAPPING
                                    // -------------------------
                                    let statusText = order.status ?? 'unknown';
                                    let statusClass = 'secondary';

                                    switch (statusText) {
                                        case 'waitDelivery':
                                            statusText = 'Waiting for Delivery';
                                            statusClass = 'warning';
                                            break;

                                        case 'delivered':
                                            statusText = 'Delivered';
                                            statusClass = 'info';
                                            break;

                                        case 'completed':
                                            statusText = 'Completed';
                                            statusClass = 'success';
                                            break;

                                        case 'cancelled':
                                            statusText = 'Cancelled';
                                            statusClass = 'danger';
                                            break;
                                    }

                                    let statusBadge = `
                                        <span class="badge bg-${statusClass}">
                                            ${statusText}
                                        </span>
                                    `;
                                    let scanBtn = `
                                        <button class="btn btn-sm btn-primary view-scan"
                                                data-id="${order.id}">
                                            View
                                        </button>
                                    `;

                                    tbody.append(`
                                        <tr>
                                            <td>${patientName}</td>
                                            <td>${phone}</td>
                                            <td>${sex}</td>
                                            <td>${labName}</td>
                                            <td>${statusBadge}</td>
                                            <td>${createdAt}</td>
                                            <td>${scanBtn}</td>
                                        </tr>
                                    `);
                                });
                            }

                            $('#caseSearchRow').show();
                        } else {
                            showError(response.message || 'API returned an error.');
                        }

                        btn.prop('disabled', false).text('Get Scan');
                    },

                    error: function () {
                        $(".my-loader").hide();
                        showError('Unable to fetch data. Please try again.');
                        btn.prop('disabled', false).text('Get Scan');
                    }
                });

                // -------------------------------
                // HELPER FUNCTIONS
                // -------------------------------
                function showError(message) {
                    error
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .text(message)
                        .show();
                }

                function showSuccess(message) {
                    error
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .text(message)
                        .show();
                }
            }
        });

        $(document).on('keypress', '#order-from-shining3d-modal input', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#order-from-shining3d').trigger('click');
            }
        });

        $(document).on('click', '#order-from-shining3dmmm', function () {
            $(".my-loader").show();
            const btn   = $('#order-from-shining3d');
            const error = $('#shining3d-error');

            const region = $('#scanRegion').val();
            const start  = $('#startDate').val();
            const end    = $('#endDate').val();

            // const domainUrl = $(this).attr('data-base-url');
            // const authToken = $(this).attr('data-auth-token');
            // const orgCode = $(this).attr('data-org-code');
            // const doctorId = $(this).attr('data-doctor-id');
            // const orgType = $(this).attr('data-org-type');

            const authToken = $("#order-from-shining3d-label-model-shining3d-auth-token").val();
            const orgCode = $("#order-from-shining3d-label-model-shining3d-org-code").val();
            const doctorId = $("#order-from-shining3d-label-model-shining3d-doctor-id").val();
            const orgType = $("#order-from-shining3d-label-model-shining3d-org-type").val();
            // Reset message
            error.hide().removeClass('alert-success alert-danger').text('');

            // -------------------------------
            // VALIDATION
            // -------------------------------
            if (!region) return showError('Please select a region.');
            if (!start)  return showError('Please select Start Date.');
            if (!end)    return showError('Please select End Date.');

            const startDate = parseValidDate(start);
            const endDate   = parseValidDate(end);

            if (!startDate || !endDate) {
                return showError('Invalid date format11.');
            }

            if (endDate < startDate) {
                return showError('End Date cannot be earlier than Start Date.');
            }


            // Shining3D rule: minimum 3 days
            const diffDays = Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24));

            if (diffDays < 3) {
                return showError('Date range must be at least 3 days (Shining3D requirement).');
            }

            // -------------------------------
            // AJAX CALL
            // -------------------------------
            $.ajax({
                url: baseUrl + '/get-shining3d-order-list',
                type: 'POST',
                dataType: 'json',
                data: {
                    start_date: start,
                    end_date: end,
                    region : region,
                    authToken : authToken,
                    orgCode : orgCode,
                    doctorId : doctorId,
                    orgType : orgType,
                    _token: $('input[name="_token"]').val()
                },

                beforeSend: function () {
                    btn.prop('disabled', true).text('Loading...');
                },

                success: function (response) {
                    $(".my-loader").hide();
                    if (response.status === 'success') {

                        showSuccess('Orders fetched successfully from Shining3D.');

                        let tbody = $('#shining3dOrderTable');
                        tbody.empty();

                        if (!response.result || response.result.length === 0) {
                            tbody.append(`
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        No orders found for selected date range.
                                    </td>
                                </tr>
                            `);
                        } else {

                            response.result.forEach(function (order) {

                                let patientName = order.patient?.name ?? '-';
                                let phone = order.patient?.phone
                                    ? `+${order.patient.phoneArea} ${order.patient.phone}`
                                    : '-';

                                let sex = order.patient?.sex ?? '-';
                                let labName = order.lab?.name ?? '-';

                                let createdAt = order.createOn
                                    ? new Date(order.createOn).toLocaleDateString()
                                    : '-';

                                // -------------------------
                                // STATUS MAPPING
                                // -------------------------
                                let statusText = order.status ?? 'unknown';
                                let statusClass = 'secondary';

                                switch (statusText) {
                                    case 'waitDelivery':
                                        statusText = 'Waiting for Delivery';
                                        statusClass = 'warning';
                                        break;

                                    case 'delivered':
                                        statusText = 'Delivered';
                                        statusClass = 'info';
                                        break;

                                    case 'completed':
                                        statusText = 'Completed';
                                        statusClass = 'success';
                                        break;

                                    case 'cancelled':
                                        statusText = 'Cancelled';
                                        statusClass = 'danger';
                                        break;
                                }

                                let statusBadge = `
                                    <span class="badge bg-${statusClass}">
                                        ${statusText}
                                    </span>
                                `;
                                let scanBtn = `
                                    <button class="btn btn-sm btn-primary view-scan"
                                            data-id="${order.id}">
                                        View
                                    </button>
                                `;

                                tbody.append(`
                                    <tr>
                                        <td>${patientName}</td>
                                        <td>${phone}</td>
                                        <td>${sex}</td>
                                        <td>${labName}</td>
                                         <td>${statusBadge}</td>
                                        <td>${createdAt}</td>
                                        <td>${scanBtn}</td>
                                    </tr>
                                `);
                            });
                        }

                        $('#caseSearchRow').show();
                    } else {
                        showError(response.message || 'API returned an error.');
                    }

                    btn.prop('disabled', false).text('Get Scan');
                },

                error: function () {
                    $(".my-loader").hide();
                    showError('Unable to fetch data. Please try again.');
                    btn.prop('disabled', false).text('Get Scan');
                }
            });

            // -------------------------------
            // HELPER FUNCTIONS
            // -------------------------------
            function showError(message) {
                error
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .text(message)
                    .show();
            }

            function showSuccess(message) {
                error
                    .removeClass('alert-danger')
                    .addClass('alert-success')
                    .text(message)
                    .show();
            }
        });

        $(document).on('click', '.view-scan', function () {
            $(".my-loader").show();
            const orderId = $(this).data('id');
            const authToken = $("#order-from-shining3d-label-model-shining3d-auth-token").val();
            const csrfToken = $('#order-from-shining3d-label-model-shining3d-csrf-token').val();
            const orgCode = $("#order-from-shining3d-label-model-shining3d-org-code").val();
            const patientId = $("#order-from-shining3d-label-model-shining3d-patient-id").val();
            const treatmentPlanId = $("#order-from-shining3d-label-model-shining3d-treatment-plan-id").val();
            const domainUrl = $('#scanRegion').val();
            const error = $('#shining3d-error');

            $.ajax({
                url: baseUrl + '/data-download-shining3d-order',
                type: 'POST',
                dataType: 'json',
                data: {
                    orderId: orderId,
                    authToken : authToken,
                    csrfToken: csrfToken,
                    orgCode: orgCode,
                    patientId: patientId,
                    treatmentPlanId: treatmentPlanId,
                    domainUrl: domainUrl,
                    _token: $('input[name="_token"]').val()
                },
                success: function (response) {
                    if (response.status === 'success') {
                        $(".my-loader").hide();
                        showSuccess('Scan data fetched successfully.');
                        setTimeout(function () {
                            $("#order-from-shining3d-modal").modal('hide');
                            window.location.href = baseUrl + '/patient/edit/' + response.hashCode + '?tab=pill-tab-div2';
                        }, 2000); // 2000 milliseconds = 2 seconds
                    } else {
                        showError(response.message || 'API returned an error.');
                    }
                },

                error: function () {
                    $(".my-loader").hide();
                    showError('Unable to fetch data. Please try again.');
                    // btn.prop('disabled', false).text('Get Scan');
                }
            });

            function showError(message) {
                error
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .text(message)
                    .show();
            }

            function showSuccess(message) {
                error
                    .removeClass('alert-danger')
                    .addClass('alert-success')
                    .text(message)
                    .show();
            }
        });
    //    $(document).on('click', '#order-from-shining3d', function () {

    //         let region = $('#scanRegion').val();
    //         let start = $('#startDate').val();
    //         let end   = $('#endDate').val();
    //         let error = $('#shining3d-error');

    //         error.hide().text('');

    //         // -------------------------------
    //         //  VALIDATION
    //         // -------------------------------

    //         if (!region) {
    //             error.text("Please select a region.").show();
    //             return;
    //         }

    //         if (!start) {
    //             error.text("Please select Start Date.").show();
    //             return;
    //         }

    //         if (!end) {
    //             error.text("Please select End Date.").show();
    //             return;
    //         }

    //         // Convert to Date objects
    //         let startDate = new Date(start);
    //         let endDate = new Date(end);

    //         // Rule: end must be >= start
    //         if (endDate < startDate) {
    //             error.text("End Date cannot be earlier than Start Date.").show();
    //             return;
    //         }

    //         // Rule: Shining3D minimum 3-day range
    //         let diffDays = (endDate - startDate) / (1000 * 60 * 60 * 24);

    //         if (diffDays < 3) {
    //             error.text("Date range must be at least 3 days (as per Shining3D API requirement).").show();
    //             return;
    //         }

    //         // -------------------------------
    //         //  VALIDATION PASSED → AJAX CALL
    //         // -------------------------------

    //         $.ajax({
    //             url: baseUrl + "/get-shining3d-order-list",
    //             type: "POST",
    //             data: {
    //                 region: region,
    //                 start_date: start,
    //                 end_date: end,
    //                 _token: $('input[name="_token"]').val()
    //             },
    //             beforeSend: function () {
    //                 $('#order-from-shining3d').prop('disabled', true).text('Loading...');
    //             },
    //             success: function (response) {
    //                 console.log(response); // already an object

    //                 if (response.status === 'success') {
    //                     $('#order-from-shining3d')
    //                         .prop('disabled', false)
    //                         .text('Get Scan');

    //                     // Example: access data
    //                     console.log(response.result);
    //                     console.log(response.pageInfo);
    //                 } else {
    //                     error.text("API Error: " + response.message).show();
    //                     $('#order-from-shining3d').prop('disabled', false).text('Get Scan');
    //                 }
    //             },
    //             error: function (xhr) {
    //                 error.text("API Error: Unable to fetch data.").show();
    //                 $('#order-from-shining3d').prop('disabled', false).text('Get Scan');
    //             }
    //         });

    //     });


    };
    return {
        init: function(){
            add();
        },
    }
}();
