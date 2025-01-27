<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\EmailListController;
use App\Http\Controllers\SubscriberController;
use App\Http\Middleware\CampaignCreateSessionControl;
use App\Mail\EmailCampaign;
use App\Models\Campaign;
use Illuminate\Support\Facades\Mail;

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
    Route::resource('campaign', CampaignController::class)->only(['index', 'destroy']);
    Route::get('/campaign/create/{tab?}', [CampaignController::class, 'create'])
        ->middleware(CampaignCreateSessionControl::class)
        ->name('campaign.create');
    Route::post('/campaign/create/{tab?}', [CampaignController::class, 'store']);
    Route::patch('/campaign/{campaign}/restore', [CampaignController::class, 'restore'])->withTrashed()->name('campaign.restore');

    Route::get('/campaign/{campaign}/emails', function (Campaign $campaign) {


        return (new EmailCampaign($campaign))->render();
    });
});

require __DIR__ . '/auth.php';
