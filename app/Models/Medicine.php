<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    Protected $fillable = ['obat', 'jumlah', 'harga', 'aktif']; 
    
    public function medicinerecords()
    {
        return $this->hasMany('App\Models\Medicinerecord');
    }
}
