@extends('layout')

@section('title', 'Detail Penjualan: ' . $penjualan->nopenjualan)

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Detail Penjualan: {{ $penjualan->nopenjualan }}</h2>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Utama</h6>
        </div>
        <div class="card-body">
            <p><strong>No. Penjualan:</strong> {{ $penjualan->nopenjualan }}</p>
            <p><strong>Pelanggan:</strong> {{ $penjualan->pelanggan->namapelanggan ?? 'N/A' }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d/m/Y') }}</p>
            <p><strong>Garansi Sampai:</strong> {{ \Carbon\Carbon::parse($penjualan->garansi)->format('d/m/Y') }}</p>
            <p><strong>Total Transaksi:</strong> Rp {{ number_format($penjualan->jumlahrp, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Item Penjualan</h6>
            {{-- Tombol Tambah Item baru, asumsikan route/controller sudah ada --}}
            <a href="{{ route('penjualan.detail.create', $penjualan->nopenjualan) }}" class="btn btn-sm btn-primary">Tambah Item</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableDetail" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Barang/Layanan</th>
                            <th>Quantity</th>
                            <th>Harga Satuan</th>
                            <th>Sub Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penjualan->detail as $item)
                            <tr>
                                {{-- Memastikan relasi 'barangJadi' sudah didefinisikan di model DetailPenjualan --}}
                                <td>{{ $item->barangJadi->barangataulayanan ?? 'Barang Dihapus' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->barangJadi->harga ?? 0, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('penjualan.detail.destroy', ['penjualan' => $penjualan->nopenjualan, 'kodejadi' => $item->kodejadi]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus item ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        <a href="{{ route('penjualan.detail.edit', ['penjualan' => $penjualan->nopenjualan, 'kodejadi' => $item->kodejadi]) }}" class="btn btn-warning btn-sm">Ubah</a>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada item untuk nota ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali ke Daftar Penjualan</a>
</div>
@endsection