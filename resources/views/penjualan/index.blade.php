@extends('layout')
@section('title', 'Daftar Penjualan')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Penjualan</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Penjualan
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-primary">
                        <tr>
                            <th>No Penjualan</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Jumlah Rp</th>
                            <th>Garansi</th>
                            <th>Aksi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penjualan as $nota)
                            <tr>
                                <td>{{ $nota->nopenjualan }}</td>
                                <td>{{ $nota->pelanggan->namapelanggan ?? 'Pelanggan Dihapus' }}</td> 
                                <td>{{ \Carbon\Carbon::parse($nota->tanggal)->format('d/m/Y') }}</td>
                                <td>Rp {{ number_format($nota->jumlahrp, 0, ',', '.') }}</td> 
                                <td>{{ \Carbon\Carbon::parse($nota->garansi)->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('penjualan.edit', $nota->nopenjualan) }}" class="btn btn-warning btn-sm text-white">
                                        <i class="fas fa-edit"></i> Ubah
                                    </a> 
                                    <form action="{{ route('penjualan.destroy', $nota->nopenjualan) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini? Semua detail penjualan juga akan ikut terhapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('penjualan.show', $nota->nopenjualan) }}">
                                        <i class="fa fa-eye"></i>Detail
                                    </a>
                                    <a class="btn btn-primary btn-sm" href="{{ route('penjualan.cetak', $nota->nopenjualan) }}" target="_blank"><i class="fas fa-print"></i> Cetak</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data penjualan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Karena Anda menggunakan Datatables, pagination ini mungkin tidak diperlukan. --}}
            {{-- Jika Anda tetap ingin mengaktifkan Laravel Pagination, pastikan di Controller: $penjualan = Penjualan::paginate(10); --}}
            {{-- <div class="d-flex justify-content-center">
                {{ $penjualan->links() }}
            </div> --}}
        </div>
    </div>
</div>
@endsection