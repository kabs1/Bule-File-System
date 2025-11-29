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
                'name' => $c->currency_name,
                'symbol' => $c->currency_symbol ?? '',
               
                // 'is_default' => ($c->is_default ?? false) ? 'Yes' : 'No',
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
        $data = $request->validate([
            'name' => 'required|unique:currencies,currency_name',
            'symbol' => 'required|string|max:5',
            // 'is_default' => 'nullable|boolean',
        ]);

        $currency = Currency::create([
            'currency_name' => $data['name'],
            'currency_symbol' => $data['symbol'],
            // 'is_default' => $data['is_default'] ?? false,
            'user_id' => auth()->id(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Currency created successfully.', 'id' => $currency->id]);
        }
        return redirect()->route('currencies.index')->with('success', 'Currency created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Currency $currency)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'id' => $currency->id,
                'name' => $currency->currency_name,
                'symbol' => $currency->currency_symbol ?? '',
                // 'is_default' => (bool) $currency->is_default,
            ]);
        }
        return view('content.currencies.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Currency $currency)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'id' => $currency->id,
                'name' => $currency->currency_name,
                'symbol' => $currency->currency_symbol ?? '',
                // 'is_default' => (bool) $currency->is_default,
            ]);
        }
        return view('content.currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        $data = $request->validate([
            'name' => 'required|unique:currencies,currency_name,' . $currency->id,
            'symbol' => 'required|string|max:5',
            // 'is_default' => 'nullable|boolean',
        ]);

        $currency->update([
            'currency_name' => $data['name'],
            'currency_symbol' => $data['symbol'],
            // 'is_default' => $data['is_default'] ?? false,
            'user_id' => auth()->id(),
        ]);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Currency updated successfully.']);
        }
        return redirect()->route('currencies.index')->with('success', 'Currency updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Currency $currency)
    {
        $currency->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Currency deleted successfully.']);
        }
        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully.');
    }
}
