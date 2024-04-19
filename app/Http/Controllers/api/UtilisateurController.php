<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = Utilisateur::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.'], 401);
    }

    // L'authentification réussie
    return response()->json(['message' => 'Connexion réussie.'], 200);
}

    
    

}

