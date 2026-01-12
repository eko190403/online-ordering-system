@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-chart-line"></i> Laporan Penjualan</h2>
    <div>
        <a href="{{ route('admin.reports.excel', ['period' => request('period'), 'month' => request('month'), 'year' => request('year')]) }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        <a href="{{ route('admin.reports.pdf', ['period' => request('period'), 'month' => request('month'), 'year' => request('year')]) }}" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </div>
</div>

<!-- Filter Periode -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.sales') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-bold"><i class="fas fa-calendar"></i> Periode</label>
                <select name="period" id="periodSelect" class="form-select" onchange="togglePeriodInputs()">
                    <option value="all" {{ $period == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                    <option value="today" {{ $period == 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                </select>
            </div>
            <div class="col-md-3" id="monthInput" style="display: {{ $period == 'monthly' ? 'block' : 'none' }};">
                <label class="form-label fw-bold">Pilih Bulan</label>
                <input type="month" name="month" class="form-control" value="{{ $month }}">
            </div>
            <div class="col-md-3" id="yearInput" style="display: {{ $period == 'yearly' ? 'block' : 'none' }};">
                <label class="form-label fw-bold">Pilih Tahun</label>
                <input type="number" name="year" class="form-control" value="{{ $year }}" min="2020" max="2099">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Total Pesanan</h6>
                <h3>{{ $orders->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Pesanan Selesai</h6>
                <h3>{{ $orders->where('status', 'selesai')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6>Total Pendapatan</h6>
                <h3>Rp {{ number_format($orders->where('status', 'selesai')->sum('total_price'), 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">Detail Penjualan</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Order</th>
                        <th>Item</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $order->order_code }}</strong></td>
                            <td>
                                @foreach($order->items as $item)
                                    <small>{{ $item->menu->name }} ({{ $item->qty }}x)</small><br>
                                @endforeach
                            </td>
                            <td><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                            <td>
                                @if($order->status == 'masuk')
                                    <span class="badge bg-warning">Masuk</span>
                                @elseif($order->status == 'diproses')
                                    <span class="badge bg-info">Diproses</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="4" class="text-end">Total Keseluruhan:</td>
                        <td colspan="2">Rp {{ number_format($orders->sum('total_price'), 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
function togglePeriodInputs() {
    const period = document.getElementById('periodSelect').value;
    const monthInput = document.getElementById('monthInput');
    const yearInput = document.getElementById('yearInput');
    
    monthInput.style.display = 'none';
    yearInput.style.display = 'none';
    
    if (period === 'monthly') {
        monthInput.style.display = 'block';
    } else if (period === 'yearly') {
        yearInput.style.display = 'block';
    }
}
</script>
@endsection
