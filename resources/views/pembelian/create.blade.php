@extends('layout')

@section('title', 'Tambah Pembelian Baru')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Tambah Pembelian Baru</h2>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pembelian</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('pembelian.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="nopembelian">No. Pembelian</label>
                    <input type="text" name="nopembelian" id="nopembelian" class="form-control @error('nopembelian') is-invalid @enderror" value="{{ old('nopembelian') }}" required>
                    @error('nopembelian')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal Pembelian</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="idsupplier">Supplier</label>
                    <select name="idsupplier" id="idsupplier" class="form-control @error('idsupplier') is-invalid @enderror" required>
                        <option value="">Pilih Supplier</option>
                        @foreach ($supplier as $s)
                            <option value="{{ $s->idsupplier }}" {{ old('idsupplier') == $s->idsupplier ? 'selected' : '' }}>
                                {{ $s->idsupplier }} - {{ $s->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('idsupplier')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="idpegawai">Pegawai Bertanggung Jawab</label>
                    <select name="idpegawai" id="idpegawai" class="form-control @error('idpegawai') is-invalid @enderror" required>
                        <option value="">Pilih Pegawai</option>
                        @foreach ($pegawai as $p)
                            <option value="{{ $p->idpegawai }}" {{ old('idpegawai') == $p->idpegawai ? 'selected' : '' }}>
                                {{ $p->idpegawai }} - {{ $p->namapegawai }}
                            </option>
                        @endforeach
                    </select>
                    @error('idpegawai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection