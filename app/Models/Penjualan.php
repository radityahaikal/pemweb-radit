<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    // Tambahkan nama tabel jika tidak mengikuti konvensi jamak ('penjualans')
    protected $table = 'penjualan'; 

    // Tentukan primary key jika bukan 'id'
    protected $primaryKey = 'nopenjualan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nopenjualan', 
        'idpelanggan', 
        'tanggal', 
        'garansi', 
        'jumlahrp'
    ];
    
    // --- Definisikan Relasi ---

    /**
     * Relasi ke model Pelanggan (Penjualan dimiliki oleh Pelanggan)
     */
    public function pelanggan()
    {
        // Asumsi: 
        // 1. Model Pelanggan ada di App\Models\Pelanggan
        // 2. Foreign key di tabel penjualan adalah 'idpelanggan'
        // 3. Local key di tabel pelanggan adalah 'idpelanggan'
        return $this->belongsTo(Pelanggan::class, 'idpelanggan', 'idpelanggan');
    }
    
    /**
     * Relasi ke model DetailPenjualan
     */
    public function detail()
    {
        // Asumsi:
        // 1. Model DetailPenjualan ada di App\Models\DetailPenjualan
        // 2. Foreign key di tabel detailpenjualan adalah 'nopenjualan'
        return $this->hasMany(DetailPenjualan::class, 'nopenjualan', 'nopenjualan');
    }
    
    // ... Tambahkan fungsi updateTotal() jika Anda menggunakannya di Controller
    public function updateTotal()
    {
         $newTotal = $this->detail()->sum('total');
         $this->update(['jumlahrp' => $newTotal]);
    }
    public function kendaraan()
    {
        // Asumsi:
        return $this->belongsTo(Kendaraan::class, 'nopol', 'nopol');
    }
}   