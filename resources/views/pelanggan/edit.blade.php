@extends('layout')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Edit Data Pelanggan</h2>

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

            <form action="{{ route('pelanggan.update', $pelanggan->idpelanggan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="idpelanggan">ID Pelanggan</label>
                    <input type="text" class="form-control" id="idpelanggan" name="idpelanggan" value="{{ $pelanggan->idpelanggan }}" readonly>
                </div>
                <div class="form-group">
                    <label for="namapelanggan">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="namapelanggan" name="namapelanggan" value="{{ $pelanggan->namapelanggan }}" required>
                </div>
                <div class="form-group">
                    <label for="jenispelanggan">Jenis Pelanggan</label>
                    <select class="form-control" id="jenispelanggan" name="jenispelanggan" required>
                        <option value="Umum" {{ $pelanggan->jenispelanggan == 'Umum' ? 'selected' : '' }}>Umum</option>
                        <option value="Toko" {{ $pelanggan->jenispelanggan == 'Toko' ? 'selected' : '' }}>Toko</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="notelp">No. Telepon</label>
                    <input type="number" class="form-control" id="notelp" name="notelp" value="{{ $pelanggan->notelp }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection