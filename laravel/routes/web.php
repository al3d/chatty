<?php

use App\Http\Controllers\Auth;
use App\Support\Url;
use Illuminate\Support\Facades\Route;

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
 * Fallback url for any GET requests to our frontend
 * that don't match. Performs a specific redirect to the frontend.
 */
Route::get('/{url}', function ($url) {
    return redirect(Url::frontend('/' . $url), 301);
})->where('url', '.*');

/**
 * Fallback for any other types of request (POST, PUT, DELETE, OPTIONS)
 * that don't match above. Simply redirects to the frontend's base url.
 */
Route::fallback(function () {
    return redirect(Url::frontend(), 301);
});
