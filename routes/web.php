<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\CosplayController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TalentAdminController;
use App\Http\Controllers\Admin\NewsAdminController;
use App\Http\Controllers\Admin\PhotoAdminController;
use App\Http\Controllers\Admin\TagAdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ホームページ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Aboutページ
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Talentページ
Route::get('/talent', [TalentController::class, 'index'])->name('talent');
Route::post('/talent', [TalentController::class, 'show'])->name('talent.show');

// Cosplayページ
Route::get('/cosplay', [CosplayController::class, 'index'])->name('cosplay');

// Contactページ
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/contact/ok', [ContactController::class, 'ok'])->name('contact.ok');

// Newsページ
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

// 管理者ページ
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
// タレント管理
Route::get('/admin/talent', [TalentAdminController::class, 'list'])->name('admin.talent.list');
Route::get('/admin/talent/entry', [TalentAdminController::class, 'entry'])->name('admin.talent.entry');
Route::post('/admin/talent', [TalentAdminController::class, 'store'])->name('admin.talent.store');
Route::get('/admin/talent/{id}', [TalentAdminController::class, 'detail'])->name('admin.talent.detail');
Route::put('/admin/talent/{id}', [TalentAdminController::class, 'update'])->name('admin.talent.update');
Route::put('/admin/talent/{id}/retire', [TalentAdminController::class, 'retire'])->name('admin.talent.retire');

// ニュース管理
Route::get('/admin/news', [NewsAdminController::class, 'entry'])->name('admin.news.entry');
Route::post('/admin/news', [NewsAdminController::class, 'store'])->name('admin.news.store');
Route::put('/admin/news/{id}', [NewsAdminController::class, 'update'])->name('admin.news.update');
Route::delete('/admin/news/{id}', [NewsAdminController::class, 'delete'])->name('admin.news.delete');

// 写真管理
Route::get('/admin/photos', [PhotoAdminController::class, 'entry'])->name('admin.photos.entry');
Route::post('/admin/photos/upload', [PhotoAdminController::class, 'upload'])->name('admin.photos.upload');
Route::put('/admin/photos', [PhotoAdminController::class, 'update'])->name('admin.photos.update');
Route::delete('/admin/photos', [PhotoAdminController::class, 'delete'])->name('admin.photos.delete');

// タグ管理
Route::get('/admin/tag', [TagAdminController::class, 'entry'])->name('admin.tag.entry');
Route::post('/admin/tag', [TagAdminController::class, 'store'])->name('admin.tag.store');
Route::delete('/admin/tag/{id}', [TagAdminController::class, 'delete'])->name('admin.tag.delete');
