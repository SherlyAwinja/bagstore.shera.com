<?php

use App\Http\Controllers\Admin\AdminMainController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductDiscountController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\SellerMainController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerStoreController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerMainController;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\MasterSubCategoryController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'rolemanager:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::controller(AdminMainController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('admin');
            Route::get('/settings', 'setting')->name('admin.settngs');
            Route::get('/manage/users', 'manage_user')->name('admin.manage.user');
            Route::get('/manahe/stores', 'manage_stores')->name('admin.manage.store');
            Route::get('/cart/history', 'cart_history')->name('admin.cart.history');
            Route::get('/order/history', 'order_history')->name('admin.order.history');
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::get('/category/create', 'index')->name('category.create');
            Route::get('/category/manage', 'manage')->name('category.manage');
        });

        Route::controller(SubCategoryController::class)->group(function () {
            Route::get('/subcategory/create', 'index')->name('subcategory.create');
            Route::post('/subcategory/store', 'store')->name('store.subcategory');
            Route::get('/subcategory/manage', 'manage')->name('subcategory.manage');
         });

        Route::controller(ProductController::class)->group(function () {
            Route::get('/product/manage', 'index')->name('product.manage');
            Route::get('/product/review/manage', 'review_manage')->name('product.review.manage');
        });

        Route::controller(ProductAttributeController::class)->group(function () {
            Route::get('/productattribute/create', 'index')->name('productattribute.create');
            Route::get('/productattribute/manage', 'manage')->name('productattribute.manage');
            Route::post('/defaultattribute/create', 'createattribute')->name('attribute.create');
            Route::get('/defaultattribute/{id}', 'showattribute')->name('show.attribute');
            Route::put('/defaultattribute/update/{id}', 'updateattribute')->name('update.attribute');
            Route::delete('/defaultattribute/delete/{id}', 'deleteattribute')->name('delete.attribute');
        });

        Route::controller(ProductDiscountController::class)->group(function () {
            Route::get('/discount/create', 'index')->name('discount.create');
            Route::get('/discount/manage', 'manage')->name('discount.manage');
        });

        Route::controller(MasterCategoryController::class)->group(function () {
            Route::post('/store/category', 'storecat')->name('store.category');
            Route::get('/category/{id}', 'showcategory')->name('show.category');
            Route::put('/category/update/{id}', 'updatecategory')->name('update.category');
            Route::delete('/category/delete/{id}', 'deletecategory')->name('delete.category');
        });

        Route::controller(MasterSubCategoryController::class)->group(function () {
            Route::post('/store/subcategory', 'storesubcat')->name('store.subcategory');
            Route::get('/subcategory/{id}', 'showsubcategory')->name('show.subcategory');
            Route::put('/subcategory/update/{id}', 'updatesubcategory')->name('update.subcategory');
            Route::delete('/subcategory/delete/{id}', 'deletesubcategory')->name('delete.subcategory');
        });
    });
});

// Vendor Routes
Route::middleware(['auth', 'verified', 'rolemanager:vendor'])->group(function () {
    Route::prefix('vendor')->group(function () {
        Route::controller(SellerMainController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('vendor');
            Route::get('/order/history', 'orderhistory')->name('vendor.order.history');
        });

        Route::controller(SellerStoreController::class)->group(function () {
            Route::get('/store/create', 'index')->name('vendor.store');
            Route::get('/store/manage', 'manage')->name('vendor.store.manage');
            Route::post('/store/publish', 'store')->name('create.store');
            Route::get('/store/{id}', 'showstore')->name('show.store');
            Route::put('/store/update/{id}', 'updatestore')->name('update.store');
            Route::delete('/store/delete/{id}', 'deletestore')->name('delete.store');
        });

        Route::controller(SellerProductController::class)->group(function () {
            Route::get('/product/create', 'index')->name('vendor.product');
            Route::get('/product/manage', 'manage')->name('vendor.product.manage');
        });
    });
});

// Customer Routes
Route::middleware(['auth', 'verified', 'rolemanager:customer'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::controller(CustomerMainController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard');
            Route::get('/order/history', 'history')->name('customer.history');
            Route::get('/setting/payment', 'payment')->name('customer.payment');
            Route::get('/affiliate', 'affiliate')->name('customer.affiliate');
        });  
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
