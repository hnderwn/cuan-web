<?php

namespace App\Imports;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\PaymentMethod;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionsImport implements ToModel, WithHeadingRow
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function model(array $row)
    {
        $category = $this->user->categories()->firstOrCreate(
            ['name' => $row['kategori'], 'transaction_type' => $row['tipe']],
            ['transaction_type' => $row['tipe']]
        );

        $paymentMethod = $this->user->paymentMethods()->firstOrCreate(
            ['name' => $row['metode_bayar']]
        );

        return new Transaction([
            'user_id'           => $this->user->id,
            'category_id'       => $category->id,
            'payment_method_id' => $paymentMethod->id,
            'transaction_type'  => $row['tipe'],
            'amount'            => $row['jumlah'],
            'description'       => $row['deskripsi'],
            'transaction_date'  => Carbon::parse($row['tanggal'])->toDateString(),
        ]);
    }
}
