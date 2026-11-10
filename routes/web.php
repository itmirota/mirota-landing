<?php

use App\Http\Controllers\ProductController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MaklonController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SitemapController;


Route::get('/', function () {
    $locale = request()->getPreferredLanguage(['id', 'en']);
    return redirect("/{$locale}");
});

Route::get('sitemap.xml', SitemapController::class);

Route::prefix('{locale}')
    ->where(['locale' => 'id|en'])
    ->middleware(SetLocale::class)
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');

        Route::get('produk', [ProductController::class, 'index'])->name('produk.index');
        Route::get('produk/{slug}', [ProductController::class, 'show'])->name('produk.show');
        Route::get('tentang-kami', fn () => redirect()->route('about.history'))->name('about.index');
        Route::view('tentang-kami/sejarah', 'about.history')->name('about.history');
        Route::view('tentang-kami/visi-misi-budaya', 'about.vision')->name('about.vision');
        Route::view('tentang-kami/kebijakan-mutu', 'about.quality')->name('about.quality');
        Route::view('tentang-kami/penghargaan', 'about.awards')->name('about.awards');
        Route::get('kontak', [ContactController::class, 'show'])->name('contact');
        Route::post('kontak', [ContactController::class, 'send'])->middleware('throttle:5,1')->name('contact.send');
        Route::view('kebijakan-privasi', 'privacy')->name('privacy');
        Route::get('maklon', [MaklonController::class, 'index'])->name('maklon');
        Route::get('artikel', [ArticleController::class, 'index'])->name('article.index');
        Route::get('artikel/{slug}', [ArticleController::class, 'show'])->name('article.show');
        Route::get('kunjungan-industri', [VisitController::class, 'index'])->name('visit');
        Route::post('kunjungan-industri', [VisitController::class, 'store'])->middleware('throttle:5,1')->name('visit.store');
        Route::get('karir', fn () => redirect()->route('career.jobs'))->name('career.index');
        Route::view('karir/benefit', 'career.benefit')->name('career.benefit');
        Route::get('karir/tim', [CareerController::class, 'team'])->name('career.team');
        Route::get('karir/lowongan', [CareerController::class, 'jobs'])->name('career.jobs');
        Route::get('karir/lowongan/{slug}', [CareerController::class, 'show'])->name('career.job');
        Route::post('karir/lowongan/{slug}/lamar', [CareerController::class, 'apply'])->middleware('throttle:5,1')->name('career.apply');

    });