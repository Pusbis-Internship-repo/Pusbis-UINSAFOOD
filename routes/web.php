<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\SellerMenuController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
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


Route::middleware(['guest'])->group(function(){

    ////////// Guest View Controller //////////
    Route::get('/',[HomeController::class, 'index'])->name('homepage');
    Route::get('/menu',[HomeController::class, 'menu'])->name('menu');
    Route::get('/tentangkami',[HomeController::class, 'about'])->name('about');
    Route::get('/kontak',[HomeController::class, 'contact'])->name('contact');
    Route::get('/filter-menu', [HomeController::class, 'filterMenu'])->name('filter.menu');
    Route::get('/forgot-password', [HomeController::class, 'forgot_password'])->name('forgot.password');
    Route::post('/forgot-password-act', [HomeController::class, 'forgot_password_act'])->name('forgot.password.act');
    Route::get('/reset-password/{token}', [HomeController::class, 'reset_password'])->name('reset.password');
    Route::post('/reset-password-act', [HomeController::class, 'resetpasswordact'])->name('reset.password.act');


    ////////// Guest Login & Regis Controller //////////
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/reg', [AuthController::class, 'create'])->name('registrasi');
    Route::post('/reg', [AuthController::class, 'register']);
    Route::get('/verify/{verify_key}', [AuthController::class, 'verify']);
});

