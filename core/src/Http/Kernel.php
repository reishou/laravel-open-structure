<?php

namespace Core\Http;

use Core\Http\Middleware\Authenticate;
use Core\Http\Middleware\LanguageCode;
use Core\Http\Middleware\Timezone;
use Core\Http\Middleware\TrimStrings;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Routing\Middleware\ThrottleRequests;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middlewares are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
        LanguageCode::class,
        Timezone::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'api' => [
            'throttle:api',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middlewares may be assigned to group or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'throttle' => ThrottleRequests::class,
    ];
}
