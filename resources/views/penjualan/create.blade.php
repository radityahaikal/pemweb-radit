@extends('layout')

@section('title', 'Tambah Penjualan Baru')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Tambah Penjualan Baru</h2>

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

            {{-- Form akan POST ke PenjualanController@store --}}
            <form action="{{ route('penjualan.store') }}" method="POST">
                @csrf
                
                <div class="form-group row">
                    <label for="nopenjualan" class="col-sm-3 col-form-label">NO PENJUALAN</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nopenjualan" name="nopenjualan" value="{{ old('nopenjualan') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="idpelanggan" class="col-sm-3 col-form-label">PELANGGAN</label>
                    <div class="col-sm-9">
                        <select name="idpelanggan" id="idpelanggan" class="form-control" required>
                            <option value="">--Pilih--</option>
                            @foreach ($pelanggan as $pl)
                                <option value="{{ $pl->idpelanggan }}" {{ old('idpelanggan') == $pl->idpelanggan ? 'selected' : '' }}>
                                    {{ $pl->namapelanggan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tanggal" class="col-sm-3 col-form-label">TANGGAL</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="garansi" class="col-sm-3 col-form-label">GARANSI</label>
                    <div class="col-sm-9">
                        {{-- Mengisi nilai default garansi 30 hari ke depan (opsional) --}}
                        <input type="date" class="form-control" id="garansi" name="garansi" value="{{ old('garansi', date('Y-m-d', strtotime('+30 days'))) }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection