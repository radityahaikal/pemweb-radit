@extends('layout')

@section('title', 'Ubah Detail Item: ' . $bahanBaku->jenis)

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Ubah Item Nota: {{ $pembelian->nopembelian }}</h2>
    {{-- Variabel: $bahanBaku dari Controller --}}
    <p>Bahan Baku: <strong>{{ $bahanBaku->jenis }}</strong></p>
    <p>Harga Satuan: <strong>Rp {{ number_format($bahanBaku->harga, 0, ',', '.') }}</strong></p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Ubah Banyaknya Bahan Baku</h6>
        </div>
        <div class="card-body">
            
            {{-- Form akan mengirim PUT request ke route pembelian.detail.update --}}
            {{-- Variabel: $detailItem (DetailPembelian) dan $bahanBaku (BahanBaku) --}}
            <form action="{{ route('pembelian.detail.update', ['pembelian' => $pembelian->nopembelian, 'kodebaku' => $detailItem->kodebaku]) }}" method="POST">
                @csrf
                @method('PUT') {{-- Penting untuk menggunakan metode PUT/PATCH --}}

                <div class="form-group">
                    {{-- Menggunakan 'banyaknya' sesuai nama kolom DB --}}
                    <label for="banyaknya">Banyaknya Baru</label> 
                    <input type="number" 
                            name="banyaknya" 
                            id="banyaknya" 
                            class="form-control @error('banyaknya') is-invalid @enderror" 
                            value="{{ old('banyaknya', $detailItem->banyaknya) }}" 
                            min="1" 
                            required>
                    @error('banyaknya')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                <a href="{{ route('pembelian.show', $pembelian->nopembelian) }}" class="btn btn-secondary">Batal</a>
            </form>
            
        </div>
    </div>
</div>
@endsection