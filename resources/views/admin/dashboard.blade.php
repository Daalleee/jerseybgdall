@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Admin</h1>
    
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalJerseys }}</h4>
                            <p class="mb-0">Total Jersey</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-tshirt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $activeJerseys }}</h4>
                            <p class="mb-0">Jersey Aktif</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalCustomers }}</h4>
                            <p class="mb-0">Total Pelanggan</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalTransactions }}</h4>
                            <p class="mb-0">Total Transaksi</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exchange-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Transaksi Pending</h5>
                </div>
                <div class="card-body">
                    <p>Jumlah transaksi pending: <strong>{{ $pendingTransactions }}</strong></p>
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-primary">Lihat Semua Transaksi</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Manajemen</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <a href="{{ route('admin.jerseys.index') }}" class="btn btn-primary w-100">
                                <i class="fas fa-tshirt"></i> Kelola Jersey
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="{{ route('admin.transactions.index') }}" class="btn btn-success w-100">
                                <i class="fas fa-exchange-alt"></i> Kelola Transaksi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection