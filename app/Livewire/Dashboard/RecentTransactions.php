<?php

namespace App\Livewire\Dashboard;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecentTransactions extends Component
{
    public function render()
    {
        $transactions = Transaction::where('user_id', Auth::id())
                                    ->with('category')
                                    ->latest('transaction_date')
                                    ->latest('id') // Tambahan sort untuk transaksi di hari yg sama
                                    ->take(5) // Ambil 5 data terbaru
                                    ->get();

        return view('livewire.dashboard.recent-transactions', [
            'transactions' => $transactions
        ]);
    }
}