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
            // optional-select-from-3shape
            $("#optional-select-from-3shape").on("click", function (e) {
                e.preventDefault();
                $("#optional-3shape-section-Modal").modal("show");
            });

            // Cancel button
            $("#optional-cancel-3shape-select").on("click", function () {
                $("#optional-3shape-section-Modal").modal("hide");
            });

        });
    }

    return {
        init: function(){
            add();
        },
    }
}();
