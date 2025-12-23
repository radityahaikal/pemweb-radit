@extends('layout')

@section('title', 'Ubah Detail Item: ' . $barangJadi->barangataulayanan)

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Ubah Item Nota: {{ $penjualan->nopenjualan }}</h2>
    <p>Barang/Layanan: <strong>{{ $barangJadi->barangataulayanan }}</strong></p>
    <p>Harga Satuan: <strong>Rp {{ number_format($barangJadi->harga, 0, ',', '.') }}</strong></p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Ubah Kuantitas</h6>
        </div>
        <div class="card-body">
            
            {{-- Form akan mengirim PUT request ke route penjualan.detail.update --}}
            <form action="{{ route('penjualan.detail.update', ['penjualan' => $penjualan->nopenjualan, 'kodejadi' => $detailItem->kodejadi]) }}" method="POST">
                @csrf
                @method('PUT') {{-- Penting untuk menggunakan metode PUT/PATCH --}}

                <div class="form-group">
                    <label for="quantity">Kuantitas Baru</label>
                    <input type="number" 
                           name="quantity" 
                           id="quantity" 
                           class="form-control @error('quantity') is-invalid @enderror" 
                           value="{{ old('quantity', $detailItem->quantity) }}" 
                           min="1" 
                           required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                <a href="{{ route('penjualan.show', $penjualan->nopenjualan) }}" class="btn btn-secondary">Batal</a>
            </form>
            
        </div>
    </div>
</div>
@endsection