<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    Protected $fillable = ['tindakan', 'harga', 'diskon'];

    public function dentaltreatments()
    {
        return $this->hasMany('App\Models\Dentaltreatment');
    }
}
