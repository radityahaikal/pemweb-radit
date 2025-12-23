@extends('layout')

@section('title', 'Tambah Kendaraan')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Tambah Kendaraan Baru</h2>

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

            <form action="{{ route('kendaraan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nopol">No. Polisi Kendaraan</label>
                    <input type="text" class="form-control" id="nopol" name="nopol" value="{{ old('nopol') }}" required>
                </div>
                <div class="form-group">
                    <label for="tipe">Tipe Kendaraan</label>
                    <input type="text" class="form-control" id="tipe" name="tipe" value="{{ old('tipe') }}" required>
                </div>
                <div class="form-group">
                    <label for="idpelanggan">Pemilik Kendaraan</label>
                    <select class="form-control" id="idpelanggan" name="idpelanggan" required>
                        <option value="">Pilih Pelanggan</option>
                        @foreach ($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->idpelanggan }}" {{ old('idpelanggan') == $pelanggan->idpelanggan ? 'selected' : '' }}>
                                {{ $pelanggan->namapelanggan }} ({{ $pelanggan->idpelanggan }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection