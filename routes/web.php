<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/* ─── Public Routes ─── */
Route::get('/',          [HomeController::class, 'index'])->name('home');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/about',     [HomeController::class, 'about'])->name('about');
Route::get('/services',  [HomeController::class, 'services'])->name('services');
Route::post('/contact',  [ContactController::class, 'send'])->name('contact.send');
Route::get('/blog',           [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}',    [BlogController::class, 'show'])->name('blog.show');

/* ─── Admin Auth ─── */
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login',  [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [Admin\AuthController::class, 'login'])->name('login.post');
    Route::post('logout',[Admin\AuthController::class, 'logout'])->name('logout');

    /* ─── Protected Admin Routes ─── */
    Route::middleware('admin.auth')->group(function () {

        Route::get('dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Hero Slides
        Route::resource('hero', Admin\HeroSlideController::class)->except(['show']);
        Route::post('hero/reorder', [Admin\HeroSlideController::class, 'reorder'])->name('hero.reorder');

        // About + Stats
        Route::get('about',               [Admin\AboutController::class, 'index'])->name('about.index');
        Route::put('about',               [Admin\AboutController::class, 'update'])->name('about.update');
        Route::post('about/stats',        [Admin\AboutController::class, 'storeStat'])->name('about.stats.store');
        Route::put('about/stats/{stat}',  [Admin\AboutController::class, 'updateStat'])->name('about.stats.update');
        Route::delete('about/stats/{stat}',[Admin\AboutController::class, 'destroyStat'])->name('about.stats.destroy');

        // Services
        Route::resource('services', Admin\ServicesController::class)->except(['show']);

        // Testimonials
        Route::resource('testimonials', Admin\TestimonialsController::class)->except(['show']);

        // Portfolio
        Route::post('portfolio/bulk-delete',         [Admin\PortfolioController::class, 'bulkDestroy'])->name('portfolio.bulk-destroy');
        Route::post('portfolio/{portfolio}/toggle',  [Admin\PortfolioController::class, 'toggleActive'])->name('portfolio.toggle');
        Route::resource('portfolio', Admin\PortfolioController::class)->except(['show']);

        // Clients
        Route::post('clients/{client}/toggle', [Admin\ClientController::class, 'toggleActive'])->name('clients.toggle');
        Route::resource('clients', Admin\ClientController::class)->except(['show']);

        // Blog
        Route::post('blog/{blog}/toggle', [Admin\BlogController::class, 'togglePublish'])->name('blog.toggle');
        Route::resource('blog', Admin\BlogController::class)->except(['show']);

        // Enquiries
        Route::resource('enquiries', Admin\EnquiriesController::class)->only(['index','show','destroy']);
        Route::patch('enquiries/{enquiry}/status', [Admin\EnquiriesController::class, 'updateStatus'])->name('enquiries.status');

        // Settings (fonts)
        Route::get('settings',  [Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings',  [Admin\SettingsController::class, 'update'])->name('settings.update');

        // Page Content
        Route::get('page-content',  [Admin\PageContentController::class, 'index'])->name('page-content.index');
        Route::put('page-content',  [Admin\PageContentController::class, 'update'])->name('page-content.update');
        Route::post('page-content/steps',              [Admin\PageContentController::class, 'storeStep'])->name('page-content.steps.store');
        Route::put('page-content/steps/{step}',        [Admin\PageContentController::class, 'updateStep'])->name('page-content.steps.update');
        Route::delete('page-content/steps/{step}',     [Admin\PageContentController::class, 'destroyStep'])->name('page-content.steps.destroy');

        // Footer & Social Links
        Route::get('footer',  [Admin\FooterController::class, 'index'])->name('footer.index');
        Route::put('footer',  [Admin\FooterController::class, 'update'])->name('footer.update');
        Route::post('footer/social-links',              [Admin\FooterController::class, 'storeSocialLink'])->name('footer.social.store');
        Route::put('footer/social-links/{link}',        [Admin\FooterController::class, 'updateSocialLink'])->name('footer.social.update');
        Route::delete('footer/social-links/{link}',     [Admin\FooterController::class, 'destroySocialLink'])->name('footer.social.destroy');
    });
});
