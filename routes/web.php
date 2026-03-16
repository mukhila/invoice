<?php

use Illuminate\Support\Facades\Route;

use App\Models\DailyGoldRate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return "Cache cleared!";
});


Route::get('/', function () {
    $todayRate = DailyGoldRate::whereDate('rate_date', Carbon::today())->first();
    return view('home', compact('todayRate'));
});
Route::prefix('admin')->group(function () {
    // Public admin routes (no auth required)
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::get('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

    // Protected admin routes
    Route::middleware('adminauth')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/profile', [App\Http\Controllers\Admin\DashboardController::class, 'profile'])->name('admin.profile');

        Route::get('/password/change', [App\Http\Controllers\Admin\AuthController::class, 'showChangePasswordForm'])->name('admin.password.change');
        Route::post('/password/change', [App\Http\Controllers\Admin\AuthController::class, 'changePassword'])->name('admin.password.update');

        Route::resource('employees', App\Http\Controllers\Admin\EmployeeController::class, ['as' => 'admin']);
        Route::resource('gold-rates', App\Http\Controllers\Admin\GoldRateController::class, ['as' => 'admin']);
        Route::resource('gold-plans', App\Http\Controllers\Admin\GoldPlanController::class, ['as' => 'admin']);
        Route::resource('users', App\Http\Controllers\Admin\UserController::class, ['as' => 'admin']);

        // User Plan Routes
        Route::get('/users/{user}/plans', [App\Http\Controllers\Admin\UserPlanController::class, 'index'])->name('admin.users.plans.index');
        Route::get('/users/{user}/plans/create', [App\Http\Controllers\Admin\UserPlanController::class, 'create'])->name('admin.users.plans.create');
        Route::post('/users/{user}/plans', [App\Http\Controllers\Admin\UserPlanController::class, 'store'])->name('admin.users.plans.store');
        Route::get('/user-plans/{userPlan}', [App\Http\Controllers\Admin\UserPlanController::class, 'show'])->name('admin.user-plans.show');

        // Invoice Routes
        Route::get('/payments/{payment}/invoice', [App\Http\Controllers\Admin\InvoiceController::class, 'generate'])->name('admin.invoices.generate');
        Route::get('/user-plans/{userPlan}/consolidated', [App\Http\Controllers\Admin\InvoiceController::class, 'consolidated'])->name('admin.invoices.consolidated');
        Route::get('/invoices/{invoice}', [App\Http\Controllers\Admin\InvoiceController::class, 'show'])->name('admin.invoices.show');

        // EMI Payment Routes
        Route::get('/emi-schedule/{emiSchedule}/pay', [App\Http\Controllers\Admin\UserPlanController::class, 'showPayForm'])->name('admin.emi.pay');
        Route::post('/emi-schedule/{emiSchedule}/pay', [App\Http\Controllers\Admin\UserPlanController::class, 'processPayment'])->name('admin.emi.process');

        // Global User Plan Routes (Sidebar)
        Route::get('/all-user-plans', [App\Http\Controllers\Admin\UserPlanController::class, 'allUserPlans'])->name('admin.all-user-plans.index');
        Route::get('/assign-plan', [App\Http\Controllers\Admin\UserPlanController::class, 'assignPlan'])->name('admin.assign-plan.create');
        Route::post('/assign-plan', [App\Http\Controllers\Admin\UserPlanController::class, 'storeAssignedPlan'])->name('admin.assign-plan.store');

        // User Payments
        Route::get('/user-payments/monthly', [App\Http\Controllers\Admin\MonthlyPaymentStatusController::class, 'index'])->name('admin.user-payments.monthly');

        // PVC Customer Card Routes
        Route::post('/users/{id}/generate-card', [App\Http\Controllers\Admin\CustomerCardController::class, 'generateCard'])->name('admin.users.generate-card');
        Route::get('/users/{id}/card-preview', [App\Http\Controllers\Admin\CustomerCardController::class, 'cardPreview'])->name('admin.users.card-preview');
        Route::get('/users/{id}/card-pdf', [App\Http\Controllers\Admin\CustomerCardController::class, 'downloadPdf'])->name('admin.users.card-pdf');
        Route::get('/users/{id}/card-pdf-preview', [App\Http\Controllers\Admin\CustomerCardController::class, 'streamPdf'])->name('admin.users.card-pdf-preview');
    });
});


// Frontend User Routes
Route::get('/login', [App\Http\Controllers\Auth\UserAuthController::class, 'showLogin'])->name('user.login');
Route::post('/login', [App\Http\Controllers\Auth\UserAuthController::class, 'login'])->name('user.login.post');
Route::post('/register', [App\Http\Controllers\Auth\UserAuthController::class, 'register'])->name('user.register.post');
Route::post('/logout', [App\Http\Controllers\Auth\UserAuthController::class, 'logout'])->name('user.logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Auth\UserAuthController::class, 'dashboard'])->name('user.dashboard');
});
