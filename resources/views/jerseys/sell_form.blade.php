@extends('layouts.app')

@section('title', 'Jual Jersey')

@section('content')
<div class="container">
    <h1 class="mb-4">Jual Jersey</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('jerseys.sell') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Jersey</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga (Rp)</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="size" class="form-label">Ukuran</label>
                                    <select class="form-control @error('size') is-invalid @enderror" id="size" name="size" required>
                                        <option value="">Pilih Ukuran</option>
                                        <option value="S" {{ old('size') == 'S' ? 'selected' : '' }}>S</option>
                                        <option value="M" {{ old('size') == 'M' ? 'selected' : '' }}>M</option>
                                        <option value="L" {{ old('size') == 'L' ? 'selected' : '' }}>L</option>
                                        <option value="XL" {{ old('size') == 'XL' ? 'selected' : '' }}>XL</option>
                                    </select>
                                    @error('size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="condition" class="form-label">Kondisi</label>
                                    <select class="form-control @error('condition') is-invalid @enderror" id="condition" name="condition" required>
                                        <option value="">Pilih Kondisi</option>
                                        <option value="baru" {{ old('condition') == 'baru' ? 'selected' : '' }}>Baru</option>
                                        <option value="bekas" {{ old('condition') == 'bekas' ? 'selected' : '' }}>Bekas</option>
                                    </select>
                                    @error('condition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" required>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Foto Utama Jersey</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*" required>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Upload foto utama jersey yang jelas</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="photos" class="form-label">Foto Tambahan (Opsional)</label>
                                    <input type="file" class="form-control @error('photos') is-invalid @enderror" id="photos" name="photos[]" accept="image/*" multiple>
                                    @error('photos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Pilih beberapa foto tambahan (depan, belakang, samping) - Tekan Ctrl/Cmd untuk memilih banyak file</div>
                                </div>
                                
                                <input type="hidden" name="type" value="pelanggan">
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Ajukan Jersey
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection