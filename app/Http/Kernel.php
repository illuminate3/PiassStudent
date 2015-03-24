<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		'App\Http\Middleware\VerifyCsrfToken',
		'App\Http\Middleware\FinanceMiddleWare',
		'App\Http\Middleware\RegistrarMiddleWare',
		'App\Http\Middleware\FaculityMiddleWare',
		
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
	    'sentry.auth' => 'Sentinel\Middleware\SentryAuth',
        'sentry.admin' => 'Sentinel\Middleware\SentryAdminAccess',
        'auth.finance' =>'App\Http\Middleware\FinanceMiddleWare',
		'auth.registrar' =>'App\Http\Middleware\RegistrarMiddleWare',
		'auth.faculity' =>'App\Http\Middleware\FaculityMiddleWare',
	];

}
