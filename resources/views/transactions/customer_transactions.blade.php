@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container">
    <h1 class="mb-4">Riwayat Transaksi</h1>
    
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-shopping-cart fa-3x text-primary mb-3"></i>
                    <h5>Transaksi Pembelian</h5>
                    <p class="text-muted">Riwayat pembelian jersey dari sistem</p>
                    <a href="{{ route('transactions.customer.bought') }}" class="btn btn-primary">
                        Lihat Semua Pembelian
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-hand-holding-usd fa-3x text-success mb-3"></i>
                    <h5>Transaksi Penjualan</h5>
                    <p class="text-muted">Riwayat penjualan jersey milik saya</p>
                    <a href="{{ route('transactions.customer.sold') }}" class="btn btn-success">
                        Lihat Semua Penjualan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection