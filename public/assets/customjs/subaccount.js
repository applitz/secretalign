var Subaccount = function() {
    var list = function(){
        $("#subaccount-list").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseUrl + "/subaccounts",
                type: 'GET',
            },
            "columns": [

                { 'title': 'First Name', "data": "first_name", orderable: true, searchable: true},
                { 'title': 'Last Name', "data": "last_name", orderable: true, searchable: true},
                { 'title': 'Billing Address', "data": "billing_address", orderable: true, searchable: true},
                { 'title': 'Email', "data": "email", orderable: true, searchable: true},
                { 'title': 'Phone', "data": "phone", orderable: true, searchable: true},
                { 'title': 'Action', "data": "actions", orderable: false, searchable: false},
            ],
            "order": [[1, 'asc']],
            "responsive": true,
            "autoWidth": false,
            "lengthMenu": [10, 25, 50, 100],
        });
    }

    var addSubaccount = function(){
        $("#add-subaccount").validate({
            ignore: [],
            rules: {
                first_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                last_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: baseUrl + "/subaccounts/check-email", // make sure this is defined globally
                        type: "post",
                        data: {
                            _token: $('input[name="_token"]').val(),
                            email: function () {
                                return $("#email").val();
                            }
                        }
                    }
                },
                password: {
                    required: true,
                    minlength: 6,
                    pattern: /^(?=.*[a-z])(?=.*\d).+$/ // at least one lowercase and one digit
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                first_name: {
                    required: "First name is required.",
                    minlength: "First name must be at least 2 characters.",
                    maxlength: "First name cannot exceed 100 characters."
                },
                last_name: {
                    required: "Last name is required.",
                    minlength: "Last name must be at least 2 characters.",
                    maxlength: "Last name cannot exceed 100 characters."
                },
                phone_number: {
                    required: "Phone number is required.",
                    maxlength: "Phone number cannot exceed 20 characters."
                },
                billing_address: {
                    required: "Billing address is required.",
                    maxlength: "Billing address cannot exceed 500 characters."
                },
                email: {
                    required: "Email is required.",
                    email: "Please enter a valid email address.",
                    remote: "This email is already taken."
                },
                password: {
                    required: "Password is required.",
                    minlength: "Password must be at least 6 characters.",
                    pattern: "Password must contain at least one lowercase letter and one digit."
                },
                confirm_password: {
                    required: "Please confirm your password.",
                    equalTo: "Passwords do not match."
                }
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
                if (element.attr("name") === "email") {
                    // Force email error to appear after input-group if present
                    if (element.closest(".input-group").length) {
                        error.insertAfter(element.closest(".input-group"));
                    } else {
                        error.insertAfter(element);
                    }
                } else if (element.attr("type") === "radio") {
                    error.insertAfter(element.closest('.form-check').parent());
                } else if (element.closest(".input-group").length) {
                    error.insertAfter(element.closest(".input-group"));
                } else {
                    error.insertAfter(element);
                }
            }



        });
    }

    var editSubaccount = function(){

    }

    var handleDelete = function() {
        // Delegate click for dynamically loaded buttons
        $(document).on('click', '.delete-contact', function() {
            var url = $(this).data('url');
            $('#deleteForm').attr('action', url);
            $('#delete-modal').modal('show');
        });

        // Handle form submit
        // $('#deleteForm').on('submit', function(e) {
        //     e.preventDefault();
        //     var form = $(this);
        //     var url = form.attr('action');
        //     var btn = form.find('button[type="submit"]');
        //     btn.prop('disabled', true);
        //     $.ajax({
        //         url: url,
        //         type: 'POST',
        //         data: form.serialize(),
        //         success: function(response) {
        //             $('#delete-modal').modal('hide');
        //             btn.prop('disabled', false);
        //             if(response.success) {
        //                 toastr.success(response.message || 'Subaccount deleted successfully.');
        //                 $('#subaccount-list').DataTable().ajax.reload();
        //             } else {
        //                 toastr.error(response.message || 'Failed to delete subaccount.');
        //             }
        //         },
        //         error: function(xhr) {
        //             $('#delete-modal').modal('hide');
        //             btn.prop('disabled', false);
        //             var msg = 'Failed to delete subaccount.';
        //             if(xhr.responseJSON && xhr.responseJSON.message) {
        //                 msg = xhr.responseJSON.message;
        //             }
        //             toastr.error(msg);
        //         }
        //     });
        // });
    }

    return {
        init: function(){
            list();
            handleDelete();
        },
        add: function(){
            addSubaccount();
        },
        edit: function(){
            editSubaccount();
        }
    }
}();
