@extends('layout')

@section('title', 'Detail Pembelian: ' . $pembelian->nopembelian)

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Detail Pembelian: {{ $pembelian->nopembelian }}</h2>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Utama Pembelian</h6>
        </div>
        <div class="card-body">
            <p><strong>No. Pembelian:</strong> {{ $pembelian->nopembelian }}</p>
            <p><strong>Supplier:</strong> {{ $pembelian->supplier->nama ?? 'N/A' }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pembelian->tanggal)->format('d/m/Y') }}</p>
            <p><strong>Pegawai:</strong> {{ $pembelian->pegawai->namapegawai ?? 'N/A' }}</p>
            <p><strong>Subtotal Transaksi:</strong> Rp {{ number_format($pembelian->subtotal, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Item Bahan Baku Dibeli</h6>
            <a href="{{ route('pembelian.detail.create', $pembelian->nopembelian) }}" class="btn btn-sm btn-primary">Tambah Bahan Baku</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableDetail" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Bahan Baku</th>
                            <th>Kode Baku</th>
                            <th>Banyaknya</th>
                            <th>Harga Satuan</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pembelian->detail as $item)
                            <tr>
                                <td>{{ $item->bahanBaku->jenis ?? 'Bahan Dihapus' }}</td>
                                <td>{{ $item->kodebaku }}</td>
                                <td>{{ $item->banyaknya }}</td>
                                <td>Rp {{ number_format($item->bahanBaku->harga ?? 0, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                <td class="text-nowrap">
                                    {{-- Tombol Ubah --}}
                                    <a href="{{ route('pembelian.detail.edit', ['pembelian' => $pembelian->nopembelian, 'kodebaku' => $item->kodebaku]) }}" class="btn btn-warning btn-sm">Ubah</a>

                                    {{-- Form Hapus --}}
                                    <form action="{{ route('pembelian.detail.destroy', ['pembelian' => $pembelian->nopembelian, 'kodebaku' => $item->kodebaku]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus item {{ $item->bahanBaku->jenis ?? 'ini' }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada bahan baku untuk nota ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
    <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Kembali ke Daftar Pembelian</a>
</div>
@endsection