@extends('layouts.app')

@section('title', 'Login Pelanggan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-coffee text-primary fa-3x mb-3"></i>
                        <h4 class="fw-bold">Selamat Datang Kembali!</h4>
                        <p class="text-muted">Login untuk kumpulkan poin & lacak pesanan</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customer.login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Login</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">Belum punya akun? <a href="{{ route('customer.register') }}" class="text-decoration-none fw-bold">Daftar Sekarang</a></p>
                        <a href="{{ route('menu.index') }}" class="d-block mt-3 text-muted text-decoration-none"><i class="fas fa-arrow-left"></i> Kembali ke Menu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
