@extends('layout')

@section('title', 'Daftar Supplier')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Supplier</h2>

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
            <a href="{{ route('supplier.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Supplier
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Supplier</th>
                            <th>Nama Supplier</th>
                            <th>Alamat</th>
                            <th>No. Telp</th>
                            <th>PIC</th>
                            <th>No. Telp PIC</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($Suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->idsupplier }}</td>
                                <td>{{ $supplier->nama }}</td>
                                <td>{{ $supplier->alamat }}</td>
                                <td>{{ $supplier->telp }}</td>
                                <td>{{ $supplier->pic }}</td>
                                <td>{{ $supplier->telppic }}</td>
                                <td>
                                    <a href="{{ route('supplier.edit', $supplier->idsupplier) }}" class="btn btn-warning btn-sm text-white">
                                        <i class="fas fa-edit"></i> Ubah
                                    </a>
                                    <form action="{{ route('supplier.destroy', $supplier->idsupplier) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data supplier {{ $supplier->nama }}?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data supplier.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $Suppliers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection