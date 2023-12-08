<?php

use App\Http\Controllers\DeleteDataController;
use App\Http\Controllers\InsertDataController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Apoteker;
use App\Models\Appointment;
use App\Models\Dokter;
use App\Models\MedicalRecord;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     // Dokter::limit(5)->get();
//     $users = User::all();
//     $dokters = Dokter::with('user')->get();

//     return view('dashboard', compact('users', 'dokters'));
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    $users = User::with('dokter')->get();
    $medicalRecord = MedicalRecord::all();

    $pasien = Pasien::whereHas('medicalRecord', function ($query) {$query->whereNotNull('tgl_berobat');})->join('medical_records', 'medical_records.pasien_id', '=', 'pasiens.id')->orderByDesc('medical_records.tgl_berobat')->limit(5)->get();

    $dokterBertugas = $users->filter(function ($user) {
        return $user->dokter && $user->dokter->status === 'Bertugas';});

    $users = User::with('pasien.appointment.medicalrecord.obat')->whereHas('pasien.appointment', function ($query) {$query->where('status', 'Selesai');})->get();
    $obats = Obat::all();

    return view('dashboard', compact('dokterBertugas', 'pasien', 'medicalRecord', 'users', 'obats'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get("admin", function(){
    return "<h1>Hello Admin</h1>";
})->middleware(['auth', 'verified', "role:admin"]);

Route::get("dokter", function(){
    return "<h1>Hello dokter</h1>";
})->middleware(['auth', 'verified', "role:admin|dokter"]);

Route::get("apoteker", function(){
    return "<h1>Hello apoteker</h1>";
})->middleware(['auth', 'verified', "role:admin|apoteker"]);

Route::get("pasien", function(){
    return "<h1>Hello pasien</h1>";
})->middleware(['auth', 'verified', "role:admin|pasien"]);

Route::get('user-profile', function () {
    return view("user-profile");
})->middleware(['auth', 'verified', "role:admin|dokter|apoteker|pasien"])->name('user-profile');

Route::get('user-list', function () {
    $users = User::all();
    $dokters = Dokter::with('user')->get();
    $apotekers = Apoteker::with('user')->get();
    $pasiens = Pasien::with('user')->get();

    return view("admin.user-list", compact("users", "dokters", 'apotekers', 'pasiens'));
})->middleware(['auth', 'verified', "role:admin"])->name('user-list');

Route::get('obat-list', function () {
    $obats = Obat::all();
    return view("apoteker.obat-list", compact("obats"));
})->middleware(['auth', 'verified', "role:apoteker"])->name('obat-list');

Route::get('pasien-list', function () {
    $users = User::all();
    $dokters = Dokter::with('user')->get();
    $apotekers = Apoteker::with('user')->get();
    $pasiens = Pasien::with('user')->get();
    $appointments = Appointment::with('pasien')->get();
    $medicalRecords = MedicalRecord::with('dokter')->get();

    return view("dokter.pasien-list", compact("users", "dokters", 'apotekers', 'pasiens', 'appointments', 'medicalRecords'));
})->middleware(['auth', 'verified', "role:dokter"])->name('pasien-list');

Route::get('insert-user', function(){
    return view("admin.insert-user");
})->middleware(['auth', 'verified', "role:admin"]);

Route::get('insert-obat', function(){
    return view("apoteker.insert-obat");
})->middleware(['auth', 'verified', "role:apoteker"]);

Route::get('insert-riwayat', function(){
    return view("dokter.insert-riwayat");
})->middleware(['auth', 'verified', "role:dokter"]);

Route::get('user-view', function(){
    return view("admin.user-view");
})->middleware(['auth', 'verified', "role:admin"]);

Route::post('tambah-user', [InsertDataController::class, 'storeuser'])->name('tambah-user');

Route::post('tambah-obat', [InsertDataController::class, 'storeobat'])->name('tambah-obat');

Route::get('delete-user/{id}', [DeleteDataController::class, 'deleteuser'])->middleware(['auth', 'verified', "role:admin"])->name('deleteuser');

Route::get('delete-obat/{id}', [DeleteDataController::class, 'deleteobat'])->middleware(['auth', 'verified', "role:apoteker"])->name('deleteobat');

Route::get('delete-pasien/{id}', [DeleteDataController::class, 'deletepasien'])->middleware(['auth', 'verified', "role:dokter"])->name('deletepasien');

Route::get('obat-edit', function(){
    return view('apoteker.obat-edit');
});

Route::get('user-edit', function(){
    return view('admin.user-edit');
});

Route::get('dashboard1', function(){
    $obats = Obat::all();

    return view("apoteker.dashboard1", compact("obats"));
})->middleware(['auth', 'verified', "role:apoteker"])->name('obat-list');

// Apoteker edit obat
Route::get('/obat-edit/{id}', [ObatController::class, 'showobat'])->name('showobat');
Route::post('/obat-update/{id}', [ObatController::class, 'update'])->name('obat-update');

// Admin edit user
Route::get('/user-edit/{id}', [UserController::class, 'showuser'])->name('showuser');
Route::post('/user-update/{id}', [UserController::class, 'update'])->name('user-update');

// Admin kirim ke dokter
Route::get('atur-pasien/{id}', [UserController::class, 'editPasien'])->name('edit-pasien');
Route::put('atur-pasien/{id}', [UserController::class, 'updatePasien'])->name('update-pasien');

// Dokter edit riwayat
Route::get('edit-riwayat/{id}', [UserController::class, 'editRiwayat'])->name('edit-riwayat');
// Route::put('update-riwayat/{id}', [UserController::class, 'updateRiwayat'])->name('update-riwayat');

// Dokter Edit riwayat
// Route::get('isi-riwayat/{id}', [UserController::class, 'isiRiwayat'])->name('isi-riwayat');
Route::put('kirim-riwayat/{id}', [UserController::class, 'kirimRiwayat'])->name('kirim-riwayat');

// Dokter tambah riwayat/medical record
// Route::get('tambah-riwayat/', [UserController::class, 'editRiwayat'])->name('tambah-riwayat');
Route::post('tambah-riwayat/', [UserController::class, 'insertRiwayat'])->name('insert-riwayat');

// Pasien
Route::get('riwayat', function(){
    $users = User::with('pasien.appointment.medicalrecord.obat')->where('role', 'pasien')->whereHas('pasien.appointment', function ($query) {$query->where('status', 'Selesai');})->get();

    return view("pasien.riwayat", compact('users'));
})->middleware(['auth', 'verified', "role:pasien"])->name('riwayat');

Route::get('/statusOn', [UserController::class, 'setBertugas'])->name('setBertugas');
Route::get('/statusOff', [UserController::class, 'setTidakBertugas'])->name('setTidakBertugas');

// method get harus pakai middleware dan sesuai role
require __DIR__.'/auth.php';
