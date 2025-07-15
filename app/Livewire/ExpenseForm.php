<?php

namespace App\Livewire;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ExpenseForm extends Component
{
    public $transaction_type = 'Pengeluaran'; // Dikunci di sini
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
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'description' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'notes' => 'nullable|string',
        ];
    }

    public function mount()
    {
        $this->transaction_date = now()->format('Y-m-d');
        $this->loadDropdownData();
    }

    public function saveTransaction()
    {
        // Kita tambahkan 'transaction_type' secara manual sebelum validasi
        $this->validate();

        $dataToSave = [
            'transaction_type' => $this->transaction_type,
            'amount' => $this->amount,
            'transaction_date' => $this->transaction_date,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'payment_method_id' => $this->payment_method_id,
            'notes' => $this->notes,
        ];

        Auth::user()->transactions()->create($dataToSave);

        session()->flash('message', 'Pengeluaran berhasil disimpan!');
        $this->reset(['amount', 'description', 'category_id', 'payment_method_id', 'notes']);
    }

    private function loadDropdownData()
    {
        $user = Auth::user();
        $this->categories = $user->categories()->where('transaction_type', 'Pengeluaran')->get();
        $this->paymentMethods = $user->paymentMethods()->get();
    }

    public function render()
    {
        return view('livewire.expense-form');
    }
}
