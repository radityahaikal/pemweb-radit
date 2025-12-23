@extends('layout')

@section('title', 'Daftar Pembelian')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Pembelian Bahan Baku</h2>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        {{-- Penyesuaian: Tombol Tambah dipindah ke kiri, tulisan Data Pembelian dihapus --}}
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            {{-- Tombol Tambah Pembelian (Di kiri, menggunakan warna oranye/warning sesuai gambar) --}}
            <a href="{{ route('pembelian.create') }}" class="btn btn-primary">
                 <i class="fas fa-plus"></i> Tambah Pembelian
            </a>
            
            {{-- Bagian ini dikosongkan karena tulisan "Data Pembelian" dihapus --}}
            <div></div> 
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTablePembelian" width="100%" cellspacing="0">
                    <thead class="table-primary">
                        <tr>
                            <th>No. Pembelian</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Pegawai</th>
                            <th>Subtotal (Rp)</th>
                            <th>Aksi</th> 
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembelian as $nota)
                            <tr>
                                <td>{{ $nota->nopembelian }}</td>
                                <td>{{ \Carbon\Carbon::parse($nota->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $nota->supplier->nama ?? 'N/A' }}</td>
                                <td>{{ $nota->pegawai->namapegawai ?? 'N/A' }}</td>
                                <td>{{ number_format($nota->subtotal, 0, ',', '.') }}</td>
                                
                                {{-- KOLOM AKSI (Ubah & Hapus) --}}
                                <td class="text-nowrap">
                                    {{-- Tombol Ubah --}}
                                    <a href="{{ route('pembelian.edit', $nota->nopembelian) }}" class="btn btn-warning btn-sm text-white">
                                        <i class="fas fa-edit"></i> Ubah
                                    </a>
                                    
                                    {{-- Form Hapus --}}
                                    <form action="{{ route('pembelian.destroy', $nota->nopembelian) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus nota pembelian {{ $nota->nopembelian }} beserta detailnya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                                
                                {{-- KOLOM KETERANGAN (Detail & Cetak) --}}
                                <td class="text-nowrap">
                                    {{-- Tombol Detail --}}
                                    <a class="btn btn-info btn-sm" href="{{ route('pembelian.show', $nota->nopembelian) }}">
                                         <i class="fa fa-eye"></i> Detail
                                    </a>
                                    
                                    {{-- Tombol Cetak --}}
                                    <a class="btn btn-primary btn-sm" href="{{ route('pembelian.cetak', $nota->nopembelian) }}" target="_blank">
                                        <i class="fas fa-print"></i> Cetak
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection