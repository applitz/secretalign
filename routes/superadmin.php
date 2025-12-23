<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\PatientsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

Route::middleware(['auth', 'auth.superadmin'])->prefix('superadmin')->group(function () {
    Route::resource('patients', PatientsController::class);
    Route::post('patients/change-expiry-date', [PatientsController::class, 'changeExpiryDate'])->name('patients.changeExpiryDate');
    Route::post('patients/change-patient-status', [PatientsController::class, 'changePatientStatus'])->name('patients.change-patient-status');
    Route::get('update-all-records-expiry-date', [PatientsController::class, 'updateExpiryDate'])->name('updateExpiryDate');
});

?>
