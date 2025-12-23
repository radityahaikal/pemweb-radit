@extends('layout')

@section('title', 'Ubah Pembelian')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Ubah Pembelian Bahan Baku</h2>

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

            {{-- Form akan PUT/PATCH ke PembelianController@update --}}
            <form action="{{ route('pembelian.update', $pembelian->nopembelian) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group row">
                    <label for="nopembelian" class="col-sm-3 col-form-label">NO PEMBELIAN</label>
                    <div class="col-sm-9">
                        {{-- Nomor Pembelian tidak boleh diubah (readonly) --}}
                        <input type="text" class="form-control" id="nopembelian" name="nopembelian" value="{{ $pembelian->nopembelian }}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="idsupplier" class="col-sm-3 col-form-label">NAMA SUPPLIER</label>
                    <div class="col-sm-9">
                        <select name="idsupplier" id="idsupplier" class="form-control @error('idsupplier') is-invalid @enderror" required>
                            <option value="" selected disabled>Pilih Supplier</option>
                            @foreach ($supplier as $s)
                                <option value="{{ $s->idsupplier }}" {{ old('idsupplier', $pembelian->idsupplier) == $s->idsupplier ? 'selected' : '' }}>
                                    {{ $s->nama }} ({{ $s->idsupplier }})
                                </option>
                            @endforeach
                        </select>
                        @error('idsupplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="idpegawai" class="col-sm-3 col-form-label">PEGAWAI</label>
                    <div class="col-sm-9">
                        <select name="idpegawai" id="idpegawai" class="form-control @error('idpegawai') is-invalid @enderror" required>
                            <option value="" selected disabled>Pilih Pegawai</option>
                            @foreach ($pegawai as $p)
                                <option value="{{ $p->idpegawai }}" {{ old('idpegawai', $pembelian->idpegawai) == $p->idpegawai ? 'selected' : '' }}>
                                    {{ $p->namapegawai }}
                                </option>
                            @endforeach
                        </select>
                        @error('idpegawai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tanggal" class="col-sm-3 col-form-label">TANGGAL PEMBELIAN</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $pembelian->tanggal) }}" required> 
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                {{-- Field 'garansi' dihapus karena tidak relevan untuk Pembelian --}}

                <div class="tombol text-right mt-4">
                    <button type="submit" name="proses" class="btn btn-success">Update</button>
                    <a href="{{ route('pembelian.index') }}" class="btn btn-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection