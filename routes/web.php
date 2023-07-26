<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',function(){
    return redirect('login');
});


// ADMIN
Route::middleware(['auth','level:admin'])
->prefix('admin')
->group(function () {
Route::resource('/',\App\Http\Controllers\Admin\DashboardController::class);
Route::resource('/branch',\App\Http\Controllers\Admin\BranchController::class);
Route::resource('/mine',\App\Http\Controllers\Admin\MineController::class);
Route::resource('/driver',\App\Http\Controllers\Admin\DriverController::class);
Route::resource('/vehicle',\App\Http\Controllers\Admin\VehicleController::class);
Route::resource('/booking',\App\Http\Controllers\Admin\VehicleBookingController::class);
Route::get('/report',[\App\Http\Controllers\Admin\ReportController::class,'index'])->name('report.index');
Route::get('/report/export',[\App\Http\Controllers\Admin\ReportController::class,'exportExcel'])->name('report.excel');
});

Route::middleware(['auth','level:approver'])
->group(function () {
Route::resource('/',\App\Http\Controllers\Approver\DashboardController::class);
Route::get('/pending',[\App\Http\Controllers\Approver\BookingController::class,'pending']);
Route::get('/approve',[\App\Http\Controllers\Approver\BookingController::class,'approve']);
Route::get('/reject',[\App\Http\Controllers\Approver\BookingController::class,'reject']);

Route::get('/approval1/{id}',[\App\Http\Controllers\Approver\BookingController::class,'approval1'])->name('booking.approve1');
Route::get('/approval2/{id}',[\App\Http\Controllers\Approver\BookingController::class,'approval2'])->name('booking.approve2');

Route::get('/rejected1/{id}',[\App\Http\Controllers\Approver\BookingController::class,'rejected1'])->name('booking.rejected1');
Route::get('/rejected2/{id}',[\App\Http\Controllers\Approver\BookingController::class,'rejected2'])->name('booking.rejected2');


});

require __DIR__.'/auth.php';
