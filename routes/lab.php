<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lab\PatientsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
Route::middleware(['auth', 'auth.lab'])->prefix('lab')->group(function () {
    Route::resource('patients', PatientsController::class);
});

?>
