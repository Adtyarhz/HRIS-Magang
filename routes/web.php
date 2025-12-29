<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FamilyDependentController;
use App\Http\Controllers\HealthRecordController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkExperienceController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\EducationHistoryController;
use App\Http\Controllers\TrainingHistoryController;
use App\Http\Controllers\EmployeeEditRequestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DivisionController;

// === LOGIN & LOGOUT ROUTES ===
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/employee/{id}/edit-login', [LoginController::class, 'editLogin'])->name('employees.data.edit_login');
Route::post('/employee/{id}/update-login', [LoginController::class, 'updateLogin'])->name('employees.data.update_login');

// === PROTECTED ROUTES ===
Route::middleware('auth')->group(function () {
    Route::post('/employees/{id}/reset-password', [LoginController::class, 'resetPassword'])->name('employees.reset_password');

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Dashboard - Semua role bisa akses
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // === SUPERADMIN ONLY ROUTES ===
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class . ':superadmin,hc')->group(function () {
        // Employee CRUD - Hanya superadmin
        Route::resource('employees', EmployeeController::class);
        Route::put('/employees/{employee}/deactivate', [EmployeeController::class, 'deactivate'])->name('employees.deactivate');
        Route::get('/employees/{employee}/deactivate-form', [EmployeeController::class, 'showDeactivateForm'])->name('employees.deactivate.form');

        Route::prefix('organization/division')->name('organization.division.')->group(function () {
            Route::get('/create', [DivisionController::class, 'create'])->name('create');
            Route::post('/', [DivisionController::class, 'store'])->name('store');
            Route::get('/{division}/edit', [DivisionController::class, 'edit'])->name('edit');
            Route::put('/{division}', [DivisionController::class, 'update'])->name('update');
            Route::delete('/{division}', [DivisionController::class, 'destroy'])->name('destroy');
        });
    });

    // === Route khusus untuk user biasa mengedit data mereka sendiri ===
    Route::middleware('auth')->group(function () {
        Route::get('employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    });

    // === SUPERADMIN, DIREKSI, MANAGER, SECTION_HEAD ROUTES ===
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class . ':superadmin,direksi,hc')->group(function () {
        Route::get('/career-path', [EmployeeController::class, 'indexCareer'])->name('career.index');
        Route::get('/career-path/{employee}', [EmployeeController::class, 'showCareer'])->name('career.show');
    });

    // === ALL AUTHENTICATED USERS ROUTES ===
    // Employee view - Semua user bisa lihat data employee mereka sendiri
    Route::get('employees/{employee}/career', [EmployeeController::class, 'showCareer'])->name('employees.showCareer');
    Route::get('employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');

    // Employee Management - Semua role bisa akses sesuai dengan menu
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class . ':superadmin,hc,direksi,manager,section_head,staff_bisnis,staff_support')->group(function () {
        // Employee tab: address
        Route::get('employees/{employee}/address', [EmployeeController::class, 'editAddress'])->name('employees.address.edit');

        // Employee tab: health
        Route::get('/employees/{employee}/health', [HealthRecordController::class, 'edit'])->name('employees.health.edit');

        // Health Record
        Route::prefix('employees/{employee}/health-record')->name('health-records.')->group(function () {
            Route::get('/', [HealthRecordController::class, 'edit'])->name('edit');
            Route::post('/', [HealthRecordController::class, 'storeOrUpdate'])->name('storeOrUpdate');
            Route::delete('/', [HealthRecordController::class, 'destroy'])->name('destroy');
        });

        // Work Experience
        Route::prefix('employees/{employee}/work-experience')->name('employees.work-experience.')->group(function () {
            Route::get('/', [WorkExperienceController::class, 'index'])->name('index');
            Route::get('/create', [WorkExperienceController::class, 'create'])->name('create');
            Route::post('/', [WorkExperienceController::class, 'store'])->name('store');
            Route::get('/{workExperience}/edit', [WorkExperienceController::class, 'edit'])->name('edit');
            Route::put('/{workExperience}', [WorkExperienceController::class, 'update'])->name('update');
            Route::delete('/{workExperience}', [WorkExperienceController::class, 'destroy'])->name('destroy');
        });

        // Certifications
        Route::prefix('employees/{employee}/certifications')->name('employees.certifications.')->group(function () {
            Route::get('/', [CertificationController::class, 'index'])->name('index');
            Route::get('/create', [CertificationController::class, 'create'])->name('create');
            Route::post('/', [CertificationController::class, 'store'])->name('store');
            Route::get('/{certification}/edit', [CertificationController::class, 'edit'])->name('edit');
            Route::put('/{certification}', [CertificationController::class, 'update'])->name('update');
            Route::delete('/{certification}', [CertificationController::class, 'destroy'])->name('destroy');
            Route::delete('/{certification}/materials/{material}', [CertificationController::class, 'destroyMaterial'])->name('materials.destroy');
        });

        // Insurance
        Route::prefix('employees/{employee}/insurance')->name('employees.insurance.')->group(function () {
            Route::get('/', [InsuranceController::class, 'index'])->name('index');
            Route::get('/create', [InsuranceController::class, 'create'])->name('create');
            Route::post('/', [InsuranceController::class, 'store'])->name('store');
            Route::get('/{insurance}/edit', [InsuranceController::class, 'edit'])->name('edit');
            Route::put('/{insurance}', [InsuranceController::class, 'update'])->name('update');
            Route::delete('/{insurance}', [InsuranceController::class, 'destroy'])->name('destroy');
        });

        // Education History
        Route::prefix('employees/{employee}/educationhistory')->name('employees.educationhistory.')->group(function () {
            Route::get('/', [EducationHistoryController::class, 'index'])->name('index');
            Route::get('/create', [EducationHistoryController::class, 'create'])->name('create');
            Route::post('/', [EducationHistoryController::class, 'store'])->name('store');
            Route::get('/{educationHistory}/edit', [EducationHistoryController::class, 'edit'])->name('edit');
            Route::put('/{educationHistory}', [EducationHistoryController::class, 'update'])->name('update');
            Route::delete('/{educationHistory}', [EducationHistoryController::class, 'destroy'])->name('destroy');
        });

        // Training History
        Route::prefix('employees/{employee}/training-histories')->name('employees.training-histories.')->group(function () {
            Route::get('/', [TrainingHistoryController::class, 'index'])->name('index');
            Route::get('/create', [TrainingHistoryController::class, 'create'])->name('create');
            Route::post('/', [TrainingHistoryController::class, 'store'])->name('store');
            Route::get('/{trainingHistory}/edit', [TrainingHistoryController::class, 'edit'])->name('edit');
            Route::put('/{trainingHistory}', [TrainingHistoryController::class, 'update'])->name('update');
            Route::delete('/{trainingHistory}', [TrainingHistoryController::class, 'destroy'])->name('destroy');
            Route::delete('/{trainingHistory}/materials/{material}', [TrainingHistoryController::class, 'destroyMaterial'])->name('materials.destroy');
        });

        // Family Dependents
        Route::resource('employees.family-dependents', FamilyDependentController::class)->scoped();
    });

    // === EMPLOYEE EDIT REQUEST - Only HC & SUPERADMIN ===
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class . ':superadmin,hc')->group(function () {
        Route::prefix('employee-edit-requests')->name('employee-edit-requests.')->group(function () {
            Route::get('/', [EmployeeEditRequestController::class, 'index'])->name('index');
            Route::get('/{id}', [EmployeeEditRequestController::class, 'show'])->name('show');
            Route::post('/{id}/approve', [EmployeeEditRequestController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [EmployeeEditRequestController::class, 'reject'])->name('reject');
        });
    });
    // === REQUEST EDIT DATA PRIBADI - Untuk semua karyawan ===
    Route::middleware('auth')->group(function () {
        Route::post('/employee-edit-requests', [EmployeeEditRequestController::class, 'store'])->name('employee-edit-requests.store');
    });

    // === NOTIFICATIONS ===    
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::get('/notifications/redirect/{id}', [NotificationController::class, 'redirect'])
        ->name('notifications.redirect');

    Route::get('/notifications/read/{id}', [NotificationController::class, 'readAndRedirect'])
        ->name('notifications.readAndRedirect');
});
