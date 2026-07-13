<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
        }
        .period-info {
            background: #f0f0f0;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th {
            background-color: #343a40;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row {
            font-weight: bold;
            background-color: #e9ecef !important;
            border-top: 2px solid #333;
        }
        .summary {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        .summary-item {
            display: inline-block;
            width: 30%;
            margin: 10px 1%;
            padding: 10px;
            background: white;
            border-left: 3px solid #007bff;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>☕ Cafe D.Villa Lampung</h2>
        <h3>Laporan Penjualan</h3>
        <p>Dicetak: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <div class="period-info">
        <strong>📅 Periode:</strong> {{ $periodLabel ?? 'Semua Periode' }}
    </div>

    @php
        $totalPendapatan = $orders->where('status', 'selesai')->sum('total_price') - $orders->where('status', 'selesai')->sum('discount_amount');
        $totalPengeluaran = isset($expenses) ? $expenses->sum('amount') : 0;
        $labaBersih = $totalPendapatan - $totalPengeluaran;
    @endphp

    <div class="summary">
        <div class="summary-item" style="width: 20%;">
            <strong>Pesanan Selesai</strong><br>
            <h3 style="margin: 5px 0;">{{ $orders->where('status', 'selesai')->count() }}</h3>
        </div>
        <div class="summary-item" style="width: 22%;">
            <strong>Total Pendapatan</strong><br>
            <h3 style="margin: 5px 0;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        </div>
        <div class="summary-item" style="width: 22%; border-left: 3px solid #ffc107;">
            <strong>Total Pengeluaran</strong><br>
            <h3 style="margin: 5px 0;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
        </div>
        <div class="summary-item" style="width: 22%; border-left: 3px solid {{ $labaBersih >= 0 ? '#28a745' : '#dc3545' }};">
            <strong>Laba Bersih</strong><br>
            <h3 style="margin: 5px 0;">Rp {{ number_format($labaBersih, 0, ',', '.') }}</h3>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">Tanggal</th>
                <th width="12%">Kode Order</th>
                <th width="10%">Meja</th>
                <th width="10%">Payment</th>
                <th width="30%">Item</th>
                <th width="12%">Total</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td><strong>{{ $order->order_code }}</strong></td>
                    <td>{{ $order->table_number ?? '-' }}</td>
                    <td>{{ strtoupper($order->payment_method ?? 'CASH') }}</td>
                    <td>
                        @foreach($order->items as $item)
                            {{ $item->menu->name }} ({{ $item->qty }}x)<br>
                        @endforeach
                    </td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6" style="text-align: right;"><strong>Total Pemasukan Kotor:</strong></td>
                <td colspan="2"><strong>Rp {{ number_format($orders->sum('total_price'), 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <h3 style="margin-top: 30px;">Daftar Pengeluaran</h3>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Kategori</th>
                <th width="45%">Deskripsi</th>
                <th width="15%">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($expenses) && count($expenses) > 0)
                @foreach($expenses as $index => $expense)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $expense->expense_date->format('d/m/Y') }}</td>
                        <td>{{ $expense->category }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data pengeluaran</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;"><strong>Total Pengeluaran:</strong></td>
                <td><strong>Rp {{ number_format(isset($expenses) ? $expenses->sum('amount') : 0, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Laporan ini digenerate otomatis oleh sistem Cafe D.Villa Lampung</p>
        <p>© {{ date('Y') }} Cafe D.Villa Lampung. All rights reserved.</p>
    </div>
</body>
</html>
