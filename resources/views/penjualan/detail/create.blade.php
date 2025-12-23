@extends('layout')

@section('title', 'Tambah Item Penjualan')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Tambah Item untuk Nota: {{ $penjualan->nopenjualan }}</h2>

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

            {{-- Form akan POST ke DetailPenjualanController@store --}}
            <form action="{{ route('penjualan.detail.store', $penjualan->nopenjualan) }}" method="POST">
                @csrf
                
                <div class="form-group row">
                    <label for="kodejadi" class="col-sm-3 col-form-label">BARANG / LAYANAN</label>
                    <div class="col-sm-9">
                        <select name="kodejadi" id="kodejadi" class="form-control" required>
                            <option value="">--Pilih Barang/Layanan--</option>
                            @foreach ($barangJadi as $barang)
                                <option value="{{ $barang->kodejadi }}" data-harga="{{ $barang->harga }}">
                                    {{ $barang->barangataulayanan }} (Rp {{ number_format($barang->harga, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="quantity" class="col-sm-3 col-form-label">QUANTITY</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                    </div>
                </div>

                <div class="tombol text-right mt-4">
                    <button type="submit" class="btn btn-success">Simpan Item</button>
                    <a href="{{ route('penjualan.show', $penjualan->nopenjualan) }}" class="btn btn-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection