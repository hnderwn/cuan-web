<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CategoryManager extends Component
{
    // Properti ini dipakai untuk form Tambah dan Edit
    public $name;
    public $transaction_type = 'Pengeluaran';

    // Properti untuk menandai mode edit
    public $editingCategoryId = null;

    // Aturan validasi terpusat
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'transaction_type' => 'required|in:Pemasukan,Pengeluaran',
        ];
    }

    // Method untuk masuk ke mode edit
    public function editCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        if ($category->user_id !== Auth::id()) {
            abort(403); // Mencegah user mengedit data orang lain
        }

        $this->editingCategoryId = $category->id;
        $this->name = $category->name;
        $this->transaction_type = $category->transaction_type;
    }

    // Method untuk membatalkan mode edit
    public function cancelEdit()
    {
        $this->resetForm();
    }

    // Method untuk menyimpan data BARU
    public function saveCategory()
    {
        $validatedData = $this->validate(); // Memakai rules() terpusat
        Auth::user()->categories()->create($validatedData);

        $this->resetForm();
        session()->flash('message', 'Kategori berhasil ditambahkan.');
    }

    // Method untuk menyimpan data HASIL EDIT
    public function updateCategory()
    {
        $validatedData = $this->validate(); // Memakai rules() terpusat
        $category = Category::findOrFail($this->editingCategoryId);
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        $category->update($validatedData);

        $this->resetForm();
        session()->flash('message', 'Kategori berhasil diperbarui.');
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }
        $category->delete();
        session()->flash('message', 'Kategori berhasil dihapus.');
    }

    // Method untuk mereset form
    private function resetForm()
    {
        $this->reset(['name', 'transaction_type', 'editingCategoryId']);
        $this->transaction_type = 'Pengeluaran'; // Kembalikan ke default
    }

    public function render()
    {
        $categories = Category::where('user_id', Auth::id())->latest()->get();
        return view('livewire.category-manager', [
            'categories' => $categories,
        ]);
    }
}
