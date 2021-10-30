<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dentalrecord extends Model
{
    Protected $fillable = ['patient_id', 'tanggalkunjungan', 'usiatahun', 'usiabulan', 'usiahari', 'keluhanutama', 'tinggibadan', 'beratbadan', 'tekanandarah', 'pernafasan', 'detakjantung', 'suhutubuh', 'pemeriksaansubjektif', 'pemeriksaanobjektif', 'diagnosa', 'informedconsent', 'pengobatan', 'user_id']; 

    public function diag()
    {
        return $this->belongsTo('App\Models\Diag');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }
   
    public function dentaltreatments()
    {
        return $this->hasMany('App\Models\Dentaltreatment');
    }
    
    public function medicinerecords()
    {
        return $this->hasMany('App\Models\Medicinerecord');
    }
}

