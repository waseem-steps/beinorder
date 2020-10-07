<?php

use Illuminate\Support\Facades\Route;


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

Route::get('/', 'RestaurantController@getActive')->name('welcome');

Route::get('/dummy', 'RestaurantController@dummy')->name('dummy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/submenu-add/add', 'SubmenuController@store')->name('submenu.store');
Route::get('/submenu/{id}', 'SubmenuController@index')->name('submenu.index');
Route::get('/submenu/delete/{id}', 'SubmenuController@delete')->name('submenu.delete');

Route::post('/submenu_item/add', 'SubmenuItemController@store')->name('submenu-item.store');
Route::get('/submenu_item/delete/{id}', 'SubmenuItemController@delete')->name('submenu-item.delete');

Route::get('/countries', 'CountryController@index')->name('countries.index');
Route::post('/country/store', 'CountryController@store')->name('country.store');
Route::get('/country/delete/{id}', 'CountryController@delete')->name('country.delete');

Route::get('/product-types', 'ProductTypeController@index')->name('product-types.index');
Route::post('/product-types/store', 'ProductTypeController@store')->name('product-type.store');
Route::get('/product-types/delete/{id}', 'ProductTypeController@delete')->name('product-type.delete');

Route::get('/product-categories', 'ProductCategoryController@index')->name('product-categories.index');
Route::get('/product-category/create', 'ProductCategoryController@create')->name('product-categories.create');
Route::get('/product-categories/{id}', 'ProductCategoryController@getRestCats')->name('product-categories.rest-cat');
Route::get('/product-categories/table/{id}', 'ProductCategoryController@getRestCatsTable')->name('product-categories.rest-cat-table');
Route::post('/product-categories/store{id}', 'ProductCategoryController@store')->name('product-category.store');
Route::get('/product-categories/delete/{id}', 'ProductCategoryController@delete')->name('product-category.delete');
Route::get('/product-categories/edit/{id}', 'ProductCategoryController@edit')->name('product-category.edit');
Route::post('/product-categories/update/{id}', 'ProductCategoryController@update')->name('product-category.update');
Route::post('/product-category/upload_cat', 'ProductCategoryController@upload_cat')->name('upload_cat');
Route::post('/product-category/upload_cat_thumbnail', 'ProductCategoryController@upload_cat_thumbnail')->name('upload_cat_thumbnail');
Route::post('/product-category/upload_cat_edit', 'ProductCategoryController@upload_cat_edit')->name('upload_cat_edit');

Route::POST('/branch/add', 'BranchController@store')->name('branch.store');
Route::get('/branches/{id}', 'BranchController@index')->name('branches.index');
Route::get('/branch/delete/{id}', 'BranchController@delete')->name('branch.delete');
Route::get('/branch/edit/{id}', 'BranchController@edit')->name('branch.edit');
Route::post('/branch/update/{id}', 'BranchController@update')->name('branch.update');
Route::get('/branch/lock/{id}', 'BranchController@lock')->name('branch.lock');
Route::get('/branch/unlock/{id}', 'BranchController@unlock')->name('branch.unlock');
Route::get('/branch/qrcode/{id}', 'BranchController@generateQrExternal')->name('branch.qrcode');
Route::get('/branch/external/qrcode/{id}', 'ProductCategoryController@branchCategories')->name('branch.details');
Route::post('/branches/select/{id}', 'BranchController@select_branch')->name('branch.store_branch');
Route::get('/branch/admin/edit/{id}', 'BranchController@adminEdit')->name('branch-admin.edit');
Route::post('/branch/admin/update/{id}', 'BranchController@adminUpdate')->name('branch-admin.update');
Route::get('/branch/admin/delete/{id}', 'BranchController@adminDelete')->name('branch-admin.delete');

