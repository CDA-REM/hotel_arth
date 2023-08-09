<?php

use App\Http\Controllers\AdvantageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\KeyCardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PromotionalBannerController;
use App\Http\Controllers\PresentationVideoController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoomCategoryController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QRCodeController;
use App\Repository\ReservationRepository;
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
    # Api login route
    Route::post('/sanctum/token', [AuthController::class, 'loginApi'])->name('loginApi');
    # Register route
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    # Logout route

    # Protected routes by auth:sanctum
    Route::middleware('auth:sanctum')->group(function () {
        #Logout route
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::middleware('setLocale')->prefix('home')->group(function () {
            # Reviews API routes
            Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        });
    });
    # Protected Users API routes 'api/users/'
    Route::middleware('auth:sanctum')->prefix('users')->name('users')->group(function () {
//        Route::get('/users', [UserController::class, 'index']);
        # Get a user
//        Route::get('/{id}', [UserController::class, 'user']);
        # Modify a user
        Route::put('/{id}', [UserController::class, 'update'])->name('.update');
        # Delete a user
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('.delete');
        # Get info of user connected
        Route::get('/me', [UserController::class, 'me'])->name('.me');
        # Get info of admin connected
        Route::get('/admin', [UserController::class, 'admin'])->name('.admin');
    });
});


#######  Route rooms api/rooms
Route::middleware('setLocale')->prefix('rooms')->name('rooms')->group(function () {
# Rooms API routes
    Route::get('/', [RoomController::class, 'index'])->name('.index');
    Route::get('/{room_number}', [RoomController::class, 'show'])->name('.show');
}); #######  END Route rooms

#######  Route reservation api/reservation
Route::middleware('setLocale')->prefix('reservation')->name('reservation')->group(function () {
###### Options API routes
    Route::post('/options', [OptionController::class, 'store'])->name('.store');
    Route::put('/options/{id}', [OptionController::class, 'update'])->name('.update');
}); ###### END reservation API routes

#######  Route reservations api/reservations
Route::middleware('setLocale')->prefix('reservations')->name('reservations')->group(function () {
    Route::get('/', [ReservationController::class, 'index'])->name('.index');
    Route::put('checkin/{reservation}', [ReservationController::class, 'checkin'])->name('.checkin');
    Route::put('checkout/{reservation}', [ReservationController::class, 'checkout'])->name('.checkout');
    Route::get('/availability', [ReservationController::class, 'getAvailableRoomsFromRequest'])->name('.availability');
    Route::get('/{id}', [ReservationController::class, 'show'])->name('.show');
    Route::post('/create', [ReservationController::class, 'createReservation'])->name('.create');
    Route::delete('/delete/{id}', [ReservationController::class, 'destroy'])->name('.destroy');
}); #######  END Route reservations api/reservations


# Routes '/api/home/' to display  the landing page
Route::middleware('setLocale')->prefix('home')->name('home')->group(function () {
    ######  Route to display the landing page
    # Hero API routes
    Route::get('/hero', [HeroController::class, 'index'])->name('.hero');

    # Promotional Banner API routes
    Route::get('/promotional_banner', [PromotionalBannerController::class, 'index'])->name('.promotional_banner');

    # Presentation Video API routes
    Route::get('/presentation_video', [PresentationVideoController::class, 'index'])->name('.presentation_video');

    # RoomCategory API routes
    Route::get('/room_category', [RoomCategoryController::class, 'index'])->name('.room_category');

    # advantages API routes
    Route::get('/advantages', [AdvantageController::class, 'index'])->name('.advantages');

    # Reviews API routes
    Route::get('/reviews', [ReviewController::class, 'index'])->name('.reviews');

    # News
    Route::get('/news', [NewsController::class, 'index'])->name('.news');

    # Footer API routes
    Route::get('/footer', [FooterController::class, 'index'])->name('.footer');

    # Social Media API routes
    Route::get('/social_medias', [SocialMediaController::class, 'index'])->name('.social_medias');
    ######  END Route to display the landing page

}); # END Routes '/api/home/ landing page'


