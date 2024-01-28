<?php

// app/Models/Driver.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'image', 'birth_date']; 
    
    public function rides()
    {
        return $this->hasMany(Ride::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}

