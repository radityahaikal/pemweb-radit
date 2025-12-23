@extends('layout') 
@section('title', 'Tambah Komposisi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="h3 mb-4 text-gray-800">Tambah Bahan Baku untuk: {{ $barangJadi->barangataulayanan }} ({{ $barangJadi->kodejadi }})</h1>
            <a href="{{ route('barangjadi.show', $barangJadi->kodejadi) }}" class="btn btn-danger btn-sm mb-3">Kembali</a>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('barangjadi.detail.store', $barangJadi->kodejadi) }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="kodebaku">Bahan Baku</label>
                            <select class="form-control @error('kodebaku') is-invalid @enderror" id="kodebaku" name="kodebaku" required>
                                <option value="" disabled selected>-- Pilih Bahan Baku --</option>
                                @foreach ($bahanBakus as $baku)
                                    <option value="{{ $baku->kodebaku }}" {{ old('kodebaku') == $baku->kodebaku ? 'selected' : '' }}>
                                        {{ $baku->kodebaku }} - {{ $baku->jenis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kodebaku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="ukuran">Ukuran yang Dibutuhkan</label>
                            <input type="number" step="0.01" class="form-control @error('ukuran') is-invalid @enderror" id="ukuran" name="ukuran" value="{{ old('ukuran') }}" required placeholder="Masukkan ukuran">
                            @error('ukuran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-main">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection