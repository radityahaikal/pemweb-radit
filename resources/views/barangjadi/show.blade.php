@extends('layout')
@section('title', 'Detail Barang Jadi: ' . $barangJadi->barangataulayanan)

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Detail Barang Jadi: {{ $barangJadi->barangataulayanan }}</h2>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- CARD 1: INFORMASI UTAMA BARANG JADI (Tombol Ubah Dihapus) --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Barang Jadi</h6>
            
            {{-- Tombol Ubah Data Utama Dihapus Sesuai Permintaan --}}
            <div></div> 
        </div>
        <div class="card-body">
            <p><strong>Kode Barang Jadi:</strong> {{ $barangJadi->kodejadi }}</p>
            <p><strong>Nama:</strong> {{ $barangJadi->barangataulayanan }}</p>
            <p><strong>Harga:</strong> Rp. {{ number_format($barangJadi->harga, 0, ',', '.') }}</p>
            <p><strong>Stok Saat Ini:</strong> {{ $barangJadi->stok }}</p>
            <p><strong>Satuan:</strong> {{ $barangJadi->satuan }}</p>
        </div>
    </div>
    
    {{-- CARD 2: KOMPOSISI BAHAN BAKU --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Komposisi Bahan Baku (Detail Barang Jadi)</h6>
            
            {{-- Tombol Tambah Item (Menggunakan btn-success/warna hijau) --}}
            <a href="{{ route('barangjadi.detail.create', $barangJadi->kodejadi) }}" class="btn btn-sm btn-primary">
                 <i class="fas fa-plus"></i> Tambah Bahan Baku
            </a>
        </div>
        <div class="card-body">
            @if ($barangJadi->detailBarang->isEmpty())
                <div class="alert alert-info">Belum ada komposisi bahan baku untuk barang jadi ini.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Bahan Baku</th>
                                <th>Kode Baku</th>
                                <th>Ukuran (Qty)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalUkuran = 0; @endphp
                            @foreach ($barangJadi->detailBarang as $index => $detail)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $detail->bahanBaku->jenis }}</td>
                                    <td>{{ $detail->kodebaku }}</td>
                                    <td>{{ $detail->ukuran }}</td>
                                    <td class="text-nowrap">
                                        {{-- Tombol Ubah --}}
                                        <a href="{{ route('barangjadi.detail.edit', ['kodejadi' => $barangJadi->kodejadi, 'kodebaku' => $detail->kodebaku]) }}" class="btn btn-warning btn-sm">Ubah</a>
                                        
                                        {{-- Form Hapus --}}
                                        <form action="{{ route('barangjadi.detail.destroy', ['kodejadi' => $barangJadi->kodejadi, 'kodebaku' => $detail->kodebaku]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus komposisi bahan baku {{ $detail->bahanBaku->jenis }} ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @php $totalUkuran += $detail->ukuran; @endphp
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-right"><strong>Total Ukuran Bahan Baku:</strong></td>
                                <td colspan="2"><strong>{{ $totalUkuran }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    
    {{-- Tombol Kembali --}}
    <a href="{{ route('barangjadi.index') }}" class="btn btn-secondary">Kembali ke Daftar Barang Jadi</a>
</div>
@endsection