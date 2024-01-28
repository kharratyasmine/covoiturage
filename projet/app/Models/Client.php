<?php
// app/Models/Client.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'birth_date']; 

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

