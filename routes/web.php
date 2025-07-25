<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\CategoryManager;
use App\Livewire\PaymentMethodManager;
use App\Livewire\ExpenseForm;
use App\Livewire\IncomeForm;
use App\Livewire\TransactionList;
use App\Livewire\TransactionEditForm;
use App\Livewire\TransactionImporter;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Carbon\Carbon;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        $user = Auth::user();

        // Ambil periode dari URL (default 30 hari)
        $days = $request->get('period', 30);
        $startDate = Carbon::today()->subDays($days);
        $endDate = Carbon::today();

        // Hitung Total Pemasukan
        $totalIncome = $user->transactions()
            ->where('transaction_type', 'Pemasukan')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        // Hitung Total Pengeluaran
        $totalExpense = $user->transactions()
            ->where('transaction_type', 'Pengeluaran')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        // Hitung Sisa Uang (Arus Kas)
        $balance = $totalIncome - $totalExpense;

        return view('dashboard', [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'period' => $days,
        ]);
    })->name('dashboard');

    // Route untuk komponen Livewire kita
    Route::get('/categories', CategoryManager::class)->name('categories');
    Route::get('/payment-methods', PaymentMethodManager::class)->name('payment-methods');
    Route::get('/expenses/create', ExpenseForm::class)->name('expenses.create');
    Route::get('/incomes/create', IncomeForm::class)->name('incomes.create');
    Route::get('/transactions', TransactionList::class)->name('transactions.index');
    Route::get('/transactions/{transaction}/edit', TransactionEditForm::class)->name('transactions.edit');
    Route::get('/import', TransactionImporter::class)->name('import');
    Route::get('/import/template', function () {
        $path = public_path('template/template_transaksi.csv');
        $headers = [
            'Content-Type' => 'text/csv',
        ];
        return response()->download($path, 'template_transaksi.csv', $headers);
    })->name('import.template');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
