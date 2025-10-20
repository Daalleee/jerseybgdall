@extends('layouts.app')

@section('title', 'JerseyDall - Jual Beli Jersey Online')

@section('content')
<div class="container">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold">Selamat Datang di JerseyDall</h1>
            <p class="lead">Platform jual beli jersey terlengkap dengan verifikasi manual untuk keamanan transaksi.</p>
            <div class="d-grid gap-2 d-sm-inline-block">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <i class="fas fa-tshirt" style="font-size: 10rem; color: #0d6efd;"></i>
        </div>
    </div>
    
    <hr class="my-5">
    
    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <i class="fas fa-tshirt fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Jual Jersey</h5>
                    <p class="card-text">Jual jersey bekas atau baru milikmu dengan mudah dan aman.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <i class="fas fa-shopping-cart fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Beli Jersey</h5>
                    <p class="card-text">Temukan jersey impianmu dengan harga terjangkau.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <i class="fas fa-shield-alt fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Verifikasi Aman</h5>
                    <p class="card-text">Setiap transaksi diverifikasi secara manual untuk keamanan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection