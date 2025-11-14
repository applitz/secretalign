<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CasePhaseController;
use App\Http\Controllers\CronJobController;
use App\Http\Controllers\DataProcessingDocument;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FinishedOrders;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\LabReportController;
use App\Http\Controllers\ManagePatient;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PatientFileController;
use App\Http\Controllers\PatientDocumentation;
use App\Http\Controllers\PatientOverview;
use App\Http\Controllers\PatientDemo;
use App\Http\Controllers\PhasePeriodController;
use App\Http\Controllers\RegisterPatient;
use App\Http\Controllers\MeditLinkController;
use App\Http\Controllers\StripeCheckout;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TutorialController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/update-phases', [CasePhaseController::class, 'duration_test']);

Route::get('/test', [App\Http\Controllers\HomeController::class, 'testNemotech']);

Route::get('/file/{filename}', function ($filename) {
    $path = storage_path('app/public/attachments/' . $filename);
    Log::info($path);
    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return Response::make($file, 200)->header("Content-Type", $type);
});

Route::get('/dev/query', function () {
//     Artisan::call('config:clear');
//   Artisan::call('route:clear');
//   Artisan::call('view:clear');
   Artisan::call('optimize:clear');
//   Artisan::call('config:cache');
//   Artisan::call('route:cache');
//   Artisan::call('view:cache');
    //return view("meshlab");
    
    //     DB::table('test_cron')->insert([
    //         "created_at" => date("Y-m-d H:i:s"),    
    //     ]);
    // return response()->json(["status" => "ok"]);
    // try {
    //     \Illuminate\Support\Facades\Notification::route('mail', ["ghulamali0424@gmail.com"])
    //         ->notify(new \App\Notifications\CustomAlert("Hello World", "Test Mail"));
    // } catch (Exception $e) {
    //     dd($e);
    // }
});

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    } else {
        return redirect('/login');
    }
    //return view('welcome');
});

Route::get('/dropzone', function () {
    return view("dropzone");
});
Route::post('/handle-dropzone-files', [\App\Http\Controllers\HomeController::class, 'handle_dropzone_files']);
Route::post('/handle-dropzone-files/delete', [\App\Http\Controllers\HomeController::class, 'handle_dropzone_files_delete']);

Route::get('/datenschutzerklarung', function () {
    return view("datenschutzerklarung");
});

Route::get('/impressum', function () {
    return view("impressum");
});


Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//notifications
Route::post('/notifications', [NotificationController::class, 'check']);
Route::get('/view-notifications', [NotificationController::class, 'view']);
Route::get('/read-all-notifications', [NotificationController::class, 'read_all'])->name('notifications.read_all');

//tasks
Route::get('/view-tasks', [TaskController::class, 'view']);
Route::get('/view-tasks2',[TaskController::class, 'tasks']);
Route::get('/view-tasks/cancelled', [TaskController::class, 'cancelled_tasks']);
Route::get('/view-tasks/new-orders', [TaskController::class, 'orders']);
Route::get('/view-tasks/under-process', [TaskController::class, 'in_progress']);
Route::get('/view-tasks/finished', [TaskController::class, 'finished_tasks']);
Route::get('/view-tasks/delivered', [TaskController::class, 'delivered']);

//users
Route::post('/users/fcm-device-token', [UserController::class, 'update_fcm_token']);
Route::get('/users/view', [UserController::class, 'view'])->middleware('auth.users.controller');
Route::get('/user/add', [UserController::class, 'add'])->middleware('auth.users.controller');
Route::post('/user/save', [UserController::class, 'save'])->middleware('auth.users.controller');
Route::get('/user/edit/{id}', [UserController::class, 'edit'])->middleware('auth.superadmin');
Route::post('/user/update/{id}', [UserController::class, 'update']);
Route::post('/user/change-password/{id}', [UserController::class, 'change_password']);
Route::post('/user/delete/{id}', [UserController::class, 'delete'])->middleware('auth.superadmin');
Route::get('/profile-settings', [UserController::class, 'profile_settings']);
Route::post('/profile-settings/change-profile-photo/{id}', [UserController::class, 'change_profile_photo']);
Route::post('/profile-settings/{id}', [UserController::class, 'post_profile']);

//data processing document
Route::get('/contract/sign/data-processing-document', [DataProcessingDocument::class, "sign_document"]);
Route::post('/contract/sign/data-processing-document', [DataProcessingDocument::class, 'post_sign_document']);
Route::get('/contract/view/data-processing-document/{id}', [DataProcessingDocument::class, "view_data_processing_document"]);
Route::get('/contracts/data-processing-documents/view', [DataProcessingDocument::class, 'view_data_processing_documents']);

