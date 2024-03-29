<?php

use App\Http\Controllers\API\Auth\ClientAuthController;
use App\Http\Controllers\API\CLient\CategoryController;
use App\Http\Controllers\API\CLient\CityController;
use App\Http\Controllers\API\Client\ClassificationController;
use App\Http\Controllers\API\Client\ClientController;
use App\Http\Controllers\API\CLient\CountryController;
use App\Http\Controllers\API\CLient\LanguageController;
use App\Http\Controllers\API\Client\MealController;
use App\Http\Controllers\API\CLient\PolicyController;
use App\Http\Controllers\API\CLient\ResturantController;
use App\Http\Controllers\API\Client\ResturantServiceController;
use App\Http\Controllers\API\CLient\SubcategoryController;
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

Route::prefix('/client')->group(function () {
    Route::post('register', [ClientAuthController::class, 'register'])->name('client.register');
    Route::post('login', [ClientAuthController::class, 'login'])->name('client.login');
    Route::apiResource('countries', CountryController::class);
    Route::apiResource('cities', CityController::class);
    Route::apiResource('policies', PolicyController::class);
    Route::get('roles', [ClientController::class, 'getRoles']);
    Route::get('restaurant/services', [ResturantController::class, 'getServices']);
    Route::get('restaurant/payment/methods', [ResturantController::class, 'getPaymentMethods']);
});

//phone
Route::prefix('/client')->middleware(['auth:sanctum', 'type.client'])->group(function () {
    Route::put('profile', [ClientAuthController::class, 'updateProfile'])->name('client.profile.update');
    Route::post('logout', [ClientAuthController::class, 'logout'])->name('client.logout');
    Route::apiResource('meals', MealController::class);
    Route::apiResource('resturantservices', ResturantServiceController::class)->parameter('resturantservices', 'resturantService');
    Route::apiResource('resturants', ResturantController::class);
    Route::get('resturants/basic/info/{client}', [ResturantController::class, 'getBasicInformation']);
    Route::post('resturants/basic/info', [ResturantController::class, 'storeBasicInfo']);
    Route::get('resturants/info/{client}', [ResturantController::class, 'getResturantInfo']);
    Route::post('resturants/info/{resturant}', [ResturantController::class, 'storeResturantInfo']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('subcategories', SubcategoryController::class);
    Route::apiResource('classifications', ClassificationController::class);
});





