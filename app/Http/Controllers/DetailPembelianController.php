<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\BahanBaku;
use App\Models\DetailPembelian;
use Illuminate\Http\Request;

class DetailPembelianController extends Controller
{
    /**
     * Menampilkan form untuk menambah item detail ke pembelian
     */
    public function create(Pembelian $pembelian)
    {
        $bahanBaku = BahanBaku::all();
        return view('pembelian.detail_create', compact('pembelian', 'bahanBaku'));
    }

    /**
     * Menyimpan detail item baru ke pembelian.
     * Mengakumulasi quantity jika bahan baku sudah ada.
     */
    public function store(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            'kodebaku' => 'required|string|exists:bahanbaku,kodebaku',
            'banyaknya' => 'required|integer|min:1', // Menggunakan 'banyaknya' sesuai DB
        ]);

        $kodeBaku = $request->input('kodebaku');
        $banyaknyaBaru = $request->input('banyaknya');

        $bahanBaku = BahanBaku::where('kodebaku', $kodeBaku)->firstOrFail();
        $hargaSatuan = $bahanBaku->harga;
        
        // 1. CEK APAKAH ITEM SUDAH ADA
        $detailLama = DetailPembelian::where('nopembelian', $pembelian->nopembelian)
                                    ->where('kodebaku', $kodeBaku)
                                    ->first();

        if ($detailLama) {
            // 2. JIKA SUDAH ADA: Update Banyaknya dan Total
            $banyaknyaLama = $detailLama->banyaknya;
            $totalBanyaknyaBaru = $banyaknyaLama + $banyaknyaBaru;
            $newTotalRp = $totalBanyaknyaBaru * $hargaSatuan;

            $detailLama->update([
                'banyaknya' => $totalBanyaknyaBaru,
                'total' => $newTotalRp,
            ]);

            $message = 'Kuantitas bahan baku ' . $bahanBaku->jenis . ' berhasil ditambahkan.';

        } else {
            // 3. JIKA BELUM ADA: Buat baris DetailPembelian baru
            $newTotalRp = $banyaknyaBaru * $hargaSatuan;
            
            DetailPembelian::create([
                'nopembelian' => $pembelian->nopembelian,
                'kodebaku' => $kodeBaku,
                'banyaknya' => $banyaknyaBaru,
                'total' => $newTotalRp,
            ]);

            $message = 'Bahan baku ' . $bahanBaku->jenis . ' berhasil ditambahkan ke nota.';
        }

        // 4. Update Subtotal Keseluruhan di Pembelian Header
        $pembelian->updateSubtotal();

        return redirect()->route('pembelian.show', $pembelian->nopembelian)
                         ->with('success', $message);
    }

    /**
     * Menampilkan form untuk mengedit detail item.
     */
    public function edit(Pembelian $pembelian, string $kodebaku)
    {
        $detailItem = DetailPembelian::where('nopembelian', $pembelian->nopembelian)
                                    ->where('kodebaku', $kodebaku)
                                    ->firstOrFail();

        $bahanBaku = BahanBaku::where('kodebaku', $kodebaku)->firstOrFail();
        
        return view('pembelian.detail_edit', compact('pembelian', 'detailItem', 'bahanBaku'));
    }

    /**
     * Menyimpan perubahan detail item.
     */
    public function update(Request $request, Pembelian $pembelian, string $kodebaku)
    {
        $request->validate([
            'banyaknya' => 'required|integer|min:1',
        ]);
        
        $newBanyaknya = $request->input('banyaknya');

        $detailItem = DetailPembelian::where('nopembelian', $pembelian->nopembelian)
                                    ->where('kodebaku', $kodebaku)
                                    ->firstOrFail();

        $hargaSatuan = $detailItem->bahanBaku->harga;
        
        $newTotalRp = $newBanyaknya * $hargaSatuan;

        $detailItem->update([
            'banyaknya' => $newBanyaknya,
            'total' => $newTotalRp,
        ]);

        $pembelian->updateSubtotal();
        
        return redirect()->route('pembelian.show', $pembelian->nopembelian)
                         ->with('success', 'Detail item pembelian berhasil diperbarui.');
    }

    /**
     * Menghapus item detail dari pembelian (menggunakan composite key)
     */
    public function destroy(Pembelian $pembelian, string $kodebaku)
    {
        // Hapus baris menggunakan Query Builder (Solusi untuk composite key)
        DetailPembelian::where('nopembelian', $pembelian->nopembelian)
                       ->where('kodebaku', $kodebaku)
                       ->delete(); 

        $pembelian->updateSubtotal(); // Hitung ulang total
        
        return redirect()->route('pembelian.show', $pembelian->nopembelian)
                         ->with('success', 'Item berhasil dihapus dari nota dan subtotal diperbarui.');
    }
}