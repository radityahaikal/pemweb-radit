<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'pelanggan';

    // Primary key tabel
    protected $primaryKey = 'idpelanggan';

    // Tipe data primary key
    protected $keyType = 'string';

    // Menonaktifkan auto-incrementing untuk primary key
    public $incrementing = false;

    // Menonaktifkan timestamps (created_at, updated_at)
    public $timestamps = true;

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'idpelanggan',
        'namapelanggan',
        'jenispelanggan',
        'notelp',
    ];

    /**
     * Relasi ke model Kendaraan (Satu pelanggan memiliki satu kendaraan)
     */
    public function kendaraan()
    {
        // Asumsi: Model Kendaraan ada di App\Models\Kendaraan
        // Asumsi: Foreign key di tabel 'kendaraan' adalah 'idpelanggan'
        return $this->hasOne(Kendaraan::class, 'idpelanggan', 'idpelanggan');
    }
    
    /**
     * Relasi ke model Penjualan (Satu pelanggan bisa memiliki banyak penjualan)
     */
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'idpelanggan', 'idpelanggan');
    }
}