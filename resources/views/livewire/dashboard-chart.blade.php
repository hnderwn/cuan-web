<div wire:init="loadChartData" class="bg-white overflow-hidden shadow-sm rounded-xl">
    <div class="p-6 text-gray-900">
        <div class="mb-4 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button
                    wire:click="showChart('pie')"
                    class="{{ $activeChart === 'pie' ? 'border-brand-dark text-brand-dark' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Pengeluaran per Kategori
                </button>
                <button
                    wire:click="showChart('bar')"
                    class="{{ $activeChart === 'bar' ? 'border-brand-dark text-brand-dark' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Tren Pengeluaran
                </button>
            </nav>
        </div>

        <div class="mt-4">
            @if ($activeChart === 'pie')
            <div wire:ignore>
                <canvas id="expensePieChart"></canvas>
            </div>
            @endif

            @if ($activeChart === 'bar')
            <div wire:ignore>
                <canvas id="expenseBarChart"></canvas>
            </div>
            @endif
        </div>
    </div>
</div>

@script
<script>
    let expensePieChart = null;
    let expenseBarChart = null;

    const brandColors = [
        '#163020',
        '#1d7942',
        '#8BC34A',
        '#FF9800',
        '#2196F3',
        '#E91E63',
        '#CDDC39',
        '#795548',
        '#673AB7',
        '#00BCD4'
    ];

    Livewire.on('updateCharts', (event) => {
        setTimeout(() => {
            if (document.getElementById('expensePieChart')) {
                const pieChartData = event.pieChart;
                const pieCtx = document.getElementById('expensePieChart');
                if (expensePieChart) expensePieChart.destroy();
                expensePieChart = new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: pieChartData.labels,
                        datasets: [{
                            label: 'Pengeluaran',
                            data: pieChartData.data,
                            backgroundColor: brandColors
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }

            if (document.getElementById('expenseBarChart')) {
                const barChartData = event.barChart;
                const barCtx = document.getElementById('expenseBarChart');
                if (expenseBarChart) expenseBarChart.destroy();
                expenseBarChart = new Chart(barCtx, {
                    type: 'polarArea',
                    data: {
                        labels: barChartData.labels,
                        datasets: [{
                            label: 'Total Pengeluaran',
                            data: barChartData.data,
                            backgroundColor: brandColors
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }
        }, 1);
    });
</script>
@endscript