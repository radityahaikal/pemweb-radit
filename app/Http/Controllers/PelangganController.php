<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua pelanggan.
     */
    public function index()
    {
        // Mengurutkan berdasarkan data yang paling baru dibuat
        $pelanggans = Pelanggan::latest()->paginate(10);
        return view('pelanggan.index', compact('pelanggans'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat pelanggan baru.
     */
    public function create()
    {
        return view('pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan pelanggan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'idpelanggan' => 'required|string|max:20|unique:pelanggan,idpelanggan',
            'namapelanggan' => 'required|string|max:50',
            'jenispelanggan' => 'required|string|max:50',
            'notelp' => 'required|string|max:20',
        ]);

        // Buat data baru
        Pelanggan::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pelanggan.index')
                         ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail satu pelanggan.
     */
    public function show(Pelanggan $pelanggan)
    {
        return view('pelanggan.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit pelanggan.
     */
    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data pelanggan di database.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        // Validasi input
        $request->validate([
            'namapelanggan' => 'required|string|max:50',
            'jenispelanggan' => 'required|string|max:50',
            'notelp' => 'required|string|max:20',
        ]);

        // Update data
        $pelanggan->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pelanggan.index')
                         ->with('success', 'Data Pelanggan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus pelanggan dari database.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        try {
            $pelanggan->delete();
            return redirect()->route('pelanggan.index')
                             ->with('success', 'Pelanggan berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani error jika pelanggan masih terhubung dengan data lain (misal: penjualan)
            return redirect()->route('pelanggan.index')
                             ->with('error', 'Pelanggan tidak dapat dihapus karena masih memiliki data transaksi terkait.');
        }
    }
}