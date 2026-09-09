<?php

use App\Http\Controllers\API\StoreApiKeyController;
use App\Http\Controllers\API\v1\CollectionController;
use App\Http\Controllers\API\v1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->middleware([
        'auth:sanctum',
        'throttle:api-v1'
    ])
    ->group(function(){

        //Products routes
        Route::middleware('abilities:products:read')->group(function(){
            Route::get('products', [ProductController::class, 'index'])->name('api.v1.products.index');
            Route::get('products/{product}', [ProductController::class, 'show'])->name('api.v1.products.show');
        });


        //Collections routes
        Route::get('collections/', [CollectionController::class, 'index'])->name('api.v1.collections.index');
        Route::get('collections/{collection}', [CollectionController::class, 'show'])->name('api.v1.collections.show');
    });


//Route::get('/hello', function (){
    //return response()->json([
        //'message' => "Hello world"
    //]);
//});


