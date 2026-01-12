<!DOCTYPE html>
<html>
<head>
    <title>Print Order - <?php echo e($order->order_code); ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Courier New', monospace; 
            font-size: 12px; 
            line-height: 1.4;
            padding: 10px;
        }
        .receipt { max-width: 300px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px dashed #000; padding-bottom: 10px; }
        .header h2 { font-size: 18px; margin-bottom: 5px; }
        .header p { font-size: 11px; }
        .info { margin-bottom: 15px; border-bottom: 1px dashed #000; padding-bottom: 10px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 3px; }
        .info-row strong { width: 120px; }
        .items { margin-bottom: 15px; border-bottom: 2px dashed #000; padding-bottom: 10px; }
        .item { margin-bottom: 8px; }
        .item-header { font-weight: bold; margin-bottom: 2px; }
        .item-detail { display: flex; justify-content: space-between; padding-left: 10px; }
        .notes { margin-bottom: 15px; border-bottom: 1px dashed #000; padding-bottom: 10px; }
        .notes strong { display: block; margin-bottom: 5px; }
        .notes p { padding-left: 10px; font-style: italic; }
        .total { margin-bottom: 15px; border-bottom: 2px dashed #000; padding-bottom: 10px; }
        .total-row { display: flex; justify-content: space-between; font-size: 14px; font-weight: bold; }
        .payment { margin-bottom: 15px; border-bottom: 1px dashed #000; padding-bottom: 10px; }
        .payment-row { display: flex; justify-content: space-between; margin-bottom: 3px; }
        .footer { text-align: center; font-size: 11px; margin-top: 15px; }
        .badge { 
            display: inline-block; 
            padding: 2px 6px; 
            border: 1px solid #000; 
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <h2>CAFE D.VILLA LAMPUNG</h2>
            <p>Jl. Raya Lampung No. 123</p>
            <p>Telp: (0721) 123456</p>
        </div>

        <!-- Info Pesanan -->
        <div class="info">
            <div class="info-row">
                <strong>Kode Order:</strong>
                <span><?php echo e($order->order_code); ?></span>
            </div>
            <div class="info-row">
                <strong>Tanggal:</strong>
                <span><?php echo e($order->created_at->format('d/m/Y H:i')); ?></span>
            </div>
            <div class="info-row">
                <strong>Nama Customer:</strong>
                <span><?php echo e($order->customer_name); ?></span>
            </div>
            <div class="info-row">
                <strong>Nomor Meja:</strong>
                <span class="badge"><?php echo e($order->table_number); ?></span>
            </div>
            <div class="info-row">
                <strong>Status:</strong>
                <span class="badge"><?php echo e(strtoupper($order->status)); ?></span>
            </div>
        </div>

        <!-- Daftar Item -->
        <div class="items">
            <strong style="display: block; margin-bottom: 8px;">DETAIL PESANAN:</strong>
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="item">
                    <div class="item-header"><?php echo e($item->menu->name); ?></div>
                    <div class="item-detail">
                        <span><?php echo e($item->qty); ?> x Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></span>
                        <strong>Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></strong>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Catatan -->
        <?php if($order->notes): ?>
            <div class="notes">
                <strong>CATATAN PESANAN:</strong>
                <p><?php echo e($order->notes); ?></p>
            </div>
        <?php endif; ?>

        <!-- Total -->
        <div class="total">
            <div class="total-row">
                <span>TOTAL:</span>
                <span>Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></span>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="payment">
            <div class="payment-row">
                <strong>Metode Bayar:</strong>
                <span>
                    <?php if($order->payment_method == 'cash'): ?>
                        CASH
                    <?php else: ?>
                        QRIS/TRANSFER
                    <?php endif; ?>
                </span>
            </div>
            <div class="payment-row">
                <strong>Status Bayar:</strong>
                <span class="badge">
                    <?php if($order->payment_status == 'paid'): ?>
                        LUNAS
                    <?php else: ?>
                        PENDING
                    <?php endif; ?>
                </span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Selamat menikmati hidangan Anda</p>
            <p style="margin-top: 10px; font-size: 10px;">Struk ini dicetak pada <?php echo e(now()->format('d/m/Y H:i:s')); ?></p>
        </div>
    </div>

    <!-- Print Buttons -->
    <div class="no-print" style="text-align: center; margin-top: 30px; padding: 20px;">
        <button onclick="window.print()" style="padding: 10px 30px; font-size: 14px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px;">
            <i class="fas fa-print"></i> Print Struk
        </button>
        <button onclick="window.close()" style="padding: 10px 30px; font-size: 14px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Tutup
        </button>
    </div>

    <script>
        // Auto-open print dialog when page loads
        window.onload = function() {
            // Delay to ensure page is fully loaded
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\cafe\resources\views/admin/orders/print.blade.php ENDPATH**/ ?>