Route::middleware(['auth'])->group(function(){
    // to_route('login');
    ////////// User View Controller //////////
    Route::redirect('/home', '/user');
    Route::get('/menu_user',[UserController::class, 'menu_user'])->name('menu_user')->middleware('userAkses:user');
    Route::get('/tentangkami_user',[UserController::class, 'about_user'])->name('about_user')->middleware('userAkses:user');
    Route::get('/kontak_user',[UserController::class, 'contact_user'])->name('contact_user')->middleware('userAkses:user');
    Route::get('/filter_menu_user',[UserController::class, 'filterMenu_user'])->name('filter.menu.user')->middleware('userAkses:user');
    Route::get('/history_order',[UserController::class, 'history_order'])->name('history_order')->middleware('userAkses:user');
    Route::get('/user/invoice/{id_pesanan}', [UserController::class, 'invoice'])->name('user_invoice')->middleware('userAkses:user');
    Route::get('generate-pdf/{id_pesanan}', [UserController::class, 'generateinvoice'])->name('download')->middleware('userAkses:user');
    Route::post('/add-rating-review/{id_pesanan}', [UserController::class, 'addRatingReview'])->name('add.rating.review')->middleware('userAkses:user');

    ////////// User EDIT //////////
    Route::get('/editprofile',[UserController::class, 'editprofile'])->name('editprofile')->middleware('userAkses:user');
    Route::put('/updateprofile',[UserController::class, 'updateprofile'])->name('updateprofile')->middleware('userAkses:user');
    Route::get('/editpassword',[UserController::class, 'editpassword'])->name('editpassword')->middleware('userAkses:user');
    Route::post('/changepassword',[UserController::class, 'updatepassword'])->name('changepassword')->middleware('userAkses:user');

    ////////// User Cart Controller //////////
    Route::get('/shopping-cart', [UserController::class, 'menuOrder'])->name('shopping.order')->middleware('userAkses:user');
    Route::get('/menu/{id}', [UserController::class, 'addMenutoOrder'])->name('addMenu.to.order')->middleware('userAkses:user');
    Route::patch('/update-shopping-cart', [UserController::class, 'updateOrder'])->name('update.sopping.order')->middleware('userAkses:user');
    Route::delete('/delete-cart-menu', [UserController::class, 'deleteMenu'])->name('delete.cart.menu')->middleware('userAkses:user');


    ////////// User Order Controller //////////
    Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout')->middleware('userAkses:user');
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order')->middleware('userAkses:user');


    ////////// User Order & Logout Controller //////////
    Route::get('/user', [UserController::class, 'index'])->name('user')->middleware('userAkses:user');
    Route::get('/user/order', [UserController::class, 'order_page'])->name('order_page')->middleware('userAkses:user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    ////////// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //////////

    ////////// Admin Controller //////////
    Route::get('/admin', [AdminController::class, 'index'])->name('admin')->middleware('userAkses:admin');
    Route::get('/admin/orders', [AdminOrderController::class, 'groupDataByCreatedAt'])->name('admin.orders')->middleware('userAkses:admin');
    Route::get('/admin/history', [AdminOrderController::class, 'history_order'])->name('admin.history')->middleware('userAkses:admin');
    Route::get('/admin/invoice/{id_pesanan}', [AdminOrderController::class, 'admin_invoice'])->name('admin_invoice')->middleware('userAkses:admin');
    Route::put('/admin/orders/{id_pesanan}/setuju', [AdminOrderController::class, 'accept'])->name('setuju')->middleware('userAkses:admin');
    Route::put('/admin/orders/{id_pesanan}/tolak', [AdminOrderController::class, 'reject'])->name('tolak')->middleware('userAkses:admin');

    ////////// Admin Seller Controller //////////
    Route::get('/dataseller', [AdminController::class, 'seller'])->name('dataseller')->middleware('userAkses:admin');
    Route::get('/createseller', [AdminController::class, 'sellercreate'])->name('createseller')->middleware('userAkses:admin');
    Route::post('/storeseller', [AdminController::class, 'storeseller'])->name('storeseller')->middleware('userAkses:admin');
    Route::get('dataseller/deleteseller/{id}', [AdminController::class, 'deleteseller'])->name('deleteseller')->middleware('userAkses:admin');
    Route::get('dataseller/{id}/editdataseller', [AdminController::class, 'editpenjual'])->name('edit.seller')->middleware('userAkses:admin');
    Route::put('{id}/updatedataseller', [AdminController::class, 'updateseller'])->name('update.seller')->middleware('userAkses:admin');


    Route::get('/datauser', [AdminController::class, 'pengguna'])->name('data.pengguna')->middleware('userAkses:admin');
    Route::get('/createuser', [AdminController::class, 'createpengguna'])->name('createuser')->middleware('userAkses:admin');
    Route::post('/storeuser', [AdminController::class, 'storepengguna'])->name('storeuser')->middleware('userAkses:admin');
    Route::get('/datauser/{id}/edituser', [AdminController::class, 'editpengguna'])->name('edit.data.pengguna')->middleware('userAkses:admin');
    Route::put('{id}/updatedatauser', [AdminController::class, 'updatepengguna'])->name('update.pengguna')->middleware('userAkses:admin');
    Route::get('datauser/deleteuser/{id}', [AdminController::class, 'deleteuser'])->name('deleteuser')->middleware('userAkses:admin');


    ////////// Admin Kategori Controller //////////
    Route::get('/datakategori', [CategoryController::class, 'data_kategori'])->name('datakategori')->middleware('userAkses:admin');
    Route::get('/createcategory', [CategoryController::class, 'create_category'])->name('createcategory')->middleware('userAkses:admin');
    Route::post('/categories', [CategoryController::class, 'store_category'])->name('categories')->middleware('userAkses:admin');
    Route::get('datakategori/{id}/editcategory', [CategoryController::class, 'edit_category'])->name('editcategory')->middleware('userAkses:admin');
    Route::put('{id}/updatecategory', [CategoryController::class, 'category_update'])->name('updatecategory')->middleware('userAkses:admin');
    Route::get('datakategori/{id}/deletecategory', [CategoryController::class, 'category_delete'])->name('deletecategory')->middleware('userAkses:admin');


    ////////// Admin Menu Controller //////////
    Route::get('/datamenu', [MenuController::class, 'data_menu'])->name('datamenu')->middleware('userAkses:admin');
    Route::get('/createmenu', [MenuController::class, 'create_menu'])->name('createmenu')->middleware('userAkses:admin');
    Route::post('/menus', [MenuController::class, 'store_menu'])->name('menus')->middleware('userAkses:admin');
    Route::get('datamenu/{id}/editmenu', [MenuController::class, 'edit_menu'])->name('editmenu')->middleware('userAkses:admin');
    Route::put('{id}/updatemenu', [MenuController::class, 'menu_update'])->name('updatemenu')->middleware('userAkses:admin');
    Route::get('datamenu/{id}/deletemenu', [MenuController::class, 'menu_delete'])->name('deletemenu')->middleware('userAkses:admin');



    ////////// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //////////

    ////////// Seller Controller //////////
    Route::get('/seller', [SellerController::class, 'index'])->name('seller')->middleware('userAkses:seller');
    Route::get('/datamenuseller', [SellerMenuController::class, 'data_menu_seller'])->name('data_menu_seller')->middleware('userAkses:seller');
    Route::get('/createmenuseller', [SellerMenuController::class, 'create_menu'])->name('createmenuseller')->middleware('userAkses:seller');
    Route::post('/menusseller', [SellerMenuController::class, 'store_menu'])->name('menusseller')->middleware('userAkses:seller');
    Route::get('datamenu/{id}/editmenuseller', [SellerMenuController::class, 'edit_menu'])->name('editmenuseller')->middleware('userAkses:seller');
    Route::put('{id}/updatemenuseller', [SellerMenuController::class, 'menu_update'])->name('updatemenuseller')->middleware('userAkses:seller');
    Route::get('datamenu/{id}/deletemenuseller', [SellerMenuController::class, 'menu_delete'])->name('deletemenuseller')->middleware('userAkses:seller');

    ////////// Seller Profile //////////
    Route::get('/selleredit', [SellerController::class, 'selleredit'])->name('selleredit')->middleware('userAkses:seller');
    Route::put('/updateseller', [SellerController::class, 'updateprofileseller'])->name('updateseller')->middleware('userAkses:seller');
    Route::get('/editpwseller', [SellerController::class, 'editpasswordseller'])->name('editpwseller')->middleware('userAkses:seller');
    Route::post('/updatepwseller', [SellerController::class, 'updatepasswordseller'])->name('updatepwseller')->middleware('userAkses:seller');

    Route::get('seller/orders', [SellerController::class, 'seller_order'])->name('seller.orders')->middleware('userAkses:seller');
    Route::get('/seller/invoice/{id_pesanan}', [SellerController::class, 'seller_invoice'])->name('seller.invoice')->middleware('userAkses:seller');
});
