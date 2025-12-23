<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua bahan baku.
     */
    public function index()
    {
        // Mengurutkan berdasarkan data yang paling baru dibuat
        $pegawais = Pegawai::latest()->paginate(10);
        return view('pegawai.index', compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat bahan baku baru.
     */
    public function create()
    {
        return view('pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan bahan baku baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'idpegawai' => 'required|string|max:50|unique:pegawai,idpegawai',
            'namapegawai' => 'required|string|max:255',
        ]);

        // Buat data baru
        Pegawai::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pegawai.index')
                         ->with('success', 'Pegawai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail satu bahan baku.
     */
    public function show(Pegawai $pegawai)
    {
        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit bahan baku.
     */
    public function edit(Pegawai $pegawai)
    {
        return view('pegawai.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data bahan baku di database.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        // Validasi input
        $request->validate([
            'namapegawai' => 'required|string|max:255',
        ]);

        // Update data
        $pegawai->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pegawai.index')
                         ->with('success', 'Pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus bahan baku dari database.
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();

        return redirect()->route('pegawai.index')
                         ->with('success', 'Pegawai berhasil dihapus.');
    }
}
