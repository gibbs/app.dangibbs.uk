<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::get('/', function() {
    return redirect()->away('https://dangibbs.uk/', 301);
});

// Data
Route::prefix('data')->group(function() {
    Route::get('/activity-feed.json', Controllers\Data\ActivityFeed::class);
    Route::get('/eol/linux.json', Controllers\Data\EOL\Linux::class);
});

// Tools
Route::prefix('tool')->group(function() {
    Route::post('/dig', Controllers\Tool\Dig::class);
    Route::post('/uuidgen', Controllers\Tool\Uuid::class);
    Route::post('/mkpasswd', Controllers\Tool\Mkpasswd::class);
    Route::post('/pwgen', Controllers\Tool\Pwgen::class);
});
