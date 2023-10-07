<?php

use App\Http\Controllers\CalenderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\locationController;
use App\Http\Controllers\PolygonController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SmsController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\GoogleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('backend.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //

});

Route::middleware('can:delete_user')->group(function () {

    Route::resource('/roles', RolesController::class);

});


require __DIR__ . '/auth.php';


Route::resource('users', UserController::class);
// Route::resource('users','UserController');

Route::resource('products', ProductController::class);

Route::resource('catagories', CategoryController::class);

// FOR otp
Route::match(['get', 'post'], '/sendsms', [SmsController::class, 'sendsms'])->name('sendsms');
Route::get('sendotp', [OtpController::class, 'otp'])->name('sendotp');
Route::post('/sendotp', [OtpController::class, 'sendotp'])->name('sendOtp');

// for google map
Route::get('/googleMap', [GoogleController::class, 'googleMap']);
Route::post('/save-location', [locationController::class, 'store'])->name('save.location');
Route::get('/view-locations', [locationController::class, 'viewLocations'])->name('view.locations');
Route::post('/save-polygon', [PolygonController::class,'savePolygon'])->name('save.polygon');
Route::get('/save-polygon', [PolygonController::class,'savePoly']);


//  FOR calender
Route::get('/calender-event',[CalenderController::class,'index']);
Route::post('calender-crude-ajax',[CalenderController::class,'calendarEvents']);