Route::get('/products', 'ProductController@all')->name('products.all');
Route::get('/product/create', 'ProductController@create')->name('product.create');
Route::get('/products/{id}', 'ProductController@index')->name('products.index');
Route::get('/products/table/{id}', 'ProductController@index_table')->name('products.table-index');
Route::post('/product/store', 'ProductController@store')->name('product.store');
Route::get('/product/delete/{id}', 'ProductController@delete')->name('product.delete');
Route::get('/product/edit/{id}', 'ProductController@edit')->name('product.edit');
Route::post('/product/update/{id}', 'ProductController@update')->name('product.update');
Route::get('/product/details/table/{id}', 'ProductController@details_table')->name('product.details-table');
Route::get('/product/details/{id}', 'ProductController@details')->name('product.details');
Route::get('/product/lock/{id}', 'ProductController@lock')->name('product.lock');
Route::get('/product/unlock/{id}', 'ProductController@unlock')->name('product.unlock');
Route::post('/product/upload_product', 'ProductController@upload_product')->name('upload_product');
Route::post('/product/upload_product_thumbnail', 'ProductController@upload_product_thumbnail')->name('upload_product_thumbnail');
Route::post('/product/upload_product_edit', 'ProductController@upload_product_edit')->name('upload_product_edit');

Route::post('/productsize/store', 'ProductSizeController@store')->name('product_size.store');
Route::get('/productsizes/{id}', 'ProductSizeController@index')->name('product_sizes.index');
Route::get('/productsize/delete/{id}', 'ProductSizeController@delete')->name('product_size.delete');
Route::get('/productsize/edit/{id}', 'ProductSizeController@edit')->name('product_size.edit');
Route::post('/productsize/update/{id}', 'ProductSizeController@update')->name('product_size.update');

Route::get('/restaurants', 'RestaurantController@index')->name('restaurants.index');
Route::get('/restaurant/create', 'RestaurantController@create')->name('restaurant.create');
Route::post('/restaurant/store', 'RestaurantController@store')->name('restaurant.store');
Route::get('/restaurant/delete/{id}', 'RestaurantController@delete')->name('restaurant.delete');
Route::get('/restaurant/edit/{id}', 'RestaurantController@edit')->name('restaurant.edit');
Route::post('/restaurant/update/{id}', 'RestaurantController@update')->name('restaurant.update');
Route::get('/restaurant/lock/{id}', 'RestaurantController@lock')->name('restaurant.lock');
Route::get('/restaurant/unlock/{id}', 'RestaurantController@unlock')->name('restaurant.unlock');
Route::get('/restaurant/details/{id}', 'RestaurantController@details')->name('restaurant.details');
Route::get('/restaurant/qrcode/{rest_id}/{table_id}', 'RestaurantController@generateQrExternal')->name('restaurant.qrcode');
Route::get('/restaurants/all', 'RestaurantController@getActive')->name('restaurants.active');
Route::get('/restaurants/search', 'RestaurantController@getActiveByName')->name('restaurants.search');
Route::get('/restaurant/admins/{id}', 'RestaurantController@getAdmins')->name('branch.admins');
Route::get('/restaurants/crop', 'RestaurantController@crop')->name('crop');
Route::post('restaurant/upload_rest', 'RestaurantController@upload_rest')->name('upload_rest');
Route::post('restaurant/upload_rest_thumbnail', 'RestaurantController@upload_rest_thumbnail')->name('upload_rest_thumbnail');
Route::post('restaurant/upload_rest_edit', 'RestaurantController@upload_rest_edit')->name('upload_rest_edit');
Route::get('restaurant/admin_settings/{id}', 'RestaurantController@change_admin_settings')->name('restaurant.admin_settings');
Route::get('/restaurant/enable_place_order/{id}', 'RestaurantController@enable_place_order')->name('restaurant.enable_place_order');
Route::get('/restaurant/disable_place_order/{id}', 'RestaurantController@disable_place_order')->name('restaurant.disable_place_order');
Route::get('/restaurant/enable_table_code/{id}', 'RestaurantController@enable_table_code')->name('restaurant.enable_table_code');
Route::get('/restaurant/disable_table_code/{id}', 'RestaurantController@disable_table_code')->name('restaurant.disable_table_code');

Route::get('/plans', 'PricePlanController@index')->name('plans.index');
Route::get('/plans/internal', 'PricePlanController@index_internal')->name('plans.index_internal');
Route::post('/plan/add', 'PricePlanController@store')->name('plan.store');
Route::get('/plan/toggle/{id}', 'PricePlanController@toggle_lock')->name('plan.toggle-status');
Route::get('/plan/upgrade/{id}', 'PricePlanController@updgradePlan')->name('upgrade.plan');
Route::get('/plan/change/{id}/{rest_id}', 'PricePlanController@change')->name('plan.change');
Route::get('plan/switch', 'PricePlanController@switch')->name('plans.switch');

