<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use App\Models\Schedules;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedules::orderBy('id')->get();
        $locations = Locations::orderBy('name')->get();
        return view('pages.schedules.index', compact('schedules', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pickup_id' => 'required',
            'arrival_time' => 'required',
            'destination_id' => 'required',
            'departure_time' => 'required',
            'description' => 'required',
            'available_seats' => 'required',
            'price' => 'required'
        ]);

        Schedules::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'pickup_id' => $request->pickup_id,
                'arrival_time' => $request->arrival_time,
                'destination_id' => $request->destination_id,
                'departure_time' => $request->departure_time,
                'description' => $request->description,
                'available_seats' => $request->available_seats, 
                'price' => $request->price
            ]
        );

        if ($request->id) {
            return redirect()->route('schedules.index')->with('success', 'Success Update Schedule!');
        } else {
            return redirect()->back()->with('success', 'Success Add Category!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Schedules::find($id)->delete();
        return redirect()->back()->with('success', 'Success Delete Schedule!');
    }
}
