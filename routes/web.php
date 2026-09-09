<?php

use App\Exports\UsersExport;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ApiKeyController as AdminApiKeyController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\orders\AcceptRefund;
use App\Http\Controllers\Admin\orders\CancelOrder as AdminCancelOrder;
use App\Http\Controllers\Admin\orders\MarkConfirmed;
use App\Http\Controllers\Admin\orders\MarkDelivered;
use App\Http\Controllers\Admin\orders\MarkPacked;
use App\Http\Controllers\Admin\orders\MarkShipped;
use App\Http\Controllers\Admin\orders\RejectRefund;
use App\Http\Controllers\Admin\orders\ReturnOrder as AdminReturnOrder;
use App\Http\Controllers\Admin\orders\UnmarkConfirmed;
use App\Http\Controllers\Admin\orders\UnmarkDelivered;
use App\Http\Controllers\Admin\orders\UnmarkPacked;
use App\Http\Controllers\Admin\orders\UnmarkShipped;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductPhotoController;
use App\Http\Controllers\Admin\ProfilePhotocontroller as AdminProfilePhotoController;
use App\Http\Controllers\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Admin\stores\ApproveStore;
use App\Http\Controllers\Admin\UnapproveStore;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\UserPasswordResetController as AdminUserPasswordResetController;
use App\Http\Controllers\API\StoreApiKeyController;
use App\Http\Controllers\Auth\EditPassword;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Auth\UpdateAccount;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\Mail\ContactEmailController;
use App\Http\Controllers\Operator\ApiKeyController as OperatorApiKeyController;
use App\Http\Controllers\Operator\OperatorController;
use App\Http\Controllers\Operator\StoreController as OperatorStoreController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\orders\MarkForRefund;
use App\Http\Controllers\User\orders\ReturnOrder;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\ProfilePhotoController as UserProfilePhotoController;
use App\Http\Controllers\User\StripeController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/localization/{locale}', LocalizationController::class)->name('localization');

