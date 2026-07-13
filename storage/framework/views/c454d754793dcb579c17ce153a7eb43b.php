<?php $__env->startSection('title', 'Daftar Pesanan'); ?>

<?php $__env->startSection('content'); ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4 fw-medium text-muted"><?php echo e($index + 1); ?></td>
                            <td><strong class="text-dark"><?php echo e($order->order_code); ?></strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2 text-primary" style="width: 32px; height: 32px;">
                                        <i class="fas fa-user fs-6"></i>
                                    </div>
                                    <span class="fw-medium"><?php echo e($order->customer_name ?? 'Anonim'); ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-soft-secondary px-2 py-1 fs-6">
                                    <i class="fas fa-chair text-secondary"></i> <?php echo e($order->table_number ?? '-'); ?>

                                </span>
                            </td>
                            <td>
                                <?php if($order->payment_method == 'qris'): ?>
                                    <span class="badge badge-soft-primary px-2 py-1">
                                        <i class="fas fa-qrcode"></i> QRIS
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-soft-success px-2 py-1">
                                        <i class="fas fa-money-bill-wave"></i> Cash
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($order->payment_status == 'paid'): ?>
                                    <span class="badge badge-soft-success px-2 py-1">
                                        <i class="fas fa-check-circle"></i> Lunas
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-soft-warning px-2 py-1">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="text-muted small">
                                    <?php echo e($order->created_at->format('d M Y')); ?><br>
                                    <strong><?php echo e($order->created_at->format('H:i')); ?></strong>
                                </div>
                            </td>
                            <td>
                                <ul class="list-unstyled mb-0 small">
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="text-truncate" style="max-width: 150px;" title="<?php echo e($item->menu->name); ?>">
                                        <span class="fw-bold text-dark"><?php echo e($item->qty); ?>x</span> <?php echo e($item->menu->name); ?>

                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </td>
                            <td><strong class="text-success">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></strong></td>
                            <td>
                                <?php if($order->status == 'masuk'): ?>
                                    <span class="badge badge-soft-danger px-2 py-1">Masuk</span>
                                <?php elseif($order->status == 'diproses'): ?>
                                    <span class="badge badge-soft-info px-2 py-1">Diproses</span>
                                <?php else: ?>
                                    <span class="badge badge-soft-success px-2 py-1">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <?php if($order->status == 'masuk'): ?>
                                        <form action="<?php echo e(route('admin.orders.updateStatus', $order->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="status" value="diproses">
                                            <button type="submit" class="btn btn-sm btn-info text-white rounded-pill px-3 shadow-sm" title="Proses Pesanan">
                                                <i class="fas fa-fire"></i> Proses
                                            </button>
                                        </form>
                                    <?php elseif($order->status == 'diproses'): ?>
                                        <form action="<?php echo e(route('admin.orders.updateStatus', $order->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" title="Tandai Selesai">
                                                <i class="fas fa-check"></i> Selesai
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <?php if($order->payment_status == 'pending' && $order->payment_method != 'cash'): ?>
                                        <form action="<?php echo e(route('admin.orders.confirmPayment', $order->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <button type="submit" class="btn btn-sm btn-warning rounded-pill px-3 shadow-sm" title="Konfirmasi Bayar">
                                                <i class="fas fa-dollar-sign"></i> Bayar
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <a href="<?php echo e(route('admin.orders.print', $order->id)); ?>" target="_blank" class="btn btn-sm btn-light rounded-pill px-3 shadow-sm border">
                                        <i class="fas fa-print text-secondary"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="11" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted opacity-25 mb-3"></i>
                                <p class="text-muted mb-0">Belum ada pesanan</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cafe\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>