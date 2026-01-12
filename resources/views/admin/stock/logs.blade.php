@extends('layouts.admin')

@section('title', 'Riwayat Stok')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-history"></i> Riwayat Stok</h2>
    <a href="{{ route('admin.stock.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Menu</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $log->menu->name }}</strong></td>
                            <td>
                                @if($log->type == 'IN')
                                    <span class="badge bg-success">MASUK</span>
                                @else
                                    <span class="badge bg-danger">KELUAR</span>
                                @endif
                            </td>
                            <td>{{ $log->qty }} unit</td>
                            <td>{{ $log->note ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada riwayat</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
