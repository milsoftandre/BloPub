<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinEmpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->smallInteger('typeuser')->default(0);
            $table->string('lname')->default('');
            $table->string('dir')->default('');
            $table->string('inn')->default('');
            $table->string('ogrn')->default('');
            $table->string('uadres')->default('');
            $table->string('rs')->default('');
            $table->string('bname')->default('');
            $table->string('badres')->default('');
            $table->string('bkor')->default('');
            $table->string('bic')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->smallInteger('typeuser')->default(0);
            $table->string('lname')->default('');
            $table->string('dir')->default('');
            $table->string('inn')->default('');
            $table->string('ogrn')->default('');
            $table->string('uadres')->default('');
            $table->string('rs')->default('');
            $table->string('bname')->default('');
            $table->string('badres')->default('');
            $table->string('bkor')->default('');
            $table->string('bic')->default('');
        });
    }
}
