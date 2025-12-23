@extends('layout')

@section('title', 'Edit Kendaraan')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Edit Data Kendaraan</h2>

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

            <form action="{{ route('kendaraan.update', ['nopol' => $kendaraan->nopol]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nopol">No. Polisi Kendaraan</label>
                    <input type="text" class="form-control" id="nopol" name="nopol" value="{{ $kendaraan->nopol }}" readonly>
                    <small class="form-text text-muted">No. Polisi tidak dapat diubah.</small>
                </div>
                <div class="form-group">
                    <label for="tipe">Tipe Kendaraan</label>
                    <input type="text" class="form-control" id="tipe" name="tipe" value="{{ $kendaraan->tipe }}" required>
                </div>
                <div class="form-group">
                    <label for="idpelanggan">Pemilik Kendaraan</label>
                    <select class="form-control" id="idpelanggan" name="idpelanggan" required>
                        <option value="">Pilih Pelanggan</option>
                        @foreach ($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->idpelanggan }}" {{ $kendaraan->idpelanggan == $pelanggan->idpelanggan ? 'selected' : '' }}>
                                {{ $pelanggan->namapelanggan }} ({{ $pelanggan->idpelanggan }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection