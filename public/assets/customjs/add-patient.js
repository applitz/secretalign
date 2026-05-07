var AddPatient = function() {
    var addPatientFormHandler = function() {
        $(document).on('change', '.trim_type_upper', function(){
            var selectedValue = $(this).val();
            if(selectedValue == 'Straight'){
                $("#trim_type_upper_show").removeClass('d-none');
            }else {
                $("#trim_type_upper_show").addClass('d-none');
            }
        });

        $(document).on('change', '.trim_type_lower', function(){
            var selectedValue = $(this).val();
            if(selectedValue == 'Straight'){
                $("#trim_type_lower_show").removeClass('d-none');
            }else {
                $("#trim_type_lower_show").addClass('d-none');
            }
        });
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
