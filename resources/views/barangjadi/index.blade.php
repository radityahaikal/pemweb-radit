@extends('layout') 
@section('title', 'Daftar Barang Jadi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Daftar Barang Jadi</h1>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Menambahkan penanganan error untuk Foreign Key --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <a href="{{ route('barangjadi.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Barang Jadi
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Jadi</th>
                                    <th>Barang/Layanan</th>
                                    <th>Harga</th>
                                    <th>Satuan</th>
                                    <th>Aksi</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangJadis as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->kodejadi }}</td>
                                    <td>{{ $item->barangataulayanan }}</td>
                                    <td>Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->satuan }}</td>
                                    <td>
                                        <a href="{{ route('barangjadi.edit', $item->kodejadi) }}" class="btn btn-warning btn-sm text-white">
                                            <i class="fas fa-edit"></i> Ubah
                                        </a>
                                        <form action="{{ route('barangjadi.destroy', $item->kodejadi) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data Barang Jadi {{ $item->barangataulayanan }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('barangjadi.show', $item->kodejadi) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('barangjadi.cetak', $item->kodejadi) }}" class="btn btn-primary btn-sm" target="_blank">
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
    </div>
</div>
@endsection