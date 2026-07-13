@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-tachometer-alt text-primary"></i> Dashboard</h2>
            <p class="text-muted mb-0">Overview performa Cafe D.Villa Lampung</p>
        </div>
        <div class="bg-white px-4 py-2 rounded-pill shadow-sm text-muted fw-medium">
            <i class="fas fa-calendar-alt text-primary me-2"></i> {{ date('d F Y') }}
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted fw-bold mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Pesanan</h6>
                        <h2 class="mb-0 fw-bold text-dark">{{ $totalOrders }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background-color: #dbeafe; color: #1e40af;">
                        <i class="fas fa-receipt fa-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted fw-bold mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Pesanan Masuk</h6>
                        <h2 class="mb-0 fw-bold text-dark">{{ $ordersMasuk }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background-color: #fef3c7; color: #d97706;">
                        <i class="fas fa-clock fa-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted fw-bold mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Diproses</h6>
                        <h2 class="mb-0 fw-bold text-dark">{{ $ordersDiproses }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background-color: #e0f2fe; color: #0284c7;">
                        <i class="fas fa-fire fa-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted fw-bold mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Selesai</h6>
                        <h2 class="mb-0 fw-bold text-dark">{{ $ordersSelesai }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background-color: #dcfce7; color: #16a34a;">
                        <i class="fas fa-check-double fa-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="card border-0" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white;">
            <div class="card-body p-4 position-relative overflow-hidden">
                <i class="fas fa-money-bill-wave position-absolute" style="font-size: 100px; right: -20px; bottom: -20px; opacity: 0.15; transform: rotate(-15deg);"></i>
                <h6 class="fw-bold mb-3 text-uppercase" style="letter-spacing: 1px; color: #a7f3d0;"><i class="fas fa-wallet me-2"></i> Total Revenue (Lunas)</h6>
                <h1 class="display-5 fw-bold mb-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h1>
                <p class="mb-0 text-white-50">Total akumulasi pendapatan terkonfirmasi</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0" style="background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); color: white;">
            <div class="card-body p-4 position-relative overflow-hidden">
                <i class="fas fa-chart-line position-absolute" style="font-size: 100px; right: -20px; bottom: -20px; opacity: 0.15;"></i>
                <h6 class="fw-bold mb-3 text-uppercase" style="letter-spacing: 1px; color: #bfdbfe;"><i class="fas fa-calendar-day me-2"></i> Revenue Hari Ini</h6>
                <h1 class="display-5 fw-bold mb-1">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h1>
                <p class="mb-0 text-white-50">Pendapatan pada {{ date('d F Y') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Row -->
<div class="row g-4 mb-5">
    <!-- Menu Terlaris -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white pt-4 pb-2 border-0">
                <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-crown text-warning me-2"></i> Menu Terlaris</h5>
            </div>
            <div class="card-body">
                @if($topMenus->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($topMenus as $index => $item)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm bg-white" style="width: 40px; height: 40px; border: 1px solid #f1f5f9;">
                                        <span class="fw-bold text-secondary">{{ $index + 1 }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $item->menu->name ?? 'N/A' }}</h6>
                                        <small class="text-muted">{{ $item->menu->category->name ?? '' }}</small>
                                    </div>
                                </div>
                                <span class="badge badge-soft-primary px-3 py-2 rounded-pill fs-6">{{ $item->total_qty }} terjual</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted mb-0">Belum ada data penjualan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Peak Hours -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white pt-4 pb-2 border-0">
                <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-business-time text-primary me-2"></i> Jam Sibuk <span class="fs-6 text-muted fw-normal">(7 Hari Terakhir)</span></h5>
            </div>
            <div class="card-body">
                @if($peakHours->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($peakHours as $peak)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 badge-soft-warning" style="width: 40px; height: 40px;">
                                        <i class="fas fa-clock text-warning"></i>
                                    </div>
                                    <h6 class="mb-0 fw-bold">{{ sprintf('%02d:00', $peak->hour) }} - {{ sprintf('%02d:00', $peak->hour + 1) }}</h6>
                                </div>
                                <span class="badge badge-soft-warning px-3 py-2 rounded-pill fs-6">{{ $peak->count }} orders</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted mb-0">Belum ada data</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Revenue Trend Chart -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white pt-4 pb-2 border-0">
                <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-chart-area text-success me-2"></i> Trend Pendapatan <span class="fs-6 text-muted fw-normal">(7 Hari Terakhir)</span></h5>
            </div>
            <div class="card-body p-4">
                <canvas id="revenueTrendChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card bg-white">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted fw-bold mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Menu Aktif</h6>
                        <h2 class="mb-0 fw-bold text-dark">{{ $totalMenus }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center border" style="width: 56px; height: 56px; color: #475569;">
                        <i class="fas fa-utensils fa-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card bg-white">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted fw-bold mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Kategori</h6>
                        <h2 class="mb-0 fw-bold text-dark">{{ $totalCategories }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center border" style="width: 56px; height: 56px; color: #475569;">
                        <i class="fas fa-tags fa-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-bottom-dashed {
        border-bottom: 1px dashed #e2e8f0;
    }
    .list-group-item {
        background-color: transparent;
        border: none;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Trend Chart
const trendData = @json($revenueTrend);
const labels = trendData.map(item => {
    const date = new Date(item.date);
    return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
});
const revenues = trendData.map(item => item.revenue);

const ctx = document.getElementById('revenueTrendChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: revenues,
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.15)',
            borderWidth: 3,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#10b981',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#1e293b',
                padding: 12,
                titleFont: { family: 'Inter', size: 13 },
                bodyFont: { family: 'Inter', size: 14, weight: 'bold' },
                callbacks: {
                    label: function(context) {
                        return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            x: {
                grid: { display: false, drawBorder: false },
                ticks: { font: { family: 'Inter' }, color: '#64748b' }
            },
            y: {
                border: { dash: [4, 4], display: false },
                grid: { color: '#f1f5f9' },
                beginAtZero: true,
                ticks: {
                    font: { family: 'Inter' },
                    color: '#64748b',
                    callback: function(value) {
                        return 'Rp ' + (value / 1000) + 'k';
                    }
                }
            }
        }
    }
});
</script>
@endsection
