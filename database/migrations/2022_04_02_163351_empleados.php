<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Empleados extends Migration
{

    public function up()
    {
      Schema::create('empleados', function (Blueprint $table) {
          $table->id();
          $table->string('codigo',200);
          $table->string('nombre',200);
          $table->string('apellidopaterno',100);
          $table->string('apellidomaterno',200);
          $table->string('correoelectronico',200);
          $table->string('tipocontrato',200);
          $table->enum('estado',['activo','inativo']);
          $table->timestamps();
          $table->softDeletes('deleted_at', 0);
      });
    }

    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
