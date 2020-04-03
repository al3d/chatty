<?php

use App\Http\Controllers\Auth;
use App\Support\Url;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

/**
 * /csrf-cookie is a route added by the sanctum package.
 * it's usually under /sanctum prefix, but through a bit
 * of code research I found you can customise the prefix
 * in the config/sanctum.php file, so I changed it to be
 * in line with the rest of these
 */
Route::post('/auth/start', Auth\StartController::class);
Route::post('/auth/login', Auth\LoginController::class);
Route::post('/auth/logout', Auth\LogoutController::class);
Route::post('/auth/register', Auth\RegisterController::class);
Route::get('/auth/magic-link/{user}', Auth\MagicLinkController::class)
    ->name('magic_link');

Route::get('/ping', function () {
    return Response::json([
        'ack' => time(),
    ]);
});

/**
 * Fallback url for any requests to our that don't match. Performs a specific
 * redirect to the frontend. If we use frontend proxy features like netlify and
 * zeit offer, we might run into infinity redirects for api urls.
 */
Route::any('/{url}', function ($url = '') {
    return Response::redirectTo(Url::frontend('/' . $url), 301);
})->where('url', '.*');
