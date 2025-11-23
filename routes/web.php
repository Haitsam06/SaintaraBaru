<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Personal\ProfilePersonalController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Admin\AgendaAdminController;
use App\Http\Controllers\PublicCalendarController;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Application;

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
use App\Http\Controllers\Personal\SettingPersonalController;
use App\Http\Controllers\Personal\SupportTicketController;

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

// --- BAGIAN AUTHENTICATION ---

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return Inertia::render('auth/login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', function () {
        return Inertia::render('auth/register');
    })->name('register');

    Route::post('/register', [AuthController::class, 'store'])->name('register.store');

    // Ini adalah rute yang benar dan mengirim data
    Route::get('/kalender-agenda', [PublicCalendarController::class, 'index'])->name('public.calendar');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- GROUP PERSONAL USER (CUSTOMER) ---
// Middleware: auth:customer
Route::prefix('personal')->name('personal.')->group(function () {

    // URL: /personal/dashboardPersonal
    // Route Name: personal.dashboard
    // File: pages/Personal/dashboard-personal.tsx
    Route::get('/dashboardPersonal', function () {
        return Inertia::render('Personal/dashboard-personal');
    })->name('dashboard');

    Route::get('/profilePersonal', [ProfilePersonalController::class, 'index'])->name('profile');

    Route::put('/profile/update', [ProfilePersonalController::class, 'update'])->name('personal.profile.update');

    Route::get('/daftarTesPersonal', function () {
        return Inertia::render('Personal/daftar-tes');
    })->name('daftar-tes');

    Route::get('/transaksiTokenPersonal', function () {
        return Inertia::render('Personal/transaksi-token');
    })->name('transaksi-token');

    Route::get('/hasilTesPersonal', function () {
        return Inertia::render('Personal/results');
    })->name('results');

    Route::get('/hadiahDonasiPersonal', function () {
        return Inertia::render('Personal/hadiah-donasi');
    })->name('hadiah-donasi');

    Route::get('/bantuanPersonal', function () {
        return Inertia::render('Personal/bantuan');
    })->name('bantuan');
    
    Route::post('/bantuanPersonal', [SupportTicketController::class, 'store'])->name("bantuan.personal.store");

    Route::get('/settingPersonal', [SettingPersonalController::class, 'index'])->name('setting.personal');
    Route::put('/settingPersonal/email', [SettingPersonalController::class, 'updateEmail'])->name('setting.personal.email');
    Route::put('/settingPersonal/password', [SettingPersonalController::class, 'updatePassword'])->name('setting.personal.password');
    Route::delete('/settingPersonal', [SettingPersonalController::class, 'deleteAccount'])->name('setting.personal.delete');

    Route::get('/formTes', function () {
        return Inertia::render('Personal/form-tes-personal');
    })->name('form-tes');

    Route::post('/update-profile-personal', [ProfilePersonalController::class, 'update']);

});

// --- GROUP ADMIN ---
// Middleware: auth:admin
Route::prefix('admin')->name('admin.')->group(function () {

    // URL: /admin/dashboardAdmin
    // Route Name: admin.dashboard (Fix: hapus prefix 'admin.' di name())
    // File: pages/Admin/dashboard-admin.tsx
    Route::get('/dashboardAdmin', function () {
        return Inertia::render('Admin/dashboard-admin');
    })->name('dashboard');

    Route::get('/profileAdmin', function () {
        return Inertia::render('Admin/Profile');
    })->name('profile');

    Route::post('/updateProfile', [ProfileAdminController::class, 'update'])->name('profile.update');

    Route::get('/agendaAdmin', [AgendaAdminController::class, 'index'])->name('agenda');

    Route::post('/agendaAdmin', [AgendaAdminController::class, 'store'])->name('agenda.store');

    Route::get('/penggunaAdmin', function () {
        return Inertia::render('Admin/Pengguna');
    })->name('pengguna');

    Route::get('/keuanganAdmin', function () {
        return Inertia::render('Admin/Keuangan');
    })->name('keuangan');

    Route::get('/teamAdmin', function () {
        return Inertia::render('Admin/Tim');
    })->name('team');

    Route::get('/supportAdmin', function () {
        return Inertia::render('Admin/Bantuan');
    })->name('support');

    Route::get('/settingsAdmin', function () {
        return Inertia::render('Admin/Pengaturan');
    })->name('settings');

});

// --- GROUP INSTANSI ---
// Middleware: auth:instansi
Route::prefix('instansi')->name('instansi.')->group(function () {

    // URL: /instansi/dashboardInstansi
    // Route Name: instansi.dashboard
    // File: pages/Instansi/Dashboard.tsx (Perhatikan huruf D besar sesuai screenshot)
    Route::get('/dashboardInstansi', function () {
        return Inertia::render('Instansi/Dashboard');
    })->name('dashboard');

    Route::get('/profilInstansi', function () {
        return Inertia::render('Instansi/Profile');
    })->name('profil');

    Route::get('/tesInstansi', function () {
        return Inertia::render('Instansi/DaftarTes');
    })->name('daftar_tes');

    Route::get('/transaksiInstansi', function () {
        return Inertia::render('Instansi/Transaksi');
    })->name('transaksi');

    Route::get('/hasilInstansi', function () {
        return Inertia::render('Instansi/Hasil');
    })->name('hasil');

    Route::get('/bantuanInstansi', function () {
        return Inertia::render('Instansi/Bantuan');
    })->name('bantuan');

    Route::get('/artikelInstansi', function () {
        return Inertia::render('Instansi/Artikel');
    })->name('artikel');

    Route::get('/pengaturanInstansi', function () {
        return Inertia::render('Instansi/Pengaturan');
    })->name('pengaturan');

    Route::get('/formTesInstansi', function () {
        return Inertia::render('Instansi/form-tes-instansi');
    })->name('form-tes-instansi');

});

require __DIR__ . '/settings.php';
