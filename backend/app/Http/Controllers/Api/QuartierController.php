<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quartier;
use Illuminate\Http\Request;

class QuartierController extends Controller
{
    public function index()
    {
        return Quartier::orderBy('id_quart')->get();
    }

    public function store(Request $request)
    {
        return response()->json(Quartier::create($request->validate(['nom_quart' => 'required|string|max:100', 'description' => 'nullable|string'])), 201);
    }

    public function update(Request $request, Quartier $quartier)
    {
        $quartier->update($request->validate(['nom_quart' => 'required|string|max:100', 'description' => 'nullable|string']));
        return $quartier;
    }

    public function destroy(Quartier $quartier)
    {
        $quartier->delete();
        return response()->noContent();
    }
}