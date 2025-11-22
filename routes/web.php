<?php

<<<<<<< HEAD
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Personal\ProfilePersonalController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Admin\AgendaAdminController;
use App\Http\Controllers\PublicCalendarController;
use App\Http\Controllers\AuthController;
=======
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
>>>>>>> f4429a1f27569837233fd7678f71f26dd4147e74

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\InstansiAuthController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HelpTicketController;

use App\Http\Controllers\InstansiDashboardController;
use App\Http\Controllers\InstansiProfileController;
use App\Http\Controllers\InstansiTesController;

/*
|--------------------------------------------------------------------------
| Landing & Auth (ALL USERS)
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => Inertia::render('landing'))->name('home');
Route::get('/test-web', fn () => 'Web Loaded');

Route::get('/login', fn () => Inertia::render('auth/login'))->name('login');
Route::get('/register', fn () => Inertia::render('auth/register'))->name('register');

Route::get('/calendar', fn () => Inertia::render('Calendar'));

/*
|--------------------------------------------------------------------------
| PERSONAL ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('personal')
    ->middleware(['auth', 'role:personal'])
    ->group(function () {

        Route::get('/dashboardPersonal', fn () => Inertia::render('Personal/dashboard-personal'))
            ->name('personal.dashboard');

        Route::get('/profilePersonal', fn () => Inertia::render('Personal/Profile'))
            ->name('personal.profile');

        Route::get('/daftarTesPersonal', fn () => Inertia::render('Personal/daftar-tes'))
            ->name('personal.daftar-tes');

        Route::get('/transaksiTokenPersonal', fn () => Inertia::render('Personal/transaksi-token'))
            ->name('personal.transaksi-token');

        Route::get('/hasilTesPersonal', fn () => Inertia::render('Personal/results'))
            ->name('personal.results');

        Route::get('/hadiahDonasiPersonal', fn () => Inertia::render('Personal/hadiah-donasi'))
            ->name('personal.hadiah-donasi');

        Route::get('/bantuanPersonal', fn () => Inertia::render('Personal/bantuan'))
            ->name('personal.bantuan');

        Route::get('/settingPersonal', fn () => Inertia::render('Personal/setting'))
            ->name('personal.setting');

        Route::get('/formTes', fn () => Inertia::render('Personal/form-tes-personal'))
            ->name('personal.form-tes');
    });

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES 
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboardAdmin', fn () => Inertia::render('Admin/dashboard-admin'))
            ->name('admin.dashboard');

        Route::get('/profileAdmin', fn () => Inertia::render('Admin/Profile'))
            ->name('admin.profile');

        Route::get('/agendaAdmin', fn () => Inertia::render('Admin/Agenda'))
            ->name('admin.agenda');

        Route::get('/penggunaAdmin', fn () => Inertia::render('Admin/Pengguna'))
            ->name('admin.pengguna');

        Route::get('/keuanganAdmin', fn () => Inertia::render('Admin/Keuangan'))
            ->name('admin.keuangan');

        Route::get('/teamAdmin', fn () => Inertia::render('Admin/Tim'))
            ->name('admin.team');

        Route::get('/supportAdmin', fn () => Inertia::render('Admin/Bantuan'))
            ->name('admin.support');

        Route::get('/settingsAdmin', fn () => Inertia::render('Admin/Pengaturan'))
            ->name('admin.settings');
    });

/*
|--------------------------------------------------------------------------
| INSTANSI ROUTES 
|--------------------------------------------------------------------------
*/
Route::prefix('instansi')
    ->middleware(['auth', 'role:instansi'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboardInstansi', [InstansiDashboardController::class, 'index'])
            ->name('instansi.dashboard');

        // Profil
        Route::get('/profilInstansi', [InstansiProfileController::class, 'edit'])
            ->name('instansi.profil.edit');

        Route::post('/profilInstansi', [InstansiProfileController::class, 'update'])
            ->name('instansi.profil.update');

        // Daftar Tes Karakter
        Route::get('/tesInstansi', [InstansiTesController::class, 'index'])
            ->name('instansi.tes.index');

        Route::post('/tesInstansi/upload-excel', [InstansiTesController::class, 'uploadExcel'])
            ->name('instansi.tes.upload');

        // Hasil Tes — SEKARANG menggunakan controller
        Route::get('/hasilInstansi', [InstansiTesController::class, 'hasil'])
            ->name('instansi.hasil');

        // Halaman lain
        Route::get('/transaksiInstansi', fn () => Inertia::render('Instansi/Transaksi'))
            ->name('instansi.transaksi');

        Route::get('/bantuanInstansi', fn () => Inertia::render('Instansi/Bantuan'))
            ->name('instansi.bantuan');

        Route::get('/artikelInstansi', fn () => Inertia::render('Instansi/Artikel'))
            ->name('instansi.artikel');

        Route::get('/pengaturanInstansi', fn () => Inertia::render('Instansi/Pengaturan'))
            ->name('instansi.pengaturan');

        Route::get('/formTesInstansi', fn () => Inertia::render('Instansi/form-tes-instansi'))
            ->name('instansi.form-tes-instansi');
    });

/*
|--------------------------------------------------------------------------
| REGISTER INSTANSI
|--------------------------------------------------------------------------
*/

Route::get('/instansi/register', [InstansiAuthController::class, 'create'])
    ->middleware('guest')
    ->name('instansi.register');

Route::post('/instansi/register', [InstansiAuthController::class, 'store'])
    ->middleware('guest')
    ->name('instansi.register.store');

/*
|--------------------------------------------------------------------------
| LOGIN / LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Artikel
|--------------------------------------------------------------------------
*/

Route::get('/artikel', [ArticleController::class, 'index'])
    ->name('artikel.index');

Route::get('/artikel/{slug}', [ArticleController::class, 'show'])
    ->name('artikel.show');

/*
|--------------------------------------------------------------------------
| HelpTicket
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/instansi/bantuan', [HelpTicketController::class, 'store'])
        ->name('instansi.bantuan.store');
});

require __DIR__ . '/settings.php';
