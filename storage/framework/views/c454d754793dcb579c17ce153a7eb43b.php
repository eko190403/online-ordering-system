

<?php $__env->startSection('title', 'Daftar Pesanan'); ?>

<?php $__env->startSection('content'); ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td><strong><?php echo e($order->order_code); ?></strong></td>
                            <td>
                                <i class="fas fa-user"></i> <?php echo e($order->customer_name ?? 'Anonim'); ?>

                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    <i class="fas fa-chair"></i> Meja <?php echo e($order->table_number ?? '-'); ?>

                                </span>
                            </td>
                            <td>
                                <?php if($order->payment_method == 'qris'): ?>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-qrcode"></i> QRIS
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-money-bill-wave"></i> Cash
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($order->payment_status == 'paid'): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Lunas
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
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
                            <td>
                                <div class="btn-group-vertical d-flex gap-1" role="group">
                                    <?php if($order->status == 'masuk'): ?>
                                        <form action="<?php echo e(route('admin.orders.updateStatus', $order->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="status" value="diproses">
                                            <button type="submit" class="btn btn-sm btn-info">
                                                <i class="fas fa-spinner"></i> Proses
                                            </button>
                                        </form>
                                    <?php elseif($order->status == 'diproses'): ?>
                                        <form action="<?php echo e(route('admin.orders.updateStatus', $order->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i> Selesai
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <?php if($order->payment_status == 'pending' && $order->payment_method != 'cash'): ?>
                                        <form action="<?php echo e(route('admin.orders.confirmPayment', $order->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                <i class="fas fa-dollar-sign"></i> Konfirmasi Bayar
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <a href="<?php echo e(route('admin.orders.print', $order->id)); ?>" target="_blank" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-print"></i> Print
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="10" class="text-center">Belum ada pesanan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cafe\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>