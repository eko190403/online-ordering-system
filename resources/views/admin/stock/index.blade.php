@extends('layouts.admin')

@section('title', 'Manajemen Stok')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1"><i class="fas fa-boxes text-primary"></i> Manajemen Stok</h2>
        <p class="text-muted mb-0">Atur ketersediaan menu</p>
    </div>
    <a href="{{ route('admin.stock.logs') }}" class="btn btn-light border text-primary rounded-pill px-4 shadow-sm">
        <i class="fas fa-history me-1"></i> Riwayat Stok
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 10%;">No</th>
                        <th style="width: 35%;">Menu</th>
                        <th style="width: 25%;">Kategori</th>
                        <th style="width: 15%;">Status</th>
                        <th class="pe-4 text-end" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus as $index => $menu)
                        @php
                            $stock = $stocks->where('menu_id', $menu->id)->first();
                            $qty = $stock ? $stock->quantity : 0;
                        @endphp
                        <tr>
                            <td class="ps-4 fw-medium text-muted">{{ $index + 1 }}</td>
                            <td><strong class="text-dark">{{ $menu->name }}</strong></td>
                            <td><span class="badge badge-soft-secondary px-2 py-1 fs-6">{{ $menu->category->name }}</span></td>
                            <td>
                                @if($qty > 0)
                                    <span class="badge badge-soft-success px-3 py-1 rounded-pill">Tersedia</span>
                                @else
                                    <span class="badge badge-soft-danger px-3 py-1 rounded-pill">Habis</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border text-primary rounded-pill px-3 shadow-sm btn-stock-toggle" 
                                        data-id="{{ $menu->id }}"
                                        data-name="{{ $menu->name }}"
                                        data-current="{{ $qty > 0 ? 'tersedia' : 'habis' }}"
                                        title="Ubah Status">
                                    <i class="fas fa-exchange-alt"></i> Ubah
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Update Stok -->
<div class="modal fade" id="stockModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="stockForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockModalTitle">Ubah Status Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Menu</label>
                        <input type="text" id="stock_menu_name" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Stok</label>
                        <select name="status" class="form-select" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="habis">Habis</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea name="note" class="form-control" rows="3" placeholder="Contoh: Stok habis karena ramai pembeli"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).on('click', '.btn-stock-toggle', function() {
    const id = $(this).data('id');
    const name = $(this).data('name');
    const current = $(this).data('current');
    
    $('#stock_menu_name').val(name);
    $('#stockForm').attr('action', '/admin/stock/' + id + '/toggle');
    
    // Set default value opposite of current
    if (current === 'tersedia') {
        $('select[name="status"]').val('habis');
    } else {
        $('select[name="status"]').val('tersedia');
    }
    
    $('#stockModal').modal('show');
});
</script>
@endsection
