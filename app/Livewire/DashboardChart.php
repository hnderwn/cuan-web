<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;

class DashboardChart extends Component
{
    public $activeChart = 'pie';
    public $period; // Properti untuk menerima periode dari dashboard

    // Method mount untuk menerima data saat komponen pertama kali dibuat
    public function mount($period)
    {
        $this->period = $period;
    }

    public function showChart($chartName)
    {
        $this->activeChart = $chartName;
        $this->loadChartData();
    }

    public function loadChartData()
    {
        $user = Auth::user();
        // Kirim periode ke method-method persiapan data
        $pieChartData = $this->preparePieChartData($user, $this->period);
        $barChartData = $this->prepareBarChartData($user, $this->period);

        $this->dispatch('updateCharts', pieChart: $pieChartData, barChart: $barChartData);
    }

    private function preparePieChartData($user, $days)
    {
        $startDate = Carbon::today()->subDays($days);
        $endDate = Carbon::today();

        $expenseByCategory = $user->transactions()
            ->where('transactions.transaction_type', 'Pengeluaran')
            ->whereBetween('transaction_date', [$startDate, $endDate]) // Gunakan periode
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name as category_name', DB::raw('SUM(transactions.amount) as total'))
            ->groupBy('categories.name')
            ->orderBy('total', 'desc')
            ->pluck('total', 'category_name');

        return [
            'labels' => $expenseByCategory->keys(),
            'data' => $expenseByCategory->values(),
        ];
    }

    private function prepareBarChartData($user, $days)
    {
        // Untuk bar chart, kita tetap tampilkan 6 bulan terakhir agar tren terlihat
        // tapi bisa disesuaikan jika ingin ikut periode juga
        $expenses = $user->transactions()
            ->where('transaction_type', 'Pengeluaran')
            ->select(
                DB::raw('SUM(amount) as total'),
                DB::raw("DATE_FORMAT(transaction_date, '%Y-%m') as month")
            )
            ->where('transaction_date', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $labels = [];
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthKey = $month->format('Y-m');
            $labels[] = $month->format('M Y');

            $monthlyExpense = $expenses->firstWhere('month', $monthKey);
            $data[] = $monthlyExpense ? $monthlyExpense->total : 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public function render()
    {
        return view('livewire.dashboard-chart');
    }
}
