<?php

use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\SosmedController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KuponController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\ProfileController;
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


// Route::get('/register-reseller', [AuthController::class, 'register']);
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// HAK AKSES ADMIN
Route::middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminProductController::class, 'dashboard']);
    Route::get('/products', [AdminProductController::class, 'index']);
    Route::get('/products-input', [AdminProductController::class, 'create']);
    Route::post('/products-input', [AdminProductController::class, 'store']);
    Route::get('/products-delete/{id}', [AdminProductController::class, 'destroy']);
    Route::get('/category', [HomeController::class, 'category']);
    Route::post('/category', [HomeController::class, 'category_post']);
    Route::get('/category-delete/{id}', [HomeController::class, 'category_delete']);

    Route::get('select-sub-category/{id}', [HomeController::class, 'sub_category']);
    Route::get('/reseller', [HomeController::class, 'reseller'])->name('reseller');
    Route::get('/reseller-transaction', [HomeController::class, 'reseller_transaction']);
    Route::put('/update-level/{id}', [HomeController::class, 'update_level']);
    Route::get('/reseller-comission', [HomeController::class, 'reseller_comission']);
    Route::post('/reseller-verify/{id}', [HomeController::class, 'reseller_verify'])->name('reseller_verify');
    Route::resource('merks', MerkController::class);
    Route::resource('kupons', KuponController::class);
    Route::resource('grades', GradeController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('sosmeds', SosmedController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('logos', LogoController::class);
    Route::resource('videos', VideoController::class);
    Route::resource('banks', BankController::class);
    Route::get('/bundle', [HomeController::class, 'bundle'])->name('bundle');
    Route::get('/list-pelanggan', [HomeController::class, 'lp']);
});
// HAK AKSES ADMIN DAN RESELLER
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'home']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// HAK AKSES RESELLER
Route::middleware('reseller')->group(function () {
    Route::get('/dashboard-reseller', [HomeController::class, 'dashboard_reseller']);
    Route::get('/transaction-reseller', [HomeController::class, 'transaction_reseller']);
    Route::get('/transaction-dropshipper', [HomeController::class, 'transaction_dropshipper']);
    Route::get('/commission-reseller', [HomeController::class, 'commission_reseller']);

    Route::get('/reseller-checkout', [HomeController::class, 'reseller_checkout'])->name('reseller_checkout');
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
    Route::get('/get-pelanggan-info/{id}', [HomeController::class, 'getPelangganInfo']);
    Route::get('/pesanan', [HomeController::class, 'pesanan'])->name('pesanan');
});
// HAK AKSES SEMUA

Route::post('/beli-sekarang', [HomeController::class, 'buynow']);
Route::post('/buy-now', [HomeController::class, 'checkout_buynow']);
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/daftar', [HomeController::class, 'daftar'])->name('daftar');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/gabung', [HomeController::class, 'gabung'])->name('gabung');
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/konfirmasi', [HomeController::class, 'konfirmasi'])->name('konfirmasi');
Route::get('/katalog', [HomeController::class, 'katalog'])->name('katalog');
// Route::get('/informasi', [HomeController::class, 'informasi'])->name('informasi');
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::post('/login-jubelio', [HomeController::class, 'loginjubelio'])->name('loginjubelio');
Route::get('/product/{id}', [HomeController::class, 'product'])->name('product');
Route::post('/add-to-cart', [HomeController::class, 'addtocart']);
Route::get('/remove-cart-{index}',[HomeController::class,'remove_cart']);//dhapus cart berdasarkan index yang dipilih atau di klik
Route::get('/shipping', [HomeController::class, 'shipping'])->name('shipping');
Route::get('/tentang-kami', [HomeController::class, 'tentangKami'])->name('tentang-kami');
Route::get('/wishlist', [HomeController::class, 'wishlist'])->name('wishlist');
require __DIR__.'/auth.php';


Route::post('/post-pesanan',[HomeController::class,'post_pesanan']); //halaman Informasi costumer
Route::post('/post-pesanan-buynow',[HomeController::class,'post_pesanan_buynow']); //halaman Informasi costumer
Route::post('/post-pelanggan',[HomeController::class,'post_pelanggan']); //halaman Informasi costumer
Route::post('/post-dropshipper',[HomeController::class,'post_dropshipper']); //halaman Informasi costumer
Route::post('/payment-reseller',[HomeController::class,'pr']); //halaman Informasi costumer
Route::post('/post-information',[HomeController::class,'information_buynow']); //halaman Informasi costumer
Route::get('/publish/{id}',[AdminProductController::class,'export']); //halaman Informasi costumer
Route::get('/export/{id}',[AdminProductController::class,'view_export']); //halaman Informasi costumer
Route::get('/upload/{id}',[AdminProductController::class,'upload']); //halaman Informasi costumer
Route::post('/post-confirmshipping',[CekoutController::class,'confirmshipping_buynow']);//cek ongkir sesuai dengan informasi yang dikirimkan
Route::get('/post-shipping',[HomeController::class,'shipping_buynow']); //halaman memilih jasa pengiriman/shipping
Route::post('/post-confirmation',[HomeController::class,'confirmation_buynow']); //post transaksi dan detail transaksi
Route::get('/post-confirmation',[HomeController::class,'getconfirmation_buynow']); //page payment
Route::get('/post-confirmation/{code_inv}',[HomeController::class,'getconfirmation_buynow']); //page payment

Route::get('/informasi',[HomeController::class,'information']); //halaman Informasi costumer
Route::post('/confirmshipping',[HomeController::class,'confirmshipping']);//cek ongkir sesuai dengan informasi yang dikirimkan
Route::post('/confirmshipping-buynow',[HomeController::class,'confirmshipping_buynow']);//cek ongkir sesuai dengan informasi yang dikirimkan
Route::get('/shipping',[HomeController::class,'shipping']); //halaman memilih jasa pengiriman/shipping
Route::get('/shipping-buynow',[HomeController::class,'shipping_buynow']); //halaman memilih jasa pengiriman/shipping
Route::post('/confirmation',[HomeController::class,'confirmation']); //post transaksi dan detail transaksi
Route::post('/confirmation-buynow',[HomeController::class,'confirmation_buynow']); //post transaksi dan detail transaksi
Route::get('/confirmation',[HomeController::class,'getconfirmation']); //page payment
Route::get('/confirmation/{code_inv}',[HomeController::class,'getconfirmation']); //page payment
Route::get('/confirmation-buynow/{code_inv}',[HomeController::class,'getconfirmation_buynow']); //page payment

Route::post('/select-province',[HomeController::class, 'city']);// menampilkan city sesuai dengan provinsi yang dipilih di page information
Route::post('/select-city',[HomeController::class, 'substrict']);//// menampilkan kecamatan/substrict sesuai dengan city yang dipilih di page information
