<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangJadi extends Model
{
    // Menonaktifkan incrementing jika kodejadi adalah primary key non-integer
    public $incrementing = false;
    // Tipe data primary key
    protected $keyType = 'string';
    // Menetapkan nama primary key
    protected $primaryKey = 'kodejadi'; 

    protected $table = 'barangjadi';
    
    // Sesuaikan fillable/guarded sesuai kolom di tabel Anda
    protected $fillable = [
        'kodejadi', 'barangataulayanan', 'harga', 'satuan'
    ];

    /**
     * Relasi One-to-Many ke DetailBarang
     */
    public function detailBarang()
    {
        // 'kodejadi' adalah foreign key di tabel 'detailbarang'
        return $this->hasMany(DetailBarang::class, 'kodejadi', 'kodejadi');
    }
}