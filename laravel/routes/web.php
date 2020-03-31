<?php

use App\Http\Controllers\Auth;
use App\Support\Url;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

Route::prefix('/auth')->group(function () {

    /**
     * /csrf-cookie is a route added by the sanctum package.
     * it's usually under /sanctum prefix, but through a bit
     * of code research I found you can customise the prefix
     * in the config/sanctum.php file, so I changed it to be
     * in line with the rest of these
     */

    Route::middleware(['guest'])->group(function () {
        Route::post('/start', Auth\StartController::class);
        Route::post('/login', Auth\LoginController::class);
        Route::post('/register', Auth\RegisterController::class);
        Route::get('/magic-link/{userHash}', Auth\MagicLinkController::class)
            ->name('magic_link')
            ->middleware('signed');
    });

    Route::post('/logout', Auth\LogoutController::class);
});

/**
 * Fallback url for any requests to our that don't match. Performs a specific
 * redirect to the frontend. If we use frontend proxy features like netlify and
 * zeit offer, we might run into infinity redirects for api urls.
 */
Route::any('/{url}', function ($url = '') {
    return Response::redirectTo(Url::frontend($url), 301);
})->where('url', '.*');
