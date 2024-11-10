<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\CosplayController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsController;

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
Route::get('/talent/{id}', [TalentController::class, 'show'])->name('talent.show');

// Cosplayページ
Route::get('/cosplay', [CosplayController::class, 'index'])->name('cosplay');

// Contactページ
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/contact/ok', [ContactController::class, 'ok'])->name('contact.ok');

// Newsページ（まだコントローラーを作成していない場合は、後で追加してください）
//Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

// 管理者ページ（まだ実装していない場合は、後で追加してください）
Route::get('/admin', function () {
    return redirect('/admin/dashboard');
})->name('admin.dashboard');