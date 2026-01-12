@extends('layouts.admin')

@section('title', 'QR Code Menu')

@section('content')
<div class="text-center">
    <h2 class="mb-4"><i class="fas fa-qrcode"></i> QR Code Menu</h2>
    
    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-body">
            <p class="text-muted">Scan QR Code ini untuk akses menu</p>
            <div class="p-4">
                <img src="{{ $qrCodeUrl }}" alt="QR Code" class="img-fluid">
            </div>
            <hr>
            <p class="mb-0"><strong>URL:</strong></p>
            <p><a href="{{ $url }}" target="_blank">{{ $url }}</a></p>
            
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
@endsection
