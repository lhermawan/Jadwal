<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;
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
use App\Http\Controllers\ScheduleController;

Route::get('/schedule/calendar', [ScheduleController::class, 'calendar'])->name('schedule.calendar');
Route::get('/generate-schedule', [ScheduleController::class, 'generateSchedule'])->name('schedule.generate');
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
Route::resource('employees', EmployeeController::class);
Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/schedule/export', [ScheduleController::class, 'exportSchedule'])->name('schedule.export');
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports/store', [ReportController::class, 'store'])->name('reports.store');
Route::get('/reports/export/{week}', [ReportController::class, 'export'])->name('reports.export');
