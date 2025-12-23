@extends('layout')

@section('title', 'Daftar Kendaraan')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Kendaraan</h2>

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
            <a href="{{ route('kendaraan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kendaraan
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No. Polisi</th>
                            <th>Tipe</th>
                            <th>Pemilik</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kendaraans as $kendaraan)
                            <tr>
                                <td>{{ $kendaraan->nopol }}</td>
                                <td>{{ $kendaraan->tipe }}</td>
                                <td>{{ $kendaraan->pelanggan->namapelanggan ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('kendaraan.edit', ['nopol' => $kendaraan->nopol]) }}" class="btn btn-warning btn-sm text-white">
                                        <i class="fas fa-edit"></i> Ubah
                                    </a>
                                    <form action="{{ route('kendaraan.destroy', ['nopol' => $kendaraan->nopol]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data kendaraan {{ $kendaraan->nopol }}?');">
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
                                <td colspan="5" class="text-center">Tidak ada data kendaraan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $kendaraans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection