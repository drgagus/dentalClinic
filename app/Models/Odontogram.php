<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Odontogram extends Model
{
    public function den()
    {
        return $this->belongsTo('App\Models\Den');
    }
}
