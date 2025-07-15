<?php

namespace App\Livewire;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TransactionForm extends Component
{
    public $transaction_type = 'Pengeluaran';
    public $amount;
    public $transaction_date;
    public $description;
    public $category_id;
    public $payment_method_id;
    public $notes;

    // Properti untuk menampung data dropdown
    public $categories = [];
    public $paymentMethods = [];

    // Aturan validasi
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

    // Method ini berjalan saat komponen pertama kali di-load
    public function mount()
    {
        $this->transaction_date = now()->format('Y-m-d');
        $this->loadDropdownData();
    }

    // Method ini akan dipanggil setiap kali $transaction_type berubah
    public function updatedTransactionType()
    {
        $this->loadDropdownData();
        $this->reset('category_id'); // Reset pilihan kategori
    }

    public function saveTransaction()
    {
        $validatedData = $this->validate();

        Auth::user()->transactions()->create($validatedData);

        session()->flash('message', 'Transaksi berhasil disimpan!');
        $this->reset([
            'amount',
            'description',
            'category_id',
            'payment_method_id',
            'notes'
        ]);
        // Tidak mereset transaction_type dan transaction_date untuk kemudahan input berikutnya
    }

    private function loadDropdownData()
    {
        $user = Auth::user();
        $this->categories = $user->categories()->where('transaction_type', $this->transaction_type)->get();
        $this->paymentMethods = $user->paymentMethods()->get();
    }

    public function render()
    {
        return view('livewire.transaction-form');
    }
}
