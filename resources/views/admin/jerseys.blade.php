@extends('layouts.app')

@section('title', 'Manajemen Jersey - Admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Manajemen Jersey</h1>
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('admin.jerseys.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus"></i> Tambah Jersey
            </a>
            <a href="{{ route('admin.jerseys.system') }}" class="btn btn-success btn-lg ms-2">
                <i class="fas fa-tshirt"></i> Jersey Sistem
            </a>
        </div>
        
        <form method="GET" class="d-flex" style="width: 300px;">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari jersey..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    
    <!-- Tabs untuk membedakan jersey sistem dan pelanggan -->
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ !request('type') || request('type') == 'all' ? 'active' : '' }}" 
               href="{{ route('admin.jerseys.index', ['type' => 'all', 'search' => request('search')]) }}">Semua</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('type') == 'sistem' ? 'active' : '' }}" 
               href="{{ route('admin.jerseys.index', ['type' => 'sistem', 'search' => request('search')]) }}">Jersey Sistem</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('type') == 'pelanggan' ? 'active' : '' }}" 
               href="{{ route('admin.jerseys.index', ['type' => 'pelanggan', 'search' => request('search')]) }}">Jersey Pelanggan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('type') == 'review' ? 'active' : '' }}" 
               href="{{ route('admin.jerseys.index', ['type' => 'review', 'search' => request('search')]) }}">Butuh Review</a>
        </li>
    </ul>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Ukuran Tersedia</th>
                    <th>Kondisi</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Penjual</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jerseys as $jersey)
                    <tr>
                        <td>{{ $jersey->id }}</td>
                        <td>{{ $jersey->name }}</td>
                        <td><span class="text-success fw-bold">Rp{{ number_format($jersey->price, 2, ',', '.') }}</span></td>
                        <td>
                            @if($jersey->sizes)
                                {{ $jersey->getAvailableSizesAttribute() }}
                            @else
                                {{ $jersey->size }}
                            @endif
                        </td>
                        <td>{{ ucfirst($jersey->condition) }}</td>
                        <td>
                            <span class="badge bg-{{ $jersey->type === 'sistem' ? 'primary' : 'secondary' }} fs-6">
                                {{ $jersey->type === 'sistem' ? 'Sistem' : 'Pelanggan' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $jersey->status === 'aktif' ? 'success' : ($jersey->status === 'pending_review' ? 'warning' : 'danger') }} fs-6">
                                {{ $jersey->status === 'aktif' ? 'Aktif' : ($jersey->status === 'pending_review' ? 'Menunggu Review' : 'Ditolak') }}
                            </span>
                        </td>
                        <td>
                            @if($jersey->user)
                                {{ $jersey->user->name }}
                            @else
                                {{ $jersey->type === 'sistem' ? 'Sistem' : 'Tidak ada' }}
                            @endif
                        </td>
                        <td>{{ $jersey->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('admin.jerseys.edit', $jersey->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                
                                <!-- Tombol untuk melihat foto -->
                                @php
                                    $allPhotos = $jersey->getAllPhotosAttribute();
                                @endphp
                                @if(count($allPhotos) > 0)
                                    <button type="button" class="btn btn-info btn-sm w-100" data-bs-toggle="modal" data-bs-target="#photosModal{{ $jersey->id }}">
                                        <i class="fas fa-images"></i> Lihat Foto ({{ count($allPhotos) }})
                                    </button>
                                @endif
                                
                                @if($jersey->status === 'pending_review' && $jersey->type === 'pelanggan')
                                    <form action="{{ route('admin.jerseys.approve', $jersey->id) }}" method="POST" class="mb-2">
                                        @csrf
                                        @method('PUT')
                                        <!-- Kirim parameter pagination untuk redirect kembali -->
                                        <input type="hidden" name="page" value="{{ request('page', 1) }}">
                                        <input type="hidden" name="type" value="{{ request('type', 'all') }}">
                                        <input type="hidden" name="search" value="{{ request('search', '') }}">
                                        <button type="submit" class="btn btn-success btn-sm w-100" onclick="return confirm('Yakin ingin menyetujui jersey ini?')">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.jerseys.reject', $jersey->id) }}" method="POST" class="mb-2">
                                        @csrf
                                        @method('PUT')
                                        <!-- Kirim parameter pagination untuk redirect kembali -->
                                        <input type="hidden" name="page" value="{{ request('page', 1) }}">
                                        <input type="hidden" name="type" value="{{ request('type', 'all') }}">
                                        <input type="hidden" name="search" value="{{ request('search', '') }}">
                                        <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin ingin menolak jersey ini?')">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </form>
                                @endif
                                
                                @if($jersey->user && $jersey->type === 'pelanggan')
                                    <a href="https://api.whatsapp.com/send?phone={{ urlencode($jersey->user->phone_number ?? $jersey->phone_number) }}" target="_blank" class="btn btn-success btn-sm w-100 mb-2">
                                        <i class="fab fa-whatsapp"></i> WhatsApp Penjual
                                    </a>
                                @endif
                                
                                <form action="{{ route('admin.jerseys.destroy', $jersey->id) }}" method="POST">
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
                        <div class="modal fade" id="photosModal{{ $jersey->id }}" tabindex="-1" aria-labelledby="photosModalLabel{{ $jersey->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="photosModalLabel{{ $jersey->id }}">Foto - {{ $jersey->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div class="row g-3">
                                                @foreach($allPhotos as $index => $photoPath)
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="card h-100">
                                                            <img src="{{ asset('storage/' . $photoPath) }}" class="card-img-top" style="height: 200px; object-fit: contain;" alt="Foto {{ $index + 1 }}">
                                                            <div class="card-body text-center">
                                                                <small class="text-muted">Foto {{ $index + 1 }} dari {{ count($allPhotos) }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <small class="text-muted">Total: {{ count($allPhotos) }} foto</small>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data jersey</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{ $jerseys->links() }}
</div>
@endsection