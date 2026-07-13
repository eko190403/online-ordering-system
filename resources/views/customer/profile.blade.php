@extends('layouts.app')

@section('title', 'Profil Pelanggan')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Profil & Poin -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 rounded-4 text-center p-4 mb-4">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-3">{{ $user->email }} | {{ $user->phone }}</p>
                
                <div class="bg-light rounded p-3 text-start">
                    <p class="text-muted mb-1 small text-uppercase fw-bold">Total Poin Loyalitas</p>
                    <h3 class="fw-bold text-warning mb-0"><i class="fas fa-star"></i> {{ number_format($user->points, 0, ',', '.') }} PTS</h3>
                </div>

                <div class="mt-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 rounded-pill">Logout</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Riwayat Pesanan -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <h4 class="fw-bold mb-4"><i class="fas fa-history text-primary"></i> Riwayat Pesanan</h4>
                
                @if($orders->count() > 0)
                    <div class="list-group">
                        @foreach($orders as $order)
                            <div class="list-group-item list-group-item-action p-3 mb-2 border rounded">
                                <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                    <h5 class="mb-1 fw-bold text-primary">#{{ $order->order_code }}</h5>
                                    <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                                </div>
                                <p class="mb-1 text-muted small">
                                    @foreach($order->items as $item)
                                        {{ $item->qty }}x {{ $item->menu->name }}, 
                                    @endforeach
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <h6 class="fw-bold mb-0">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h6>
                                    <div>
                                        @if($order->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-warning">Dalam Proses</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-basket fa-3x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted">Belum ada riwayat pesanan.</p>
                        <a href="{{ route('menu.index') }}" class="btn btn-primary rounded-pill mt-2">Pesan Sekarang</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
