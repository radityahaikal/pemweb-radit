<?php

namespace App\Http\Controllers;

use App\Models\BarangJadi;
use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    // --- FUNGSI UNTUK PENJUALAN UTAMA ---

    /**
     * Menampilkan daftar semua penjualan (menggantikan penjualan-lihat.php)
     */
    public function index()
    {
        $penjualan = Penjualan::with('pelanggan')->latest()->get();
        return view('penjualan.index', compact('penjualan'));
    }

    /**
     * Menampilkan form untuk membuat penjualan baru (menggantikan penjualan-tambah.php)
     */
    public function create()
    {
        $pelanggan = Pelanggan::all();
        return view('penjualan.create', compact('pelanggan'));
    }

    /**
     * Menyimpan penjualan baru ke database (menggantikan logika proses di penjualan-tambah.php)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nopenjualan' => 'required|string|unique:penjualan,nopenjualan',
            'idpelanggan' => 'required|string|exists:pelanggan,idpelanggan',
            'tanggal' => 'required|date',
            'garansi' => 'required|date',
        ]);

        Penjualan::create([
            'nopenjualan' => $request->nopenjualan,
            'idpelanggan' => $request->idpelanggan,
            'tanggal' => $request->tanggal,
            'garansi' => $request->garansi,
            'jumlahrp' => 0, // Jumlah awal adalah 0
        ]);

        // Redirect ke halaman detail untuk menambahkan item
        return redirect()->route('penjualan.show', $request->nopenjualan)
            ->with('success', 'Data penjualan berhasil dibuat. Silakan tambahkan detail barang.');
    }

    /**
     * Menampilkan detail penjualan beserta item-itemnya (menggantikan penjualandetail-lihat.php)
     */
    public function show(Penjualan $penjualan)
    {
        // Eager load relasi untuk efisiensi query
        $penjualan->load('pelanggan', 'detail.barangJadi');
        return view('penjualan.show', compact('penjualan'));
    }

    /**
     * Menampilkan form untuk mengedit data penjualan (menggantikan penjualan-ubah.php)
     */
    public function edit(Penjualan $penjualan)
    {
        $pelanggan = Pelanggan::all();
        return view('penjualan.edit', compact('penjualan', 'pelanggan'));
    }

    /**
     * Mengupdate data penjualan di database (menggantikan logika proses di penjualan-ubah.php)
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'idpelanggan' => 'required|string|exists:pelanggan,idpelanggan',
            'tanggal' => 'required|date',
            'garansi' => 'required|date',
        ]);

        $penjualan->update($request->only(['idpelanggan', 'tanggal', 'garansi']));

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil diubah.');
    }

    /**
     * Menghapus data penjualan beserta detailnya (menggantikan penjualan-hapus.php)
     */
    public function destroy(Penjualan $penjualan)
    {
        // Menggunakan transaksi untuk memastikan integritas data
        DB::transaction(function () use ($penjualan) {
            $penjualan->detail()->delete(); // Hapus semua detail terkait
            $penjualan->delete(); // Hapus penjualan utama
        });

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dihapus.');
    }

    /**
     * Menampilkan halaman cetak untuk penjualan (menggantikan penjualancetak.php)
     */
    public function cetak(Penjualan $penjualan)
    {
        $penjualan->load('pelanggan', 'detail.barangJadi', 'pelanggan.kendaraan');
        return view('penjualan.cetak', compact('penjualan'));
    }


    // --- FUNGSI UNTUK DETAIL PENJUALAN ---

    /**
     * Menambahkan item detail ke penjualan (menggantikan logika proses di penjualandetail-tambah.php)
     */
    public function storeDetail(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'kodejadi' => 'required|string|exists:barangjadi,kodejadi',
            'quantity' => 'required|integer|min:1',
        ]);

        $barangJadi = BarangJadi::find($request->kodejadi);
        $total = $barangJadi->harga * $request->quantity;

        $penjualan->detail()->create([
            'kodejadi' => $request->kodejadi,
            'quantity' => $request->quantity,
            'total' => $total,
        ]);

        // Hitung ulang total di tabel penjualan
        $penjualan->updateTotal();

        return redirect()->route('penjualan.show', $penjualan->nopenjualan)
            ->with('success', 'Item berhasil ditambahkan.');
    }

    /**
     * Menghapus item detail dari penjualan (menggantikan penjualandetail-hapus.php)
     */
    public function destroyDetail(Penjualan $penjualan, $kodejadi)
    {
        $penjualan->detail()->where('kodejadi', $kodejadi)->delete();

        // Hitung ulang total di tabel penjualan
        $penjualan->updateTotal();

        return redirect()->route('penjualan.show', $penjualan->nopenjualan)
            ->with('success', 'Item berhasil dihapus.');
    }
}
