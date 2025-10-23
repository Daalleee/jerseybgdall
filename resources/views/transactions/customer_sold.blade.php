@extends('layouts.app')

@section('title', 'Transaksi Penjualan')

@section('content')
<div class="container">
    <h1 class="mb-4">Transaksi Penjualan Saya</h1>
    
    <div class="card">
        <div class="card-body">
            @if($penjualan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Jersey</th>
                                <th>Harga</th>
                                <th>Status Jersey</th>
                                <th>Tanggal</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan as $jersey)
                            <tr>
                                <td>{{ $jersey->slug }}</td>
                                <td>{{ $jersey->name }}</td>
                                <td><span class="text-success fw-bold">Rp{{ number_format($jersey->price, 2, ',', '.') }}</span></td>
                                <td>
                                    <span class="badge bg-{{ $jersey->status === 'aktif' ? 'success' : ($jersey->status === 'pending_review' ? 'warning' : 'danger') }} fs-6">
                                        {{ $jersey->display_status }}
                                    </span>
                                </td>
                                <td>{{ $jersey->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('jerseys.sell.form') }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </a>
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
@endsection