<?php

use App\Models\User;
use App\Models\Posts;
use App\Models\Groups;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\GroupsController;

Route::get('/', function () {
 return view('welcome');
});

Auth::routes([
    'register' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function(){
    Route::get('/', [Dashboard::class, 'index'])->name('index');
    Route::prefix('posts')->name('posts.')->middleware('can:posts')->group(function(){
        Route::get('/', [PostsController::class, 'index'])->name('index');
        Route::get('/add', [PostsController::class, 'add'])->name('add')->can('create', Posts::class);
        Route::post('/add', [PostsController::class, 'postAdd'])->can('create', Posts::class);
        Route::get('/edit/{post}', [PostsController::class, 'edit'])->name('edit')->can('posts.edit');
        Route::post('/edit/{post}', [PostsController::class, 'postEdit'])->can('posts.edit');
        Route::get('/delete/{post}', [PostsController::class, 'delete'])->name('delete')->can('posts.delete');
    });
    Route::prefix('groups')->name('groups.')->middleware('can:groups')->group(function(){
        Route::get('/', [GroupsController::class, 'index'])->name('index');
        Route::get('/add', [GroupsController::class, 'add'])->name('add')->can('create', Groups::class);
        Route::post('/add', [GroupsController::class, 'postAdd'])->can('create', Groups::class);
        Route::get('/edit/{group}', [GroupsController::class, 'edit'])->name('edit')->can('groups.edit');
        Route::post('/edit/{group}', [GroupsController::class, 'postEdit'])->can('groups.edit');
        Route::get('/delete/{group}', [GroupsController::class, 'delete'])->name('delete')->can('groups.delete');
        Route::get('/permission/{group}', [GroupsController::class, 'permission'])->name('permission')->can('groups.permission');
        Route::post('/permission/{group}', [GroupsController::class, 'postPermission'])->can('groups.permission');
    });

    Route::prefix('users')->name('users.')->middleware('can:users')->group(function(){
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('/add', [UsersController::class, 'add'])->name('add')->can('create', User::class);
        Route::post('/add', [UsersController::class, 'postAdd'])->can('create', User::class);
        Route::get('/edit/{user}', [UsersController::class, 'edit'])->name('edit')->can('users.edit');
        Route::post('/edit/{user}', [UsersController::class, 'postEdit'])->can('users.edit');
        Route::get('/delete/{user}', [UsersController::class, 'delete'])->name('delete')->can('users.delete');
    });
});