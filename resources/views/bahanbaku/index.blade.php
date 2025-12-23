@extends('layout')

@section('title', 'Daftar Bahan Baku')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Bahan Baku</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('bahanbaku.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Bahan Baku
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode Baku</th>
                            <th>Jenis</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bahanBakus as $bahanbaku)
                            <tr>
                                <td>{{ $bahanbaku->kodebaku }}</td>
                                <td>{{ $bahanbaku->jenis }}</td>
                                <td>{{ $bahanbaku->satuan }}</td>
                                <td>Rp {{ number_format($bahanbaku->harga, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('bahanbaku.edit', $bahanbaku->kodebaku) }}" class="btn btn-warning btn-sm text-white">
                                        <i class="fas fa-edit"></i> Ubah
                                    </a>
                                    <form action="{{ route('bahanbaku.destroy', $bahanbaku->kodebaku) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                                <td colspan="5" class="text-center">Tidak ada data bahan baku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $bahanBakus->links() }}
            </div>
        </div>
    </div>
</div>
@endsection