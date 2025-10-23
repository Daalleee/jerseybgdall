@extends('layouts.app')

@section('title', 'Transaksi Pembelian')

@section('content')
<div class="container">
    <h1 class="mb-4">Transaksi Pembelian Saya</h1>
    
    <div class="card">
        <div class="card-body">
            @if($pembelian->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Jersey</th>
                                <th>Harga</th>
                                <th>Alamat Pengiriman</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Bukti Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembelian as $transaksi)
                            <tr>
                                <td>{{ $transaksi->transaction_code }}</td>
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
                                            <i class="fas fa-image"></i> Lihat
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
@endsection