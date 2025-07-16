<?php

namespace App\Livewire;

use App\Imports\TransactionsImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class TransactionImporter extends Component
{
    use WithFileUploads;

    public $csvFile;

    public function import()
    {
        $this->validate([
            'csvFile' => 'required|file|mimes:csv,txt' 
        ]);

        try {
            Excel::import(new TransactionsImport, $this->csvFile);

            session()->flash('message', 'File CSV berhasil diimpor!');
            $this->reset('csvFile');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            session()->flash('error', 'Ada beberapa data yang gagal diimpor. Periksa kembali file Anda.');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan. Pastikan format CSV sudah benar. Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.transaction-importer');
    }
}
