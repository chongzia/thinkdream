<?php

use Illuminate\Support\Facades\Route;
use Modules\Cms\Http\Controllers\CategoryController;
use Modules\Cms\Http\Controllers\PostController;
use Modules\Cms\Http\Controllers\ResourceController;
use Modules\Cms\Http\Controllers\SettingController;
use Modules\Cms\Http\Controllers\TagController;

Route::prefix('cms')->group(function () {

    Route::adminResource('category', CategoryController::class)->names('cms_category');

    Route::adminResource('post', PostController::class);
    Route::put('post/enable/{id}', [PostController::class, 'enable']);

    Route::adminResource('tag', TagController::class);

    Route::post('setting', [SettingController::class, 'store']);
    Route::get('setting/{key?}', [SettingController::class, 'index']);

    Route::adminResource('resource', ResourceController::class);
    Route::put('resource/enable/{id}', [ResourceController::class, 'enable']);

    //next
});
