@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Pelanggan</h1>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Semua Jersey Tersedia</h5>
                </div>
                <div class="card-body">
                    @if($availableJerseys && $availableJerseys->count() > 0)
                        <div class="row">
                            @foreach($availableJerseys as $jersey)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card h-100">
                                        <div class="img-container position-relative" style="height: 150px; overflow: hidden;">
                                            <!-- Tampilkan foto utama atau foto pertama dari additional photos -->
                                            @php
                                                $allPhotos = $jersey->getAllPhotosAttribute();
                                            @endphp
                                            @if(!empty($allPhotos))
                                                <img src="{{ asset('storage/' . $allPhotos[0]) }}" class="card-img-top" alt="{{ $jersey->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                @if(count($allPhotos) > 1)
                                                    <div class="position-absolute bottom-0 end-0 bg-primary text-white px-2 py-1 rounded-start" style="font-size: 0.7rem;">
                                                        <i class="fas fa-images"></i> {{ count($allPhotos) }}
                                                    </div>
                                                @endif
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 100%; height: 100%;">
                                                    <i class="fas fa-tshirt fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h6 class="card-title">{{ Str::limit($jersey->name, 20) }}</h6>
                                            <p class="text-success fw-bold">Rp{{ number_format($jersey->price, 2, ',', '.') }}</p>
                                            <a href="{{ route('transactions.buy.form', $jersey->id) }}" class="btn btn-primary btn-sm mt-auto">
                                                <i class="fas fa-shopping-cart"></i> Beli
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-tshirt fa-3x text-muted mb-2"></i>
                            <p class="text-muted">Belum ada jersey tersedia</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection