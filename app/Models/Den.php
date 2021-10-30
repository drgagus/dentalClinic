<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Den extends Model
{
    public function dentaltreatments()
    {
        return $this->hasMany('App\Models\Dentaltrealment');
    }
    
    public function odontograms()
    {
        return $this->hasMany('App\Models\Odontogram');
    }
}
