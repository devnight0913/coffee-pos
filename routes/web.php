<?php

use Illuminate\Support\Facades\Artisan;
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

Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'show'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('login.attempt');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'show'])->name('home');
    Route::view('/about', 'about.show')->name('about');
    Route::get('/point-of-sale', [\App\Http\Controllers\PointOfSaleController::class, 'show'])->name('pos.show');
    Route::post('logout', [\App\Http\Controllers\Auth\LogOutController::class, 'logout'])->name('logout');


    Route::get('password/confirm', [\App\Http\Controllers\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('password/confirm', [\App\Http\Controllers\Auth\ConfirmPasswordController::class, 'confirm']);

    Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [\App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('categories.create');
    Route::get('/categories/{category}/edit', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::delete('/categories/{category}/image', [\App\Http\Controllers\CategoryController::class, 'imageDestroy'])->name('categories.image.destroy');


    Route::get('/recipe', [\App\Http\Controllers\RecipeController::class, 'index'])->name('recipe.index');
    Route::post('/recipe', [\App\Http\Controllers\RecipeController::class, 'store'])->name('recipe.store');
    Route::get('/recipe/create', [\App\Http\Controllers\RecipeController::class, 'create'])->name('recipe.create');
    Route::get('/recipe/{recipe}/edit', [\App\Http\Controllers\RecipeController::class, 'edit'])->name('recipe.edit');
    Route::put('/recipe/{recipe}', [\App\Http\Controllers\RecipeController::class, 'update'])->name('recipe.update');
    Route::delete('/recipe/{recipe}', [\App\Http\Controllers\RecipeController::class, 'destroy'])->name('recipe.destroy');
    Route::delete('/recipe/{recipe}/image', [\App\Http\Controllers\RecipeController::class, 'imageDestroy'])->name('recipe.image.destroy');


    Route::get('/items', [\App\Http\Controllers\ItemController::class, 'index'])->name('items.index');
    Route::post('/items', [\App\Http\Controllers\ItemController::class, 'store'])->name('items.store');
    Route::get('/items/create', [\App\Http\Controllers\ItemController::class, 'create'])->name('items.create');
    Route::get('/items/{item}/edit', [\App\Http\Controllers\ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [\App\Http\Controllers\ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [\App\Http\Controllers\ItemController::class, 'destroy'])->name('items.destroy');
    Route::delete('/items/{item}/image', [\App\Http\Controllers\ItemController::class, 'imageDestroy'])->name('items.image.destroy');


    Route::get('/customers', [\App\Http\Controllers\CustomerController::class, 'index'])->name('customers.index');
    Route::post('/customers', [\App\Http\Controllers\CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/create', [\App\Http\Controllers\CustomerController::class, 'create'])->name('customers.create');
    Route::get('/customers/print', [\App\Http\Controllers\CustomerController::class, 'printInfo'])->name('customers.print.info');
    Route::get('/customers/{customer}/edit', [\App\Http\Controllers\CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [\App\Http\Controllers\CustomerController::class, 'update'])->name('customers.update');
    Route::get('/customers/{customer}', [\App\Http\Controllers\CustomerController::class, 'show'])->name('customers.show');
    Route::delete('/customers/{customer}', [\App\Http\Controllers\CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customers/{customer}/orders', [\App\Http\Controllers\CustomerOrderController::class, 'index'])->name('customers.orders.index');
    Route::get('/customers/{customer}/payments', [\App\Http\Controllers\CustomerPaymentController::class, 'index'])->name('customers.payments.index');
    Route::post('/customers/{customer}/payments', [\App\Http\Controllers\CustomerPaymentController::class, 'store'])->name('customers.payments.store');
    Route::get('/customers/{customer}/payments/create', [\App\Http\Controllers\CustomerPaymentController::class, 'create'])->name('customers.payments.create');
    Route::get('/customers/{customer}/payments/filter', [\App\Http\Controllers\CustomerPaymentController::class, 'filter'])->name('customers.payments.filter');
    Route::get('/customers/{customer}/payments/filter-print', [\App\Http\Controllers\CustomerPaymentController::class, 'filterPrint'])->name('customers.payments.filter.print');
    Route::get('/customers/{customer}/payments/{payment}/edit', [\App\Http\Controllers\CustomerPaymentController::class, 'edit'])->name('customers.payments.edit');
    Route::get('/customers/{customer}/payments/{payment}/print', [\App\Http\Controllers\CustomerPaymentController::class, 'print'])->name('customers.payments.print');
    Route::put('/customers/{customer}/payments/{payment}', [\App\Http\Controllers\CustomerPaymentController::class, 'update'])->name('customers.payments.update');
    Route::delete('/customers/{customer}/payments/{payment}', [\App\Http\Controllers\CustomerPaymentController::class, 'destroy'])->name('customers.payments.destroy');

    Route::get('/customers/{customer}/statements', [\App\Http\Controllers\CustomerAccountStatementController::class, 'index'])->name('customers.statements.index');
    Route::get('/customers/{customer}/statements/{statement}/print', [\App\Http\Controllers\CustomerAccountStatementController::class, 'print'])->name('customers.statements.print');
    Route::get('/customers/{customer}/statements/filter', [\App\Http\Controllers\CustomerAccountStatementController::class, 'filter'])->name('customers.statements.filter');
    Route::get('/customers/{customer}/statements/filter-print', [\App\Http\Controllers\CustomerAccountStatementController::class, 'filterPrint'])->name('customers.statements.filter.print');

    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/analytics', [\App\Http\Controllers\OrderController::class, 'showAnalytics'])->name('orders.analytics');

    Route::get('/orders/filter', [\App\Http\Controllers\OrderController::class, 'filter'])->name('orders.filter');
    Route::get('/orders/print/stats', [\App\Http\Controllers\OrderController::class, 'printStats'])->name('orders.print.stats');
    Route::get('/orders/print/{order}', [\App\Http\Controllers\OrderController::class, 'print'])->name('orders.print');
   
    Route::get('/orders/edit/{order}', [\App\Http\Controllers\OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/update/{order}', [\App\Http\Controllers\OrderController::class, 'update'])->name('orders.update');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'destroy'])->name('orders.destroy');


    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'show'])->name('settings.show');
    Route::put('/settings/pos', [\App\Http\Controllers\SettingsController::class, 'updatePos'])->name('settings.pos.update');
    Route::put('/settings/currency', [\App\Http\Controllers\SettingsController::class, 'updateCurrency'])->name('settings.currency.update');
    Route::put('/settings/identification', [\App\Http\Controllers\SettingsController::class, 'updateIdentification'])->name('settings.identification.update');
    Route::put('/settings/date', [\App\Http\Controllers\SettingsController::class, 'updateDate'])->name('settings.date.update');
    Route::put('/settings/exchange-rate', [\App\Http\Controllers\SettingsController::class, 'updateExchangeRate'])->name('settings.exchange-rate.update');


    Route::get('/change-password', [\App\Http\Controllers\PasswordController::class, 'show'])->name('password.show');
    Route::put('/change-password', [\App\Http\Controllers\PasswordController::class, 'update'])->name('password.update');

    Route::get('/drawer', [\App\Http\Controllers\DrawerController::class, 'show'])->name('drawer.show');
    Route::post('/drawer/close', [\App\Http\Controllers\DrawerController::class, 'close'])->name('drawer.close');
    Route::get('/drawer/{drawerHistory}/print', [\App\Http\Controllers\DrawerController::class, 'print'])->name('drawer.print');

    Route::get('/expenses', [\App\Http\Controllers\ExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/expenses', [\App\Http\Controllers\ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/expenses/create', [\App\Http\Controllers\ExpenseController::class, 'create'])->name('expenses.create');
    // Route::get('/expenses/archive', [\App\Http\Controllers\ExpenseController::class, 'archive'])->name('expenses.archive');
    Route::get('/expenses/{expense}/print', [\App\Http\Controllers\ExpenseController::class, 'print'])->name('expenses.print');
    // Route::get('/expenses/{expense}/archive', [\App\Http\Controllers\ExpenseController::class, 'updateArchive'])->name('expenses.update.archive');
    Route::get('/expenses/filter', [\App\Http\Controllers\ExpenseController::class, 'filter'])->name('expenses.filter');
    Route::get('/expenses/filter-print', [\App\Http\Controllers\ExpenseController::class, 'filterPrint'])->name('expenses.filter.print');
    Route::delete('/expenses/{expense}', [\App\Http\Controllers\ExpenseController::class, 'destroy'])->name('expenses.destroy');


    Route::get('/payments', [\App\Http\Controllers\PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments', [\App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/create', [\App\Http\Controllers\PaymentController::class, 'create'])->name('payments.create');
    Route::get('/payments/{payment}/edit', [\App\Http\Controllers\PaymentController::class, 'edit'])->name('payments.edit');
    Route::post('/payments/{payment}', [\App\Http\Controllers\PaymentController::class, 'update'])->name('payments.update');
    Route::delete('/payments/{payment}', [\App\Http\Controllers\PaymentController::class, 'destroy'])->name('payments.destroy');
    Route::get('/payments/filter', [\App\Http\Controllers\PaymentController::class, 'filter'])->name('payments.filter');
    Route::get('/payments/filter-print', [\App\Http\Controllers\PaymentController::class, 'filterPrint'])->name('payments.filter.print');



    Route::get('/suppliers', [\App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/create', [\App\Http\Controllers\SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers', [\App\Http\Controllers\SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{supplier}', [\App\Http\Controllers\SupplierController::class, 'show'])->name('suppliers.show');
    Route::get('/suppliers/{supplier}/edit', [\App\Http\Controllers\SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{supplier}', [\App\Http\Controllers\SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [\App\Http\Controllers\SupplierController::class, 'destroy'])->name('suppliers.destroy');


    Route::get('/purchases', [\App\Http\Controllers\PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/purchases/create', [\App\Http\Controllers\PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/purchases', [\App\Http\Controllers\PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/purchases/{purchase}', [\App\Http\Controllers\PurchaseController::class, 'show'])->name('purchases.show');
    Route::get('/purchases/{purchase}/edit', [\App\Http\Controllers\PurchaseController::class, 'edit'])->name('purchases.edit');
    Route::get('/purchases/{purchase}/print', [\App\Http\Controllers\PurchaseController::class, 'print'])->name('purchases.print');
    Route::put('/purchases/{purchase}', [\App\Http\Controllers\PurchaseController::class, 'update'])->name('purchases.update');
    Route::delete('/purchases/{purchase}', [\App\Http\Controllers\PurchaseController::class, 'destroy'])->name('purchases.destroy');


    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::get('sales-report', [\App\Http\Controllers\SalesController::class, 'index'])->name('sales.index');
    Route::get('sales-report/filter', [\App\Http\Controllers\SalesController::class, 'filter'])->name('sales.filter');
    Route::get('sales-report/{date}', [\App\Http\Controllers\SalesController::class, 'show'])->name('sales.show');

    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    
    Route::get('/employees', [\App\Http\Controllers\EmployeeController::class, 'index'])->name('employees.index');
    Route::post('/employees', [\App\Http\Controllers\EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/create', [\App\Http\Controllers\EmployeeController::class, 'create'])->name('employees.create');
    Route::delete('/employees/{employee}', [\App\Http\Controllers\EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/employees/{employee}/edit', [\App\Http\Controllers\EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{employee}', [\App\Http\Controllers\EmployeeController::class, 'update'])->name('employees.update');

    Route::get('/inventory', [\App\Http\Controllers\InventoryController::class, 'show'])->name('inventory.index');
    Route::post('/inventory/close', [\App\Http\Controllers\InventoryController::class, 'close'])->name('inventory.close');
    Route::get('/inventory/{inventoryHistory}/print', [\App\Http\Controllers\InventoryController::class, 'print'])->name('inventory.print');
    // Route::get('/inventory', [\App\Http\Controllers\InventoryController:class, 'index']))->name('inventory.index');

    //API
    Route::get('/recipe/all', [\App\Http\Controllers\RecipeController::class, 'getRecipes']);
    Route::get('/categories/all', [\App\Http\Controllers\InventoryController::class, 'getCategories']);
    Route::get('/items/all', [\App\Http\Controllers\ItemController::class, 'getItems']);
    Route::get('/inventory/recipe', [\App\Http\Controllers\InventoryController::class, 'getRecipes']);
    Route::get('/customers/search/all', [\App\Http\Controllers\CustomerController::class, 'search']);
    Route::post('/customers/create-new', [\App\Http\Controllers\CustomerController::class, 'createNew']);

    Route::get('/database/download', function () {
        return response()->download(database_path('database.sqlite'), 'database.sqlite');
    })->name('database.download');
    Route::get('/storage/link', function () {
        try {
            Artisan::call('storage:link');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', 'Storage has been linked');
    })->name('storage.link');


    Route::post('/order', [\App\Http\Controllers\OrderController::class, 'store']);
    Route::post('/settings/starting-cash', [\App\Http\Controllers\SettingsController::class, 'updateStartingCashValue']);

    Route::get('/uploads/{path}', [App\Http\Controllers\ImageController::class, 'show'])->where('path', '.*')->name('image.show');
});
