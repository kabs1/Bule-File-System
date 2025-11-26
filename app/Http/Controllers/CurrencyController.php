<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::all();
        return view('content.currencies.index', compact('currencies'));
    }

    public function list(Request $request)
    {
        $currencies = Currency::all();
        $data = $currencies->map(function ($c) {
            return [
                'id' => $c->id,
                'name' => $c->name,
                'code' => $c->code,
                'symbol' => $c->symbol,
                'exchange_rate' => $c->exchange_rate,
                'is_default' => $c->is_default ? 'Yes' : 'No',
                'actions' => ''
            ];
        });
        return response()->json(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:currencies,name',
            'code' => 'required|unique:currencies,code|max:3',
            'symbol' => 'required|max:5',
            'exchange_rate' => 'required|numeric',
            'is_default' => 'boolean',
        ]);

        $currency = Currency::create($request->all());

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Currency created successfully.', 'id' => $currency->id]);
        }
        return redirect()->route('currencies.index')->with('success', 'Currency created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        return view('content.currencies.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency)
    {
        return view('content.currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'name' => 'required|unique:currencies,name,' . $currency->id,
            'code' => 'required|unique:currencies,code,' . $currency->id . '|max:3',
            'symbol' => 'required|max:5',
            'exchange_rate' => 'required|numeric',
            'is_default' => 'boolean',
        ]);

        $currency->update($request->all());
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Currency updated successfully.']);
        }
        return redirect()->route('currencies.index')->with('success', 'Currency updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Currency deleted successfully.']);
        }
        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully.');
    }
}