//Route::get('/payment/pay','PaymentController@pay');

Route::get('/orderdetails/{id}', 'OrderDetailController@index')->name('order_details.index');
Route::get('/orderdetails/delete/{id}', 'OrderDetailController@delete')->name('order_details.delete');
Route::get('/addOrder', 'OrderDetailController@store')->name('order_details.store');
Route::get('/createOrder', 'OrderDetailController@create')->name('order_details.create');
Route::post('/newOrder', 'OrderDetailController@new_order')->name('order_details.new_order');

Route::get('/orders', 'OrderController@index')->name('orders.index');
Route::get('/orders/table', 'OrderController@index_table')->name('orders.index-table');
Route::get('/orders/table-orders', 'OrderController@table_orders')->name('orders.table-orders');
Route::get('/order/checkout/{id}', 'OrderController@checkout')->name('order.checkout');
Route::post('/order/add', 'OrderController@store')->name('order.store');
Route::get('/order/confrim/{id}', 'OrderController@confirm')->name('order.confirm');
Route::get('/order/done/{id}', 'OrderController@done')->name('order.checkout');
Route::get('/order/print/{id}', 'OrderController@print')->name('order.print');
Route::get('/order/printInternalOrder/{id}', 'OrderController@printInternalOrder')->name('order.printInternalOrder');
Route::get('/order/printInternalTable/{id}', 'OrderController@printInternalTable')->name('order.printInternalTable');

Route::get('/orders/history-orders', 'OrderHistoryController@history_orders')->name('orders.history-orders');
Route::get('/orderHistory/printInternalTable/{id}', 'OrderHistoryController@printInternalTable')->name('orderHistory.printInternalTable');

Route::get('/test', 'RestaurantController@test')->name('test');

Route::get('/cart/add', 'CartController@store')->name('cart.store');
Route::get('/cart-product/add', 'CartController@store_product_cart')->name('product_cart.store');
Route::get('/store-cart/add', 'CartController@store_cart')->name('store_cart.store');
Route::get('/cart/active', 'CartController@getActiveCart')->name('cart.active-cart');
Route::get('/cart/checkout', 'CartController@checkout')->name('cart.checkout');
Route::get('/cart/final', 'CartController@finalConfirm')->name('cart.final_confirm');
Route::get('/cart/table/checkout', 'CartController@checkout_table')->name('cart.checkout-table');
Route::get('/cart/table/final', 'CartController@finalConfirm_table')->name('cart.final_confirm-table');
Route::get('/cart/delete/{product_id}/{description}', 'CartController@delete')->name('cart.delete');

Route::post('/subscribe/add', 'SubscriptionController@store')->name('subscription.store');
Route::get('/subscribe/pending', 'SubscriptionController@pending')->name('subs.pending');
Route::get('/subscribe/{id}', 'SubscriptionController@subscribe')->name('plan.subscribe');
Route::get('/subscriber-activate/{id}/{rest_id}', 'PricePlanController@activateUpgrade')->name('plan.activate');


Route::get('/image-cropper', 'ImageCropperController@index');
Route::post('/image-cropper/upload', 'ImageCropperController@upload')->name('upload');
Route::post('/image-cropper/upload_rest', 'ImageCropperController@upload_rest')->name('upload_rest');
Route::post('/image-cropper/upload_rest_edit', 'ImageCropperController@upload_rest_edit')->name('upload_rest_edit');
Route::post('/image-cropper/upload_cat', 'ImageCropperController@upload_cat')->name('upload_cat');
Route::post('/image-cropper/upload_cat_edit', 'ImageCropperController@upload_cat_edit')->name('upload_cat_edit');
Route::post('/image-cropper/upload_product', 'ImageCropperController@upload_product')->name('upload_product');
Route::post('/image-cropper/upload_product_edit', 'ImageCropperController@upload_product_edit')->name('upload_product_edit');
Route::post('/image-cropper/upload_subscribe', 'ImageCropperController@upload_subs')->name('upload_subscribe');

Route::get('tables/rest/{id}', 'TableController@index')->name('table.index');
Route::get('table/delete/{id}', 'TableController@delete')->name('table.delete');
Route::post('table/store', 'TableController@store')->name('table.store');
Route::get('table/validate', 'TableController@validate_table')->name('table.validate');
Route::get('table/valid', 'TableController@valid')->name('table.valid');


