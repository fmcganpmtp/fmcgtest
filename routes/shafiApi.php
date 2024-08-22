<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth.api'])->group(function () {
    Route::post('address/create', 'CustomerAPIController@addressCreate')->name('address.create');

    Route::post('address/list', 'CustomerAPIController@addressList')->name('address.list');
    Route::post('address/edit/{address}', 'CustomerAPIController@addressEdit')->name('address.edit');
    Route::post('address/update/{address}', 'CustomerAPIController@addressUpdate')->name('address.update');
    Route::post('address/destroy/{address}', 'CustomerAPIController@addressDestroy')->name('address.destroy');
    Route::post('address/select', 'CustomerAPIController@addressSelect')->name('address.select');

    //Vendor
    Route::post('vendor/contact-information', 'VendorAPI2Controller@contactInformation')->name('vendor.contactinformation');
    Route::post('vendor/contact-information-update', 'VendorAPI2Controller@contactInformationUpdate')->name('vendor.contactinformation.update');

    Route::post('vendor/store-location', 'VendorAPI2Controller@storeLocation')->name('vendor.storelocation');
    Route::post('vendor/store-location-update', 'VendorAPI2Controller@storeLocationUpdate')->name('vendor.storelocation.update');

    Route::post('vendor/delivery-details', 'VendorAPI2Controller@deliveryDetails')->name('delivery.details');
    Route::post('vendor/delivery-details-update', 'VendorAPI2Controller@deliveryDetailsUpdate')->name('delivery.details.update');

});
Route::prefix('customer')->group(function () {

    Route::post('home', 'CustomerAPIController@home')->name('home');
    Route::post('category-stores', 'CustomerAPIController@storeList')->name('stores.list');
    Route::post('product-details', 'CustomerAPIController@productDetails')->name('view.product');
    Route::post('store-products', 'CustomerAPIController@vendorProducts')->name('store.products');
    Route::post('search-keyword', 'CustomerAPIController@searchKeyword')->name('search.keyword');
    Route::post('vendor-products-pagination', 'CustomerAPIController@vendorProductPagination')->name('store.products');
    Route::post('vendor-menus', 'CustomerAPIController@vendormenus')->name('vendor.menus');
    Route::post('offer-products', 'CustomerAPIController@offerProducts')->name('offer.products');
    Route::post('app-version', 'CustomerAPIController@getAppVersion')->name('app.version');


});

Route::middleware(['auth.api'])->prefix('customer')->group(function () {
    Route::post('product-varients', 'CustomerAPIController@productVarients')->name('vendor.menus');
    Route::post('addtocart', 'CustomerAPIController@addtoCart')->name('product.addtocart');
    Route::post('cart-view', 'CustomerAPIController@showCart')->name('product.cart');
    Route::post('cart-clear', 'CustomerAPIController@clear_cart')->name('cart.clear');
    Route::post('coupon-list', 'CustomerAPIController@couponList')->name('coupon.list');
    Route::post('apply-coupon', 'CustomerAPIController@applyCoupon')->name('coupon.apply');
    Route::post('place-order', 'CustomerAPIController@placeorder')->name('order.place');
    Route::post('confirm-order', 'CustomerAPIController@confirmOrder')->name('order.confirm');
    Route::post('cancel-order', 'CustomerAPIController@cancelOrder')->name('order.cancel');
    Route::post('reorder', 'CustomerAPIController@reOrder')->name('reorder.place');
    Route::post('order/check-expiry', 'CustomerAPIController@checkOrderExpiry')->name('order.expiry');
    Route::post('order-history', 'CustomerAPIController@orderHistory')->name('order.history');
    Route::post('support', 'CustomerAPIController@customerSupport')->name('customer.support');
    Route::post('profile-details', 'CustomerAPIController@profileDetails')->name('profile.view');
    Route::post('profile-update', 'CustomerAPIController@profile_update')->name('profile.update');
    Route::post('order-details', 'CustomerAPIController@orderDetails')->name('order.details');
    Route::post('notifications', 'CustomerAPIController@notifications')->name('user.notifications');
    Route::post('minimalcart', 'CustomerAPIController@MinimalCart')->name('user.minimal.cart');
    Route::post('general-coupon', 'CustomerAPIController@generalCoupon')->name('general.coupon.check');
    Route::post('store-profile', 'CustomerAPIController@storeProfile')->name('storeProfile');

});
