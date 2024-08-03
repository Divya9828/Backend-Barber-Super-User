<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:api')->group(function () {
//     Route::post('/shop/store', [UserController::class, 'store']);
// });

Route::get('/debug-auth', function() {
    echo "hi";
    return response()->json(['user' => auth()->user(), 'user_id' => auth()->id()]);
})->middleware('auth');

Route::post('/registerUser',[UserController::class,'store'])->middleware('auth');
