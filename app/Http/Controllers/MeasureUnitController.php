<?php

namespace App\Http\Controllers;

use App\Models\MeasureUnit;
use Illuminate\Http\Request;

class MeasureUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $measureUnits = MeasureUnit::all();
        return view('content.measure-units.index', compact('measureUnits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.measure-units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:measure_units,name',
            'short_name' => 'required|unique:measure_units,short_name|max:10',
        ]);

        MeasureUnit::create($request->all());

        return redirect()->route('measure-units.index')
            ->with('success', 'Measure Unit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MeasureUnit $measureUnit)
    {
        return view('content.measure-units.show', compact('measureUnit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MeasureUnit $measureUnit)
    {
        return view('content.measure-units.edit', compact('measureUnit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MeasureUnit $measureUnit)
    {
        $request->validate([
            'name' => 'required|unique:measure_units,name,' . $measureUnit->id,
            'short_name' => 'required|unique:measure_units,short_name,' . $measureUnit->id . '|max:10',
        ]);

        $measureUnit->update($request->all());

        return redirect()->route('measure-units.index')
            ->with('success', 'Measure Unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MeasureUnit $measureUnit)
    {
        $measureUnit->delete();

        return redirect()->route('measure-units.index')
            ->with('success', 'Measure Unit deleted successfully.');
    }
}
