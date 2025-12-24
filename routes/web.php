<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('github-api')->name('github-api.')->group(function () {
    Route::get('/', [App\Http\Controllers\GitHubApiController::class, 'index'])->name('index');
    Route::post('/users/authenticated', [App\Http\Controllers\GitHubApiController::class, 'getAuthenticatedUser'])->name('users.authenticated');
    Route::post('/users/get', [App\Http\Controllers\GitHubApiController::class, 'getUser'])->name('users.get');
    Route::post('/users/followers', [App\Http\Controllers\GitHubApiController::class, 'getUserFollowers'])->name('users.followers');
    Route::post('/users/following', [App\Http\Controllers\GitHubApiController::class, 'getUserFollowing'])->name('users.following');
    Route::post('/repositories/authenticated', [App\Http\Controllers\GitHubApiController::class, 'getAuthenticatedUserRepositories'])->name('repositories.authenticated');
    Route::post('/repositories/user', [App\Http\Controllers\GitHubApiController::class, 'getUserRepositories'])->name('repositories.user');
    Route::post('/repositories/get', [App\Http\Controllers\GitHubApiController::class, 'getRepository'])->name('repositories.get');
    Route::post('/repositories/search', [App\Http\Controllers\GitHubApiController::class, 'searchRepositories'])->name('repositories.search');
    Route::post('/repositories/create', [App\Http\Controllers\GitHubApiController::class, 'createRepository'])->name('repositories.create');
});

require __DIR__.'/settings.php';
