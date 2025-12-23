@extends('layout')

@section('title', 'Daftar Pegawai')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Pegawai</h2>

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
            <a href="{{ route('pegawai.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pegawai
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Pegawai</th>
                            <th>Nama Pegawai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pegawais as $pegawai)
                            <tr>
                                <td>{{ $pegawai->idpegawai }}</td>
                                <td>{{ $pegawai->namapegawai }}</td>
                                <td>
                                    <a href="{{ route('pegawai.edit', $pegawai->idpegawai) }}" class="btn btn-warning btn-sm text-white">
                                        <i class="fas fa-edit"></i> Ubah
                                    </a>
                                    <form action="{{ route('pegawai.destroy', $pegawai->idpegawai) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data pegawai {{ $pegawai->namapegawai }}?');">
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
                                <td colspan="3" class="text-center">Tidak ada data pegawai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $pegawais->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

