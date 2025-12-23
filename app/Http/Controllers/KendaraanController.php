<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua kendaraan.
     */
    public function index()
    {
        // Mengurutkan berdasarkan data yang paling baru dibuat dan mengambil relasi pelanggan
        $kendaraans = Kendaraan::with('pelanggan')->latest()->paginate(10);
        return view('kendaraan.index', compact('kendaraans'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat kendaraan baru.
     */
    public function create()
    {
        $pelanggans = Pelanggan::all();
        return view('kendaraan.create', compact('pelanggans'));
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan kendaraan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nopol' => 'required|string|max:20|unique:kendaraan,nopol',
            'tipe' => 'required|string|max:50',
            'idpelanggan' => 'required|exists:pelanggan,idpelanggan',
        ]);

        // Buat data baru
        Kendaraan::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kendaraan.index')
                         ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail satu kendaraan.
     */
    public function show(Kendaraan $kendaraan)
    {
        return view('kendaraan.show', compact('kendaraan'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit kendaraan.
     */
    public function edit(Kendaraan $kendaraan)
    {
        $pelanggans = Pelanggan::all();
        return view('kendaraan.edit', compact('kendaraan', 'pelanggans'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data kendaraan di database.
     */
    public function update(Request $request, Kendaraan $kendaraan)
    {
        // Validasi input
        $request->validate([
            'tipe' => 'required|string|max:50',
            'idpelanggan' => 'required|exists:pelanggan,idpelanggan',
        ]);

        // Update data
        $kendaraan->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kendaraan.index')
                         ->with('success', 'Data Kendaraan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus kendaraan dari database.
     */
    public function destroy(Kendaraan $kendaraan)
    {
        // Anda bisa menambahkan try-catch block di sini jika ada relasi
        // yang mungkin menyebabkan error saat penghapusan, mirip seperti di PelangganController.
        // Untuk saat ini, kita asumsikan bisa langsung dihapus.
        try {
            $kendaraan->delete();
            return redirect()->route('kendaraan.index')
                             ->with('success', 'Kendaraan berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani error jika kendaraan masih terhubung dengan data lain
            // Misalnya, jika ada tabel 'servis' yang berelasi dengan 'kendaraan'
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1451){ // Foreign key constraint fails
                return redirect()->route('kendaraan.index')
                                 ->with('error', 'Kendaraan tidak dapat dihapus karena masih memiliki data transaksi terkait.');
            }
            // Untuk error lainnya
            return redirect()->route('kendaraan.index')
                             ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}