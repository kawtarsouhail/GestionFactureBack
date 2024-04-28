<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $primaryKey = 'NumFacture';

    protected $fillable = [
        'NumFacture',
        'MontantHT',
        'DateFacture',
        'Taux',
        'TVA',
        'MontantTTC',
        'idEmetteur',
        'idClient',
        'TypeContrat',
        'EtabliPar',
        'EtaPayement',
        'ModeReg',
        'NumBonLiv',
        'NumRemise',
        'NumCheque',
    ];

    public function Emetteur()
    {
        return $this->belongsTo('App\Models\Emetteur', 'idEmetteur');
    }

    public function Client()
    {
        return $this->belongsTo('App\Models\Client', 'idClient');
    }

    public function bonLivraison()
    {
        return $this->hasOne(BonLivraison::class, 'NumBonLiv');
    }

    public function remise()
    {
        return $this->hasOne(Remise::class, 'NumRemise');
    }
    public function Cheque()
    {
        return $this->belongsTo('App\Models\Cheque', 'NumCheque');
    }
    
}
