<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Partner\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

Route::middleware(['auth', 'auth.partner'])->prefix('partner')->group(function () {
    Route::resource('users', UsersController::class);
});

?>
