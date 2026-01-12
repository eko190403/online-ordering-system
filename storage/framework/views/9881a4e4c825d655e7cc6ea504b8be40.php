

<?php $__env->startSection('title', 'Manajemen Stok'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-boxes"></i> Manajemen Stok</h2>
    <a href="<?php echo e(route('admin.stock.logs')); ?>" class="btn btn-info">
        <i class="fas fa-history"></i> Riwayat Stok
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Menu</th>
                        <th>Kategori</th>
                        <th>Stok Tersedia</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $stock = $stocks->where('menu_id', $menu->id)->first();
                            $qty = $stock ? $stock->quantity : 0;
                        ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td><strong><?php echo e($menu->name); ?></strong></td>
                            <td><?php echo e($menu->category->name); ?></td>
                            <td>
                                <?php if($qty > 0): ?>
                                    <span class="badge bg-success">Tersedia</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Habis</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary btn-stock-toggle" 
                                        data-id="<?php echo e($menu->id); ?>"
                                        data-name="<?php echo e($menu->name); ?>"
                                        data-current="<?php echo e($qty > 0 ? 'tersedia' : 'habis'); ?>">
                                    <i class="fas fa-exchange-alt"></i> Ubah Status
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Update Stok -->
<div class="modal fade" id="stockModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="stockForm" method="POST">
            <?php echo csrf_field(); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cafe\resources\views/admin/stock/index.blade.php ENDPATH**/ ?>