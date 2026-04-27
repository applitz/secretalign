<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\Doctor\PatientsController;
use App\Http\Controllers\Doctor\Shining3dController;
use App\Http\Controllers\Doctor\MovixtechController;

Route::middleware(['auth', 'auth.doctor'])->group(function () {
    Route::resource('patients', PatientsController::class);
    Route::get('update-shiping-date', [PatientsController::class, 'updateShipingDate'])->name('update-shiping-date');

    Route::post('order-from-dental-monitoring', [PatientsController::class, 'orderFromDentalMonitoring'])->name('order-from-dental-monitoring');
    Route::post('update-order-from-dental-monitoring', [PatientsController::class, 'updateOrderFromDentalMonitoring'])->name('update-order-from-dental-monitoring');
    Route::post('cancel-order-from-dental-monitoring', [PatientsController::class, 'cancelOrderFromDentalMonitoring'])->name('cancel-order-from-dental-monitoring');

    Route::post('get-shining3d-order-list', [Shining3dController::class, 'getOrderList'])->name('get-shining3d-order-list');
    Route::post('data-download-shining3d-order', [Shining3dController::class, 'dataDownload'])->name('download-shining3d-order');
    Route::get('data-download-and-upload-shining3d-order', [Shining3dController::class, 'dataDownloadAndUpload'])->name('download-and-upload-shining3d-order');

    Route::get('shining3d-region-details', [Shining3dController::class, 'regionDetails'])->name('shining3d-region-details');

    Route::get('movix-login', [MovixtechController::class, 'login'])->name('movix-login');
    Route::post('/patient/movixtech/create_case', [MovixtechController::class, 'movixtech_create_case'])->name('movixtech_create_case');
    Route::get('movix-get-access-token', [MovixtechController::class, 'getAccessToken'])->name('movix-get-access-token');
    Route::get('movix-create-webhook', [MovixtechController::class, 'createWebhook'])->name('movix-create-webhook');
    Route::get('movix-get-webhook', [MovixtechController::class, 'getWebhooks'])->name('movix-get-webhook');
});

?>
