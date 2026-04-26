<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TestTypeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TestCategoryController;
use App\Http\Controllers\TestParameterController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes (Dashboard for all authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Core Clinical Operations (Accessible by Admin and Staff)
    Route::middleware(['role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('bookings', BookingController::class);
        Route::resource('patients', PatientController::class);
        Route::resource('doctors', \App\Http\Controllers\DoctorController::class);
        Route::get('patients/{id}/invoice', [PatientController::class, 'printInvoice'])->name('patients.invoice');
        Route::get('patients/dashboard', [PatientController::class, 'dashboard'])->name('patients.dashboard');
        
        // Test Management
        Route::get('test-types/template', [TestTypeController::class, 'downloadTemplate'])->name('test-types.template');
        Route::post('test-types/import', [TestTypeController::class, 'import'])->name('test-types.import');
        Route::resource('test-types', TestTypeController::class);
        Route::resource('test-categories', TestCategoryController::class);
        Route::resource('test-parameters', TestParameterController::class);
        
        // Reports Management
        Route::get('test-reports', [ReportController::class, 'index'])->name('test-reports');
        Route::post('test-reports/import', [ReportController::class, 'importResults'])->name('reports.import');
        Route::post('reports/{report}/add-parameter', [ReportController::class, 'addParameter'])->name('reports.add-parameter');
        Route::delete('reports/delete-parameter/{id}', [ReportController::class, 'deleteParameter'])->name('reports.delete-parameter');
        Route::get('reports/dispatch', [ReportController::class, 'dispatch'])->name('reports.dispatch');
        Route::get('reports/{report}/print', [ReportController::class, 'print'])->name('reports.print');
        Route::resource('reports', ReportController::class)->except(['index']);
        
        // Operational Tasks
        Route::get('tasks/recent', [\App\Http\Controllers\TaskController::class, 'recent'])->name('tasks.recent');
        Route::resource('tasks', \App\Http\Controllers\TaskController::class);

        // Payments (Operational)
        Route::resource('payments', PaymentController::class);

        // Analysis, Infrastructure & Settings (Access controlled by permissions)
        Route::get('analysis', [AnalysisController::class, 'index'])->name('analysis.index');
        Route::get('analysis/sales-slip/{booking}', [AnalysisController::class, 'salesSlip'])->name('analysis.sales-slip');
        Route::resource('labs', LabController::class);
        Route::resource('equipment', EquipmentController::class);
        Route::get('terminal', [\App\Http\Controllers\TerminalController::class, 'index'])->name('terminal');
        Route::post('terminal/store', [\App\Http\Controllers\TerminalController::class, 'store'])->name('terminal.store');
        Route::get('/settings', function() { return view('settings.index'); })->name('settings');
        Route::post('/settings/identity', [\App\Http\Controllers\SettingController::class, 'updateIdentity'])->name('settings.identity');
        Route::post('/settings/security', [\App\Http\Controllers\SettingController::class, 'updateSecurity'])->name('settings.security');
        Route::get('/support', [\App\Http\Controllers\SupportController::class, 'index'])->name('support.index');
        Route::post('/support/ticket', [\App\Http\Controllers\SupportController::class, 'submitTicket'])->name('support.submit');

        // Analysis & Reporting (Restricted to Admin for financial audit?)
        Route::middleware(['role:admin'])->group(function () {
            // Management
            Route::resource('users', UserController::class);

            // Backup & Restore System
            Route::prefix('backup')->name('backup.')->group(function () {
                Route::get('/', [\App\Http\Controllers\BackupController::class, 'index'])->name('index');
                Route::post('/create', [\App\Http\Controllers\BackupController::class, 'backup'])->name('create');
                Route::post('/restore', [\App\Http\Controllers\BackupController::class, 'restore'])->name('restore');
                Route::post('/import', [\App\Http\Controllers\BackupController::class, 'import'])->name('import');
                Route::get('/download/{filename}', [\App\Http\Controllers\BackupController::class, 'download'])->name('download');
                Route::delete('/delete/{filename}', [\App\Http\Controllers\BackupController::class, 'delete'])->name('delete');
                Route::get('/stats', [\App\Http\Controllers\BackupController::class, 'stats'])->name('stats');
                Route::get('/export-csv', [\App\Http\Controllers\BackupController::class, 'exportCsv'])->name('export-csv');
            });
        });
    });

    // Aliases
    Route::get('/tests-management', function() {
        return redirect()->route('admin.test-types.index');
    })->name('tests.management');

    Route::view('/coming-soon', 'coming-soon')->name('coming-soon');
});

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});
