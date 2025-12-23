<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPenjualan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detailpenjualan'; // Nama tabel dengan dua 'l'

    /**
     * Eloquent tidak mendukung composite primary keys secara default.
     * Kita akan menangani operasi berdasarkan kedua kolom secara manual.
     */
    protected $primaryKey = null;
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nopenjualan',
        'kodejadi',
        'quantity',
        'total',
    ];

    /**
     * Get the main sale record.
     */
    public function penjualan(): BelongsTo
 {
 return $this->belongsTo(Penjualan::class, 'nopenjualan', 'nopenjualan');
    }

    /**
     * Get the product/service for the detail item.
     */
    public function barangJadi(): BelongsTo
 {
 return $this->belongsTo(BarangJadi::class, 'kodejadi', 'kodejadi');
    }
}
