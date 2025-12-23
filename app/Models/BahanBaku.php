<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'kodebaku'; 

    protected $table = 'bahanbaku';
    
    protected $fillable = [
        'kodebaku', 'jenis', 'satuan', 'harga'
    ];
}