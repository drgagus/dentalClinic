<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    Protected $fillable = ['patient_id', 'usia', 'tanggalkunjungan', 'keluhanutama', 'tinggibadan', 'beratbdan', 'tekanandarah', 'pernafasan', 'detakjantung', 'suhutubuh', 'selesai', 'user_id']; 
    
    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
