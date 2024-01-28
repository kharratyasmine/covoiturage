<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use Illuminate\Http\Request;

class RideController extends Controller
{
    public function index()
    {
        
        $rides = Ride::with('driver')->get()->toArray();
        return array_reverse($rides);
    }
   
    public function store(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'pickup_location' => 'required',
            'dropoff_location' => 'required',
            'date' => 'required|date',
            'cost' => 'required|numeric',
            'place_available' => 'required|numeric',
        ]);

        $ride = Ride::create($request->all());

        return response()->json(['ride' => $ride, 'message' => 'Ride created successfully'], 201);
    }

    
    public function show($id)
    {
        
        $ride = Ride::with('driver')->find($id);
        return response()->json($ride);
    }

    
    public function update(Request $request, $id)
    {
        $ride = Ride::find($id);
        $ride->update($request->all());

        return response()->json(['ride' => $ride, 'message' => 'Ride updated successfully'], 200);
    }

   
    public function destroy($id)
    {
        $ride = Ride::findOrFail($id);
        $ride->delete();

        return response()->json(['message' => 'Ride deleted successfully']);
    }
}