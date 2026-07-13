@extends('layouts.admin')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1"><i class="fas fa-receipt text-primary"></i> Daftar Pesanan</h2>
        <p class="text-muted mb-0">Kelola pesanan pelanggan dari satu tempat</p>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Kode Order</th>
                        <th>Pelanggan</th>
                        <th>Meja</th>
                        <th>Pembayaran</th>
                        <th>Status Bayar</th>
                        <th>Waktu</th>
                        <th style="min-width: 150px;">Item</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="pe-4 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $index => $order)
                        <tr>
                            <td class="ps-4 fw-medium text-muted">{{ $index + 1 }}</td>
                            <td><strong class="text-dark">{{ $order->order_code }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2 text-primary" style="width: 32px; height: 32px;">
                                        <i class="fas fa-user fs-6"></i>
                                    </div>
                                    <span class="fw-medium">{{ $order->customer_name ?? 'Anonim' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-soft-secondary px-2 py-1 fs-6">
                                    <i class="fas fa-chair text-secondary"></i> {{ $order->table_number ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @if($order->payment_method == 'qris')
                                    <span class="badge badge-soft-primary px-2 py-1">
                                        <i class="fas fa-qrcode"></i> QRIS
                                    </span>
                                @else
                                    <span class="badge badge-soft-success px-2 py-1">
                                        <i class="fas fa-money-bill-wave"></i> Cash
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($order->payment_status == 'paid')
                                    <span class="badge badge-soft-success px-2 py-1">
                                        <i class="fas fa-check-circle"></i> Lunas
                                    </span>
                                @else
                                    <span class="badge badge-soft-warning px-2 py-1">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="text-muted small">
                                    {{ $order->created_at->format('d M Y') }}<br>
                                    <strong>{{ $order->created_at->format('H:i') }}</strong>
                                </div>
                            </td>
                            <td>
                                <ul class="list-unstyled mb-0 small">
                                @foreach($order->items as $item)
                                    <li class="text-truncate" style="max-width: 150px;" title="{{ $item->menu->name }}">
                                        <span class="fw-bold text-dark">{{ $item->qty }}x</span> {{ $item->menu->name }}
                                    </li>
                                @endforeach
                                </ul>
                            </td>
                            <td><strong class="text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                            <td>
                                @if($order->status == 'masuk')
                                    <span class="badge badge-soft-danger px-2 py-1">Masuk</span>
                                @elseif($order->status == 'diproses')
                                    <span class="badge badge-soft-info px-2 py-1">Diproses</span>
                                @else
                                    <span class="badge badge-soft-success px-2 py-1">Selesai</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    @if($order->status == 'masuk')
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="diproses">
                                            <button type="submit" class="btn btn-sm btn-info text-white rounded-pill px-3 shadow-sm" title="Proses Pesanan">
                                                <i class="fas fa-fire"></i> Proses
                                            </button>
                                        </form>
                                    @elseif($order->status == 'diproses')
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" title="Tandai Selesai">
                                                <i class="fas fa-check"></i> Selesai
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($order->payment_status == 'pending' && $order->payment_method != 'cash')
                                        <form action="{{ route('admin.orders.confirmPayment', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-warning rounded-pill px-3 shadow-sm" title="Konfirmasi Bayar">
                                                <i class="fas fa-dollar-sign"></i> Bayar
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="btn btn-sm btn-light rounded-pill px-3 shadow-sm border">
                                        <i class="fas fa-print text-secondary"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted opacity-25 mb-3"></i>
                                <p class="text-muted mb-0">Belum ada pesanan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
