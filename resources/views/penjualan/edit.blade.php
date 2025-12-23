@extends('layout')

@section('title', 'Ubah Penjualan')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Ubah Penjualan</h2>

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

            {{-- Form akan PUT/PATCH ke PenjualanController@update --}}
            <form action="{{ route('penjualan.update', $penjualan->nopenjualan) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group row">
                    <label for="nopenjualan" class="col-sm-3 col-form-label">NO PENJUALAN</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nopenjualan" name="nopenjualan" value="{{ $penjualan->nopenjualan }}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="idpelanggan" class="col-sm-3 col-form-label">NAMA PELANGGAN</label>
                    <div class="col-sm-9">
                        <select name="idpelanggan" id="idpelanggan" class="form-control" required>
                            <option selected disabled>Pilih</option>
                            @foreach ($pelanggan as $pl)
                                <option value="{{ $pl->idpelanggan }}" {{ old('idpelanggan', $penjualan->idpelanggan) == $pl->idpelanggan ? 'selected' : '' }}>
                                    {{ $pl->namapelanggan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tanggal" class="col-sm-3 col-form-label">TANGGAL</label>
                    <div class="col-sm-9">
                        {{-- Laravel/HTML5 input date menerima format YYYY-MM-DD --}}
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', $penjualan->tanggal) }}" required> 
                    </div>
                </div>

                <div class="form-group row">
                    <label for="garansi" class="col-sm-3 col-form-label">GARANSI</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="garansi" name="garansi" value="{{ old('garansi', $penjualan->garansi) }}" required>
                    </div>
                </div>

                <div class="tombol text-right mt-4">
                    <button type="submit" name="proses" class="btn btn-success">Update</button>
                    <a href="{{ route('penjualan.index') }}" class="btn btn-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection