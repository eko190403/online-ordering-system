@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1"><i class="fas fa-tags text-primary"></i> Kelola Kategori</h2>
        <p class="text-muted mb-0">Atur kategori untuk mengelompokkan menu</p>
    </div>
    <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="fas fa-plus me-1"></i> Tambah Kategori
    </button>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 10%;">No</th>
                        <th style="width: 30%;">Nama Kategori</th>
                        <th style="width: 20%;">Station</th>
                        <th style="width: 20%;">Jumlah Menu</th>
                        <th class="pe-4 text-end" style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                        <tr>
                            <td class="ps-4 fw-medium text-muted">{{ $index + 1 }}</td>
                            <td><strong class="text-dark">{{ $category->name }}</strong></td>
                            <td>
                                @if($category->station == 'Bar')
                                    <span class="badge bg-info text-dark rounded-pill px-3 py-1"><i class="fas fa-coffee"></i> Bar</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-1"><i class="fas fa-utensils"></i> Dapur</span>
                                @endif
                            </td>
                            <td><span class="badge badge-soft-primary px-3 py-1 rounded-pill">{{ $category->menus->count() }} menu</span></td>
                            <td class="pe-4 text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <button class="btn btn-sm btn-light border text-primary rounded-pill px-3 btn-edit shadow-sm"
                                            data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}"
                                            data-station="{{ $category->station }}"
                                            title="Edit Kategori">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light border text-danger rounded-pill px-3 shadow-sm" title="Hapus Kategori">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="fas fa-tags fa-3x text-muted opacity-25 mb-3"></i>
                                <p class="text-muted mb-0">Belum ada kategori</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Station (Tempat Pemrosesan)</label>
                        <select name="station" class="form-select" required>
                            <option value="Dapur">Dapur (Makanan)</option>
                            <option value="Bar">Bar (Minuman)</option>
                        </select>
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

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editCategoryForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name" id="edit_category_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Station (Tempat Pemrosesan)</label>
                        <select name="station" id="edit_category_station" class="form-select" required>
                            <option value="Dapur">Dapur (Makanan)</option>
                            <option value="Bar">Bar (Minuman)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).on('click', '.btn-edit', function() {
    const id = $(this).data('id');
    const name = $(this).data('name');
    const station = $(this).data('station');
    
    $('#edit_category_name').val(name);
    $('#edit_category_station').val(station);
    $('#editCategoryForm').attr('action', '/admin/categories/' + id);
    
    $('#editCategoryModal').modal('show');
});
</script>
@endsection
