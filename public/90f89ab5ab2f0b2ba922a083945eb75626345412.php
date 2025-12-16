

<?php $__env->startSection('css'); ?>
<?php if(Auth::user()->role == 'doctor'): ?>
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/assets/signaturepad/docs/css/signature-pad.css">
<style>
    .wrapper {
        width: 100%;
        height: 100vh;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .signature-pad {
        width: 45%;
        height: 10.875vh;
    }

    .signature-pad--body {
        background-color: whitesmoke;
    }

    .demo-inline-spacing>* {
        margin-right: 0;
    }
</style>
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-39365077-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();
</script>
<?php endif; ?>
<style>
    .top-34 {
        top: 34%;
    }

    .choices[data-type*=select-one] .choices__inner {
        padding-top: 1px !important;
        padding-bottom: 2px !important;
    }

    .choices__inner {
        min-height: 29px !important;
    }
    .contract-ul {
  list-style-type: none;
}



.contract-ul li:before {
  content: "-";
  padding-right: 12px;
}

</style>
<link href="<?php echo e(asset('public/dashboard')); ?>/vendors/choices/choices.min.css" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="page-content">

    <?php if(Auth::user()->role != 'doctor'): ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Doctors</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('/contracts/data-processing-documents/view')); ?>">Doctors</a></li>
                        <li class="breadcrumb-item active">Data processing agreement</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                  <h5 class="mb-0 text-center">DATA PROCESSING AGREEMENT</h5>
                </div>
                <div class="card-body bg- light pb-0">
                  <div class="row">
                    <div class="col-lg-12">

                        <p class="fs--1">In Following document <sub><small>(NAME)</small></sub> <span style="text-decoration: underline;">
                        <?php if(Auth::user()->role == 'doctor'): ?>
                        <?php echo e(Auth::user()->first_name . ' ' . Auth::user()->last_name); ?>

                        <?php else: ?>
                        <?php echo e($doctor->first_name . ' ' . $doctor->last_name); ?>

                        <?php endif; ?>
                        </span>  will be referred to as the Doctor or Data Controller.</p>
                        <p class="fs--1">On the other hand, Al-Secret e.U. will be sometimes referred to as Data Processor or Processor.</p>
                        <p class="fs--1">In compliance with pertinent data protection legislation, both Parties, SECRET and the Doctor freely and spontaneously concur to regulate the processing of personal data according to the following</p>
                        <h5 class="fs-0" style="text-decoration: underline;">CLAUSES</h5>
                        <h5 class="fs-0">1. PURPOSE OF THE DATA PROCESSING</h5>
                        <p class="fs--1">Through the present clauses, the Doctor enables SECRET to process the personal data necessary to render the SERVICE on behalf of the Doctor.</p>
                        <h5 class="fs-0">2. IDENTIFICATION OF PERSONAL DATA AND DATA SUBJECTS</h5>
                        <p class="fs--1">The Doctor will make the following information available to the SECRET for the execution of the steps necessary to fulfil the obligations stipulated in the cited service agreement:</p>
                        <ul class="fs--1 contract-ul">
                            <li>Name and surnames</li>
                            <li>Postal address</li>
                            <li>Email address</li>
                            <li>Telephone number</li>
                            <li>Tax ID No.</li>
                        </ul>
                        <p class="fs--1">CATEGORY OF DATA SUBJECTS WHOSE PERSONAL DATA ARE PROCESSED</p>
                        <ul class="fs--1 contract-ul">
                            <li>Users</li>
                            <li>Patients</li>
                        </ul>
                        <h5 class="fs-0">3. DURATION</h5>
                        <p class="fs--1">The duration of the present Agreement will be subject to the continuity of the main commissioned service and will automatically extend so long as one Party does not notify the other of its decision otherwise.</p>
                        <h5 class="fs-0">4. OBLIGATIONS OF THE DATA CONTROLLER (DOCTOR)</h5>
                        <p class="fs--1">a) Provide the SECRET with the data referred to in CLAUSE 2 herein.</p>
                        <p class="fs--1">b) Provide the corresponding instructions for carrying out the processing.</p>
                        <p class="fs--1">c) Conduct a personal data protection risk analysis and impact assessment regarding the processing operations that SECRET will carry out, where applicable.</p>
                        <p class="fs--1">d) Carry out the corresponding prior consultations.</p>
                        <p class="fs--1">e) Ensure before and throughout the processing that SECRET is compliant with the GDPR.</p>
                        <p class="fs--1">f) Supervise the processing, including the carrying out of inspections and audits.</p>
                        <h5 class="fs-0">5. DESTINATION OF THE DATA</h5>
                        <p class="fs--1">This clause only applies in cases where the maintenance of the SECRET has required the receipt of customer data for repair or transfer. Upon conclusion of the service, SECRET must: Return all the personal data and, where pertinent, media containing them to the Doctor upon completion of the service. SECRET may also be asked to destroy them.</p>
                        <h5 class="fs-0">6. LEGAL DISCLAIMER</h5>
                        <p class="fs--1">The Doctor is exonerated from any responsibility that could be generated by the PROCESSOR'S non-compliance with the stipulations of this contract, as well as with the provisions of the GDPR, in which case he will be considered Data Controller, answering for the infringements in which he could incur, as well as for any claim for compensation that the data subjects could file with the Control Authority or with the Courts. If the PROCESSOR were to subcontract, giving rise to a Sub-processor, the latter failing to comply with his or her data protection obligations, the PROCESSOR will continue to be fully liable to the CONTROLLER with regard to compliance with the obligations of the Sub-processor. This will be maintained regardless of the number of successive sub- processors.</p>
                        <h5 class="fs-0">7. CONFIDENTIALITY AND DATA PROTECTION</h5>
                        <p class="fs--1">The Parties are obliged to keep absolute confidentiality on the information and documentation provided or accessed during the provision of the SERVICE, not to disclose, nor use directly or indirectly the information derived from this contractual relationship. Both parties are informed respectively that the personal data of the signatories of the present contract will be included in the processing of the other party to satisfy the purpose of management and maintenance of the contractual relationship. At any time, they may exercise their rights of access, rectification, deletion, opposition, limitation to processing, portability, and not be subject to automated individualized decisions, where appropriate, in the postal addresses and contact emails indicated in the header. They also provide the privacy policy posted on their respective websites for further information, offering the availability of attaching it on paper or sending it by mail if there is no website.</p>
                        <h5 class="fs-0">8. GOVERNING LAW AND JURISDICTION</h5>
                        <p class="fs--1">This contract complies with the requirements of European legislation, particularly the GDPR and any other national applicable law. The Parties expressly renounce any venue that may correspond to them and agree to submit all interpretations and/or disputes arising from or relating to this Agreement to the competent Courts of the city of Krems an der Donau.</p>
                        <br>
                        <p class="fs--1">In witness whereof, the Parties hereto execute duplicate original copies of the present Agreement at the place and on the date set forth above.</p>
                    </div>
                  </div>
                </div>
                <div class="card-footer bg-white pb-3 pt-5">
                  <div class="row">
                    <div class="col-md-6">
                        <div >
                            <?php if(Auth::user()->role == 'doctor'): ?>
                            <div id="signature-pad" class="signature-pad " style="cursor: pointer">
                                <div class="signature-pad--body">
                                    <canvas></canvas>
                                </div>
                            </div>
                            <img id="imagen_firma" src="" class="d-none">
                            <?php else: ?>
                            <?php if(@$doctor->data_processing_document_signatures): ?>
                            <img style="width: 45%;height: 10.875vh;" src="<?php echo e($doctor->data_processing_document_signatures); ?>">
                            <?php endif; ?>
                            <?php endif; ?>
                            <p class="fs-0 pt-2" style="border-top: 1px solid var(--falcon-body-color);width: 45%;">THE DATA CONTROLLER</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div >
                            <img style="width: 45%;height: 10.875vh;" src="<?php echo e(asset('public')); ?>/assets/secret-logo.png">
                            <p class="fs-0 pt-2" style="border-top: 1px solid var(--falcon-body-color); width: 45%;">THE DATA PROCESSOR</p>
                        </div>
                    </div>
                    <?php if(Auth::user()->role == 'doctor'): ?>
                    <div class="col-md-12">
                        <p class="fs--1 text-danger mt-1">* You must sign the document before saving.</p>
                        <div class="signature-pad--footer">
                            <div class="signature-pad--actions mt-0">
                                <div class="demo-inline-spacing">
                                    <button type="button"
                                        class="btn btn-falcon-default btn-sm text-success" id="accept"><i class="fas fa-check"></i>
                                        Accept & Save</button>
                                    <button type="button"
                                        class="btn btn-falcon-default btn-sm text-danger clear"
                                        data-action="clear"><i class="fas fa-times"></i>
                                        Clear Signature</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<?php echo $__env->make('layouts.page_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(Auth::user()->role == 'doctor'): ?>
<script src="<?php echo e(asset('public')); ?>/assets/signaturepad/docs/js/signature_pad.umd.js"></script>
<script src="<?php echo e(asset('public')); ?>/assets/signaturepad/docs/js/app.js"></script>
<script>
    $(document).ready(function() {
        var saveButton = wrapper.querySelector("[data-action=save]");
        // Adjust canvas coordinate space taking into account pixel ratio,
        // to make it look crisp on mobile devices.
        // This also causes canvas to be cleared.
        function resizeCanvas() {
            // When zoomed out to less than 100%, for some very strange reason,
            // some browsers report devicePixelRatio as less than 1
            // and only part of the canvas is cleared then.
            var ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }
        signaturePad = new SignaturePad(canvas);



        window.onresize = resizeCanvas;
        resizeCanvas()
        $(`[data-action='clear']`).on('click', function() {
            signaturePad.clear();
        })

    })
</script>
<script>
    $(window).on('load', () => {
resizeCanvas();
});

$(document).ready(function () {
    $("#accept").on('click', function () {
        let dataUrl = signaturePad.toDataURL();
        if(signaturePad.isEmpty()) {
            toastError('You must sign the document.');
            return false;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo e(url()->current()); ?>",
            data: {
                "_token" : "<?php echo e(csrf_token()); ?>",
                "signatures" : dataUrl,
            }
        }).done(function (response) {
            if(response.status == 200) {
                window.location.href = "<?php echo e(url('/home')); ?>";
            }
            else {
                toastError("Enable to proceed request.");
            }
        });
    });
});
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_base_horizontal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\secretalign\resources\views/users/data_processing_document.blade.php ENDPATH**/ ?>