<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('currency')->default('');
            $table->string('commission')->default('');
            $table->string('commissionnone')->default('');
            $table->timestamps();
        });


        DB::table('settings')->insert([
            [
                'currency' => 'руб. ',
                'commission' => 10,
                'commissionnone' => 14,

            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