Route::get('/rest/internal/qrcode/{rest_id}/{table_id}', 'TableController@table_code')->name('table.table_code');
Route::get('/table/product-categories', 'ProductCategoryController@tableCategories')->name('table.product-categories');
Route::get('/table/product-categories/cart', 'ProductCategoryController@tableCategories1')->name('table.product-categories-cart');
Route::get('/table/close/{id}', 'TableController@closeTable')->name('table.close');

Route::get('notify', 'NotificationController@notify');
Route::view('/notification', 'notification');



//----------- Arabic Routes

Route::get('/', 'RestaurantController@getActive_ar')->name('welcome-ar');

Route::get('/ar/dummy', 'RestaurantController@dummy_ar')->name('dummy-ar');

Route::get('/ar/home', 'HomeController@index_ar')->name('home-ar');

Route::post('/ar/submenu-add/add', 'SubmenuController@store_ar')->name('submenu.store-ar');
Route::get('/ar/submenu/{id}', 'SubmenuController@index_ar')->name('submenu.index-ar');
Route::get('/ar/submenu/delete/{id}', 'SubmenuController@delete_ar')->name('submenu.delete-ar');

Route::post('/ar/submenu_item/add', 'SubmenuItemController@store_ar')->name('submenu-item.store-ar');
Route::get('/ar/submenu_item/delete/{id}', 'SubmenuItemController@delete_ar')->name('submenu-item.delete-ar');

Route::get('/ar/countries', 'CountryController@index_ar')->name('countries.index-ar');
Route::post('/ar/country/store', 'CountryController@store_ar')->name('country.store-ar');
Route::get('/ar/country/delete/{id}', 'CountryController@delete_ar')->name('country.delete-ar');

Route::get('/ar/product-types', 'ProductTypeController@index_ar')->name('product-types.index-ar');
Route::post('/ar/product-types/store', 'ProductTypeController@store_ar')->name('product-type.store-ar');
Route::get('/ar/product-types/delete/{id}', 'ProductTypeController@delete_ar')->name('product-type.delete-ar');

Route::get('/ar/product-categories', 'ProductCategoryController@index_ar')->name('product-categories.index-ar');
Route::get('/ar/product-category/create', 'ProductCategoryController@create_ar')->name('product-categories.create-ar');
Route::get('/ar/product-categories/{id}', 'ProductCategoryController@getRestCats_ar')->name('product-categories.rest-cat-ar');
Route::get('/ar/product-categories/table/{id}', 'ProductCategoryController@getRestCatsTable_ar')->name('product-categories.rest-cat-table-ar');
Route::post('/ar/product-categories/store{id}', 'ProductCategoryController@store_ar')->name('product-category.store-ar');
Route::get('/ar/product-categories/delete/{id}', 'ProductCategoryController@delete_ar')->name('product-category.delete-ar');
Route::get('/ar/product-categories/edit/{id}', 'ProductCategoryController@edit_ar')->name('product-category.edit-ar');
Route::post('/ar/product-categories/update/{id}', 'ProductCategoryController@update_ar')->name('product-category.update-ar');
Route::post('/ar/product-category/upload_cat', 'ProductCategoryController@upload_cat_ar')->name('upload_cat-ar');
Route::post('/ar/product-category/upload_cat_thumbnail', 'ProductCategoryController@upload_cat_thumbnail_ar')->name('upload_cat_thumbnail-ar');
Route::post('/ar/product-category/upload_cat_edit', 'ProductCategoryController@upload_cat_edit_ar')->name('upload_cat_edit-ar');

