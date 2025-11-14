@extends('layouts.app_base_horizontal')

@section('css')
<link href="{{ asset('public') }}/dashboard/vendors/glightbox/glightbox.min.css" rel="stylesheet">
<link href="{{ asset('public') }}/dashboard/vendors/prism/prism-okaidia.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('public/') }}/filepond/dist/filepond.css">
<link rel="stylesheet" href="{{ asset('public/') }}/filepond/dist/filepond-plugin-image-preview.css">
<link rel="stylesheet" href="{{ asset('public/assets') }}/restrictions.css">
<script src="{{ asset('public/assets/three/build/three.js') }}"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

<!-- Lightbox JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js" defer></script>
<script type="importmap">
    {
        "imports": {
            "three": "{{asset('public/assets/three/build/three.module.js')}}",
            "OrbitControls": "{{asset('public/assets/three/examples/jsm/controls/OrbitControls.js')}}"
        }
    }
</script>

<style>
.lb-data .lb-close {
    display: block;
    /* float: right; */
    position: fixed;
    right: 25px;
    top: 17px;
}
.lb-nav a.lb-next,.lb-nav a.lb-prev {
opacity:1;

}
    #scan-data-canvas {
        max-height: 220px;
    }


    #sharesmile-canvas {
        opacity: 0;
    }

    #sharesmile-canvas[state=loaded] {
        opacity: 1;
    }

    div#canvas canvas {
        margin: 0 auto;
        /*border: 10px solid #c3e8f8;*/
        /*background: #f2f2f2;*/
    }

    .canvas-bg {
        background: #aaaaaa;
    }
</style>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
@stop

@section('content')
<div class="page-content">

    @if(@$_GET['i'] != 'true')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Patients</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/patients')}}">Patients</a></li>
                        <li class="breadcrumb-item active">Case Overview</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endif

    @include("patients.case_overview_el")


@if(Auth::user()->role == 'superadmin')
    <form method="POST" action="{{url('/pateint/treatment-plan/cancel-request')}}">@csrf
        <input type="hidden" name="treatment_plan_id" value="{{$patient->id}}">block-edit
        <div class="modal fade bs-example-modal-center" id="cancelPlan" tabindex="-1" role="dialog"
                                            aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0">Cancel Requested Plan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="fw-bolder text-danger">Are you really want to cancel the requested case? The change will be permanent and you will not be able to reverse it.</p>
                                                        <div class="mb-3">
                                                            <label class="form-label">Enter your password to confirm</label>
                                                            <input required type="password" class="form-control" name="password" placeholder="*******">
                                                        </div>
                                                        <div class="mb-3">
                                                            <button type="submit" class="btn btn-danger" >Confirm</button>
                                                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
    </form>

@endif
@stop
@php
$upper_arch_stl = asset('/storage/PatientFiles/Patient' .
$patient->patient_id . '/' . $patient->fl_upper_arch);
$lower_arch_stl = asset('/storage/PatientFiles/Patient' .
$patient->patient_id . '/' . $patient->fl_lower_arch);
@endphp

@section('javascript')
<script src="{{ asset('public') }}/dashboard/vendors/glightbox/glightbox.min.js"></script>
<script src="{{ asset('public') }}/dashboard/vendors/prism/prism.js"></script>

