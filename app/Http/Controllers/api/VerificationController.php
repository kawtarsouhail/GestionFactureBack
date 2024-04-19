<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Valeur;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    
    
    
    public function verifierValeur(Request $request)
    {
            // Récupérer l'ID à vérifier à partir de la demande
            $id = $request->input('id');

            // Recherchez l'enregistrement dans la base de données
            $valeurTrouvee = Valeur::find($id);

            // Vérifiez si l'enregistrement a été trouvé
            if ($valeurTrouvee) {
                return response()->json(['message' => 'L\'enregistrement a été trouvé dans la base de données.'], 200);
            } else {
                return response()->json(['message' => 'L\'enregistrement n\'a pas été trouvé dans la base de données.'], 404);
            }
    }
    
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Valeur $valeur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Valeur $valeur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Valeur $valeur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Valeur $valeur)
    {
        //
    }
}
