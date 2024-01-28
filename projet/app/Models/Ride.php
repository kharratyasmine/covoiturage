<?php

// app/Models/Ride.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    protected $fillable = ['driver_id',  'pickup_location', 'dropoff_location', 'date', 'cost','place_available']; // Add other ride-related fields as needed

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