//tier settings
Route::get('/tier-settings', [TierController::class, 'view_tiers']);
Route::post('/tier-settings/change-price', [TierController::class, 'change_jaw_price']);

//phase period settings
Route::get('/treatment-plan-phase-period-settings', [PhasePeriodController::class, 'form']);
Route::post('/treatment-plan-phase-period-settings', [PhasePeriodController::class, 'post']);

//register/edit patient
Route::get('/patient/create', [RegisterPatient::class, 'create']);
Route::get('/patient/edit/{treatment_plan_id}', [RegisterPatient::class, 'edit']);
Route::post('/patient/patient-info/save', [RegisterPatient::class, 'save_patient_info']);
Route::post('/patient/scan-data/save', [RegisterPatient::class, 'save_scan_data']);
Route::post('/patient/images/save', [RegisterPatient::class, 'save_images']);
Route::post('/patient/prescription/save', [RegisterPatient::class, 'save_prescription']);
Route::post('/patient/submit', [RegisterPatient::class, 'submit']);
Route::post('/patient/validate-data', [RegisterPatient::class, 'validatePatientData']);

//patient files
Route::post('/patient/file/upload/{patient_id}/{treatment_plan_id}', [PatientFileController::class, 'file_upload']);
Route::post('/patient/file/revert/{patient_id}/{treatment_plan_id}', [PatientFileController::class, 'file_revert']);
Route::get('/patient/file/load/{patient_id}', [PatientFileController::class, 'file_load']);
Route::get('/patient/mesh/fetch/{patient_id}/{filename}', [PatientFileController::class, 'fetchMesh']);

//save stl
Route::post('/patient/file/download-3shape', [PatientFileController::class, 'ThreeShapeDownloadSTL']);
Route::post('/patient/file/download-medit-link', [PatientFileController::class, 'MeditLinkDownloadSTL']);

//stripe checkout
// Route::get('/orders/checkout/proceed/{patient_id}/{treatment_plan_id}/{mode}', [StripeCheckout::class, 'checkout'])->name('checkout');
// Route::get('/orders/checkout/return/{payment_id}/success', [StripeCheckout::class, 'success'])->name('checkout.success');
// Route::get('/orders/checkout/return/{payment_id}/error', [StripeCheckout::class, 'error'])->name('checkout.error');
//manage patients
Route::get('/patients/view/under-process', [ManagePatient::class, 'under_process']);
Route::get('/patients/delivered', [ManagePatient::class, 'delivered']);
Route::get('/patients/cancelled', [ManagePatient::class, 'cancelled']);
Route::get('/patients/view', [ManagePatient::class, 'view']);
Route::get('/patients/secret-partner-requests', [ManagePatient::class , 'secret_partner_requests']);
Route::post('/patient/delete/{id}', [ManagePatient::class, 'delete']);

//finished orders
Route::get('/patients/orders/finished/view', [FinishedOrders::class, 'finished_orders']);