Route::POST('/ar/branch/add', 'BranchController@store_ar')->name('branch.store-ar');
Route::get('/ar/branches/{id}', 'BranchController@index_ar')->name('branches.index-ar');
Route::get('/ar/branch/delete/{id}', 'BranchController@delete_ar')->name('branch.delete-ar');
Route::get('/ar/branch/edit/{id}', 'BranchController@edit_ar')->name('branch.edit-ar');
Route::post('/ar/branch/update/{id}', 'BranchController@update_ar')->name('branch.update-ar');
Route::get('/ar/branch/lock/{id}', 'BranchController@lock_ar')->name('branch.lock-ar');
Route::get('/ar/branch/unlock/{id}', 'BranchController@unlock_ar')->name('branch.unlock-ar');
Route::get('/ar/branch/qrcode/{id}', 'BranchController@generateQrExternal_ar')->name('branch.qrcode-ar');
Route::get('/ar/branch/external/qrcode/{id}', 'ProductCategoryController@branchCategories_ar')->name('branch.details-ar');
Route::post('/ar/branches/select/{id}', 'BranchController@select_branch_ar')->name('branch.store_branch-ar');
Route::get('/ar/branch/admin/edit/{id}', 'BranchController@adminEdit_ar')->name('branch-admin.edit-ar');
Route::post('/ar/branch/admin/update/{id}', 'BranchController@adminUpdate_ar')->name('branch-admin.update-ar');
Route::get('/ar/branch/admin/delete/{id}', 'BranchController@adminDelete_ar')->name('branch-admin.delete-ar');

Route::get('/ar/products', 'ProductController@all_ar')->name('products.all-ar');
Route::get('/ar/product/create', 'ProductController@create_ar')->name('product.create-ar');
Route::get('/ar/products/{id}', 'ProductController@index_ar')->name('products.index-ar');
Route::get('/ar/products/table/{id}', 'ProductController@index_table_ar')->name('products.table-index-ar');
Route::post('/ar/product/store', 'ProductController@store_ar')->name('product.store-ar');
Route::get('/ar/product/delete/{id}', 'ProductController@delete_ar')->name('product.delete-ar');
Route::get('/ar/product/edit/{id}', 'ProductController@edit_ar')->name('product.edit-ar');
Route::post('/ar/product/update/{id}', 'ProductController@update_ar')->name('product.update-ar');
Route::get('/ar/product/details/table/{id}', 'ProductController@details_table_ar')->name('product.details-table-ar');
Route::get('/ar/product/details/{id}', 'ProductController@details_ar')->name('product.details-ar');
Route::get('/ar/product/lock/{id}', 'ProductController@lock_ar')->name('product.lock-ar');
Route::get('/ar/product/unlock/{id}', 'ProductController@unlock_ar')->name('product.unlock-ar');
Route::post('/ar/product/upload_product', 'ProductController@upload_product_ar')->name('upload_product-ar');
Route::post('/ar/product/upload_product_thumbnail', 'ProductController@upload_product_thumbnail_ar')->name('upload_product_thumbnail-ar');
Route::post('/ar/product/upload_product_edit', 'ProductController@upload_product_edit_ar')->name('upload_product_edit-ar');

Route::post('/ar/productsize/store', 'ProductSizeController@store_ar')->name('product_size.store-ar');
Route::get('/ar/productsizes/{id}', 'ProductSizeController@index_ar')->name('product_sizes.index-ar');
Route::get('/ar/productsize/delete/{id}', 'ProductSizeController@delete_ar')->name('product_size.delete-ar');
Route::get('/ar/productsize/edit/{id}', 'ProductSizeController@edit_ar')->name('product_size.edit-ar');
Route::post('/ar/productsize/update/{id}', 'ProductSizeController@update_ar')->name('product_size.update-ar');

