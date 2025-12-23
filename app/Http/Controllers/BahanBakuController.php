<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku; // Import model BahanBaku

class BahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua bahan baku.
     */
    public function index()
    {
        // Mengurutkan berdasarkan data yang paling baru dibuat
        $bahanBakus = BahanBaku::latest()->paginate(10);
        return view('bahanbaku.index', compact('bahanBakus'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat bahan baku baru.
     */
    public function create()
    {
        return view('bahanbaku.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan bahan baku baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kodebaku' => 'required|string|max:50|unique:bahanbaku,kodebaku',
            'jenis' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'harga' => 'required|integer|min:0',
        ]);

        // Buat data baru
        BahanBaku::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('bahanbaku.index')
                         ->with('success', 'Bahan Baku berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail satu bahan baku.
     */
    public function show(BahanBaku $bahanbaku)
    {
        return view('bahanbaku.show', compact('bahanbaku'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit bahan baku.
     */
    public function edit(BahanBaku $bahanbaku)
    {
        return view('bahanbaku.edit', compact('bahanbaku'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data bahan baku di database.
     */
    public function update(Request $request, BahanBaku $bahanbaku)
    {
        // Validasi input
        $request->validate([
            'jenis' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'harga' => 'required|integer|min:0',
            // 'stok' tidak diupdate dari sini, tapi dari transaksi pembelian/pemakaian
        ]);

        // Update data
        $bahanbaku->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('bahanbaku.index')
                         ->with('success', 'Bahan Baku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus bahan baku dari database.
     */
    public function destroy(BahanBaku $bahanbaku)
    {
        $bahanbaku->delete();

        return redirect()->route('bahanbaku.index')
                         ->with('success', 'Bahan Baku berhasil dihapus.');
    }
}