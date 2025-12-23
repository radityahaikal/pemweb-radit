<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\BarangJadi; // Asumsikan model Barang Jadi Anda
use App\Models\DetailPenjualan; // Asumsikan model Detail Penjualan Anda
use Illuminate\Http\Request;

class DetailPenjualanController extends Controller
{
    // Menampilkan form tambah item untuk nota tertentu
    public function create(Penjualan $penjualan)
    {
        $barangJadi = BarangJadi::all(); // Ambil semua data barang jadi
        
        return view('penjualan.detail.create', compact('penjualan', 'barangJadi'));
    }

    // Menyimpan item baru ke detail penjualan
    public function store(Request $request, Penjualan $penjualan)
    {
        // 1. Validasi Input
        $request->validate([
            'kodejadi' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $kodejadi = $request->input('kodejadi');
        $quantityBaru = $request->input('quantity');

        // Ambil harga dari BarangJadi
        $barangJadi = BarangJadi::where('kodejadi', $kodejadi)->first();

        if (!$barangJadi) {
            return redirect()->back()->with('error', 'Barang/Layanan tidak ditemukan.');
        }

        $hargaSatuan = $barangJadi->harga;
        
        // 2. CEK APAKAH ITEM SUDAH ADA DI NOTA INI
        $detailLama = DetailPenjualan::where('nopenjualan', $penjualan->nopenjualan)
                                    ->where('kodejadi', $kodejadi)
                                    ->first();

        if ($detailLama) {
            // 3. JIKA SUDAH ADA: Update Quantity dan Total
            
            $quantityLama = $detailLama->quantity;
            $totalQuantityBaru = $quantityLama + $quantityBaru;
            $newTotalRp = $totalQuantityBaru * $hargaSatuan;

            $detailLama->update([
                'quantity' => $totalQuantityBaru,
                'total' => $newTotalRp,
            ]);

            $message = 'Quantity item ' . $barangJadi->barangataulayanan . ' berhasil ditambahkan.';

        } else {
            // 4. JIKA BELUM ADA: Buat baris DetailPenjualan baru
            
            $newTotalRp = $quantityBaru * $hargaSatuan;
            
            DetailPenjualan::create([
                'nopenjualan' => $penjualan->nopenjualan,
                'kodejadi' => $kodejadi,
                'quantity' => $quantityBaru,
                'total' => $newTotalRp,
            ]);

            $message = 'Item ' . $barangJadi->barangataulayanan . ' berhasil ditambahkan ke nota.';
        }

        // 5. Update Total Keseluruhan di Penjualan Header
        $penjualan->updateTotal();

        return redirect()->route('penjualan.show', $penjualan->nopenjualan)->with('success', $message);
    }
    
    // Anda juga perlu metode destroy jika Anda ingin item dapat dihapus
    public function destroy(Penjualan $penjualan, $kodejadi)
    {
        // 1. Cari detail item (hanya untuk mendapatkan 'total' yang akan dihapus)
        $detailItem = DetailPenjualan::where('nopenjualan', $penjualan->nopenjualan)
                                    ->where('kodejadi', $kodejadi)
                                    ->firstOrFail();
        
        $oldTotal = $detailItem->total;

        // 2. HAPUS BARIS SECARA MANUAL MENGGUNAKAN QUERY BUILDER
        DetailPenjualan::where('nopenjualan', $penjualan->nopenjualan)
                    ->where('kodejadi', $kodejadi)
                    ->delete(); // <-- SOLUSI: Menggunakan statik delete pada Query Builder

        // 3. Update total di header penjualan
        $penjualan->updateTotal(); 
        
        return redirect()->route('penjualan.show', $penjualan->nopenjualan)
            ->with('success', 'Item berhasil dihapus dari nota dan total nota diperbarui.');
    }

    public function edit(Penjualan $penjualan, string $kodejadi)
    {
        // 1. Cari detail item yang akan diedit (menggunakan composite key)
        $detailItem = DetailPenjualan::where('nopenjualan', $penjualan->nopenjualan)
                                    ->where('kodejadi', $kodejadi)
                                    ->firstOrFail();

        // 2. Ambil data barang jadi terkait (untuk nama dan harga)
        $barangJadi = BarangJadi::where('kodejadi', $kodejadi)->firstOrFail();
        
        // 3. Kirim data ke View (asumsikan nama view Anda adalah 'detail.edit')
        return view('penjualan.detail.edit', compact('penjualan', 'detailItem', 'barangJadi'));
    }

    /**
     * Menyimpan perubahan detail item.
     */
    public function update(Request $request, Penjualan $penjualan, string $kodejadi)
    {
        // 1. Validasi Input (Hanya Quantity yang bisa diubah, karena kodejadi tidak boleh diubah)
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        $newQuantity = $request->input('quantity');

        // 2. Cari detail item lama
        $detailItem = DetailPenjualan::where('nopenjualan', $penjualan->nopenjualan)
                                    ->where('kodejadi', $kodejadi)
                                    ->firstOrFail();

        // 3. Ambil harga satuan
        $hargaSatuan = $detailItem->barangJadi->harga; // Akses relasi barangJadi
        
        // 4. Hitung Total Baru
        $newTotalRp = $newQuantity * $hargaSatuan;

        // 5. Update Detail Item
        $detailItem->update([
            'quantity' => $newQuantity,
            'total' => $newTotalRp,
        ]);

        // 6. Update Total Keseluruhan di Penjualan Header
        $penjualan->updateTotal();
        
        return redirect()->route('penjualan.show', $penjualan->nopenjualan)
                         ->with('success', 'Detail item penjualan berhasil diperbarui.');
    }
}