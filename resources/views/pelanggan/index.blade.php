@extends('layout')

@section('title', 'Daftar Pelanggan')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Pelanggan</h2>

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
        <div class="card-header py-3">
            <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pelanggan
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Pelanggan</th>
                            <th>Nama Pelanggan</th>
                            <th>Jenis</th>
                            <th>No. Telp</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelanggans as $pelanggan)
                            <tr>
                                <td>{{ $pelanggan->idpelanggan }}</td>
                                <td>{{ $pelanggan->namapelanggan }}</td>
                                <td>{{ $pelanggan->jenispelanggan }}</td>
                                <td>{{ $pelanggan->notelp }}</td>
                                <td>
                                    <a href="{{ route('pelanggan.edit', $pelanggan->idpelanggan) }}" class="btn btn-warning btn-sm text-white">
                                        <i class="fas fa-edit"></i> Ubah
                                    </a>
                                    <form action="{{ route('pelanggan.destroy', $pelanggan->idpelanggan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data pelanggan {{ $pelanggan->namapelanggan }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data pelanggan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $pelanggans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection