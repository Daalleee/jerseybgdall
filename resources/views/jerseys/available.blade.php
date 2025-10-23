@extends('layouts.app')

@section('title', 'Daftar Jersey')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Jersey Tersedia</h1>
    
    <div class="row">
        @forelse($jerseys as $jersey)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="img-container position-relative" style="height: 200px; overflow: hidden;">
                        <!-- Tampilkan foto utama atau foto pertama dari additional photos -->
                        @php
                            $allPhotos = $jersey->getAllPhotosAttribute();
                        @endphp
                        @if(!empty($allPhotos))
                            <img src="{{ asset('storage/' . $allPhotos[0]) }}" class="card-img-top" alt="{{ $jersey->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @if(count($allPhotos) > 1)
                                <div class="position-absolute bottom-0 end-0 bg-primary text-white px-2 py-1 rounded-start" style="font-size: 0.8rem;">
                                    <i class="fas fa-images"></i> {{ count($allPhotos) }}
                                </div>
                            @endif
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="width: 100%; height: 100%;">
                                <i class="fas fa-tshirt fa-5x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $jersey->name }}</h5>
                        <p class="text-success fw-bold fs-5">Rp{{ number_format($jersey->price, 2, ',', '.') }}</p>
                        
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fas fa-box"></i> Stok: 
                                <span class="badge bg-{{ $jersey->hasStock() ? 'success' : 'danger' }} fs-6">
                                    {{ $jersey->stock }}
                                </span>
                            </small>
                        </div>
                        
                        <div class="mt-auto">
                            @if($jersey->hasStock())
                                <a href="{{ route('transactions.buy.form', $jersey->slug) }}" class="btn btn-primary w-100">
                                    <i class="fas fa-shopping-cart"></i> Beli Sekarang
                                </a>
                            @else
                                <button class="btn btn-secondary w-100" disabled>
                                    <i class="fas fa-shopping-cart"></i> Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-tshirt fa-5x text-muted mb-3"></i>
                    <h4>Belum ada jersey tersedia</h4>
                    <p class="text-muted">Silakan cek kembali nanti untuk jersey baru</p>
                </div>
            </div>
        @endforelse
    </div>
    
    {{ $jerseys->links() }}
</div>
@endsection