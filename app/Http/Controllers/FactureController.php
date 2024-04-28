<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; 

use App\Models\BonLivraison;
use App\Models\Cheque;
use App\Models\Client;
use App\Models\Emetteur;
use App\Models\Facture;
use App\Models\Remise;

use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'NumFacture' => 'required|string',
            'MontantHT' => 'required|string',
            'DateFacture' => 'required|date',
            'Taux' => 'required|numeric',
            'TVA' => 'required|numeric',
            'MontantTTC' => 'required|numeric',
            'TypeContrat' => 'required|string',
            'EtabliPar' => 'required|string',
            'EtaPayement' => 'required|string',
            'ModeReg' => 'required|string',
            'NomEmetteur' => 'required|string',
            'NomClient' => 'required|string',
            'NumBonLiv' => 'required|string',
            'dateBonLiv' => 'required|date',
            'TypeValidation' => 'required|string',
            'NumRemise' => 'nullable|string',
            'MontantEnc' => 'nullable|numeric',
            'NumCheque' => 'nullable|string'
        ]);
    
        DB::beginTransaction();
    
        try {
            // Create Emetteur and Client...
            $emetteur = Emetteur::create(['NomEmetteur' => $validatedData['NomEmetteur']]);
            $client = Client::create(['NomClient' => $validatedData['NomClient']]);
            $bonLivraison = BonLivraison::create([
                'NumBonLiv' => $validatedData['NumBonLiv'],
                'idClient' => $client->id,
                'dateBonLiv' => $validatedData['dateBonLiv'],
                'TypeValidation' => $validatedData['TypeValidation']
            ]);
    
            $numRemise = null;
            $NumCheque = null;
    
                        // Conditional creation of Remise
            if (!empty($validatedData['NumRemise']) && !empty($validatedData['MontantEnc'])) {
                $remise = Remise::create([
                    'NumRemise' => $validatedData['NumRemise'],
                    'MontantEnc' => $validatedData['MontantEnc'],
                ]);
                $numRemise = $remise->NumRemise;
            } else {
                $numRemise = null;
            }
            $numRemise = $validatedData['NumRemise'];

            // Conditional creation of Cheque
            if (!empty($validatedData['NumCheque']) && $numRemise) {
                $cheque = Cheque::create([
                    'NumCheque' => $validatedData['NumCheque'],
                    'NumRemise' => $numRemise,
                ]);
                $NumCheque = $cheque->NumCheque;
            } else {
                $NumCheque = null;
            }
            $NumCheque = $validatedData['NumCheque'];
    
            // Create Facture
            $facture = Facture::create([
                'NumFacture' => $validatedData['NumFacture'],
                'MontantHT' => $validatedData['MontantHT'],
                'DateFacture' => $validatedData['DateFacture'],
                'Taux' => $validatedData['Taux'],
                'TVA' => $validatedData['TVA'],
                'MontantTTC' => $validatedData['MontantTTC'],
                'idEmetteur' => $emetteur->id,
                'idClient' => $client->id,
                'TypeContrat' => $validatedData['TypeContrat'],
                'EtabliPar' => $validatedData['EtabliPar'],
                'EtaPayement' => $validatedData['EtaPayement'],
                'ModeReg' => $validatedData['ModeReg'],
                'NumRemise' => $numRemise,
                'NumBonLiv' => $validatedData['NumBonLiv'],
                'NumCheque' => $NumCheque,
            ]);
    
            DB::commit();
            return response()->json(['message' => 'Facture enregistrée avec succès'], 201);
        } catch (\Exception $e) {
    // En cas d'erreur, annuler la transaction
    DB::rollback();
    // Retourner une réponse avec l'erreur
    return response()->json(['message' => 'Erreur lors de l\'enregistrement de la facture', 'error' => $e->getMessage()], 500);
}
}


        public function getDonnees()
        {
            $donnees = Facture::with([
                'Emetteur:id,NomEmetteur', 
                'Client:id,NomClient', 
                'Remise:NumRemise,MontantEnc', 
                'BonLivraison:NumBonLiv,dateBonLiv,TypeValidation'
            ])->get([
                'NumFacture', 'MontantHT', 'DateFacture', 'Taux', 'TVA', 'MontantTTC', 
                'TypeContrat', 'EtabliPar', 'EtaPayement', 'ModeReg', 
                'idClient', 'idEmetteur', 'NumBonLiv', 'NumCheque', 'NumRemise'
            ]);

            logger()->info("Retrieved data: " . json_encode($donnees));

            return response()->json(['donnees' => $donnees], 200);
        }



}    

