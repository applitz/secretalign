<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\PatientsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\TreatmentCheckController;
use App\Http\Controllers\RegisterstaffPatient;
Route::middleware(['auth', 'auth.staff'])->prefix('staff')->group(function () {
    Route::resource('patients', PatientsController::class);
    Route::post('/treatment-check/save', [TreatmentCheckController::class, 'store'])->name('treatment.check.save');
    Route::get('/treatment/preview/{id}', [TreatmentCheckController::class, 'preview'])->name('treatment.preview');
    Route::get('/treatment/export/{id}', [TreatmentCheckController::class, 'export'])->name('treatment.export');

    Route::post('/patient/check-movix-scan-status-staff', [RegisterstaffPatient::class, 'checkMovixScanStatus']);
});

?>
