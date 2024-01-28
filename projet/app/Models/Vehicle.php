<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['image', 'model', 'matricule', 'driver_id']; 
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

}
