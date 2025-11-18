var AddPatient = function() {
    var addPatientFormHandler = function() {

    }
    var nextButtonHandler = function() {
        $(document).on('click', '.next-tab', function () {
            $(`${$(this).attr('data-target')}`).click();
        });
    }
    var previousButtonHandler = function() {
        $(document).on('click', '.previous-tab', function () {
            $(`${$(this).attr('data-target')}`).click();
        });
    }
    return {
        init: function() {
            // Initialization code for adding a patient can go here
            addPatientFormHandler();
            nextButtonHandler();
            previousButtonHandler();
        }
    };
}();
