<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('front.index');

Route::get('/category/{category:slug}', [FrontController::class, 'category'])->name('front.category');

Route::get('/author/{author}', [FrontController::class, 'author'])->name('front.author');

Route::get('/details/{post}', [FrontController::class, 'details'])->name('front.details');

Route::get('/search', [FrontController::class, 'search'])->name('front.search');
