<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PassResetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\WishListController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Role;

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



Auth::routes();

//Dashboard
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/welcome', [FrontendController::class, 'welcome'])->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/product/details/{product_slug}', [FrontendController::class, 'product_details'])->name('product.details');
Route::post('/getsize', [FrontendController::class, 'getsize']);
Route::get('/profile', [FrontendController::class, 'profile'])->name('profile1');
Route::post('/account/update', [FrontendController::class, 'account_update']);
Route::get('/order', [FrontendController::class, 'order'])->name('order');

//Profile Edit
Route::get('/profile/edit', [ProfileController::class, 'profile'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'update']);
Route::post('/password/update', [ProfileController::class, 'password_update']);
Route::post('/photo/change', [ProfileController::class, 'photo_change']);

//Role Manager
Route::get('/role/manager', [RoleController::class, 'role_manager'])->name('role');
Route::post('/permission/store', [RoleController::class, 'permission_store']);
Route::post('/role/store', [RoleController::class, 'role_store']);
Route::post('/role/assign', [RoleController::class, 'role_assign'])->name('role.assign');
Route::get('/role/edit/{user_id}', [RoleController::class, 'role_edit'])->name('role.edit');
Route::post('/role/update', [RoleController::class, 'role_update'])->name('role.update');

//Category
Route::get('/category', [CategoryController::class, 'category'])->name('category');
Route::post('/category/insert', [CategoryController::class, 'insert']);
Route::get('/category/delete/{category_id}', [CategoryController::class, 'delete']);
Route::get('/category/edit/{category_id}', [CategoryController::class, 'edit']);
Route::post('/category/update', [CategoryController::class, 'update']);

//Sub Category
Route::get('/subcategory', [SubCategoryController::class, 'index'])->name('subcategory');
Route::post('/subcategory/insert', [SubCategoryController::class, 'insert']);
Route::get('/subcategory/delete/{subcategory_id}', [SubCategoryController::class, 'delete']);
Route::get('/subcategory/edit/{subcategory_id}', [SubCategoryController::class, 'edit']);
Route::post('/subcategory/update', [SubCategoryController::class, 'update']);

//Products
Route::get('/add/product', [ProductController::class, 'index'])->name('add.product');
Route::post('/getsubcategory', [ProductController::class, 'getsubcategory']);
Route::post('/product/insert', [ProductController::class, 'product_insert']);

//Color And Size
Route::get('/color/size', [ProductController::class, 'color_size'])->name('color.size');
Route::post('/color/insert', [ProductController::class, 'color_insert']);
Route::post('/size/insert', [ProductController::class, 'size_insert']);

//Inventory
Route::get('/inventory/{product_id}', [ProductController::class, 'inventory'])->name('inventory');
Route::post('/inventory/insert', [ProductController::class, 'inventory_insert']);

//Customer Login & Register
Route::get('/customer/login/register', [CustomerLoginController::class, 'customer_register_login'])->name('customer');
Route::post('/customer/login', [CustomerLoginController::class, 'customer_login']);
Route::post('/customer/register', [CustomerRegisterController::class, 'customer_register']);
Route::get('/customer/logout', [CustomerLoginController::class, 'customer_logout'])->name('customer.logout');

//Cart
Route::post('cart/insert', [CartController::class, 'cart_insert']);
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::get('cart/delete/{cart_id}', [CartController::class, 'cart_delete'])->name('cart.delete');
Route::post('/cart/update', [CartController::class, 'cart_update']);

//WishList
Route::get('wish-list/{id}', [WishListController::class, 'wishlist_show'])->name('wishlistShow');
Route::get('/wish-list', [WishListController::class, 'wishlist'])->name('wishlist');
Route::get('wishlist/delete/{wishlist_id}', [WishListController::class, 'wishlist_delete'])->name('wishlist.delete');


//Auth Logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//Coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/coupon/insert', [CouponController::class, 'coupon_insert']);

//Checkout
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/getCity', [CheckoutController::class, 'getCity']);
Route::post('/order/insert', [CheckoutController::class, 'order_insert']);
Route::get('/order/success', [CheckoutController::class, 'order_success'])->name('order.success');

// SSLCOMMERZ Start
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

//Stripe
Route::get('stripe', [StripePaymentController::class, 'stripe']);
Route::post('stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');

//Invoice
Route::get('/invoice/download/{invoice_id}', [FrontendController::class, 'invoice_download'])->name('invoice.download');

//Github Login
Route::get('/github/redirect', [GithubController::class, 'RedirectToProvider']);
Route::get('/github/callback', [GithubController::class, 'RedirectToWebsite']);

//Google Login
Route::get('/google/redirect', [GoogleController::class, 'RedirectToProvider']);
Route::get('/google/callback', [GoogleController::class, 'RedirectToWebsite']);

//Facebook Login
Route::get('/facebook/redirect', [FacebookController::class, 'RedirectToProvider']);
Route::get('/facebook/callback', [FacebookController::class, 'RedirectToWebsite']);

//Password Reset
Route::get('/pass/reset', [PassResetController::class, 'pass_reset'])->name('pass.reset');
Route::post('/pass/reset/notification', [PassResetController::class, 'pass_reset_notification']);
Route::get('/pass/reset/form/{reset_token}', [PassResetController::class, 'pass_reset_form'])->name('pass.reset.form');
Route::post('/pass/reset/update', [PassResetController::class, 'pass_reset_update']);

//Review
Route::post('/review/insert', [FrontendController::class, 'review_insert']);

//Email Verify
Route::get('/customer/email/verify/{verify_token}', [ProfileController::class, 'email_verity']);
Route::get('/verify/email/success', [ProfileController::class, 'email_verity_success']);

//Search Product
Route::get('/product-list', [SearchController::class, 'productlistAjax']);
Route::post('searchproduct', [SearchController::class, 'searchProduct']);
