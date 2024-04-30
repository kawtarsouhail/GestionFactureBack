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
        'NumFacture' => 'required|string|unique:factures',
        'MontantHT' => 'required|numeric',
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
        'NumBonLiv' => 'required|string|unique:bon_livraisons',
        'dateBonLiv' => 'required|date',
        'TypeValidation' => 'required|string',
        'NumRemise' => 'nullable|string|unique:remises',
        'MontantEnc' => 'nullable|numeric',
        'NumCheque' => 'nullable|string|unique:cheques'
    ]);

    DB::beginTransaction();

    try {
        $emetteur = Emetteur::create(['NomEmetteur' => $validatedData['NomEmetteur']]);

        $client = Client::create(['NomClient' => $validatedData['NomClient']]);

        $bonLivraison = BonLivraison::create([
            'NumBonLiv' => $validatedData['NumBonLiv'],
            'idClient' => $client->id,
            'dateBonLiv' => $validatedData['dateBonLiv'],
            'TypeValidation' => $validatedData['TypeValidation']
        ]);
        $idBonLivraison = $bonLivraison->id;
        $remise = null;
        $cheque = null;

        if (!empty($validatedData['NumRemise']) && !empty($validatedData['MontantEnc'])) {
            $remise = Remise::create([
                'NumRemise' => $validatedData['NumRemise'],
                'MontantEnc' => $validatedData['MontantEnc'],
            ]);
        }

        if (!empty($validatedData['NumCheque']) && $remise) {
            $cheque = Cheque::create([
                'NumCheque' => $validatedData['NumCheque'],
                'idRemise' => $remise->id,
            ]);
        }

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
            'idBonLiv' => $idBonLivraison, // Utilisez l'ID du bon de livraison
            'idRemise' => $remise ? $remise->id : null,
            'idCheque' => $cheque ? $cheque->id : null,
        ]);

        DB::commit();
        return response()->json(['message' => 'Facture enregistrée avec succès'], 201);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'Erreur lors de l\'enregistrement de la facture', 'error' => $e->getMessage()], 500);
    }
}




        public function getDonnees()
        {
            $donnees = Facture::with([
                'Emetteur:id,NomEmetteur', 
                'Client:id,NomClient', 
                'Remise:id,NumRemise,MontantEnc', 
                'BonLivraison:id,NumBonLiv,dateBonLiv,TypeValidation',
                'Cheque:id,NumCheque',
            ])->get([
                'id','NumFacture', 'MontantHT', 'DateFacture', 'Taux', 'TVA', 'MontantTTC', 
                'TypeContrat', 'EtabliPar', 'EtaPayement', 'ModeReg', 
                'idClient', 'idEmetteur', 'idBonLiv', 'idCheque', 'idRemise'
            ]);


            return response()->json(['donnees' => $donnees], 200);
        }
        

        public function update(Request $request, $id)
        {
            $facture = Facture::findOrFail($id); // Trouver la facture par ID, ou échouer si non trouvée
        
            // Validation des données entrantes
            $validatedData = $request->validate([
                'NumFacture' => 'required|string|unique:factures,NumFacture,' . $id,
                'MontantHT' => 'required|numeric',
                'DateFacture' => 'required|date',
                'Taux' => 'required|numeric',
                'TVA' => 'required|numeric',
                'MontantTTC' => 'required|numeric',
                'TypeContrat' => 'required|string',
                'EtabliPar' => 'required|string',
                'EtaPayement' => 'required|string',
                'ModeReg' => 'required|string',
                // Assurez-vous de valider les autres champs importants
            ]);
        
            // Mise à jour de la facture avec les données validées
            $facture->update($validatedData);
        
            return response()->json(['message' => 'Facture mise à jour avec succès'], 200);
        }
        public function delete($id)
        {
            $facture = Facture::findOrFail($id); // Trouver la facture par son ID
            
            $facture->delete(); // Supprimer la facture
        
            return response()->json(['message' => 'Facture supprimée avec succès'], 200);
        }

      

}    

