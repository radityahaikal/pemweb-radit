@extends('layout')

@section('title', 'Tambah Bahan Baku Pembelian')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Tambah Bahan Baku untuk Nota: {{ $pembelian->nopembelian }}</h2>

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

            {{-- Form akan POST ke DetailPembelianController@store --}}
            <form action="{{ route('pembelian.detail.store', $pembelian->nopembelian) }}" method="POST">
                @csrf
                
                <div class="form-group row">
                    <label for="kodebaku" class="col-sm-3 col-form-label">BAHAN BAKU</label>
                    <div class="col-sm-9">
                        <select name="kodebaku" id="kodebaku" class="form-control" required>
                            <option value="">--Pilih Bahan Baku--</option>
                            {{-- Looping menggunakan variabel $bahanBaku --}}
                            @foreach ($bahanBaku as $baku)
                                <option value="{{ $baku->kodebaku }}" data-harga="{{ $baku->harga }}">
                                    {{ $baku->jenis }} ({{ $baku->satuan }}) - (Rp {{ number_format($baku->harga, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    {{-- Menggunakan 'banyaknya' sesuai nama kolom DB --}}
                    <label for="banyaknya" class="col-sm-3 col-form-label">BANYAKNYA (Unit/Kilo/Meter dll)</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="banyaknya" name="banyaknya" value="{{ old('banyaknya', 1) }}" min="1" required>
                    </div>
                </div>

                <div class="tombol text-right mt-4">
                    <button type="submit" class="btn btn-success">Simpan Bahan Baku</button>
                    {{-- Kembali ke detail pembelian --}}
                    <a href="{{ route('pembelian.show', $pembelian->nopembelian) }}" class="btn btn-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection