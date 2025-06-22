<?php

use App\Http\Controllers\Admin\AdminLogsController;
use App\Http\Controllers\Admin\AdminRequestsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/set-locale/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ru', 'zh'])) {
        abort(400); // запрещаем неизвестные языки
    }

    session(['locale' => $locale]);

    return redirect()->back(); // возвращаем на ту же страницу
})->name('set.locale');

Route::get('/clear-locale', function () {
    session()->forget('locale');
    return redirect()->back();
})->name('clear.locale');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('admin.dashboard');

    Route::get('/logs', [AdminLogsController::class, 'index'])->name('admin.logs.index');

    Route::get('/requests', [AdminRequestsController::class, 'index'])->name('admin.requests.index');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');


})->middleware(['auth', 'verified']);
Route::get('/upload-env-to-s3', function () {
    $url = Storage::disk('s3')->temporaryUrl(
        'backups/.env',
        now()->addMinutes(10) // Срок действия ссылки
    );

    return $url;
});


require __DIR__.'/auth.php';
