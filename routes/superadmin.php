<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\PatientsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

Route::middleware(['auth', 'auth.superadmin'])->prefix('superadmin')->group(function () {
    Route::resource('patients', PatientsController::class);
});

?>