<script>
    const PHASE = '{{$patient->phase}}'
    var link_regex =
            /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,}))\.?)(?::\d{2,5})?(?:[/?#]\S*)?$/
        $(document).ready(function() {

            $(document).on('click', '.update-package', function () {

                const current = $(this).attr('data-current');
                let message = "";
                if(current == 'AL-SECRET-CONFIDENCE') {
                    message = "Do you really want to change pricing package from "+current+" to "+" SECRET SELECT ?";
                } else {
                    message = "Do you really want to change pricing package from "+current+" to "+" SECRET CONFIDENCE ?";
                }
                const c = confirm(message);
                if(c) {
                    $.ajax({
                        type: "POST",
                        url: "{{url('/patient/case-overview/chane-pricing-package')}}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                        "treatment_plan_id": "{{ $patient->id }}", //treatment plan id
                        }
                    }).done(function (response) {
                        if(response.status == 200) {
                            window.location.reload();
                        } else {
                            toastError("Enable to change pricing package.");
                        }
                    }).fail(function (response) {
                        toastError("Enable to change pricing package.");
                    });
                }
            });
            $("#block-edit").one('click', function() {
                var $this = $(this);
                var data = $this.attr('data');
                var html = ``;
                if (data == '1') {
                    html = `<span class="fas fas fa-edit me-2"></span>Allow Edit`;
                } else {
                    html = `<span class="fas fas fa-edit me-2"></span>Disable Edit`;
                }
                $.ajax({
                    type: "POST",
                    url: "{{ url('/patient/case/allow-user-to-edit') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "treatment_plan_id": "{{ $patient->id }}", //treatment plan id
                    }
                }).done(function(response) {
                    $this.html(html);
                    $this.attr('data', data == '1' ? '0' : '1');
                    if (data == '1') {
                        toastSuccess("Case Edit Disabled");
                    } else {
                        toastSuccess("Case Edit Allowed")
                    }
                    location.reload();
                }).fail(function(response) {
                    toastError("Enable to proceed with request.");
                })
            });
            $(document).on('click', '#load-more-comments', function() {
                var $this = $(this);
                var page = $this.attr('data-current');
                var last = parseInt($this.attr('data-last'));
                var nextPage = (parseInt(page) + 1);
                $.ajax({
                    type: "GET",
                    url: "{{ url('/patient/case-overview/load-comments/' . $patient->id) }}?page=" +
                        nextPage,
                }).done(function(response) {
                    $("#case-overview-comments").append(response);
                    $this.attr('data-current', nextPage);
                    if (nextPage >= last) {
                        $this.remove();
                    }
                }).fail(function(response) {
                    toastError("Enable to load more comments.");
                });
            });
            $(document).on('change', '.hyperlink', function() {
                var link = $(this).val();
                if (!link_regex.test(link)) {
                    $(this).val('');
                }
            });
            $(document).on('input', '.hyperlink', function() {
                var link = $(this).val();
                if (link_regex.test(link)) {
                    $(this).removeClass('is-invalid');
                } else {
                    $(this).addClass('is-invalid');
                }
            });

            $(document).on("input", "input[name='no_of_steps']", function() {
                var inputVal = $(this).val();
                inputVal = inputVal.replace(/[^0-9]/g, ''); // Remove non-numeric characters
                if (inputVal ==
                    '') { // If input is empty or 0, set value to an empty string || inputVal == '0'
                    inputVal = '';
                }
                $(this).val(inputVal); // Set input value
            });

            // $("input[name=terms2]").on('change', function () {
            //     if($(this).is(':checked')) {
            //         $("#dataProcessingTemplate").modal('show');
            //     }
            // })

            $("#approve").on('click', function() {

                var comment = $("#comment").val();
               // alert(comment);
                var $this = $(".btn-action");
                if(!$("input[name=terms2]").is(":checked")) {
                    toastError("You must agree to terms & conditions");
                    return false;
                }
                $($this).prop("disabled", true);
                var formData=new FormData();
   formData.append('treatment_plan_id','{{ $patient->id }}')
                formData.append('comment',comment)
               var fileInput = document.getElementById('attachments');

                formData.append('_token','{{ csrf_token() }}')
for (var i = 0; i < fileInput.files.length; i++) {
    formData.append('attachments[]', fileInput.files[i]);
}

                $.ajax({
                    type: "POST",
                    url: "{{ url('/patient/case-overview/case/approve') }}",
                    data: formData,
                    processData: false, // Required for FormData
        contentType: false, // Required for FormData
        cache: false,
                }).done(function(response) {
                    $("#comment").val('');
                    $("#panel").remove();
                    toastSuccess("Case approved!");
                }).fail(function(response) {
                    console.log(response)
                    $($this).prop("disabled", false);
                    toastError("Enable to approve case");
                });
            });
            $("#staff-reject-treatment").on('click', function() {
                var comment = $("#comment").val();
                var c = confirm("Are you really want to reject the treatment plan?");
                var $this = $(".btn-action");
                if (c) {
                    $($this).prop("disabled", true);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('reject-treatment') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "comment": comment,
                            "treatment_plan_id": "{{ $patient->id }}", //treatment plan id
                        }
                    }).done(function(response) {
                        $("#comment").val('');
                        $("#panel").remove();
                        toastSuccess("Case rejected!");
                    }).fail(function(response) {
                        console.log(response)
                        $($this).prop("disabled", false);
                        toastError("Enable to reject treatment");
                    });
                }
            });
