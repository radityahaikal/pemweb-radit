<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Supplier;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    // --- FUNGSI UNTUK PEMBELIAN UTAMA ---

    /**
     * Menampilkan daftar semua pembelian
     */
    public function index()
    {
        $pembelian = Pembelian::with('supplier', 'pegawai')->latest()->get();
        return view('pembelian.index', compact('pembelian'));
    }

    /**
     * Menampilkan form untuk membuat pembelian baru
     */
    public function create()
    {
        $supplier = Supplier::all();
        $pegawai = Pegawai::all();
        return view('pembelian.create', compact('supplier', 'pegawai'));
    }

    /**
     * Menyimpan pembelian baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nopembelian' => 'required|string|unique:pembelian,nopembelian',
            'idsupplier' => 'required|string|exists:supplier,idsupplier',
            'idpegawai' => 'required|string|exists:pegawai,idpegawai',
            'tanggal' => 'required|date',
        ]);

        Pembelian::create([
            'nopembelian' => $request->nopembelian,
            'idsupplier' => $request->idsupplier,
            'idpegawai' => $request->idpegawai,
            'tanggal' => $request->tanggal,
            'subtotal' => 0, // Jumlah awal adalah 0
        ]);

        // Redirect ke halaman detail untuk menambahkan item
        return redirect()->route('pembelian.show', $request->nopembelian)
            ->with('success', 'Data pembelian berhasil dibuat. Silakan tambahkan detail bahan baku.');
    }

    /**
     * Menampilkan detail pembelian beserta item-itemnya
     */
    public function show(Pembelian $pembelian)
    {
        // Eager load relasi
        $pembelian->load('supplier', 'pegawai', 'detail.bahanBaku');
        return view('pembelian.show', compact('pembelian'));
    }

    /**
     * Menampilkan form untuk mengedit data pembelian
     */
    public function edit(Pembelian $pembelian)
    {
        $supplier = Supplier::all(); // <-- Pastikan ini ada
        $pegawai = Pegawai::all();   // <-- Pastikan ini ada
        return view('pembelian.edit', compact('pembelian', 'supplier', 'pegawai'));
    }   

    /**
     * Mengupdate data pembelian di database
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            'idsupplier' => 'required|string|exists:supplier,idsupplier',
            'idpegawai' => 'required|string|exists:pegawai,idpegawai',
            'tanggal' => 'required|date',
        ]);

        $pembelian->update($request->only(['idsupplier', 'idpegawai', 'tanggal']));

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil diubah.');
    }

    /**
     * Menghapus data pembelian beserta detailnya
     */
    public function destroy(Pembelian $pembelian)
    {
        DB::transaction(function () use ($pembelian) {
            $pembelian->detail()->delete(); // Hapus semua detail terkait
            $pembelian->delete(); // Hapus pembelian utama
        });

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil dihapus.');
    }

    public function cetak(Pembelian $pembelian)
    {
        // Pastikan relasi 'detail', 'supplier', dan 'pegawai' tersedia di model Pembelian
        $pembelian->load('detail.bahanBaku', 'supplier', 'pegawai'); 

        // Mengembalikan view cetak
        return view('pembelian.cetak', compact('pembelian'));
    }
}