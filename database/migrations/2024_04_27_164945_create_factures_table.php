<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->string('NumFacture')->primary();
            $table->float('MontantHT');
            $table->date('DateFacture');
            $table->float('Taux');
            $table->float('TVA');
            $table->float('MontantTTC');
            $table->bigInteger('idEmetteur')->unsigned();
            //$table->bigInteger('idAvance')->unsigned();
            $table->string('TypeContrat');
            $table->string('EtabliPar');
            $table->string('EtaPayement');
            $table->string('ModeReg');
            $table->timestamps();
            
            $table->foreign('idEmetteur')->references('id')->on('emetteurs'); 
            //$table->foreign('idAvance')->references('id')->on('avances'); 
            $table->bigInteger('idClient')->unsigned();
            $table->foreign('idClient')->references('id')->on('clients');
    
            // Ajout des clés primaires des autres tables comme clés étrangères
            $table->string('NumBonLiv')->nullable();
            $table->foreign('NumBonLiv')->references('NumBonLiv')->on('bon_livraisons');
            $table->string('NumRemise')->nullable();
            $table->foreign('NumRemise')->references('NumRemise')->on('remises');
            $table->string('NumCheque')->nullable();
            $table->foreign('NumCheque')->references('NumCheque')->on('cheques');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
