<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIpsEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('apiips')->default('');
            $table->bigInteger('partner_id')->default(0);
            $table->float('prec')->default(0);
            $table->string('promo')->default('');
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
            $table->string('apiips')->default('');
            $table->bigInteger('partner_id')->default(0);
            $table->float('prec')->default(0);
            $table->string('promo')->default('');
        });
    }
}
