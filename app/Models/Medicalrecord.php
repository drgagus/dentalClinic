<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicalrecord extends Model
{
    Protected $fillable = ['patient_id', 'alergi', 'last', 'now'];

    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }
}
