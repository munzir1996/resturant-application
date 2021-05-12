<?php

use App\Http\Controllers\API\Auth\ClientAuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\CLient\ResturantController;
use App\Http\Controllers\API\CountryController;
use App\Http\Controllers\API\LanguageController;
use App\Http\Controllers\API\PolicyController;
use App\Http\Controllers\API\SubcategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('languages', LanguageController::class);
Route::apiResource('policies', PolicyController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('subcategories', SubcategoryController::class);
Route::apiResource('countries', CountryController::class);
Route::apiResource('cities', CityController::class);

Route::prefix('/client')->group(function () {
    Route::post('register', [ClientAuthController::class, 'register'])->name('client.register');
    Route::post('login', [ClientAuthController::class, 'login'])->name('client.login');
});
//phone
Route::prefix('/client')->middleware(['auth:sanctum', 'type.client'])->group(function () {
    Route::put('profile', [ClientAuthController::class, 'updateProfile'])->name('client.profile.update');
    Route::post('logout', [ClientAuthController::class, 'logout'])->name('client.logout');
    Route::apiResource('resturants', ResturantController::class);
});


