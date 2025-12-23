@extends('layout')

@section('title', 'Tambah Supplier')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Tambah Supplier Baru</h2>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('supplier.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="idsupplier">ID Supplier</label>
                    <input type="text" class="form-control" id="idsupplier" name="idsupplier" value="{{ old('idsupplier') }}" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Supplier</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat Supplier</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}" required>
                </div>
                <div class="form-group">
                    <label for="telp">No. Telepon</label>
                    <input type="number" class="form-control" id="telp" name="telp" value="{{ old('telp') }}" required>
                </div>
                <div class="form-group">
                    <label for="pic">PIC</label>
                    <input type="text" class="form-control" id="pic" name="pic" value="{{ old('pic') }}" required>
                </div>
                <div class="form-group">
                    <label for="telppic">No. Telepon PIC</label>
                    <input type="number" class="form-control" id="telppic" name="telppic" value="{{ old('telppic') }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection