<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\EmailListController;
use App\Http\Controllers\SubscriberController;

Route::view('/', 'welcome');

Route::view('/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/email-list', [EmailListController::class, 'index'])->name('email-list.index');
    Route::get('/email-list/create', [EmailListController::class, 'create'])->name('email-list.create');
    Route::post('/email-list/create', [EmailListController::class, 'store']);
    Route::get('/email-list/{emailList}/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::get('/email-list/{emailList}/subscribers/create', [SubscriberController::class, 'create'])->name('subscribers.create');
    Route::post('/email-list/{emailList}/subscribers/create', [SubscriberController::class, 'store']);
    Route::delete('/email-list/{emailList}/subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');

    Route::resource('template', TemplateController::class);
    Route::resource('campaign', CampaignController::class)->only(['index', 'create', 'destroy']);
});

require __DIR__ . '/auth.php';