$("#staff-submit-tracking-id").on('click', function () {
   // alert("true");
    var comment = $("#comment").val();
    var tracking_id = $("#tracking_id").val();
    var $this = $('.btn-action');
    if(tracking_id == "" || tracking_id == undefined) {
        toastError("Tracking Nr. is required");
        return false;
    }
    $this.prop("disabled", true);

       var formData=new FormData();
   formData.append('treatment_plan_id','{{ $patient->id }}')
                formData.append('comment',comment)
                 formData.append('tracking_id',tracking_id)
               var fileInput = document.getElementById('attachments');

                formData.append('_token','{{ csrf_token() }}')
for (var i = 0; i < fileInput.files.length; i++) {
    formData.append('attachments[]', fileInput.files[i]);
}



    $.ajax({
        type: "POST",
        url: "{{url('/patient/case-overview/submit/tracking-id')}}",
        data: formData,
                      cache:false,
                    processData:false,
                    contentType:false,
    }).done(function (response) {
        $("#comment").val('');
        toastSuccess("Tracking Nr. sent to doctor");
    }).fail(function (response) {
        $($this).prop('disabled', false);
        toastError("Enable to send tracking Nr.");
    });
});

            $("#request-setup-files").on('click', function () {
               // alert("true");
                var comment = $("#comment").val();
              //  alert(comment);
                var $this = $(".btn-action");
                $this.prop("disabled", true);


       var formData=new FormData();
   formData.append('treatment_plan_id','{{ $patient->id }}')
                formData.append('comment',comment)

                formData.append('_token','{{ csrf_token() }}')
                 var fileInput = document.getElementById('attachments');

for (var i = 0; i < fileInput.files.length; i++) {
    formData.append('attachments[]', fileInput.files[i]);
}


                $.ajax({
                    type: "POST",
                    url: "{{url('/pastient/case-overview/request-setup-files-from-lab')}}",
                    data: formData,
                      cache:false,
                    processData:false,
                    contentType:false,
                }).done(function (response) {
                    $("#comment").val('');
                    $("#panel").remove();
                    toastSuccess("Case sent to lab!");
                }).fail(function (response) {
                    $(this).prop("disabled", false);
                    toastError("Enable to send case to lab!");
                });
            });

            $("#lab-send-to-staff").on('click', function() {
                var $this = $(".btn-action");
                var comment = $("#comment").val();
                $($this).prop("disabled", true);

                   var formData=new FormData();
   formData.append('treatment_plan_id','{{ $patient->id }}')
                formData.append('comment',comment)
               var fileInput = document.getElementById('attachments');

                formData.append('_token','{{ csrf_token() }}')
for (var i = 0; i < fileInput.files.length; i++) {
    formData.append('attachments[]', fileInput.files[i]);
}


                $.ajax({
                    type: "POST",
                    url: "{{ url('/patient/case-overiew/send-from-lab-to-staff') }}",
                 data: formData,
                      cache:false,
                    processData:false,
                    contentType:false,
                }).done(function(response) {
                    $("#comment").val('');
                    $("#treatment_link").val('');
                    $("#patient_link").val('');
                    $("#iframe_link").val('');
                    $("#panel").remove();
                    toastSuccess("Case sent to staff!");
                }).fail(function(response) {
                   // console.log(response);
                    $($this).prop("disabled", false);
                    toastError("Enable to send case to staff!");
                });
            });

            $("#lab-cancel-request").on('click', function() {
                var $this = $(".btn-action");
                var comment = $("#comment").val();
                var c = confirm("Are you really want to cancel the request?");
                if (c) {
                    $($this).prop("disabled", true);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('cancel-treatment') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "comment": comment,
                            "treatment_plan_id": "{{ $patient->id }}",
                        }
                    }).done(function(response) {
                        $("#comment").val('');
                        $("#panel").remove();
                        toastSuccess("You have canceled request for treatment plan!");
                    }).fail(function(response) {
                        $($this).prop("disabled", false);
                        console.log(response)
                        toastError("Enable to cancel request!");
                    });
                }
            });

            $("#submit-treatment").on('click', function() {
                var $this = $(".btn-action");
                var comment = $("#comment").val();
                var treatment_link = $("#treatment_link").val();

              //  alert(patient_link);
                var iframe_link = $("#iframe_link").val();
                var patient_link = $("#patient_link").val();
                if(PHASE == '1') {
                    if (!link_regex.test(treatment_link) && !link_regex.test(iframe_link) && !link_regex.test(patient_link)) {
                        toastError("Enter valid File & Iframe Links.");
                        return false;
                    }
                } else {
                    if (!link_regex.test(treatment_link)) {
                        toastError("Enter valid File Link.");
                        return false;
                    }
                }

                  var formData=new FormData();
                $($this).prop("disabled", true);
                formData.append('treatment_plan_id','{{ $patient->id }}')
                formData.append('comment',comment)
                    formData.append('treatment_link',treatment_link)
                    formData.append('iframe_link',iframe_link)
                    formData.append('patient_link',patient_link)
                formData.append('_token','{{ csrf_token() }}')
                 var fileInput = document.getElementById('attachments');

for (var i = 0; i < fileInput.files.length; i++) {
    formData.append('attachments[]', fileInput.files[i]);
}

                $($this).prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "{{ route('submit-treatment') }}",
                    data: formData,
                      cache:false,
                    processData:false,
                    contentType:false,
                }).done(function(response) {
                    $("#comment").val('');
                    $("#treatment_link").val('');

                    $("#iframe_link").val('');
                    $("#patient_link").val('');
                    $("#panel").remove();
                    toastSuccess("Case Treatment Plan submitted!");
                }).fail(function(response) {
                $($this).prop("disabled", false);
                console.error(response.responseText); // Log the response for debugging
                toastError("Enable to send case to staff!");
                });
            });

            $("#submit-setup-files").on('click', function () {
                var $this = $(".btn-action");
                var comment = $("#comment").val();
                var setup_files_link = $("#setup_files_link").val();
                if(!link_regex.test(setup_files_link)) {
                    toastError("Enter valid File Link");
                    return false;
                }
                $($this).prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "{{ url('/patient/case-overview/submit-setup-files') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "comment": comment,
                        "setup_files_link": setup_files_link,
                        "treatment_plan_id": "{{ $patient->id }}", //treatment plan id
                    }
                }).done(function (response) {
                    $("#comment").val('');
                    $("#setup_files_link").val('');
                    $("#panel").remove();
                    toastSuccess("Case sent to staff!");
                }).fail(function (response) {
                    $($this).prop("disabled", false);
                    toastError("Enable to send case to staff!");
                });
            });

            $("#request-treatment").on('click', function() {
               // alert("true");
                var $this = $(".btn-action");
                var lab = $("#lab").val();
               // console.log(lab);
                var comment = $("#comment").val();
                if (lab == '' || lab == null || lab == undefined) {
                    toastError("Select Lab to Send!");
                    return false;
                }
                   var formData=new FormData();
                $($this).prop("disabled", true);
                formData.append('treatment_plan_id','{{ $patient->id }}')
                formData.append('comment',comment)
                    formData.append('lab',lab)
                formData.append('_token','{{ csrf_token() }}')
                var fileInput = document.getElementById('attachments');

// Loop through each file selected and append them to FormData
for (var i = 0; i < fileInput.files.length; i++) {
    formData.append('attachments[]', fileInput.files[i]);
}
                $.ajax({
                    type: "POST",
                    url: "{{ route('request-treatment') }}",
                      data:  formData,
                    cache:false,
                    processData:false,
                    contentType:false,
                }).done(function(response) {
                    $("#comment").val('');
                    $("#lab").val('');
                    $("#panel").remove();
                    $("#block-edit").attr('data', '0');
                    $("#block-edit").html(`<span class="fas fas fa-edit me-2"></span>Allow Edit`);
                    toastSuccess("Case sent to Lab!");
                }).fail(function(response) {
                    $($this).prop("disabled", false);
                    console.log(response)
                    toastError("Enable to send case to Lab!");
                });
            });

            $("#send-to-lab-for-modification").on('click', function() {
                var $this = $(".btn-action");
                var comment = $("#comment").val();
                   var formData=new FormData();
                $($this).prop("disabled", true);
                formData.append('treatment_plan_id','{{ $patient->id }}')
                formData.append('comment',comment)
                formData.append('_token','{{ csrf_token() }}')
                var fileInput = document.getElementById('attachments');

// Loop through each file selected and append them to FormData
for (var i = 0; i < fileInput.files.length; i++) {
    formData.append('attachments[]', fileInput.files[i]);
}
                $.ajax({
                    type: "POST",
                    url: "{{ route('request.modification') }}",
                     data:  formData,
                    cache:false,
                    processData:false,
                    contentType:false,
                }).done(function(response) {
                    $("#comment").val('');
                    $("#panel").remove();
                    toastSuccess("Case sent to lab for modification!");
                }).fail(function(response) {
                    $($this).prop("disabled", false);
                    console.log(response)
                    toastError("Enable to send case to lab.");
                });
            });

            $("#staff-send-to-lab").on('click', function() {
    var $this = $(".btn-action");
    var comment = $("#comment").val();
   // alert(comment);
    var formData = new FormData();

    // Disable the button to prevent multiple submissions
    $($this).prop("disabled", true);

    // Append necessary data to FormData
    formData.append('treatment_plan_id', '{{ $patient->id }}');
    formData.append('comment', comment);
    formData.append('_token', '{{ csrf_token() }}');

    // Add file attachments to FormData
    var fileInput = document.getElementById('attachments');
    if (fileInput) {
        for (var i = 0; i < fileInput.files.length; i++) {
            formData.append('attachments[]', fileInput.files[i]);
        }
    }

    // Perform the AJAX request
    $.ajax({
        type: "POST",
        url: "{{ url('/patient/case-overview/send-to-lab') }}",
        data: formData,
        processData: false, // Required for FormData
        contentType: false, // Required for FormData
        cache: false,
    }).done(function(response) {
        // Reset the form and UI on success
        $("#comment").val('');
        $("#panel").remove();
        $("#block-edit").attr('data', '0');
        $("#block-edit").html(`<span class="fas fas fa-edit me-2"></span>Allow Edit`);
        toastSuccess("Case sent to Lab!");
    }).fail(function(response) {
        // Enable the button and show an error on failure
        $($this).prop("disabled", false);
        console.log(response);
        toastError("Unable to send case to Lab!");
    });
});

            $("#staff-send-to-doctor").on('click', function() {
                var $this = $(".btn-action");
                var comment = $("#comment").val();
                $(this).prop("disabled", true);
                 var formData=new FormData();
                formData.append('treatment_plan_id','{{ $patient->id }}')
                formData.append('comment',comment)
                formData.append('_token','{{ csrf_token() }}')
                var fileInput = document.getElementById('attachments');

// Loop through each file selected and append them to FormData
for (var i = 0; i < fileInput.files.length; i++) {
    formData.append('attachments[]', fileInput.files[i]);
}
                $.ajax({
                    "type": "POST",
                    "url": "{{ url('/patient/case-overiew/send-from-staff-to-doctor') }}",
                    data:formData ,
                    cache:false,
                    processData:false,
                    contentType:false,
                }).done(function(response) {
                    $("#comment").val('');
                    $("#lab").val('');
                    $("#panel").remove();
                    toastSuccess("Case sent to doctor!");
                }).fail(function(response) {
                    $($this).prop("disabled", false);
                    console.log(response);
                    toastError("Enable to send case to doctor!");
                });
            });
            $("#staff-send-to-doctor-for-approval").on('click', function() {
                var $this = $(".btn-action");
                var comment = $("#comment").val();
                var steps = $("#no_of_steps").val();
                if (steps == '' || steps == null || steps == undefined || steps == NaN || parseInt(steps) <
                    0) {
                    toastError("steps should not be empty and greate then 0!");
                    return false;
                }
                $($this).prop("disabled", true);

                 var formData=new FormData();
                formData.append('treatment_plan_id','{{ $patient->id }}')
                formData.append('comment',comment)
                formData.append('steps',steps)
                formData.append('_token','{{ csrf_token() }}')
                var fileInput = document.getElementById('attachments');

// Loop through each file selected and append them to FormData
for (var i = 0; i < fileInput.files.length; i++) {
    formData.append('attachments[]', fileInput.files[i]);
}


                $.ajax({
                    "type": "POST",
                    "url": "{{ url('/patient/case-overiew/send-from-staff-to-doctor') }}",
                    data:  formData,
                    cache:false,
                    processData:false,
                    contentType:false,
                }).done(function(response) {
                    if (response.status == 400) {
                        $($this).prop("disabled", false);
                        toastError("Enable to send case to doctor!");
                    } else {
                        $("#comment").val('');
                        $("#lab").val('');
                        $("#panel").remove();
                        toastSuccess("Case sent to doctor!");
                    }

                }).fail(function(response) {
                    $($this).prop("disabled", false);
                    console.log(response);
                    toastError("Enable to send case to doctor!");
                });
            });
            $("#doctor-send-to-staff").on('click', function() {
                var $this = $(".btn-action");
                var comment = $("#comment").val();
                $($this).prop("disabled", true);
                var formData=new FormData();
                  formData.append('_token','{{ csrf_token() }}')
           formData.append('treatment_plan_id','{{ $patient->id }}')
                formData.append('comment',comment)
// Loop through each file selected and append them to FormData
                 var fileInput = document.getElementById('attachments');

for (var i = 0; i < fileInput.files.length; i++) {
    formData.append('attachments[]', fileInput.files[i]);
}
                $.ajax({
                    "type": "POST",
                    "url": "{{ url('/patient/case-overview/send-from-doctor-to-staff') }}",
                    data: formData,
                    cache:false,
                    processData:false,
                    contentType:false,
                }).done(function(response) {
                    $("#comment").val('');
                    $("#panel").remove();
                    toastSuccess("Case sent to staff!");
                }).fail(function(response) {
                    $($this).prop("disabled", false);
                    console.log(response);
                    toastError("Enable to send case to staff!");
                });
            });

            $("#advisor-send-to-doctor").on('click', function() {
                var $this = $(".btn-action");
                var comment = $("#comment").val();
                $($this).prop("disabled", true);
                var formData=new FormData();
                formData.append('_token','{{ csrf_token() }}')
                formData.append('treatment_plan_id','{{ $patient->id }}')
                formData.append('comment',comment)
                var fileInput = document.getElementById('attachments');

                for (var i = 0; i < fileInput.files.length; i++) {
                    formData.append('attachments[]', fileInput.files[i]);
                }
                $.ajax({
                    "type": "POST",
                    "url": "{{ url('/patient/case-overview/send-from-advisor-to-doctor') }}",
                    data: formData,
                    cache:false,
                    processData:false,
                    contentType:false,
                }).done(function(response) {
                    $("#comment").val('');
                    $("#panel").remove();
                    toastSuccess("Case sent for review to staff!");
                }).fail(function(response) {
                    $($this).prop("disabled", false);
                    console.log(response);
                    toastError("Enable to send case to staff!");
                });
            });

            $(".reopen-case").on('click', function() {
                var $this = this
                $($this).prop("disabled", true);
                $.ajax({
                    "type": "POST",
                    "url": "{{ url('/patient/case-overview/case/reopen') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "treatment_plan_id": "{{ $patient->id }}", //treatment plan id
                    }
                }).done(function(response) {
                    $($this).remove();
                    toastSuccess("Case reopened!");
                }).fail(function(response) {
                    $($this).prop("disabled", false);
                    toastError("Enable to reopen case!");
                });
            });
        });
