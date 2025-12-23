<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;
use App\Models\BarangJadi;
use App\Models\Penjualan;
use App\Models\BahanBaku; // Import model BahanBaku

class PageController extends Controller
{
    /**
     * Menampilkan halaman utama atau landing page.
     */
    public function index()
    {
        // Mengembalikan view 'index.blade.php'
        return view('index');
    }

    /**
     * Menampilkan halaman login.
     */
    public function login()
    {
        // Di sini Anda akan mengembalikan view untuk form login.
        return view('login');
    }

    /**
     * Menampilkan halaman home/dashboard setelah login.
     */
    public function home()
    {
        // Ambil data statistik
        $jumlahPelanggan = Pelanggan::count();
        $jumlahBarang = BarangJadi::count();
        $jumlahPenjualan = Penjualan::count();

        // Ambil filter dari request
        $filter = request('filter');
        $query = Penjualan::query();

        if ($filter == "hari") {
            $query->whereDate('tanggal', today());
        } elseif ($filter == "bulan") {
            $query->whereMonth('tanggal', today()->month)->whereYear('tanggal', today()->year);
        } elseif ($filter == "tahun") {
            $query->whereYear('tanggal', today()->year);
        }

        $totalPemasukan = $query->sum('jumlahrp');

        // Kirim semua data ke view 'home'
        return view('home', [
            'jumlahPelanggan' => $jumlahPelanggan,
            'jumlahBarang' => $jumlahBarang,
            'jumlahPenjualan' => $jumlahPenjualan,
            'totalPemasukan' => $totalPemasukan,
            'currentFilter' => $filter,
        ]);
    }
}