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
use App\Http\Controllers\Admin\CompanyAdminController;
use App\Http\Controllers\Admin\CareerAdminController;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\Admin\TalentAdminController;
use App\Http\Controllers\Admin\AcmailAdminController;
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
// Contact 確認ページ
Route::post('/contact/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
// Contact 送信完了ページ
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Newsページ
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

// プライバシーポリシー
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');

// 管理者ページログイン
Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login/access', [AdminController::class, 'loginAccess'])->name('login.access');
// 管理者ページログアウト
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

// 管理者ページ
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/admin/guest', [AdminController::class, 'indexGuest'])->name('admin.guest');
//acメーラー管理画面ログイン
Route::get('/admin/acmail', [AdminController::class, 'indexAcMail'])->name('admin.acmail');

// タレント管理
Route::get('/admin/talent/list', [TalentAdminController::class, 'list'])->name('admin.talent.list');
Route::delete('/admin/talent/delete', [TalentAdminController::class, 'delete'])->name('admin.talent.delete');
Route::post('/admin/talent/store', [TalentAdminController::class, 'store'])->name('admin.talent.store');
Route::put('/admin/bulkUpdate', [TalentAdminController::class, 'bulkUpdateTalent'])->name('admin.talent.bulkUpdate');
Route::get('/admin/talent-admin', [TalentAdminController::class, 'talentAdmin'])->name('admin.talent.admin');

//タレント詳細ページ
Route::post('/admin/talent-admin/detail', [TalentAdminController::class, 'detail'])->name('admin.talent.detail');
//タレント情報変更
Route::put('/admin/talent-admin/edit', [TalentAdminController::class, 'edit'])->name('admin.talent.edit');
//タレント写真
Route::post('/admin/talent-admin/photos/upload', [TalentAdminController::class, 'uploadPhotos'])->name('admin.talent.photos.upload');
Route::put('/admin/talent-admin/photos/update', [TalentAdminController::class, 'updatePhoto'])->name('admin.talent.photos.update');
Route::delete('/admin/talent-admin/photos/delete', [TalentAdminController::class, 'deletePhoto'])->name('admin.talent.photos.delete');
Route::put('/admin/talent-admin/photos/bulkUpdate', [TalentAdminController::class, 'bulkUpdatePhoto'])->name('admin.talent.photos.bulkUpdate');

//タレント経歴
Route::post('/admin/talent-admin/career/entry', [TalentAdminController::class, 'entryCareer'])->name('admin.talent.career.entry');
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

//経歴カテゴリ管理
Route::post('/admin/career/entry', [CareerAdminController::class, 'entry'])->name('admin.career.entry');
Route::put('/admin/career/update', [CareerAdminController::class, 'update'])->name('admin.career.update');
Route::delete('/admin/career/delete', [CareerAdminController::class, 'delete'])->name('admin.career.delete');

//問い合わせカテゴリ管理
Route::post('/admin/contact/entry', [ContactAdminController::class, 'entry'])->name('admin.contact.entry');
Route::put('/admin/contact/update', [ContactAdminController::class, 'update'])->name('admin.contact.update');
Route::delete('/admin/contact/delete', [ContactAdminController::class, 'delete'])->name('admin.contact.delete');

// ニュース管理
Route::get('/admin/news', [NewsAdminController::class, 'entry'])->name('admin.news.entry');
Route::post('/admin/news', [NewsAdminController::class, 'store'])->name('admin.news.store');
Route::post('/admin/news/{id}', [NewsAdminController::class, 'update'])->name('admin.news.update');
Route::delete('/admin/news/{id}', [NewsAdminController::class, 'delete'])->name('admin.news.delete');

// 写真管理
Route::post('/admin/photos/entry', [PhotoAdminController::class, 'entry'])->name('admin.photos.entry');
Route::post('/admin/photos/upload', [PhotoAdminController::class, 'upload'])->name('admin.photos.upload');
Route::put('/admin/photos', [PhotoAdminController::class, 'update'])->name('admin.photos.update');
Route::delete('/admin/photos', [PhotoAdminController::class, 'delete'])->name('admin.photos.delete');
Route::put('/admin/photos/bulkUpdate', [PhotoAdminController::class, 'bulkUpdate'])->name('admin.photos.bulkUpdate');

// タグ管理
Route::get('/admin/tag', [TagAdminController::class, 'entry'])->name('admin.tag.entry');
Route::post('/admin/tag', [TagAdminController::class, 'store'])->name('admin.tag.store');
Route::delete('/admin/tag/{id}', [TagAdminController::class, 'delete'])->name('admin.tag.delete');

//会社情報・問い合わせメール管理
Route::post('/admin/company/mail', [CompanyAdminController::class, 'mail'])->name('admin.company.mail');
Route::post('/admin/company/update', [CompanyAdminController::class, 'update'])->name('admin.company.update');

//ACメーラーリスト登録
Route::post('/admin/ac/entry', [AcmailAdminController::class, 'entry'])->name('admin.ac.entry');
Route::put('/admin/ac/csvout', [AcmailAdminController::class, 'csvOutput'])->name('admin.ac.csvout');
Route::post('/admin/ac/edit', [AcmailAdminController::class, 'edit'])->name('admin.ac.edit');
Route::put('/admin/ac/update', [AcmailAdminController::class, 'update'])->name('admin.ac.update');
Route::get('/admin/ac/editEntry', [AdminController::class, 'editEntry'])->name('admin.ac.editEntry');
Route::post('/admin/ac/delete', [AcmailAdminController::class, 'delete'])->name('admin.ac.delete');
