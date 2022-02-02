<?php

use App\Http\Controllers\ProductRatingController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('newsletter', [\App\Http\Controllers\NewsletterController::class, 'send'])->name('send.newsletter');

    Route::post('products/{product}/rate', [ProductRatingController::class, 'rate']);

    Route::post('products/{product}/unrate', [ProductRatingController::class, 'unrate']);
});

Route::post('sanctum/token','UserTokenController');

//Es un controlador RESTful que genera todas las rutas básicas requeridas para una aplicación y se puede manejar fácilmente usando la clase de controlador
Route::resource('products','ProductController')->middleware('auth:sanctum');

/*Route::resource('categories','CategoriesController');*/
Route::group(
    ['prefix' => ''],//['prefix' => 'v1'] Aqui podemos agregar un prefijo a la ruta por ejemplo api/v1/categories
    function () {
        Route::resource(
            'categories',//Ruta principal
            'CategoriesController',
            ['only' => ['index', 'store', 'update', 'destroy', 'show']]//con el arreglo only le decimos cuales de esas rutas son accesibles
        )->middleware('auth:sanctum');
    }
);
Route::post('newsletter','NewsLetterController@send');
    
