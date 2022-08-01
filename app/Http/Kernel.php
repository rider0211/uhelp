<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;


class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

        \Spatie\CookieConsent\CookieConsentMiddleware::class,
        \Spatie\Honeypot\ProtectAgainstSpam::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
      
            \App\Http\Middleware\Languagelocaliztion::class,
            \App\Http\Middleware\HttpsProtocolMiddleware::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'refresh' => [
            'throttle:refresh',
            'bindings',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,


        'disablepreventback' => \App\Http\Middleware\DisablePreventBack::class,

        'admin.auth' => \App\Http\Middleware\AdminAuthenticate::class,
        'customer.auth' => \App\Http\Middleware\CustomerAuthenicate::class,
        'status' => \App\Http\Middleware\statuslogin::class,

        'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
        'checkinstallation' => \App\Http\Middleware\Checkinstallation::class,
        'admincountryblock' => \App\Http\Middleware\AdminCountryblockunblockMiddleware::class,
        'countrylistbub' => \App\Http\Middleware\CountryblockunblockMiddleware::class,
        'ipblockunblock' => \App\Http\Middleware\IPblockunblockMiddleware::class,
        'https' => \App\Http\Middleware\HttpsProtocolMiddleware::class,
        
        'apichecking' => \App\Http\Middleware\ApiCheckingMiddleware::class,
        'caninstall' => \App\Http\Middleware\Install\CanInstall::class,
        'canupdate' => \App\Http\Middleware\Install\CanUpdate::class,
    ];
}
