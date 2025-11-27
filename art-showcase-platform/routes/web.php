<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Member\DashboardController as MemberDashboard;
use App\Http\Controllers\Member\ArtworkController as MemberArtwork;
use App\Http\Controllers\Member\ProfileController as MemberProfile;
use App\Http\Controllers\Curator\PendingController;
use App\Http\Controllers\Curator\DashboardController as CuratorDashboard;
use App\Http\Controllers\Curator\ChallengeController as CuratorChallenge;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\ModerationController as AdminModeration;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/artworks/{id}', [HomeController::class, 'show'])->name('artworks.show');
Route::get('/profile/{username}', [HomeController::class, 'profile'])->name('profile.show');
Route::get('/challenges', [HomeController::class, 'challenges'])->name('challenges.index');
Route::get('/challenges/{id}', [HomeController::class, 'challengeShow'])->name('challenges.show');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
});

require __DIR__.'/auth.php';

// Member Routes
Route::middleware(['auth', 'verified'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberDashboard::class, 'index'])->name('dashboard');
    Route::get('/favorites', [MemberDashboard::class, 'favorites'])->name('favorites');
    Route::get('/submissions', [MemberDashboard::class, 'submissions'])->name('submissions');
    
    Route::resource('artworks', MemberArtwork::class);
    
    Route::post('/artworks/{id}/like', [MemberArtwork::class, 'like'])->name('artworks.like');
    Route::post('/artworks/{id}/favorite', [MemberArtwork::class, 'favorite'])->name('artworks.favorite');
    Route::post('/artworks/{id}/comment', [MemberArtwork::class, 'comment'])->name('artworks.comment');
    Route::delete('/comments/{id}', [MemberArtwork::class, 'deleteComment'])->name('comments.delete');
    Route::post('/artworks/{id}/report', [MemberArtwork::class, 'report'])->name('artworks.report');
    
    Route::get('/profile/edit', [MemberProfile::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [MemberProfile::class, 'update'])->name('profile.update');
});

// Curator Routes
Route::middleware(['auth', 'verified'])->prefix('curator')->name('curator.')->group(function () {
    Route::get('/pending', [PendingController::class, 'index'])->name('pending');
    
    Route::middleware('curator.active')->group(function () {
        Route::get('/dashboard', [CuratorDashboard::class, 'index'])->name('dashboard');
        Route::resource('challenges', CuratorChallenge::class);
        Route::get('/challenges/{id}/submissions', [CuratorChallenge::class, 'submissions'])->name('challenges.submissions');
        Route::post('/submissions/{id}/select-winner', [CuratorChallenge::class, 'selectWinner'])->name('submissions.winner');
    });
});

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    Route::get('/users', [AdminUser::class, 'index'])->name('users.index');
    Route::post('/users/{id}/approve', [AdminUser::class, 'approveCurator'])->name('users.approve');
    Route::delete('/users/{id}', [AdminUser::class, 'destroy'])->name('users.destroy');
    
    Route::get('/categories', [AdminCategory::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategory::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [AdminCategory::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategory::class, 'destroy'])->name('categories.destroy');
    
    Route::get('/moderation', [AdminModeration::class, 'index'])->name('moderation.index');
    Route::post('/reports/{id}/dismiss', [AdminModeration::class, 'dismiss'])->name('reports.dismiss');
    Route::post('/reports/{id}/resolve', [AdminModeration::class, 'resolve'])->name('reports.resolve');
});