# START - Protected routes admin
Route::middleware(['auth:sanctum', 'role:admin'])->name('admin')->group(function () {

#######  Protected Route api/home
    Route::middleware('setLocale')->prefix('home')->name('home')->group(function () {

        # Hero API routes
        Route::post('/hero/{id}', [HeroController::class, 'update'])->name('.heroUpdate');

        # Promotional Banner API routes
        Route::put('/promotional_banner/{id}', [PromotionalBannerController::class, 'update'])->name('.promotional_bannerUpdate');

        # Presentation Video API routes
        Route::get('/presentation_video/{id}', [PresentationVideoController::class, 'show'])->name('.presentation_videoShow');
        Route::post('/presentation_video/{id}', [PresentationVideoController::class, 'update'])->name('.presentation_videoUpdate');

        # RoomCategory API routes
        Route::post('/room_category/{id}', [RoomCategoryController::class, 'update'])->name('.room_categoryUpdate');

        # advantages API routes
        # Modification of advantages
        Route::post('/advantages/{id}', [AdvantageController::class, 'update'])->name('.advantagesUpdate');
        //Route::delete('/advantages/{id}', [AdvantageController::class, 'destroy']);

        # Reviews API routes
        Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('.reviewsUpdate');
        //Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

        # News
        # update a review
        Route::post('/news/{id}', [NewsController::class, 'update'])->name('.newsUpdate');
        # Post a new review
        Route::post('/news', [NewsController::class, 'store'])->name('.newsStore');

        # Footer API routes
        # Modify a link in the footer
        Route::put('/footer/{id}', [FooterController::class, 'update'])->name('.footerUpdate');
        # Delete a link in the footer
        Route::delete('/footer/{id}', [FooterController::class, 'destroy'])->name('.footerDelete');
        # Add a new link in the footer
        Route::post('/footer', [FooterController::class, 'store'])->name('.footerStore');

        # Social Media API routes
        # Update a link of social media
        Route::post('/social_medias/{id}', [SocialMediaController::class, 'update'])->name('.social_mediasUpdate');
        # Delete link of social media
        Route::delete('/social_medias/{id}', [SocialMediaController::class, 'destroy'])->name('.social_mediasDelete');
        # Post a new a link of social media
        Route::post('/social_medias', [SocialMediaController::class, 'store'])->name('.social_mediasStore');

    }); #######  Protected Route api/home

#######  Protected Route rooms
    Route::middleware('setLocale')->prefix('rooms')->name('rooms')->group(function () {
        Route::post('/', [RoomController::class, 'store'])->name('.store');
        Route::put('/{room_number}', [RoomController::class, 'update'])->name('.update');
        Route::delete('/{room_number}', [RoomController::class, 'destroy'])->name('.destroy');
    }); #######  END Protected Route rooms

#######  Protected Route reservation
    Route::middleware('setLocale')->prefix('reservation')->name('reservation')->group(function () {
        # Options API routes
        #Route::post('/options', [OptionController::class, 'store']);
        Route::get('/options', [OptionController::class, 'index'])->name('.optionsIndex');
        # Route::put('/options/{id}', [OptionController::class, 'update']);
    });
});
# END - Protected routes admin

# START - Route QRCode
Route::get('qr/reservation/{id}', [QRCodeController::class, 'show'])->name('qrCode.show');
# START - Route Email
//Route::post('reservation/{id}/send_mail', [MailController::class, 'sendmail']);
# START - Route test
Route::get('reservation/test/{id}', [ReservationController::class, 'test'])->name('reservation.test');

# START - Route key cards
Route::middleware('setLocale')->prefix('keycard')->name('keycard')->group(function () {
    Route::post('/', [KeyCardController::class, 'create'])->name('.create');
    Route::get('/{keyCard}', [KeyCardController::class, 'show'])->name('.show');
    Route::post('/room', [KeyCardController::class, 'openRoomDoor'])->name('.openRoomDoor');
});
# END - Route key cards

# START - Route statistics
Route::middleware('setLocale')->prefix('statistics')->name('statistics')->group(function () {
    Route::get('/', [StatisticController::class, 'index'])->name('.index');
    Route::get('/{key_card_id}', [StatisticController::class, 'show'])->name('.show');
});
# END - Route statistics


Route::get('/keycardReservation/{keyCard}', [KeyCardController::class, 'showWithReservation'])->name('keycardReservation.show');

// Tests for dashboard
Route::get('/dashboard/operational', [DashboardController::class, 'getOperationalDashboardData'])->name('operationalDashboard');


// START - Routes Dashboard Tactic
Route::get('dashboard/tactical/reservationsBetweenDates', [DashboardController::class, 'getReservationsBetweenTwoDates'])->name('tacticalDashboard');
Route::get('/dashboard/tactical/totalSales', [DashboardController::class, 'getTotalSalesBetweenTwoDates']);
Route::get('/dashboard/tactical/averageCartEvolution', [DashboardController::class, 'getAverageCartValueBetweenTwoDates']);
Route::get('/dashboard/tactical/occupancy', [DashboardController::class, 'getNumberOfReservationsBetweenTwoDates']);
Route::get('/dashboard/tactical/occupancyRate', [DashboardController::class, 'getOccupancyRateBetweenTwoDates']);
Route::get('/dashboard/tactical/occupancyRateByRoomType', [DashboardController::class, 'getOccupancyRatePerRoomTypeBetweenTwoDates']);
Route::get('/dashboard/tactical/occupancyRateByOptions', [DashboardController::class, 'getOccupancyRatePerOptionBetweenTwoDates']);
Route::get('/dashboard/tactical/averageTimeBetweenBookingAndCheckin', [DashboardController::class, 'getAverageTimeBetweenBookingAndCheckin']);
Route::get('/dashboard/tactical/averageDurationOfAReception', [DashboardController::class, 'getAverageDurationOfAReception']);
// END - Routes Dashboard Tactic
