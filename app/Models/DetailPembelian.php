<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPembelian extends Model
{
    use HasFactory;

    protected $table = 'detailpembelian'; 

    // Composite key, harus diatasi di Controller
    protected $primaryKey = null; 
    public $incrementing = false;
    public $timestamps = false; // Karena tidak ada created_at/updated_at di tabel Anda

    protected $fillable = [
        'nopembelian',
        'kodebaku', // Bahan Baku
        'banyaknya', // Mirip Quantity di Penjualan
        'total',
    ];

    /**
     * Relasi ke header Pembelian.
     */
    public function pembelian(): BelongsTo
    {
        return $this->belongsTo(Pembelian::class, 'nopembelian', 'nopembelian');
    }

    /**
     * Relasi ke Bahan Baku.
     */
    public function bahanBaku(): BelongsTo
    {
        // Bahan baku memiliki PK 'kodebaku'
        return $this->belongsTo(BahanBaku::class, 'kodebaku', 'kodebaku');
    }
}