Route::get('/ar/restaurants', 'RestaurantController@index_ar')->name('restaurants.index-ar');
Route::get('/ar/restaurant/create', 'RestaurantController@create_ar')->name('restaurant.create-ar');
Route::post('/ar/restaurant/store', 'RestaurantController@store_ar')->name('restaurant.store-ar');
Route::get('/ar/restaurant/delete/{id}', 'RestaurantController@delete_ar')->name('restaurant.delete-ar');
Route::get('/ar/restaurant/edit/{id}', 'RestaurantController@edit_ar')->name('restaurant.edit-ar');
Route::post('/ar/restaurant/update/{id}', 'RestaurantController@update_ar')->name('restaurant.update-ar');
Route::get('/ar/restaurant/lock/{id}', 'RestaurantController@lock_ar')->name('restaurant.lock-ar');
Route::get('/ar/restaurant/unlock/{id}', 'RestaurantController@unlock_ar')->name('restaurant.unlock-ar');
Route::get('/ar/restaurant/details/{id}', 'RestaurantController@details_ar')->name('restaurant.details-ar');
Route::get('/ar/restaurant/qrcode/{rest_id}/{table_id}', 'RestaurantController@generateQrExternal_ar')->name('restaurant.qrcode-ar');
Route::get('/ar/restaurants/all', 'RestaurantController@getActive_ar')->name('restaurants.active-ar');
Route::get('/ar/restaurants/search', 'RestaurantController@getActiveByName_ar')->name('restaurants.search-ar');
Route::get('/ar/restaurant/admins/{id}', 'RestaurantController@getAdmins_ar')->name('branch.admins-ar');
Route::get('/ar/restaurants/crop', 'RestaurantController@crop_ar')->name('crop-ar');
Route::post('ar/restaurant/upload_rest', 'RestaurantController@upload_rest_ar')->name('upload_rest-ar');
Route::post('ar/restaurant/upload_rest_thumbnail', 'RestaurantController@upload_rest_thumbnail_ar')->name('upload_rest_thumbnail-ar');
Route::post('ar/restaurant/upload_rest_edit', 'RestaurantController@upload_rest_edit_ar')->name('upload_rest_edit-ar');
Route::get('ar/restaurant/admin_settings/{id}', 'RestaurantController@change_admin_settings_ar')->name('restaurant.admin_settings-ar');
Route::get('/ar/restaurant/enable_place_order/{id}', 'RestaurantController@enable_place_order_ar')->name('restaurant.enable_place_order-ar');
Route::get('/ar/restaurant/disable_place_order/{id}', 'RestaurantController@disable_place_order_ar')->name('restaurant.disable_place_order-ar');
Route::get('/ar/restaurant/enable_table_code/{id}', 'RestaurantController@enable_table_code_ar')->name('restaurant.enable_table_code-ar');
Route::get('/ar/restaurant/disable_table_code/{id}', 'RestaurantController@disable_table_code_ar')->name('restaurant.disable_table_code-ar');

Route::get('/ar/plans', 'PricePlanController@index_ar')->name('plans.index-ar');
Route::get('/ar/plans/internal', 'PricePlanController@index_internal_ar')->name('plans.index_internal-ar');
Route::post('/ar/plan/add', 'PricePlanController@store_ar')->name('plan.store-ar');
Route::get('/ar/plan/toggle/{id}', 'PricePlanController@toggle_lock_ar')->name('plan.toggle-status-ar');
Route::get('/ar/plan/upgrade/{id}', 'PricePlanController@updgradePlan_ar')->name('upgrade.plan-ar');
Route::get('/ar/plan/change/{id}/{rest_id}', 'PricePlanController@change_ar')->name('plan.change-ar');
Route::get('/ar/plan/switch', 'PricePlanController@switch_ar')->name('plans.switch-ar');

Route::get('/ar/orderdetails/{id}', 'OrderDetailController@index_ar')->name('order_details.index-ar');
Route::get('/ar/orderdetails/delete/{id}', 'OrderDetailController@delete_ar')->name('order_details.delete-ar');
Route::get('/ar/addOrder', 'OrderDetailController@store_ar')->name('order_details.store-ar');
Route::get('/ar/createOrder', 'OrderDetailController@create_ar')->name('order_details.create-ar');
Route::post('/ar/newOrder', 'OrderDetailController@new_order_ar')->name('order_details.new_order-ar');

Route::get('/ar/orders', 'OrderController@index_ar')->name('orders.index-ar');
Route::get('/ar/orders/table', 'OrderController@index_table_ar')->name('orders.index-table-ar');
Route::get('/ar/orders/table-orders', 'OrderController@table_orders_ar')->name('orders.table-orders-ar');
Route::get('/ar/order/checkout/{id}', 'OrderController@checkout_ar')->name('order.checkout-ar');
Route::post('/ar/order/add', 'OrderController@store_ar')->name('order.store-ar');
Route::get('/ar/order/confrim/{id}', 'OrderController@confirm_ar')->name('order.confirm-ar');
Route::get('/ar/order/done/{id}', 'OrderController@done_ar')->name('order.checkout-ar');
Route::get('/ar/order/print/{id}', 'OrderController@print_ar')->name('order.print-ar');
Route::get('/ar/order/printInternalOrder/{id}', 'OrderController@printInternalOrder_ar')->name('order.printInternalOrder-ar');
Route::get('/ar/order/printInternalTable/{id}', 'OrderController@printInternalTable_ar')->name('order.printInternalTable-ar');

