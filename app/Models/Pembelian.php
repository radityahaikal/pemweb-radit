<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian'; 

    protected $primaryKey = 'nopembelian';
    public $incrementing = false;
    protected $keyType = 'string';

    // Kolom dari tabel pembelian
    protected $fillable = [
        'nopembelian', 
        'idsupplier', 
        'idpegawai', 
        'tanggal', 
        'subtotal'
    ];
    
    // --- Definisikan Relasi ---

    /**
     * Relasi ke model Supplier (Pembelian dimiliki oleh Supplier)
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'idsupplier', 'idsupplier');
    }

    /**
     * Relasi ke model Pegawai (Pembelian dilakukan oleh Pegawai)
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'idpegawai', 'idpegawai');
    }
    
    /**
     * Relasi ke model DetailPembelian
     */
    public function detail()
    {
        // Foreign key di tabel detailpembelian adalah 'nopembelian'
        return $this->hasMany(DetailPembelian::class, 'nopembelian', 'nopembelian');
    }
    
    /**
     * Fungsi untuk menghitung ulang dan memperbarui total pembelian
     */
    public function updateSubtotal()
    {
         $newTotal = $this->detail()->sum('total');
         // Perhatikan: kolom di tabel pembelian adalah 'subtotal'
         $this->update(['subtotal' => $newTotal]); 
    }
}