//case overview
Route::get('/patient/fetch-case-overview/{phase}', [PatientOverview::class, 'fetch_overview']);
Route::get('/patient/case-overview/{phase}', [PatientOverview::class, 'overview']);
Route::get('/patient/full-screen/{phase}', [PatientOverview::class, 'iframe'])->name('iframe');
Route::post('/patient/case-overview/chane-pricing-package', [PatientOverview::class, 'change_pricing_package']);
Route::get('/patient/case-overview/load-comments/{treatment_plan_id}', [PatientOverview::class, 'get_overview_comments']);
Route::post('/patient/case-overview/send-to-lab/submit-for-treatment', [PatientOverview::class, 'submit_to_lab_for_treatment'])->name("request-treatment");
Route::post('/patient/case-overview/send-to-lab', [PatientOverview::class, 'send_from_staff_to_lab']);
Route::post('/patient/case-overiew/send-from-lab-to-staff', [PatientOverview::class, 'send_from_lab_to_staff']);
Route::post('/patient/case-overview/send-from-lab-to-staff/submit-treatment', [PatientOverview::class, 'submit_treatment'])->name("submit-treatment");
Route::post('/patient/case-overview/submit-setup-files', [PatientOverview::class, 'submit_setup_files']);
Route::post('/pastient/case-overview/request-setup-files-from-lab', [PatientOverview::class, 'request_setup_files']);
Route::post('/patient/case-overview/submit/tracking-id', [PatientOverview::class, 'submit_tracking_id']);
Route::post('/patient/case-overview/send-from-lab-to-staff/cancel-request', [PatientOverview::class, 'cancel_treatment_request'])->name("cancel-treatment");
Route::post('/patient/case-overiew/send-from-staff-to-doctor', [PatientOverview::class, 'send_form_staff_to_doctor']);
Route::post('/patient/case-overview/send-from-doctor-to-staff', [PatientOverview::class, 'send_from_doctor_to_staff']);
Route::post('/patient/case-overview/send-from-doctor-to-staff-for-advisor', [PatientOverview::class, 'send_from_doctor_to_staff_for_advisor']);
Route::post('/patient/case-overview/send-from-staff-to-advisor', [PatientOverview::class, 'send_from_staff_to_advisor']);
Route::post('/patient/case-overview/send-from-advisor-to-doctor', [PatientOverview::class, 'send_from_advisor_to_doctor']);
Route::post('/patient/case-overview/send-from-staff-to-doctor/reject-treatment', [PatientOverview::class, 'reject_treatment'])->name("reject-treatment");
Route::post('/patient/case-overview/send-from-staff-to-lab-for-modification', [PatientOverview::class, 'request_modification'])->name('request.modification');
Route::post('/patient/case/allow-user-to-edit', [PatientOverview::class, 'allow_edit']);
Route::post('/patient/case-overview/case/approve', [PatientOverview::class, 'approveCase']);
Route::post('/patient/case-overview/case/reopen', [PatientOverview::class, 'reopenCase']);
Route::get('/patient/picture/print/{patient_id}/{file_name}', [PatientOverview::class, 'print_picture']);
Route::get('/patient/print/images/{treatment_plan_id}', [PatientOverview::class, 'print_images']);
Route::get('/patient/images/edit/{treatment_plan_id}', [PatientOverview::class, 'edit_image']);
Route::post('/patient/images/update/{treatment_plan_id}', [PatientOverview::class, 'update_image']);
Route::post('/patient/update-links/{treatment_plan_id}', [PatientOverview::class, 'update_links'])->middleware('auth.superadmin');
Route::post('/patient/case-overview/patient-alert', [PatientOverview::class, 'patient_alert'])->name('patient.alert');

Route::get('/patient/documentation/{treatment_plan_id}', [PatientDocumentation::class, 'documentation']);
Route::post('/patient/documentation/upload/{patient_id}/{treatment_plan_id}', [PatientDocumentation::class, 'file_upload']);
Route::delete('/patient/documentation/revert/{patient_id}/{treatment_plan_id}', [PatientDocumentation::class, 'file_revert']);
Route::get('/patient/documentation/load/{patient_id}', [PatientDocumentation::class, 'file_load']);

Route::get('/patient/case/cancellation-cron', [CronJobController::class, 'cancel_not_approved_cases']);
Route::get('/patient/case/cancellation-notification-cron', [CronJobController::class, 'send_cancellation_notification']);
Route::get('/patient/case/sync-documents', [CronJobController::class, 'syncTreatmentPlanDocument']);

//next treatment plan
Route::post('/patient/treatment-plan/request', [CasePhaseController::class, 'request_new_plan'])->middleware('auth.doctor');
Route::post('/patient/treatment-plan/continue', [CasePhaseController::class, 'continue_new_plan'])->middleware('auth.doctor');
Route::post('/pateint/treatment-plan/cancel-request', [CasePhaseController::class, 'cancel_requested_plan'])->middleware('auth.superadmin');

//orders
Route::get('/orders', [OrderController::class, 'view_orders']);
Route::get('/orders/print/{id}', [OrderController::class, 'print_order']);

//reports
Route::get('/reports/lab-requests', [LabReportController::class, 'view_lab_requests']);

//integrations
Route::get('/integrations/3shape-setup', [IntegrationController::class, 'SetupThreeShapeIntegration']);
Route::get('/integrations/3shape-disable', [IntegrationController::class, 'DisableThreeShapeIntegration']);
Route::get('/integration-3shape/obtain-authorization-code', [IntegrationController::class, 'ThreeShapeObtainAuthorizationCode']);
Route::get('/integration-3shape', [IntegrationController::class, 'ThreeShapeObtainAuthorizationCodeCallback']);
Route::post('/integrations/3shape-search-cases', [IntegrationController::class, 'ThreeShapeSearchCase']);
Route::get('/integrations/medit-link-disable', [IntegrationController::class, 'DisableMeditLinkIntegration']);
Route::get('/integration-medit-link/obtain-authorization-code', [IntegrationController::class, 'MeditLinkObtainAuthorizationCode']);
Route::get('/integration-medit-link', [IntegrationController::class, 'MeditLinkObtainAuthorizationCodeCallback']);
Route::post('/integrations/medit-link-search-cases', [IntegrationController::class, 'MeditLinkSearchCase']);
Route::get('/integrations/medit-link/receive-data', [MeditLinkController::class, 'receiveData']);

