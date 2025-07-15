<?php

namespace App\Livewire;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TransactionEditForm extends Component
{
    public Transaction $transaction;

    // Properti untuk form
    public $transaction_type;
    public $amount;
    public $transaction_date;
    public $description;
    public $category_id;
    public $payment_method_id;
    public $notes;

    public $categories = [];
    public $paymentMethods = [];

    protected function rules()
    {
        return [
            'transaction_type' => 'required|in:Pemasukan,Pengeluaran',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'description' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'notes' => 'nullable|string',
        ];
    }

    public function mount(Transaction $transaction)
    {
        // Pastikan user hanya bisa edit transaksi miliknya
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        $this->transaction = $transaction;

        // Isi properti form dengan data dari transaksi yang ada
        $this->transaction_type = $transaction->transaction_type;
        $this->amount = $transaction->amount;
        $this->transaction_date = $transaction->transaction_date;
        $this->description = $transaction->description;
        $this->category_id = $transaction->category_id;
        $this->payment_method_id = $transaction->payment_method_id;
        $this->notes = $transaction->notes;

        $this->loadDropdownData();
    }

    public function updatedTransactionType()
    {
        $this->loadDropdownData();
        $this->reset('category_id');
    }

    public function updateTransaction()
    {
        $validatedData = $this->validate();
        $this->transaction->update($validatedData);
        session()->flash('message', 'Transaksi berhasil diperbarui!');
        return redirect()->route('transactions.index');
    }

    private function loadDropdownData()
    {
        $user = Auth::user();
        $this->categories = $user->categories()->where('transaction_type', $this->transaction_type)->get();
        $this->paymentMethods = $user->paymentMethods()->get();
    }

    public function render()
    {
        return view('livewire.transaction-edit-form');
    }
}
