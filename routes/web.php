<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,ShelterController,AdminController};
Route::get('/',[ShelterController::class,'home'])->name('home');
Route::view('/privacidad','privacy');
Route::middleware('guest')->group(function(){Route::view('/login','auth',['register'=>false])->name('login');Route::view('/registro','auth',['register'=>true]);Route::post('/login',[AuthController::class,'login'])->middleware('throttle:6,1');Route::post('/registro',[AuthController::class,'register'])->middleware('throttle:6,1');});
Route::middleware('auth')->group(function(){
 Route::post('/logout',[AuthController::class,'logout']);Route::get('/panel',[ShelterController::class,'panel']);
 Route::post('/adopciones',[ShelterController::class,'adopt']);Route::post('/aportes',[ShelterController::class,'donate']);Route::post('/voluntariado',[ShelterController::class,'volunteer']);
 Route::middleware('role:admin,volunteer')->group(function(){Route::get('/cuidados',[ShelterController::class,'careIndex']);Route::post('/cuidados',[ShelterController::class,'care']);});
 Route::middleware('role:admin')->prefix('admin')->group(function(){Route::get('/solicitudes',[AdminController::class,'requests']);Route::post('/revision/{type}/{id}',[AdminController::class,'review']);Route::get('/{kind}',[AdminController::class,'index']);Route::get('/{kind}/{id}/editar',[AdminController::class,'edit']);Route::post('/{kind}',[AdminController::class,'save']);Route::put('/{kind}/{id}',[AdminController::class,'save']);Route::delete('/{kind}/{id}',[AdminController::class,'delete']);});
});
