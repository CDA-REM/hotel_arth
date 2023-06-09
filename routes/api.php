<?php

use App\Http\Controllers\AdvantageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PromotionalBannerController;
use App\Http\Controllers\PresentationVideoController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoomCategoryController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QRCodeController;
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

Route::middleware('setLocale')->group(function () {
    # Login route
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    # Register route
    Route::post('/register', [AuthController::class, 'register']);
    # Logout route

    # Protected routes by auth:sanctum
    Route::middleware('auth:sanctum')->group(function () {
        #Logout route
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::middleware('setLocale')->prefix('home')->group(function () {
            # Reviews API routes
            Route::post('/reviews', [ReviewController::class, 'store']);
            });
        });
    # Protected Users API routes 'api/users/'
    Route::middleware('auth:sanctum')->prefix('users')->group(function () {
//        Route::get('/users', [UserController::class, 'index']);
        # Get a user
//        Route::get('/{id}', [UserController::class, 'user']);
        # Modify a user
        Route::put('/{id}', [UserController::class, 'update']);
        # Delete a user
        Route::delete('/{id}', [UserController::class, 'destroy']);
        # Get info of user connected
        Route::get('/me', [UserController::class, 'me']);
    });


});


#######  Route rooms api/rooms
Route::middleware('setLocale')->prefix('rooms')->group(function () {
# Rooms API routes
    Route::get('/', [RoomController::class, 'index']);
    Route::get('/{room_number}', [RoomController::class, 'show']);
}); #######  END Route rooms

#######  Route reservation api/reservation
Route::middleware('setLocale')->prefix('reservation')->group(function () {
###### Options API routes
    Route::post('/options', [OptionController::class, 'store']);
    Route::put('/options/{id}', [OptionController::class, 'update']);
}); ###### END reservation API routes

#######  Route reservations api/reservations
Route::middleware('setLocale')->prefix('reservations')->group(function () {
    Route::put('/{id}', [ReservationController::class, 'update']);
    Route::get('/availability', [ReservationController::class, 'getAvailableRooms']);
    Route::get('/{id}', [ReservationController::class, 'show']);
    Route::post('/create', [ReservationController::class, 'createReservation']);
    Route::delete('/delete/{id}', [ReservationController::class, 'destroy']);
}); #######  END Route reservations api/reservations



# Routes '/api/home/' to display  the landing page
Route::middleware('setLocale')->prefix('home')->group(function () {

    ######  Route to display the landing page
        # Hero API routes
            Route::get('/hero', [HeroController::class, 'index']);

        # Promotional Banner API routes
            Route::get('/promotional_banner', [PromotionalBannerController::class, 'index']);

        # Presentation Video API routes
            Route::get('/presentation_video', [PresentationVideoController::class, 'index']);

        # RoomCategory API routes
            Route::get('/room_category', [RoomCategoryController::class, 'index']);

        # advantages API routes
            Route::get('/advantages', [AdvantageController::class, 'index']);

        # Reviews API routes
            Route::get('/reviews', [ReviewController::class, 'index']);

        # News
            Route::get('/news', [NewsController::class, 'index']);

        # Footer API routes
            Route::get('/footer', [FooterController::class, 'index']);

        # Social Media API routes
            Route::get('/social_medias', [SocialMediaController::class, 'index']);
    ######  END Route to display the landing page

}); # END Routes '/api/home/ landing page'


# Protected routes
Route::middleware(['auth:sanctum','role:admin'])->group(function () {

#######  Protected Route api/home
    Route::middleware('setLocale')->prefix('home')->group(function () {

    # Hero API routes
    Route::post('/hero/{id}', [HeroController::class, 'update']);

    # Promotional Banner API routes
    Route::put('/promotional_banner/{id}', [PromotionalBannerController::class, 'update']);

    # Presentation Video API routes
    Route::get('/presentation_video/{id}', [PresentationVideoController::class, 'show']);
    Route::post('/presentation_video/{id}', [PresentationVideoController::class, 'update']);

    # RoomCategory API routes
    Route::post('/room_category/{id}', [RoomCategoryController::class, 'update']);

    # advantages API routes
    # Modification of avantages
    Route::post('/advantages/{id}', [AdvantageController::class, 'update']);
    //Route::delete('/advantages/{id}', [AdvantageController::class, 'destroy']);

    # Reviews API routes
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    //Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

    # News
    # update a review
    Route::post('/news/{id}', [NewsController::class, 'update']);
    # Post a new review
    Route::post('/news', [NewsController::class, 'store']);

    # Footer API routes
    # Modify a link in the footer
    Route::put('/footer/{id}', [FooterController::class, 'update']);
    # Delete a link in the footer
    Route::delete('/footer/{id}', [FooterController::class, 'destroy']);
    # Add a new link in the footer
    Route::post('/footer', [FooterController::class, 'store']);

    # Social Media API routes
    # Update a link of social media
    Route::post('/social_medias/{id}', [SocialMediaController::class, 'update']);
    # Delete link of social media
    Route::delete('/social_medias/{id}', [SocialMediaController::class, 'destroy']);
    # Post a new a link of social media
    Route::post('/social_medias', [SocialMediaController::class, 'store']);

}); #######  Protected Route api/home

#######  Protected Route rooms
    Route::middleware('setLocale')->prefix('rooms')->group(function () {
        Route::post('/', [RoomController::class, 'store']);
        Route::put('/{room_number}', [RoomController::class, 'update']);
        Route::delete('/{room_number}', [RoomController::class, 'destroy']);
    }); #######  END Protected Route rooms

#######  Protected Route reservation
    Route::middleware('setLocale')->prefix('reservation')->group(function () {
    # Options API routes
        #Route::post('/options', [OptionController::class, 'store']);
        Route::get('/options', [OptionController::class, 'index']);
        # Route::put('/options/{id}', [OptionController::class, 'update']);
    });

});#######  END Protected Route admin

Route::get('qr/reservation/{id}', [QRCodeController::class, 'show']);
Route::post('reservation/{id}/send_mail', [MailController::class, 'sendmail']);
Route::get('reservation/test/{id}', [ReservationController::class, 'test']);
