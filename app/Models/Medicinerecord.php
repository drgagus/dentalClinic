<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicinerecord extends Model
{
    Protected $fillable = ['dentalrecord_id', 'medicine_id', 'jumlah', 'user_id', 'harga'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function medicine()
    {
        return $this->belongsTo('App\Models\Medicine');
    }

    public function dentalrecord()
    {
        return $this->belongsTo('App\Models\Dentalrecord');
    }
}
