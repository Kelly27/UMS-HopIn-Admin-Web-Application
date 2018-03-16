<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = ['bus_number', 'plate_no', 'year_manufactured', 'bus_location'];

    public function routes(){
        return $this->belongsTo('App\Route');
    }

    public function drivers(){
        return $this->belongsTo('App\Driver');
    }
}
