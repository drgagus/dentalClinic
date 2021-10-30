<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    Protected $fillable = ['name', 'jabatan', 'username', 'password', 'admin', 'pendaftaran', 'pemeriksaan', 'dentist', 'apotek', 'kasir'];

    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }

    public function dentalrecords()
    {
        return $this->hasMany('Ápp\Models\Dentalrecord');
    }
    
    public function medicinerecords()
    {
        return $this->hasMany('Ápp\Models\Medicinerecord');
    }
    
}

