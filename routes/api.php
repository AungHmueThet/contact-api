<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ContactController;
use App\Http\Middleware\ApiTokenCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix("v1")->group(function () {

    Route::middleware('auth:sanctum')->group(function () {

        Route::apiResource('contact', ContactController::class);
        Route::delete("fdContact/{id}",[ContactController::class,'forceDelete']);
        Route::get("rsContact/{id}",[ContactController::class,'restore']);

        Route::get("favourite",[\App\Http\Controllers\FavouriteController::class,"index"]);
        Route::post("favourite/add",[\App\Http\Controllers\FavouriteController::class,"addToFavorites"]);
        Route::post("favourite/remove",[\App\Http\Controllers\FavouriteController::class,"removeFromFavorites"]);

        Route::post("logout", [ApiAuthController::class, 'logout']);
        Route::post("logout-all", [ApiAuthController::class, 'logoutAll']);
        Route::get("devices", [ApiAuthController::class, 'devices']);

    });
    Route::post("register", [ApiAuthController::class, 'register']);
    Route::post("login", [ApiAuthController::class, 'login']);
});
