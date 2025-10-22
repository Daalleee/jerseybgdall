@extends('layouts.app')

@section('title', isset($jersey) ? 'Edit Jersey' : 'Tambah Jersey Baru')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ isset($jersey) ? 'Edit Jersey' : 'Tambah Jersey Baru' }}</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ isset($jersey) ? route('admin.jerseys.update', $jersey->id) : route('admin.jerseys.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($jersey))
                            @method('PUT')
                        @endif
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Jersey</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $jersey->name ?? '') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $jersey->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga (Rp)</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $jersey->price ?? '') }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ukuran Tersedia</label>
                                    <div class="d-flex flex-wrap gap-2 mb-2" id="selectedSizesContainer">
                                        <!-- Selected sizes will be displayed here -->
                                        @if(old('sizes'))
                                            @foreach(old('sizes') as $size)
                                                <span class="badge bg-primary d-flex align-items-center">
                                                    {{ $size }}
                                                    <input type="hidden" name="sizes[]" value="{{ $size }}">
                                                    <button type="button" class="btn-close btn-close-white ms-1" onclick="removeSize(this, '{{ $size }}')"></button>
                                                </span>
                                            @endforeach
                                        @elseif(isset($jersey) && $jersey->sizes)
                                            @foreach($jersey->sizes as $size)
                                                <span class="badge bg-primary d-flex align-items-center">
                                                    {{ $size }}
                                                    <input type="hidden" name="sizes[]" value="{{ $size }}">
                                                    <button type="button" class="btn-close btn-close-white ms-1" onclick="removeSize(this, '{{ $size }}')"></button>
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="d-flex flex-wrap gap-2" id="sizeOptions">
                                        <button type="button" class="btn btn-outline-secondary size-btn" data-size="S" {{ (old('sizes') && in_array('S', old('sizes')) || (isset($jersey) && $jersey->sizes && in_array('S', $jersey->sizes))) ? 'disabled' : '' }}>S</button>
                                        <button type="button" class="btn btn-outline-secondary size-btn" data-size="M" {{ (old('sizes') && in_array('M', old('sizes')) || (isset($jersey) && $jersey->sizes && in_array('M', $jersey->sizes))) ? 'disabled' : '' }}>M</button>
                                        <button type="button" class="btn btn-outline-secondary size-btn" data-size="L" {{ (old('sizes') && in_array('L', old('sizes')) || (isset($jersey) && $jersey->sizes && in_array('L', $jersey->sizes))) ? 'disabled' : '' }}>L</button>
                                        <button type="button" class="btn btn-outline-secondary size-btn" data-size="XL" {{ (old('sizes') && in_array('XL', old('sizes')) || (isset($jersey) && $jersey->sizes && in_array('XL', $jersey->sizes))) ? 'disabled' : '' }}>XL</button>
                                    </div>
                                    <div class="form-text">Klik ukuran untuk menambahkan, klik X untuk menghapus</div>
                                    @error('sizes')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="condition" class="form-label">Kondisi</label>
                                    <select class="form-control @error('condition') is-invalid @enderror" id="condition" name="condition" required>
                                        <option value="baru" {{ (old('condition', $jersey->condition ?? '') == 'baru') ? 'selected' : '' }}>Baru</option>
                                        <option value="bekas" {{ (old('condition', $jersey->condition ?? '') == 'bekas') ? 'selected' : '' }}>Bekas</option>
                                    </select>
                                    @error('condition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stok</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $jersey->stock ?? 1) }}" min="1" required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Foto Jersey</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if(isset($jersey) && $jersey->photo)
                                        <div class="mt-2">
                                            <p>Foto saat ini:</p>
                                            <img src="{{ asset('storage/' . $jersey->photo) }}" alt="Foto Jersey" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    @endif
                                </div>
                                
                                <input type="hidden" name="type" value="sistem">
                                <input type="hidden" name="user_id" value="">
                                <input type="hidden" name="address" value="Sistem">
                                <input type="hidden" name="phone_number" value="Sistem">
                                <input type="hidden" name="status" value="aktif">
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.jerseys.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($jersey) ? 'Update Jersey' : 'Tambah Jersey' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function removeSize(element, size) {
            // Hapus elemen badge
            element.parentElement.remove();
            
            // Aktifkan kembali tombol ukuran
            const sizeBtn = document.querySelector(`.size-btn[data-size="${size}"]`);
            if (sizeBtn) {
                sizeBtn.disabled = false;
                sizeBtn.classList.remove('btn-secondary');
                sizeBtn.classList.add('btn-outline-secondary');
            }
        }
        
        document.querySelectorAll('.size-btn').forEach(button => {
            button.addEventListener('click', function() {
                const size = this.getAttribute('data-size');
                
                // Cek apakah ukuran sudah ditambahkan
                const existingInput = document.querySelector(`input[type="hidden"][name="sizes[]"][value="${size}"]`);
                if (existingInput) return;
                
                // Tambahkan badge ukuran ke container
                const container = document.getElementById('selectedSizesContainer');
                const badge = document.createElement('span');
                badge.className = 'badge bg-primary d-flex align-items-center';
                badge.innerHTML = `
                    ${size}
                    <input type="hidden" name="sizes[]" value="${size}">
                    <button type="button" class="btn-close btn-close-white ms-1" onclick="removeSize(this, '${size}')"></button>
                `;
                container.appendChild(badge);
                
                // Disable tombol dan ubah tampilan
                this.disabled = true;
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-secondary');
            });
        });
    </script>
</div>
@endsection