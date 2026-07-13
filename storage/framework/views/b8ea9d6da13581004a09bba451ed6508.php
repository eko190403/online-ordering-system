<?php $__env->startSection('title', 'Manajemen Pengeluaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800"><i class="fas fa-wallet text-primary"></i> Pengeluaran Operasional</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
        <i class="fas fa-plus"></i> Catat Pengeluaran
    </button>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-danger text-white border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h6>Total Pengeluaran Bulan Ini</h6>
                <h3>Rp <?php echo e(number_format($expenses->where('expense_date', '>=', date('Y-m-01'))->sum('amount'), 0, ',', '.')); ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Tanggal</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4">
                                <strong><?php echo e($expense->expense_date->format('d/m/Y')); ?></strong>
                            </td>
                            <td>
                                <span class="badge bg-secondary"><?php echo e($expense->category); ?></span>
                            </td>
                            <td><?php echo e($expense->description); ?></td>
                            <td class="text-danger fw-bold">Rp <?php echo e(number_format($expense->amount, 0, ',', '.')); ?></td>
                            <td class="text-end pe-4">
                                <form action="<?php echo e(route('admin.expenses.destroy', $expense->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengeluaran ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-icon">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>Belum ada catatan pengeluaran.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Expense Modal -->
<div class="modal fade" id="addExpenseModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?php echo e(route('admin.expenses.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                    <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Catat Pengeluaran Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal</label>
                        <input type="date" name="expense_date" class="form-control" required value="<?php echo e(date('Y-m-d')); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category" class="form-select" required>
                            <option value="Bahan Baku">Bahan Baku (Sayur, Daging, dll)</option>
                            <option value="Operasional">Operasional (Listrik, Air, Gas)</option>
                            <option value="Gaji Pegawai">Gaji Pegawai</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <input type="text" name="description" class="form-control" placeholder="Contoh: Beli Gas 3kg" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah (Rp)</label>
                        <input type="number" name="amount" class="form-control" placeholder="Contoh: 50000" min="0" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cafe\resources\views/admin/expenses/index.blade.php ENDPATH**/ ?>