Route::group(['middleware' => ['locale']], function(){

    Route::middleware('auth')->group(function () {
        //Logout route
        Route::post("/logout", Logout::class)->name("logout");

        Route::middleware('verified')->group(function () {

            //User routes
            Route::middleware('is-user')->group(function () {
                Route::get("user/", [UserController::class, 'index'])->name('user.home');
                Route::get("user/profile", [UserController::class, 'edit'])->name('user.profile');
                Route::get("user/products", [UserProductController::class, 'index'])->name('user.products');
                Route::get("user/products/{product}/view",[UserProductController::class, 'show'])->name('user.products.view');
                Route::get("user/orders", [UserOrderController::class, 'index'])->name('user.orders');
                Route::get("checkout/", [StripeController::class, 'index'])->name('checkout');
                Route::get("checkout/retry/{id}", [StripeController::class, 'retry'])->name('checkout.retry');

                Route::post("user/photo/update", [UserProfilePhotoController::class, 'update'])->name('user.update-profile');
                Route::post("user/orders/create", [UserOrderController::class, 'store'])->name('user.orders.create');
                Route::post("user/orders/refund/{id}", MarkForRefund::class)->name('user.orders.refund.request');
                Route::post("user/orders/return/{id}", ReturnOrder::class)->name('user.orders.return');

                Route::put("user/info/update", UpdateAccount::class)->name('user.update-account');
                Route::put("user/password/update", EditPassword::class)->name('user.update-password');

                Route::delete("user/photo/delete", [UserProfilePhotoController::class, 'destroy'])->name('user.delete-profile');
                Route::delete("user/orders/delete/{order}", [UserOrderController::class, 'destroy'])->name('user.orders.delete');

                Route::get("/checkout/success", [StripeController::class, 'success'])->name('checkout-success');
                Route::get("/checkout/cancel", [StripeController::class, 'cancel'])->name('checkout-cancel');
            });

            //Admin routes
            Route::middleware('is-admin')->group(function () {
                Route::get("admin/", [AdminController::class, 'index'])->name('admin.dashboard');
                Route::get("admin/users", [AdminUserController::class, 'index'])->name('admin.users');
                Route::get("admin/users/{user}/edit", [AdminUserController::class, 'edit'])->name('admin.users.inspect');
                Route::get("admin/users/trashed", [AdminUserController::class, 'trashIndex'])->name('admin.trashed.users');
                Route::get("admin/products", [AdminProductController::class, 'index'])->name('admin.products');
                Route::get("admin/products/create", [AdminProductController::class, 'create'])->name('admin.products.create');
                Route::get("admin/products/{product}/edit", [AdminProductController::class, 'edit'])->name('admin.products.inspect');
                Route::get("admin/products/trashed", [AdminProductController::class, 'trashIndex'])->name('admin.trashed.products');
                Route::get("admin/orders", [AdminOrderController::class, 'index'])->name('admin.orders');
                Route::get("admin/orders/{order}/view", [AdminOrderController::class, 'show'])->name('admin.orders.view');
                Route::get("admin/orders/trashed", [AdminOrderController::class, 'trashIndex'])->name('admin.trashed.orders');
                Route::get("admin/stores", [AdminStoreController::class, 'index'])->name('admin.stores');
                Route::get("admin/stores/{store}/edit", [AdminStoreController::class, 'edit'])->name('admin.stores.edit');
                Route::get("admin/stores/disabled", [AdminStoreController::class, 'trashIndex'])->name('admin.trashed.stores');
                Route::get("admin/stores/{store}/api-keys", [AdminApiKeyController::class, 'index'])->name('admin.stores.api-keys');
                Route::get("admin/stores/{store}/revoked-api-keys", [AdminApiKeyController::class, 'revokedIndex'])->name('admin.stores.revoked-api-keys');

                Route::post("admin/user/create", [AdminUserController::class, 'store'])->name('admin.user.create');
                Route::post("admin/user/photo/update/{user}", [AdminProfilePhotoController::class, 'update'])->name('admin.user.update-profile');
                Route::post("admin/user/restore/{id}", [AdminUserController::class, 'restore'])->name('admin.trashed.users.restore');
                Route::post("admin/products/store", [AdminProductController::class, 'store'])->name('admin.products.store');
                Route::post("admin/products/{product}/pictures/add", [ProductPhotoController::class, 'store'])->name('admin.products.pictures.add');
                Route::post("admin/products/restore/{id}", [AdminProductController::class, 'restore'])->name('admin.products.restore');
                Route::post("admin/orders/confirm/{order}", MarkConfirmed::class)->name('admin.orders.confirm');
                Route::post("admin/orders/unconfirm/{order}", UnmarkConfirmed::class)->name('admin.orders.unconfirm');
                Route::post("admin/orders/pack/{order}", MarkPacked::class)->name('admin.orders.pack');
                Route::post("admin/orders/unpack/{order}", UnmarkPacked::class)->name('admin.orders.unpack');
                Route::post("admin/orders/ship/{order}", MarkShipped::class)->name('admin.orders.ship');
                Route::post("admin/orders/unship/{order}", UnmarkShipped::class)->name('admin.orders.unship');
                Route::post("admin/orders/deliver/{order}", MarkDelivered::class)->name('admin.orders.deliver');
                Route::post("admin/orders/undeliver/{order}", UnmarkDelivered::class)->name('admin.orders.undeliver');
                Route::post("admin/orders/restore/{id}", [AdminOrderController::class, 'restore'])->name('admin.orders.restore');
                Route::post("admin/orders/refund/{id}/accept", AcceptRefund::class)->name('admin.orders.refund.accept');
                Route::post("admin/orders/refund/{id}/reject", RejectRefund::class)->name('admin.orders.refund.reject');
                Route::post("admin/orders/cancel/{order}", AdminCancelOrder::class)->name('admin.orders.cancel');
                Route::post("admin/orders/return/{id}", AdminReturnOrder::class)->name('admin.orders.return');
                Route::post("admin/stores/{store}/update", [AdminStoreController::class, 'update'])->name('admin.stores.update');
                Route::post("admin/stores/restore/{id}", [AdminStoreController::class, 'restore'])->name('admin.stores.restore');
                Route::post("admin/stores/{store}/approve", ApproveStore::class)->name('admin.stores.approve');
                Route::post("admin/stores/{store}/unapprove", UnapproveStore::class)->name('admin.stores.unapprove');

                Route::put("admin/user/info/update/{user}", [AdminUserController::class, 'update'])->name('admin.user.update-account');
                Route::put("admin/user/password/update/{user}", AdminUserPasswordResetController::class)->name('admin.user.update-password');
                Route::put("admin/products/update/{id}", [AdminProductController::class, 'update'])->name('admin.products.update');

                Route::delete("admin/user/photo/delete/{user}", [AdminProfilePhotoController::class, 'destroy'])->name('admin.user.clear-profile');
                Route::delete("admin/user/delete/{user}", [AdminUserController::class, 'destroy'])->name('admin.user.delete');
                Route::delete("admin/user/force-delete/{id}", [AdminUserController::class, 'forceDelete'])->name('admin.trashed.users.force-delete');
                Route::delete("admin/products/delete/{product}", [AdminProductController::class, 'destroy'])->name('admin.products.delete');
                Route::delete("admin/products/pictures/{id}/delete", [ProductPhotoController::class, 'destroy'])->name('admin.products.pictures.remove');
                Route::delete("admin/products/force-delete/{id}", [AdminProductController::class, 'forceDelete'])->name('admin.products.force-delete');
                Route::delete("admin/orders/delete/{order}", [AdminOrderController::class, 'destroy'])->name('admin.orders.delete');
                Route::delete("admin/orders/force-delete/{id}", [AdminOrderController::class, 'forceDelete'])->name('admin.products.force-delete');
                Route::delete("admin/stores/delete/{store}", [AdminStoreController::class, 'destroy'])->name('admin.stores.delete');
                Route::delete("admin/stores/force-delete/{id}", [AdminStoreController::class, 'forceDelete'])->name('admin.stores.force-delete');
                Route::delete("admin/stores/api-keys/revoke/{token}", [AdminApiKeyController::class, 'revoke'])->name('admin.stores.api-keys.revoke');
                Route::delete("admin/stores/api-keys/delete/{token}", [AdminApiKeyController::class, 'destroy'])->name('admin.stores.api-keys.delete');
            });

            //Operator routes
            Route::middleware('is-operator')->group(function(){
                Route::get('operator/', [OperatorController::class, 'index'])->name('operator.dashboard');
                Route::get('operator/stores', [OperatorStoreController::class, 'index'])->name('operator.stores');
                Route::get('operator/stores/register', [OperatorStoreController::class, 'create'])->name('operator.stores.create');
                Route::get('operator/stores/{store}/edit', [OperatorStoreController::class, 'edit'])->name('operator.stores.edit');
                Route::get('operator/stores/{store}/api-keys', [OperatorApiKeyController::class, 'index'])->name('operator.stores.api-keys');
                Route::get('operator/stores/{store}/api-keys/create', [OperatorApiKeyController::class, 'create'])->name('operator.stores.api-keys.create');
                Route::get('operator/stored/{store}/api-keys/created', [OperatorApiKeyController::class, 'show'])->name('operator.stores.api-keys.show');

                Route::post('operator/stores/create', [OperatorStoreController::class, 'store'])->name('operator.stores.store');
                Route::post('operator/stores/{store}/update', [OperatorStoreController::class, 'update'])->name('operator.stores.update');
                Route::post('operator/stores/{store}/api-keys/store',[OperatorApiKeyController::class, 'store'])->name('operator.stores.api-keys.store');

                Route::delete('operator/stores/delete/{store}', [OperatorStoreController::class, 'destroy'])->name('operator.stores.delete');
                Route::delete('operator/stores/api-keys/delete/{token}', [OperatorApiKeyController::class, 'destroy'])->name('operator.stores.api-keys.delete');
            });
        });
    });

    //Routes for email verification
    Route::get('email/verify', [EmailVerificationController::class, 'index'])->middleware('auth')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'update'])->middleware(['auth', 'signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'store'])->middleware(['auth', 'throttle:6,1'])->name('verification.sent');

    //Guest Routes
    Route::middleware('is-guest')->group(function () {

        Route::get('/', function () {
            return view('pages.guest.welcome');
        })->name('index');

        Route::view('/about-us', 'pages.guest.about-us')->name('about');
        Route::view('/contact-us', 'pages.guest.contact-us')->name('contact');

        Route::post('/send-mail', ContactEmailController::class)->name('contact-mail.send');

        //Password reset routes
        Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
        Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'edit'])->name('password.reset');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
        Route::post('/reset-password', [ForgotPasswordController::class, 'update'])->middleware('guest')->name('password.update');

        //Register routes
        Route::view("/register", "pages.auth.register")->name("register");
        Route::post("/register", Register::class);

        //Login routes
        Route::view("/login", "pages.auth.login")->name('login');
        Route::post("/login", Login::class)->name('process-login');
    });

});

Route::get('/php-info', function () {
    phpinfo();
});




