@extends('layout')

@section('title', 'Tambah Pelanggan')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Tambah Pelanggan Baru</h2>

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

            <form action="{{ route('pelanggan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="idpelanggan">ID Pelanggan</label>
                    <input type="text" class="form-control" id="idpelanggan" name="idpelanggan" value="{{ old('idpelanggan') }}" required>
                </div>
                <div class="form-group">
                    <label for="namapelanggan">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="namapelanggan" name="namapelanggan" value="{{ old('namapelanggan') }}" required>
                </div>
                <div class="form-group">
                    <label for="jenispelanggan">Jenis Pelanggan</label>
                    <select class="form-control" id="jenispelanggan" name="jenispelanggan" required>
                        <option value="">Pilih Jenis Pelanggan</option>
                        <option value="Umum" {{ old('jenispelanggan') == 'Umum' ? 'selected' : '' }}>Umum</option>
                        <option value="Toko" {{ old('jenispelanggan') == 'Toko' ? 'selected' : '' }}>Toko</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="notelp">No. Telepon</label>
                    <input type="number" class="form-control" id="notelp" name="notelp" value="{{ old('notelp') }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection