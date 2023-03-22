<?php

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

use App\Http\Controllers\BannerController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommodityController;
use App\Http\Controllers\EnClientController;
use App\Http\Controllers\GlobalSettingController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypiesController;
use App\Http\Controllers\ThirdLinkController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {
    Auth::routes();

    Route::get('/', function () {
        return redirect()->route('commodity');
    });

    Route::middleware(['auth'])->group(function () {
        Route::apiResource('banner', 'BannerController', ['names' => ['index' => 'banner']]);
        Route::get('banner/edit/{banner}', 'BannerController@edit');

        Route::apiResource('/commodity', 'CommodityController', ['names' => ['index' => 'commodity']]);

        Route::get('commodities', 'CommodityController@getCommodities');

        Route::prefix('product-type')->group(function () {
            Route::get('/edit', [ProductTypiesController::class, 'edit'])->name('editProductTypePage');
            Route::get('/create', [ProductTypiesController::class, 'create'])->name('createProductTypePage');
            Route::get('/{type}', [ProductTypiesController::class, 'show']);
            Route::patch('/{type}', [ProductTypiesController::class, 'update']);
            Route::delete('/{type}', [ProductTypiesController::class, 'destroy']);
            Route::get('/', [ProductTypiesController::class, 'index'])->name('product-type');
            Route::post('/', [ProductTypiesController::class, 'store']);
        });

        Route::prefix('product')->group(function () {
            Route::get('/edit', [ProductController::class, 'edit'])->name('editProductPage');
            Route::get('/create', [ProductController::class, 'create'])->name('createProductPage');
            Route::get('/{product}', [ProductController::class, 'show']);
            Route::patch('/{product}', [ProductController::class, 'update']);
            Route::delete('/{product}', [ProductController::class, 'destroy']);
            Route::get('/', [ProductController::class, 'index'])->name('product-admin');
            Route::post('/', [ProductController::class, 'store']);
        });

        Route::prefix('news')->group(function () {
            Route::get('/edit', [NewsController::class, 'edit'])->name('editNewsPage');
            Route::get('/create', [NewsController::class, 'create'])->name('createNewsPage');
            Route::get('/{news}', [NewsController::class, 'show']);
            Route::patch('/{news}', [NewsController::class, 'update']);
            Route::delete('/{news}', [NewsController::class, 'destroy']);
            Route::get('/', [NewsController::class, 'index'])->name('news-admin');
            Route::post('/', [NewsController::class, 'store']);
        });

        Route::prefix('settings')->group(function () {
            Route::get('/edit', [GlobalSettingController::class, 'edit'])->name('editSettingPage');
            Route::get('/{setting}', [GlobalSettingController::class, 'show']);
            Route::patch('/{setting}', [GlobalSettingController::class, 'update']);
            Route::get('/', [GlobalSettingController::class, 'index'])->name('setting-admin');
        });

        //api
        Route::post('/upload', function () {
            $imageURL = request()->file('img')->store('public');
            return 'storage/' . substr($imageURL, 7);
        });

        Route::apiResource('third', 'ThirdLinkController', ['names' => ['index' => 'third']]);

        Route::apiResource('/commodity', 'CommodityController', ['names' => ['index' => 'commodity']]);

        Route::prefix('edit-page')->group(function () {
            Route::get('commodity', [CommodityController::class, 'edit'])->name('editCommodityPage');
            Route::get('link', [ThirdLinkController::class, 'edit'])->name('editLinkPage');
            Route::get('banner', [BannerController::class, 'edit'])->name('editBannerPage');
        });

        Route::prefix('create-page')->group(function () {
            Route::get('link', 'ThirdLinkController@create')->name('createThirdLinkPage');
        });

        Route::get('client-commodity', 'CommodityController@search');
    });
});

Route::prefix('zh')->group(function () {
    Route::get('index', [ClientController::class, 'index'])->name('index');
    Route::get('about', [ClientController::class, 'about'])->name('about');
    Route::get('news', [ClientController::class, 'news'])->name('news');
    Route::get('contact', [ClientController::class, 'contact'])->name('contact');
    Route::get('recommend', [ClientController::class, 'recommend'])->name('recommend');
    Route::get('product', [ClientController::class, 'product'])->name('product');
    Route::get('article/{news}', [ClientController::class, 'article'])->name('article');
    Route::get('product-list', [ClientController::class, 'productList'])->name('product-list');
    Route::get('product-detail/{product}', [ClientController::class, 'productDetail'])->name('product-detail');
});

Route::prefix('en')->group(function () {
    Route::get('index', [EnClientController::class, 'index'])->name('en-index');
    Route::get('about', [EnClientController::class, 'about'])->name('en-about');
    Route::get('news', [EnClientController::class, 'news'])->name('en-news');
    Route::get('contact', [EnClientController::class, 'contact'])->name('en-contact');
    Route::get('recommend', [EnClientController::class, 'recommend'])->name('en-recommend');
    Route::get('product', [EnClientController::class, 'product'])->name('en-product');
    Route::get('article/{news}', [EnClientController::class, 'article'])->name('en-article');
    Route::get('product-list', [EnClientController::class, 'productList'])->name('en-product-list');
    Route::get('product-detail/{product}', [EnClientController::class, 'productDetail'])->name('en-product-detail');
});


Route::prefix('/')->group(function () {
    Route::get('/', function () {
        return redirect()->route('index');
    })->name('home');

    Route::get('/home', function () {
        return redirect()->route('index');
    });
});
