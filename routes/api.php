<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AuthController; //call auth controller
use App\Http\Controllers\AdminController;  //call admin controller

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


/**
 * 
 *      guest route
 * 
 */

// route untuk mengakses API registrasi akun 
Route::post('register',[AuthController::class,'register']);

//route untuk mengakses API login akun 
Route::post('login',[AuthController::class,'login']);

// menampilkan resep yang sudah berstatus publish
Route::get('recipes',[RecipeController::class,'show_recipes']);

Route::post('recipes/get-recipe',[RecipeController::class,'recipe_by_id']);  //show deeetail resep

//  fitur ulasan resep, dimana terdapat rating 1-5 &  memasukan review dari resep yang di publish.
Route::post('recipes/rating',[RecipeController::class,'rating']);  



/**
 * 
 * route untuk ADMIN Dimana terdapat middleware admin dan juga prefix awalan  url "admin" 
 */
Route::middleware(['admin.api'])->prefix('admin')->group(function() {

    Route::post('register',[AdminController::class,'register']);
    Route::get('register',[AdminController::class,'show_register']);     //routingan untuk Lihat Semua Akun role user
    Route::get('register/{id}',[AdminController::class,'show_register_by_id']);   //show detail akun by id
    Route::put('register/{id}',[AdminController::class,'update_register']);         //Update Akun
    Route::delete('register/{id}',[AdminController::class,'delete_register']);

    Route::get('activation-account/{id}',[AdminController::class,'activation_account']);         //aktivation Akun
    Route::get('deactivation-account/{id}',[AdminController::class,'deactivation_account']);         
    
    Route::post('create-recipe',[AdminController::class,'create_recipe']);  //add recipe
    Route::put('update-recipe/{id}',[AdminController::class,'update_recipe']);  //update recipe

    Route::delete('delete-recipe/{id}',[AdminController::class,'delete_recipe']);  //deleting recipe
    Route::get('publish/{id}',[AdminController::class,'publish_recipe']);      //publishing recipe
    Route::get('unpublish/{id}',[AdminController::class,'unpublish_recipe']);  //unpublishing recipe

     /*  fitur untuk kebutuhan dashboard admin
      yang mana pada dashboard admin terdapat data kalkulasi antara lain jumlah resep, jumlah resep yang
     dipublish, dan resep yang popular    
    */
    Route::get('dashboard',[AdminController::class,'dashboard']);

});


Route::middleware(['user.api'])->prefix('user')->group(function () {
    Route::post('submit-recipe',[UserController::class,'create_recipe']);

});



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
