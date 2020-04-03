<?php

use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', Api\MeController::class);

    Route::get('/channels', Api\Channel\ListController::class);
    Route::post('/channels', Api\Channel\CreateController::class);
    Route::get('/channels/{channel}', Api\Channel\ShowController::class);
    Route::patch('/channels/{channel}', Api\Channel\UpdateController::class);
    Route::patch('/channels/{channel}/leave', Api\Channel\LeaveController::class);
    Route::delete('/channels/{channel}', Api\Channel\DeleteController::class);

    Route::get('/channels/{channel}/members', Api\Channel\Member\ListController::class);

    Route::get('/channels/{channel}/messages', Api\Channel\Message\ListController::class);
    Route::post('/channels/{channel}/messages', Api\Channel\Message\CreateController::class);

    Route::get('/channels/{channel}/messages/{message}', Api\Channel\Message\ShowController::class);
    Route::patch('/channels/{channel}/messages/{message}', Api\Channel\Message\UpdateController::class);
    Route::delete('/channels/{channel}/messages/{message}', Api\Channel\Message\DeleteController::class);

});
