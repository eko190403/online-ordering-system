

<?php $__env->startSection('title', 'QR Code Menu'); ?>

<?php $__env->startSection('content'); ?>
<div class="text-center">
    <h2 class="mb-4"><i class="fas fa-qrcode"></i> QR Code Menu</h2>
    
    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-body">
            <p class="text-muted">Scan QR Code ini untuk akses menu</p>
            <div class="p-4">
                <img src="<?php echo e($qrCodeUrl); ?>" alt="QR Code" class="img-fluid">
            </div>
            <hr>
            <p class="mb-0"><strong>URL:</strong></p>
            <p><a href="<?php echo e($url); ?>" target="_blank"><?php echo e($url); ?></a></p>
            
            <button class="btn btn-primary mt-3" onclick="window.print()">
                <i class="fas fa-print"></i> Print QR Code
            </button>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .btn, nav { display: none !important; }
    body { background: white !important; }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cafe\resources\views/admin/qrcode.blade.php ENDPATH**/ ?>