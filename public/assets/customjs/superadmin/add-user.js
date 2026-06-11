var AddUser = function() {
    var AddUserFormHandler = function() {

        $(document).on("change", "#role", function() {
            $('.select2').select2({
                closeOnSelect: false
            });
        });
    }

    return {
        init: function() {
            AddUserFormHandler();
        }
    };
}();
