<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
        'patient/documentation/upload/*',
        'patient/documentation/revert/*',
        'patient/file/upload/*',
        'patient/file/revert/*',
        'demo/patient/file/upload/*',
        'demo/patient/file/revert/*',
        'handle-dropzone-files',
        'notifications',
        'login',
        'logout',
    ];
}
