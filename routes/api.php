<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MovieController;
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
require __DIR__ . '/auth.php';


Route::get('csrf-token', function () {
  return response()->json(['token' => csrf_token()]);
});

//movie 
Route::get('all-movies', [MovieController::class, 'allMovie']);
Route::get('top-movies', [MovieController::class, 'topMovies']);
Route::get('category-wise-movies', [CategoryController::class, 'categoryWiseMovies']);
Route::get('single-movie/{movie}', [MovieController::class, 'singleMovie']);

Route::post('ai-movie-store', [MovieController::class, 'aiMovieStore']);
//Category 
Route::get('all-category', [CategoryController::class, 'allCategory']);
Route::get('single-category/{category}', [CategoryController::class, 'singleCategory']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    //movie 
    Route::post('movie-store', [MovieController::class, 'store']);
    Route::post('movie-update/{movie}', [MovieController::class, 'update']);
    Route::delete('movie-delete/{movie}', [MovieController::class, 'delete']);
    
    //Category
    Route::post('category-store', [CategoryController::class, 'store']);
    Route::post('category-update/{category}', [CategoryController::class, 'update']);
    Route::delete('category-delete/{category}', [CategoryController::class, 'delete']);
});