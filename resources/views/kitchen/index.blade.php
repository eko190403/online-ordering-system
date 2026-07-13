@extends('layouts.admin')

@section('title', 'Kitchen Display System')

@section('content')
<div class="container-fluid py-4 bg-dark min-vh-100 text-light" style="margin-top: -24px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-warning"><i class="fas fa-fire"></i> KDS - Kitchen Display System</h2>
        <div id="clock" class="h4 mb-0 font-monospace text-info"></div>
    </div>
    
    <!-- Audio Notification -->
    <audio id="notificationSound" src="https://www.soundjay.com/buttons/sounds/button-14.mp3" preload="auto"></audio>

    <div class="mb-4">
        <div class="btn-group" role="group" id="stationFilter">
            <input type="radio" class="btn-check" name="station" id="stationAll" value="Semua" autocomplete="off" checked>
            <label class="btn btn-outline-warning" for="stationAll"><i class="fas fa-list"></i> Semua</label>
          
            <input type="radio" class="btn-check" name="station" id="stationDapur" value="Dapur" autocomplete="off">
            <label class="btn btn-outline-warning" for="stationDapur"><i class="fas fa-utensils"></i> Dapur</label>
          
            <input type="radio" class="btn-check" name="station" id="stationBar" value="Bar" autocomplete="off">
            <label class="btn btn-outline-warning" for="stationBar"><i class="fas fa-coffee"></i> Bar</label>
        </div>
    </div>

    <div class="row g-4" id="ordersContainer">
        <!-- Orders will be loaded here via AJAX -->
        <div class="col-12 text-center text-muted mt-5">
            <i class="fas fa-spinner fa-spin fa-3x mb-3"></i>
            <h4>Memuat pesanan...</h4>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function updateClock() {
    const now = new Date();
    document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID', { hour12: false });
}
setInterval(updateClock, 1000);
updateClock();

let isFirstLoad = true;
let knownOrderIds = [];
let currentStation = 'Semua';

$('input[name="station"]').on('change', function() {
    currentStation = $(this).val();
    fetchOrders(); // reload immediately
});

function fetchOrders() {
    $.get('/kitchen/api/orders', function(orders) {
        let html = '';
        let newOrdersFound = false;
        let displayedCount = 0;
        
        // Track new orders for audio notification
        const currentOrderIds = orders.map(o => o.id);
        if (!isFirstLoad) {
            currentOrderIds.forEach(id => {
                if (!knownOrderIds.includes(id)) {
                    newOrdersFound = true;
                }
            });
            if (newOrdersFound) {
                document.getElementById('notificationSound').play().catch(e => console.log('Audio play failed:', e));
            }
        }
        knownOrderIds = currentOrderIds;
        isFirstLoad = false;
        
        orders.forEach(function(order) {
            // Filter items by station
            let filteredItems = order.items;
            if (currentStation !== 'Semua') {
                filteredItems = order.items.filter(item => item.menu.category && item.menu.category.station === currentStation);
            }
            
            // Skip order if no items match the current station filter
            if (filteredItems.length === 0) return;
            
            displayedCount++;

            // Calculate waiting time
            const orderTime = new Date(order.created_at);
            const now = new Date();
            const waitTime = Math.floor((now - orderTime) / 60000); // in minutes
            let timeColor = waitTime > 15 ? 'text-danger' : (waitTime > 10 ? 'text-warning' : 'text-success');

            html += `
            <div class="col-12 col-md-4 col-lg-3">
                <div class="card h-100 bg-secondary border-0 shadow">
                    <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-warning">#${order.order_code.substring(3)}</h5>
                        <span class="badge bg-primary fs-6"><i class="fas fa-chair"></i> Meja ${order.table_number}</span>
                    </div>
                    <div class="card-body">
                        <p class="small text-light mb-2"><i class="fas fa-user"></i> ${order.customer_name}</p>
                        <p class="small ${timeColor} fw-bold mb-3"><i class="fas fa-clock"></i> Menunggu: ${waitTime} menit</p>
                        
                        <ul class="list-group list-group-flush mb-3">
            `;

            filteredItems.forEach(function(item) {
                let stationBadge = item.menu.category ? (item.menu.category.station === 'Bar' ? '<span class="badge bg-info ms-2">Bar</span>' : '<span class="badge bg-warning text-dark ms-2">Dapur</span>') : '';
                html += `
                            <li class="list-group-item bg-secondary text-light d-flex justify-content-between align-items-center px-0 border-dark">
                                <div>
                                    <span class="fw-bold fs-5">${item.qty}x</span>
                                    <span class="ms-3 fs-5">${item.menu.name}</span>
                                </div>
                                ${currentStation === 'Semua' ? stationBadge : ''}
                            </li>
                `;
            });

            html += `
                        </ul>
                        ${order.notes ? `<div class="alert alert-warning p-2 small"><i class="fas fa-exclamation-triangle"></i> Catatan: ${order.notes}</div>` : ''}
                    </div>
                    <div class="card-footer bg-dark border-0 text-center">
                        <button class="btn btn-success w-100 fs-5" onclick="completeOrder(${order.id})">
                            <i class="fas fa-check"></i> Selesai
                        </button>
                    </div>
                </div>
            </div>
            `;
        });
        
        if (displayedCount === 0) {
            html = '<div class="col-12 text-center text-muted mt-5"><i class="fas fa-check-circle fa-4x mb-3"></i><h4>Tidak ada pesanan masuk untuk '+currentStation+'</h4></div>';
        }
        
        $('#ordersContainer').html(html);
    });
}

function completeOrder(id) {
    if(confirm('Tandai pesanan ini selesai?')) {
        $.post('/kitchen/api/orders/' + id + '/complete', {
            _token: '{{ csrf_token() }}'
        }, function(res) {
            if(res.success) {
                fetchOrders();
            }
        });
    }
}

// Polling every 5 seconds
setInterval(fetchOrders, 5000);
fetchOrders();
</script>
@endsection
