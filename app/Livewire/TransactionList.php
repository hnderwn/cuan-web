<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionList extends Component
{
    use WithPagination;

    public $sortField = 'transaction_date';
    public $sortDirection = 'desc';

    public $search = '';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
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

    public function render()
    {
        $query = Transaction::where('user_id', Auth::id())
            ->with(['category', 'paymentMethod']);

        if ($this->search) {
            $query->where('description', 'like', '%' . $this->search . '%');
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        $transactions = $query->paginate(10);

        return view('livewire.transaction-list', [
            'transactions' => $transactions
        ]);
    }
}
