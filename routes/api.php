<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\api\v1\MediaController;
use App\Http\Controllers\api\v1\NewsCategoryController;
use App\Http\Controllers\api\v1\NewsDetailController;
use App\Http\Controllers\api\v1\GeneralSettingsController;
use App\Http\Controllers\api\v1\LandingPagesController;
use App\Http\Controllers\api\v1\ContactController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::get('/v1/news-category', [NewsCategoryController::class, 'getNewsCategories']);
Route::get('/v1/get-news/{slug}', [NewsCategoryController::class, 'getNewsByCategory']);

Route::get('/v1/news-detail/{newsSlug}', [NewsDetailController::class, 'fetchNewsDetails']);



Route::middleware('auth:sanctum')->group( function () {

    // Route::get('/v1/my-profile', [CustomerController::class, 'myProfile']);
    // Route::get('/v1/order-details/{order_id}', [CustomerController::class, 'orderDetails']);
    // Route::post('/v1/logout', [CustomerController::class, 'logout']);

    // Route::post('/v1/cart/add', [CartController::class, 'addToCart']);
    // Route::delete('/v1/cart/remove/{cartItemId}', [CartController::class, 'removeFromCart']);
    // Route::get('/v1/cart/fetch', [CartController::class, 'fetchCart']);
    // Route::post('/v1/cart/update', [CartController::class, 'updateCart']);

    // Route::post('/v1/wish-list/add', [WishListController::class, 'addToWishList']);
    // Route::get('/v1/wish-list/fetch', [WishListController::class, 'fetchWishList']);
    // Route::delete('/v1/wish-list/remove/{wishlistId}', [WishListController::class, 'removeFromWishList']);

});

// Route::post('/v1/cart/sync', [CartController::class, 'syncCart']);
// Route::post('/v1/checkout', [CheckoutController::class, 'checkout']);
// Route::post('/v1/success-payment', [CheckoutController::class, 'success']);

Route::get('/v1/search', [NewsCategoryController::class, 'search']);
Route::get('/v1/home', [GeneralSettingsController::class, 'homePage']);
Route::get('/v1/website-logo', [GeneralSettingsController::class, 'websiteLogo']);

Route::get('/v1/landing-pages/{slug}', [LandingPagesController::class, 'landingPages']);
// Route::get('/v1/get-filtered-products/{slug}/{optionId}', [ProductCategoryController::class, 'getFilteredProducts']);
Route::post('/v1/contact', [ContactController::class, 'contact']);


