<?php

namespace App\Http\Controllers;

use App\Models\BarangJadi;
use App\Models\DetailBarang;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailBarangController extends Controller
{
    /**
     * Menampilkan formulir untuk menambah Detail Barang Baru (Mirip detailbarang-tambah.php)
     * @param string $kodejadi - Kode Barang Jadi Induk
     */
    public function create($kodejadi)
    {
        $barangJadi = BarangJadi::where('kodejadi', $kodejadi)->firstOrFail();
        $bahanBakus = BahanBaku::all(); // Ambil semua bahan baku untuk dropdown

        return view('barangjadi.detail.create', compact('barangJadi', 'bahanBakus'));
    }

    /**
     * Menyimpan Detail Barang yang baru dibuat (Mirip detailbarang-tambah.php POST)
     * @param Request $request
     * @param string $kodejadi - Kode Barang Jadi Induk
     */
    public function store(Request $request, $kodejadi)
    {
        // Pastikan Barang Jadi Induk ada
        BarangJadi::where('kodejadi', $kodejadi)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'kodebaku' => 'required|string|exists:bahanbaku,kodebaku',
            'ukuran' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Cek duplikasi: tidak boleh ada kodebaku yang sama dalam satu kodejadi
        $existingDetail = DetailBarang::where('kodejadi', $kodejadi)
                                      ->where('kodebaku', $request->kodebaku)
                                      ->exists();
        
        if ($existingDetail) {
            return redirect()->back()
                             ->with('error', 'Bahan Baku tersebut sudah ada dalam komposisi ini.')
                             ->withInput();
        }

        DetailBarang::create([
            'kodejadi' => $kodejadi,
            'kodebaku' => $request->kodebaku,
            'ukuran' => $request->ukuran,
        ]);

        return redirect()->route('barangjadi.show', $kodejadi)
                         ->with('success', 'Komposisi Bahan Baku berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit Detail Barang (Mirip detailbarang-ubah.php)
     * @param string $kodejadi - Kode Barang Jadi Induk
     * @param string $kodebaku - Kode Bahan Baku yang akan diubah
     */
    public function edit($kodejadi, $kodebaku)
    {
        $barangJadi = BarangJadi::where('kodejadi', $kodejadi)->firstOrFail();
        
        $detail = DetailBarang::with('bahanBaku')
                              ->where('kodejadi', $kodejadi)
                              ->where('kodebaku', $kodebaku)
                              ->firstOrFail();

        return view('barangjadi.detail.edit', compact('barangJadi', 'detail'));
    }

    /**
     * Memperbarui Detail Barang di database (Mirip detailbarang-ubah.php POST)
     * @param Request $request
     * @param string $kodejadi - Kode Barang Jadi Induk
     * @param string $kodebaku - Kode Bahan Baku yang akan diubah
     */
    public function update(Request $request, $kodejadi, $kodebaku)
    {
        $validator = Validator::make($request->all(), [
            'ukuran' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Menggunakan pembaruan eksplisit berbasis where untuk composite key
        $updated = DetailBarang::where('kodejadi', $kodejadi)
                            ->where('kodebaku', $kodebaku)
                            ->update([
                                'ukuran' => $request->ukuran,
                                // Tidak perlu menyebutkan created_at/updated_at karena sudah dinonaktifkan di Model
                            ]);
                            
        if ($updated === 0) {
            // Jika tidak ada baris yang diupdate (mungkin data tidak ditemukan)
            return redirect()->back()->with('error', 'Gagal mengubah ukuran. Data tidak ditemukan.');
        }

        return redirect()->route('barangjadi.show', $kodejadi)
                        ->with('success', 'Ukuran Bahan Baku berhasil diubah.');
    }

    /**
     * Menghapus Detail Barang dari database (Mirip detailbarang-hapus.php)
     * @param string $kodejadi - Kode Barang Jadi Induk
     * @param string $kodebaku - Kode Bahan Baku yang akan dihapus
     */
    public function destroy($kodejadi, $kodebaku)
    {
        DetailBarang::where('kodejadi', $kodejadi)
                    ->where('kodebaku', $kodebaku)
                    ->delete();

        return redirect()->route('barangjadi.show', $kodejadi)
                         ->with('success', 'Komposisi Bahan Baku berhasil dihapus.');
    }
}