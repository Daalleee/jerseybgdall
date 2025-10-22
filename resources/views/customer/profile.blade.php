@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container">
    <h1 class="mb-4">Profil Saya</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <p class="form-control-plaintext">{{ Auth::user()->name }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <p class="form-control-plaintext">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <p class="form-control-plaintext">{{ Auth::user()->phone_number ?? '-' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <p class="form-control-plaintext">{{ Auth::user()->address ?? '-' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tanggal Registrasi</label>
                        <p class="form-control-plaintext">{{ Auth::user()->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Statistik Saya</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-primary text-white text-center">
                                <div class="card-body">
                                    <h3>{{ Auth::user()->transactions()->where('type', 'pembelian')->count() }}</h3>
                                    <p class="mb-0">Pembelian</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success text-white text-center">
                                <div class="card-body">
                                    <h3>{{ Auth::user()->jerseys()->where('type', 'pelanggan')->count() }}</h3>
                                    <p class="mb-0">Penjualan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6>Ringkasan Aktivitas</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Jersey Aktif
                            <span class="badge bg-primary rounded-pill">{{ Auth::user()->jerseys()->where('status', 'aktif')->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Jersey Pending
                            <span class="badge bg-warning rounded-pill">{{ Auth::user()->jerseys()->where('status', 'pending_review')->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Jersey Ditolak
                            <span class="badge bg-danger rounded-pill">{{ Auth::user()->jerseys()->where('status', 'ditolak')->count() }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection