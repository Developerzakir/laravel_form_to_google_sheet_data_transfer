<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleSheetController;

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
    return view('google-sheet');
});





Route::controller(GoogleSheetController::class)->group(function () {

    Route::get('/google-sheet', 'index');
    Route::post('/google-sheet/store',  'store');
    Route::delete('/google-sheet/delete/{row}', 'destroy');
  
});

