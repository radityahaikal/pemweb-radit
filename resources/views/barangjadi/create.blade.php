@extends('layout') 
@section('title', 'Tambah Barang Jadi')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Tambah Barang Jadi Baru</h2>

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
                    <form action="{{ route('barangjadi.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="kodejadi">Kode Barang Jadi</label>
                            <input type="text" class="form-control @error('kodejadi') is-invalid @enderror" id="kodejadi" name="kodejadi" value="{{ old('kodejadi') }}" required>
                            @error('kodejadi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="barangataulayanan">Barang atau Layanan</label>
                            <input type="text" class="form-control @error('barangataulayanan') is-invalid @enderror" id="barangataulayanan" name="barangataulayanan" value="{{ old('barangataulayanan') }}" required>
                            @error('barangataulayanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}" required>
                            @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <select class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" required>
                                <option value="" disabled selected>-- Pilih Satuan --</option>
                                <option value="Pcs" {{ old('satuan') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="Set" {{ old('satuan') == 'Set' ? 'selected' : '' }}>Set</option>
                                <option value="Unit" {{ old('satuan') == 'Unit' ? 'selected' : '' }}>Unit</option>
                                <option value="Jasa" {{ old('satuan') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                                </select>
                            @error('satuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('barangjadi.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection