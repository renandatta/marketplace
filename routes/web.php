<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('image/{folder}/{filename}', function ($folder,$filename){
    $path = storage_path('app/' . $folder . '/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

/// =============== auth
Route::get('login', 'AuthController@login')->name('login');
Route::post('login', 'AuthController@login_process')->name('login.process');
Route::get('register', 'AuthController@register')->name('register');
Route::post('register', 'AuthController@register_process')->name('register.process');
Route::get('logout', 'AuthController@logout')->name('logout');

/// =============== home
Route::get('/', 'HomeController@index')->name('/');
Route::post('search', 'HomeController@search_post')->name('search.post');
Route::get('products', 'HomeController@products')->name('products');
Route::get('category/{slug}', 'HomeController@category')->name('category');
Route::get('product/{slug}', 'HomeController@product')->name('product');
Route::get('store/{slug}', 'HomeController@store')->name('store');

/// =============== transaction
Route::get('cart', 'HomeController@cart')->name('cart');
Route::get('cart/search', 'HomeController@cart_search')->name('cart.search');
Route::post('cart/save', 'HomeController@cart_save')->name('cart.save');
Route::post('cart/update', 'HomeController@cart_update')->name('cart.update');
Route::post('cart/delete', 'HomeController@cart_delete')->name('cart.delete');

Route::get('wishlist', 'HomeController@wishlist')->name('wishlist');
Route::get('wishlist/search', 'HomeController@wishlist_search')->name('wishlist.search');
Route::post('wishlist/save', 'HomeController@wishlist_save')->name('wishlist.save');
Route::post('wishlist/delete', 'HomeController@wishlist_delete')->name('wishlist.delete');

Route::post('recent_purchases', 'UserController@recent_purchases')->name('recent_purchases');

Route::get('order/detail', 'HomeController@order_detail')->name('order.detail');

Route::post('shipping/cost', 'HomeController@shipping_cost')->name('shipping.cost');
Route::post('checkout', 'HomeController@checkout_save')->name('checkout.save');
Route::get('checkout', 'HomeController@checkout')->name('checkout');
Route::post('payment', 'HomeController@payment_save')->name('payment.save');
Route::get('payment_receipt', 'HomeController@payment_receipt')->name('payment_receipt');
Route::post('payment_receipt', 'HomeController@payment_receipt_save')->name('payment_receipt.save');

/// =============== user
Route::get('user', 'UserController@dashboard')->name('user');
Route::get('user/dashboard', 'UserController@dashboard')->name('user.dashboard');
Route::get('user/edit_profile', 'UserController@edit_profile')->name('user.edit_profile');
Route::get('user/change_password', 'UserController@change_password')->name('user.change_password');
Route::get('user/order_history', 'UserController@order_history')->name('user.order_history');
Route::get('user/address', 'UserController@address')->name('user.address');

Route::post('user/save_profile', 'UserController@save_profile')->name('user.save_profile');
Route::post('user/save_password', 'UserController@save_password')->name('user.save_password');
Route::post('user/address', 'UserController@address')->name('user.address');
Route::get('user/address/new', 'UserController@address_new')->name('user.address.new');
Route::get('user/address/edit', 'UserController@address_edit')->name('user.address.edit');
Route::post('user/address/save', 'UserController@address_save')->name('user.address.save');
Route::post('user/address/default', 'UserController@address_default')->name('user.address.default');
Route::delete('user/address/delete', 'UserController@address_delete')->name('user.address.delete');
Route::post('user/city/search', 'UserController@city_search')->name('user.city.search');
Route::get('user/store', 'UserController@store')->name('user.store');
Route::get('user/store/transaction/detail', 'UserController@transaction_detail')->name('user.store.transaction.detail');
Route::post('user/store/shipping/save', 'UserController@shipping_save')->name('user.store.shipping.save');


/// =============== admin page
Route::get('management', 'ManagementController@index')->name('management');

Route::get('management/user', 'ManagementUserController@index')->name('management.user');
Route::post('management/user/search', 'ManagementUserController@search')->name('management.user.search');
Route::get('management/user/info', 'ManagementUserController@info')->name('management.user.info');
Route::post('management/user/save', 'ManagementUserController@save')->name('management.user.save');
Route::post('management/user/delete', 'ManagementUserController@delete')->name('management.user.delete');

Route::get('management/payment_type', 'ManagementPaymentTypeController@index')->name('management.payment_type');
Route::post('management/payment_type/search', 'ManagementPaymentTypeController@search')->name('management.payment_type.search');
Route::get('management/payment_type/info', 'ManagementPaymentTypeController@info')->name('management.payment_type.info');
Route::post('management/payment_type/save', 'ManagementPaymentTypeController@save')->name('management.payment_type.save');
Route::post('management/payment_type/delete', 'ManagementPaymentTypeController@delete')->name('management.payment_type.delete');

Route::get('management/courier', 'ManagementCourierController@index')->name('management.courier');
Route::post('management/courier/search', 'ManagementCourierController@search')->name('management.courier.search');
Route::get('management/courier/info', 'ManagementCourierController@info')->name('management.courier.info');
Route::post('management/courier/save', 'ManagementCourierController@save')->name('management.courier.save');
Route::post('management/courier/delete', 'ManagementCourierController@delete')->name('management.courier.delete');

Route::get('management/courier/service', 'ManagementCourierServiceController@index')->name('management.courier.service');
Route::post('management/courier/service/search', 'ManagementCourierServiceController@search')->name('management.courier.service.search');
Route::get('management/courier/service/info', 'ManagementCourierServiceController@info')->name('management.courier.service.info');
Route::post('management/courier/service/save', 'ManagementCourierServiceController@save')->name('management.courier.service.save');
Route::post('management/courier/service/delete', 'ManagementCourierServiceController@delete')->name('management.courier.service.delete');

Route::get('management/store', 'ManagementStoreController@index')->name('management.store');
Route::post('management/store/search', 'ManagementStoreController@search')->name('management.store.search');
Route::get('management/store/info', 'ManagementStoreController@info')->name('management.store.info');
Route::post('management/store/save', 'ManagementStoreController@save')->name('management.store.save');
Route::post('management/store/delete', 'ManagementStoreController@delete')->name('management.store.delete');

Route::get('management/store/user', 'ManagementUserController@index')->name('management.store.user');
Route::post('management/store/user/search', 'ManagementUserController@search')->name('management.store.user.search');
Route::get('management/store/user/info', 'ManagementUserController@info')->name('management.store.user.info');
Route::post('management/store/user/save', 'ManagementUserController@save')->name('management.store.user.save');
Route::post('management/store/user/delete', 'ManagementUserController@delete')->name('management.store.user.delete');

Route::get('management/store/product', 'ManagementProductController@index')->name('management.store.product');
Route::post('management/store/product/search', 'ManagementProductController@search')->name('management.store.product.search');
Route::get('management/store/product/info', 'ManagementProductController@info')->name('management.store.product.info');
Route::post('management/store/product/save', 'ManagementProductController@save')->name('management.store.product.save');
Route::post('management/store/product/delete', 'ManagementProductController@delete')->name('management.store.product.delete');

Route::get('management/store/product/image', 'ManagementProductImageController@index')->name('management.store.product.image');
Route::post('management/store/product/image/search', 'ManagementProductImageController@search')->name('management.store.product.image.search');
Route::post('management/store/product/image/save', 'ManagementProductImageController@save')->name('management.store.product.image.save');
Route::post('management/store/product/image/delete', 'ManagementProductImageController@delete')->name('management.store.product.image.delete');

Route::get('management/slider', 'ManagementSliderController@index')->name('management.slider');
Route::post('management/slider/search', 'ManagementSliderController@search')->name('management.slider.search');
Route::get('management/slider/info', 'ManagementSliderController@info')->name('management.slider.info');
Route::post('management/slider/save', 'ManagementSliderController@save')->name('management.slider.save');
Route::post('management/slider/delete', 'ManagementSliderController@delete')->name('management.slider.delete');

Route::get('management/featured', 'ManagementFeaturedController@index')->name('management.featured');
Route::post('management/featured/search', 'ManagementFeaturedController@search')->name('management.featured.search');
Route::get('management/featured/info', 'ManagementFeaturedController@info')->name('management.featured.info');
Route::post('management/featured/save', 'ManagementFeaturedController@save')->name('management.featured.save');
Route::post('management/featured/delete', 'ManagementFeaturedController@delete')->name('management.featured.delete');
Route::post('management/featured/save_detail', 'ManagementFeaturedController@save_detail')->name('management.featured.save_detail');

Route::get('management/featured/detail', 'ManagementFeaturedDetailController@index')->name('management.featured.detail');
Route::post('management/featured/detail/search', 'ManagementFeaturedDetailController@search')->name('management.featured.detail.search');
Route::get('management/featured/detail/info', 'ManagementFeaturedDetailController@info')->name('management.featured.detail.info');
Route::post('management/featured/detail/save', 'ManagementFeaturedDetailController@save')->name('management.featured.detail.save');
Route::post('management/featured/detail/delete', 'ManagementFeaturedDetailController@delete')->name('management.featured.detail.delete');

Route::get('management/transaction', 'ManagementTransactionController@index')->name('management.transaction');
Route::post('management/transaction/detail/search', 'ManagementTransactionController@search')->name('management.transaction.search');
Route::get('management/transaction/detail', 'ManagementTransactionController@detail')->name('management.transaction.detail');
Route::post('management/transaction/payment/verify', 'ManagementTransactionController@payment_verify')->name('management.transaction.payment.verify');
Route::post('management/transaction/payment/reject', 'ManagementTransactionController@payment_reject')->name('management.transaction.payment.reject');
