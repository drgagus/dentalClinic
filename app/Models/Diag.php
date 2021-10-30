<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diag extends Model
{
    Protected $fillable = ['diagnosa'];

    public function dentalrecords()
    {
        return $this->hasMany('Ápp\Models\Dentalrecord');
    }
    
    public function dentaltreatments()
    {
        return $this->hasMany('App\Models\Dentaltreatment');
    }
}
