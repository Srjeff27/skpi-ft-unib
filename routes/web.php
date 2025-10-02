<?php

use Illuminate\Support\Facades\Route;

// General & Public Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Public\VerificationController;

// Student Controllers
use App\Http\Controllers\Student\PortfolioController as StudentPortfolioController;
use App\Http\Controllers\Student\SkpiController as StudentSkpiController;
use App\Http\Controllers\Student\NotificationController as StudentNotificationController;

// Verifikator Controllers
use App\Http\Controllers\Verifikator\DashboardController as VerifikatorDashboardController;
use App\Http\Controllers\Verifikator\PortfolioReviewController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\VerifikatorController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\PortfolioCategoryController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\PagesController as AdminPagesController;
use App\Http\Controllers\Admin\CplController;
use App\Http\Controllers\Admin\CetakSkpiController;
use App\Http\Controllers\Admin\PejabatController;
use App\Http\Controllers\Admin\SystemSettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Public SKPI Verification (Signed URL)
Route::get('/verifikasi/skpi/{user}', [VerificationController::class, 'skpi'])
    ->middleware('signed')
    ->name('skpi.verify');


// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Universal Dashboard - Logic handled by DashboardController
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Backward-compat: alias tanpa prefix untuk link lama
    Route::middleware('role:mahasiswa')->group(function () {
        Route::get('/portofolio', function () {
            return redirect()->route('student.portfolios.index');
        });
        Route::get('/dokumen-skpi', function () {
            return redirect()->route('student.documents.index');
        });
    });
});

