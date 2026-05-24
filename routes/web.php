<?php
// Lokasi: routes/web.php
// Ganti SELURUH isi file ini

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// ── Public: Auth ─────────────────────────────────────────────────
Route::get('/',       fn() => redirect()->route('login'));
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// ── Debug Route (Remove in production) ─────────────────────────────
Route::get('/debug/api/technicians', function() {
    $response = \App\Helpers\ApiHelper::get("/technicians");
    
    // Dump seluruh response untuk debugging
    echo "<pre style='background:#f5f5f5;padding:20px;font-family:monospace;'>";
    echo "=== FULL API RESPONSE ===\n";
    var_dump($response);
    echo "\n=== ANALYSIS ===\n";
    echo "Data Type: " . gettype($response['data'] ?? null) . "\n";
    echo "Data Value: " . var_export($response['data'], true) . "\n";
    echo "\n=== WHAT SHOULD TECHS BE ===\n";
    if (isset($response['data']) && is_array($response['data'])) {
        if (isset($response['data']['technicians']) && is_array($response['data']['technicians'])) {
            echo "TECHS = response['data']['technicians']\n";
            echo "Count: " . count($response['data']['technicians']) . "\n";
        } elseif (count($response['data']) > 0) {
            echo "TECHS = response['data'] (directly)\n";
            echo "Count: " . count($response['data']) . "\n";
        } else {
            echo "TECHS = [] (empty)\n";
        }
    } else {
        echo "ERROR: data is not an array! Type: " . gettype($response['data'] ?? null) . "\n";
    }
    echo "</pre>";
});

Route::get('/debug/api/logs', function() {
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        $logs = file_get_contents($logFile);
        return response($logs, 200, ['Content-Type' => 'text/plain; charset=utf-8']);
    }
    return 'Log file not found at: ' . $logFile;
});

Route::get('/debug/api/notifications', function() {
    $res = \App\Helpers\ApiHelper::get('/notifications?limit=5');
    return response()->json([
        'session_role' => session('servizz_user.role'),
        'api_response' => $res
    ]);
});

// ── Protected: Semua role ─────────────────────────────────────────
Route::middleware('servizz.auth')->group(function () {

    // Dashboard - Hanya Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware('servizz.auth:Admin');

    // Pesanan - Semua Role
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/',             [OrderController::class, 'index'])->name('index');
        Route::get('/{id}',         [OrderController::class, 'show'])->name('show');
        Route::post('/{id}/assign', [OrderController::class, 'assign'])
            ->name('assign')
            ->middleware('servizz.auth:Admin');
        Route::post('/{id}/status', [OrderController::class, 'updateStatus'])->name('status');

        // Khusus Mitra
        Route::post('/{id}/nego',        [OrderController::class, 'storeNego'])->name('nego.store')->middleware('servizz.auth:Mitra');
        Route::post('/{id}/nego/update', [OrderController::class, 'updateNego'])->name('nego.update')->middleware('servizz.auth:Mitra');
        Route::post('/{id}/rating', [\App\Http\Controllers\OrderController::class, 'submitRating'])
            ->name('rating')
            ->middleware('servizz.auth:Pelanggan');

        Route::post('/{id}/evidence', [\App\Http\Controllers\OrderController::class, 'storeEvidence'])
            ->name('evidence.store')->middleware('servizz.auth:Mitra');

        // Khusus Pelanggan
        Route::post('/create',           [OrderController::class, 'store'])->name('store')->middleware('servizz.auth:Pelanggan');
        Route::post('/{id}/nego/decide', [OrderController::class, 'decideNego'])->name('nego.decide')->middleware('servizz.auth:Pelanggan');

        // Pembayaran Midtrans (Khusus Pelanggan)
        Route::post('/{id}/pay',         [PaymentController::class, 'charge'])->name('pay')->middleware('servizz.auth:Pelanggan');
    });

    // Mitra / Teknisi - Hanya Admin
    Route::prefix('technicians')->name('technicians.')->middleware('servizz.auth:Admin')->group(function () {
        Route::get('/',             [TechnicianController::class, 'index'])->name('index');
        Route::get('/{id}',         [TechnicianController::class, 'show'])->name('show');
        Route::post('/{id}/verify', [TechnicianController::class, 'verify'])->name('verify');
    });

    // Pengguna - Hanya Admin
    Route::prefix('users')->name('users.')->middleware('servizz.auth:Admin')->group(function () {
        Route::get('/',             [UserController::class, 'index'])->name('index');
        Route::get('/{id}',         [UserController::class, 'show'])->name('show');
        Route::post('/{id}/toggle', [UserController::class, 'toggle'])->name('toggle');
    });

    // Kategori Jasa - Semua Role bisa list, store hanya Admin
    Route::prefix('services-list')->name('services.')->group(function () {
        Route::get('/',    [ServiceController::class, 'index'])->name('index');
        Route::post('/',   [ServiceController::class, 'store'])
            ->name('store')
            ->middleware('servizz.auth:Admin');
    });

    // Profil - Semua Role
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
    });

    // Pengaturan - Semua Role
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [\App\Http\Controllers\SettingsController::class, 'index'])->name('index');
        Route::post('/profile', [\App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('profile.update');
        Route::post('/avatar', [\App\Http\Controllers\SettingsController::class, 'uploadAvatar'])->name('avatar.upload');
        Route::post('/avatar/delete', [\App\Http\Controllers\SettingsController::class, 'deleteAvatar'])->name('avatar.delete');
        
        Route::get('/password', [\App\Http\Controllers\SettingsController::class, 'password'])->name('password');
        Route::post('/password', [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('password.update');
        Route::get('/notifications', [\App\Http\Controllers\SettingsController::class, 'notifications'])->name('notifications');
        Route::get('/verification', [\App\Http\Controllers\SettingsController::class, 'verification'])->name('verification');
        Route::post('/verification', [\App\Http\Controllers\SettingsController::class, 'uploadDocuments'])->name('verification.upload');
    });

    // Bantuan / Help
    Route::prefix('help')->name('help.')->group(function () {
        Route::get('/', [\App\Http\Controllers\HelpController::class, 'index'])->name('index');
        Route::get('/messages', [\App\Http\Controllers\HelpController::class, 'getMessages'])->name('messages.get');
        Route::post('/messages', [\App\Http\Controllers\HelpController::class, 'sendMessage'])->name('messages.send');
    });

    Route::post('/notifications/{id}/read', [\App\Http\Controllers\HelpController::class, 'markRead'])->name('notifications.read');
});