Route::get('/ar/orders/history-orders', 'OrderHistoryController@history_orders_ar')->name('orders.history-orders-ar');
Route::get('/ar/orderHistory/printInternalTable/{id}', 'OrderHistoryController@printInternalTable_ar')->name('orderHistory.printInternalTable-ar');

Route::get('/ar/test', 'RestaurantController@test')->name('test-ar');

Route::get('/ar/cart/add', 'CartController@store_ar')->name('cart.store-ar');
Route::get('/ar/cart-product/add', 'CartController@store_product_cart_ar')->name('product_cart.store-ar');
Route::get('/ar/store-cart/add', 'CartController@store_cart_ar')->name('store_cart.store-ar');
Route::get('/ar/cart/active', 'CartController@getActiveCart_ar')->name('cart.active-cart-ar');
Route::get('/ar/cart/checkout', 'CartController@checkout_ar')->name('cart.checkout-ar');
Route::get('/ar/cart/final', 'CartController@finalConfirm_ar')->name('cart.final_confirm-ar');
Route::get('/ar/cart/table/checkout', 'CartController@checkout_table_ar')->name('cart.checkout-table-ar');
Route::get('/ar/cart/table/final', 'CartController@finalConfirm_table_ar')->name('cart.final_confirm-table-ar');
Route::get('/ar/cart/delete/{product_id}/{description}', 'CartController@delete_ar')->name('cart.delete-ar');

Route::post('/ar/subscribe/add', 'SubscriptionController@store_ar')->name('subscription.store-ar');
Route::get('/ar/subscribe/pending', 'SubscriptionController@pending_ar')->name('subs.pending-ar');
Route::get('/ar/subscribe/{id}', 'SubscriptionController@subscribe_ar')->name('plan.subscribe-ar');
Route::get('/ar/subscriber-activate/{id}/{rest_id}', 'PricePlanController@activateUpgrade_ar')->name('plan.activate-ar');


Route::get('/ar/image-cropper', 'ImageCropperController@index_ar');
Route::post('/ar/image-cropper/upload', 'ImageCropperController@upload_ar')->name('upload-ar');
Route::post('/ar/image-cropper/upload_rest', 'ImageCropperController@upload_rest_ar')->name('upload_rest-ar');
Route::post('/ar/image-cropper/upload_rest_edit', 'ImageCropperController@upload_rest_edit_ar')->name('upload_rest_edit-ar');
Route::post('/ar/image-cropper/upload_cat', 'ImageCropperController@upload_cat_ar')->name('upload_cat-ar');
Route::post('/ar/image-cropper/upload_cat_edit', 'ImageCropperController@upload_cat_edit_ar')->name('upload_cat_edit-ar');
Route::post('/ar/image-cropper/upload_product', 'ImageCropperController@upload_product_ar')->name('upload_product-ar');
Route::post('/ar/image-cropper/upload_product_edit', 'ImageCropperController@upload_product_edit_ar')->name('upload_product_edit-ar');
Route::post('/ar/image-cropper/upload_subscribe', 'ImageCropperController@upload_subs_ar')->name('upload_subscribe-ar');

Route::get('/ar/tables/rest/{id}', 'TableController@index_ar')->name('table.index-ar');
Route::get('/ar/table/delete/{id}', 'TableController@delete_ar')->name('table.delete-ar');
Route::post('/ar/table/store', 'TableController@store_ar')->name('table.store-ar');
Route::get('/ar/table/validate', 'TableController@validate_table_ar')->name('table.validate-ar');
Route::get('/ar/table/valid', 'TableController@valid_ar')->name('table.valid-ar');


Route::get('/ar/rest/internal/qrcode/{rest_id}/{table_id}', 'TableController@table_code_ar')->name('table.table_code-ar');
Route::get('/ar/table/product-categories', 'ProductCategoryController@tableCategories_ar')->name('table.product-categories-ar');
Route::get('/ar/table/product-categories/cart', 'ProductCategoryController@tableCategories1_ar')->name('table.product-categories-cart-ar');
Route::get('/ar/table/close/{id}', 'TableController@closeTable_ar')->name('table.close-ar');

//-------------------------