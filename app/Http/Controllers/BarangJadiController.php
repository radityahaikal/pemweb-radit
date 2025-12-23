<?php

namespace App\Http\Controllers;

use App\Models\BarangJadi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DetailBarangController;

class BarangJadiController extends Controller
{
    /**
     * Menampilkan daftar semua Barang Jadi (untuk index.blade.php)
     */
    public function index()
    {
        $barangJadis = BarangJadi::orderBy('kodejadi', 'asc')->get();
        return view('barangjadi.index', compact('barangJadis'));
    }

    /**
     * Menampilkan formulir untuk membuat Barang Jadi baru (untuk create.blade.php)
     */
    public function create()
    {
        // Jika kodejadi dibuat otomatis, lakukan logika pembuatan kode di sini
        return view('barangjadi.create');
    }

    /**
     * Menyimpan Barang Jadi yang baru dibuat ke database
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kodejadi' => 'required|string|unique:barangjadi,kodejadi|max:10',
            'barangataulayanan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $barangJadi = BarangJadi::create($request->all());

        // Redirect ke halaman detail (show) untuk menambahkan komposisi/detail
        return redirect()->route('barangjadi.show', $barangJadi->kodejadi)
                         ->with('success', 'Data Barang Jadi berhasil ditambahkan! Sekarang Anda dapat menambahkan komposisi bahannya.');
    }

    /**
     * Menampilkan Barang Jadi tertentu (untuk show.blade.php)
     * Memuat relasi detailBarang dan bahanBaku di dalamnya.
     */
    public function show($kodejadi)
    {
        // Eager loading detailBarang dan relasi bahanBaku di dalamnya
        $barangJadi = BarangJadi::with('detailBarang.bahanBaku')
                                 ->where('kodejadi', $kodejadi)
                                 ->firstOrFail();
                                 
        return view('barangjadi.show', compact('barangJadi'));
    }

    /**
     * Menampilkan formulir untuk mengedit Barang Jadi (untuk edit.blade.php)
     */
    public function edit($kodejadi)
    {
        $barangJadi = BarangJadi::where('kodejadi', $kodejadi)->firstOrFail();
        return view('barangjadi.edit', compact('barangJadi'));
    }

    /**
     * Memperbarui Barang Jadi di database
     */
    public function update(Request $request, $kodejadi)
    {
        $validator = Validator::make($request->all(), [
            'barangataulayanan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $barangJadi = BarangJadi::where('kodejadi', $kodejadi)->firstOrFail();
        $barangJadi->update($request->all());

        return redirect()->route('barangjadi.index')
                         ->with('success', 'Data Barang Jadi berhasil diubah!');
    }

    /**
     * Menghapus Barang Jadi dari database
     */
    public function destroy($kodejadi)
    {
        $barangJadi = BarangJadi::where('kodejadi', $kodejadi)->firstOrFail();
        
        try {
            // Hapus detail terkait terlebih dahulu jika belum di-cascade di database
            // $barangJadi->detailBarang()->delete(); 
            
            $barangJadi->delete();
            return redirect()->route('barangjadi.index')
                             ->with('success', 'Data Barang Jadi berhasil dihapus!');

        } catch (\Exception $e) {
            // Tangani error jika terjadi pelanggaran foreign key
            return redirect()->route('barangjadi.index')
                             ->with('error', 'Gagal menghapus! Data ini masih digunakan di transaksi lain.');
        }
    }
    
    public function cetakKomposisi($kodejadi)
    {
        // Eager loading detailBarang dan relasi bahanBaku di dalamnya
        $barangJadi = BarangJadi::with('detailBarang.bahanBaku')
                                ->where('kodejadi', $kodejadi)
                                ->firstOrFail();

        // Hitung total ukuran yang dibutuhkan
        $totalUkuran = 0;
        foreach ($barangJadi->detailBarang as $detail) {
            $totalUkuran += $detail->ukuran;
        }

        // Kirim data ke view cetak
        return view('barangjadi.cetak', compact('barangJadi', 'totalUkuran'));
    }
}