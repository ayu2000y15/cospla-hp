<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\CosplayController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsAdminController;
use App\Http\Controllers\Admin\PhotoAdminController;
use App\Http\Controllers\Admin\TagAdminController;

use App\Http\Controllers\Admin\TalentAdminController;

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
Route::get('/contact/ok', [ContactController::class, 'ok'])->name('contact.ok');

// Newsページ
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

// 管理者ページ
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
// タレント管理
Route::get('/admin/talent/list', [TalentAdminController::class, 'list'])->name('admin.talent.list');
Route::delete('/admin/talent/delete', [TalentAdminController::class, 'delete'])->name('admin.talent.delete');
Route::post('/admin/talent/store', [TalentAdminController::class, 'store'])->name('admin.talent.store');
Route::get('/admin/talent-admin', [TalentAdminController::class, 'talentAdmin'])->name('admin.talent.admin');

//タレント詳細ページ
Route::post('/admin/talent-admin/detail', [TalentAdminController::class, 'detail'])->name('admin.talent.detail');
//タレント情報変更
Route::put('/admin/talent-admin/edit', [TalentAdminController::class, 'edit'])->name('admin.talent.edit');
//タレント写真
Route::post('/admin/talent-admin/photos/upload', [TalentAdminController::class, 'uploadPhotos'])->name('admin.talent.photos.upload');
Route::put('/admin/talent-admin/photos/update', [TalentAdminController::class, 'updatePhoto'])->name('admin.talent.photos.update');
Route::delete('/admin/talent-admin/photos/delete', [TalentAdminController::class, 'deletePhoto'])->name('admin.talent.photos.delete');
//タレント経歴
Route::post('/admin/talent-admin/career/store', [TalentAdminController::class, 'storeCareer'])->name('admin.talent.career.store');
Route::post('/admin/talent-admin/career/update', [TalentAdminController::class, 'updateCareer'])->name('admin.talent.career.update');
Route::delete('/admin/talent-admin/career/delete', [TalentAdminController::class, 'deleteCareer'])->name('admin.talent.career.delete');

//タレントタグ
Route::delete('/admin/talent-admin/tag/delete', [TalentAdminController::class, 'deleteTag'])->name('admin.talent.tag.delete');
Route::post('/admin/talent-admin/tag/add', [TalentAdminController::class, 'addTag'])->name('admin.talent.tag.add');
//タレント退職
Route::put('/admin/talent-admin/retire', [TalentAdminController::class, 'retire'])->name('admin.talent.retire');


// タグ作成（全体で使用）
Route::post('/admin/tag', [TalentController::class, 'storeTag'])->name('admin.tag.store');

// ニュース管理
Route::get('/admin/news', [NewsAdminController::class, 'entry'])->name('admin.news.entry');
Route::post('/admin/news', [NewsAdminController::class, 'store'])->name('admin.news.store');
Route::post('/admin/news/{id}', [NewsAdminController::class, 'update'])->name('admin.news.update');
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

