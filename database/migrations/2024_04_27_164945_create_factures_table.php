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
            $table->id();
            $table->string('NumFacture');
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
            $table->foreign('idEmetteur')->references('id')->on('emetteurs'); 
            //$table->foreign('idAvance')->references('id')->on('avances'); 
            $table->bigInteger('idClient')->unsigned();
            $table->bigInteger('idBonLiv')->unsigned();
            $table->unsignedBigInteger('idRemise')->nullable();
            $table->unsignedBigInteger('idCheque')->nullable();


            $table->foreign('idClient')->references('id')->on('clients');
            $table->foreign('idBonLiv')->references('id')->on('bon_livraisons');
            $table->foreign('idRemise')->references('id')->on('remises');
            $table->foreign('idCheque')->references('id')->on('cheques');

            $table->timestamps();

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
