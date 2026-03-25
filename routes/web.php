<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CampaignController::class, 'index'])->name('home');
Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');
Route::get('/impact', [CampaignController::class, 'impact'])->name('impact');
Route::post('/donate', [DonationController::class, 'store'])->middleware('throttle:10,1')->name('donate');
Route::get('/donation/success', [DonationController::class, 'success'])->name('donation.success');
Route::post('/mpesa/callback', [\App\Http\Controllers\MpesaCallbackController::class, 'handle'])->name('mpesa.callback');
Route::post('/paynecta/callback', [\App\Http\Controllers\PaynectaCallbackController::class, 'handle'])->name('paynecta.callback');
Route::get('/paynecta/callback', function() {
    return response()->json(['message' => 'Paynecta callback endpoint is active. Expecting POST requests.'], 200);
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $donations = $user->donations()->with('campaign')->latest()->get();
    $totalDonated = $donations->where('status', 'success')->sum('amount');
    
    return view('dashboard', compact('donations', 'totalDonated'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    
    // Campaign Management
    Route::get('/campaigns', [\App\Http\Controllers\AdminController::class, 'campaigns'])->name('campaigns.index');
    Route::get('/campaigns/create', [\App\Http\Controllers\AdminController::class, 'createCampaign'])->name('campaigns.create');
    Route::post('/campaigns', [\App\Http\Controllers\AdminController::class, 'storeCampaign'])->name('campaigns.store');
    Route::get('/campaigns/{campaign}/edit', [\App\Http\Controllers\AdminController::class, 'editCampaign'])->name('campaigns.edit');
    Route::put('/campaigns/{campaign}', [\App\Http\Controllers\AdminController::class, 'updateCampaign'])->name('campaigns.update');
    Route::delete('/campaigns/{campaign}', [\App\Http\Controllers\AdminController::class, 'destroyCampaign'])->name('campaigns.destroy');
    Route::post('/campaigns/{campaign}/updates', [\App\Http\Controllers\AdminController::class, 'addUpdate'])->name('campaigns.updates.store');
    
    // Donation Management
    Route::get('/donations', [\App\Http\Controllers\AdminController::class, 'donations'])->name('donations.index');
    Route::get('/donations/export', [\App\Http\Controllers\AdminController::class, 'exportDonations'])->name('donations.export');

    // Withdrawal Management
    Route::get('/withdrawals', [\App\Http\Controllers\AdminController::class, 'withdrawals'])->name('withdrawals.index');
    Route::post('/withdrawals', [\App\Http\Controllers\AdminController::class, 'storeWithdrawal'])->name('withdrawals.store');
    Route::post('/withdrawals/{withdrawal}/approve', [\App\Http\Controllers\AdminController::class, 'approveWithdrawal'])->name('withdrawals.approve');

    // Staff Management
    Route::resource('staff', \App\Http\Controllers\Admin\StaffController::class);

    // Message Management
    Route::get('/messages', [\App\Http\Controllers\AdminController::class, 'messages'])->name('messages.index');
    Route::post('/messages/{message}/read', [\App\Http\Controllers\AdminController::class, 'markMessageRead'])->name('messages.read');
});

Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

require __DIR__.'/auth.php';
