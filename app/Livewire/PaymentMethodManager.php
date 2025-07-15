<?php

namespace App\Livewire;

use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PaymentMethodManager extends Component
{
    public $name;
    public $editingPaymentMethodId = null;

    protected function rules()
    {
        return ['name' => 'required|string|max:255'];
    }

    public function savePaymentMethod()
    {
        $validatedData = $this->validate();
        Auth::user()->paymentMethods()->create($validatedData);
        $this->resetForm();
        session()->flash('message', 'Metode Pembayaran berhasil ditambahkan.');
    }

    public function editPaymentMethod($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403);
        }
        $this->editingPaymentMethodId = $paymentMethod->id;
        $this->name = $paymentMethod->name;
    }

    public function updatePaymentMethod()
    {
        $validatedData = $this->validate();
        $paymentMethod = PaymentMethod::findOrFail($this->editingPaymentMethodId);
        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403);
        }
        $paymentMethod->update($validatedData);
        $this->resetForm();
        session()->flash('message', 'Metode Pembayaran berhasil diperbarui.');
    }

    public function deletePaymentMethod($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403);
        }
        $paymentMethod->delete();
        session()->flash('message', 'Metode Pembayaran berhasil dihapus.');
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['name', 'editingPaymentMethodId']);
    }

    public function render()
    {
        $paymentMethods = PaymentMethod::where('user_id', Auth::id())->latest()->get();
        return view('livewire.payment-method-manager', [
            'paymentMethods' => $paymentMethods
        ]);
    }
}
