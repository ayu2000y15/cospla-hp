<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\WorksController;
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

use App\Http\Controllers\Admin\WorksAdminController;
use App\Http\Controllers\TagSearchController;
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

// Worksページ
Route::get('/works', [WorksController::class, 'index'])->name('works');

// Contactページ
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
// Contact 確認ページ
Route::post('/contact/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
// Contact 送信完了ページ
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Newsページ
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

// プライバシーポリシー
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');

// 検索ページ
Route::get('/tags/{tagName}', [TagSearchController::class, 'search'])->name('tags.search');

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

Route::post('/admin/talent/reorder', [TalentAdminController::class, 'reorder'])->name('admin.talent.reorder');

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
Route::post('/admin/talent-admin/career/reorder', [TalentAdminController::class, 'reorderCareers'])->name('admin.talent.career.reorder');
Route::post('/admin/talent-admin/career/store-multiple', [TalentAdminController::class, 'storeMultipleCareers'])->name('admin.talent.career.store-multiple');

//タレントタグ
Route::post('/admin/talent-admin/tags/update', [TalentAdminController::class, 'updateTalentTags'])->name('admin.talent.tags.update');

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
Route::get('/admin/news/images/{id}', [NewsAdminController::class, 'getImages'])->name('admin.news.images');
Route::delete('/admin/news/delete-image/{id}', [NewsAdminController::class, 'deleteImage'])->name('admin.news.deleteImage');

// Route::post('/admin/news/priority', [NewsAdminController::class, 'priority'])->name('admin.news.priority');
Route::get('/admin/news/images/{id}', 'App\Http\Controllers\Admin\NewsAdminController@getImages')->name('admin.news.images');
Route::delete('/admin/news/delete-image/{id}', 'App\Http\Controllers\Admin\NewsAdminController@deleteImage')->name('admin.news.deleteImage');
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
Route::post('/admin/tags/{tag}/update-color', [TagAdminController::class, 'updateColor'])->name('admin.tags.updateColor');

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

// Worksページ管理
Route::prefix('admin/works')->name('admin.works.')->group(function () {
    Route::get('/', [WorksAdminController::class, 'index'])->name('index');
    Route::post('/client', [WorksAdminController::class, 'storeClient'])->name('client.store');
    Route::put('/client/{client}', [WorksAdminController::class, 'updateClient'])->name('client.update'); // 更新
    Route::delete('/client/{client}', [WorksAdminController::class, 'destroyClient'])->name('client.destroy'); // 削除
    Route::post('/images', [WorksAdminController::class, 'uploadImages'])->name('images.upload');
    Route::delete('/image/{image}', [WorksAdminController::class, 'destroyImage'])->name('image.destroy'); // 画像削除
    Route::post('/client/reorder', [WorksAdminController::class, 'reorderClients'])->name('client.reorder');
    Route::put('/image/{image}', [WorksAdminController::class, 'updateImage'])->name('image.update');
    Route::put('/client/{client}/toggle', [WorksAdminController::class, 'toggleVisibility'])->name('client.toggle');
});
