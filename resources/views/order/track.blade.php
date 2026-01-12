<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Pesanan - {{ $order->order_code }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .track-card {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .track-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .track-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .track-body {
            padding: 30px;
        }
        .order-code {
            font-size: 1.5rem;
            font-weight: bold;
            color: #667eea;
            text-align: center;
            margin-bottom: 20px;
        }
        .status-timeline {
            position: relative;
            padding-left: 50px;
            margin: 30px 0;
        }
        .status-item {
            position: relative;
            padding-bottom: 30px;
        }
        .status-item:last-child {
            padding-bottom: 0;
        }
        .status-item::before {
            content: '';
            position: absolute;
            left: -35px;
            top: 5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 3px solid #ddd;
            background: white;
        }
        .status-item.active::before {
            border-color: #667eea;
            background: #667eea;
        }
        .status-item.completed::before {
            border-color: #28a745;
            background: #28a745;
        }
        .status-item::after {
            content: '';
            position: absolute;
            left: -26px;
            top: 25px;
            width: 2px;
            height: calc(100% - 5px);
            background: #ddd;
        }
        .status-item:last-child::after {
            display: none;
        }
        .status-item.completed::after,
        .status-item.active::after {
            background: #667eea;
        }
        .status-label {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }
        .status-time {
            font-size: 0.85rem;
            color: #666;
        }
        .order-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #555;
        }
        .items-list {
            margin-top: 20px;
        }
        .item-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .item-name {
            font-weight: 600;
            color: #333;
        }
        .item-qty {
            color: #666;
            font-size: 0.9rem;
        }
        .item-price {
            font-weight: bold;
            color: #667eea;
        }
        .total-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-top: 20px;
        }
        .total-label {
            font-size: 1rem;
            margin-bottom: 5px;
        }
        .total-amount {
            font-size: 2rem;
            font-weight: bold;
        }
        .btn-back {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 20px;
        }
        .notes-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .notes-label {
            font-weight: bold;
            color: #856404;
            margin-bottom: 5px;
        }
        .notes-text {
            color: #856404;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="track-card">
        <div class="track-header">
            <h1><i class="fas fa-utensils"></i> Cafe D.Villa Lampung</h1>
            <p>Lacak Pesanan Anda</p>
        </div>

        <div class="track-body">
            <div class="order-code">
                <i class="fas fa-receipt"></i> {{ $order->order_code }}
            </div>

            <!-- Order Info -->
            <div class="order-info">
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-user"></i> Nama</span>
                    <span>{{ $order->customer_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-chair"></i> Meja</span>
                    <span class="badge bg-secondary">{{ $order->table_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-calendar"></i> Tanggal</span>
                    <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-credit-card"></i> Pembayaran</span>
                    <span>
                        @if($order->payment_method == 'cash')
                            <span class="badge bg-success">Cash</span>
                        @else
                            <span class="badge bg-primary">QRIS/Transfer</span>
                        @endif
                        @if($order->payment_status == 'paid')
                            <span class="badge bg-success ms-1">Lunas</span>
                        @else
                            <span class="badge bg-warning text-dark ms-1">Pending</span>
                        @endif
                    </span>
                </div>
            </div>

            <!-- Status Timeline -->
            <h5 class="mb-3"><i class="fas fa-tasks"></i> Status Pesanan</h5>
            <div class="status-timeline">
                <div class="status-item completed">
                    <div class="status-label">
                        <i class="fas fa-check-circle text-success"></i> Pesanan Diterima
                    </div>
                    <div class="status-time">{{ $order->created_at->format('d M Y, H:i') }}</div>
                </div>
                
                <div class="status-item {{ $order->status == 'diproses' || $order->status == 'selesai' ? 'active' : '' }}">
                    <div class="status-label">
                        <i class="fas fa-fire {{ $order->status == 'diproses' || $order->status == 'selesai' ? 'text-primary' : 'text-muted' }}"></i> Sedang Diproses
                    </div>
                    @if($order->status == 'diproses' || $order->status == 'selesai')
                        <div class="status-time">Pesanan sedang disiapkan</div>
                    @else
                        <div class="status-time">Menunggu proses</div>
                    @endif
                </div>
                
                <div class="status-item {{ $order->status == 'selesai' ? 'completed' : '' }}">
                    <div class="status-label">
                        <i class="fas fa-check-double {{ $order->status == 'selesai' ? 'text-success' : 'text-muted' }}"></i> Pesanan Selesai
                    </div>
                    @if($order->status == 'selesai')
                        <div class="status-time">Silakan ambil pesanan Anda</div>
                    @else
                        <div class="status-time">Menunggu</div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <h5 class="mb-3"><i class="fas fa-list"></i> Detail Pesanan</h5>
            <div class="items-list">
                @foreach($order->items as $item)
                    <div class="item-card">
                        <div>
                            <div class="item-name">{{ $item->menu->name }}</div>
                            <div class="item-qty">{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="item-price">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Notes -->
            @if($order->notes)
                <div class="notes-box">
                    <div class="notes-label"><i class="fas fa-sticky-note"></i> Catatan Pesanan:</div>
                    <div class="notes-text">{{ $order->notes }}</div>
                </div>
            @endif

            <!-- Total -->
            <div class="total-box">
                <div class="total-label">Total Pembayaran</div>
                <div class="total-amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
            </div>

            <!-- Back Button -->
            <a href="{{ route('menu.index') }}" class="btn btn-primary btn-back">
                <i class="fas fa-home"></i> Kembali ke Menu
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Auto Refresh every 30 seconds -->
    <script>
        // Refresh page every 30 seconds to update order status
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
