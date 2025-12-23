@extends('layout')
@section('title', 'Ubah Barang Jadi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="h3 mb-4 text-gray-800">Ubah Barang Jadi: {{ $barangJadi->kodejadi }}</h1>
            <a href="{{ route('barangjadi.index') }}" class="btn btn-danger btn-sm mb-3">Kembali</a>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('barangjadi.update', $barangJadi->kodejadi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="kodejadi">Kode Barang Jadi</label>
                            <input type="text" class="form-control" id="kodejadi" value="{{ $barangJadi->kodejadi }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="barangataulayanan">Barang atau Layanan</label>
                            <input type="text" class="form-control @error('barangataulayanan') is-invalid @enderror" id="barangataulayanan" name="barangataulayanan" value="{{ old('barangataulayanan', $barangJadi->barangataulayanan) }}" required>
                            @error('barangataulayanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga', $barangJadi->harga) }}" required>
                            @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <select class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" required>
                                <option value="" disabled>-- Pilih Satuan --</option>
                                @php $currentSatuan = old('satuan', $barangJadi->satuan); @endphp
                                <option value="Pcs" {{ $currentSatuan == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="Set" {{ $currentSatuan == 'Set' ? 'selected' : '' }}>Set</option>
                                <option value="Unit" {{ $currentSatuan == 'Unit' ? 'selected' : '' }}>Unit</option>
                                <option value="Jasa" {{ $currentSatuan == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                            </select>
                            @error('satuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-main">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection