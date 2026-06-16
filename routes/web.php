<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\LogoutController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get("/auth/register", [RegisterController::class, 'index'])->name("register");
Route::post("/auth/register", [RegisterController::class, 'store'])->name("register.store");

Route::get("/auth/login", [LoginController::class, 'index'])->name("login");
Route::post("/auth/login", [LoginController::class, 'store'])->name("login.store");

Route::post("/auth/logout", [LogoutController::class, "store"])->name("logout.store");

Route::get("/email/verify/{id}/{hash}", function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route("dashboard")->with("success", "Tu correo electrónico ha sido verificado. Empieza Creando tu Primer Presupuesto!");
})->middleware(['auth', 'signed',])->name("verification.verify");

Route::get("email/verify", function () {
    return view("Auth.verifyEmail");
})->middleware("auth")->name("verification.notice");

Route::post("email/verify/resend", function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with("success", "Se ha enviado un correo electrónico de verificación a tu dirección electrónico.");
})->middleware(["auth", "throttle:1,1"])->name("verification.send");

Route::prefix("/dashboard")->group(function () {
    Route::get("/", [BudgetController::class, "index"])->name("dashboard");
    Route::get("/budgets/create", [BudgetController::class, "create"])->name("budgets.create");
    Route::post("/budgets", [BudgetController::class, "store"])->name("budgets.store");

    Route::get("budgets/{budget}", [BudgetController::class, "show"])->name("budgets.show");

    Route::get("/budgets/{budget}/edit", [BudgetController::class, "edit"])->name("budgets.edit");
    Route::put("/budgets/{budget}", [BudgetController::class, "update"])->name("budgets.update");

    Route::delete("/budgets/{budget}", [BudgetController::class, "destroy"])->name("budgets.destroy");
    Route::post("/budgets/{budget}/expenses", [\App\Http\Controllers\ExpenseController::class, "store"])->name("expenses.store");
    Route::put("/budgets/{budget}/expenses/{expense}", [\App\Http\Controllers\ExpenseController::class, "update"])->name("expenses.update");
    Route::delete("/budgets/{budget}/expenses/{expense}", [\App\Http\Controllers\ExpenseController::class, "destroy"])->name("expenses.destroy");
});

Route::middleware(["auth", "verified", "subscribed"])->prefix("dashboard")->group(function () {
    Route::post("/budgets/{budget}/chat", [\App\Http\Controllers\BudgetChatController::class, "store"])->name("budgets.chat");
    Route::post("/budgets/{budget}/scan-ticket", [\App\Http\Controllers\TicketScanController::class, "store"])->name("budgets.scan-ticket");
});

Route::middleware(["auth", "verified"])->group(function () {
    Route::post("/subscription-checkout/{plan}", [\App\Http\Controllers\SubscriptionCheckout::class, "store"])->name("subscription.checkout")->whereIn("plan", ["monthly", "yearly"]);

    Route::view("/billing/success", "billing.success")->name("billing.success");
    Route::view("/billing/cancel", "billing.cancel")->name("billing.cancel");

    Route::get("/plans", function () {
        return \Inertia\Inertia::render("Pro/Plans");
    })->name("plans");

    Route::get('/subscription', [\App\Http\Controllers\SubscriptionController::class, 'show'])
        ->name('subscription.manage');

    Route::post('/subscription/swap/{plan}', [\App\Http\Controllers\SubscriptionController::class, 'swap'])
        ->name('subscription.swap')
        ->whereIn('plan', ['monthly', 'yearly']);

    Route::post('/subscription/cancel', [\App\Http\Controllers\SubscriptionController::class, 'cancel'])
        ->name('subscription.cancel');

    Route::post('/subscription/resume', [\App\Http\Controllers\SubscriptionController::class, 'resume'])
        ->name('subscription.resume');

    Route::get("/billing", function (Request $request) {
        return $request->user()->redirectToBillingPortal(route('dashboard'));
    })->name("billing");
});
