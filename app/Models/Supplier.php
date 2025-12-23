<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    
    protected $table = 'supplier';
    
    protected $primaryKey = 'idsupplier';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idsupplier', 
        'nama', 
        'alamat', 
        'telp', 
        'pic', 
        'telppic'
    ];
    
    /**
     * Relasi One-to-Many ke Pembelian
     */
    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'idsupplier', 'idsupplier');
    }
}