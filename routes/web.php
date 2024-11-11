<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\ReportController;
use Inertia\Inertia;

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
})->name('dashboard');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


Route::get('/medication', [MedicationController::class, 'index'])
    ->name('medication.Medication');

Route::get('/report', [ReportController::class, 'index'])
    ->name('report.Report');


require __DIR__ . '/auth.php';



