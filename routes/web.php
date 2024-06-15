<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegionController;

use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\PermissionController;


use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Author\PostController as AuthorPostController;
use App\Http\Controllers\Author\DashboardController as AuthorDashboardController;
use App\Http\Controllers\Author\ProfileController as AuthorProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('region/getCity', [RegionController::class, 'getCity'])->name('region.getCity');
Route::get('region/getDistrict', [RegionController::class, 'getDistrict'])->name('region.getDistrict');
Route::get('region/getVillage', [RegionController::class, 'getVillage'])->name('region.getVillage');

Route::post('image-upload', [ImageUploadController::class, 'storeImage'])->name('image.upload');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{slug}/related', [PostController::class, 'getRelatedPosts']);
Route::get('/posts/archive/{year}/{month}', [PostController::class, 'archive'])->name('posts.archive');
Route::get('/posts/category/{category}', [PostController::class, 'category'])->name('posts.category');

Route::middleware(['auth','role:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::get('categories/export/excel', [CategoryController::class, 'excelExport'])->name('categories.excelExport');
    Route::get('categories/export/pdf', [CategoryController::class, 'pdfExport'])->name('categories.pdfExport');
    Route::resource('tags', TagController::class);
    Route::resource('profile', ProfileController::class)->only(['edit', 'update']);
    Route::get('posts', [AdminPostController::class, 'index'])->name('admin.posts');
    Route::get('posts/create', [AdminPostController::class, 'create'])->name('admin.posts.create');
    Route::post('posts', [AdminPostController::class, 'store'])->name('admin.posts.store');
    Route::get('posts/{post}', [AdminPostController::class, 'show'])->name('admin.posts.show');
    Route::get('posts/{post}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
    Route::patch('posts/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
    Route::delete('posts/{post}', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy');

    Route::prefix('configuration')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('navigations', NavigationController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('roles', RoleController::class);
    });
});

Route::middleware(['auth'])->prefix('author')->group(function () {
    Route::get('dashboard', [AuthorDashboardController::class, 'index'])->name('dashboard');
    // Custom routes for author posts
    Route::get('posts', [AuthorPostController::class, 'index'])->name('author.posts');
    Route::get('posts/create', [AuthorPostController::class, 'create'])->name('author.posts.create');
    Route::post('posts', [AuthorPostController::class, 'store'])->name('author.posts.store');
    Route::get('posts/{post}', [AuthorPostController::class, 'show'])->name('author.posts.show');
    Route::get('posts/{post}/edit', [AuthorPostController::class, 'edit'])->name('author.posts.edit');
    Route::patch('posts/{post}', [AuthorPostController::class, 'update'])->name('author.posts.update');
    Route::delete('posts/{post}', [AuthorPostController::class, 'destroy'])->name('author.posts.destroy');

    Route::resource('user-profile', AuthorProfileController::class)->only(['edit', 'update', 'delete']);
});

require __DIR__ . '/auth.php';
