@extends('layout')

@section('title', 'Home - Dashboard')

@section('content')
      <h2 class="mb-4">Home</h2>
      
      <div class="row">
        
        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
              <div>
                <h5 class="card-title">Jumlah Pelanggan</h5>
                <p class="card-text" style="font-size: 2rem;">
                  {{ $jumlahPelanggan }}
                </p>
              </div>
              <div style="font-size: 4rem; color:#333;">
                <i class="fa-solid fa-user"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
              <div>
                <h5 class="card-title">Jumlah Barang</h5>
                <p class="card-text" style="font-size: 2rem;">
                  {{ $jumlahBarang }}
                </p>
              </div>
              <div style="font-size: 4rem; color:#333;">
                <i class="fa-solid fa-tools"></i>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
              <div>
                <h5 class="card-title">Jumlah Penjualan</h5>
                <p class="card-text" style="font-size: 2rem;">
                  {{ $jumlahPenjualan }}
                </p>
              </div>
              <div style="font-size: 4rem; color:#333;">
                <i class="fa-solid fa-file-invoice"></i>
              </div>
              
            </div>
          </div>
        </div>
        
      </div>

      <div class="row">


  <!-- Card Total Pemasukan memanjang di bawah dan tengah -->
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card shadow">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div class="mb-2"> 
              <a href="{{ route('home', ['filter' => 'hari']) }}" class="btn btn-sm {{ $currentFilter == 'hari' ? 'btn-primary' : 'btn-outline-primary' }}">Hari Ini</a>
              <a href="{{ route('home', ['filter' => 'bulan']) }}" class="btn btn-sm {{ $currentFilter == 'bulan' ? 'btn-success' : 'btn-outline-success' }}">Bulan Ini</a>
              <a href="{{ route('home', ['filter' => 'tahun']) }}" class="btn btn-sm {{ $currentFilter == 'tahun' ? 'btn-warning' : 'btn-outline-warning' }}">Tahun Ini</a>
              <a href="{{ route('home') }}" class="btn btn-sm {{ !$currentFilter ? 'btn-secondary' : 'btn-outline-secondary' }}">Semua</a>
            </div>

            <h4 class="card-title">Total Pemasukan</h4>
            <p class="card-text" style="font-size: 2.5rem;">
              Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
            </p>
          </div>
          <div style="font-size: 4rem; color:#333;">
            <i class="fa-solid fa-money-bill-wave"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection