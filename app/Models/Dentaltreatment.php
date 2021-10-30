<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dentaltreatment extends Model
{
    Protected $fillable = ['dentalrecord_id', 'gigi', 'diag_id', 'imagebefore', 'imageafter', 'tindakan', 'cost_id', 'harga'];

    public function dentalrecord()
    {
        return $this->belongsTo('App\Models\Dentalrecord');
    }
    
    public function den()
    {
        return $this->belongsTo('App\Models\Den');
    }
    
    public function cost()
    {
        return $this->belongsTo('App\Models\Cost');
    }
    
    public function diag()
    {
        return $this->belongsTo('App\Models\Diag');
    }
}






