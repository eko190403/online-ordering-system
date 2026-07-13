

<?php $__env->startSection('title', 'Laporan Penjualan'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-chart-line"></i> Laporan Penjualan</h2>
    <div>
        <a href="<?php echo e(route('admin.reports.excel', ['period' => request('period'), 'month' => request('month'), 'year' => request('year')])); ?>" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        <a href="<?php echo e(route('admin.reports.pdf', ['period' => request('period'), 'month' => request('month'), 'year' => request('year')])); ?>" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </div>
</div>

<!-- Filter Periode -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('admin.reports.sales')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-bold"><i class="fas fa-calendar"></i> Periode</label>
                <select name="period" id="periodSelect" class="form-select" onchange="togglePeriodInputs()">
                    <option value="all" <?php echo e($period == 'all' ? 'selected' : ''); ?>>Semua Waktu</option>
                    <option value="today" <?php echo e($period == 'today' ? 'selected' : ''); ?>>Hari Ini</option>
                    <option value="monthly" <?php echo e($period == 'monthly' ? 'selected' : ''); ?>>Bulanan</option>
                    <option value="yearly" <?php echo e($period == 'yearly' ? 'selected' : ''); ?>>Tahunan</option>
                </select>
            </div>
            <div class="col-md-3" id="monthInput" style="display: <?php echo e($period == 'monthly' ? 'block' : 'none'); ?>;">
                <label class="form-label fw-bold">Pilih Bulan</label>
                <input type="month" name="month" class="form-control" value="<?php echo e($month); ?>">
            </div>
            <div class="col-md-3" id="yearInput" style="display: <?php echo e($period == 'yearly' ? 'block' : 'none'); ?>;">
                <label class="form-label fw-bold">Pilih Tahun</label>
                <input type="number" name="year" class="form-control" value="<?php echo e($year); ?>" min="2020" max="2099">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<?php
    $totalPendapatan = $orders->where('status', 'selesai')->sum('total_price') - $orders->where('status', 'selesai')->sum('discount_amount');
    $totalPengeluaran = isset($expenses) ? $expenses->sum('amount') : 0;
    $labaBersih = $totalPendapatan - $totalPengeluaran;
?>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h6>Pesanan Selesai</h6>
                <h3><?php echo e($orders->where('status', 'selesai')->count()); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h6>Total Pendapatan</h6>
                <h3>Rp <?php echo e(number_format($totalPendapatan, 0, ',', '.')); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h6>Total Pengeluaran</h6>
                <h3>Rp <?php echo e(number_format($totalPengeluaran, 0, ',', '.')); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card <?php echo e($labaBersih >= 0 ? 'bg-success' : 'bg-danger'); ?> text-white border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h6>Laba Bersih</h6>
                <h3>Rp <?php echo e(number_format($labaBersih, 0, ',', '.')); ?></h3>
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
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                            <td><strong><?php echo e($order->order_code); ?></strong></td>
                            <td>
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <small><?php echo e($item->menu->name); ?> (<?php echo e($item->qty); ?>x)</small><br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td><strong>Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></strong></td>
                            <td>
                                <?php if($order->status == 'masuk'): ?>
                                    <span class="badge bg-warning">Masuk</span>
                                <?php elseif($order->status == 'diproses'): ?>
                                    <span class="badge bg-info">Diproses</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="4" class="text-end">Total Keseluruhan:</td>
                        <td colspan="2">Rp <?php echo e(number_format($orders->sum('total_price'), 0, ',', '.')); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title mb-3">Detail Pengeluaran</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($expenses) && count($expenses) > 0): ?>
                        <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($expense->expense_date->format('d/m/Y')); ?></td>
                                <td><span class="badge bg-secondary"><?php echo e($expense->category); ?></span></td>
                                <td><?php echo e($expense->description); ?></td>
                                <td><strong>Rp <?php echo e(number_format($expense->amount, 0, ',', '.')); ?></strong></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada pengeluaran di periode ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="4" class="text-end">Total Keseluruhan:</td>
                        <td>Rp <?php echo e(number_format(isset($expenses) ? $expenses->sum('amount') : 0, 0, ',', '.')); ?></td>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cafe\resources\views/admin/reports/sales.blade.php ENDPATH**/ ?>