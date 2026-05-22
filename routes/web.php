<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\Models\Salon;

// Controladores
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| 1. RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('welcome'); });
Route::view('/privacy', 'privacy')->name('privacy');

// --- LOGIN DUEÑAS (Guardia Web) ---
Route::get('/login', function () {
    if (Auth::guard('web')->check()) return redirect()->route('admin.dashboard');
    return view('auth.login-duena'); 
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate(['email' => 'required|email', 'password' => 'required']);
    
    // Intenta loguear en tabla 'users'
    if (Auth::guard('web')->attempt($credentials, true)) { 
        $request->session()->regenerate();
        $user = Auth::guard('web')->user();
        if ($user->email === 'contacto@rodnix.com.mx') return redirect()->route('superadmin.index');
        return redirect()->route('admin.dashboard');
    }
    return back()->withErrors(['email' => 'Credenciales incorrectas']);
})->name('login.post');

// --- LOGIN CLIENTAS (Solo vista, la lógica es Google) ---
Route::get('/login-cliente', function () {
    if (Auth::guard('client')->check()) return redirect()->route('perfil.index');
    return view('auth.login-cliente');
})->name('login.cliente');

// --- GOOGLE AUTH (Backend) ---
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/google/callback', [GoogleAuthController::class, 'callback']);

// --- LOGOUT (Cierra todo) ---
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    Auth::guard('client')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/'); 
})->name('logout');

// --- REGISTRO Y PASSWORD ---
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| 2. ZONA DUEÑAS (Middleware: auth:web)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // API & Settings
    Route::put('/settings/servicio/{id}', [SettingsController::class, 'updateServicio'])->name('settings.updateServicio');
    Route::patch('/cita/{id}/status', [AdminController::class, 'updateCitaStatus'])->name('cita.status');
    Route::post('/api/save-device', [AdminController::class, 'saveDeviceID'])->name('api.saveDevice');
    Route::get('/api/ultimas-citas', [AdminController::class, 'checkNuevasCitas'])->name('api.citas.check');
    
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/update', [SettingsController::class, 'updateSalon'])->name('settings.updateSalon');
    Route::post('/settings/servicio', [SettingsController::class, 'storeServicio'])->name('settings.storeServicio');
    Route::delete('/settings/servicio/{id}', [SettingsController::class, 'destroyServicio'])->name('settings.destroyServicio');

    // Super Admin
    Route::prefix('superadmin')->group(function () {
        Route::get('/', [SuperAdminController::class, 'index'])->name('superadmin.index');
        Route::delete('/{id}', [SuperAdminController::class, 'destroy'])->name('superadmin.destroy');
        Route::get('/login-as/{id}', [SuperAdminController::class, 'loginAs'])->name('superadmin.loginAs');
        Route::patch('/status/{id}', [SuperAdminController::class, 'toggleStatus'])->name('superadmin.status'); 
    });
});

/*
|--------------------------------------------------------------------------
| 3. ZONA CLIENTAS (Middleware: auth:client)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:client'])->group(function () {
    Route::get('/perfil', [ClientController::class, 'index'])->name('perfil.index');
});

/*
|--------------------------------------------------------------------------
| 4. RUTAS PÚBLICAS GLOBALES
|--------------------------------------------------------------------------
*/

// 🔥 RUTA ADS.TXT (Manual Force) 🔥
// Esta ruta obliga a Laravel a servir el archivo como texto plano.
Route::get('/ads.txt', function () {
    $path = public_path('ads.txt');
    if (!File::exists($path)) abort(404);
    return response()->file($path, ['Content-Type' => 'text/plain']);
});

Route::post('/reservar', [ReservaController::class, 'store'])->name('reservar.store');

// Imágenes
Route::get('/uploads/{filename}', function ($filename) {
    $path = public_path('uploads/' . basename($filename));
    if (!File::exists($path)) abort(404);
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

// Perfil de Salón (Slug) - IMPORTANTE: Esta debe ir AL FINAL
Route::get('/{slug}', function ($slug) {
    $salon = Salon::with('servicios')->where('slug', $slug)->where('active', true)->firstOrFail();
    return view('salon', compact('salon'));
})->name('salon.show');