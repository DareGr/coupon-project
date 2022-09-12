<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FilterController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [LoginController::class, 'index'])->middleware('guest');

Route::middleware(['auth'])->group(function() {
    Route::get('/admin_dashboard', [AdminController::class, 'index'])->name('admin_dashboard');

    Route::get('/all_coupons', [CouponController::class, 'all'])->name('all_coupons');
    Route::get('/active_coupons', [CouponController::class, 'active'])->name('active_coupons');
    Route::get('/used_coupons', [CouponController::class, 'used'])->name('used_coupons');
    Route::get('/non_used_coupons', [CouponController::class, 'non_used'])->name('non_used_coupons');

    Route::get('/create_coupons', [CouponController::class, 'create'])->name('create_coupons');
    Route::post('/coupon_store', [CouponController::class, 'store'])->name('coupon_store');

    Route::post('/filter', [FilterController::class, 'filter'])->name('filter');

    Route::post('/edit', [CouponController::class, 'edit'])->name('edit');
    Route::patch('/update', [CouponController::class, 'update'])->name('update');
    Route::delete('/delete', [CouponController::class, 'delete'])->name('delete');

    Route::get('/emails', [EmailController::class, 'all'])->name('emails');

});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
