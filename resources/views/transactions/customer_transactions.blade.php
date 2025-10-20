@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container">
    <h1 class="mb-4">Riwayat Transaksi</h1>
    
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#pembelian">Pembelian</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#penjualan">Penjualan</a>
        </li>
    </ul>
    
    <div class="tab-content">
        <!-- Tab Pembelian -->
        <div class="tab-pane fade show active" id="pembelian">
            <div class="card">
                <div class="card-header">
                    <h5>Transaksi Pembelian</h5>
                </div>
                <div class="card-body">
                    @if($pembelian->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Jersey</th>
                                        <th>Harga</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pembelian as $transaksi)
                                    <tr>
                                        <td>#{{ $transaksi->id }}</td>
                                        <td>{{ $transaksi->jersey->name }}</td>
                                        <td><span class="text-success fw-bold">Rp{{ number_format($transaksi->jersey->price, 2, ',', '.') }}</span></td>
                                        <td>{{ Str::limit($transaksi->buyer_address, 30) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $transaksi->status === 'selesai' ? 'success' : ($transaksi->status === 'pending' ? 'warning' : 'danger') }} fs-6">
                                                {{ $transaksi->status === 'selesai' ? 'Selesai' : ($transaksi->status === 'pending' ? 'Pending' : 'Ditolak') }}
                                            </span>
                                        </td>
                                        <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($transaksi->payment_proof)
                                                <a href="{{ asset('storage/' . $transaksi->payment_proof) }}" target="_blank" class="btn btn-info btn-sm">
                                                    <i class="fas fa-image"></i> Bukti
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $pembelian->links() }}
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
                            <h4>Belum ada transaksi pembelian</h4>
                            <p class="text-muted">Anda belum melakukan pembelian jersey apapun</p>
                            <a href="{{ route('jerseys.available') }}" class="btn btn-primary">
                                <i class="fas fa-tshirt"></i> Cari Jersey
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Tab Penjualan -->
        <div class="tab-pane fade" id="penjualan">
            <div class="card">
                <div class="card-header">
                    <h5>Transaksi Penjualan</h5>
                </div>
                <div class="card-body">
                    @if($penjualan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Jersey</th>
                                        <th>Harga</th>
                                        <th>Alamat Pembeli</th>
                                        <th>Status</th>
                                        <th>Jumlah Transaksi</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($penjualan as $jersey)
                                    <tr>
                                        <td>#{{ $jersey->id }}</td>
                                        <td>{{ $jersey->name }}</td>
                                        <td><span class="text-success fw-bold">Rp{{ number_format($jersey->price, 2, ',', '.') }}</span></td>
                                        <td>
                                            @if($jersey->transactions->count() > 0)
                                                {{ Str::limit($jersey->transactions->first()->buyer_address, 30) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $jersey->status === 'aktif' ? 'success' : ($jersey->status === 'pending_review' ? 'warning' : 'danger') }} fs-6">
                                                {{ $jersey->status === 'aktif' ? 'Aktif' : ($jersey->status === 'pending_review' ? 'Menunggu Review' : 'Ditolak') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info fs-6">{{ $jersey->transactions->count() }}</span>
                                        </td>
                                        <td>{{ $jersey->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($jersey->transactions->count() > 0)
                                                <a href="https://api.whatsapp.com/send?phone={{ $jersey->transactions->first()->buyer_phone }}" target="_blank" class="btn btn-success btn-sm">
                                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $penjualan->links() }}
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-hand-holding-usd fa-5x text-muted mb-3"></i>
                            <h4>Belum ada transaksi penjualan</h4>
                            <p class="text-muted">Anda belum menjual jersey apapun</p>
                            <a href="{{ route('jerseys.sell.form') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Jual Jersey
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection