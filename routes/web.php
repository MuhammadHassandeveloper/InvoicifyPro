<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ShippingChargeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\AccountanBrandController;
use App\Http\Controllers\AccountanDiscountController;
use App\Http\Controllers\AccountanProductController;
use App\Http\Controllers\AccountantDashboardController;
use App\Http\Controllers\AccountantShippingChargeController;
use App\Http\Controllers\AccountantCategoryController;
use App\Http\Controllers\AccountantTaxController;


// clear all
Route::get('/all-clear', function () {
    Artisan::call('optimize:clear');
    return 'All cleared!';
});

// Call the Artisan command to generate the CSV
Route::get('/fetch-invoices', function () {
    Artisan::call('invoices:update_status');
    return 'successfully statues fetch invoices and command run';
});



Route::get('/',[AuthController::class,'index'])->name('login.form');
Route::post('/post-login', [AuthController::class, 'postLogin'])->name('post.login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'admin', 'prefix' => '/'], function () {

    // admin dashboard routes
    Route::group(array('prefix' => 'admin'), function () {
        Route::get('/dashboard', [AdminController::class, 'admin_dashboard'])->name('admin.dashboard');


        #profile setting
        Route::get('/profile/setting',[AdminController::class,'profile_setting'])->name('profile.setting');
        Route::post('profile/update',[AdminController::class,'profile_update'])->name('profile.update');

        //site setting

        Route::get('site/setting',[AdminController::class,'site_setting_from'])->name('site_setting');
        Route::post('site/setting-save',[AdminController::class,'site_setting_save'])->name('site_setting_save');
        Route::get('/activity/logs',[AdminController::class,'activitylogs'])->name('activity-logs');


        //countries routes
        Route::resource('countries', CountryController::class, ['as' => 'admin']);
        Route::post('countries/{id}/status', [CountryController::class, 'changeStatus'])->name('admin.countries.changeStatus');

        //taxes routes
        Route::resource('taxes', TaxController::class, ['as' => 'admin']);
        Route::post('taxes/{id}/status', [TaxController::class, 'changeStatus'])->name('admin.taxes.changeStatus');

        //discounts routes
        Route::resource('discounts', DiscountController::class, ['as' => 'admin']);
        Route::post('discounts/{id}/status', [DiscountController::class, 'changeStatus'])->name('admin.discounts.changeStatus');

        //shipping-charges routes
        Route::resource('shipping-charges', ShippingChargeController::class,['as' => 'admin']);
        Route::post('shipping-charges/{id}/status', [ShippingChargeController::class, 'changeStatus'])->name('admin.shipping-charges.changeStatus');

        //brands routes
        Route::resource('brands', BrandController::class,['as' => 'admin']);
        Route::post('brands/{id}/status', [BrandController::class, 'changeStatus'])->name('admin.brands.changeStatus');

        //categories routes
        Route::resource('categories', CategoryController::class,['as' => 'admin']);
        Route::post('categories/{id}/status', [CategoryController::class, 'changeStatus'])->name('admin.categories.changeStatus');


        Route::group(['prefix' => 'products'], function () {

            Route::get('/', [ProductController::class, 'index'])->name('admin.products.index');
            Route::get('/low-stock', [ProductController::class, 'low_stock'])->name('admin.products.low_stock');
            Route::get('/out-of-stock', [ProductController::class, 'out_of_stock'])->name('admin.products.out_of_stock');
            Route::get('/disabled', [ProductController::class, 'disabled'])->name('admin.products.disabled');
            Route::get('/active', [ProductController::class, 'active'])->name('admin.products.active');

            Route::get('/create', [ProductController::class, 'create'])->name('admin.products.create');
            Route::post('/store', [ProductController::class, 'store'])->name('admin.products.store');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
            Route::post('/update/{id}', [ProductController::class, 'update'])->name('admin.products.update');
            Route::get('/destroy/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
            Route::post('status/{id}', [ProductController::class, 'changeStatus'])->name('admin.products.changeStatus');
            Route::get('/show/{id}', [ProductController::class, 'show'])->name('admin.products.show');

            Route::post('update-stock', [ProductController::class, 'updateStock'])->name('admin.products.updateStock');

        });

        Route::group(['prefix' => 'clients'], function () {
            Route::get('/', [ClientController::class, 'index'])->name('admin.clients.index');
            Route::get('/active', [ClientController::class, 'active'])->name('admin.clients.active');
            Route::get('/disabled', [ClientController::class, 'disabled'])->name('admin.clients.disabled');
            Route::get('/create', [ClientController::class, 'create'])->name('admin.clients.create');
            Route::post('/store', [ClientController::class, 'store'])->name('admin.clients.store');
            Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('admin.clients.edit');
            Route::POST('/update/{id}', [ClientController::class, 'update'])->name('admin.clients.update');
            Route::get('/show/{id}', [ClientController::class, 'show'])->name('admin.clients.show');
            Route::get('/destroy/{id}', [ClientController::class, 'destroy'])->name('admin.clients.destroy');
            Route::post('/status/{id}', [ClientController::class, 'changeStatus'])->name('admin.clients.changeStatus');
            Route::get('/details/{id}', [ClientController::class, 'getClientDetails']);

        });

        Route::group(['prefix' => 'accountants'], function () {
            Route::get('/', [AccountantController::class, 'index'])->name('admin.accountants.index');
            Route::get('/create', [AccountantController::class, 'create'])->name('admin.accountants.create');
            Route::post('/store', [AccountantController::class, 'store'])->name('admin.accountants.store');
            Route::get('/edit/{id}', [AccountantController::class, 'edit'])->name('admin.accountants.edit');
            Route::post('/update/{id}', [AccountantController::class, 'update'])->name('admin.accountants.update');
            Route::get('/destroy/{id}', [AccountantController::class, 'destroy'])->name('admin.accountants.destroy');
            Route::post('/status/{id}', [AccountantController::class, 'changeStatus'])->name('admin.accountants.changeStatus');

        });

        Route::group(['prefix' => 'invoices'], function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('admin.invoices.index');
            Route::get('/unpaid', [InvoiceController::class, 'unpaid'])->name('admin.invoices.unpaid');
            Route::get('/paid', [InvoiceController::class, 'paid'])->name('admin.invoices.paid');
            Route::get('/void', [InvoiceController::class, 'void'])->name('admin.invoices.void');
            Route::get('/transactions', [InvoiceController::class, 'transactions'])->name('admin.invoices.transactions');
            Route::get('/sales-report', [InvoiceController::class, 'saleReport'])->name('admin.invoices.sales');

            Route::get('/create', [InvoiceController::class, 'create'])->name('admin.invoices.create');

            Route::get('/fetch-invoices/{id}', [InvoiceController::class, 'fecthInvoice'])->name('admin.invoices.fecthInvoice');

            Route::get('/show/{id}', [InvoiceController::class, 'show'])->name('admin.invoices.show');
            Route::get('/edit/{id}', [InvoiceController::class, 'edit'])->name('admin.invoices.edit');
            Route::get('/make-void/{id}', [InvoiceController::class, 'voidInvoice'])->name('admin.invoices.make-void');
            Route::get('/financials/{id}', [InvoiceController::class, 'financialsDetails'])->name('admin.invoices.financialsDetails');
            Route::get('product/details/{id}', [InvoiceController::class, 'getProductDetails'])->name('admin.products.details');
            Route::post('generate', [InvoiceController::class, 'generateInvoice'])->name('admin.invoices.generate');

        });

    });
    // customer  dashboard routes
    Route::group(array('prefix' => 'customer'), function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'customer_dashboard'])->name('customer.dashboard');
        #profile setting
        Route::get('/profile/setting',[CustomerDashboardController::class,'profile_setting'])->name('customer.profile.setting');
        Route::post('profile/update',[CustomerDashboardController::class,'profile_update'])->name('customer.profile.update');
        //site setting
        Route::group(['prefix' => 'invoices'], function () {
            Route::get('/', [CustomerDashboardController::class, 'index'])->name('customer.invoices.index');
            Route::get('/unpaid', [CustomerDashboardController::class, 'unpaid'])->name('customer.invoices.unpaid');
            Route::get('/paid', [CustomerDashboardController::class, 'paid'])->name('customer.invoices.paid');
            Route::get('/void', [CustomerDashboardController::class, 'void'])->name('customer.invoices.void');
            Route::get('/transactions', [CustomerDashboardController::class, 'transactions'])->name('customer.invoices.transactions');
            Route::get('/sales-report', [CustomerDashboardController::class, 'saleReport'])->name('customer.invoices.sales');
            Route::get('/show/{id}', [CustomerDashboardController::class, 'show'])->name('customer.invoices.show');
        });
    });

    // accountant dashboard routes
    Route::group(array('prefix' => 'accountant'), function () {
        Route::get('/dashboard', [AccountantDashboardController::class, 'accountant_dashboard'])->name('accountant.dashboard');

        #profile setting
        Route::get('/profile/setting',[AccountantDashboardController::class,'profile_setting'])->name('accountant.profile.setting');
        Route::post('profile/update',[AccountantDashboardController::class,'profile_update'])->name('accountant.profile.update');

        //taxes routes
        Route::resource('taxes', AccountantTaxController::class, ['as' => 'accountant']);
        Route::post('taxes/{id}/status', [AccountantTaxController::class, 'changeStatus'])->name('accountant.taxes.changeStatus');

        //discounts routes
        Route::resource('discounts', AccountanDiscountController::class, ['as' => 'accountant']);
        Route::post('discounts/{id}/status', [AccountanDiscountController::class, 'changeStatus'])->name('accountant.discounts.changeStatus');

        //shipping-charges routes
        Route::resource('shipping-charges', AccountantShippingChargeController::class,['as' => 'accountant']);
        Route::post('shipping-charges/{id}/status', [AccountantShippingChargeController::class, 'changeStatus'])->name('accountant.shipping-charges.changeStatus');

        //brands routes
        Route::resource('brands', AccountanBrandController::class,['as' => 'accountant']);
        Route::post('brands/{id}/status', [AccountanBrandController::class, 'changeStatus'])->name('accountant.brands.changeStatus');

        //categories routes
        Route::resource('categories', AccountantCategoryController::class,['as' => 'accountant']);
        Route::post('categories/{id}/status', [AccountantCategoryController::class, 'changeStatus'])->name('accountant.categories.changeStatus');


        Route::group(['prefix' => 'products'], function () {

            Route::get('/', [AccountanProductController::class, 'index'])->name('accountant.products.index');
            Route::get('/low-stock', [AccountanProductController::class, 'low_stock'])->name('accountant.products.low_stock');
            Route::get('/out-of-stock', [AccountanProductController::class, 'out_of_stock'])->name('accountant.products.out_of_stock');
            Route::get('/disabled', [AccountanProductController::class, 'disabled'])->name('accountant.products.disabled');
            Route::get('/active', [AccountanProductController::class, 'active'])->name('accountant.products.active');

            Route::get('/create', [AccountanProductController::class, 'create'])->name('accountant.products.create');
            Route::post('/store', [AccountanProductController::class, 'store'])->name('accountant.products.store');
            Route::get('/edit/{id}', [AccountanProductController::class, 'edit'])->name('accountant.products.edit');
            Route::post('/update/{id}', [AccountanProductController::class, 'update'])->name('accountant.products.update');
            Route::get('/destroy/{id}', [AccountanProductController::class, 'destroy'])->name('accountant.products.destroy');
            Route::post('status/{id}', [AccountanProductController::class, 'changeStatus'])->name('accountant.products.changeStatus');
            Route::get('/show/{id}', [AccountanProductController::class, 'show'])->name('accountant.products.show');

            Route::post('update-stock', [AccountanProductController::class, 'updateStock'])->name('accountant.products.updateStock');

        });

    });

});
