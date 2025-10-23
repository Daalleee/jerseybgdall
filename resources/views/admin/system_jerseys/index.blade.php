@extends('layouts.app')

@section('title', 'Jersey Sistem - Admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Jersey Sistem</h1>
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.jerseys.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i> Tambah Jersey Sistem
        </a>
        
        <form method="GET" class="d-flex" style="width: 300px;">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari jersey..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> Jersey sistem adalah jersey yang dibuat langsung oleh admin dan tersedia untuk dibeli oleh pelanggan.
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Ukuran Tersedia</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jerseys as $jersey)
                    <tr>
                        <td>{{ $jersey->slug }}</td>
                        <td>{{ $jersey->name }}</td>
                        <td><span class="text-success fw-bold">Rp{{ number_format($jersey->price, 2, ',', '.') }}</span></td>
                        <td>
                            <span class="badge bg-{{ $jersey->hasStock() ? 'success' : 'danger' }} fs-6">
                                {{ $jersey->stock }}
                            </span>
                        </td>
                        <td>
                            @if($jersey->sizes)
                                {{ $jersey->getAvailableSizesAttribute() }}
                            @else
                                {{ $jersey->size }}
                            @endif
                        </td>
                        <td>{{ ucfirst($jersey->condition) }}</td>
                        <td>
                            <span class="badge bg-{{ $jersey->status === 'aktif' ? 'success' : ($jersey->status === 'pending_review' ? 'warning' : 'danger') }} fs-6">
                                @if($jersey->type === 'pelanggan')
                                    {{ $jersey->status === 'aktif' ? 'Aktif (Disetujui)' : ($jersey->status === 'pending_review' ? 'Menunggu Review' : 'Ditolak') }}
                                @else
                                    {{ $jersey->display_status }}
                                @endif
                            </span>
                        </td>
                        <td>{{ $jersey->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('admin.jerseys.edit', $jersey->slug) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                
                                <!-- Tombol untuk melihat foto -->
                                @php
                                    $allPhotos = $jersey->getAllPhotosAttribute();
                                @endphp
                                @if(count($allPhotos) > 0)
                                    <button type="button" class="btn btn-info btn-sm w-100" data-bs-toggle="modal" data-bs-target="#photosModal{{ $jersey->slug }}">
                                        <i class="fas fa-images"></i> Lihat Foto ({{ count($allPhotos) }})
                                    </button>
                                @endif
                                
                                <form action="{{ route('admin.jerseys.destroy', $jersey->slug) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Yakin ingin menghapus jersey ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Modal untuk menampilkan foto -->
                    @php
                        $allPhotos = $jersey->getAllPhotosAttribute();
                    @endphp
                    @if(count($allPhotos) > 0)
                        <div class="modal fade" id="photosModal{{ $jersey->slug }}" tabindex="-1" aria-labelledby="photosModalLabel{{ $jersey->slug }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="photosModalLabel{{ $jersey->slug }}">Foto - {{ $jersey->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="photosCarousel{{ $jersey->slug }}" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators">
                                                @foreach($allPhotos as $index => $photoPath)
                                                    <button type="button" data-bs-target="#photosCarousel{{ $jersey->slug }}" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
                                                @endforeach
                                            </div>
                                            <div class="carousel-inner">
                                                @foreach($allPhotos as $index => $photoPath)
                                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                        <img src="{{ asset('storage/' . $photoPath) }}" class="d-block w-100" style="max-height: 500px; object-fit: contain;" alt="Foto {{ $index + 1 }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if(count($allPhotos) > 1)
                                                <button class="carousel-control-prev" type="button" data-bs-target="#photosCarousel{{ $jersey->slug }}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#photosCarousel{{ $jersey->slug }}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data jersey sistem</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{ $jerseys->links() }}
</div>
@endsection