</script>
@if ($patient->fl_upper_arch && $patient->fl_lower_arch && $patient->is_treatment_submitted == 0)
<script type="module">
    import { STLLoader } from "{{asset('public/assets/three/examples/jsm/loaders/STLLoader.js')}}";
    import { PLYLoader } from "{{asset('public/assets/three/examples/jsm/loaders/PLYLoader.js')}}";
            import { OrbitControls } from '{{asset("public/assets/three/examples/jsm/controls/OrbitControls.js")}}';

 //initial setup (scene, camera, renderer, material, controls, etc)
 const container = document.getElementById( 'canvas' );
            const scene = new THREE.Scene();
            scene.name = 'myscene';
            scene.background = new THREE.Color( 0xaaaaaa );
            const camera = new THREE.PerspectiveCamera(10, 1420/764 , 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({ antialias: true });
            @if(@$patient->fl_upper_arch)
            @if(explode(".", @$patient->fl_upper_arch)[1] == "stl")
            const material = new THREE.MeshNormalMaterial();
            @else
            const material = new THREE.MeshStandardMaterial({
                    vertexColors: THREE.VertexColors,
                    flatShading: true
                });
            @endif
            @endif
            const controls = new OrbitControls(camera, renderer.domElement, { enableRotate: true });
            controls.enableDamping = true;

            var filesLoaded = 0;
            var element = document.getElementById("progress-wrapper");
			var loadingBar = document.getElementById("loading-bar");
			const buttons = document.querySelectorAll('.step-control');
			// const labels = document.querySelectorAll('.step-trigger');

			var totalFiles = 2;
			var percentage = (100/totalFiles);
			var currentProgress = 0;

            THREE.Cache.enabled = true;

            //modify renderer
            renderer.setSize( window.innerWidth, window.innerHeight );

            //append renderer to body
            document.body.appendChild( renderer.domElement );


// Lighting
const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
    directionalLight.position.set(1, 1, 1).normalize();
    scene.add(directionalLight);

            //prepare STL Loader

            @if(@$patient->fl_upper_arch)
                @if(explode(".", $patient->fl_upper_arch)[1] == "stl")
                    const loader = new STLLoader()
                @else
                    const loader = new PLYLoader()
                @endif
            @endif

            //load upper arch STL file
            loader.load('<?php echo $upper_arch_stl; ?>',
            function (geometry) {
                @if(@$patient->fl_upper_arch)
            @if(explode(".", @$patient->fl_upper_arch)[1] == "ply")
            geometry.computeVertexNormals();
            @endif
            @endif
                const mesh = new THREE.Mesh(geometry, material)
                mesh.name = 'maxillary';
                mesh.tag = 'base';
                scene.add(mesh);
                filesLoaded++;
                currentProgress += percentage;
                loadingBar.style.width = currentProgress+'%';
                loadingBar.textContent = Math.floor(currentProgress)+'%';
                // console.log('scene updated');
                // Output the axis of the model
            },
            (xhr) => {
                // console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
            },
            (error) => {
                console.log(error)
            })
            loader.load('<?php echo $lower_arch_stl; ?>',
            function (geometry) {
                @if(@$patient->fl_upper_arch)
            @if(explode(".", @$patient->fl_upper_arch)[1] == "ply")
            geometry.computeVertexNormals();
            @endif
            @endif
                const mesh = new THREE.Mesh(geometry, material)
                mesh.name = 'mandibular';
                mesh.tag = 'base'
                scene.add(mesh);
                filesLoaded++;
                currentProgress += percentage;
                loadingBar.style.width = currentProgress+'%' + ' modules loaded';
                loadingBar.textContent = Math.floor(currentProgress)+'%';

                // console.log('scene updated');
                // console.log(scene);
            },
            (xhr) => {
                // console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
            },
            (error) => {
                console.log(error)
            });
            camera.position.z = 10;
            camera.position.x = 0;
            camera.position.y = -6;
            scene.scale.set(0.02,0.02,0.02);
            controls.update();
            const divs = document.querySelectorAll('.model-control');
			divs.forEach(el => el.addEventListener('click', event => {
			  console.log(event.target.getAttribute("id"));
			  const objectid = event.target.getAttribute("id");
			  const visible = event.target.getAttribute("data-visible");
			  const camera_z = event.target.getAttribute("data-cameraz");
			  const camera_x = event.target.getAttribute("data-camerax");
              jQuery('.current-view').text(camera_z+','+camera_x+','+objectid);
			  scene.traverse(function(object){
				        console.log(object);
				        if (object.visible === true && object.type === "Mesh"){
				        	document.getElementById('current-module').textContent = object.tag;
				        }
				        if (visible === '1'){
				        	if (object.tag === document.getElementById('current-module').textContent && object.type === "Mesh"){
					        	object.visible = true;
					        	camera.position.z = camera_z;
					            camera.position.x = camera_x;
					            camera.position.y = 0;
					        }
					        if (object.tag === document.getElementById('current-module').textContent && object.type === "Mesh" && object.visible == false){
					        	// alert(object.tag+' hidden');
					        	object.visible = true;
					        	camera.position.z = camera_z;
					            camera.position.x = camera_x;
					            camera.position.y = 0;
					        }
				        }
				        else{
				        	if (objectid != object.name && object.type == 'Mesh' && object.tag == document.getElementById('current-module').textContent){
				        		object.visible = false;
				        		console.log(object);
				        	}
				        	if (objectid == object.name && object.type == 'Mesh' && object.tag == document.getElementById('current-module').textContent){
				        		object.visible = true;
				        		camera.position.z = 0;
				        	    camera.position.x = 0;
				        	    camera.position.y = camera_x;
				        	    console.log(object);
				        	}
				        }
				    });
			}));
            var i = 0;
            var m = 0;
			// function loadModels() {
                for (let i = 0; i < buttons.length; i++) {
                    // setTimeout(function(){


                    loader.load(buttons[i].getAttribute("data-maxillary"),
                        function (geometry) {
                            const mesh = new THREE.Mesh(geometry, material)
                            mesh.name = 'maxillary';
                            mesh.visible = false;
                            mesh.tag = buttons[i].getAttribute("id");
                            scene.add(mesh);
                            filesLoaded++;
                            currentProgress += percentage;
                            loadingBar.style.width = currentProgress+'%';
                            loadingBar.textContent = Math.floor(currentProgress)+'%' + ' modules loaded';
                            console.log('scene updated');
                            console.log(scene);
                            if (currentProgress > 95){
                                jQuery('#progress-wrapper').remove();
                            }
                        },
                        (xhr) => {
                            console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
                        },
                        (error) => {
                            console.log(error)
                        }, (success) => {

                        });
                    loader.load(buttons[i].getAttribute("data-mandibular"),
                        function (geometry) {
                            const mesh = new THREE.Mesh(geometry, material)
                            mesh.name = 'mandibular';
                            mesh.visible = false;
                            mesh.tag = buttons[i].getAttribute("id");
                            scene.add(mesh);
                            filesLoaded++;
                            currentProgress += percentage;
                            loadingBar.style.width = currentProgress+'%';
                            loadingBar.textContent = Math.floor(currentProgress)+'%' + ' modules loaded';
                            console.log('scene updated');
                            console.log(scene);
                            if (currentProgress > 95){
                                jQuery('#progress-wrapper').remove();
                            }
                        },
                        (xhr) => {
                            console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
                        },
                        (error) => {
                            console.log(error)
                        }, (success) => {

                        });
                    // },i * 50);
                }



// jQuery('#slider').on('hover',function(){
// event.preventDefault();
// });

// document.getElementById('slider').addEventListener('mousedown', onDocumentMouseMove);
// document.getElementById('slider').addEventListener('mouseup', onDocumentMouseMove);
// document.getElementById('slider').addEventListener('mousemove', onDocumentMouseMove);


// document.getElementById('slider').addEventListener('mousedown', onDocumentMouseMove);
document.getElementById('slider').addEventListener('mousedown', function(event) {
    document.getElementById('slider').addEventListener('mousemove', onDocumentMouseMove);
    document.getElementById('slider').addEventListener('mouseout', function(event) {
        document.getElementById('slider').removeEventListener('mousemove', onDocumentMouseMove);
    });
});
document.addEventListener('mouseup', function(event) {
    document.getElementById('slider').removeEventListener('mousemove', onDocumentMouseMove);
});

var quaternion = new THREE.Quaternion();
function onDocumentMouseMove( event ) {
    quaternion.setFromAxisAngle( new THREE.Vector3( 1, 0, 0 ), event.clientX * Math.PI / 360 );
    scene.children.forEach(function(mesh) {
        mesh.rotation.setFromQuaternion(quaternion);
    });
}



			buttons.forEach(el => el.addEventListener('click', event => {
			  var camera_z = event.target.getAttribute("data-cameraz");
			  var camera_x = event.target.getAttribute("data-camerax");
			  var objectid = event.target.getAttribute("id");
			  camera.position.z = camera_z;
              camera.position.x = camera_x;
               objectid = event.target.getAttribute("id");
              // alert(camera.position.x);
              // alert(camera.position.z);
              if (jQuery('.current-view').text().length > 0){
                // camera.position.y = -6;
                var info = jQuery('.current-view').text().split(',');
                if (info[0] !== 'null' && info[2] !== 'maxillary' && info[2] !== 'mandibular'){
                    camera.position.z = info[0];
                }
                else{
                    camera.position.z = 0;
                }
                if (info[1] !== 'null' && info[2] !== 'maxillary' && info[2] !== 'mandibular'){
                   camera.position.x = info[1];
                }
                else{
                    // camera.position.x = 0;
                }
                if (info[2] === 'maxillary'){
                  var objectname = 'maxillary';
                }
                else if (info[2] === 'mandibular'){
                  var objectname = 'mandibular';
                }


              }
              else{
                camera.position.y = 0;
              }


	              scene.traverse(function(object){
                        if (object.visible === true && object.type === "Mesh"){
                            document.getElementById('current-module').textContent = objectid;
                        }
						if (object.type == 'Mesh' && object.tag == objectid){
							object.visible = true;
						}
						if (object.type == 'Mesh' && object.tag !== objectid){
							object.visible = false;
						}
                        if (objectname){
                            if (objectname === 'maxillary' && object.name === 'mandibular'){
                                object.visible = false;
                            }
                            if (objectname === 'mandibular' && object.name === 'maxillary'){
                                object.visible = false;
                            }

                            if (objectname === 'mandibular' && object.name === 'mandibular' && object.tag == document.getElementById('current-module').textContent){
                                object.visible = true;
                            }
                            if (objectname === 'maxillary' && object.name === 'maxillary' && object.tag == document.getElementById('current-module').textContent){
                                object.visible = true;
                            }
                        }
						console.log(object.tag);
				  });
              }));
              document.getElementById('play-button').addEventListener('click', event => {
                console.log(buttons)
			  		var i = 0;
	            	buttons.forEach((button) => {
						setTimeout(function(){

                                 // jQuery('label.step-trigger:nth-child('+i+')').addClass('active');
	        					 const camera_z = button.getAttribute("data-cameraz");
								  const camera_x = button.getAttribute("data-camerax");
								  const objectid = button.getAttribute("id");
								  console.log(camera_z+','+camera_x+','+objectid);
								  camera.position.z = camera_z;
					              camera.position.x = camera_x;
                                  if (jQuery('.current-view').text().length > 0){
                                    // camera.position.y = -6;
                                    var info = jQuery('.current-view').text().split(',');
                                    if (info[0] !== 'null' && info[2] !== 'maxillary' && info[2] !== 'mandibular'){
                                        camera.position.z = info[0];
                                    }
                                    else{
                                        camera.position.z = 0;
                                    }
                                    if (info[1] !== 'null' && info[2] !== 'maxillary' && info[2] !== 'mandibular'){
                                       camera.position.x = info[1];
                                    }
                                    else{
                                        // camera.position.x = 0;
                                    }
                                    if (info[2] === 'maxillary'){
                                      var objectname = 'maxillary';
                                    }
                                    else if (info[2] === 'mandibular'){
                                      var objectname = 'mandibular';
                                    }


                                  }
                                  else{
                                    camera.position.y = 0;
                                  }
					              scene.traverse(function(object){
										if (object.visible === true && object.type === "Mesh"){
                                            document.getElementById('current-module').textContent = objectid;
                                        }
                                        if (object.type == 'Mesh' && object.tag == objectid){
                                            object.visible = true;
                                        }
                                        if (object.type == 'Mesh' && object.tag !== objectid){
                                            object.visible = false;
                                        }
                                        if (objectname){
                                            if (objectname === 'maxillary' && object.name === 'mandibular'){
                                                object.visible = false;
                                            }
                                            if (objectname === 'mandibular' && object.name === 'maxillary'){
                                                object.visible = false;
                                            }

                                            if (objectname === 'mandibular' && object.name === 'mandibular' && object.tag == document.getElementById('current-module').textContent){
                                                object.visible = true;
                                            }
                                            if (objectname === 'maxillary' && object.name === 'maxillary' && object.tag == document.getElementById('current-module').textContent){
                                                object.visible = true;
                                            }
                                        }
								  });
                                  // jQuery('label.step-trigger:nth-child('+i+')').removeClass('active');
								  if (i === buttons.length){
								  	i = 0;
								  }
	        			},500 * i);
	        			i++;
					});

	            });

            function animate() {
                requestAnimationFrame( animate );
                container.appendChild( renderer.domElement );
                controls.update();
                renderer.render( scene, camera );

            };
            export const ZoomBar = () => {
                  return ('<div className="zoom-wrapper"><div className="zoom-bar"><div className="button" id="zoom-out">-</div><div className="button" id="zoom-in">+</div></div></div>');
                };
            animate();
            jQuery(document).ready(function(){
            	jQuery('#customRange2').on('input',function(){
            		var currentStep = parseInt(jQuery(this).val())+1
            		jQuery('.step-trigger[for="step-'+currentStep+'"]').click();
            	});
            	// jQuery('.x-rays-box > div').on('click',function(){
        		// 	jQuery('.image-open.col-lg-12').not(this).removeClass('image-open').removeClass('col-lg-12').addClass('col-lg-6');
        		// 	jQuery(this).toggleClass('col-lg-6 col-lg-12 image-open');

            	// });
                $('.review-photos img').on('click', function() {
                    $('#ModalImage').attr('src', $(this).attr('src'));
                });

            });
            var somethingChanged = false;
            jQuery(document).ready(function() {
               $('.acf-form input').change(function() {
                    somethingChanged = true;
               });
            });
            jQuery('form:not(#acf-form)').on('submit',function(event){
                if (somethingChanged){
                    if (confirm("You have unsaved notes. Do you want to proceed?")) {
                       //nothin
                    } else {
                       // do something else
                       jQuery('html, body').animate({
                            scrollTop: jQuery("#notes").offset().top
                        }, 2000);
                       jQuery('#submit_data').css('background-color','red');
                       return false;
                    }
                }
            });
</script>
@endif
@stop
