<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = Driver::all()->toArray();
        return array_reverse($drivers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $driver = new Driver([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'image' => $request->input('image'),
            'birth_date' => $request->input('birth_date'),
        ]);

        $driver->save();

        return response()->json($driver, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $driver = Driver::find($id);
        return response()->json($driver);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $driver = Driver::find($id);
        $driver->update($request->all());

        return response()->json($driver, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $driver = Driver::findOrFail($id);
            $driver->delete();
            return response()->json('Driver deleted successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'Foreign key constraint error. There are rides or vehicles associated with this driver.'], 500);
        }
    }
}
