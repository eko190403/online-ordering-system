@extends('layouts.app')

@section('title', 'Menu - Cafe')

@section('content')
<div class="container py-4">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-gradient mb-2">
            <i class="fas fa-coffee"></i> Cafe D.Villa Lampung
        </h1>
        <p class="lead text-muted">Nikmati kelezatan menu pilihan kami</p>
        <div class="text-warning mb-2">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
        </div>
        <small class="text-muted">
            <i class="fas fa-clock"></i> Buka: {{ $openTime ?? '08:00' }} - {{ $closeTime ?? '22:00' }}
        </small>
    </div>

    @if(isset($isClosed) && $isClosed)
    <div class="alert alert-warning alert-dismissible fade show text-center mb-4" role="alert">
        <h5><i class="fas fa-exclamation-triangle"></i> Maaf, Kami Sedang Tutup</h5>
        <p class="mb-0">Jam operasional: <strong>{{ $openTime }} - {{ $closeTime }}</strong></p>
        <small>Silakan kembali pada jam buka untuk melakukan pemesanan</small>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-4">
        <form method="GET" action="{{ route('menu.index') }}">
            <div class="input-group input-group-lg shadow-sm">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" 
                       name="search" 
                       class="form-control border-start-0" 
                       placeholder="Cari menu favorit Anda..." 
                       value="{{ request('search') }}"
                       autocomplete="off">
                @if(request('search'))
                <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                </a>
                @endif
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Filter Kategori -->
    <div class="mb-5">
        <div class="d-flex gap-2 flex-wrap justify-content-center">
            <a href="{{ route('menu.index') }}" class="btn btn-category btn-outline-dark rounded-pill px-4">
                <i class="fas fa-th"></i> Semua Menu
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('menu.category', $cat->id) }}" class="btn btn-category btn-outline-dark rounded-pill px-4">
                    <i class="fas fa-utensils"></i> {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Daftar Menu -->
    <div class="row g-4">
        @forelse($menus as $menu)
            @php
                $stock = $menu->stock ? $menu->stock->quantity : 0;
                $isOutOfStock = $stock <= 0;
            @endphp
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card menu-card-hover h-100 border-0 shadow-sm {{ $isOutOfStock ? 'opacity-50' : '' }}" 
                     style="{{ $isOutOfStock ? 'cursor:not-allowed;' : 'cursor:pointer;' }}">
                    <div class="menu-detail position-relative overflow-hidden" 
                         data-menu-id="{{ $menu->id }}" 
                         data-menu-name="{{ $menu->name }}"
                         data-menu-description="{{ $menu->description }}"
                         data-menu-price="{{ $menu->price }}"
                         data-menu-photo="{{ $menu->photo }}"
                         data-menu-category="{{ $menu->category->name }}"
                         data-is-out="{{ $isOutOfStock ? '1' : '0' }}">
                        @if($menu->photo)
                            <img src="{{ asset('uploads/menus/'.$menu->photo) }}" 
                                 class="card-img-top menu-img" 
                                 alt="{{ $menu->name }}"
                                 style="height: 180px; object-fit: cover; transition: transform 0.3s;">
                        @else
                            <div class="bg-gradient text-white d-flex align-items-center justify-content-center" 
                                 style="height: 180px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-concierge-bell fa-3x opacity-50"></i>
                            </div>
                        @endif
                        
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-dark bg-opacity-75">
                                <i class="fas fa-tag"></i> {{ $menu->category->name }}
                            </span>
                        </div>
                        
                        <div class="position-absolute top-0 end-0 m-2">
                            @if($isOutOfStock)
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle"></i> Habis
                                </span>
                            @else
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Tersedia
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card-body p-3">
                        <h6 class="card-title mb-2 fw-bold">{{ $menu->name }}</h6>
                        <p class="card-text small text-muted mb-3" style="min-height: 40px;">{{ Str::limit($menu->description, 60) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary fw-bold">Rp {{ number_format($menu->price, 0, ',', '.') }}</h5>
                            @if(!$isOutOfStock)
                                <button class="btn btn-primary btn-add-cart rounded-circle" 
                                        data-menu-id="{{ $menu->id }}" 
                                        data-menu-name="{{ $menu->name }}"
                                        data-menu-price="{{ $menu->price }}"
                                        style="width: 40px; height: 40px;">
                                    <i class="fas fa-plus"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Belum ada menu tersedia
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Floating Cart Button -->
<div class="cart-fab" id="cartBtn">
    <i class="fas fa-shopping-cart"></i>
    <span class="cart-badge" id="cartCount">0</span>
</div>

<!-- Track Order FAB (Floating Action Button) -->
<div class="track-order-fab" id="trackOrderFab" style="display: none;">
    <a href="#" id="trackOrderFabLink" class="text-decoration-none text-white">
        <i class="fas fa-receipt"></i>
        <small class="d-block" style="font-size: 9px; margin-top: 2px; line-height: 1.1;">Lihat<br>Pesanan</small>
    </a>
</div>

<!-- Modal Detail Menu -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailMenuName"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="detailMenuPhoto" class="mb-3"></div>
                <p class="text-muted"><i class="fas fa-tag"></i> <span id="detailMenuCategory"></span></p>
                <p id="detailMenuDescription"></p>
                <h4 class="text-success" id="detailMenuPrice"></h4>
                <div id="detailMenuStatus"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" id="detailAddCartBtn">
                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cart -->
<div class="modal fade" id="cartModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-shopping-cart"></i> Keranjang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Pemesan <span class="text-danger">*</span></label>
                    <input type="text" id="customerName" class="form-control" placeholder="Masukkan nama Anda" required>
                    <small class="text-muted">Nama akan digunakan saat memanggil pesanan</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nomor Meja <span class="text-danger">*</span></label>
                    <input type="text" id="tableNumber" class="form-control" placeholder="Contoh: 1, 2A, VIP-3" required>
                    <small class="text-muted">Masukkan nomor meja Anda</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="paymentMethod" id="paymentCash" value="cash" checked>
                            <label class="btn btn-outline-success w-100" for="paymentCash">
                                <i class="fas fa-money-bill-wave"></i><br>Cash
                            </label>
                        </div>
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="paymentMethod" id="paymentQris" value="qris">
                            <label class="btn btn-outline-primary w-100" for="paymentQris">
                                <i class="fas fa-qrcode"></i><br>QRIS
                            </label>
                        </div>
                    </div>
                    <small class="text-muted">Pilih metode pembayaran yang akan digunakan</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Catatan Pesanan <span class="text-muted">(Opsional)</span></label>
                    <textarea id="orderNotes" class="form-control" rows="2" placeholder="Contoh: Pedas sedang, tanpa bawang" maxlength="500"></textarea>
                    <small class="text-muted">Maksimal 500 karakter</small>
                </div>
                <hr>
                <div id="cartItems"></div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Total:</h5>
                    <h5 class="text-success" id="cartTotal">Rp 0</h5>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" id="checkoutBtn">
                    <i class="fas fa-check"></i> Pesan Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-check-circle"></i> Pesanan Berhasil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
                <h4 class="mt-3">Pesanan Berhasil Dibuat!</h4>
                <p class="mb-1">Kode Pesanan: <strong id="orderCode" class="text-primary"></strong></p>
                <div class="alert alert-success d-inline-block">
                    <i class="fas fa-hourglass-half"></i> <strong>Status: SEDANG DIPROSES</strong>
                </div>
                
                <!-- QRIS Payment Info -->
                <div id="qrisInfo" style="display: none;">
                    <hr>
                    <div class="alert alert-info">
                        <h5><i class="fas fa-wallet"></i> Pembayaran Transfer</h5>
                        <div class="mb-3">
                            <span class="badge bg-primary mb-2">
                                <i class="fas fa-university"></i> SeaBank
                            </span>
                            <p class="mb-1 text-muted small">Total yang harus dibayar:</p>
                            <h3 class="text-danger mb-0" id="qrisTotal">Rp 0</h3>
                        </div>
                        
                        <div class="bg-white border-2 border-primary rounded p-4 mb-3 shadow">
                            <p class="mb-2 text-center"><strong>Transfer ke rekening:</strong></p>
                            
                            <!-- QR Code untuk nomor rekening -->
                            <div class="text-center mb-3">
                                <img id="qrisImage" 
                                     src="" 
                                     alt="Scan untuk salin nomor" 
                                     class="img-fluid bg-light p-2 rounded"
                                     style="width: 180px; height: 180px;">
                                <p class="text-muted small mt-2 mb-0">
                                    <i class="fas fa-info-circle"></i> Scan untuk salin nomor rekening
                                </p>
                            </div>
                            
                            <div class="text-center">
                                <p class="text-muted small mb-1">Nomor Rekening</p>
                                <h4 class="text-primary mb-2" style="letter-spacing: 2px; font-weight: bold;">901567615382</h4>
                                <p class="mb-0"><strong>a.n. Cafe D.Villa Lampung</strong></p>
                                <p class="text-muted small mb-0">SeaBank Indonesia</p>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 mb-3">
                            <button class="btn btn-primary" onclick="copyQRIS()">
                                <i class="fas fa-copy"></i> Salin Nomor Rekening
                            </button>
                            <button class="btn btn-success" onclick="copyAmount()">
                                <i class="fas fa-money-bill-wave"></i> Salin Nominal Transfer
                            </button>
                        </div>
                        
                        <div class="alert alert-warning mb-0">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Penting!</h6>
                            <ol class="mb-0 ps-3 small">
                                <li>Transfer sejumlah <strong id="qrisTotal2">Rp 0</strong></li>
                                <li>Simpan bukti transfer</li>
                                <li>Tunjukkan bukti ke kasir untuk verifikasi</li>
                                <li>Pesanan diproses setelah pembayaran dikonfirmasi</li>
                            </ol>
                        </div>
                    </div>
                </div>
                
                <p class="text-muted" id="normalMessage">
                    <i class="fas fa-utensils"></i> Pesanan Anda sedang diproses oleh dapur.<br>
                    <small>Silakan menunggu, kami akan segera mengantarkan pesanan ke meja Anda.</small>
                </p>
                
                <!-- Track Order Link -->
                <a href="#" id="trackOrderLink" class="btn btn-outline-primary mt-3">
                    <i class="fas fa-receipt"></i> Lihat Pesanan Saya
                </a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                    Pesan Lagi
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Load cart dari localStorage
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Fungsi save cart ke localStorage
function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Fungsi render cart
function renderCart() {
    let html = '';
    let total = 0;
    
    if (cart.length === 0) {
        html = '<p class="text-muted text-center">Keranjang kosong</p>';
    } else {
        cart.forEach((item, index) => {
            const subtotal = item.price * item.qty;
            total += subtotal;
            
            html += `
                <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                    <div class="flex-grow-1">
                        <h6 class="mb-0">${item.name}</h6>
                        <small class="text-muted">Rp ${item.price.toLocaleString('id-ID')}</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-sm btn-outline-secondary" onclick="updateQty(${index}, -1)">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="fw-bold">${item.qty}</span>
                        <button class="btn btn-sm btn-outline-secondary" onclick="updateQty(${index}, 1)">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeItem(${index})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });
    }
    
    $('#cartItems').html(html);
    $('#cartTotal').text('Rp ' + total.toLocaleString('id-ID'));
    $('#cartCount').text(cart.length);
}

// Fungsi tambah ke cart
function addToCart(menuId, menuName, menuPrice) {
    const existingIndex = cart.findIndex(item => item.id === menuId);
    
    if (existingIndex !== -1) {
        cart[existingIndex].qty++;
    } else {
        cart.push({
            id: menuId,
            name: menuName,
            price: menuPrice,
            qty: 1
        });
    }
    
    saveCart();
    renderCart();
}

// Klik card untuk lihat detail
$(document).on('click', '.menu-detail', function() {
    const menuId = $(this).data('menu-id');
    const menuName = $(this).data('menu-name');
    const menuDescription = $(this).data('menu-description');
    const menuPrice = $(this).data('menu-price');
    const menuPhoto = $(this).data('menu-photo');
    const menuCategory = $(this).data('menu-category');
    const isOutOfStock = $(this).data('is-out') == '1';
    
    $('#detailMenuName').text(menuName);
    $('#detailMenuCategory').text(menuCategory);
    $('#detailMenuDescription').text(menuDescription || 'Tidak ada deskripsi');
    $('#detailMenuPrice').text('Rp ' + parseInt(menuPrice).toLocaleString('id-ID'));
    
    if (menuPhoto) {
        $('#detailMenuPhoto').html('<img src="/uploads/menus/' + menuPhoto + '" class="img-fluid rounded" alt="' + menuName + '">');
    } else {
        $('#detailMenuPhoto').html('<div class="bg-secondary text-white text-center p-5 rounded"><i class="fas fa-image fa-3x"></i></div>');
    }
    
    if (isOutOfStock) {
        $('#detailMenuStatus').html('<span class="badge bg-danger">Habis</span>');
        $('#detailAddCartBtn').hide();
    } else {
        $('#detailMenuStatus').html('<span class="badge bg-success">Tersedia</span>');
        $('#detailAddCartBtn').show();
        $('#detailAddCartBtn').data('menu-id', menuId);
        $('#detailAddCartBtn').data('menu-name', menuName);
        $('#detailAddCartBtn').data('menu-price', menuPrice);
    }
    
    $('#detailModal').modal('show');
});

// Tombol + langsung tambah ke cart (prevent bubbling)
$(document).on('click', '.btn-add-cart', function(e) {
    e.stopPropagation(); // Stop event dari bubble ke parent
    e.preventDefault();
    
    const menuId = $(this).data('menu-id');
    const menuName = $(this).data('menu-name');
    const menuPrice = $(this).data('menu-price');
    
    addToCart(menuId, menuName, menuPrice);
    
    // Animasi
    $(this).html('<i class="fas fa-check"></i>');
    setTimeout(() => {
        $(this).html('<i class="fas fa-plus"></i>');
    }, 500);
    
    return false;
});

// Tambah ke cart dari modal detail
$(document).on('click', '#detailAddCartBtn', function() {
    const menuId = $(this).data('menu-id');
    const menuName = $(this).data('menu-name');
    const menuPrice = $(this).data('menu-price');
    
    addToCart(menuId, menuName, menuPrice);
    $('#detailModal').modal('hide');
    
    // Show toast notification
    setTimeout(() => {
        alert('Menu berhasil ditambahkan ke keranjang!');
    }, 300);
});

// Update quantity
function updateQty(index, change) {
    cart[index].qty += change;
    if (cart[index].qty <= 0) {
        cart.splice(index, 1);
    }
    saveCart();
    renderCart();
}

// Remove item
function removeItem(index) {
    cart.splice(index, 1);
    saveCart();
    renderCart();
}

// Show cart modal
$('#cartBtn').on('click', function() {
    $('#cartModal').modal('show');
});

// Checkout
$('#checkoutBtn').on('click', function() {
    if (cart.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Keranjang Kosong',
            text: 'Silakan pilih menu terlebih dahulu!'
        });
        return;
    }
    
    const customerName = $('#customerName').val().trim();
    if (!customerName) {
        Swal.fire({
            icon: 'warning',
            title: 'Nama Diperlukan',
            text: 'Silakan masukkan nama Anda terlebih dahulu!'
        });
        $('#customerName').focus();
        return;
    }
    
    const tableNumber = $('#tableNumber').val().trim();
    if (!tableNumber) {
        Swal.fire({
            icon: 'warning',
            title: 'Nomor Meja Diperlukan',
            text: 'Silakan masukkan nomor meja Anda!'
        });
        $('#tableNumber').focus();
        return;
    }
    
    const paymentMethod = $('input[name="paymentMethod"]:checked').val();
    if (!paymentMethod) {
        Swal.fire({
            icon: 'warning',
            title: 'Pilih Metode Pembayaran',
            text: 'Silakan pilih metode pembayaran!'
        });
        return;
    }
    
    @if(isset($isClosed) && $isClosed)
    Swal.fire({
        icon: 'error',
        title: 'Cafe Tutup',
        text: 'Maaf, cafe sedang tutup. Silakan pesan pada jam operasional ({{ $openTime }} - {{ $closeTime }})'
    });
    return;
    @endif
    
    // Show loading
    const btn = $(this);
    const originalText = btn.html();
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
    
    const orderData = {
        customer_name: customerName,
        table_number: tableNumber,
        payment_method: paymentMethod,
        notes: $('#orderNotes').val().trim(),
        menu_items: cart.map(item => ({
            menu_id: item.id,
            qty: item.qty
        }))
    };
    
    $.ajax({
        url: '{{ route("order.store") }}',
        method: 'POST',
        data: JSON.stringify(orderData),
        contentType: 'application/json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // Reset button state
            btn.prop('disabled', false).html(originalText);
            
            $('#cartModal').modal('hide');
            $('#orderCode').text(response.order_code);
            
            // Set tracking link
            const trackUrl = '{{ url("/track") }}/' + response.order_code;
            $('#trackOrderLink').attr('href', trackUrl);
            
            // Save active order to localStorage for persistent tracking
            localStorage.setItem('activeOrder', JSON.stringify({
                order_code: response.order_code,
                created_at: new Date().toISOString()
            }));
            
            // Show floating track button
            showTrackingButton();
            
            // Show QRIS info if payment method is QRIS
            if (paymentMethod === 'qris') {
                const totalPrice = response.total_price;
                const accountNumber = '901567615382';
                
                // Display total
                const formattedTotal = 'Rp ' + totalPrice.toLocaleString('id-ID');
                $('#qrisTotal').text(formattedTotal);
                $('#qrisTotal2').text(formattedTotal);
                
                // Generate simple QR Code with just account number for easy scanning
                const qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&margin=5&data=' + encodeURIComponent(accountNumber);
                $('#qrisImage').attr('src', qrUrl);
                
                // Store data for copy functions
                window.qrisAmount = totalPrice;
                window.qrisAccountNumber = accountNumber;
                
                $('#qrisInfo').show();
                $('#normalMessage').hide();
            } else {
                $('#qrisInfo').hide();
                $('#normalMessage').show();
            }
            
            $('#confirmModal').modal('show');
            
            // Clear form and cart
            cart = [];
            localStorage.removeItem('cart');
            $('#customerName').val('');
            $('#tableNumber').val('');
            $('#orderNotes').val('');
            $('#paymentCash').prop('checked', true);
            renderCart();
        },
        error: function(xhr) {
            btn.prop('disabled', false).html(originalText);
            
            let errorMsg = 'Terjadi kesalahan saat memproses pesanan.';
            
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                errorMsg = Object.values(errors).flat().join('<br>');
            } else if (xhr.status === 500) {
                errorMsg = 'Kesalahan server. Silakan hubungi admin.';
            } else if (xhr.status === 0) {
                errorMsg = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Pesanan Gagal',
                html: errorMsg
            });
            
            console.error(xhr);
        }
    });
});

// Initial render
renderCart();

// Function to show/hide tracking button
function showTrackingButton() {
    const activeOrder = localStorage.getItem('activeOrder');
    if (activeOrder) {
        const order = JSON.parse(activeOrder);
        const trackUrl = '{{ url("/track") }}/' + order.order_code;
        $('#trackOrderFabLink').attr('href', trackUrl);
        $('#trackOrderFab').fadeIn();
    }
}

// Function to hide tracking button
function hideTrackingButton() {
    $('#trackOrderFab').fadeOut();
    localStorage.removeItem('activeOrder');
}

// Check active order on page load
$(document).ready(function() {
    showTrackingButton();
    
    // Check order status every 30 seconds if there's active order
    setInterval(function() {
        const activeOrder = localStorage.getItem('activeOrder');
        if (activeOrder) {
            const order = JSON.parse(activeOrder);
            
            // Check if order is completed (AJAX call)
            $.ajax({
                url: '{{ url("/api/check-order-status") }}/' + order.order_code,
                method: 'GET',
                success: function(response) {
                    if (response.status === 'selesai') {
                        // Order completed, hide tracking button
                        Swal.fire({
                            icon: 'success',
                            title: 'Pesanan Selesai!',
                            text: 'Pesanan #' + order.order_code + ' sudah selesai. Silakan ambil di counter!',
                            timer: 5000
                        });
                        hideTrackingButton();
                    }
                },
                error: function() {
                    // If order not found, hide button
                    hideTrackingButton();
                }
            });
        }
    }, 30000); // Check every 30 seconds
});

// Copy QRIS number function
function copyQRIS() {
    const accountNumber = window.qrisAccountNumber || '901567615382';
    navigator.clipboard.writeText(accountNumber).then(function() {
        alert('Nomor rekening SeaBank berhasil disalin:\n' + accountNumber);
    }).catch(function(err) {
        // Fallback for older browsers
        const textArea = document.createElement("textarea");
        textArea.value = accountNumber;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('Nomor rekening SeaBank berhasil disalin:\n' + accountNumber);
    });
}

// Copy amount function
function copyAmount() {
    if (window.qrisAmount) {
        const amount = window.qrisAmount.toString();
        navigator.clipboard.writeText(amount).then(function() {
            alert('Nominal berhasil disalin: Rp ' + parseInt(amount).toLocaleString('id-ID'));
        }).catch(function(err) {
            // Fallback
            const textArea = document.createElement("textarea");
            textArea.value = amount;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('Nominal berhasil disalin: Rp ' + parseInt(amount).toLocaleString('id-ID'));
        });
    }
}
</script>

<style>
/* Custom styles for Cafe D.Villa Lampung */
body {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

.text-gradient {
    background: linear-gradient(45deg, #FF6B6B, #4ECDC4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.menu-card-hover {
    transition: all 0.3s ease;
    cursor: pointer;
}

.menu-card-hover:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.menu-img {
    transition: transform 0.3s ease;
    object-fit: cover;
}

.menu-card-hover:hover .menu-img {
    transform: scale(1.05);
}

.btn-category {
    transition: all 0.3s ease;
    border: 2px solid #e0e0e0;
    background: white;
    color: #333;
    font-weight: 500;
}

.btn-category:hover, .btn-category.active {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-add-cart {
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.btn-add-cart:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
}

.badge {
    font-weight: 500;
    padding: 6px 12px;
}

.card-text {
    color: #666;
    line-height: 1.6;
}

.rating-stars {
    color: #ffc107;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

/* Cart button animation */
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.btn-cart-pulse {
    animation: pulse 2s infinite;
}

/* Category button active state */
.btn-outline-primary {
    border-width: 2px;
}

/* Modal enhancements */
.modal-content {
    border: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}

.modal-header {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    border: none;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
}

/* Price styling */
.text-primary {
    color: #667eea !important;
}

/* Card body padding enhancement */
.card-body {
    padding: 1.25rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .display-4 {
        font-size: 2rem;
    }
    
    .btn-category {
        font-size: 0.875rem;
        padding: 0.5rem 1rem !important;
    }
}
</style>
@endsection
