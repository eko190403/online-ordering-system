@extends('layouts.admin')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-receipt"></i> Daftar Pesanan</h2>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Order</th>
                        <th>Nama Customer</th>
                        <th>Nomor Meja</th>
                        <th>Pembayaran</th>
                        <th>Status Bayar</th>
                        <th>Tanggal</th>
                        <th>Item</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $order->order_code }}</strong></td>
                            <td>
                                <i class="fas fa-user"></i> {{ $order->customer_name ?? 'Anonim' }}
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    <i class="fas fa-chair"></i> Meja {{ $order->table_number ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @if($order->payment_method == 'qris')
                                    <span class="badge bg-primary">
                                        <i class="fas fa-qrcode"></i> QRIS
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        <i class="fas fa-money-bill-wave"></i> Cash
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($order->payment_status == 'paid')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Lunas
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
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
                            <td>
                                <div class="btn-group-vertical d-flex gap-1" role="group">
                                    @if($order->status == 'masuk')
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="diproses">
                                            <button type="submit" class="btn btn-sm btn-info">
                                                <i class="fas fa-spinner"></i> Proses
                                            </button>
                                        </form>
                                    @elseif($order->status == 'diproses')
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i> Selesai
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($order->payment_status == 'pending' && $order->payment_method != 'cash')
                                        <form action="{{ route('admin.orders.confirmPayment', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                <i class="fas fa-dollar-sign"></i> Konfirmasi Bayar
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-print"></i> Print
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Belum ada pesanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
