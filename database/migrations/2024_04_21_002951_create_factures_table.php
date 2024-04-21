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
            $table->date('DateFacture')->format('m/d/y');
            $table->float('Taux');
            $table->float('TVA');
            $table->float('MontantTTC');
            $table->bigInteger('idEmetteur')->unsigned();
            $table->string('TypeContrat');
            $table->string('EtabliPar');
            $table->string('EtaPayement');
            $table->string('ModeReg');
            $table->timestamps();
            $table->foreign('idEmetteur')->references('id')->on('emetteurs'); 
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
