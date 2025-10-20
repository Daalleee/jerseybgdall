@extends('layouts.app')

@section('title', 'Manajemen Transaksi - Admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Manajemen Transaksi</h1>
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ request('status', 'all') === 'all' ? 'active' : '' }}" 
                       href="{{ route('admin.transactions.index', ['status' => 'all']) }}">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'pending' ? 'active' : '' }}" 
                       href="{{ route('admin.transactions.index', ['status' => 'pending']) }}">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'selesai' ? 'active' : '' }}" 
                       href="{{ route('admin.transactions.index', ['status' => 'selesai']) }}">Selesai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'ditolak' ? 'active' : '' }}" 
                       href="{{ route('admin.transactions.index', ['status' => 'ditolak']) }}">Ditolak</a>
                </li>
            </ul>
        </div>
        
        <form method="GET" class="d-flex" style="width: 300px;">
            <input type="hidden" name="status" value="{{ request('status', 'all') }}">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari transaksi..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jersey</th>
                    <th>Pembeli</th>
                    <th>Harga</th>
                    <th>Alamat</th>
                    <th>No. HP</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>#{{ $transaction->id }}</td>
                        <td>{{ $transaction->jersey->name }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td><span class="text-success fw-bold">Rp{{ number_format($transaction->jersey->price, 2, ',', '.') }}</span></td>
                        <td>{{ Str::limit($transaction->buyer_address, 20) }}</td>
                        <td>{{ $transaction->buyer_phone }}</td>
                        <td>
                            <span class="badge bg-{{ $transaction->status === 'selesai' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }} fs-6">
                                {{ $transaction->status === 'selesai' ? 'Selesai' : ($transaction->status === 'pending' ? 'Pending' : 'Ditolak') }}
                            </span>
                        </td>
                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="d-flex flex-column gap-2">
                                @if($transaction->payment_proof)
                                    <a href="{{ asset('storage/' . $transaction->payment_proof) }}" target="_blank" class="btn btn-info btn-sm">
                                        <i class="fas fa-image"></i> Bukti
                                    </a>
                                @endif
                                
                                @if($transaction->status === 'pending')
                                    <form action="{{ route('admin.transactions.approve', $transaction->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <!-- Kirim parameter pagination untuk redirect kembali -->
                                        <input type="hidden" name="page" value="{{ request('page', 1) }}">
                                        <input type="hidden" name="status" value="{{ request('status', 'all') }}">
                                        <input type="hidden" name="search" value="{{ request('search', '') }}">
                                        <button type="submit" class="btn btn-success btn-sm w-100" onclick="return confirm('Yakin ingin menyetujui transaksi ini?')">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.transactions.reject', $transaction->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <!-- Kirim parameter pagination untuk redirect kembali -->
                                        <input type="hidden" name="page" value="{{ request('page', 1) }}">
                                        <input type="hidden" name="status" value="{{ request('status', 'all') }}">
                                        <input type="hidden" name="search" value="{{ request('search', '') }}">
                                        <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin ingin menolak transaksi ini?')">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="https://api.whatsapp.com/send?phone={{ $transaction->buyer_phone }}" target="_blank" class="btn btn-success btn-sm">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{ $transactions->appends(['status' => request('status')])->links() }}
</div>
@endsection