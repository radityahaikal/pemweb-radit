@extends('layout') 
@section('title', 'Ubah Komposisi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="h3 mb-4 text-gray-800">Ubah Komposisi untuk: {{ $barangJadi->barangataulayanan }} ({{ $barangJadi->kodejadi }})</h1>
            <a href="{{ route('barangjadi.show', $barangJadi->kodejadi) }}" class="btn btn-danger btn-sm mb-3">Kembali</a>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('barangjadi.detail.update', ['kodejadi' => $barangJadi->kodejadi, 'kodebaku' => $detail->kodebaku]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label>Kode Barang Jadi</label>
                            <input type="text" class="form-control" value="{{ $barangJadi->kodejadi }}" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label>Bahan Baku</label>
                            <input type="text" class="form-control" value="{{ $detail->bahanBaku->jenis }} ({{ $detail->kodebaku }})" readonly>
                        </div>

                        <div class="form-group">
                            <label for="ukuran">Ukuran yang Dibutuhkan</label>
                            <input type="number" step="0.01" class="form-control @error('ukuran') is-invalid @enderror" id="ukuran" name="ukuran" value="{{ old('ukuran', $detail->ukuran) }}" required placeholder="Masukkan ukuran baru">
                            @error('ukuran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-main">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection