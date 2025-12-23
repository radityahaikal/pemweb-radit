<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua bahan baku.
     */
    public function index()
    {
        // Mengurutkan berdasarkan data yang paling baru dibuat
        $Suppliers = Supplier::latest()->paginate(10);
        return view('supplier.index', compact('Suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat bahan baku baru.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan bahan baku baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'idsupplier' => 'required|string|max:50|unique:supplier,idsupplier',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telp' => 'required|string|max:20',
            'pic' => 'required|string|max:255',
            'telppic' => 'required|string|max:20',
        ]);

        // Buat data baru
        Supplier::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('supplier.index')
                         ->with('success', 'Supplier berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail satu bahan baku.
     */
    public function show(Supplier $supplier)
    {
        return view('supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit bahan baku.
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data bahan baku di database.
     */
    public function update(Request $request, Supplier $supplier)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telp' => 'required|integer',
            'pic' => 'required|string|max:255',
            'telppic' => 'required|integer',
        ]);

        // Update data
        $supplier->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('supplier.index')
                         ->with('success', 'Supplier berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus bahan baku dari database.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('supplier.index')
                         ->with('success', 'Supplier berhasil dihapus.');
    }
}
