<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    Protected $fillable = ['nomorrekammedis', 'nama', 'nik', 'jeniskelamin', 'tempatlahir', 'tanggallahir', 'agama', 'pendidikan', 'pekerjaan', 'alamat', 'nomortelepon'];
    
    public function customer()
    {
        return $this->hasOne('App\Models\Customer');
    }
    
    public function medicalrecord()
    {
        return $this->hasOne('App\Models\Medicalrecord');
    }

    public function dentalrecords()
    {
        return $this->hasMany('Ápp\Models\Dentalrecord');
    }
}
