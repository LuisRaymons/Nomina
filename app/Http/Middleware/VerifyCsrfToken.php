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
        'http://127.0.0.1/Nomina/public/empleado/add',
        'http://127.0.0.1/Nomina/public/empleado/update',
        'http://127.0.0.1/Nomina/public/empleado/delete/*',
        'http://127.0.0.1/Nomina/public/empleado/active',
    ];
}
