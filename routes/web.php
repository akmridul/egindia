<?php

use App\Http\Controllers\SearchMeetingController;
use Illuminate\Support\Facades\Route;

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
    return view('jsonupload');
})->name('upload.form');

Route::post('/upload', [SearchMeetingController::class, 'uploadFile'])->name('upload.file');
Route::get('/searchmeeting', [SearchMeetingController::class, 'searchMeeting'])->name('search.meeting');
Route::post('/searchsubmit', [SearchMeetingController::class, 'searchSubmit'])->name('search.submit');
