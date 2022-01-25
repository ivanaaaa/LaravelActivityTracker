<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ReportsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Auth/Register', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/activity/create', function () {
        return Inertia::render('Activity/Create');
    })->name('activity.create');
    Route::post('/activity', [ActivityController::class, 'store'])->name('activity.store');
    //Reports
    Route::get('/reports', function () {
        return Inertia::render('Reports/Reports', ['reports' => Auth::user()->activities()->paginate(15)]);
    })->name('reports');
    Route::post('/reports', [ReportsController::class, 'filter'])->name('reports.filter');
    Route::post('/reports/email', [ReportsController::class, 'sendEmailNotification'])->name('reports.email');
    Route::get('/reports/print', [ReportsController::class, 'printReport'])->name('reports.print');

});
//Unauthorized routes
Route::get('/report/{token}', [ReportsController::class, 'emailReport'])->name('report.notification');
