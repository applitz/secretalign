var Patients = function() {
    var list = function(){
        const fp = flatpickr($(".pickr"), {
           "mode": "range"
       });
        $("#patients-list").dataTable({
            "pageLength": 20,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                url: baseUrl + "/patients",
                type: 'GET',
                data: function(d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.ft_search = $('#ft_search').val(); // Match: input id="search"
                    d.status = $('#statuChooser').val(); // Match: select id="statuChooser"
                    d.date = $('#CRMDateRange').val(); // Match: input id="CRMDateRange"
                    d.case_holder = $('#ft_case_holder').val(); // Match: input id="ft_case_holder"
                },

            },
            "columns": [
                { 'title': 'ID', "data": "patientId", orderable: true, searchable: false },
                { 'title': 'Last Name', "data": "last_name", orderable: false, searchable: true },
                { 'title': 'First Name', "data": "first_name", orderable: false, searchable: true },
                { 'title': 'Birth Date', "data": "dob", orderable: false, searchable: true },
                { 'title': 'Package', "data": "package", orderable: false, searchable: false },
                { 'title': 'Status', "data": "status", orderable: false, searchable: false },
                { 'title': 'Case Holder', "data": "case_holder", orderable: false, searchable: false },
                { 'title': 'Due Date', "data": "due_date", orderable: false, searchable: false },
                { 'title': 'Treatment Type', "data": "treatment_type", orderable: false, searchable: false },
                { 'title': 'Setup Approval Date', "data": "setup_approval_date", orderable: false, searchable: false },
                { 'title': '', "data": "case_overview", orderable: false, searchable: false },
                { 'title': 'Continue Treatment', "data": "continue_treatment", orderable: false, searchable: false },
                { 'title': 'Request New Plan', "data": "request_new_plan", orderable: false, searchable: false },

            ],
            "order": [[1, 'DESC']],
            "responsive": true,
            "autoWidth": false,
            "lengthMenu": [10, 20, 50, 100],
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
            const aligner_steps = $(this).attr('data-aligner_steps');
            $('#confirmName').text(fullName);
            $('#newTreatmentLoop').val(loopIndex);
            $('#newTreatmentConfirmModal').modal('show');
            $('#confirmNewTreatmentBtn').attr("data-aligner_steps", aligner_steps);
        });

        // Step 2: After confirmation
        $('#confirmNewTreatmentBtn').on('click', function () {
            const aligner_steps = $(this).attr('data-aligner_steps');
            $('#newTreatmentConfirmModal').modal('hide');
            setTimeout(() => {
                $('#alignerTrackInput').val('');
                $('#alignerTrackModal').modal('show');
                $("#submitNewTreatmentBtn").attr("data-aligner_steps", aligner_steps);
            }, 300);
        });

        // Step 3: On input submit
        $('#submitNewTreatmentBtn').on('click', function () {
            const input = $('#alignerTrackInput').val().trim();
            const aligner_steps = $(this).attr('data-aligner_steps');
            const loopIteration = $('#newTreatmentLoop').val();
            const inputNumber = parseInt(input, 10);

            if (!input) {
                toastError("Please enter the aligner number.");
                return;
            }

            // Validate whole number
            if (isNaN(inputNumber) || !Number.isInteger(inputNumber)) {
                toastError("Please enter a valid whole number!");
                return;
            }

            // Validate range
            if (inputNumber < 1 || inputNumber > aligner_steps) {
                toastError("Please enter a number between 1 and " + aligner_steps);
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


    }

    return {
        init: function(){
            list();
        },
    }
}();
