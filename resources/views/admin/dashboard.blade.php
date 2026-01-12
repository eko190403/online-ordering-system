@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
            <p class="text-muted mb-0">Cafe D.Villa Lampung</p>
        </div>
        <span class="text-muted"><i class="fas fa-calendar"></i> {{ date('d F Y') }}</span>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Pesanan</h6>
                        <h2 class="mb-0">{{ $totalOrders }}</h2>
                    </div>
                    <i class="fas fa-receipt fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Pesanan Masuk</h6>
                        <h2 class="mb-0">{{ $ordersMasuk }}</h2>
                    </div>
                    <i class="fas fa-clock fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Diproses</h6>
                        <h2 class="mb-0">{{ $ordersDiproses }}</h2>
                    </div>
                    <i class="fas fa-spinner fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Selesai</h6>
                        <h2 class="mb-0">{{ $ordersSelesai }}</h2>
                    </div>
                    <i class="fas fa-check-circle fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-success">
            <div class="card-body">
                <h5 class="card-title text-success"><i class="fas fa-money-bill-wave"></i> Total Revenue (Lunas)</h5>
                <h2 class="text-success mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                <small class="text-muted">Total pendapatan terkonfirmasi</small>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-primary">
            <div class="card-body">
                <h5 class="card-title text-primary"><i class="fas fa-calendar-day"></i> Revenue Hari Ini</h5>
                <h2 class="text-primary mb-0">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h2>
                <small class="text-muted">{{ date('d F Y') }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Row -->
<div class="row g-3 mb-4">
    <!-- Menu Terlaris -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-fire"></i> Menu Terlaris</h5>
            </div>
            <div class="card-body">
                @if($topMenus->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($topMenus as $item)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <i class="fas fa-utensils text-primary"></i>
                                    <strong>{{ $item->menu->name ?? 'N/A' }}</strong>
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ $item->total_qty }} terjual</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center py-4">Belum ada data penjualan</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Peak Hours -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-clock"></i> Jam Tersibuk (7 Hari Terakhir)</h5>
            </div>
            <div class="card-body">
                @if($peakHours->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($peakHours as $peak)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <i class="fas fa-business-time text-warning"></i>
                                    <strong>{{ sprintf('%02d:00', $peak->hour) }} - {{ sprintf('%02d:00', $peak->hour + 1) }}</strong>
                                </div>
                                <span class="badge bg-warning text-dark rounded-pill">{{ $peak->count }} orders</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center py-4">Belum ada data</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Revenue Trend Chart -->
<div class="row g-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-chart-line"></i> Trend Revenue (7 Hari Terakhir)</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueTrendChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-utensils"></i> Total Menu</h5>
                <h2 class="text-primary">{{ $totalMenus }}</h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-tags"></i> Total Kategori</h5>
                <h2 class="text-success">{{ $totalCategories }}</h2>
            </div>
        </div>
    </div>
</div>
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
            label: 'Revenue (Rp)',
            data: revenues,
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Revenue: Rp ' + context.parsed.y.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
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
