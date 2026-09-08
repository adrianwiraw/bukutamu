<?php
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuTamuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeperluanController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome.welcome');
})->name('welcome');

Route::get('/welcome', function () {
    return view('welcome.welcome');
})->name('welcome');

Route::get('/bukutamu', [BukuTamuController::class, 'create'])->name('bukutamu.create');
Route::post('/bukutamu', [BukuTamuController::class, 'store'])->name('bukutamu.store');
Route::post('/bukutamu/feedback', [BukuTamuController::class, 'storeFeedback'])->name('bukutamu.feedback.store');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('role', PermissionController::class)->parameters(['role' => 'role'])->middleware('permission:Kelola Privileges');

    Route::get('/dashboard/chart-bulan', [DashboardController::class, 'chartBulan'])->middleware('auth')->name('dashboard.chart-bulan');
    Route::get('/dashboard/chart-tanggal', [DashboardController::class, 'chartTanggal'])->middleware('auth')->name('dashboard.chart-tanggal');
    Route::get('/dashboard/chart-keperluan', [DashboardController::class, 'chartKeperluan'])->middleware('auth')->name('dashboard.chart-keperluan');
    Route::get('/dashboard/feedback', [DashboardController::class, 'feedbackIndex'])->middleware('auth')->name('dashboard.feedback.index');
    Route::put('/dashboard/feedback/{feedback}', [DashboardController::class, 'updateFeedback'])->middleware('auth')->name('dashboard.feedback.update');
    Route::delete('/dashboard/feedback/{feedback}', [DashboardController::class, 'destroyFeedback'])->middleware('auth')->name('dashboard.feedback.destroy');
    Route::get('/informasi-pengguna', [UserManagementController::class, 'informasi'])->name('akun-pengguna.informasi');
    Route::get('/pengunjung', [PengunjungController::class, 'index'])->name('pengunjung.index');
    Route::get('/pengunjung/{bukuTamu}/edit', [PengunjungController::class, 'edit'])->name('pengunjung.edit');
    Route::put('/pengunjung/{bukuTamu}', [PengunjungController::class, 'update'])->name('pengunjung.update');
    Route::delete('/pengunjung/{bukuTamu}', [PengunjungController::class, 'destroy'])->name('pengunjung.destroy');
    Route::get('/laporan/harian', [LaporanController::class, 'harian'])->name('laporan.harian');
    Route::get('/laporan/harian/pdf', [LaporanController::class, 'harianPdf'])->name('laporan.harian.pdf');
    Route::get('/laporan/harian/excel', [LaporanController::class, 'harianExcel'])->name('laporan.harian.excel');
    Route::get('/laporan/bulanan', [LaporanController::class, 'bulanan'])->name('laporan.bulanan');
    Route::get('/laporan/bulanan/pdf', [LaporanController::class, 'bulananPdf'])->name('laporan.bulanan.pdf');
    Route::get('/laporan/bulanan/excel', [LaporanController::class, 'bulananExcel'])->name('laporan.bulanan.excel');
    Route::get('/laporan/tahunan', [LaporanController::class, 'tahunan'])->name('laporan.tahunan');
    Route::get('/laporan/tahunan/pdf', [LaporanController::class, 'tahunanPdf'])->name('laporan.tahunan.pdf');
    Route::get('/laporan/tahunan/excel', [LaporanController::class, 'tahunanExcel'])->name('laporan.tahunan.excel');
    Route::get('/laporan/custom', [LaporanController::class, 'custom'])->name('laporan.custom');
    Route::get('/laporan/custom/pdf', [LaporanController::class, 'customPdf'])->name('laporan.custom.pdf');
    Route::get('/laporan/custom/excel', [LaporanController::class, 'customExcel'])->name('laporan.custom.excel');

});

Route::middleware('auth')->group(function () {
    // ... route profile yang udah ada

    Route::resource('grup', GroupController::class)
        ->parameters(['grup' => 'grup'])
        ->middleware('permission:Kelola Grup');

    Route::resource('akun-pengguna', UserManagementController::class)
        ->parameters(['akun-pengguna' => 'akun_pengguna'])
        ->middleware('permission:Kelola Akun');

    Route::post('/akun-pengguna/{akun_pengguna}/toggle-aktif', [UserManagementController::class, 'toggleAktif'])
        ->name('akun-pengguna.toggle-aktif')
        ->middleware('permission:Kelola Akun');


    Route::resource('keperluan', KeperluanController::class);

});
require __DIR__ . '/auth.php';