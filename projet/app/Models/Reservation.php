<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['client_id', 'ride_id']; 

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }
}
