<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBarang extends Model
{
    // 1. Menonaktifkan timestamps untuk menghilangkan error 'updated_at'
    public $timestamps = false; 

    // 2. Karena ini adalah composite key, kita nonaktifkan incrementing
    public $incrementing = false; 
    
    // 3. Set primaryKey ke kolom dummy (atau salah satu kolom key Anda)
    // Ini diperlukan agar Eloquent tidak mencari 'id'
    protected $primaryKey = ['kodejadi', 'kodebaku']; // Kita akan menggunakan kodejadi dan kodebaku di controller

    protected $table = 'detailbarang';
    
    protected $fillable = [
        'kodejadi', 'kodebaku', 'ukuran'
    ];
    
    // Non-default primary key handling (ini tidak wajib, tapi membantu jika Anda punya id kolom)
    // Jika tidak ada kolom 'id', pastikan operasi insert/update berjalan manual atau via pivot.

    /**
     * Relasi Many-to-One ke BarangJadi
     */
    public function barangJadi()
    {
        return $this->belongsTo(BarangJadi::class, 'kodejadi', 'kodejadi');
    }

    /**
     * Relasi Many-to-One ke BahanBaku
     */
    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'kodebaku', 'kodebaku');
    }

    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->originalData)) {
            return $this->originalData[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}