<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\PromotionalBannerController;
use App\Http\Controllers\PresentationVideoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoomCategoryController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

# Hero API routes
Route::get('/home/hero', [HeroController::class, 'index']);
Route::post('/home/hero', [HeroController::class, 'update']);

# Promotional Banner API routes
Route::get('/home/promotional_banner', [PromotionalBannerController::class, 'index']);
Route::put('/home/promotional_banner/{id}', [PromotionalBannerController::class, 'update']);

# Presentation Video API routes
Route::get('/home/presentation_video', [PresentationVideoController::class, 'index']);
Route::post('/home/presentation_video/{id}', [PresentationVideoController::class, 'update']);

# RoomCategory API routes
Route::get('/home/room_category', [RoomCategoryController::class, 'index']);
Route::post('home/room_category/{id}', [RoomCategoryController::class, 'update']);



# Avantages API routes





# Customers API routes
Route::post('/home/customers', [CustomerController::class, 'create']);
Route::get('/home/customers', [CustomerController::class, 'index']);
Route::put('/home/customers/{id}', [CustomerController::class, 'update']);
//Route::delete('/home/customers/{id}', [CustomerController::class, 'destroy']);

# Reviews API routes
Route::post('/home/reviews', [ReviewController::class, 'create']);
Route::get('/home/reviews', [ReviewController::class, 'index']);
Route::put('/home/reviews/{id}', [ReviewController::class, 'update']);
//Route::delete('/home/reviews/{id}', [ReviewController::class, 'destroy']);

#Admin API routes
