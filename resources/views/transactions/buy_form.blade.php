@extends('layouts.app')

@section('title', 'Beli Jersey')

@section('content')
<div class="container">
    <h1 class="mb-4">Pembelian Jersey</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Jersey</h5>
                </div>
                <div class="card-body">
                    <!-- Carousel untuk foto jersey -->
                    <div id="jerseyPhotosCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @php
                                $allPhotos = $jersey->getAllPhotosAttribute();
                            @endphp
                            @if(count($allPhotos) > 0)
                                @foreach($allPhotos as $index => $photoPath)
                                    <button type="button" data-bs-target="#jerseyPhotosCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
                                @endforeach
                            @endif
                        </div>
                        
                        <div class="carousel-inner">
                            @if(count($allPhotos) > 0)
                                @foreach($allPhotos as $index => $photoPath)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $photoPath) }}" class="d-block w-100" style="height: 300px; object-fit: cover;" alt="Foto {{ $index + 1 }}">
                                    </div>
                                @endforeach
                            @else
                                <div class="carousel-item active">
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 100%; height: 300px;">
                                        <i class="fas fa-tshirt fa-5x text-muted"></i>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        @if(count($allPhotos) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#jerseyPhotosCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#jerseyPhotosCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                    
                    <h4>{{ $jersey->name }}</h4>
                    <p>{{ $jersey->description }}</p>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Harga:</strong> <span class="text-success fw-bold">Rp{{ number_format($jersey->price, 2, ',', '.') }}</span></li>
                        <li class="list-group-item"><strong>Stok:</strong> 
                            <span class="badge bg-{{ $jersey->hasStock() ? 'success' : 'danger' }} fs-6">
                                {{ $jersey->stock }}
                            </span>
                        </li>
                        <li class="list-group-item"><strong>Kondisi:</strong> {{ ucfirst($jersey->condition) }}</li>
                        <li class="list-group-item"><strong>Penjual:</strong> 
                            @if($jersey->user)
                                {{ $jersey->user->name }}
                            @else
                                Sistem
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Form Pembelian</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('transactions.buy', $jersey->slug) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="size" class="form-label">Pilih Ukuran</label>
                            <select class="form-select @error('size') is-invalid @enderror" id="size" name="size" required>
                                <option value="">Pilih Ukuran...</option>
                                @if($jersey->sizes)
                                    @foreach($jersey->sizes as $size)
                                        <option value="{{ $size }}" {{ old('size') == $size ? 'selected' : '' }}>
                                            {{ $size }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="{{ $jersey->size }}" {{ old('size') == $jersey->size ? 'selected' : '' }}>
                                        {{ $jersey->size }}
                                    </option>
                                @endif
                            </select>
                            @error('size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="buyer_address" class="form-label">Alamat Pengiriman</label>
                            <input type="text" class="form-control @error('buyer_address') is-invalid @enderror" id="buyer_address" name="buyer_address" value="{{ old('buyer_address') }}" required>
                            @error('buyer_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="buyer_phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('buyer_phone') is-invalid @enderror" id="buyer_phone" name="buyer_phone" value="{{ old('buyer_phone') }}" required>
                            @error('buyer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="payment_proof" class="form-label">Bukti Pembayaran</label>
                            <input type="file" class="form-control @error('payment_proof') is-invalid @enderror" id="payment_proof" name="payment_proof" accept="image/*" required>
                            @error('payment_proof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Upload bukti transfer pembayaran</div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-shopping-cart"></i> Proses Pembelian
                            </button>
                            <a href="{{ route('jerseys.available') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection