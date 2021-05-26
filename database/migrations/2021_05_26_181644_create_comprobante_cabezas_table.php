<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobanteCabezasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante_cabezas', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('codigoComprobante');
            $table->enum('tipoOperacion', ['compra', 'venta']);
            $table->dateTime('fecha');
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comprobante_cabezas');
    }
}
