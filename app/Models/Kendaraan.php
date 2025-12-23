<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kendaraan extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'kendaraan';

    // Primary key tabel
    protected $primaryKey = 'nopol';

    // Tipe data primary key
    protected $keyType = 'string';

    // Menonaktifkan auto-incrementing untuk primary key
    public $incrementing = false;

    // Mengaktifkan timestamps (created_at, updated_at)
    public $timestamps = true;

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'nopol',
        'tipe',
        'idpelanggan',
    ];

    /**
     * Mendefinisikan relasi bahwa Kendaraan ini dimiliki oleh satu Pelanggan.
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'idpelanggan', 'idpelanggan');
    }
}