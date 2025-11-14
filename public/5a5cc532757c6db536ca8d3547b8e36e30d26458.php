<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Presentation Print_Export</title>



    <script src="<?php echo e(asset('public/dashboard')); ?>/assets/js/config.js"></script>
    <script src="<?php echo e(asset('public/dashboard')); ?>/vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="<?php echo e(asset('public/dashboard')); ?>/vendors/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="<?php echo e(asset('public/dashboard')); ?>/vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('public/dashboard')); ?>/assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
    <link href="<?php echo e(asset('public/dashboard')); ?>/assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="<?php echo e(asset('public/dashboard')); ?>/assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
    <link href="<?php echo e(asset('public/dashboard')); ?>/assets/css/user.min.css" rel="stylesheet" id="user-style-default">
    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>

    <style>
    .d-img-top {
        width: 100%;
        max-height: 300px;
    }
        .d-img {
            width: 100%;
            max-height: 250px;
        }
        @media print {

            @page {
  size: A4 landscape;
  margin: 0;

}
        }


    </style>
</head>


<body onload="window.print()" class="bg-white">

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main bg-white py-3 mx-0 px-5" id="top">
        <div class="container-fluid px-5">
        <div class="container-fluid">
       <div class="row">
        <div class="col-4 mb-3 px-4">
            <div class="d-flex text-center justify-content-center d-img-top my-auto ">

                    <img class="img-fluid w-100 " style="border-radius: 1rem !important;"
                    src="<?php echo e(asset('/storage/PatientFiles/Patient' . $treatment_plan->patient_id . '/' . $treatment_plan->fl_profile)); ?>">

            </div>
        </div>
        <div class="col-4 mb-3 px-4">
            <div class="d-flex text-center justify-content-center d-img-top my-auto">

                <img class="img-fluid w-100" style="    border-radius: 1rem !important;"
                    src="<?php echo e(asset('/storage/PatientFiles/Patient' . $treatment_plan->patient_id . '/' . $treatment_plan->fl_front)); ?>">

            </div>
        </div>
        <div class="col-4 mb-3 px-4">
            <div class="d-flex text-center justify-content-center d-img-top my-auto">

                <img class="img-fluid w-100" style="    border-radius: 1rem !important;"
                    src="<?php echo e(asset('/storage/PatientFiles/Patient' . $treatment_plan->patient_id . '/' . $treatment_plan->fl_profile)); ?>">

                </div>
        </div>
        <div class="col-4 mb-3 px-4">
            <div class="d-flex text-center justify-content-center d-img my-auto">

                <img class="img-fluid w-100" style="    border-radius: 1rem !important;"
                    src="<?php echo e(asset('/storage/PatientFiles/Patient' . $treatment_plan->patient_id . '/' . $treatment_plan->fl_upper_occlusal)); ?>">

                </div>
        </div>
        <div class="col-4 mb-3 px-4">
            <h6 class="text-dark">Patient's Name: <span class=""><?php echo e($treatment_plan->p_first_name . ' ' . $treatment_plan->p_last_name); ?></span></h6>
                <h6 class="text-dark">Doctor's Name: <span class=""><?php echo e($treatment_plan->d_first_name . ' ' . $treatment_plan->d_last_name); ?></span></h6>
                <div class="d-flex text-center justify-content-center mt-2 px-4" >
                    <img src="<?php echo e(asset('public')); ?>/assets/secret-logo.png" alt="" class="img-fluid" />
                </div>
        </div>
        <div class="col-4 mb-3 px-4">
            <div class="d-flex text-center justify-content-center d-img my-auto">


                <img class="img-fluid w-100" style="    border-radius: 1rem !important;"
                    src="<?php echo e(asset('/storage/PatientFiles/Patient' . $treatment_plan->patient_id . '/' . $treatment_plan->fl_lower_occlusal)); ?>">

                </div>
        </div>
        <div class="col-4 px-4">
            <div class="d-flex text-center justify-content-center d-img my-auto">

                <img class="img-fluid w-100" style="    border-radius: 1rem !important;"
                    src="<?php echo e(asset('/storage/PatientFiles/Patient' . $treatment_plan->patient_id . '/' . $treatment_plan->fl_right_buccal)); ?>">

                </div>
        </div>
        <div class="col-4 px-4">
            <div class="d-flex text-center justify-content-center d-img my-auto">

                <img class="img-fluid w-100" style="    border-radius: 1rem !important;"
                    src="<?php echo e(asset('/storage/PatientFiles/Patient' . $treatment_plan->patient_id . '/' . $treatment_plan->fl_frontal)); ?>">

                </div>
        </div>
        <div class="col-4 px-4">
            <div class="d-flex text-center justify-content-center d-img my-auto">

                <img class="img-fluid w-100" style="    border-radius: 1rem !important;"
                    src="<?php echo e(asset('/storage/PatientFiles/Patient' . $treatment_plan->patient_id . '/' . $treatment_plan->fl_left_buccal)); ?>">

                </div>
        </div>
       </div>
    </div>

</div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="<?php echo e(asset('public/dashboard')); ?>/vendors/popper/popper.min.js"></script>
    <script src="<?php echo e(asset('public/dashboard')); ?>/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo e(asset('public/dashboard')); ?>/vendors/anchorjs/anchor.min.js"></script>
    <script src="<?php echo e(asset('public/dashboard')); ?>/vendors/is/is.min.js"></script>
    <script src="<?php echo e(asset('public/dashboard')); ?>/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="<?php echo e(asset('public/dashboard')); ?>/vendors/typed.js/typed.js"></script>
    <script src="<?php echo e(asset('public/dashboard')); ?>/vendors/fontawesome/all.min.js"></script>
    <script src="<?php echo e(asset('public/dashboard')); ?>/vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="<?php echo e(asset('public/dashboard')); ?>/vendors/list.js/list.min.js"></script>
    <script src="<?php echo e(asset('public/dashboard')); ?>/assets/js/theme.js"></script>

</body>

</html>
<?php /**PATH /home/u531876341/domains/secretalign-user.com/public_html/resources/views/patients/print_images_landscape.blade.php ENDPATH**/ ?>