//events
Route::get('/events/view', [EventController::class, 'view_events']);
Route::get('/events/add', [EventController::class, 'add_event']);
Route::get('/events/edit/{id}', [EventController::class, 'edit_event']);
Route::post('/events/save', [EventController::class, 'save_event']);
Route::post('/events/update', [EventController::class, 'update_event']);
Route::post('/events/delete', [EventController::class, 'delete_event']);
Route::get('/events', [\App\Http\Controllers\HomeController::class, 'view_events']);

//blogs
Route::get('/blogs/view', [BlogController::class, 'view_blogs'])->middleware('auth.superadmin');
Route::get('/blog/add', [BlogController::class, 'add_blog'])->middleware('auth.superadmin');
Route::get('/blog/edit/{id}', [BlogController::class, 'edit_blog'])->middleware('auth.superadmin');
Route::post('/blog/save', [BlogController::class, 'save_blog'])->middleware('auth.superadmin');
Route::post('/blog/update/{id}', [BlogController::class, 'update_blog'])->middleware('auth.superadmin');
Route::get('/blog/delete/{id}', [BlogController::class, 'delete_blog'])->middleware('auth.superadmin');
Route::get('/blogs', [BlogController::class, 'blogs']);
Route::get('/blog/{id}', [BlogController::class, 'blog']);

//tutorials
Route::get('/tutorials/view', [TutorialController::class, 'view_blogs'])->middleware('auth.superadmin');
Route::get('/tutorial/add', [TutorialController::class, 'add_blog'])->middleware('auth.superadmin');
Route::get('/tutorial/edit/{id}', [TutorialController::class, 'edit_blog'])->middleware('auth.superadmin');
Route::post('/tutorial/save', [TutorialController::class, 'save_blog'])->middleware('auth.superadmin');
Route::post('/tutorial/update/{id}', [TutorialController::class, 'update_blog'])->middleware('auth.superadmin');
Route::get('/tutorials/play/{id}', [TutorialController::class, 'play_blog'])->middleware('auth.superadmin');
Route::get('/tutorial/delete/{id}', [TutorialController::class, 'delete_blog'])->middleware('auth.superadmin');
Route::get('/tutorials', [TutorialController::class, 'blogs']);
Route::get('/tutorial/{id}', [TutorialController::class, 'blog']);

//patient demo
Route::get('/patient/demo/{treatment_plan_id}', [PatientDemo::class, 'overview']);
Route::get('/patient/demo/full-screen/{phase}', [PatientDemo::class, 'iframe'])->name('demo_iframe');

Route::get('/demo/patient/delete/{id}', [PatientDemo::class, 'delete_demo_patient'])->middleware('auth.superadmin');
Route::get('/demo/patients/view', [PatientDemo::class, 'manage_demo_patients']);
Route::get('/demo/patient/add', [PatientDemo::class, 'add'])->middleware('auth.superadmin');
Route::get('/demo/patient/edit', [PatientDemo::class, 'edit'])->middleware('auth.superadmin');
Route::post('/demo/patient/patient-info/save', [PatientDemo::class, 'save_patient_info'])->middleware('auth.superadmin');
Route::post('/demo/patient/scan-data/save', [PatientDemo::class, 'save_scan_data'])->middleware('auth.superadmin');
Route::post('/demo/patient/images/save', [PatientDemo::class, 'save_images'])->middleware('auth.superadmin');
Route::post('/demo/patient/prescription/save', [PatientDemo::class, 'save_prescription'])->middleware('auth.superadmin');
Route::post('/demo/patient/submit', [PatientDemo::class, 'submit'])->middleware('auth.superadmin');
Route::post('/demo/patient/validate-data', [PatientDemo::class, 'validatePatientData']);//->middleware('auth.superadmin');
Route::post('/demo/patient/file/upload/{patient_id}/{treatment_plan_id}', [PatientDemo::class, 'file_upload'])->middleware('auth.superadmin');
Route::post('/demo/patient/file/revert/{patient_id}/{treatment_plan_id}', [PatientDemo::class, 'file_revert'])->middleware('auth.superadmin');
Route::get('/demo/patient/file/load/{patient_id}', [PatientDemo::class, 'file_load'])->middleware('auth.superadmin');
Route::post('/demo/patient/file/download-3shape', [PatientDemo::class, 'ThreeShapeDownloadSTL'])->middleware('auth.superadmin');
Route::get('/demo/patient/case-overview/{phase}', [PatientDemo::class, 'overview']);
