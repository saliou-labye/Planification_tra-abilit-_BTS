<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index()
    {
        return Vehicule::orderBy('id_vehicu')->get();
    }

    public function store(Request $request)
    {
        return response()->json(Vehicule::create($request->validate(['immatriculation' => 'required|string|max:20|unique:vehicule,immatriculation', 'type_vehicule' => 'required|string|max:50'])), 201);
    }

    public function update(Request $request, Vehicule $vehicule)
    {
        $vehicule->update($request->validate(['immatriculation' => 'sometimes|string|max:20|unique:vehicule,immatriculation,'.$vehicule->id_vehicu.',id_vehicu', 'type_vehicule' => 'sometimes|string|max:50']));
        return $vehicule;
    }

    public function destroy(Vehicule $vehicule)
    {
        $vehicule->delete();
        return response()->noContent();
    }
}