<?php

namespace App\Livewire;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

class BudgetManager extends Component
{
    public $period;
    public $budgets = [];

    public function mount()
    {
        // Set periode default ke bulan saat ini
        $this->period = Carbon::now()->format('Y-m');
        $this->loadBudgets();
    }

    public function updatedPeriod()
    {
        // Muat ulang data budget saat periode diganti
        $this->loadBudgets();
    }

    public function loadBudgets()
    {
        $user = Auth::user();
        $categories = $user->categories()->where('transaction_type', 'Pengeluaran')->get();
        $existingBudgets = $user->budgets()->where('period', $this->period)->get()->keyBy('category_id');

        $this->budgets = $categories->map(function ($category) use ($existingBudgets) {
            return [
                'category_id' => $category->id,
                'category_name' => $category->name,
                'amount' => $existingBudgets->get($category->id)->amount ?? 0,
            ];
        })->toArray();
    }

    public function saveBudgets()
    {
        $user = Auth::user();

        foreach ($this->budgets as $budgetData) {
            // Update atau buat budget baru untuk setiap kategori
            Budget::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'category_id' => $budgetData['category_id'],
                    'period' => $this->period,
                ],
                [
                    'amount' => $budgetData['amount'] > 0 ? $budgetData['amount'] : 0,
                ]
            );
        }

        session()->flash('message', 'Anggaran berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.budget-manager');
    }
}
