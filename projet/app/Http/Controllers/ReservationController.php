<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the 'client' and 'ride' relationships
        $reservations = Reservation::with('client', 'ride')->get()->toArray();
        return array_reverse($reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'ride_id' => 'required|exists:rides,id',
        ]);

        $reservation = Reservation::create($request->all());

        return response()->json(['reservation' => $reservation, 'message' => 'Reservation created successfully'], 201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Eager load the 'client' and 'ride' relationships
        $reservation = Reservation::with('client', 'ride')->find($id);
        return response()->json($reservation);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        $reservation->update($request->all());
            return response()->json(['reservation' => $reservation, 'message' => 'reservation updated successfully'], 200);

    }

  
  public function destroy($id){
    $reservation = Reservation::findOrFail($id);
    $reservation->delete();

        return response()->json(['message' => 'Client deleted successfully'], 200);
    }
}
