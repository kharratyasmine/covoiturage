<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{

  public function index(){$vehicles = Vehicle::with('driver')->get();
      return $vehicles;}



public function store(Request $request)
{
    $request->validate([
        'driver_id' => 'required|exists:drivers,id',
        'image' => 'required',
        'model' => 'required',
        'matricule' => 'required',
    ]);

    try {
        $vehicle = Vehicle::create($request->all());
        return response()->json(['vehicle' => $vehicle, 'message' => 'Vehicle created successfully'], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error creating vehicle. ' . $e->getMessage()], 500);
    }
}


 
  public function update(Request $request, $id){
      try {$vehicle = Vehicle::find($id);$vehicle->update($request->all());
          return response()->json(['vehicle' => $vehicle, 'message' => 'Vehicle updated successfully'], 200);} catch (\Exception $e) {
          return response()->json(['error' => 'Error updating vehicle. ' . $e->getMessage()], 500);}}
 

          
  public function destroy($id){
      try {$vehicle = Vehicle::findOrFail($id);$vehicle->delete();
          return response()->json(['message' => 'Vehicle deleted successfully'], 200);} catch (\Exception $e) {
          return response()->json(['error' => 'Error deleting vehicle. ' . $e->getMessage()], 500);}}
}