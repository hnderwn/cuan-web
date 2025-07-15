<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionList extends Component
{
    use WithPagination;

    public function render()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with(['category', 'paymentMethod']) // Eager Loading
            ->latest('transaction_date')
            ->paginate(10); // Ambil 10 data per halaman

        return view('livewire.transaction-list', [
            'transactions' => $transactions
        ]);
    }

    public function deleteTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        $transaction->delete();
        session()->flash('message', 'Transaksi berhasil dihapus.');
    }
}
