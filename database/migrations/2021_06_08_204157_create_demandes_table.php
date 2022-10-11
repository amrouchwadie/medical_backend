<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id('id_demande');
            $table->String('description');
            $table->String('demande_image');
            $table->String('status')->default('Pending');
            $table->String('message_refuse')->nullable();
            $table->unsignedBigInteger('id_client')->nullable();
            $table->foreign('id_client')->references('id_client')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('id_livreur')->nullable();
            $table->foreign('id_livreur')->references('id_livreur')->on('livreurs')->onDelete('cascade');
            $table->unsignedBigInteger('id_pharmacie')->nullable();
            $table->foreign('id_pharmacie')->references('id_pharmacie')->on('pharmacies')->onDelete('cascade');
            $table->timestamps();
            // ?message_refuse status id_livreur
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demandes');
    }
}