// Student Specific Routes (tidak perlu email verified)
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('student.')->group(function () {
    // Portfolio (parameter disamakan agar binding konsisten)
    Route::resource('portofolio', StudentPortfolioController::class)
        ->parameters(['portofolio' => 'portfolio'])
        ->names('portfolios')
        ->only(['index','create','store','edit','update','destroy']);

    // SKPI
    Route::get('/skpi/unduh', [StudentSkpiController::class, 'download'])->name('skpi.download');
    Route::post('/skpi/ajukan', [StudentSkpiController::class, 'apply'])->name('skpi.apply');

    // Notifications
    Route::get('/notifikasi', [StudentNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifikasi/{notification}/read', [StudentNotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifikasi/{notification}/unread', [StudentNotificationController::class, 'markUnread'])->name('notifications.unread');
    Route::post('/notifikasi/read-all', [StudentNotificationController::class, 'markAllRead'])->name('notifications.read_all');
    Route::post('/notifikasi/delete-all', [StudentNotificationController::class, 'deleteAll'])->name('notifications.delete_all');

    // Dokumen SKPI (placeholder)
    Route::get('/dokumen-skpi', function () {
        return view('student.dokumen.index');
    })->name('documents.index');
});

// Verifikator & Admin Shared Routes (Portfolio Review)
Route::middleware(['auth', 'role:verifikator,admin'])->prefix('verifikasi')->name('verifikator.')->group(function () {
    Route::get('/dashboard', [VerifikatorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/portofolio', [PortfolioReviewController::class, 'index'])->name('portfolios.index');
    Route::get('/portofolio/{portfolio}', [PortfolioReviewController::class, 'show'])->name('portfolios.show');
    Route::post('/portofolio/{portfolio}/approve', [PortfolioReviewController::class, 'approve'])->name('portfolios.approve');
    Route::post('/portofolio/{portfolio}/reject', [PortfolioReviewController::class, 'reject'])->name('portfolios.reject');
    Route::post('/portofolio/{portfolio}/request-edit', [PortfolioReviewController::class, 'requestEdit'])->name('portfolios.request_edit');
    // Data Mahasiswa (khusus verifikator melihat mahasiswa di prodi-nya)
    Route::get('/mahasiswa', [\App\Http\Controllers\Verifikator\StudentController::class, 'index'])->name('students.index');
});

// Admin Only Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset_password');
    Route::resource('students', StudentController::class);
    Route::resource('verifikators', VerifikatorController::class);
    Route::resource('prodis', ProdiController::class);
    Route::resource('portfolio-categories', PortfolioCategoryController::class);
    Route::resource('announcements', AnnouncementController::class)->only(['index', 'create', 'store', 'destroy']);
    // Academic Management
    Route::get('cpl', [CplController::class, 'index'])->name('cpl.index');
    Route::get('cpl/kelola/{curriculum}', [CplController::class, 'manage'])->name('cpl.manage');
    Route::post('cpl/curricula', [CplController::class, 'storeCurriculum'])->name('cpl.curricula.store');
    Route::delete('cpl/curricula/{curriculum}', [CplController::class, 'destroyCurriculum'])->name('cpl.curricula.destroy');
    Route::get('cpl/curricula/{curriculum}/edit', [CplController::class, 'editCurriculum'])->name('cpl.curricula.edit');
    Route::put('cpl/curricula/{curriculum}', [CplController::class, 'updateCurriculum'])->name('cpl.curricula.update');
    Route::post('cpl/{curriculum}/items', [CplController::class, 'storeItem'])->name('cpl.items.store');
    Route::delete('cpl/items/{item}', [CplController::class, 'destroyItem'])->name('cpl.items.destroy');
    Route::get('cpl/items/{item}/edit', [CplController::class, 'editItem'])->name('cpl.items.edit');
    Route::put('cpl/items/{item}', [CplController::class, 'updateItem'])->name('cpl.items.update');

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export-csv', [ReportController::class, 'exportCsv'])->name('reports.export_csv');
    Route::get('reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export_pdf');

    // Import
    Route::get('import', [ImportController::class, 'index'])->name('import.index');
    Route::post('import/users', [ImportController::class, 'importUsers'])->name('import.users');

    // Activity Logs
    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');

    // Additional Admin Pages
    Route::get('finalisasi', [AdminPagesController::class, 'finalisasi'])->name('finalisasi.index');
    Route::post('finalisasi/set-official', [AdminPagesController::class, 'setOfficial'])->name('finalisasi.set_official');
    Route::post('finalisasi/lock', [AdminPagesController::class, 'lock'])->name('finalisasi.lock');
    // Penerbitan SKPI (resmi)
    Route::get('penerbitan', [\App\Http\Controllers\Admin\PenerbitanController::class, 'index'])->name('penerbitan.index');
    Route::post('penerbitan/publish', [\App\Http\Controllers\Admin\PenerbitanController::class, 'publishBulk'])->name('penerbitan.publish_bulk');
    Route::post('penerbitan/publish/{user}', [\App\Http\Controllers\Admin\PenerbitanController::class, 'publishSingle'])->name('penerbitan.publish_single');
    Route::get('penerbitan/download/{user}', [\App\Http\Controllers\Admin\PenerbitanController::class, 'download'])->name('penerbitan.download');
    Route::get('penerbitan/verify/{user}', [\App\Http\Controllers\Admin\PenerbitanController::class, 'verify'])->name('penerbitan.verify');
    Route::get('pengaturan', [AdminPagesController::class, 'pengaturan'])->name('pengaturan.index');
    Route::post('pengaturan/save-permissions', [AdminPagesController::class, 'savePermissions'])->name('security.save_permissions');
    Route::post('pengaturan/save-advanced', [AdminPagesController::class, 'saveAdvanced'])->name('security.save_advanced');
    Route::get('cetak-skpi', [CetakSkpiController::class, 'index'])->name('cetak_skpi.index');
    Route::get('cetak-skpi/preview/{user}', [CetakSkpiController::class, 'preview'])->name('cetak_skpi.preview');
    Route::get('cetak-skpi/print/{user}', [CetakSkpiController::class, 'printSingle'])->name('cetak_skpi.print_single');
    Route::post('cetak-skpi/print-bulk', [CetakSkpiController::class, 'printBulk'])->name('cetak_skpi.print_bulk');
    Route::get('pejabat', [PejabatController::class, 'index'])->name('pejabat.index');
    Route::get('pejabat/create', [PejabatController::class, 'create'])->name('pejabat.create');
    Route::post('pejabat', [PejabatController::class, 'store'])->name('pejabat.store');
    Route::get('pejabat/{pejabat}/edit', [PejabatController::class, 'edit'])->name('pejabat.edit');
    Route::put('pejabat/{pejabat}', [PejabatController::class, 'update'])->name('pejabat.update');
    Route::delete('pejabat/{pejabat}', [PejabatController::class, 'destroy'])->name('pejabat.destroy');
    Route::get('pengaturan-sistem', [SystemSettingsController::class, 'index'])->name('system_settings.index');
    Route::post('pengaturan-sistem/institusi', [SystemSettingsController::class, 'updateInstitution'])->name('system_settings.institution');
    Route::post('pengaturan-sistem/narasi', [SystemSettingsController::class, 'updateNarratives'])->name('system_settings.narratives');
    Route::post('pengaturan-sistem/umum', [SystemSettingsController::class, 'updateGeneral'])->name('system_settings.general');

    // Admin mapping: Manajemen Data SKPI & Verifikasi menggunakan controller verifikator
    Route::get('portofolio', [PortfolioReviewController::class, 'index'])->name('portfolios.index');
    Route::get('portofolio/{portfolio}', [PortfolioReviewController::class, 'show'])->name('portfolios.show');
});


require __DIR__ . '/auth.php';
